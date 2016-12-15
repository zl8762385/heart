<?php
/*
 * 缓存 模板
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart\libs\cache;

abstract class driver{

    /*
     * 设置缓存
     * @param $name string 缓存变量名
     * @param $value string|array 数据
     * @param $life int 有效时间 0为永久
     * */
    abstract function set( $name, $value, $life = null );

    /*
     * 读取缓存
     * @param $name string 缓存变量名
     * @param $default string 默认值
     * @return string|array
     * */
    abstract function get( $name, $default = null );

    /*
     * 删除缓存
     * @param $name 缓存变量名
     * @return void
     * */
    abstract function rm( $name );

}

