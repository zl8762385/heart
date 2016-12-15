<?php
/*
 * redis缓存驱动
 * 要求安装phpredis扩展：https://github.com/nicolasff/phpredis
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */
namespace heart\libs\cache\driver;

use heart\libs\cache\driver;
use heart\libs\error_exception;

class redis extends driver {

    public function __construct() {
        if (!extension_loaded('redis')) {
            throw new error_exception('请安装redis扩展.');
        }

        $options =  load_config( 'cache' )['redis'];
        $this->options['expire'] = isset($options['expire']) ? $options['expire'] : 3600 ;
        $func = $options['persistent'] ? 'pconnect' : 'connect';

        if($options['cluster_mode'] == true)  {
             $this->handler  =   $options['timeout'] === false ?
                 new \RedisCluster(NULL,$options['host']) :
                 new \RedisCluster(NULL,$options['host'],$options['timeout']);
        } else {
            $this->handler  = new \Redis;

            $host = array_shift($options['host']);
            list($host,$port) = explode(':',$host);

            $options['timeout'] === false ?
                $this->handler->$func($host, $port) :
                $this->handler->$func($host, $port, $options['timeout']);
        }

        if(!empty($options['prefix'])) {
            $this->handler->setOption(\Redis::OPT_PREFIX, $options['prefix']);
        }

        $this->handler->setOption(\Redis::OPT_SERIALIZER,\Redis::SERIALIZER_PHP);
    }

    /*
     * 读取缓存
     *
     * @param string $name 缓存变量名
     * @return mixed
     * */
    public function get($name, $default = false) {
        $value = $this->handler->get($name);
        //$jsonData  = json_decode( $value, true );
        return $value;
    }

    /*
     * 写入缓存
     *
     * @param string $name 缓存变量名
     * @param mixed $value  存储数据
     * @param integer $expire  有效时间（秒）
     * @return boolean
     * */
    public function set($name, $value, $expire = null) {
        if(is_null($expire)) $expire = $this->options['expire'];

        //对数组/对象数据进行缓存处理，保证数据完整性
        //$value  =  (is_object($value) || is_array($value)) ? json_encode($value) : $value;
        if(is_int($expire) && $expire) {
            $result = $this->handler->setex($name, $expire, $value);
        }else{
            $result = $this->handler->set($name, $value);
        }

        return $result;
    }

    /*
     * 删除缓存
     *
     * @param string $name 缓存变量名
     * @return boolean
     * */
    public function rm($name) {
        return $this->handler->del($name);
    }

    /*
     * 判断缓存是否存在
     * @param string $name 缓存变量名
     * @return bool
     * */
    public function has($name) {
        // TODO: Implement has() method.
    }

    /*
     * 自增缓存（针对数值缓存）
     * @access public
     * @param string $name 缓存变量名
     * @param int $step 步长
     * @return false|int
     * */
    public function inc($name, $step = 1) {
        // TODO: Implement inc() method.
    }

    /*
     * 自减缓存（针对数值缓存）
     * @param string $name 缓存变量名
     * @param int $step 步长
     * @return false|int
     * */
    public function dec($name, $step = 1) {
        // TODO: Implement dec() method.
    }
}
