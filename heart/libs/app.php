<?php
/*
 * 应用模块
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */

namespace heart\libs;

class app {

    /*
     * 初始化
     * @return void
     * */
    static public function init(){

        //URi映射
        \heart\libs\uri::init();

        //初始化SESSION
        session( load_config( 'session' ) );

        //应用function
        self::app_common_func();

        //执行
        self::run();
    }

    /*
     * 应用function加载
     *
     * @return void
     * */
    static function app_common_func() {
        $func_name = load_config( 'app_common_functions' );
        if( empty( $func_name ) ) return false;

        foreach( explode( ',', $func_name ) as $k => $v ) {
            __include( APP_PATH.'common/functions/'.$v.EXT );
        }
    }

    /*
     * 执行
     *
     * @return void
     * */
    static public function run() {

        $controller = '\\'.load_config('directory_controller').'\\'.__M__.'\\'.__C__;
        $class = new $controller();

        if( !method_exists($controller, __A__) ) throw new error_exception($controller.'\\'.__A__.' not found');
        call_user_func( array( $class, __A__ ) );
    }
}
