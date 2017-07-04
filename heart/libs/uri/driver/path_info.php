<?php
/*
 * 路由驱动 - path_info
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace heart\libs\uri\driver;

use heart\libs\uri\driver as driver;

class path_info extends driver {

    //server pathinfo
    protected $path_info = [];

    public function __construct() {
        isset( $_SERVER['PATH_INFO'] ) || die('您环境不支持PATH_INFO.');

        $this->path_info = $_SERVER['PATH_INFO'];
    }


    /*
     * 返回URI
     * @return [];
     * */
    public function get_uri() {
        return $this->path_info();
    }


    /*
     * PATH_INFO
     * @return []
     * **/
    public function path_info() {
        $infos = $this->get_infos();

        switch( count( $infos ) ) {
            case 1:
                list( $module ) = $infos;
                $u['module'] = $module;
                break;
            case 2:
                list( $module, $controller ) = $infos;
                $u['module'] = $module;
                $u['controller'] = $controller;
                break;
            default:
                list( $module, $controller, $action ) = $infos;
                $u['module'] = $module;
                $u['controller'] = $controller;
                $u['action'] = $action;
        }

        return $u;
    }

    /*
     * 获取 path_infos全路径数组
     * @return [];
     * */
    public function get_infos() {
        $path_info = array_filter( explode('/', $this->path_info ) );

        return ( $path_info ) ? array_values( $path_info ) : [] ;
    }

}
