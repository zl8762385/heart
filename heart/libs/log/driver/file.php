<?php
/*
 * 日志写入操作
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */

namespace heart\libs\log\driver;

class file {
    protected $config = [];
    public function __construct() {
        $this->config = load_config( 'log' );


    }

    /*
     * 写入日志
     * @param $infos array  [
            'msg' => $message,
            'line' => $line,
            'file' => $file,
            'type' => $type
        ]
     *
     * */
    public function write( $infos ) {
        $now = date( 'Y.m.d H:i:s' );
        $type = ( $this->config['partition']['enabled'] ) ? $this->config['partition']['type'] : 'day' ;
        $date = ( $type == 'day' ) ? date('Ymd') : date('Ymd').DS.date('H') ;
        $files = $this->config['path'].$date.'.log';

        $path = dirname( $files );
        !is_dir($path) && mkdir( $path, 0755, true );

        // 获取基本信息
        if (isset($_SERVER['HTTP_HOST'])) {
            $current_uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else {
            $current_uri = "cmd:" . implode(' ', $_SERVER['argv']);
        }

        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'CLI';
        $remote = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';

        foreach( $infos as $k => $v ) {
            foreach( $v as $_k => $_v ) {

                $in_arr = array( 'info', 'debug' );
                //处理系统级别错误
                if( in_array( $k, $in_arr ) || !is_array( $_v ) ) {
                    //手动记录
                    if( is_array( $_v ) ) $_v = json_encode( $_v );

                    $str = "[$k] $_v \r\n";
                } else {
                    //自动记录
                    $str = "[$k] [{$now}] [{$_v['msg']}] [{$_v['line']}行] [{$_v['file']}] [$method] [$current_uri|$remote]\r\n";
                }

                error_log( $str , 3, $files );
            }
        }
    }
}
