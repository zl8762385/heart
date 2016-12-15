<?php
/*
 *
 * 异常处理 主要处理 set_error_handler  register_shutdown_function set_exception_handler
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */

namespace heart\libs;
use heart\libs\log\log as log;

class error {

    static  protected $error_type = '';

    /*
     * 初始化并注册
     * */
    static public function init() {
        set_error_handler( [__CLASS__, 'error_handler'] );
        register_shutdown_function( [__CLASS__, 'shutdown_handler'] );
    }

    /*
     * 自定义异常处理
     * @return void
     * */
    static public function exception_handler( $e ) {

        self::$error_type = log::INFO;
        self::handler($e->getMessage(),$e->getLine(),$e->getFile(), $e->getCode(),'异常提示');
    }

    /*
     * 自定义错误
     * @return void
     * */
    static public function error_handler($errno, $message, $file, $line) {

        self::$error_type = log::ERROR;
        self::handler($message,$line,$file, $errno);
    }

    /*
     * 最后执行方法
     * @return void
     * */
    static public function shutdown_handler() {
        if( !is_null( $error = error_get_last() ) && self::is_fatal( $error['type'] ) ) {

            self::$error_type = log::FATAL;
            self::handler($error['message'],$error['line'],$error['file'], $error['type'],"致命错误");
        }

        //保存日志
        log::save();
    }

    /*
     * 检查错误界别是否致命
     * @param $type int 错误级别
     * @return int
     * */
    static public function is_fatal( $type ) {
        return in_array($type, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]);
    }

    /*
     * 处理错误数据
     * @param $message string 信息
     * @param $line int 行号
     * @param $file string 文件地址
     * @param $type 错误类型 数字表示,可集合对照表查看
     * @param $title string 标题
     * @return tpl
     * */
    static public function handler($message, $line, $file, $type, $title = '提示') {
        //记录日志
        log::record( [
            'msg' => $message,
            'line' => $line,
            'file' => $file,
            'type' => $type
        ], self::$error_type);

        //非DEBUG模式,不显示具体源码
        if( !APP_DEBUG ) return true;

        $arr = [];
        $arr[0] = '<div class="tips_message">信息: '.$message.'</div>';
        $arr[1] = '<div class="tips_line">行号: '.$line.'行</div>';
        $arr[2] = '<div class="tips_file">路径: '.$file.'</div>';
        //获取出错文件源码
        $source = self::get_source_code( $line, $file );
        $content = implode( "\n", $arr );

        include FRAMEWORK_PATH.'tpl/exception_error.php';
    }

    /*
     * 获取出错文件内容
     * 获取错误的前9行和后9行
     * @param $line int 错误行号
     * @param $file string 文件路径
     * @return array 错误文件内容
     */
    static public function get_source_code( $line, $file ) {
        // 读取前9行和后9行
        $first = ($line - 9 > 0) ? $line - 9 : 1;

        try {
            $contents = file( $file );
            $source   = [
                'first'  => $first,
                'source' => array_slice($contents, $first - 1, 19),
            ];
        } catch (Exception $e) {
            $source = [];
        }
        return $source;
    }
}