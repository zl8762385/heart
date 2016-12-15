<?php
/*
 * admin 服务架构
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 **/
namespace services;

use heart\controller;

abstract class admin_base extends controller{

    //允许登录
    public $allow_login = [ 'login/index', 'login/code', 'login/logout' ];

    public function __construct() {
        parent::__construct();

        //模板变量赋值
        $this->tpl_assign();

        if( !in_array( __C__.'/'.__A__, $this->allow_login ) ) {
            $this->db_menus = load_model( 'admin_menu' );
            $this->db_role = load_model( 'admin_role' );

            $this->check();
        }
    }

    /*
     * 检查登录
     *
     * @return
     * */
    public function check() {
        $uid = session( 'uid' );
        if( empty( $uid ) ) $this->show_message( '登录失效', make_url( 'admin', 'login', 'index' ) );
        $db = load_model( 'admin_users' );

        $infos = $db->get_one( 'uid,username,email,truename,createtime,groupid,islock',  'uid='.$uid);
        if( empty( $infos ) ) $this->show_message( '异常登录', make_url( 'admin', 'login', 'index' ) );

        //赋值,给继承者使用
        $this->userinfos = $infos;

        //登录成功后 检查菜单权限
        $this->auth();
    }

    /*
     * 检查权限
     * @return void
     * */
    public function auth() {
        if( !$this->userinfos ) $this->show_message( '异常登录' );

        if( $this->userinfos['islock'] ) $this->logout( '账户被锁定,请联系管理员!' );

        $this->userinfos['role'] = $this->db_role->get_one( 'name,list', $this->userinfos['groupid']);

        //检查是否有访问文件的权限
        $_where = [];
        $_where[] = "model='".__M__."'";
        $_where[] = "controller='".__C__."'";
        $_where[] = "action='".__A__."'";
        $_where[] = "menuid in (".$this->userinfos['role']['list'].")";
        $where = implode( ' AND ', $_where );
        $check_file = $this->db_menus->get_one( '*', $where );
//        if( empty( $check_file ) ) $this->show_message( '没有访问权限.', make_url( 'admin', 'index', 'right' ) );

        $this->view->assign( 'userinfos', $this->userinfos );
    }

    /*
     * 后台初始化模板变量
     *
     * @return void
     * */
    public function tpl_assign(){
        $front_admin = load_config( 'front_admin' );

        $this->view->assign( 'domain', load_config( 'domain' ) );
        $this->view->assign( 'js', $front_admin['js'] );
        $this->view->assign( 'css', $front_admin['css'] );
        $this->view->assign( 'images', $front_admin['images'] );
    }

    /*
     * 信息提示
     *
     * @param $title string 操作标题
     * @param $url string URL
     * @return tpl
     * */
    public function show_message( $title, $url = '' ){
        if( empty( $title ) ) return false;

        $refer = ( isset( $_SERVER['HTTP_REFERER'] ) ) ? $_SERVER['HTTP_REFERER'] : '' ;

        $this->view->assign( 'title', $title );
        $this->view->assign( 'url', ( empty( $url ) ) ? $refer : $url );
        $this->view->display( 'public/tips' );
    }

    /*
     * 退出登录
     * @param $title string 提示标题
     * @return void
     * */
    public function logout( $title = '成功退出' ) {

        session( 'uid', null );
        session( 'username', null );
        $this->show_message( $title, make_url( __M__, 'login', 'index' ) );
    }

}
