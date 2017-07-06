<?php
/*
 * 路由
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */

use \heart\libs\router as router;

//设置普通路由 映射

//路由反向解析
router::normal( 'index/([\w]+)/zhuang/([\w]+)/aa/bb', function ( $action, $aa ) {
    echo $action.'==='.$aa;
    return 'index.test@mozi';
} );

//通配符目前支持 :num  :any
router::normal( 'index/test/:any', 'index.test@mozi' );
//正则
router::normal( 'index/test/([\w]+)', 'index.test@zhangliang' );
//标准字符串路由
router::normal( 'index/test/normal', 'index.test@normal' );


//restful
router::get( 'user', 'index.test@normal' );
router::post( 'user', 'index.test@post_user' );
router::put( 'user/1', function () {
    echo 'put111';
    return 'index.test@put_user';
} );
router::delete( 'user/1', 'index.test@delete_user' );
