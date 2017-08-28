<?php
namespace Common\Model;
class OrderModel{
	/**
	 * 获取订单列表
	 */
	public function getMyOrder(){
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
				'page' => $_POST ['page'], //页码
				'page_size'=> $_POST ['pagenumber'], //页大小
		);
		$ret = getPingtaiApiData("public.weixindata.getOrderlist",$params);
		if($ret){
			return array (
					'msg' => $ret['msg'],
					'data' => $ret['data'],
					'success' => $ret['code'] ==1? true : false,
			);
		}else{
			return array (
					'msg' => '未查询到数据',
					'data' => array(),
					'success' => true,
			);
		}
	}
	/**
	 * 获取订单详细
	 */
	public function getOrderDetail(){
	
		$params = array(
		 		'orderno'	=> $_POST['orderno'],
		 		'uid' 		=> $_SESSION['USERINFO']['uid']
		);
		$ret = getPingtaiApiData("public.weixindata.getOrderDetail",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
	/**
	 * 取消订单的理由
	 */
	public function getcancelreason(){
		$ret = getPingtaiApiData("public.weixindata.getCancelreason");
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
	
	/**
	 * 取消订单
	 */
	public function cancleOrder(){
		
		$params = array(
				'orderno'=> $_POST['orderno'],
				'uid'=> $_SESSION['USERINFO']['uid'],
				'status'=> $_POST['status'], //订单状态
				'dociid'=> $_POST['dociid'], //取消订单理由id
				'storeid'=> $_POST['storeid'],
		);
		$ret = getPingtaiApiData("public.weixindata.cancleOrder",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
	
	/**
	 * 提交订单评论
	 */
	public function setOrderComment(){
		
	}
	
	/**
	 * 取消发票
	 */
	public function cancelInvoice(){
		$params = array(
			'uid'=> $_SESSION['USERINFO']['uid'],
			'orderno' => $_POST['orderno'],
		);
		$ret = getPingtaiApiData("public.weixindata.cancelfapiao",$params);
	}
	
	/**
	 * 创建电子发票
	 */
	public function setOrderInvoice() {
		$params = array (
			'storeid' => $_POST['storeid'],/*门店id*/
			'title' => $_POST ['title'], /* 发票抬头 */
			'email' => $_POST ['email'],
			'phone' => $_POST ['phone'],
			'orderno' => $_POST ['orderno'],	/* 订单编号 */
			'uid' => $_SESSION ['USERINFO'] ['uid'],
			'buyerNum' => $_POST ['identification'],	/* 纳税人识别号 */
			'buyerBankName' => $_POST ['openingBank'],	/* 开户行 */
			'buyerBankCode' => $_POST ['bankNumber'],	/* 银行账号 */
			'buyerAddress' => $_POST ['address'], 		/* 地址 */
			'buyerTel' => $_POST ['telephone'],		/*  电话 */
		);
		$ret = getPingtaiApiData ( "public.weixindata.drawing", $params );
		return array (
				'msg' => $ret ['msg'],
				'data' => $ret ['data'],
				'success' => $ret ['code'] == 1 ? true : false 
		);
	}
	
	
	/**
	 * 发票发邮箱
	 */
	public function sendfapiaoEmail(){
		$params = array(
				'uid' => $_SESSION['USERINFO']['uid'], 
				'orderno'=> $_POST['orderno'],
		);
		$ret = getPingtaiApiData("public.weixindata.sendfapiaoEmail",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
	
	/**
	 * 查看发票
	 */
	public function getfapiao() {
		$params = array(
				'uid'=> $_SESSION ['USERINFO'] ['uid'],
				'orderno'=> $_POST ['orderno'],
		);
		$ret = getPingtaiApiData ("public.weixindata.previewInvoice", $params );
		$result = array();
		if($ret['code']==1){
			
			$result =array (
					'Payer'			=> $_SESSION['USERINFO']['nickname'],		/*付款方  */
					'Payee'			=>empty($ret['data']['storeidtext']) ? "暂无" : $ret['data']['storeidtext'],	/* 收款方 */
					'invoiceValue'	=>empty($ret['data']['price'])? "暂无" : $ret['data']['price'] , 		/* 发票金额 */
					'billingDate'	=>empty($ret['data']['ctime']) ? "暂无": $ret['data']['ctime'],		/* 开票日期 */
					'identification'=>empty($ret['data']['shibienum']) ? "暂无":$ret['data']['shibienum'],	/* 收款方识别号 */
					'invoiceCode'	=>empty($ret['data']['invoicecode']) ? "暂无": $ret['data']['invoicecode'],		/* 发票代码 */
					'invoiceNumber' =>empty($ret['data']['invoiceno']) ? "暂无": $ret['data']['invoiceno'],		/* 发票号码 */
					'status'		=>$ret['data']['status'],
					'url' => isset($ret['data']['url'])? $ret['data']['url'] : '',  /* 发票预览路径 */
			);
		}
		return array (
				'msg' => $ret['msg'],
				'data' => $result,
				'success' => $ret['code']==1? true : false,
		);
	}
	/**
	 * 外卖下单
	 */
	public function creatWaimaiOrder(){
		$order = json_decode($_POST['order'],true);
		$od = array(
		 	'storeid' => $order['storeid'],
			'total_price'=>$order['totalprice'],  //订单总价 (优惠金额+实收金额=订单总价)
			'uid' =>$_SESSION['USERINFO']['uid'],
			'discount_price'=> 0, //优惠总金额
			'sprice' => $order['totalprice'] ,  //商户实收金额
			'allgoodsno'=>$order['allnumber'], //商品总数量
			'ispay'=> 0, //是否支付
			'reservation'=> '1', //是否预约， 0 否  1 是  外卖必传1
			'addtime'=>time(), //下单时间
			'paytype'=> $order['paytype'], //支付方式  0:是余额， 2：是微信
			'member'=> $order['member'],
			'ptid' =>$order['ptid'],
			'isconfirm' =>1,
				
			'addressid'=>$order['addressid'], //外卖必传
			'yytime'=> strtotime($order['yytime']),//预约时间戳  外卖必传
			'allpackageprice' =>$order['packboxPrice'], //打包盒总金额  外卖必传
		); 
		
		$params  = array(
			'goods'=> $_POST['goods'],
			'order'=> json_encode($od),
			'paylist' => $_POST['paylist'],
			'type'=>2 //1:自助点餐  2:外卖点餐
		);
		
		$ret = getPingtaiApiData("public.weixindata.ceateweixinOrder",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code']==1? true : false,
		);
	}
	
	/**
	 * 自助下单
	 */
	public function createzizhuOrder(){
		$order = json_decode($_POST['order'],true);
		$yytime = strtotime($order['yytime']);
		$reservation = 1;
		if(time()>$yytime){
			$reservation = 0;
		}
		$od = array(
			'storeid' => $order['storeid'],
			'total_price'=>$order['totalprice'],  //订单总价 (优惠金额+实收金额=订单总价)
			'uid' =>$_SESSION['USERINFO']['uid'],
			'discount_price'=> 0, //优惠总金额
			'sprice' => $order['totalprice'] ,  //商户实收金额
			'allgoodsno'=>$order['allnumber'], //商品总数量
			'ispay'=> 0, //是否支付
			'reservation'=> $reservation, //是否预约， 0 否  1 是  外卖必传1
			'addtime'=>time(), //下单时间
			'yytime'=> $yytime,//预约时间戳  外卖必传
			'paytype'=> $order['paytype'], //支付方式  0:是余额， 2：是微信
			'member'=> $order['member'],
			'ptid' =>$order['ptid'],
			'staid' =>empty($order['staid'])?'':$order['staid'],
			'stid' =>empty($order['stid'])?'':$order['stid'],
			'isconfirm' =>$order['isconfirm'],
			'allpackageprice' =>$order['packboxPrice'], //打包盒总金额  外卖必传
			'username' => empty($_POST['nickname']) ?  $_SESSION['USERINFO']['nickname'] : $_POST['nickname'],'username' => empty($_SESSION['USERINFO']['nickname']) ? $order['nickname'] :  $_SESSION['USERINFO']['nickname'],
//			'username'=> $_SESSION['USERINFO']['nickname'],

		); 
		$params  = array(
				'goods'=> $_POST['goods'] ,
				'order'=> json_encode($od),
				'paylist' => $_POST['paylist'],
				'type'=>1 //1:自助点餐  2:外卖点餐
		);
		$ret = getPingtaiApiData("public.weixindata.ceateweixinOrder",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code']==1? true : false,
		);
	}
	
	/**
	 * 获取支付方式
	 */
	public function getPaytype(){
		/* 自助 */
	 	if($_POST['type'] == 4){
			$data = array_values(C("ZIZHUPAYTYPECONFIG"));
		}
		if($_POST['type'] == 1){
			$data = array_values(C("WAIMAIPAYTYPECONFIG"));
		}
		$ispay = C('WEIXINPAY_STATUS');
		if($ispay === null) $ispay = false;
		$ispay = (boolean)$ispay;
		if(!empty($data)){
			$result = array();
			foreach($data as $k=>$v){
				if($ispay == false && $v['paytype'] == '2') continue;
				if($k=='YEPAYTYPE'){
					$v['payname'] = $v['payname'];
					$v['paytype'] = $v['paytype'];
					$v['member'] = $v['member'];
				}
					
				if($k=='WXPAYTYPE'){
					$v['payname'] = $v['payname'];
					$v['paytype'] = $v['paytype'];
					$v['member'] = $v['member'];
				}
				$result[] = $v;
				
			}
		}else{
			$params  = array(
					'type'=> $_POST['type'],  //区分外卖 自助
			);
			$ret = getPingtaiApiData("public.weixindata.getPayType",$params);
			$result=$ret['data'];
		}
		$useryue = $_SESSION['USERINFO']['yue'];
		if($useryue == null){
			$ret = getPingtaiApiData("public.weixindata.getUserAccount",array('ucode'=>$_SESSION['USERINFO']['ucode']));
			$useryue = $ret['data']['yue'];
		}
		return array (
				'msg' => "数据拉取成功",
				'data' => $result,
				'useryue' => $useryue,
				'success' => true,
		); 
	}
	
	/**
	 * 余额支付
	 */
	public function yuePay(){
		$params  = array(
				'orderno'=> $_POST['orderno'] ,
				'storeid'=> $_POST['storeid'],
				'uid'=> $_SESSION['USERINFO']['uid'],
		);
		$ret = getPingtaiApiData("public.weixindata.yuePay",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
	/**
	 * 修改支付方式
	 */
	public function setPaytype(){
		
		$pay = array(
			'paytype' => $_POST['paytype'],
			'ptid' => $_POST['ptid'],
			'price' => $_POST['price'],
		);
		$oldpay = array(
			'paytype' => $_POST['oldpaytype'],
			'ptid' => $_POST['oldptid'],
		);
		$params = array(
			'orderno'=> $_POST['orderno'],
			'storeid' => $_POST['storeid'],
			'uid' => $_SESSION['USERINFO']['uid'],
			'pay'=> json_encode($pay),
			'oldpay' => json_encode($oldpay),
			'orderid'=> $_POST['orderid'],
			'localcode' => $_POST['localcode']
		);
		$ret = getPingtaiApiData("public.weixindata.editPaytype",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
	/**
	 * 获取用户门店未完成订单
	 */
	public function getUserOrderList(){
		$params = array(
			'storeid'=> $_POST['storeid'],
			'uid' => $_SESSION['USERINFO']['uid'],
		);
		$ret = getPingtaiApiData("public.weixindata.getUserOrderConduct",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
	/**
	 * 获取用户门店未完成订单绑定桌台或取餐
	 */
	public function completeUserOrder(){
		$params = array(
			'storeid'=> $_POST['storeid'],
			'uid' => $_SESSION['USERINFO']['uid'],
			'orderno' => $_POST['orderno'],
			'stid' => empty($_POST['stid'])?'':$_POST['stid'],
			'staid' => empty($_POST['staid'])?'':$_POST['staid'],
			'addtime' => strtotime($_POST['addtime'])
		);
		$ret = getPingtaiApiData("public.weixindata.completeUserOrder",$params);
		if(is_array($ret['data']['serial'])) $ret['data'] = array('serial'=>$ret['data']['serial']['serial']);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
	
}