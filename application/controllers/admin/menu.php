<?php
/*
 * 后台菜单
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace controllers\admin;

use services\admin_base;

class menu extends admin_base{

    //admin_menu db
    public $db = [];

    public function __construct() {
        parent::__construct();

        $this->db = load_model( 'admin_menu' );
    }

    /*
     *列表
     *
     * @return tpl
     * */
    public function index() {
        $pid = gpc( 'pid' );
        $_where = [];
        $_where[] = ( !empty( $pid ) ) ? "parentid={$pid}" : "parentid=0" ;
        $where = implode( ' AND ', $_where );

        $lists = $this->db->select_lists( '*', $where, '10', 'sort ASC, menuid ASC');

        $this->view->assign( 'page', $this->db->page );
        $this->view->assign( 'pid', ( !empty( $pid ) ) ? $pid : 0 );
        $this->view->assign( 'refer', ( isset( $_SERVER['HTTP_REFERER'] ) ) ? $_SERVER['HTTP_REFERER'] : '' );
        $this->view->assign( 'lists', $lists );
        $this->view->display();
    }

    /*
     * 排序
     * @return boolean
     * */
    public function sort() {
        $ids = gpc( 'ids', 'P' );
        if( empty( $ids ) ) $this->show_message( '没数据.' );

        foreach( $ids as $k => $v ) {
            $this->db->update( ['sort'=>$v], ['menuid' => $k] );
        }

        $this->show_message( '操作成功.' );
    }

    /*
     * 增加
     *
     * @return tpl
     * */
    public function add() {
        if( gpc( 'dosubmit', 'P' ) ) {
            $infos = gpc( 'infos', 'P' );

            if( empty( $infos['name'] ) ) $this->show_message( '请输入菜单名' );
            if( empty( $infos['model'] ) ) $this->show_message( '请输入模块名' );
            if( empty( $infos['controller'] ) ) $this->show_message( '请输入控制器名' );
            if( empty( $infos['action'] ) ) $this->show_message( '请输入方法名' );

            $infos['createtime'] = $infos['updatetime'] = time();

            if( $this->db->insert( $infos ) ) {
//                 $this->show_message( '操作成功', make_url( __M__, __C__, 'index' ) );
                 $this->show_message( '操作成功' );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }
        $pid = gpc( 'pid' );
        $infos = [];
        if( !empty( $pid ) ) {
            $infos = $this->db->get_one( 'parentid,name', 'menuid='.$pid );
        }

        $this->view->assign( 'pid', ( !empty( $pid ) ) ? $pid : 0 );
        $this->view->assign( 'infos', $infos );
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
            $menuid = gpc( 'menuid', 'P' );

            if( empty( $infos['name'] ) ) $this->show_message( '请输入菜单名' );
            if( empty( $infos['model'] ) ) $this->show_message( '请输入模块名' );
            if( empty( $infos['controller'] ) ) $this->show_message( '请输入控制器名' );
            if( empty( $infos['action'] ) ) $this->show_message( '请输入方法名' );

            $infos['createtime'] = $infos['updatetime'] = time();

            if( $this->db->update( $infos, ['menuid' => $menuid] ) ) {
                 $this->show_message( '操作成功', make_url( __M__, __C__, 'index' ) );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $menuid = gpc( 'menuid' );
        if( empty( $menuid ) ) $this->show_message( 'MENU ID不能为空' );
        $infos = $this->db->get_one( '*',['menuid' => $menuid ] );

        $this->view->assign( 'infos', $infos );
        $this->view->display();
    }

    /*
     * 删除
     *
     * @return 1:0
     * */
    public function del() {
        $menuid = gpc( 'menuid' );
        if( empty( $menuid ) ) $this->show_message( 'MENU ID不能为空' );

        $this->db->delete( ['parentid'=>$menuid] );
        echo ( $this->db->delete( ['menuid'=>$menuid] ) ) ? 1 : 0 ;
    }
}