<?php
/*
 * pdo_mysql 驱动
 *
 * @copyright			(C) 2016 HeartPHP
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart\libs\db\driver;

use heart\libs\db\db_interface;
use PDO as PDO;
use heart\libs\log\log;

class pdo_mysql implements db_interface{

    //配置文件
	private $conf;

    //最后一次执行的SQL语句
	protected $last_query_sql = null;

    //最后一次请求句柄
	protected $last_query = null;

	public function __construct( &$conf ) {
		$this->conf = &$conf;
	}

	public function __get($var) {
		switch($var) {
            //master
			case 'mlink':
				return $this->mlink = $this->master_connect();
                break;
            //slave
            case 'slink':
                return $this->slink = $this->slave_connect();
                break;
			default:
		}
	}

	/*
	 * master
	 * 多个master待续 ^_^
	 * */
	private function master_connect() {

        return $this->connected(
			$this->conf['host'],
			$this->conf['port'],
			$this->conf['db_name'],
			$this->conf['user'],
			$this->conf['password'],
			$this->conf['charset']
		);
	}

    /*
     * slave连接数据库
     * 连接多个slave时 检查当前的MYSQL连接状态是否可用,如果不可用直接剔除,只保留可用状态句柄
     * 这里也许会影响性能,待开发...^_^
     * */
    private function slave_connect() {
        $slaves = $this->conf['slaves'];
        if( !is_array( $slaves ) )  log::record( "slave配置读取失败.", log::FATAL );
        $obj = array();
        foreach( $slaves as $k => $v ) {
            $connected = $this->connected( $v['host'], $v['port'], $v['db_name'], $v['user'], $v['password'], $v['charset'] );
            if( $connected ) $obj[] = $connected;
        }

        if( empty($obj) ) log::record( "抱歉您slave无可用服务器,请仔细检查", log::FATAL );

        //随机从多组从服务器取数据
        return $obj[ mt_rand( 0, count($obj)-1 ) ];
    }

    /*
     * 连接PDO
     * @param string $host IP
     * @param int    $port 端口
     * @param string $dbname 数据库名称
     * @param string $user 用户名
     * @param string $password 密码
     * @param string $charset 编码
     * @return object
     * */
    private function connected( $host, $port, $dbname, $user, $password, $charset ) {

        try {
            $link = new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}", $user, $password);
        } catch( \PDOException $e ) {
            //错误信息暂时关闭

			log::record(
				$e->getMessage(),
				log::FATAL
			);
            return null;
        }

		return $link;
    }

    /*
     * 查看是否为slave
     * $param $string $sql SQL语句
     * @return string
     * */
    final public function is_slave( $sql ) {

        $_sql = substr( ltrim($sql), 0, 10 );
        //slave查询操作
        $slave_str = str_ireplace(
            array( "select", 'show' ),
            '#_#',
            $_sql
        );
        if( strstr( $slave_str, '#_#' ) ) return 1;
    }

	/*
	 * 执行SQL语句 所有MYSQL_QUERY全部走这个方法
	 * @param $sql sql
	 * @return
	 */
	final public function execute($sql) {

		return $this->query(
			$sql,
			$this->conf['enable_slave'] && $this->is_slave( $sql ) ? $this->slink : $this->mlink
		);
	}

	/*
	 * 
	 * 执行SQL 用户处理数据库修复等操作 一般不直接使用, 正常操作数据库请使用execute
	 * @param $sql  sql
	 * @param $link mysql object
	 * @return object last_query 
	 */
	final public function query($sql, $link = NULL) {
		$this->last_query = $link->query($sql);
		$this->last_query_sql = $sql;

		if(!$this->last_query) {
			log::record( 'MySQL Query Error: <br/>'.$sql.' <br/>'. $link->errorInfo()[2], log::FATAL );
		}

		return $this->last_query;
	}

	/*
	 * 更新数据
	 * @param $data array array('view' => 10, 'age' => 15)
	 * @param $where string id=15 
	 * @param $tblname string table_name
	 * @return $number 
	 * */
	final public function update($data, $where, $tblname) {
		if(empty($data) || empty($where) || !is_array($data)) return false;

		$filed = array();
		foreach($data as $k => $v) {
			$this->add_special_char($k);
			$this->filter_filed_value($v);
			$filed[] = "`{$k}` = {$v}";
		}

		$filed = implode(',', $filed);

		$sql = 'UPDATE '.$tblname. ' SET '.$filed.' WHERE '.$where;
		$this->execute($sql);
		return $this->last_query;
	}

	/*
	 * 删除数据
	 * @param $where 删除条件
	 * @param $tblname table_name
	 * @return number
	 * */
	final public function delete($where, $tblname) {
		if(empty($where) || empty($tblname)) return false;

		$sql = 'DELETE FROM '.$tblname.' WHERE '.$where;
		$this->execute($sql);
		//Object of class PDOStatement could not be converted to string
		//找了资料不知道为什么,需要强制转换一下.
		return (boolean)$this->last_query;
	}

	/*
	 * 插入数据
	 * @param $data 插入数据  键值是字段 array('filed' => 'data')
	 * @param $tblname table_name
	 * @return bool
	 * */
	final public function insert($data, $tblname) {
		if(!is_array($data) || empty($data)) return false;

		$filed = array_keys($data);
		$value = array_values($data);

		$this->add_special_char($filed);
		$this->filter_filed_value($value);

		$sql = 'INSERT INTO '. $tblname .'('. $filed.') VALUES '.'('. $value .')';
		$this->execute($sql);
		return $this->last_query;

	}

	/*
	 * 获取最新的ID主键
	 * @return number
	 * */
	final public function insert_id() {
		return $this->mlink->lastInsertId();
	}

	/*
	 * 获取最后一次执行的SQL语句
	 * */
	final public function last_query_sql() {
		return $this->last_query_sql;
	}

	/*
	 * 给字段值两边加引号，保证数据安全，并对特有内容进行转义
	 * @param $value array
	 * @return void
	 * */
	final public function filter_filed_value(&$value) {
		if(is_array($value)) {
			$new_value = array();
			foreach($value as $k => $v) {
				$new_value[$k] = '\''.$v.'\'';
			}

			$value = implode(',', $new_value);
		} else {
			$value = '\''.$value.'\'';
		} 
	}

	/*
	 * 给字段增加``，为了保证数据库安全
	 * @param $filed 字段
	 * @return string 进行替换反引号之后 最后返回implode之后的数据，例如: a,b,c,d
	 * */
	final public function add_special_char(&$filed) {
		if(is_array($filed)) { //进行数组过滤
			$new_filed = array();
			foreach($filed as $k => $v) {
				$v = trim($v);

				if(strpos($v, '(') && strpos($v, ')')) {
					$v = str_replace('(', '(`', $v);
					$v = str_replace(')', '`)', $v);
				} else {
					if(strpos($v, ' as ')) {//处理 as
						$s = explode('as', $v);
						if(is_array($s)) {
							$v = '`'. trim($s[0]) .'` as '. $s[1];	
						}
					} else {
						$v = '`'. trim($v) .'`';
					}
					
				}

				$new_filed[$k] = $v; 
			}

			$filed = implode(',', $new_filed);
		} elseif(strpos($filed,',')) {//查找 如果找到逗号，就是字符串，则开始替换过滤
			$filed = explode(',', $filed);
			$this->add_special_char($filed);
		} else{//很可惜不是数字 也没有逗号  这里就不替换了，去掉两边空格，等以后遇到了问题在加反引号把

			$filed = trim($filed);
		}
	}

	/*
	 * @param $fileds string 需要显示的字段，例如：username,age,content
	 * @param $tblname string 数据表名称
	 * @param $where string where查询条件
	 * @param $limit limit 0,10 不解释了
	 * @param $order 排序
	 * @param $gourp 分组
	 * @return array
	 * */
	final public function select($fileds = '*', $tblname, $where = '', $limit = '', $order = '', $group = '') {
		if(empty($tblname)) return false;

		$where = (!empty($where)) ? ' WHERE '.$where : '' ;
		$limit = (!empty($limit)) ? ' LIMIT '.$limit : '' ;
		$order = (!empty($order)) ? ' ORDER BY '.$order : '' ;
		$group = (!empty($group)) ? ' GROUP BY '.$group : '' ;

		$this->add_special_char($fileds);
		$sql = 'SELECT '.$fileds.' FROM '.$tblname.''.$where.$group.$order.$limit;
		// echo "$sql \n";
		$this->execute($sql);
		$this->last_query->setFetchMode(PDO::FETCH_ASSOC);
		return $this->last_query->fetchAll();
	}

	/*
	 * 获取一条数据
	 * @param $fileds 字段名 例如：username,passwd,age
	 * @param $tblname table_name
	 * @param $where 查询条件 
	 * @return array;
	 * */
	final public function get_one($fileds, $tblname, $where = '') {
		if(empty($tblname)) return false;

		empty($fileds) && $fileds = '*';

		$this->add_special_char($fileds);
		$where = (!empty($where)) ? ' WHERE '.$where : '' ;

		$sql = 'SELECT '.$fileds.' FROM '.$tblname.$where.' LIMIT 1';
		$this->execute($sql);
		return $this->fetch_next();
	}

	/*
	 * 检查表是否存在
	 * @param $table_name 表名
	 * @return number 1=存在 0=不存在
	 * */
	final public function check_table_exists($table_name) {
		$sql = "SHOW TABLES LIKE '%{$table_name}%'";
		$this->execute($sql);
		$data = $this->fetch_next();

		return (!empty($data)) ? '1' : '0' ;
	}
	/*
	 * 返回结果集
	 * @param $type
	 * */
	final public function fetch_next() {

		$this->last_query->setFetchMode(PDO::FETCH_ASSOC);
		return $this->last_query->fetch();
	}

	public function version() {
		return 'pdo_mysql';
	}

	public function __destruct(){
		$this->mlink = $this->slin = NULL;
	}
}