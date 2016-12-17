<?php
/*
 * zip解压
 *
 * using:
 * $z = new Unzip();
 * $z->unzip("./bootstrap-3.3.4.zip",'./unzipres/', true, false);
 *
 * @copyright			(C) 2016 HeartPHP
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart\utils;

class unzip{

    //html文件名称
    public $html_names = [];

    public function __construct(){
        //init code here...
        header("content-type:text/html;charset=utf8");
    }

    /*
     * 解压文件到指定目录
     *
     * @param $src_file  string   zip压缩文件的路径
     * @param $dest_dir string   解压文件的目的路径
     * @param $create_zip_name_dir  boolean  是否以压缩文件的名字创建目标文件夹
     * @param $overwrite  boolean  是否重写已经存在的文件
     * @return  boolean  返回成功 或失败
     * */
    public function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true){

        $_name = '';
        if ($zip = zip_open($src_file)){
            if ($zip){
                $splitter = ($create_zip_name_dir === true) ? "." : "/";
                if($dest_dir === false){
                    $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";
                }

                // 如果不存在 创建目标解压目录
                $this->create_dirs($dest_dir);

                // 对每个文件进行解压
                while ($zip_entry = zip_read($zip)){
                    // 文件不在根目录
                    $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
                    if ($pos_last_slash !== false){
                        // 创建目录 在末尾带 /
                        $this->create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
                    }

                    // 打开包
                    if (zip_entry_open($zip,$zip_entry,"r")){

                        // 文件名保存在磁盘上
                        $file_name = $dest_dir.zip_entry_name($zip_entry);
                        //以第一个目录为文件名
                        if( empty( $_name ) && is_dir( $file_name ) ) $_name = $file_name;

                        // 检查文件是否需要重写
                        if ($overwrite === true || $overwrite === false && !is_file($file_name)){
                            // 读取压缩文件的内容
                            $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

                            if( is_dir( $file_name ) ) continue;
                            file_put_contents($file_name, $fstream);
                            // 设置权限
                            chmod($file_name, 0777);

                            //获取html 名称
                            $this->html_names( $_name, $file_name );
//                            echo "save: ".$file_name."<br />";
                        }

                        // 关闭入口
                        zip_entry_close($zip_entry);
                    }
                }
                // 关闭压缩包
                zip_close($zip);
            }
        }else{
            return false;
        }

        if( !empty( $_name ) ) {
            $_arr = array_filter( explode( '/', $_name ) );

            return array_pop( $_arr );
        } else {
            return false;

        }
    }

    /*
     * 获取HTML 目录名称
     *
     * @param $root_path string 根目录
     * @param $names string 文件路径
     * */
    public function html_names( $root_path, $names ) {
        if( empty( $root_path ) || empty( $names ) ) return false;
        $filename = str_replace( $root_path, '', $names );

        //只要根目录文件
        if( !strpos( $filename, '/' ) && strpos( $filename, '.html' ) ) {
            $this->html_names[] = $filename;
        }
    }

    /*
     * 获取html_names
     *
     * @return []
     * */
    public function get_html_names() {
        return $this->html_names;
    }

    /*
     * 创建目录
     * */
    public function create_dirs($path){
        if (!is_dir($path)){
            $directory_path = "";
            $directories = explode("/",$path);
            array_pop($directories);

            foreach($directories as $directory){
                $directory_path .= $directory."/";
                if (!is_dir($directory_path)){
                    mkdir($directory_path);
                    chmod($directory_path, 0777);
                }
            }
        }
    }

}
