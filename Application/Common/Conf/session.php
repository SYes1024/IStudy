<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/3
 * Time: 20:38
 */
return array(
    'SESSION_OPTIONS'         =>  array(
           'name'                =>  'verCode',                    //设置session名
            'expire'              =>  60,                      //SESSION保存15天
            'use_trans_sid'       =>  1,                               //跨页传递
            'use_only_cookies'    =>  0,  //是否只开启基于cookies的session的会话方式
//        ],
//        [   'name'                =>  'email',                    //设置session名
//            'expire'              =>  60,                      //SESSION保存15天
//            'use_trans_sid'       =>  1,                               //跨页传递
//            'use_only_cookies'    =>  0,  //是否只开启基于cookies的session的会话方式
//        ]
    ),
);