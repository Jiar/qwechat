<?php
return array(
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