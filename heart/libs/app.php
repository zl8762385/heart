<?php
/*
 * 应用模块
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */

namespace heart\libs;

use heart\libs\uri as uri;
use heart\libs\router as router;

class app {

    /*
     * 初始化
     * @return void
     * */
    public static function init(){

        //URi调度
        uri::init();

        //初始化SESSION
        session( load_config( 'session' ) );

        //function
        self::app_common_func();

        //路由
        router::init();

        //执行
        self::run();
    }

    /*
     * 应用function加载
     *
     * @return void
     * */
    public static function app_common_func() {
        $func_name = load_config( 'app_common_functions' );
        if( empty( $func_name ) ) return false;

        foreach( explode( ',', $func_name ) as $k => $v ) {
            __include( APP_PATH.'common/functions/'.$v.EXT );
        }
    }

    /*
     * 执行
     * @return void
     * */
    public static function run() {

        $params = [];
        if( $routers = router::dispatch() ) {
            //exec路由调度
            $controller = '\\'.load_config('directory_controller').'\\'.$routers['module'].'\\'.$routers['controller'];
            $action = $routers['action'];
        } else {
            $controller = '\\'.load_config('directory_controller').'\\'.__M__.'\\'.__C__;
            $action = __A__;
        }

        $class = new $controller();

        if( !method_exists($controller, $action) ) throw new error_exception($controller.'\\'.$action.' not found');
        call_user_func_array( array( $class, $action ), $params );
    }
}
