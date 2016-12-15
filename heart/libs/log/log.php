<?php
/*
 * 日志
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace heart\libs\log;

class log {

    //日志等级
        //常规
    const INFO = 'info';
        //调试
    const DEBUG = 'debug';
        //标准
    const ERROR = 'error';
        //警告
    const WARN = 'warn';
        //致命
    const FATAL = 'fatal';


    //日志信息
    static protected $log = [];

    //实例对象
    static protected $_instances = [];

    /*
     * 初始化日志
     * */
    static public function init( $config = [] ) {
        $type = isset( $config['type'] )? $config['type'] : 'file' ;

        $class = 'heart\\libs\\log\\driver\\'.$type;
        self::$_instances[$type] = new $class();
    }

    /*
     * 获取日志信息
     * @param $type string 日志类型
     * @return array
     * */
    static public function get_log( $type = '' ) {
        return $type ? self::$log[$type] : self::$log ;
    }

    /*
     * 记录信息
     * @param $msg string 信息
     * @param $type string 日志类型
     * */
    static public function record( $msg, $type = 'info' ) {
        self::$log[$type][] = $msg;
    }

    /*
     * 自动保存,当程序结束后执行
     * */
    static public function save() {
        if( !self::$log ) return true;

        $type = load_config( 'log' )['type'];

        //初始化
        if( !isset( self::$_instances[ $type ] ) ) self::init( load_config( 'log' ) );

        self::$_instances[$type]->write( self::$log );
    }

}
