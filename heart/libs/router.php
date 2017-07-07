<?php
/*
 * 路由
 *
 * @copyright			(C) 2016 HeartPHP
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */

/*
 *
 * 使用方法
//路由反向解析
router::normal( 'index/([\w]+)/zhuang/([\w]+)/aa/bb', function ( $action, $aa ) {
    echo $action.'==='.$aa;
    return 'index.test@mozi';
} );

//通配符目前支持 :num  :any
router::normal( 'index/test/:any', 'index.test@mozi' );
//正则
router::normal( 'index/test/([\w]+)', 'index.test@zhangliang' );
//标准字符串路由
router::normal( 'index/test/normal', 'index.test@normal' );


//restful
router::get( 'user', 'index.test@normal' );
router::post( 'user', 'index.test@post_user' );
router::put( 'user/1', function () {
    echo 'put111';
    return 'index.test@put_user';
} );
router::delete( 'user/1', 'index.test@delete_user' );
*/

namespace heart\libs;

class router {

    //路由常用方法
    public static $mehtod_arr = [ 'normal', 'get', 'post', 'delete', 'put' ];

    //注册
    public static $method = [];

    //当前路由
    public static $current = [];

    //通配符
    public static $patterns = [
        ':num' => '[0-9]+',
        ':any' => '[^/]+',
    ];

    /*
     * 初始化
     * @return void
     * */
    public static function init() {
        __include( APP_PATH.'common/router.php' );
//        $_SERVER['REQUEST_METHOD'] = 'put';
    }

    public static function __callstatic($method, $args) {
        in_array( $method, self::$mehtod_arr ) || die( '未注册['.$method.']路由静态方法' );

        //注册数据
        $_method = ( $method == 'normal' ) ? self::delimiter('get') : self::delimiter($method) ;
        self::$method[ $_method.$args[0] ][ 'method' ] = $method;
        self::$method[ $_method.$args[0] ][ 'args' ][ 'source' ] = $args[0];
        self::$method[ $_method.$args[0] ][ 'args' ][ 'target' ] = $args[1];
    }

    /*
     * 分隔符 method_router
     * @param $method string get,post,put.......
     * @param $str string 分隔符
     * @return string
     * */
    public static function delimiter( $method, $str = '___' ) {
        return $method.$str;
    }

    /*
     * 当前URI,去掉/
     * @return string
     * */
    public static function current_uri() {
        $uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
        $method = self::delimiter( self::current_method() );

        return $method.substr( $uri,1, strlen( $uri ) );
    }

    /*
     * 当前请求method
     * @return string
     * */
    public static function current_method() {
        return strtolower( $_SERVER['REQUEST_METHOD'] );
    }

    /*
     * 匹配到当前路由
     * @return []
     * */
    public static function match_router() {
        $lst = self::$method;
        $uri = self::current_uri();

        //第一次键查找
        if( isset( $lst[ $uri ] ) ) return $lst[ $uri ];

        //匹配通配符
        if( $data = self::pattern_handler( $lst ) ) return $data;

    }

    /*
     * 通配符/正则 匹配处理
     * @param $data [] 路由数据
     * @return []
     * */
    public static function pattern_handler( Array &$data ){
        $match = array_keys( self::$patterns );
        $pattern = array_values( self::$patterns );
        $uri = self::current_uri();

        foreach( $data as $source => &$value ) {
//            if( !strpos( $source, ':' ) ) continue;

            $_source = str_replace( $match, $pattern, $source );
            $_source = str_replace( '/', '\/', $_source );
//            echo $_source.'===='.$uri."<br/>\n";

            //查找匹配数据,找到直接返回.
            if( preg_match( '/^'.$_source.'$/', $uri, $m ) ) {
                unset( $m[0] );
                $value['args']['params'] = array_values( $m );
                return $value;
            }
        }

    }

    /*
     * 拆分router目标uri
     * 例: target = module.controller@action
     * @param $router [] 路由
     * @return []
     * */
    public static function target_uri( Array $router ) {
        $target = ( isset( $router[ 'args' ][ 'target' ] ) ) ? $router[ 'args' ][ 'target' ] : '' ;

        return self::uri_handler( $router[ 'args' ] );
    }

    /*
     * 对目标URI拆分处理,如果遇到闭包做相应处理
     * @param $uri string module.controller@action
     * */
    public static function uri_handler( $data ) {
        if( empty( $data ) ) return '';

//        if( is_callable($data) ) exit('是闭包函数,不执行了');
        $uri = $data['target'];
        if( is_callable( $data['target'] ) ) {
            $uri = call_user_func_array(
                $data['target'],
                ( isset( $data['params'] ) && !empty( $data['params'] ) ) ? $data['params'] : []
            );
        }

        $arr = explode( '.', $uri );
        list( $controller, $action ) = explode( '@', $arr[1] );

        $data = [];
        $data['module'] = $arr[0];
        $data['controller'] = $controller;
        $data['action'] = $action;

        return $data;
    }

    /*
     * 执行路由调度
     * @return exec
     * */
    public static function dispatch() {
        $current = self::match_router();
        $router = ( $current ) ? self::target_uri( $current ) : [] ;

        return $router;
    }

}
