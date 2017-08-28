<?php
namespace Api\Controller;
use Think\Controller;

/**
 * 更新缓存
 * @author qiude
 *
 */
class CommonController extends Controller{
	public function _initialize(){
		//做来源验证
		if(!APP_DEBUG){
			$url = $_SERVER["HTTP_REFERER"];
			if(empty($url)){
				msg(array (
						'success' => false,
						'errcode' => '101',
						'msg' => '不允许的请求来源'
				),'JSON');
			}
			$urlinfo = parse_url($url);
			if(in_array($urlinfo['host'], C('URL_AUTHORIZE'))){
				msg(array (
						'success' => false,
						'errcode' => '101',
						'msg' => '不允许的请求来源'
				),'JSON');
			}
		}
	} 

}