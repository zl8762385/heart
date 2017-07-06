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

//路由驱动
use heart\libs\uri\driver as uri_driver;

class uri {

    //默认module
    public static $module = 'index';

    //默认controller
    public static $controller = 'index';

    //默认action
    public static $action = 'index';

    //请求方式
    static $uri_request_method = [
        'module' => 'm',
        'controller' => 'c',
        'action' => 'a',
    ];

    /*
     * 初始化
     * */
    public static function init() {
        //安全过滤
        self::safety();
        //获取路由信息
        $request = self::get();
        //定义常量
        defined( "__M__" ) or define( "__M__",  isset($request['module']) ? $request['module'] : self::$module );
        defined( "__C__" ) or define( "__C__",  isset($request['controller']) ? $request['controller'] : self::$controller );
        defined( "__A__" ) or define( "__A__",  isset($request['action']) ? $request['action']: self::$action );
        defined( '__URI__' ) or define( "__URI__", __M__.'/'.__C__.'/'.__A__ );
    }

    /*
     * 安全过滤
     * @return void
     * */
    public static function safety() {
        //安全过滤
        $_GET     && self::filter_gpc( $_GET );
        $_COOKIE  && self::filter_gpc( $_COOKIE );
        $_REQUEST && self::filter_gpc( $_REQUEST );
//        $_POST    && self::filter_gpc( $_POST );
    }

    /*
     * 获取执行的类型
     * @return [];
     * */
    public static function get() {
        //cli
        if( IS_CLI ) return  ( new uri_driver\cli() )->get_uri();

        //pathinfo
        if ( IS_PATH_INFO) return ( new uri_driver\path_info() )->get_uri();


        return self::vars();
    }

    /*
     * 处理动态请求
     * @return void
     * */
    public static function vars() {
        $request = [];
        foreach( self::$uri_request_method as $k => $v ) {

            if( !isset($_GET[$v]) ) continue;
            $request[$k] = $_GET[$v] ? $_GET[$v] : self::$controller ;
        }

        return $request;
    }

    /*
     * URL安全过滤
     * @return [] | string
     * */
    public static function filter_gpc( &$data ) {

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