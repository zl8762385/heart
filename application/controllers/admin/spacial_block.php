<?php
/*
 * 专题碎片
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace controllers\admin;

use services\admin_base;
use heart\utils\form;

class spacial_block extends admin_base{

    //db
    public $db = [];

    public function __construct() {
        parent::__construct();

        $this->db = load_model( 'admin_spacial_block' );

        //专题列表
        $this->db_spacial = load_model( 'admin_spacial' );

        //专题模型
        $this->db_spacial_model = load_model( 'admin_spacial_model' );
    }

    /*
     *列表
     *
     * @return tpl
     * */
    public function index() {
        $sid = gpc( 'sid' );
        $_where = [];
        //sid=0 是全局碎片
        $_where[] = ( !empty( $sid ) ) ? "sid={$sid}" : "sid=0" ;
        $where = implode( ' AND ', $_where );

        $lists = $this->db->select_lists( '*', $where, '10', 'id ASC');

        $spacial_infos = [];
        if( !empty( $sid ) ) {
            $spacial_infos = $this->db_spacial->get_one( 'id,name', [ 'id' => $sid ] );
        }

        if( !empty( $lists ) ) {
            //获取模型数据
            foreach( $lists as $k => &$v ) {
                if( empty( $v['mid'] ) ) continue;
                $v['model_infos'] = $this->db_spacial_model->get_one( 'id,name', [ 'id' => $v['mid'] ]);
            }
        }

        $this->view->assign( 'refer', ( isset( $_SERVER['HTTP_REFERER'] ) ) ? $_SERVER['HTTP_REFERER'] : '' );
        $this->view->assign( 'page', $this->db->page );
        $this->view->assign( 'sid', ( !empty( $sid ) ) ? $sid : 0 );
        $this->view->assign( 'lists', $lists );
        $this->view->assign( 'spacial_infos', $spacial_infos);
        $this->view->display();
    }

    /*
     * 获取数据模型列表
     *
     * @param $sid int 专题ID
     * @return []
     * */
    public function get_spacial_model( $sid = '' ) {
        $_where = [];
        if( !empty( $sid ) ) {
            $_where[] = "sid=0 OR sid=".$sid;
        }

        $where = implode( ' AND ', $_where );

        return $this->db_spacial_model->select( 'id,name', $where);
    }

    /*
     * 增加
     *
     * @return tpl
     * */
    public function add() {
        if( gpc( 'dosubmit', 'P' ) ) {
            $infos = gpc( 'infos', 'P' );

            if( empty( $infos['name'] ) ) $this->show_message( '请输入碎片键值' );

            $infos['createtime'] = $infos['updatetime'] = time();
            switch( $infos['type'] ) {
                case 0:
                    $infos['content '] = gpc( 'content', 'P' );
                    break;
                case 1:case 2:
                    $infos['content'] = gpc( 'new_content', 'P' );
                    break;

            }


            if( $this->db->insert( $infos ) ) {
                 $this->show_message( '操作成功' );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $sid = gpc( 'sid' );
        $infos = [];
        if( !empty( $sid ) ) {
            $infos = $this->db_spacial->get_one( 'id,name', 'id='.$sid );
        }

        $this->view->assign( 'editor', form::editor('content' , 'content', '', 'normal') );
        $this->view->assign( 'sid', ( !empty( $sid ) ) ? $sid : 0 );
        $this->view->assign( 'infos', $infos );
        $this->view->assign( 'm_lists', $this->get_spacial_model( $sid ) );
        $this->view->display();
    }

    /*
     * 修改
     *
     * @return tpl
     * */
    public function edit() {
        if( gpc( 'dosubmit', 'P' ) ) {
            $infos = gpc( 'infos', 'P' );
            $id = gpc( 'id', 'P' );

            if( empty( $infos['name'] ) ) $this->show_message( '请输入碎片键值' );

            $infos['createtime'] = $infos['updatetime'] = time();

            switch( $infos['type'] ) {
                case 0:
                    $infos['content '] = gpc( 'content', 'P' );
                    break;
                case 1:case 2:
                    $infos['content'] = gpc( 'new_content', 'P' );
                    break;

            }

            if( $this->db->update( $infos, ['id' => $id] ) ) {
                 $this->show_message( '操作成功' );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $id = gpc( 'id' );
        $sid = gpc( 'sid' );
        if( empty( $id ) ) $this->show_message( 'ID不能为空' );
        $infos = $this->db->get_one( '*',['id' => $id ] );

        $spacial_infos = [];
        if( !empty( $sid ) ) {
            $spacial_infos = $this->db_spacial->get_one( 'id,name', [ 'id' => $sid ] );
        }

        $this->view->assign( 'editor', form::editor('content' , 'content', $infos['content'], 'normal') );
        $this->view->assign( 'infos', $infos );
        $this->view->assign( 'spacial_infos', $spacial_infos);
        $this->view->assign( 'm_lists', $this->get_spacial_model( $sid ) );
        $this->view->assign( 'sid', $sid);
        $this->view->display();
    }

    /*
     * 删除
     *
     * @return 1:0
     * */
    public function del() {
        $id = gpc( 'id' );
        if( empty( $id ) ) $this->show_message( 'ID不能为空' );

        echo ( $this->db->delete( ['id'=>$id] ) ) ? 1 : 0 ;
    }
}