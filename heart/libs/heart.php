<?php
/**
 *
 * 应用
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace heart\libs;


class heart {

    //类映射字典
    public static $_map = array();

    /*
     * 初始化
     * */
    public static function init() {

        //注册自动加载
        spl_autoload_register( '\heart\libs\heart::autoload' );

        //加载基础文件
        include FRAMEWORK_PATH.'functions'.EXT;

        set_exception_handler( '\heart\libs\error::exception_handler' );

        //注册错误机制
        error::init();

        //执行
        app::init();
    }

    public static function autoload( $class ){
        $class_path = str_replace( '\\', '/', $class );

        //核心
        if( substr( $class, 0,5 ) === 'heart' ) __include( ROOT_PATH.$class_path.EXT );
        //控制器
        if( substr( $class, 0, 10 ) === 'controller' ) __include( APP_PATH.$class_path.EXT );
        //数据模型
        if( substr( $class, 0, 5 ) === 'model' ) __include( APP_PATH.$class_path.EXT );
        //服务助手类
        if( substr( $class, 0, 8 ) === 'services' ) __include( APP_PATH.$class_path.EXT );
    }
}