<?php
/*
 * session会话管理 驱动
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart\libs\session;


class driver {

    //配置信息
    protected $config = [];

    public function __construct() {}

    /*
     * 开启会话
     *
     * @return void
     * */
    public function start( $config = [] ) {
        if( empty( $config ) ) return false;
        $this->config = $config;

        //php.ini设置
        $this->ini_set();

        //生成SESSION NAME
        if( $this->config['name'] ) session_name( $this->config[ 'name' ] );

        //启动SESSION
        if( $this->config['auto_start'] ) session_start();

        //重新生成ID
        if( $this->config['regenerate'] ) session_regenerate_id();

        //驱动设置
        $this->driver();

    }

    /*
     * ini_set 选项设置
     * */
    public function ini_set() {

        //存储和驱动设置
        if( isset( $this->config['host'] ) && is_array( $this->config['host'] ) ) {
            ini_set( 'session.save_handler', $this->config['type'] );
            ini_set( 'session.save_path', implode( ',', $this->config['host'] ) );
        }

    }

    /*
     * 设置SESSION存储驱动
     *
     * @return void
     * */
    public function driver() {
        if( empty( $this->config['type'] ) ) return false;

        $handler = new $this->config['type']();
        session_set_save_handler(
            array(&$handler,"open"),
            array(&$handler,"close"),
            array(&$handler,"read"),
            array(&$handler,"write"),
            array(&$handler,"destroy"),
            array(&$handler,"gc")
        );
    }

    /*
     * 设置会话
     *
     * @param $name string session变量名  支持.语法[name1.name2.names3] = 'value';仅支持二维
     * @param $value strign 值
     * @return void
     * */
    public function set( $name, $value ) {
        if( empty( $name ) || empty( $value ) ) return false;

        if( strstr( $name, '.' ) ) {
            list( $name1, $name2 ) = explode( '.', $name );
            $_SESSION[ $name1 ][$name2] = $value;
        } else {
            $_SESSION[ $name ] = $value;
        }
    }

    /*
     * 获取会话
     *
     * @param $name string session变量名  支持.语法[name1.name2.names3] = 'value';仅支持二维
     * @return void
     * */
    public function get( $name = '' ) {
        if( empty( $name ) ) return false;

        if( strstr( $name, '.' ) ) {
            list( $name1, $name2 ) = explode( '.', $name );
            return $_SESSION[ $name1 ][ $name2 ];
        } else {
            return ( isset( $_SESSION[ $name ] ) ) ? $_SESSION[ $name ] : '' ;
        }
    }

    /*
     * 销毁指定会话
     *
     * @param $name string session变量名  支持.语法[name1.name2.names3] = 'value';仅支持二维
     * @return void
     * */
    public function rm( $name = '' ) {
        if( empty( $name ) ) return false;

        if( strstr( $name, '.' ) ) {
            list( $name1, $name2 ) = explode( '.', $name );
            unset( $_SESSION[ $name1 ][ $name2 ] );
        } else {
            unset( $_SESSION[ $name ] );
        }
    }
}
