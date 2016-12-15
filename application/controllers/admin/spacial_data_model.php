<?php
/*
 * 专题数据模型
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace controllers\admin;

use models\admin_spacial_model;
use services\admin_base;

class spacial_data_model extends admin_base{

    public $db = [];
    public function __construct() {
        parent::__construct();

        $this->db = load_model( 'admin_spacial_model' );
    }

    /*
     * 数据模型列表页
     *
     * @return tpl
     * */
    public function index() {

        $where = '';
        $lists = $this->db->select_lists( '*', $where, '10', 'id ASC');

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

            if( empty( $infos['name'] ) ) $this->show_message( '请输入模型名称' );

            $infos['createtime'] = $infos['updatetime'] = time();

            if( $this->db->insert( $infos ) ) {
//                 $this->show_message( '操作成功', make_url( __M__, __C__, 'index' ) );
                $this->show_message( '操作成功' );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

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
            $id= gpc( 'id', 'P' );

            if( empty( $infos['name'] ) ) $this->show_message( '请输入模型名称' );

            $infos['updatetime'] = time();

            if( $this->db->update( $infos, ['id' => $id] ) ) {
                $this->show_message( '操作成功', make_url( __M__, __C__, 'index' ) );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $id= gpc( 'id' );
        if( empty( $id) ) $this->show_message( 'ID不能为空' );
        $infos = $this->db->get_one( '*',['id' => $id] );

        $this->view->assign( 'infos', $infos );
        $this->view->display();
    }


}