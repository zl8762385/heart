<?php
namespace controllers\index;

use heart\controller;
use heart\libs\log\log as log;


class test extends controller {

    //缓存使用集合
    public function cache() {
//        cache( 'test_redis', '12345');
//        echo cache( 'test_redis' );
//        cache( 'test_redis', false, 60);
//        cache( 'test1', 'zhangliang' );
//        cache( 'test3', 'zhangliang' );
    }

    //模板
    public function tpl() {
        $title = "我是标题";
        $arr = ['aa', 'bb', 'cc', 'dd', 'ee'];

        $this->view->assign( "title", $title );
        $this->view->assign( "content", "内容数据" );
        $this->view->assign( "arr", $arr );
//        $this->view->display( 'public/header' );
        $this->view->display();
    }

    //数据库
    public function index() {
//        echo 'default test index,controller';

//        load_model( 'role' )->insert(
//            [ 'name' => 'zhangliang', 'age' =>23 ]
//        );

//        load_model( 'role' )->update(
//            [ 'age' =>21 ],
//            "id=2"
//        );
//        load_model( 'role' )->delete(
//            "id=2"
//        );

//        $data = load_model( 'role' )->select( '*' );
//        print_r( $data );
//        $data = load_model( 'role' )->get_one( '*', "id=8" );
//        print_r( $data );
//        echo load_model('role')->check_table_exists( 'heart_menu' );

        $db = load_model( 'role' );
        $data = $db->select_lists( '*', "", '1' );
        echo $db->page;
        print_r( $data );


//        load_model( 'role' )->insert(
//            [ 'name' => 'zhangliang', 'age' =>24 ]
//        );
//        $data = load_model('role')->insert_id();
//        print_r( $data );

//        echo load_model('role')->last_query_sql();
//        load_model( 'role' )->select_page();


//use heart\libs\error_exception;
//        throw new error_exception('cuowule');
    }
}