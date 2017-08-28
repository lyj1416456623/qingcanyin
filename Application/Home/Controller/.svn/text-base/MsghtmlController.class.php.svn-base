<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 微信服务号
 * @author qiude
 *
 */
class MsghtmlController extends Controller{
	/**
	 * 首页
	 */
	public function noappid(){
		$this->display();
	}
	public function nowxconfig(){
		$this->display();
	}
	public function iswesoft(){
		$ret = S('qrcode');
		if(!$ret){
			$params = array();
			$ret = getPingtaiApiData("public.weixinuser.getWxsoftQrcode",$params);
			if($ret['code'] == '1'){
				S('qrcode',$ret);
			}
		}
		$this->assign('img',$ret['data']);
		$this->display();
	}
	
}