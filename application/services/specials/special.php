<?php
/*
 * 专题
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 **/
namespace services\specials;

use heart\controller;

class special extends controller {
    public function __construct() {
        $this->domain = load_config( 'domain' );
    }

    /*
     * 生成XML文件
     * @param $files string 路径
     * @param $data [] 数组
     * @return 生成xml and php文件
     * */
    public function make_xml( $files, $data ) {

        //当前路径
        $current_page = str_replace( ROOT_PATH, '', $files );

        if( !isset( $data['infos']['_files'] ) || !is_array( $data['infos']['_files'] ) ) return false;
        //遍历 获取html

        $page_html = '';
        foreach( $data['infos']['_files'] as $k => $v ) {
            $path = $files.$v;
            $html = file_get_contents( $path );

            $page_node = explode( '.', $v );
            $this->replace_text( $current_page, $html );

            $page_html .=<<<HTML
<page_{$page_node[0]}  page="{$v}">
    <![CDATA[
        {$html}
    ]]>
</page_{$page_node[0]}>
HTML;
        }

        //批量替换链接

        $xml =<<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<root>
    <head>
        <title>{$data['infos']['name']}</title>
        <files>{$data['infos']['files']}</files>
        <english_title>{$data['infos']['directory']}</english_title>
        <root_path>{$current_page}</root_path>
        <createtime>{$data['infos']['createtime']}</createtime>
    </head>
    <body>
        {$page_html}
    </body>
</root>
EOF;

        $filename = $files.$data['infos']['directory'];
        //生成XML
        write_files($filename.'.xml', $xml);
        return true;
    }

    /*
     * 正则替换src href link内容,增加当前链接
     * @param $path string 当前相对目录路径
     * @param $html string html代码
     * @return void
     * */
    public function replace_text($path, &$html) {
        $html = preg_replace( '/src=[\'"](?!http|https:\/\/)(.*?)[\'"]/i', 'src="'.$this->domain.$path.'$1"', $html );
        $html = preg_replace( '/<link(.*?)href=[\'"](?!http|https:\/\/)(.*?)[\'"]/i', '<link$1 href="'.$this->domain.$path.'$2"', $html );
    }
}

