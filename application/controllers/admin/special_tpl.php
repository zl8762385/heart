<?php
/*
 * 专题模板
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace controllers\admin;

use services\admin_base;

class special_tpl extends admin_base{

    public $db = [];
    public function __construct() {
        parent::__construct();

        //专题模型
        $this->db = load_model( 'admin_special_model' );

        //专题
        $this->db_special = load_model( 'admin_special' );

        //special目录
        $this->special_path = ROOT_PATH.'resource/special/';

    }

    /*
     * 查看模板
     *
     * @return tpl
     * */
    public function view() {
        if( gpc( 'dosubmit', 'P' ) ) {
            $page_tpl = gpc( 'page_tpl', 'P' );
            $page_node = gpc( 'page_node', 'P' );
            $content = gpc( 'newcontent', 'P' );

            if( empty( $page_tpl ) ) $this->show_message( '模板路径不对.' );
            $content = htmlspecialchars_decode( $content );

            //修改XML数据
            $xml_obj = simplexml_load_file( $page_tpl );
            $xml_obj->body->{$page_node} = $content;
            $xml_obj->asXML( $page_tpl );

            $this->show_message( '模板保存成功.' );
        }


        $id = gpc( 'id' );
        $page_url = gpc( 'page_url' );
        if( empty( $id ) ) $this->show_message( '请求错误.' );

        $infos = $this->db_special->get_one( 'id,name,directory,files', [ 'id' => $id ] );
        $page_tpl = $this->special_path.$infos['directory'].'/'.$infos['directory'].'.xml';

        $xml_obj = simplexml_load_file( $page_tpl, 'SimpleXMLElement', LIBXML_NOCDATA);
        if( !$xml_obj ) $this->show_message( $page_tpl.'<br/>模板解析失败.' );
        $files = explode( ',', $infos['files'] );


        //取出第一个文件
        $page_url = ( !empty( $page_url ) ) ? $page_url : $files[0] ;
        $node_name = strstr( $page_url, '.', true );
        $method = 'page_'.$node_name;
        $content = htmlspecialchars( trim( $xml_obj->body->{$method} ) );

        $this->view->assign( 'content', $content );
        $this->view->assign( 'page_tpl', $page_tpl );
        $this->view->assign( 'page_url', $page_url);
        $this->view->assign( 'files', $files);
        $this->view->assign( 'id', $id);
        $this->view->assign( 'head', $xml_obj->head);
        //页面节点
        $this->view->assign( 'page_node', $method);
        $this->view->display( 'special/view' );
    }

}