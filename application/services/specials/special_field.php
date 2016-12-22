<?php
/*
 * 专题模型 字段
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 **/
namespace services\specials;

use heart\controller;

class special_field extends controller {
    public function __construct() {
    }

    /*
     * 字段列表
     *
     * @return []
     * */
    public function field_list() {
         return [
            'text' => '单行文本',
            'textarea' => '多行文本',
            'editor' => '编辑器',
            'image' => '图片 - 带预览',
            'images' => '多图片',
            'files' => '多文件上传',
            'datetime' => '日期和时间'
        ];
    }

}

