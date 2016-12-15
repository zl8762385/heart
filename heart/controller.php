<?php
/*
 * 控制器基类
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart;

abstract class controller {
    //视图指针
    protected $view = '';

    public function __construct() {
        //视图
        $this->view = new \heart\view();
    }

}
