<?php
return array(
		'DB_TYPE'               =>  'mysql',     // 数据库类
		'DB_HOST'               =>  '127.0.0.1', // 服务器地址
		'DB_NAME'               =>  'ssyp',          // 数据库名
		'DB_USER'               =>  'root',      // 用户名
		'DB_PWD'                =>  'root',          // 密码
		'DB_PORT'               =>  '3306',        // 端口
		'DB_PREFIX'             =>  'ssyp_',    // 数据库表前缀
 		'DEF_PWD' => '123456',//添加用户时候的默认密码
		'DEFAULT_MODULE' => 'Admin',
 		'APPID' => 'wx1b496a2ecc70a7dd',//'wx82deb2547553938c', //公众 		'APPSECRET' => '11d6933541e22f836c159d4adfe162ff',
		'APPSECRET' => '11d6933541e22f836c159d4adfe162ff',
		'WX_KEY'=>'cc6e921b6ac655da6f1f3a4737049941',
 		'MCHID'=>'1487445642',
 		'SERVER_IP' => '122.14.208.143',
        'TOKEN' => 'xgs_xgs',
		'LOAD_EXT_FILE' => 'ifunction',
		'WEIXINPAY_CONFIG'       => array(
			'APPID'              => '', // 微信支付APPID
			'MCHID'              => '', // 微信支付MCHID 商户收款账号
			'KEY'                => '', // 微信支付KEY
			'APPSECRET'          => '',  //公众帐号secert
			'NOTIFY_URL'         => 'http://baijunyao.com/Api/WeixPay/notify/order_number/', // 接收支付状态的连接
		),
);
?>
