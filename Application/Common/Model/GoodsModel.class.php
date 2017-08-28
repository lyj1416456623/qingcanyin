<?php
namespace Common\Model;
class GoodsModel{
	/**
	 * 
	 */
	
	/**
	 * 获取外卖点餐商品
	 * 参数$_POST['storeid]
	 */
	public function getWaimaiGoods(){
		
		/*判断门店是否营业*/
		$waimaiIDData = S(WXAPPID."_Waimai_StoreIDData");
 		$storestatus = true;
 		if(empty($waimaiIDData) || !in_array($_POST['storeid'], $waimaiIDData)){
			$storeList = getPingtaiApiData('public.weixindata.getStoreId');
			$waimaistore = $storeList['data']['waimaistore'];	
	 		if(!in_array($_POST['storeid'], $waimaistore)){
	 			$storestatus = false;
	 			return array (
						'msg' => "成功！",
						'data' => array(),
	 					'storestatus' => $storestatus,
						'success' => true,
				);
	 		}
 		}
	 	/* 获取外卖门店配置 */
 		$waimaiConfig = S(WXAPPID."_Waimai_StoreConfig".$_POST['storeid']);
 		if(empty($waimaiConfig)){
	 		$params = array(
	 				'storeid'=>$_POST['storeid'],
	 		);
	 		$ret = getPingtaiApiData("public.weixindata.getWaimaiStoreConfig",$params);
	 		if( $ret['code'] ==1 && !empty($ret['data']) ){
	 			/* 存数据 */
	 			S(WXAPPID."_Waimai_StoreConfig".$_POST['storeid'],$ret['data']);
	 			$waimaiConfig = $ret['data'] ;
	 		}else{
	 			return array (
 					'msg' => "成功！",
 					'data' => array(),
 					'storestatus' => $storestatus,
 					'success' => true,
	 			);
	 		}
 		}
		$waimaiConfig = json_decode($waimaiConfig,true);
		/* 商品是否使用全局商品 */
		if(isset($waimaiConfig['DELIVERY_DEFAULTGOODS']) && !$waimaiConfig['DELIVERY_DEFAULTGOODS']){
			$storeid = $_POST['storeid'];
		}else{
			$storeid = '0';
		}
		/* 校验门店是否开启大图 */
		if(!isset($waimaiConfig['DELIVERY_DATUCONFIG'])){
				$allconfig= C("WAIMAICONFIG");
				$datu = isset($allconfig['DELIVERY_DATUCONFIG'])?$allconfig['DELIVERY_DATUCONFIG']:false;
		}else {
			$datu = $waimaiConfig['DELIVERY_DATUCONFIG'];
		}
		$isfapiao = false;
		if(isset($waimaiConfig['PUBLIC_FAPIAOCONFIG'])){
			$isfapiao = $waimaiConfig['PUBLIC_FAPIAOCONFIG'];
		}else{
			$fapiaoconfig = C("PUBLIC_FAPIAOCONFIG");
			if($fapiaoconfig === null) $fapiaoconfig = false;
		}
		
		if($waimaiConfig['DELIVERY_DEFAULTCONFIG'] == 'true'){
			$waimaiConfig = C("WAIMAICONFIG");
		}
		/* 外卖分类 */
		$waimaitype = S(WXAPPID."_Waimai_GoodsTypeData".$storeid);
		if(empty($waimaitype)){
			$params = array(
					'storeid'=>$storeid,
					'type'=> 2,
			);
			$ret = getPingtaiApiData("public.weixindata.getstoreType",$params);
			if( $ret['code'] ==1 && !empty($ret['data']) ){
				if(empty($ret['data']['type'])){
					return array (
						'msg' => "成功！",
						'data' => array(),
						'storestatus' => $storestatus,
						'success' => true,
					);
				}
				/* 存数据 */
				S(WXAPPID."_Waimai_GoodsTypeData".$storeid,$ret['data']);
				$waimaitype = $ret['data'] ;
			}else{
				return array (
						'msg' => "成功！",
						'data' => array(),
						'storestatus' => $storestatus,
						'success' => true,
				);
			}
		}
		$waimaitype = json_decode($waimaitype,true);
		
		/* 外卖商品 */
		$waimaiGoods = S(WXAPPID."_Waimai_GoodsData".$storeid);
		if(empty($waimaiGoods)){
			$params = array(
					'storeid'=>$storeid,
					'type'=> 2,
			);
			$ret = getPingtaiApiData("public.weixindata.getstoregoods",$params); 
			if( $ret['code'] ==1 && !empty($ret['data']) ){
				/* 存数据 */
				S(WXAPPID."_Waimai_GoodsData".$storeid,$ret['data']);
				$waimaiGoods = $ret['data'] ;
			}
		}
		$waimaiGoods = json_decode($waimaiGoods,true);
		
		/* 拼数据 */
		foreach($waimaitype as $k => $type){
			if(empty($waimaiGoods[$type['typeid']])) unset($waimaitype[$k]);
		}
		$waimaitype = array_values($waimaitype);
		$data = array("goods"=> $waimaiGoods,"type"=>$waimaitype);
		$data['packbox'] = $waimaiConfig['DELIVERY_PACKBOX'];
		$waimaiConfig['DELIVERY_GOODS']['freecharge'] = $waimaiConfig['DELIVERY_PRICE'];
		$data['deliveryinfo'] = $waimaiConfig['DELIVERY_GOODS'];
		$data['timesinfo'] = array(
				'maketime' =>  $waimaiConfig['DELIVERY_YYTTIME'],	//可预约时间（天含今日）
				'starttime' =>	$waimaiConfig['DELIVERY_STIME'],	//开始时间（送达时间）
				'stoptime' => 	$waimaiConfig['DELIVERY_YTIME'], // 结束时间（送达时间）
				'deliverytime' => $waimaiConfig['DELIVERY_YYSTIME'] //预计配送需要的时间
		);
		$data['storedatu'] = $datu;
		$data['storefapiao'] = $isfapiao;
		$data['paytype'] = array_values(C("WAIMAIPAYTYPECONFIG"));
		
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
		);
		$userret = getPingtaiApiData("public.weixindata.MyinfoList",$params);
		$data['useryue'] = null;
		if($userret['code'] == 1){
			$data['useryue'] = $userret['data']['yue'];
		}
		$ispay = C('WEIXINPAY_STATUS');
		if($ispay === null) $ispay = false;
		$data['isweixinpay'] = (boolean)$ispay;
		if($ispay === false){
			$newpay = array();
			foreach($data['paytype'] as $pv){
				if($pv['paytype'] != '2'){
					$newpay[] = $pv;
				}
			}
			$data['paytype'] = $newpay;
		}
		return array (
				'msg' => "成功！",
				'data' => $data,
				'storestatus' => $storestatus,
				'success' => true,
		);
	}

	/**
	 * 获取自助点餐商品
	 * 参数$_POST['storeid]
	 */
	public function getZizhuGoods(){
		
		$zizuConfig = S(WXAPPID."_Zizhu_StoreConfig".$_POST['storeid']);
		$data = array();
		/* 获取自助门店配置 */
		if(empty($zizuConfig)){
			$params = array(
					'storeid'=>$_POST['storeid'],
			);
			$ret = getPingtaiApiData("public.weixindata.getZizhuStoreConfig",$params);
			if($ret['code']==1 && !empty($ret['data']) ){
				$zizuConfig = $ret['data'];
				/* 保存数据 */
				S(WXAPPID."_Zizhu_StoreConfig".$_POST['storeid'],$ret['data']) ;
			}else{
				return array (
						'msg' => "成功！",
						'data' => array(),
						'success' => true,
				);
			}
		}
		$zizuConfig = json_decode($zizuConfig,true);
		$packbox = array();
		if(!$zizuConfig['SHOPPING_DEFAULTCONFIG']){
			$data['packbox'] = $zizuConfig['SHOPPING_PACKBOX'];
			$data['timesinfo'] = array(
				'maketime' =>  $zizuConfig['SHOPPING_YYTTIME'],	//可预约时间（天含今日）
				'starttime' =>	$zizuConfig['SHOPPING_STIME'],	//开始时间（送达时间）
				'stoptime' => 	$zizuConfig['SHOPPING_TTIME'], // 结束时间（送达时间）
			);
		}else{
			$allconfig= C("ZIZHUCONFIG");
			$data['packbox'] = $allconfig['SHOPPING_PACKBOX'];
			$data['timesinfo'] = array(
				'maketime' =>  $allconfig['SHOPPING_YYTTIME'],	//可预约时间（天含今日）
				'starttime' =>	$allconfig['SHOPPING_STIME'],	//开始时间（送达时间）
				'stoptime' => 	$allconfig['SHOPPING_TTIME'], // 结束时间（送达时间）
			);
		}
		if(!isset($zizuConfig['storetype'])){
			$zizhuStore = S(WXAPPID."_Zizhu_StoreList");
			$zizhuStore = json_decode($zizhuStore,true);
			if(empty($zizhuStore)){
				$zizhuStore = array();
				$zizhuData = json_decode(S(WXAPPID."_Zizhu_StoreList"),true);
				foreach($zizhuData as $v){
					$zizhuStore[$v['storeid']] = $v;
				}			
				S(WXAPPID."_Zizhu_StoreData",$zizhuStore);	
			}
			$storetype = $zizhuStore[$_POST['storeid']]['storetype'];
			$storename = $zizhuStore[$_POST['storeid']]['storename'];
		}
		/*是否使用全局商品  */
		if(isset($zizuConfig['SHOPPING_DEFAULTCONFIG']) && !$zizuConfig['SHOPPING_DEFAULTGOODS']){
			$storeid = $_POST['storeid'];
		}else{
			$storeid = '0';
		}
		/* 校验门店是否开启大图 */
		if(!isset($zizuConfig['SHOPPING_DATUCONFIG'])){
			if(empty($allconfig)) $allconfig= C("ZIZHUCONFIG");
			$datu = isset($allconfig['SHOPPING_DATUCONFIG'])?$allconfig['SHOPPING_DATUCONFIG']:false;
		}else {
			$datu = $zizuConfig['SHOPPING_DATUCONFIG'];
		}
		$isfapiao = false;
		if(isset($zizuConfig['PUBLIC_FAPIAOCONFIG'])){
			$isfapiao = $zizuConfig['PUBLIC_FAPIAOCONFIG'];
		}else{
			$isfapiao = C('PUBLIC_FAPIAOCONFIG');
			if($isfapiao === null) $isfapiao = false;
		}
		if($zizuConfig['SHOPPING_DEFAULTGOODS'] == 'true'){
			$zizuConfig = $allconfig;
			if(empty($allconfig)) $zizuConfig = C("ZIZHUCONFIG");
		}
		/* 自助分类 */
		$zizhutype = S(WXAPPID."_Zizhu_GoodsTypeData".$storeid);
		
		if(empty($zizhutype)){
			$params = array(
					'storeid' => $storeid,
					'type'=> 1,
			);
			$ret = getPingtaiApiData("public.weixindata.getstoreType",$params);
			if($ret['code']==1 && !empty($ret['data'])){
				if(empty($ret['data'])){
					return array (
						'msg' => "成功！",
						'data' => array(),
						'success' => true,
					);
				}
				$zizhutype = $ret['data'];
				/* 保存数据 */
				S(WXAPPID."_Zizhu_GoodsTypeData ".$storeid,$ret['data']) ;
			}else{
				return array (
						'msg' => "成功！",
						'data' => array(),
						'success' => true,
				);
			}
		}
		$zizhutype = json_decode($zizhutype,true);
		/*自助商品 */
		$zizhuGoods = S(WXAPPID."_Zizhu_GoodsData".$storeid);
//		$zizhuGoods = array();
		if(empty($zizhuGoods)){
			$params = array(
					'storeid'=>$storeid,
					'type'=> 1,
			);
			$ret = getPingtaiApiData("public.weixindata.getstoregoods",$params);
			if($ret['code']==1 && !empty($ret['data']) ){
				$zizhuGoods = $ret['data'];
				/* 保存数据 */
				S(WXAPPID."_Zizhu_GoodsData ".$storeid,$ret['data']);
			}
		}
		$zizhuGoods = json_decode($zizhuGoods,true);
		/* 拼数据 */
		foreach($zizhutype as $k => $type){
			if(empty($zizhuGoods[$type['typeid']])) unset($zizhutype[$k]);
		}
		$zizhutype = array_values($zizhutype);
		$data["goods"] = $zizhuGoods;
		$data["type"] = $zizhutype;
		$paytype = array_values(C("ZIZHUPAYTYPECONFIG"));
		$data['paytype'] = empty($paytype)?array():$paytype;
		$data['storetype'] = $storetype;
		$data['storename'] = $storename;
		$data['storedatu'] = $datu;
		$data['storefapiao'] = $isfapiao;
		$data['islogin'] = is_login();
		
		/*获取用户余额*/
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
		);
		$userret = getPingtaiApiData("public.weixindata.MyinfoList",$params);
		$data['useryue'] = null;
		if($userret['code'] == 1){
			$data['useryue'] = $userret['data']['yue'];
		}
		$ispay = C('WEIXINPAY_STATUS');
		if($ispay === null) $ispay = false;
		$data['isweixinpay'] = (boolean)$ispay;
		if($ispay === false){
			$newpay = array();
			foreach($data['paytype'] as $pv){
				if($pv['paytype'] != '2'){
					$newpay[] = $pv;
				}
			}
			$data['paytype'] = $newpay;
		}
		return array (
				'msg' => "成功！",
				'data' => $data,
				'success' => true,
		);  
	}
	/**
	 * 领水
	 * @return multitype:boolean unknown Ambigous <string, multitype:number string unknown Ambigous <mixed, void, multitype:, NULL> Ambigous <mixed, void, NULL, multitype:> >
	 */
	public function getLimitGoods(){
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
				'activityid' => $_POST['activityid'],
		);
		$ret = getPingtaiApiData("public.weixindata.getLimitGoods",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'ret' => $ret,
				'success' => $ret['code'] ==1? true : false,
		);
	}
	
	public function getactivityGoods(){
		
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
				'activityid' => $_POST['activityid'],
				'storeid' => $_POST['storeid'],
		);
		$ret = getPingtaiApiData("public.weixindata.getactivityGoods",$params);
		$ret['data']['islogin'] = is_login();
		$ispay = $ret['data']['isweixinpay'];
		if($ispay === null) $ispay = false;
		$data['isweixinpay'] = (boolean)$ispay;
		if($ispay === false){
			$newpay = array();
			foreach($ret['data']['paytype'] as $pv){
				if($pv['paytype'] != '2'){
					$newpay[] = $pv;
				}
			}
			$ret['data']['paytype'] = $newpay;
		}
		$ret['data']['ucode'] = $_SESSION['USERINFO']['ucode'];
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		);
	}
		
}