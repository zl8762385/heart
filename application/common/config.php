<?php
/*
 * 配置
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <zl8762385@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */

return [
    // +----------------------------------------------------------------------
    // | 目录设置
    // +----------------------------------------------------------------------
    //控制器目录名
    'directory_controller' => 'controllers',
    //模型目录名
    'directory_model' => 'models',
    //业务目录名
    'directory_service' => 'services',

    // +----------------------------------------------------------------------
    // | 模板设置 - 这里模板采用PHP原生模板
    // +----------------------------------------------------------------------
    //模板文件后缀
    'template_suffix' => '.php',

    // +----------------------------------------------------------------------
    // | SESSION 设置
    // +----------------------------------------------------------------------
    'session' => [
        /*
         * 默认session使用files   如果需要使用redis或memcache 请打开注释 填写信息即可(maoxiaoqi 友情提示 ^_^)
        //session驱动类型
        'type' => 'redis',

        //如果设置memcache,redis需要设置host
        'host' => [
            'tcp://127.0.0.1:11211',
            'tcp://127.0.0.1:11211',
        ],
        */

        //（session.name）session名称
        'name' => 'HEART_SESSION',

        //是否自动开启SESSION
        'auto_start' => true,//true=自动开启 false=关闭

        //重新生成SESSION ID
        'regenerate' => false,//true=重新生成,false=不生成

    ],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------
    'cache' => [
        //缓存类型 file,redis,memcache等,如需其他驱动可以在heart 自行扩展
        'type' => 'file',

        //file ---------------- 相关设置
        'file' => [
            //缓存目录
            'dir' => ROOT_PATH.'runtime/cache/',
        ],

        //memcache ---------------- 相关设置
        'memcache' => [
            'host' => '127.0.0.1,127.0.0.1',
            'port' => "11211,11211",
            'expire' => 0,
            'timeout' => 0,//超时时间
            'persistent' => true,//是否持久化
            'prefix' => 'heart_',
        ],

        //redis ---------------- 相关设置
        'redis' => [
            //连接超时时间(S) 0:永不超时
            'timeout' => 5,
            //集群模式
            'cluster_mode' => true,
            //前缀
            'prefix' => 'heart_',
            //数据缓存有效期 0表示永久缓存，单位（秒）
            'expire' => 3600,
            //是否采用持久连接
            'persistent' => false,
            //链接
            'host' => [
//                '127.0.0.1:6379',
                'bj01-ops-g1rdsc01.pre.gomeplus.com:7007',
                'bj01-ops-g1rdsc02.pre.gomeplus.com:7007',
                'bj01-ops-g1rdsc03.pre.gomeplus.com:7007',
                'bj01-ops-g1rdsc04.pre.gomeplus.com:7007',
                'bj01-ops-g1rdsc05.pre.gomeplus.com:7007',
            ]
        ],

    ],
];
