<?php
/*
 * URL调度（URL映射到控制器）
 * 默认开启: PATH_INFO,动态模式
 *
 *
 * URL访问方式
 * 多模块扩展    : /index.php?m=admin&c=users&a=zhangliang
 * 动态         :  index.php?m=1&c=2&a=3
 * PATH_INFO1   :/index/init
 * PATH_INFO2   :/模块/控制器/方法
 * PATH_INFO3   :/模块1/模块2/控制器/方法
 *
 * @copyright			(C) 2016 HeartPHP
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */

namespace heart\libs;

class dispatcher {

    //默认module
    static $module = 'index';

    //默认controller
    static $controller = 'index';

    //默认action
    static $action = 'index';

    //请求方式
    static $uri_request_method = [
        'module' => 'm',
        'controller' => 'c',
        'action' => 'a',
    ];

    /*
     * 初始化
     * */
    static public function init() {
        //安全过滤
        $_GET     && self::filter_gpc( $_GET );
//        $_POST    && self::filter_gpc( $_POST );
        $_COOKIE  && self::filter_gpc( $_COOKIE );
        $_REQUEST && self::filter_gpc( $_REQUEST );

        $request = [];
        //命令行模式请求 php index.php 模块 控制器 方法
        if( IS_CLI ) $request = self::cli();
        if( $_GET ) $request = self::vars();
        if( load_config( 'uri_path_info' ) && empty($request) ) $request = self::pathinfo();

        //定义常量
        if( !defined( "__M__" ) ) define( "__M__",  isset($request['module']) ? $request['module'] : self::$module );
        if( !defined( "__C__" ) ) define( "__C__",  isset($request['controller']) ? $request['controller'] : self::$controller );
        if( !defined( "__A__" ) ) define( "__A__",  isset($request['action']) ? $request['action']: self::$action );
    }

    /*
     * 处理动态请求
     * @return void
     * */
    static public function vars() {
        $request = [];
        foreach( self::$uri_request_method as $k => $v ) {

            if( !isset($_GET[$v]) ) continue;
            $request[$k] = $_GET[$v] ? $_GET[$v] : self::$controller ;
        }

        return $request;
    }

    /*
     * cli
     * @return array
     * */
    static public function cli() {
        $clis = $_SERVER['argv'];
        unset( $clis[0] );

        $argv = [];
        foreach( $clis as $v ) $argv[] = $v;

        $r = array();
        switch ( $_SERVER['argc'] ) {
            case 3:
                list( $r['controller'], $r['action'] ) = $argv;
                break;
            case 4:
                list( $r['module'],$r['controller'], $r['action'] ) = $argv;
                break;
        }

        return $r;
    }

    /*
     * PATH_INFO支持
     * @return array
     * **/
    static public function pathinfo() {
        $pathinfo = array_filter( explode('/', $_SERVER['PATH_INFO']) );

        //安全过滤
        foreach( $pathinfo as $k => &$v ) self::filter_gpc( $v );

        $r = [];
        if( count($pathinfo) == 2) {

            //模块如果存在 改变路由顺序
            if( is_dir( APP_PATH.load_config( 'directory_controller' ).'/'.$pathinfo[1] ) ) {
                $r['module'] = $pathinfo[1];
                $r['controller'] = $pathinfo[2];
                $r['action'] = self::$action;
            } else {
                //默认访问index模块  test/inex 等同于 index/test/index
                $r['module'] = self::$module;
                $r['controller'] = $pathinfo[1];
                $r['action'] = $pathinfo[2];
            }
        }

        if( count($pathinfo) == 3 ) {
            $r['module'] = $pathinfo[1];
            $r['controller'] = $pathinfo[2];
            $r['action'] = $pathinfo[3];
        }

        return $r;
    }

    /*
     * URL安全过滤
     * */
    static public function filter_gpc( &$data ) {

        if( is_array($data) ) {
            foreach( $data as $k => $v ) {
                $data[$k] = self::filter_gpc($v);
            }
        } else {

            $data = trim($data);
            $data = removexss($data);
            return $data;
        }
    }
}