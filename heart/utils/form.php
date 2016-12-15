<?php
/*
 * form组件
 *
 * @copyright			(C) 2016 HeartPHP
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart\utils;

class form {

    /*
     * 文件上传2，支持更多参数设置
     * form::attachment('' ,1 , 'infos[files]', '', '', false) 单个文件  带图片预览
     * form::attachment('zip,doc,docs' ,3 , 'infos[fujian]')  多个文件 没预览
     * @param string $ext         允许的文件扩展名
     * @param int $limit          数据限制
     * @param string $formname    表单字段名
     * @param string $default_val 默认值
     * @param string $callback    回调js函数名
     * @param bool $is_thumb      是否为缩略图,这里需要直接显示缩略图片
     * @param string $width       图像宽度
     * @param string $height      图像高度
     * @param int $cut            是否裁剪
     * @return string
     * */
    public static function attachment($ext = 'png|jpg|gif|doc|docx', $limit = 1, $formname = 'file', $default_val = '', $callback = 'callback_thumb_dialog', $is_thumb = 1, $width = '', $height = '', $cut = 0,$is_water = false,$is_allow_show_img=false,$ext_code = ''){

        if ($ext == '') $ext = 'png|jpg|gif';

        if(strpos($formname,'][')===false) {
            $id = preg_match("/\[(.*)\]/", $formname, $m) ? $m[1] : $formname;
        } else {
            $_GET['attr_id'] = $_GET['attr_id'] ? $_GET['attr_id']+1 : 1;
            $pos = strpos($formname,'[');
            $id = substr($formname,0,$pos).$_GET['attr_id'];
        }

        $_js = load_config( 'domain' ).load_config( 'front_admin' )['js'];
        $_images = load_config( 'domain' ).load_config( 'front_admin' )['images'];
        $_KEY = load_config( 'public_key' );

        $str = '';
        if (!defined('PUPLOAD_INIT')) {
            define('PUPLOAD_INIT', TRUE);
            $str = '<script src="' . $_js . 'dialog/dialog-plus.js"></script>';
            $str .= '<script type="text/javascript" src="' . $_js . 'json2.js"></script>';
            $str .= '<script type="text/javascript" src="' . $_js . 'html5upload/plupload.full.min.js"></script>';
            $str .= '<script type="text/javascript" src="' . $_js . 'html5upload/extension.js"></script>';
        }
        $limit = $limit ? $limit : 1;

        $token = md5($ext . $_KEY);

        //$limit=1 显示缩略图预览
        if ($limit == 1) {
            //========================================单个文件
            if ($is_thumb) {
                $input_type = 'hidden';
                $default_thumb = $default_val ? $default_val : $_images . 'upload-thumb.png';
                $thumb_w = $width ? $width : '200';
                $thumb_h = $height ? $height : '113';
                $style = "max-width:".$thumb_w."px;";
                $style .= "max-height:".$thumb_h."px;";
                $str .= '<img class="attachment_thumb" id="' . $id . '_thumb" src="' . $default_thumb . '" onclick="img_view(this.src);"  style="' . $style . '"  />';
            } else {
                $input_type = 'text';
            }

            $str .= '<input type="' . $input_type . '" value="' . $default_val . '" class="form-control" id="' . $id . '" name="' . $formname . '" size="100" '.$ext_code.' placeholder="允许上传的后缀：'.str_replace('|','、',$ext).'" />';

            $up_url = make_url( 'admin', 'attachment', 'upload_dialog', ["callback=$callback", "htmlid=$id", "_su=", "limit=$limit","is_thumb=$is_thumb","width=$width","height=$height","htmlname=$formname","ext=$ext","token=$token","cut=$cut","is_water=$is_water","is_allow_show_img=$is_allow_show_img"] );

            $str .= '<span class="input-group-btn"><button type="button" class="btn btn-white" onclick="openiframe(\'' . $up_url . '\',\'' . $id . '\',\'loading...\',810,315,' . $limit . ')">上传文件</button></span>';

        } else {
            //========================================多文件上传,需要借助回调生成多个框

            $callback = "callback_more_dialog_files";

            $str .= "<div id='{$id}' class='attaclist'>";
                $str .= '<ul></ul>';

                $up_url = make_url( 'admin', 'attachment', 'upload_dialog', ["callback=$callback", "htmlid=$id", "_su=", "limit=$limit","is_thumb=$is_thumb","width=$width","height=$height","htmlname=$formname","ext=$ext","token=$token","cut=$cut","is_water=$is_water","is_allow_show_img=$is_allow_show_img"] );

                $str .= '<span class="input-group-btn"><button type="button" class="btn btn-white" onclick="openiframe(\'' . $up_url . '\',\'' . $id . '\',\'loading...\',810,315,' . $limit . ')">上传文件</button></span>';

            $str .='</div>';

        }

        return $str;
    }
}
