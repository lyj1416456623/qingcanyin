<?php
namespace Common\Model;
class IntegralModel{
	
	/**
	 * 获取积分兑换列表
	 */
	public function getList(){
		$params = array(
				'type'=>'1',
				'uid'=> $_SESSION['USERINFO']['uid'],
		);
		$result = getOpenApiData("public.memberintegral.getIntegralGoodsList",$params);
		$data = array();
		/* 此处拼参数 */
		if($result['code']==1){
			foreach($result['data'] as $v){
				/* 已兑换数量 */
				$hvexchange = 0;
				if(!empty($v['logs'])){
					foreach($v['logs'] as $p){
						$p = json_decode($p,true);
						$hvexchange +=$p['num'];
					}
				}
				/*兑换数量有限 */
				if($v['uenum']>0 && $v['uenum']<=$v['available']){
					$surplus = $v['uenum']-$hvexchange >=0 ? $v['uenum']-$hvexchange :0 ;
				}else{
				/* 兑换数量不限制 */
					$surplus = $v['available']>=0 ? $v['available'] : 0;
				}
				$rst = array(	
					'pic' => $v['pic'],
					'surplus' => (int)$surplus, /*用户可用数量  */
					'type' => $v['type']==1 ? 2 : 1 , /* 兑换类型（1兑换券、现金券等2需要邮寄的物品，该类会要求提交配送地址） */
					'id' => $v['imid'], /*  积分兑换商品ID */
					'integral' => $v['integral'],  /* 所需积分 */
					'text' => $v['title'], 	/* 商品名称 */
					'available'=> $v['available']>=0 ? $v['available'] : 0, /* 此商品剩余数量 */
				);
				$rst['available'] = (int)$rst['available'];
				$data[] = $rst;
			}
		}
		$len = count($data);
		for($k=1;$k<$len;$k++) {
		 	for($j=0;$j<$len-$k;$j++){
		 		if($data[$j]['surplus']<$data[$j+1]['surplus']){
		 			$temp =$data[$j+1];
		 			$data[$j+1] =$data[$j] ;
		 			$data[$j] = $temp;
		 		}
		 	}
		 }
		return array (
			'msg' => $result['msg'],
			'data' => $data,
			'success' => $result['code']==1? true : false ,
		);
	}
	/**
	 * 获取积分商品详情
	 */
	public function getDetail(){
		$id = $_POST['id'];
		$params = array(
			'id'=>$id,
			'uid' => $_SESSION['USERINFO']['uid'],
		);
		$ret = getOpenApiData("public.memberintegral.getIntegralGoods",$params);
		if($ret['code']==1){
			if(!empty($ret['data']['pic'])) {
				$ret['data']['pic'] = array($ret['data']['pic']."_480");
			}else{
				$ret['data']['pic'] = array();
			}
			
			$result= array (
				'id' 			=>$ret['data']['imid'], // 积分兑换商品ID
				'integral' 		=>$ret['data']['integral'], // 所需积分
				'type' 			=>$ret['data']['type']==1 ? 2 : 1 , // 兑换类型（1兑换券、现金券等2需要邮寄的物品，该类会要求提交配送地址）
				'images' 		=>$ret['data']['pic'],
				'surplus' 		=>$ret['data']['available']>=0 ? $ret['data']['available'] : 0,/*  */ // 剩余可兑换数量
				//'usersurplus' 	=>$ret['data']['uenum'], /* 用户可兑换数量 */
				'endtime' 		=>$ret['data']['tdate'], // 活动结束日期
				'goodsname'	 	=>$ret['data']['title'], // 兑换商品名称
				'goodsendtime' 	=>$ret['data']['days'].'天', // 兑换商品有效期
				'sprice'		=>$ret['data']['sprice'], //若是券 0则不限制消费条件  其他是 例：满200可使用此券
				'text'			=> "需要{$ret['data']['integral']}积分才可以兑换商品哦！",
				'price'			=>$ret['data']['price'], /* 卡券面值 */
				//'uenum'			=> $ret['data']['uenum'] ==0 ? , /*每人可兑换数量 */
			);
			$result['uenum'] = $ret['data']['uenum']>0 ? $ret['data']['uenum'] : $result['surplus']; 
			/* 已兑换数量 */
			$hvexchange = 0;
			if(!empty($ret['data']['logs'])){
				foreach($ret['data']['logs'] as $v){
					$v = json_decode($v,true);
					$hvexchange +=$v['num'];
				}
			}
			/* 有限制的兑换数量 */
			if($ret['data']['uenum'] !=0) {
				$last = $ret['data']['uenum'] - $hvexchange;
				if($last<=0) $result['usersurplus'] = 0;
				if($last>0 && $last>$result['surplus']) $result['usersurplus'] = $result['surplus'];
				if($last>0 &&  $last<=$result['surplus']) $result['usersurplus'] = $ret['data']['uenum']-$hvexchange;
			}else{
				$result['usersurplus'] = $result['surplus'];
			}
			if($ret['data']['sprice']>0 && $ret['data']['type']==2 ){
				$result['text'] = "满¥{$ret['data']['sprice']}可使用该券,每次只能兑换1张";
			}
			if($ret['data']['sprice'] ==0.00 && $ret['data']['type']==2 ){
				$result['text'] = "此券不可兑换现金，不受消费额限制，每次只能兑换1张";
			}		
			if($ret['data']['type']==1){
				$result['text'] = "每次只能兑换1份商品";
			}
		}
		
		return array (
			'msg' => '查询成功',
			'data' => $result,
			'success' => true
		);
	}
	
	/**
	 * 兑换
	 */
	public function Exchange(){
		$address = array(
			'address'=>$_POST['address'],
			'phone'=> $_POST['phone'],
			'uname'=> $_POST['uname'],
		);
		$params = array(
				'id'=> $_POST['id'],
				'ucode'=> $_SESSION['USERINFO']['ucode'],
				'address'=>json_encode($address),
				'num'=> 1,
				'wxappid'=> WXAPPID,
		);
		$ret = getOpenApiData("public.memberintegral.exchangeIntegralGoods",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code']==1 ? true : false ,
		);
	}
	
	/**
	 * 兑换记录 
	 * @todo getexchangedetail 和此方式有管理 需要做缓存 
	 */
	public function getExchangeLog(){
		$params = array(
				'ucode'=> $_SESSION['USERINFO']['ucode'],
		);
		
		$ret = getOpenApiData("public.memberintegral.getExchangeLog",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code']==1? true : false ,
		);
		
	}
	/**
	 * 兑换记录详情 
	 * @return multitype:boolean unknown Ambigous <>
	 */
	public function getexchangedetail(){
		$params = array(
				'id'=> $_POST['id'],
		);
		$ret = getOpenApiData("public.memberintegral.getExchgeDetail",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code']==1? true : false ,
		);
	}
	
}