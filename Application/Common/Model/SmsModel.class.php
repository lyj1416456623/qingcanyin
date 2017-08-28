<?php
namespace Common\Model;
class SmsModel{
	
	public function send(){
		$params = array(
				'phone'=>$_POST['phone']
		);
		$ret = getPingtaiApiData("public.weixinuser.sendcode",$params);
		if($ret['code'] == 1){
			$_SESSION['login']['phone'] = $_POST['phone'];
			$_SESSION['login']['code'] = $ret['data'];
			return array(
				'msg' => '短信发送成功，5分钟内输入有效！',
				'success' => true
			);
		}else{
			return array(
				'msg' => $ret['msg'],
				'success' => false
			);
		}
	}
}