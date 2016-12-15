<?php
/*
 * 管理员
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace controllers\admin;

use services\admin_base;

class user extends admin_base{

    //admin_users db
    public $db = [];

    public function __construct() {
        parent::__construct();

        $this->db = load_model( 'admin_users' );
        $this->db_role = load_model( 'admin_role' );
    }

    /*
     *列表
     *
     * @return tpl
     * */
    public function index() {
        $_where = [];
        if( !empty( gpc( 'q' ) ) ) {
            $q = gpc( 'q' );
            $column = gpc( 'column' );

            $_where[] = "{$column} like '%{$q}%'";
        }

        $where = implode( ' AND ', $_where );

        $lists = $this->db->select_lists(
            'uid, username, email, truename, createtime, updatetime, groupid, islock',
            $where,
            '10',
            'uid desc'
        );

        $this->view->assign( 'page', $this->db->page );
        $this->view->assign( 'lists', $lists );
        $this->view->assign( 'db_role', $this->db_role);
        $this->view->display();
    }

    /*
     * 增加
     *
     * @return tpl
     * */
    public function add() {
        if( gpc( 'dosubmit', 'P' ) ) {
            $infos = gpc( 'infos', 'P' );

            if( empty( $infos['username'] ) ) $this->show_message( '请输入用户名' );
            if( empty( $infos['password'] ) ) $this->show_message( '请输入密码' );
            if( empty( $infos['pwdconfirm'] ) ) $this->show_message( '请输入确认密码' );
            if( $infos['password'] != $infos['pwdconfirm'] ) $this->show_message( '两次密码不一致' );

            $_password = password( $infos['pwdconfirm'] );
            unset( $infos['password'], $infos['pwdconfirm'] );
            $infos['password'] = $_password['password'];
            $infos['encrypt'] = $_password['encrypt'];
            $infos['createtime'] = $infos['updatetime'] = time();

            if( $this->db->insert( $infos ) ) {
                 $this->show_message( '操作成功', make_url( __M__, __C__, 'index' ) );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $this->view->assign( 'role_lists', $this->db_role->select());
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
            $uid = gpc( 'uid', 'P' );

            if( empty( $infos['username'] ) ) $this->show_message( '请输入用户名' );

            if( !empty( $infos['password'] ) || $infos['pwdconfirm'] ) {
                if( empty( $infos['password'] ) ) $this->show_message( '请输入密码' );
                if( empty( $infos['pwdconfirm'] ) ) $this->show_message( '请输入确认密码' );
                if( $infos['password'] != $infos['pwdconfirm'] ) $this->show_message( '两次密码不一致' );

                $_password = password( $infos['pwdconfirm'] );
                unset( $infos['password'], $infos['pwdconfirm'] );
                $infos['password'] = $_password['password'];
                $infos['encrypt'] = $_password['encrypt'];
            } else {

                unset( $infos['password'], $infos['pwdconfirm'] );
            }

            $infos['updatetime'] = time();

            if( $this->db->update( $infos, [ 'uid' => $uid ] ) ) {
                $this->show_message( '操作成功', make_url( __M__, __C__, 'index' ) );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $uid = gpc( 'uid' );
        if( empty( $uid ) ) $this->show_message( 'UID不能为空' );
        $infos = $this->db->get_one( '*',['uid' => $uid ] );

        $this->view->assign( 'infos', $infos );
        $this->view->assign( 'role_lists', $this->db_role->select());
        $this->view->display();
    }

    /*
     * 删除
     *
     * @return 1:0
     * */
    public function del() {
        $uid = gpc( 'uid' );
        if( empty( $uid ) ) $this->show_message( 'UID不能为空' );

        echo ( $this->db->delete( ['uid'=>$uid] ) ) ? 1 : 0 ;
    }
}