<?php
/*
 * 角色管理
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace controllers\admin;

use services\admin_base;

class role extends admin_base{

    //role db
    public $db = [];

    public $db_menu = [];

    public function __construct() {
        parent::__construct();

        $this->db = load_model( 'admin_role' );
        $this->db_menu = load_model( 'admin_menu' );
    }

    /*
     *列表
     *
     * @return tpl
     * */
    public function index() {
        $lists = $this->db->select_lists( '*', '', '10', 'id DESC');

        $this->view->assign( 'page', $this->db->page );
        $this->view->assign( 'lists', $lists );
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
            $group_ids = gpc( 'group_ids','P' );

            if( empty( $infos['name'] ) ) $this->show_message( '请输入角色名称' );

            $infos['createtime'] = $infos['updatetime'] = time();
            $infos['list'] = $group_ids;

            if( $this->db->insert( $infos ) ) {
                 $this->show_message( '操作成功', make_url( __M__, __C__, 'index' ) );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $this->view->assign('menus', $this->menus());
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
            $group_ids = gpc( 'group_ids','P' );
            $id = gpc( 'id', 'P' );

            if( empty( $infos['name'] ) ) $this->show_message( '请输入角色名称' );

            $infos['createtime'] = $infos['updatetime'] = time();
            $infos['list'] = $group_ids;

            if( $this->db->update( $infos, ['id' => $id] ) ) {
                 $this->show_message( '操作成功', make_url( __M__, __C__, 'index' ) );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $id = gpc( 'id' );
        if( empty( $id ) ) $this->show_message( 'ID不能为空' );
        $infos = $this->db->get_one( '*',['id' => $id ] );

        $this->view->assign( 'infos', $infos );
        $this->view->assign('menus', $this->menus( $infos['list'] ));
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

    /*
     * 菜单
     * @param array $group 修改需要传递的数据
     * @return void(0)
     * */
    public function menus( $str = '' ) {
        $menus = $this->db_menu->select( 'menuid as id,parentid,name', '', '','sort ASC' );
        if( empty($menus) ) return false;

        $newarr = array();
        if( !empty($str) ) {
            $arr = explode( ',', $str);
            foreach( $arr as $k => $v ) {
                $newarr[$v] = $v;
            }
        }

        foreach( $menus as $k => &$v ) {
            if( $v['parentid'] == 0 ) {
                $v['open'] = 'true';
            }

            if( isset( $newarr[$v['id']] ) ) {
                $v['checked'] = 'true';
                $v['open'] = 'true';
            }
        }

        return json_encode($menus);
    }

}