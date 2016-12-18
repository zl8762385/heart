<?php
/*
 * 专题碎片（解析语法）
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 **/
namespace services\spacials;

use heart\controller;

class block extends controller {
    //需要处理的HTML
    public $html = '';

    //区块数组
    public $block = [];

    //专题ID
    public $id = '';

    //模板语法
    public $left_str = '<{';
    public $right_str = '}>';

    public function __construct( $id ) {
        $this->id = $id;

        $this->db_block = load_model( 'admin_spacial_block' );
    }

    /*
     * 解析block
     *
     * @param $html string html代码
     * */
    public function parse( $html ) {
        preg_match_all( '/<{(.*)}>/i', $html, $m );

        if( empty( $m[1] ) ) return $this->html = $html;
        foreach( $m[1] as $k => $v ) {
            $v= preg_replace( '/block\((.*)\)/i', "$1", $v );
            $v = str_replace( '\'', '', $v );
            $v = str_replace( '"', '', $v );

            $rs = $this->block( $v );
            $html = str_replace( $m[0][$k], $rs, $html );
        }

        $this->html = $html;
    }

    /*
     * 区块数据
     *
     * @param $key string 参数
     * */
    public function block( $key ) {

        $infos = $this->get_block( $key );
        if( empty( $infos ) ) return false;

        $rs = '';
        switch( $infos['type'] ) {
            case 0: case 1:
                $rs = $infos['content'];
                break;
            case 2:
                $rs = '我是列表';
                break;
        }

        return $rs;

    }

    /*
     * 获取碎片数据
     *
     * @param $name string 碎片键值
     * @return []
     * */
    public function get_block( $name ) {
        if( empty( $name ) ) return false;

        $infos = $this->db_block->get_one( '*', [ 'name' => $name ] );
        return ( !empty($infos) ) ? $infos : [] ;
    }

    /*
     * 获取HTML
     *
     * @return string;
     * */
    public function get() {
        return $this->html;
    }

}

