<?php
return array(
	//'配置项'=>'配置值'
		'TMPL_PARSE_STRING'  =>array(
				'__JS__'     	 => __ROOT__.'/Public/'.MODULE_NAME.'/js/',
				'__CSS__' 	 	 => __ROOT__.'/Public/'.MODULE_NAME.'/css/',
				'__IMG__' 		 => __ROOT__.'/Public/'.MODULE_NAME.'/images/',
				'__STATICS__' 	 => __ROOT__.'/Public/Statics/',
            'DEFAULT_MODULE'        =>  'Home',  // 默认模块
            'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
            'DEFAULT_ACTION'        =>  'index', // 默认操作名称
            'TMPL_ACTION_ERROR'     => 'Public:success',
            'TMPL_ACTION_SUCCESS'   =>  'Public:success',
        ),
);