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

use services\specials\special_field;
use services\admin_base;

class special_data_model extends admin_base{

    public $db = [];
    public function __construct() {
        parent::__construct();

        //专题模型
        $this->db = load_model( 'admin_special_model' );

        //专题
        $this->db_special = load_model( 'admin_special' );

        //模型字段
        $this->_filed = new special_field();
    }

    /*
     * 数据模型列表页
     *
     * @return tpl
     * */
    public function index() {
        $sid = gpc( 'sid' );
        $_where = $special_infos = [];

        if( !empty( $sid ) ) {
            $special_infos = $this->db_special->get_one( 'id,name', [ 'id' => $sid ] );
            $_where[] = 'sid='.$sid;
        } else {
            //sid = 0 属于公共模型部分
            $_where[] = 'sid=0';

        }


        $where = implode( ' AND ', $_where );

        $lists = $this->db->select_lists( '*', $where, '10', 'id ASC');

        $this->view->assign( 'page', $this->db->page );
        //专题信息
        $this->view->assign( 'special_infos', $special_infos );
        $this->view->assign( 'sid', ( $sid ) ? $sid : 0 );
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

        $sid = gpc( 'sid' );
        $spcial_infos = [];
        if( !empty( $sid ) ) {
            $spcial_infos = $this->db_special->get_one( 'id,name', [ 'id' => $sid ] );
        }

        $this->view->assign( 'special_infos', $spcial_infos );
        $this->view->assign( 'sid', ( !empty( $sid ) ) ? $sid : 0 );
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
                $sid = ( isset( $infos['sid'] ) ) ? $infos['sid'] : 0 ;
                $this->show_message( '操作成功', make_url( __M__, __C__, 'index', [ 'sid='.$sid ] ) );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $id= gpc( 'id' );

        if( empty( $id) ) $this->show_message( 'ID不能为空' );
        //模型数据
        $infos = $this->db->get_one( '*',['id' => $id] );

        //专题相关信息
        $spcial_infos = [];
        if( !empty( $infos['sid'] ) ) {
            $spcial_infos = $this->db_special->get_one( 'id,name', [ 'id' => $infos['sid'] ] );
        }

        $this->view->assign( 'infos', $infos );
        $this->view->assign( 'special_infos', $spcial_infos );
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

    /*
     * 添加模型字段
     *
     * @return
     * */
    public function add_field() {
        if( gpc( 'dosubmit', 'P' ) ) {
            $infos = gpc( 'infos', 'P' );
            $model_id = gpc( 'model_id', 'P' );

            if( empty( $infos ) ) $this->show_message( '操作失败,请联系管理员.' );

            $rs = $this->db->get_one( 'id,field', [ 'id' => $model_id ] );

            $infos['createtime'] = $infos['updatetime'] = time();


            if( !empty( $infos ) ) {
                foreach( $infos as $k => &$v ) {
                    $v = urlencode( $v );
                }
            }

            if( empty( $rs['field'] ) ) {
                $data = json_encode( [ $infos ] );
            } else {
                $data = json_decode( $rs['field'], true );
                array_push( $data, $infos);
                $data = json_encode( $data );
            }

            if( $this->db->update( [ 'field' => $data ], ['id' => $model_id] ) ) {
                $this->show_message( '操作成功', make_url( __M__, __C__, 'index_field', [ 'id='.$model_id ] ) );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $id = gpc( 'id' );
        if( empty( $id ) ) $this->show_message( 'ID不能为空' );
        $infos = $this->db->get_one( 'id,name', 'id='.$id );

        $this->view->assign( 'id', $id);
        $this->view->assign( 'field_list', $this->_filed->field_list());
        $this->view->assign( 'name', $infos['name']);
        $this->view->display();
    }

    /*
     * 模型字段列表
     *
     * @return
     * */
    public function index_field() {
        $id = gpc( 'id' );
        if( empty( $id ) ) $this->show_message( 'ID不能为空' );

        $infos = $this->db->get_one( 'id,name,field', 'id='.$id );

        $lists = [];
        if( isset( $infos['field'] ) && !empty( $infos['field'] ) ) {
            $lists = json_decode( $infos['field'], true );
        }

        $this->view->assign( 'name', $infos['name']);
        $this->view->assign( 'lists', $lists);
        $this->view->assign( 'refer', ( isset( $_SERVER['HTTP_REFERER'] ) ) ? $_SERVER['HTTP_REFERER'] : '' );
        $this->view->assign( 'id', $id);
        $this->view->display();
    }


    /*
     * 删除字段
     *
     * @return 1:0
     * */
    public function del_field() {
        $id = gpc( 'id' );
        $k = gpc( 'k' );
        if( empty( $id ) || $k =='' ) $this->show_message( '删除失败[0].' );

        $infos = $this->db->get_one( 'id,field', [ 'id' => $id ] );
        if( empty( $infos ) ) $this->show_message( '删除失败[1].' );

        $infos['field'] = json_decode( $infos['field'], true );
        unset( $infos['field'][$k], $infos['id'] );
        $infos['field'] = json_encode( $infos['field'] );



        echo ( $this->db->update( $infos, ['id'=>$id] ) ) ? 1 : 0 ;
    }

    /*
     * 添加模型字段
     *
     * @return
     * */
    public function edit_field() {
        if( gpc( 'dosubmit', 'P' ) ) {
            $infos = gpc( 'infos', 'P' );
            $model_id = gpc( 'model_id', 'P' );
            $field_k = gpc( 'field_k', 'P' );

            if( empty( $infos ) ) $this->show_message( '操作失败,请联系管理员.' );

            $rs = $this->db->get_one( 'id,field', [ 'id' => $model_id ] );

            $infos['createtime'] = $infos['updatetime'] = time();


            if( !empty( $infos ) ) {
                foreach( $infos as $k => &$v ) {
                    $v = urlencode( $v );
                }
            }


            if( empty( $rs['field'] ) ) {
                $data = json_encode( [ $infos ] );
            } else {
                $data = json_decode( $rs['field'], true );
                $data[ $field_k ] = $infos;
                $data = json_encode( $data );
            }

            if( $this->db->update( [ 'field' => $data ], ['id' => $model_id] ) ) {
                $this->show_message( '操作成功', make_url( __M__, __C__, 'index_field', [ 'id='.$model_id ] ) );
            } else {
                $this->show_message( '操作失败,请联系管理员.' );
            }
        }

        $id = gpc( 'id' );
        $field_k = gpc( 'k' );
        if( empty( $id ) || $field_k == '' ) $this->show_message( '获取失败[0]' );
        $infos = $this->db->get_one( 'id,name,field', 'id='.$id );

        $_infos = [];
        if( isset( $infos['field'] ) && !empty( $infos['field'] ) ) {
            $_infos = json_decode( $infos['field'], true );
            $_infos = $_infos[$field_k];

            foreach( $_infos as $k => &$v ) {
                $v = urldecode( $v );
            }
        }

        $this->view->assign( 'id', $id);
        $this->view->assign( 'field_list', $this->_filed->field_list());
        $this->view->assign( 'name', $infos['name']);
        $this->view->assign( 'infos', $_infos);
        $this->view->assign( 'field_k', $field_k);
        $this->view->display();
    }

}