<?php
namespace Common\Model;
class SysModel{
	
	public function getWesoftQrcode(){
		$ret = S('qrcode');
		if(!$ret){
			$params = array();
			$ret = getPingtaiApiData("public.weixinuser.getWxsoftQrcode",$params);
			if($ret['code'] == '1'){
				S('qrcode',$ret);
			}else{
				msg( array (
						'msg' => '小程序二维码获取失败',
						'success' => false
				));
			}
		}
		
		return array (
				'data' => $ret,
				'msg' => '小程序二维码获取成功',
				'success' => true
		);
	}
	/**
	 * getJsSdk 获取配置
	 */
	public function getJsSdkconfig(){
		$params = array('url'=>$_POST['url']);
		$ret = getPingtaiApiData('public.weixindata.getJsSdkConfig',$params);
		return array (
				'msg' => $ret['msg'],
				'isweixin' => is_weixin(),
				'backdata' => $ret,
				'data' => empty($ret['data'])? array(): $ret['data'],
				'success' => $ret['code']==1 ? true : false,
		);
	}
	public function getJsPayOrder(){
		$params = array(
			'ucode'=>$_SESSION['USERINFO']['ucode'],
			'body'=>$_POST['body'],
			'total_fee'=> ($_POST['price']*100),
			'trade_type'=>$_POST['trade_type'],
			'paytype'=>$_POST['paytype'],
			'localcode' => $_POST['localcode']
		);
		if($_POST['paytype'] == 'maidan'){
			$params['orderno'] = $_POST['orderno'];
		}
		$ret = getPingtaiApiData('public.weixindata.setJsPayOrder',$params);
		if($ret['code'] == '1'){
			return array (
					'msg' => $ret['msg'],
					'data' => $ret['data'],
					'header' => getallheaders(),
					'success' => true,
			);
		}else{
			return array (
					'msg' => $ret['msg'],
					'backdata' => $ret,
					'success' => false,
			);
		}
		
	}
	public function getPayOrder(){
		$params = array(
			'ucode'=>$_SESSION['USERINFO']['ucode'],
			'body'=>$_POST['body'],
			'total_fee'=>$_POST['price'],
			'trade_type'=>$_POST['trade_type'],
		);
		$ret = getPingtaiApiData('public.weixindata.setPayOrder',$params);
		if($ret['code'] == '1'){
			return array (
					'msg' => $ret['msg'],
					'data' => $ret['data'],
					'success' => true,
			);
		}else{
			return array (
					'msg' => $ret['msg'],
					'backdata' => $ret,
					'success' => false,
			);
		}
		
	}
	/**
	 * 获取支付码
	 */
	public function getPayCode(){
		return array (
			'msg' => "拉取成功！",
			'data' => '2018' . rand ( 1000000, 99999999 ) . rand ( 1000000, 99999999 ),
			'success' => true
		);
	}
	public function getChongzhiData(){
		$data = array (
				array (
						'name' => '0.01元',
						'value' => 0.01
				),
				array (
						'name' => '10元',
						'value' => 10
				),
				array (
						'name' => '20元',
						'value' => 20
				),
				array (
						'name' => '50元',
						'value' => 50,
						'checked' => true
				),
				array (
						'name' => '100元',
						'value' => 100
				),
				array (
						'name' => '500元',
						'value' => 500
				),
				array (
						'name' => '1000元',
						'value' => 1000
				)
		);
		$ispay = C('WEIXINPAY_STATUS');
		if($ispay === null) $ispay = false;
		return array (
				'msg' => "数据拉取成功！",
				'data' => $data,
				'isweixinpay' => $ispay,
				'success' => true,
				'uid' => $_SESSION['USERINFO']['uid']
		);
	}
}