<?php
/*
 * 后台登录
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace controllers\admin;

use services\admin_base;
use heart\utils\verify_code;

class login extends admin_base{

    public function __construct() {
        parent::__construct();

        //后台菜单
        $this->db_menu = load_model( 'admin_menu' );
        $this->db_users = load_model( 'admin_users' );
    }

    /*
     * 登录
     *
     * @return tpl
     * */
    public function index() {
        if( gpc( 'dosubmit', 'P' ) ) {
            $username = gpc( 'username', 'P' );
            $password = gpc( 'password', 'P' );
            $code = gpc( 'checkcode', 'P' );

            if( empty( $username ) ) $this->show_message( '请输入用户名!' );
            if( empty( $password ) ) $this->show_message( '请输入密码!' );
            if( empty( $code ) ) $this->show_message( '请输入验证码!' );

            if( !( new verify_code() )->check( $code ) ) {
                $this->show_message( '验证码错误', '' );
            }

            $infos = $this->db_users->get_one( 'uid,username,password,encrypt', "username='{$username}'" );
            if( empty( $infos ) ) $this->show_message( '用户不存在.' );

            if( $infos['password'] != password( $password, $infos['encrypt'] ) ) {
                $this->show_message( '密码错误.' );
            }

            session( 'uid', $infos['uid'] );
            session( 'username', $infos['username'] );

            $this->show_message( '登录成功', make_url( 'admin', 'index', 'cms' ) );
        }

        $this->view->display();
    }

    /*
     * 验证码
     *
     * @return void
     * */
    public function code(){
        $config = array(
            'fontSize' => 16,    // 验证码字体大小
            'imageW' =>  117,    // 验证码图片宽度
            'imageH' =>  30,     // 验证码图片高度
            'length' => 4,       // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
            'useCurve' => false,
            'fontttf' => '6.ttf',
        );

        ( new verify_code( $config ) )->entry();
    }

}