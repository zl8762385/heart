<?php
namespace controllers\group;

use heart\controller;
use heart\libs\error_exception;
use heart\libs\log\log as log;

class topic extends controller{
    public function test() {

        $this->view->assign( 'title', "我是title" );
        $this->view->assign( 'content', "我是content" );
        $this->view->display();
    }
    public function index() {

//        print_r(load_config());
        $data = array ('name' => 'abc', 'job' => 'programmer','a'=>array('aa','cc','bb'));
        $data = var_export($data,TRUE);
        echo $data;
//        log::record(111);
//        log::record(222, log::DEBUG);
//        log::record(2233, log::DEBUG);
//        log::record(2244, log::DEBUG);

//        $test = new \controllers\index\test();
//        $test->index();
//        echo 'topic default test index';
//        $c = load_config('log');
//        print_r($c);
//        echo 'bbb';
//        echo $test;
//        echo $test1;
//        echo 'aaa';
//        throw new error_exception( '111' );
    }
}