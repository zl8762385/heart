<?php
/*
 * 角色管理
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 **/
namespace models;

use heart\model as model;

class admin_role extends model{

    //表名
    public $name = 'admin_role';

    //前缀
    public $prefix = 'heart_';

    //配置选项
    public $db_setting = 'db';

    public function __construct() {
        parent::__construct();
    }
}