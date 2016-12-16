<?php
/*
 * 系统函数库
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */


/*
 * 导入文件
 * @param string $files 文件完整路径
 * @return array|string
 * */
function __include( $files = '' ) {
    return ( !is_file( $files ) ) ? [] : include $files ;
}

/*
 * 获取数据模型
 * @param string $name 数据名称: 例1:user.user_admin 例2:user_admin
 * @return object
 * */
function load_model( $name ) {
    if( empty( $name ) ) return false;

    static $_db = [];

    $files = $name;
    if( strstr( $name, '.') ) $files = str_replace( '.', '\\', $name );

    $models = '\\'.load_config('directory_model').'\\'.$files;

    if( !isset( $_db[ $models ] ) ) {
        $_db[ $models ] = new $models();
    }

    return $_db[ $models ];
}

/*
 * 缓存
 * @param $k string 缓存变量名
 * @param $v string|array 缓存值
 * @param $life int 生命周期
 * @return string|array|int
 * */
function cache( $k, $v = '', $life = 0) {
    if( empty($k) ) return false;

    static $_cache = [];
    $type = load_config( 'cache' )['type'];

    $class = "\\heart\\libs\\cache\\driver\\{$type}";
    if( !isset( $_cache[ $type ] ) ) $_cache[$type] = new $class();
    $_instance = $_cache[ $type ];

    if( !empty( $k ) && !empty( $v ) ) {

        //设置缓存
        return $_instance->set( $k, $v, $life );
    } else if( !empty( $k ) && $v === '') {

        //获取缓存
        return $_instance->get( $k );
    } else if( !empty( $k ) && !$v ) {

        //删除缓存
        if( $life > 0 ) {
            return $_instance->rm( $k, $life );
        } else {
            return $_instance->rm( $k );
        }
    }

    //删除所有缓存（只针对文件缓存,暂时不开放,如有需要自行开放）
//    $_instance->rm_all();
}

/*
 * 获取配置文件
 * @param $key string 键值
 * @param $file string 文件路径
 * @return array|string
 * */
function load_config( $key = '', $file = '' ) {
    static $_CONF = [];

    if( !empty($_CONF[$file]) ) {
        if( empty($key) ) {
           return ( isset( $_CONF[$file] ) ) ? $_CONF[$file] : [] ;
        } else {
           return ( isset( $_CONF[$file][$key] ) ) ? $_CONF[$file][$key] : [] ;
        }
    }

    if( !empty($file) ) {
        $_CONF[ $file ] = __include( $file );
    } else {
        $app_path = APP_PATH.'common'.DS;
        $app_config = __include( $app_path.'config'.EXT );
        $sys_config = __include( FRAMEWORK_PATH.'config'.EXT );
        $data = array_merge( $sys_config, $app_config );

        if( isset( $data['ext_config'] ) && !empty( $data['ext_config'] ) ) {
            $ext_arr = explode( ',', $data['ext_config'] );
            foreach( $ext_arr as $k => $v ) {
                $data = array_merge( $data, __include( $app_path.$v.EXT ) );
            }
        }

        $_CONF[$file] = $data;
    }

    return ( empty($key) ) ? $_CONF[$file] : $_CONF[$file][$key] ;
}

/*
 * 综合过滤 POST GET COOKIE SESSION COOKIE通过这个可以进行安全过滤
 * @param $name string 变量名称
 * @param $type string 类型 G,P,C,R,S
 * @return void
 * */
function gpc($name, $type = 'G') {
    $vars = array();
    switch($type) {
        case 'G':
            $vars = &$_GET;
            break;
        case 'P':
            $vars = &$_POST;
            break;
        case 'C':
            $vars = &$_COOKIE;
            break;
        case 'R':
            $vars = isset($_GET[$name]) ? $_GET : (isset($_POST[$name]) ? $_POST : $_COOKIE);
            break;
        case 'S':
            $vars = &$_SESSION;
            break;
    }

    //数组批量获取参数 array(id, name, age)
    if(is_array( $name ) && !empty( $name )) {

        $rt = [];
        foreach($name as $k => $v) {
            if( !isset( $vars[ $v ] ) ) continue;

            $rt[$v] = safefilter($vars[$v]);
        }

        return $rt;
    } elseif(isset($vars[ $name ]) && is_array($vars[ $name ])) {

        foreach($vars[ $name ] as $vk => $vv) {
            $vars[ $name ][$vk] = (!empty($vv)) ? safefilter($vv) : '' ;
        }

        return $vars[ $name ];
    } elseif( isset( $vars[ $name ] ) ) {
        return $vars[ $name ];
    }
}

/*
 * 安全:XSS工具
 * @param string str 字符串
 * @return string
 * */
function removexss($str){
    $farr = array(
        "/\\s+/",
        "/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
    );
    $str = preg_replace($farr,"",$str);
    return addslashes($str);
}

/*
 * 安全过滤
 *
 * @param string $value 内容
 * @return string
 * */
function safefilter( $value ) {
    if( is_array( $value ) ) {
        //不递归执行了,影响性能,太深的数组直接过滤,需要的自己搞下
        return $value;
    } else {
        $value = trim( $value );
        $value = removexss( $value );
    }

    return $value;
}

/*
 * 双向加密
 * @param $string： 明文 或 密文
 * @param $operation：DECODE表示解密,其它表示加密
 * @param $key： 如果没有传密钥参数 默认是HEARTPHP_KEY
 * @param $expiry：密文有效期
 * */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;	// 随机密钥长度 取值 0-32;
	// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
	// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
	// 当此值为 0 时，则不产生随机密钥

	$key = md5($key ? $key : load_config( "config", 'COOKIE_PWD' ));
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

/*
 * session回话管理
 *
 * @param $name string|array 键值,字符串或者数组,如是数组就进行数据初始化 执行session_start等操作
 * @param $value string 数据
 * @return void
 * */
function session( $name, $value = '' ) {

    static $_INS = [];

    $file = '\heart\libs\session\driver';
    if( !isset( $_INS[ $file ] ) ) $_INS[ $file ] = new $file();
    $_instance = $_INS[ $file ];

    if( is_array( $name ) ) {
        //初始化

        $_instance->start( $name );
    } elseif ( !empty( $name ) && !empty( $value ) ) {
        //设置

        $_instance->set( $name, $value );
    } elseif( !empty( $name ) && $value === '' ) {
        //获取

        return $_instance->get( $name );
    } elseif( !empty( $name ) && !$value ) {
        //删除

        return $_instance->rm( $name );
    }

}

/*
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 * */
function password($password, $encrypt='') {
    $pwd = array();
    $pwd['encrypt'] =  $encrypt ? $encrypt : create_randomstr();
    $pwd['password'] = md5(md5(trim($password)).$pwd['encrypt']);
    return $encrypt ? $pwd['password'] : $pwd;
}

/*
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 * */
function create_randomstr($lenth = 6) {
    return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

/*
 * 产生随机字符串
 *
 * @param    int        $length  输出长度
 * @param    string     $chars   可选的 ，默认为 0123456789
 * @return   string     字符串
 * */
function random($length, $chars = '0123456789') {
    $hash = '';
    $max = strlen ( $chars ) - 1;
    for($i = 0; $i < $length; $i ++) {
        $hash .= $chars [mt_rand ( 0, $max )];
    }
    return $hash;
}

/*
 * 单纯写入文件
 * @param string $files 文件全路径
 * @param string $content 内容
 * @return void
 * */
function write_files( $files, $content ) {
    if( empty( $files ) || empty($content) ) throw new \heart\libs\error_exception( '写入文件和内容不能为空.' );

    if( ($ob = @fopen( $files, 'wb+' )) === false )  throw new \heart\libs\error_exception( pathinfo( $files )['basename']."写入失败." );

    //开启flock
    flock( $ob, LOCK_EX + LOCK_NB );
    fwrite( $ob, $content, strlen($content) );
    flock( $ob, LOCK_UN + LOCK_NB );
    fclose( $ob );
}


/*
 * tpl方法: include
 *
 * 用例:<?=tpl_include( 'public/header',['id'=>1,'pid'=>22] );?>
 * @param $name string 模板变量
 * @param $params [] 给模板传递参数 [ 'id' => 1, 'pid' => 22 ]
 * */
function tpl_include( $template_name, $params = [] ) {
    if( empty( $template_name ) ) return null;
    extract( $GLOBALS['tpl_data'] );

    if( !empty( $params ) ) extract( $params );

    include( $GLOBALS['tpl_module'].$template_name.EXT );

    //使用过的变量直接注销
    unset( $GLOBALS['tpl_data'], $GLOBALS['tpl_module'] );
    return null;
}


























/*
 * 获取控制器对象 C = controller
 * 调用方式C('模块完整路径')
 *
 * 例1:C('index') = controllers/index.class.php
 * 例2:C('admin\index') = controllers/admin/index.class.php
 * 例3:C( 'admin\index' )->zhangliang();
 * 很多框架模块下有libs类包,可以这样访问: C('content\libs\html')->init('init张亮');
 *
 * @param string $names 文件名称
 * @return object
 * */
function C( $names ) {
    if( empty($names) ) error(" C:请输入控制器名称和模块完整路径! ");

    static $_C = array();

    if( isset( $_C[ $names ] ) ) {
        return $_C[ $names ];
    } else {
        $app_namespace = load_config( 'convention', 'APP_USE_NAMESPACE', 1 );
        $app_controller = load_config( 'convention', 'APP_CONTROLLER', 1 ).'/';

        $controller_name = $names_path = $names;
        if( strstr( $names, '\\' ) ) {
            $names_path = str_replace( "\\", '/', $names );
            $names_arr = explode( '/', $names_path );
            $controller_name = $names_arr[ count($names_arr)-1 ];
        }
        $files = DOCUMENT_ROOT.APP_PATH.$app_controller.$names_path.CLASS_EXT;

        import_include( $files );

        //命名空间和普通模式
        $func_name = $app_namespace ? $names.'\\'.$controller_name : $controller_name ;
        return $_C[ $names ] = new $func_name();
    }
}

/**
 * 设置 cookie
 * @param string $var 名称
 * @param string $value 值
 * @param int $time 过期时间
 * @param string $pre 前缀
 */
if(!function_exists('set_cookie')) {
    function set_cookie($var, $value = '', $time = 0,$pre = '') {
        $time = $time > 0 ? $time : ($value == '' ? time() - 3600 : 0);
        $s = $_SERVER ['SERVER_PORT'] == '443' ? 1 : 0;
        $cookie_pre = load_config( 'config', 'COOKIE_PRE' ) ?  load_config( 'config', 'COOKIE_PRE' ) : $pre ;
        $var = $cookie_pre . $var;

        $cookie_pre = load_config('config', 'COOKIE_PATH');
        $cookie_domain = load_config('config','COOKIE_DOMAIN');

        //加密
        $value = authcode($value, 'ENCODE', load_config( "config", 'COOKIE_PWD' ));
        setcookie ( $var, $value, $time, $cookie_pre, $cookie_domain, $s );
    }
}

/**
 * 获取 cookie
 * @param string $var 名称
 * @param string $pre 前缀
 */
if(!function_exists('get_cookie')) {
    function get_cookie($var, $pre = '') {

        $cookie_pre = load_config( 'config', 'COOKIE_PRE' ) ?  load_config( 'config', 'COOKIE_PRE' ) : $pre ;
        $var = $cookie_pre . $var;

        if(!isset($_COOKIE[$var])) return false;

        $cookie_var = authcode($_COOKIE[$var], 'DECODE', load_config( "config", 'COOKIE_PWD' ));
        return isset ($cookie_var) && !empty($cookie_var) ? $cookie_var : false;
    }
}






