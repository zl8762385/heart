<?php
/*
 * 路由驱动 - cli
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace heart\libs\router\driver;

use heart\libs\router\driver as driver;

class cli extends driver {

    public function __construct() {
    }

    public function get_uri() {
        return $this->cli_handler();
    }


    /*
     * cli
     * @return array
     * */
    public function cli_handler() {
        $argv = ( isset( $_SERVER['argv'][1] )  ) ? explode('/', $_SERVER['argv'][1]) : [] ;
        switch ( count($argv) ) {
            case 2:
                list( $r['controller'], $r['action'] ) = $argv;
                break;
            case 3:
                list( $r['module'],$r['controller'], $r['action'] ) = $argv;
                break;
            default:
                $r = [];
        }
        return $r;
    }

}
