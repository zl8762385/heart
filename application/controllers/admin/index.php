<?php
/*
 * 后台
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace controllers\admin;

use services\admin_base;
use heart\utils\verify_code;

class index extends admin_base{

    public function __construct() {
        parent::__construct();

        //后台菜单
        $this->db_menu = load_model( 'admin_menu' );
    }

    /*
     * 登录首页
     * */
    public function cms() {

        $where = 'parentid=0 AND menuid in ('.$this->userinfos['role']['list'].') AND display=1';
        $this->view->assign( 'menus', $this->db_menu->select( 'menuid,name,icon', $where, '', 'sort ASC, menuid ASC' ) );
        $this->view->assign( 'db_menus', $this->db_menu );
        $this->view->assign( 'role_list_str', $this->userinfos['role']['list'] );
        $this->view->display();
    }

    /*
     * 右侧默认首页
     *
     * @return tpl
     * */
    public function right() {

        $this->view->display();
    }

    public function phpinfo() {
        phpinfo();
    }
}