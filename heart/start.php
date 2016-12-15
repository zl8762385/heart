<?php
/**
 *  heart.php 公共入口方向
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
header('Content-Type: text/html; charset=utf-8');

$GLOBALS = array();

//清除时差
date_default_timezone_set("PRC");

const HEART_VERSION = "3.0";

const EXT = ".php";

//系统常量
defined( 'DS' ) or define( 'DS', DIRECTORY_SEPARATOR );
defined( 'ROOT_PATH' ) OR define( 'ROOT_PATH', dirname(__DIR__).DS );
defined( 'FRAMEWORK_PATH' ) OR define( "FRAMEWORK_PATH", substr( __DIR__, 0, -5).'heart'.DS );
defined( 'APP_PATH' ) OR define( "APP_PATH", dirname( $_SERVER['SCRIPT_FILENAME'] ).'/application'. DS );
defined( 'REQUEST_METHOD' ) OR define( "REQUEST_METHOD", !isset($_SERVER['REQUEST_METHOD']) ?: $_SERVER['REQUEST_METHOD'] );
defined( 'LOG_PATH' ) OR define( 'LOG_PATH', ROOT_PATH.'runtime'.DS.'log'.DS );

//系统信息
defined( "IS_CLI" ) OR define( "IS_CLI", PHP_SAPI == 'cli' ? 1 : 0  );

require_once FRAMEWORK_PATH."libs/heart".EXT;
\heart\libs\heart::init();