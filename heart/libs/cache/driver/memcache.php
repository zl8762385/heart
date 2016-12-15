<?php
/*
 * memcache
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * */

namespace heart\libs\cache\driver;

use heart\libs\cache\driver;
use heart\libs\error_exception;

class memcache extends driver {

    protected $options = [
        'host'       => '127.0.0.1',
        'port'       => 11211,
        'expire'     => 0,
        'timeout'    => 0, // 超时时间（单位：毫秒）
        'persistent' => true,
        'prefix'     => '',
    ];

    public function __construct() {

        if (!extension_loaded('memcache')) throw new error_exception('请安装redis扩展.');

        $options = load_config( 'cache' )['memcache'];

        $this->options = array_merge($this->options, $options);

        $this->handler = new \Memcache;

        // 支持集群
        $hosts = explode(',', $this->options['host']);
        $ports = explode(',', $this->options['port']);

        if (empty($ports[0])) $ports[0] = 11211;

        // 建立连接
        foreach ((array) $hosts as $i => $host) {
            $port = isset($ports[$i]) ? $ports[$i] : $ports[0];

            $this->options['timeout'] > 0 ?
            $this->handler->addServer($host, $port, $this->options['persistent'], 1, $this->options['timeout']) :
            $this->handler->addServer($host, $port, $this->options['persistent'], 1);
        }
    }

    public function get_cache_name( $name ) {
        return $this->options['prefix'].$name;
    }

    /*
     * 判断缓存
     *
     * @param string $name 缓存变量名
     * @return bool
     * */
    public function has($name) {

        $key = $this->get_cache_name($name);
        return $this->handler->get($key) ? true : false;
    }

    /*
     * 读取缓存
     *
     * @param string $name 缓存变量名
     * @param mixed  $default 默认值
     * @return mixed
     * */
    public function get($name, $default = false) {
        $result = $this->handler->get($this->get_cache_name($name));
        return false !== $result ? $result : $default;
    }

    /*
     * 写入缓存
     *
     * @param string    $name 缓存变量名
     * @param mixed     $value  存储数据
     * @param integer   $expire  有效时间（秒）
     * @return bool
     * */
    public function set($name, $value, $expire = null) {
        if (is_null($expire)) $expire = $this->options['expire'];

        $key = $this->get_cache_name($name);

        if ($this->handler->set($key, $value, 0, $expire)) {
            return true;
        }

        return false;
    }

    /*
     * 删除缓存
     *
     * @param    string  $name 缓存变量名
     * @param bool|false $ttl 设置过期时间
     * @return bool
     * */
    public function rm($name, $life = false) {
        $name = $this->get_cache_name($name);

        if( false === $life ) {
            $this->handler->delete($name);
        } else {
            $this->handler->delete($name, $life);
        }
    }
}
