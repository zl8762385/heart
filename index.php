<?php
/**
 *  index.php 入口文件
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */

if( version_compare(PHP_VERSION, '5.5.0', '<') ) die("php versions < 5.5.0");

define( 'APP_DEBUG', true);
define( 'ROOT_PATH', dirname(__FILE__).'/' );
define( 'APP_PATH', ROOT_PATH.'application/' );

//引入入口文件
require "./heart/start.php";