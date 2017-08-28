<?php
return array (
		'DOMAIN_ROOT' => 'qcywx.com',
		'CRYPT_KEY' => 'XINYI',
		
		'APPID' => '100026', //芯易的APPID
		'APP_SECRET' => '60b5483aaad1bba3a8ae5489', //芯易的secret
		
		'DOMAIN_HTTP' => 'http',
		'OPEN_API_URL' => 'http://openapi.yunshouyin.com.cn',
		//允许访问API的域名
		'URL_AUTHORIZE' => array(
			'openapi.yunshouyin.com.cn'
		),
		'FILEURL'=>"http://f.xinyisoft.org/",//文件地址
		//默认错误跳转对应的模板文件
		'TMPL_ACTION_ERROR' => 'Public:error',
		//默认成功跳转对应的模板文件
		'TMPL_ACTION_SUCCESS' => 'Public:success',
		// '配置项'=>'配置值'
		'URL_CASE_INSENSITIVE' => true, // 开启URL不区分大小写
		'LANG_SWITCH_ON' => true, // 开启多语言监测
		'VIEW_CACHE' => true, // 开启权限缓存
		'GROUP_CLOSE' => true, // 开启分组验证
		'DATA_CACHE_SUBDIR' => true, // 开启缓存自动创建目录
		//权限配置
		'MODULE_NO_RBAC' => array (
			'/home/load/*',
			'/home/index/index',
			'/home/index/login',
			'/home/index/hiddenlogin',
			'/home/datainfo/getindexdata',
			'/home/datainfo/sendsmscode',
			'/home/datainfo/binduser',
			'/home/data/*',
			'/home/msghtml/*',
			
			'/home/datainfo/getstoredata',
			'/home/datainfo/getzizhustoredata',
			'/home/datainfo/getzizhugoodsdata',
			'/home/datainfo/getsdkconfig',
			'/home/datainfo/phoneregister',
			'/home/selfshopping/selectstore',
			'/home/selfshopping/storeinfo',
			'/home/selfshopping/index',
			'/home/selfshopping/orderconfirm',
			'/home/selfshopping/orderlist',
			'/home/selfshopping/activity',
			'/home/datainfo/getactivitygoods',
			'/home/datainfo/getlimitgoods',
			'/home/datainfo/getuserorderlist',
			'/home/selfshopping/orderceshi',

		),	
		'URL_MODEL' => '2', // URL模式
		'URL_HTML_SUFFIX' => '', // URL伪静态后缀设置
		'DEFAULT_MODULE' => 'Home', // 默认模块
		'APP_DOMAIN' => '', // 默认域名
		'APP_DOMAIN_SUFFIX_ARRAY' => array('com.cn','com','net.cn','cn'), // 可以使用的域名后缀，com.cn这种二级后缀的优先级高于一级后缀域名
		'APP_SUB_DOMAIN_DEPLOY' => 1, // 开启子域名配置
		'APP_SUB_DOMAIN_RULES' => array (
			'*.wx' => array('Home','appid=*'),/*支持微信解析*/
			'api'  => array ('Api' ),
			'wesoftapi'  => array ('Api' ),
		)
)
;