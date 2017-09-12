<?php
namespace Common\Model;
class ActivityModel{
	/**
	 * 进行中的活动
	 */
	public function getActivitting(){
		$ret = getOpenApiData('public.memberrecharge.getActivittingList');
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['code']==1 ? $ret['data'] : array(),
				'success' => $ret['code']==1 ? true : false,
		);
	}
	
	/**
	 * 获取活动规则列表
	 */
	public function getRuleList(){
		$other = array();
		$ispay = C('WEIXINPAY_STATUS');
		if($ispay === null) $ispay = false;
		$other['isweixinpay'] = (boolean)$ispay;
		$other['merchantname'] = C("BUSINESSNAME");
		$params = array (
				'activityid'=>$_POST['activityid'],
		);
		$ret = getOpenApiData('public.memberrecharge.getRuleList',$params);
		
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['code']==1 ? $ret['data'] : array(),
				'other'=>$other,
				'success' => $ret['code']==1 ? true : false,
		);
	}	
	

	/**
	 * 将充值金金额（微信支付）
	 * 会员充值活动
	 */
	public function setActivityJsPayOrder(){		
		$params = array(
				'ucode'      => $_SESSION['USERINFO']['ucode'],
				'body'       => $_POST['body'],
				'total_fee'  => ($_POST['price']*100),
				'trade_type' => $_POST['trade_type'],
				'amraid'     => $_POST['amraid'],
				'paytype'    => $_POST['paytype'],
//				'wxappid'    => WXAPPID,
				'wxappid'    => wx5136c604941dc31e,
				'ptid'       => $_POST['ptid'],
		);
		$ret = getOpenApiData('public.memberrecharge.setJsPayOrder',$params);
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
	 * 优惠劵，首单立减，是否已经领过
	 * return array()
	 * */
	public function getCouponData(){
//		$params = array('ucode' => $_SESSION['USERINFO']['ucode']);
		$data['islogin'] = is_login();
		$data['coupon'] = array(
						'id' => 1,
						'price' => 10,
						'stime' => "2017/9/6",
						'ttime' => "2017/9/8",
						'type' => 1,  //1为优惠劵  2为首单立减
						'receive' => false, //是否已经领取
				
		);
		$data['firstcut'] = array(
						'id' => 2,
						'price' => 20,
						'stime' => "2017/9/5",
						'ttime' => "2017/9/8",
						'type' => 2,  //1为优惠劵  2为首单立减
						'receive' => false, //是否已经使用
		);
		
		return array(
				'msg' => '成功',
				'data' => $data,
				'success' => true,
		);
	}
}