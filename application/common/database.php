<?php
/*
 * 数据库
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */

return [
    //选择适合数据驱动
    'type' => 'pdo_mysql',

    //setting信息
    'db' => [
        //主机
        'host' => '127.0.0.1',
        //用户名
        'user' => 'root',
        //密码
        'password' => 'v90v70v00',
        //库名
        'db_name' => 'heart',
        //编码
        'charset' => 'utf8',
        //表前缀
        'prefix' => 'heart_',
        //端口
        'port' => 3306,
        ////是否启动从库（启动从库下列配置就会生效）  ture=开启  false=关闭
        'enable_slave' => false,
        //从库配置项
        'slaves' => [
            [
                'host' => 'localhost',
                'user' => 'root',
                'password' => 'v90v70v00',
                'db_name' => 'qiche',
                'charset' => 'utf8',
                'table_prefix' => 'heart_',
                'port' => 3306,
            ],
            [
                'host' => 'localhost',
                'user' => 'root',
                'password' => 'v90v70v00',
                'db_name' => 'qiche',
                'charset' => 'utf8',
                'table_prefix' => 'heart_',
                'port' => 3306,
            ],
        ]
    ]
];
