<?php
return array(
    //扩展配置
    //'LOAD_EXT_CONFIG'       => 'session,',
    //session不自动启动
    //'SESSION_AUTO_START' => false,
	//'配置项'=>'配置值'
    'MAIL_HOST' =>'smtp.qq.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'644760354@qq.com',//你的邮箱名
    'MAIL_FROM' =>'644760354@qq.com',//发件人地址
    'MAIL_FROMNAME'=>'孜智在线学习平台',//发件人姓名
    'MAIL_PASSWORD' =>'ahbryhrfbfdxbced',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件

    //链接数据库
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'istudy',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  '',    // 数据库表前缀
    'DB_CHARSET'            =>  'utf8',      // 数据库编码
    //'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志

    //显示调试信息
    'SHOW_PAGE_TRACE' => true,

    'SESSION_AUTO_START' =>true
);