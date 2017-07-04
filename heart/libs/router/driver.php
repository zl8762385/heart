<?php
/*
 * 路由驱动
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace heart\libs\router;

abstract class driver {

    /*
     * 返回一唯数组的URI
     * @return []
     * */
    public abstract  function get_uri();
}
