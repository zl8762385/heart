<?php
/*
 * 数据模型抽象基类
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart;

use heart\libs\log;
use heart\utils\page as page;

abstract class model {
    //完整表名
    private $_name = '';

    //驱动类型 pdo_mysql,mysql,mssql
    public $_type = '';

    //数据库实例
    static protected $_instance = [];

    //数据库配置信息
    public $_setting = [];

    public function __construct() {

        $this->_setting = load_config( 'db', APP_PATH.'common/database'.EXT );
        $this->_type = load_config( 'type', APP_PATH.'common/database'.EXT );
        $this->_name = $this->prefix.$this->name;
    }

    /*
     * 实例化模型
     *
     * @return object
     * */
    private function db_instance() {

        $conf = $this->_setting;
        $md5 = md5($conf['host'].$conf['db_name'].$conf['user'].$conf['password']);

        if( !isset( self::$_instance[ $md5 ] ) ) {
            $class = '\\heart\\libs\\db\\driver\\'.$this->_type;
            self::$_instance[ $md5 ] = new $class( $conf );
        }

        return self::$_instance[ $md5 ];
    }

    /*
     * 插入数据
     *
     * @param $data 数组
     * @return []
     * */
    final public function insert($data) {
        return $this->db->insert($data, $this->_name);
    }

    /*
     * 更新数据
     *
     * @param $data array
     * @param $where 可以为数组 也可以是字符串
     * */
    final public function update($data, $where) {
        if(empty($data) || empty($where) || !is_array($data)) return false;
        $where = $this->sqls($where);
        return $this->db->update($data, $where, $this->_name);
    }

    /*
     * 删除数据
     *
     * @param $data array('字段' => '10')
     * @return number
     * */
    final public function delete($where = '') {
        if( is_array($where) ) $where = $this->sqls( $where );

        return $this->db->delete($where, $this->_name);
    }

    /*
     * 普通查询
     *
     * @param $fileds string 需要显示的字段，例如：username,age,content
     * @param $where string where查询条件
     * @param $limit limit 0,10 不解释了
     * @param $order 排序
     * @param $gourp 分组
     * @return []
     */
    final public function select($fileds = '*', $where = '', $limit = '', $order = '', $group = '') {
        return $this->db->select($fileds, $this->_name, $where, $limit, $order, $group);
    }

    /*
     * 查询列表并返回分页句柄 AND html
     *
     * @param string $fileds 字段
     * @param string $where 条件
     * @param numbers $pagesize 分页数量
     * @param string $order 排序 id desc,name asc
     * @param string $group 分组
     * @return []
     * */
    final public function select_lists( $fileds = '*', $where = '', $pagesize = '10', $order = '', $group = '' ) {

        //获取总数
        $total = $this->db->get_one( 'count(*) as total' , $this->_name, $where)['total'];

        $page  = new page( $total, $pagesize );
        $limit = $page->limit;

        //返回分页HTML  调用方法 $this->db->page
        $this->page = $page->showpage();

        return $this->db->select($fileds, $this->_name, $where, $limit, $order, $group);
    }

    /*
     * 获取一条数据
     * */
    final public function get_one($fileds = '*', $data) {
        $where = $this->sqls($data);
        $where = (is_numeric($data)) ? "id = $where" : $where;

        return $this->db->get_one($fileds, $this->_name, $where);
    }

    /*
     * 检查表是否存在
     *
     * @param $name
     * */
    public function check_table_exists( $name = '' ) {
        $table_name = ( $name ) ? $name : $this->_name ;
        return $this->db->check_table_exists( $table_name );
    }

    /*
     * mysql_fetch_array
     * */
    final public function fetch_next() {
        return $this->db->fetch_next();
    }

    /*
     * 获取最后一次执行ID主键
     * */
    final public function insert_id(){
        return $this->db->insert_id();
    }

    /*
     * 获取最后一次执行的SQL语句
     * */
    final public function last_query_sql() {
        return $this->db->last_query_sql();
    }


    /*
     * 创建limit
     *
     * @param $offset 偏移数字
     * @param limit number
     * @return 0,10
     * */
    final public function build_limit($offset, $num = NULL) {
        $offset = (int) $offset;
        $offset = (empty($offset)) ? 0 : $offset ;

        return $num === NULL ? $offset : $offset.','. $num ;
    }

    /*
     * 将数组转换成SQL语句
     *
     * @param $where SQL数组
     * @param $font 连接字符串
     * @return
     * */
    final public function sqls($where, $font = ' AND ') {
        if(is_array($where)) {
            $sqls_str = '';
            foreach($where as $k => $v) {
                $sqls_str .= ($sqls_str) ? " $font `$k` = '$v'" : " `$k` = '$v'" ;
            }
            return $sqls_str;
        } else {
            return $where;
        }
    }

    public function __get( $name ) {
        switch( $name ) {
            case 'db':
                return $this->db_instance();
                break;
            default:
                return false;

        }
    }

    public function __call( $method, $value ) {
        log::record( "$method() method not found", log::FATAL);
    }
}
