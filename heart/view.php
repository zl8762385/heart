<?php
/*
 * 视图
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart;

use heart\libs\error_exception;

class view {

    //数据集合
    protected $_data = [];

    //控制器目录
    protected $_controller = '';

    //视图名
    protected  $_view = '';

    //模板扩展名
    protected $_tmp_suffix = '';

    public function __construct() {
        $this->_controller = load_config( 'directory_controller' );
        $this->_view = load_config( 'directory_view' );
        $this->_tmp_suffix = load_config( 'template_suffix' );
    }

    /*
     * 视图数据赋值
     * @param $k string 键值
     * @param $v string|array 数据
     * @return void
     * */
    public function assign( $k, $v ) {
        if( empty($k) ) return false;

        $this->_data[$k] = $v;
    }

    /*
     * 实例视图 调用模板
     * @param $tpl_name string 模板名称
     * @return void
     * */
    public function display( $tpl_name = '' ) {

        extract( $this->_data, EXTR_SKIP );

        //当前访问的模块 模板路径/支持夸模块调用
        if( strpos( $tpl_name, '::' ) ) {
            $module_name = strstr( $tpl_name, '::', 1 );
            $module = $module_name.'/'.$this->_view.'/';
            $tpl_name = str_replace( $module_name.'::', '', $tpl_name );
        } else {
            $module = __M__.'/'.$this->_view.'/';
        }

        $controller = APP_PATH.$this->_controller.'/';
        $path = ( $tpl_name ) ? $tpl_name : __C__.'/'.__A__ ;
        $path = $controller.$module.$path.$this->_tmp_suffix;

        //当前模板模块写入全局
        $GLOBALS['tpl_module'] = $module;
        $GLOBALS['tpl_data'] = $this->_data;

        if( !is_file( $path ) ) throw new error_exception( "$path \r\n not found" );

        include( $path );
        exit;
    }

    public function __call( $method, $param ) {

        throw new error_exception( "$method() not found" );
    }
}
