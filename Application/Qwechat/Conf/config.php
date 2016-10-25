<?php
return array(

//     'DB_TYPE' => 'mysql',
//     'DB_HOST' => '127.0.0.1',
//     'DB_USER' => 'root',
//     'DB_PWD' => '664198',
//     'DB_NAME' => 'pal_qwechat',
//     'DB_PORT' => '3306',
//     'DB_PREFIX' => 'db_',

    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_USER' => 'root',
    'DB_PWD' => 'palcomm007',
    'DB_NAME' => 'pal_qwechat',
    'DB_PORT' => '3306',
    'DB_PREFIX' => 'db_',

	'app_begin' => array('Behavior\CheckLangBehavior'),

    'LANG_SWITCH_ON'   => true,
    'LANG_AUTO_DETECT' => true, 		 // 自动侦测语言 开启多语言功能后有效
	'LANG_LIST'        => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l', 			 // 默认语言切换变量


    'URL_ROUTER_ON' => true,
    'URL_MODEL' => 2,

    'SHOW_PAGE_TRACE' => true,
    'ACTION_SUFFIX' => '_action',
    'URL_HTML_SUFFIX' => '',

    'DEFAULT_MODULE'        =>  'Qwechat',      // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Qwechat',      // 默认控制器名称
    'DEFAULT_ACTION'        =>  'qwechat',      // 默认操作名称

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/Static',
        '__CSS__' => __ROOT__ . '/Public/Static/css',
        '__JS__' => __ROOT__ . '/Public/Static/js',
        '__IMAGES__' => __ROOT__ . '/Public/Static/images',
        '__FONTS__' => __ROOT__ . '/Public/Static/fonts',
    ),

);