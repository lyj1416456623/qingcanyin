<?php
namespace Common\Model;
class UserModel{
	/**
	 * 获取用户信息
	 */
	public function getUserInfo(){
		//通过code获取用户信息
		$params = array(
			'code' => $_POST['code'],
		);
		$ret = getPingtaiApiData("public.weixinuser.getUserinfo",$params);
		if($ret['code'] == '1'){
			if(!empty($ret['data']['user']['uid'])){
				$ret['data']['user'];
				$data['uid'] = $ret['data']['user']['uid'];
				$data['username'] = $ret['data']['user']['username'];
				$data['ucode'] = $ret['data']['user']['ucode'];
				$data['sharecode'] = md5($ret['data']['user']['uid']); // 分享的时候用户ID方便追踪需要在服务器端存储，每个用户是唯一的
				$_SESSION['USERINFO'] = $data;
			}else{
				$data['uid'] = '';
				$data['username'] = '尚未绑定用户';
				$data['sharecode'] = md5 ( 'public' ); // 没有绑定用户的时候分享的时候ID方便追踪需要在服务器端存储
				$_SESSION['LOGINKEY'] = $ret['data']['key'];
			}
			return array(
					'data' => $data,
					'msg' => '数据获取成功',
					'success' => true
			);
		}else{
			return array(
					'data' => $ret['data'],
					'msg' => $ret['msg'],
					'success' => false
			);
		}
	}
	/**
	 * 微信小程序注册用户
	 */
	public function regWesoftUser(){
		//验证验证码
		if(empty($_POST['code'])){
			msg(array (
					'msg' => '请输入验证码',
					'success' => false
			) );
		}
		if(empty($_POST['phone'])){
			msg(array (
					'msg' => '请输入手机号',
					'success' => false
			) );
		}
		if($_POST['phone'] != $_SESSION['login']['phone']){
			msg(array (
					'msg' => '手机号码与验证码接收号码不一致',
					'success' => false
			) );
		}
		if($_POST['code'] != $_SESSION['login']['code']){
			return array (
				'data' => $_SESSION,
				'msg' => '验证码输入错误',
				'success' => false
			);
		}
		//如果微信服务号，key
		$params = array(
			'phone'=>$_POST['phone'],
		);
		$params['wxkey'] = $_SESSION['LOGINKEY'];
		$ret = getPingtaiApiData("public.weixinuser.setUserLoginWeixin",$params);
		if($ret['code'] == '1'){
			$_SESSION['USERINFO'] = $ret['data'];
			return array(
					'data' => $_SESSION['USERINFO'],
					'msg' => '操作成功',
					'success' => true
			);
		}else{
			return array(
					'msg' => $ret['msg'],
					'success' => false
			);
		}
		return array (
				'msg' => $ret['msg'],
				'success' => $ret['code'] == 1? true :false
		);
	}
	/**
	 * 网页版注册用户
	 */
	public function regWebUser(){
		//验证验证码
		if(empty($_POST['code'])){
			msg(array (
					'msg' => '请输入验证码',
					'success' => false
			) );
		}
		if(empty($_POST['phone'])){
			msg(array (
					'msg' => '请输入手机号',
					'success' => false
			) );
		}
		if($_POST['phone'] != $_SESSION['login']['phone']){
			msg(array (
					'msg' => '手机号码与验证码接收号码不一致',
					'success' => false
			) );
		}
		if($_POST['code'] != $_SESSION['login']['code']){
			msg(array (
					'msg' => '验证码输入错误',
					'success' => false
			) );
		}
		//如果微信服务号，key
		$params = array(
				'phone'=>$_POST['phone'],
		);
		/* @todo ltt 2017/07/13 $_SESSION['WXLOGINKEY'] */
		if(!is_weixin() || empty($_SESSION['WXLOGINKEY'])){
			$ret = getPingtaiApiData("public.weixinuser.setUserLogin",$params);
		}else{
			$params['wxkey'] = $_SESSION['WXLOGINKEY'];
			$ret = getPingtaiApiData("public.weixinuser.setUserLoginWeixin",$params);
		}
		if($ret['code'] == '1'){
			$_SESSION['USERINFO'] = $ret['data'];
		}
		die (json_encode(array (
				'msg' => $ret['msg'],
				'success' => $ret['code'] == 1? true :false
		)));
	}
	/**
	 * 创建微信支付统一订单
	 */
	public function setChongzhiOrder(){
		$params = array(
			'ucode' => $_SESSION['USERINFO']['ucode'],
			'body' => $_POST['body'],
			'total_fee' => $_POST['total_fee'],
			'trade_type' => $_POST['trade_type'],
		);
		$ret = getPingtaiApiData("public.weixindata.setPayOrder",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'databack' => $ret,
				'success' => $ret['code'] ==1? true : false,
		);
	}
	/**
	 * 获取用户付款码
	 */
	public function getPayCode(){
		$params = array(
				'ucode' => $_SESSION['USERINFO']['ucode'],
		);
		$ret = getPingtaiApiData("public.weixindata.getPayCode",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => empty($ret['data']) ? array() :$ret['data'] ,
				'success' => $ret['code'] ==1? true : false,
		);
	}
	/**
	 * 获取用户付款码状态
	 */
	public function getpaycodestatus(){
		$params = array('code'=>$_POST['code']);
		$ret = getPingtaiApiData("public.weixindata.getPayCodeStatus",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => empty($ret['data']) ? array() :$ret['data'] ,
				'success' => $ret['code'] ==1? true : false,
		);
	}
	/**
	 * 获取用户账户信息
	 */
	public function getUserAccount(){
		$params = array(
				'ucode' => $_SESSION['USERINFO']['ucode'],
		);
		$ret = getPingtaiApiData("public.weixindata.getUserAccount",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
	/**
	 * 获取账户余额
	 */
	public function getUserBalance(){
		$params = array(
			'ucode'=> $_SESSION['USERINFO']['ucode'],
		);
		$ret = getPingtaiApiData("public.weixindata.getUserAccount",$params);
		$_SESSION['USERINFO']['yue'] = $ret['data']['yue'];
		$_SESSION['USERINFO']['jifen'] = $ret['data']['jifen'];
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data']['yue'],
				'success' => $ret['code'] ==1 ? true : false,
		);
	}
	/**
	 * 获取财务流水
	 */
	public function getUserFinancialflow(){
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
				'page' => $_POST ['page'], //页码
				'page_size'=> $_POST ['pagenumber'], //页大小
		);
		$page = $_POST['page'];
		$key = "getUserFinancialflow";
		//@todo 测试需要，
		S_apidata($key,NULL,'',1);
		$data = S_apidata($key,'','',1);
		if(empty($data[$page])){
			$ret = getPingtaiApiData("public.weixindata.getFinancialflow",$params);
			if($ret['code']=='1'){
				$data[$page] = $ret['data'];
				S_apidata($key,$data,'',1);
			}
		}
		return array (
				'msg' => "查询成功！",
				'data' => empty($data[$page])?array():$data[$page],
				'success' => true,
		);
	}
	/**
	 * 获取用户积分信息
	 */
	public function getUserIntegral(){
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
		);
		$ret = getPingtaiApiData("public.weixindata.getUserAccount",$params);
		$_SESSION['USERINFO']['yue'] = $ret['data']['yue'];
		$_SESSION['USERINFO']['jifen'] = $ret['data']['jifen'];
		return array (
			'msg' => $ret['msg'],
			'testdata' => $ret,
			'data' => $ret['data']['jifen'],
			'success' => $ret['code'] ==1? true: false,
		);
	}
	public function getUserIntegralList(){
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
				'page' => $_POST ['page'], //页码
				'page_size'=> $_POST ['pagenumber'], //页大小
		);
		
		$page = $_POST['page'];
		$ret = getOpenApiData("public.memberintegral.getIntegralWater",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => empty($ret['data'])?array():$ret['data'],
				'success' => true,
		);
	}
	
	/**
	 * 我的页面
	 */
	public function getMyInfoList(){
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
		);
		$ret = getPingtaiApiData("public.weixindata.MyinfoList",$params);
		$ret['data']['usericon'] = empty($_SESSION['USERINFO']['icon'])?'http://f.xinyisoft.org/a43a238a74cf7cc61177ba64b9ff13d2_480':$_SESSION['USERINFO']['icon'];
		return array (
				'msg' => $ret['msg'],
				'$ret' => $ret,
				'ucode' => $_SESSION['USERINFO']['ucode'],
				'data' => empty($ret['data']) ? array() : $ret['data'],
				'success' => $ret['code']==1 ? true : false,
		);
	}
}