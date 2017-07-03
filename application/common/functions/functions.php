<?php
/*
 * 应用函数
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */

/*
 * 生成URL
 * echo make_url('admin','test','index',['id=1','pid=2']);
 *
 * @param $m string 模块
 * @param $c string 控制器
 * @param $a string 方法
 * @param $param [] 参数
 * @return string
 * */
function make_url( $m, $c, $a, $param = [] ) {
    if( empty( $m) || empty( $c ) || empty($a) ) return false;

    $domain = load_config( 'domain' );

    $param = ( empty( $param ) ) ? '' : implode( '&', $param ) ;
    if( IS_PATH_INFO ) {
        if( ( !empty( $param ) ) ) $param = '?'.$param;
        $uri = $domain."{$m}/{$c}/{$a}".$param;
    } else {
        if( ( !empty( $param ) ) ) $param = '&'.$param;
        $uri = $domain."index.php?m={$m}&c={$c}&a={$a}{$param}";
    }

    return $uri;
}

/*
 * 上传的url访问安全认证
 * */
function upload_url_safe() {
	if(empty($_SERVER['HTTP_REFERER'])) exit( '上传错误.' );//上传弹窗必然由上级页面加载
}

