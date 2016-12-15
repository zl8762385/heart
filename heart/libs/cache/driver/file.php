<?php
/*
 * 文件缓存
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart\libs\cache\driver;

use heart\libs\cache\driver;
use heart\libs\error_exception;
use heart\libs\log\log;

class file extends driver{

	//缓存目录
	protected $_dir = '';

	//缓存文件名
	protected $_filename = '';

	//缓存后缀名
	protected $_suffix = '.cache.php';

	//配置文件
	protected $_conf = [];

	public function __construct(){

		$this->_conf = load_config( 'cache' )['file'];
		$this->_dir = $this->dir();
	}

	/*
	 * 获取缓存目录
	 *
	 * @return string
	 * */
	public function dir() {

		!file_exists( $this->_conf['dir'] ) && mkdir( $this->_conf['dir'], 0755, true );
		return $this->_conf['dir'];
	}

	/*
	 * 获取文件名
	 * @param $name string 缓存变量名
	 * @return string
	 * */
	public function get_file( $name ) {
		return md5( $name ).$this->_suffix;
	}

	/*
     * 设置缓存
	 *
     * @param $name string 缓存变量名
     * @param $value string|array 数据
     * @param $life int 有效时间 0为永久
	 * @return void
     * */
	public function set($name, $data, $life = 0) {

		//如果存在则覆盖
		if(($fp = fopen($this->_dir.$this->get_file( $name ), 'wb')) === false) {
			throw new error_exception( 'cache创建失败，请检查文件权限！' );
		}

		//缓存数据格式
		$_data = '<?php
$_data["life"] = '.$life.';
$_data["data"] = '.var_export($data,true).';
?>';
		flock($fp, LOCK_EX + LOCK_NB);//独占上锁
		fwrite($fp, $_data);
		flock($fp, LOCK_UN + LOCK_NB);//解锁
		fclose($fp);	
	}

	/*
     * 读取缓存
	 *
     * @param $name string 缓存变量名
     * @param $default string 默认值
     * @return string|array
     * */
	public function get( $name, $default = null ) {
		$file = $this->_dir.$this->get_file( $name );

		if(is_file($file)) {
			include $file;

			if($this->is_active($file, $_data['life'])) {
				return $_data['data'];
			} else {
				$this->rm( $name );//过期删除文件
				return false;
			}
		}
	}

	/*
	 * 删除缓存
	 *
	 * @param $name string 缓存变量名
	 * @return void
	 * */
	public function rm( $name ) {

		$filename = $this->get_file( $name );
		if(is_file($this->_dir.$filename)) @unlink($this->_dir.$filename);
	}

	/*
	 * 删除全部缓存
	 *
	 * @return bool
	 * */
	public function rm_all() {

		$path = dir($this->_dir);
		while(($v = $path->read()) !== false) {
			if($v == '..' || $v == '.') continue;
			if(is_file($this->_dir.$v)) {
				@unlink($this->_dir.$v);
			} else {
				return false;
			}
		}

		return true;
	}

	/*
	 * 检测文件是否过期
	 *
	 * @param $filepath 文件完整路径
	 * @param $life 过期时间
	 * @return bool
	 * */
	public function is_active($file, $life = 0) {

		return ( time() > ( filemtime($file)+$life) ) ? false : true ;
	}

	public function __call($method, $params) {
		log::record( "$method() not found" );
	}
}