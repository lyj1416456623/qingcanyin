<?php
namespace Common\Model;
class AddressModel{
	/**
	 * 根据关键字搜索地址（外卖）
	 */
	public function searchAddress(){
		$params = array('address'=>$_POST['key']);
		//外卖门店
		$storeList = getPingtaiApiData('public.weixindata.getStoreId');
		$waimaistore = $storeList['data']['waimaistore'];
		if(empty($waimaistore)){
			return array (
					'msg' => "没有支持外卖的门店",
					'data' => $storeList,
					'success' => false,
			);
		} 
		$ret = getOpenApiData('public.waimaixinyistore.getStoreArea',$params);
		$result = $ret['data']['suggestions'];
		if(empty($result)) $result = array();
		$data = array();
		foreach($result as $v){
			$rest= explode("|",$v['data']);
			if(empty($rest[0])){
				if(!empty($waimaistore[$rest[2]])){
					$data[] = array (
						'id' =>'',
						'storeid' => $rest[2],
						'storename' => '',
						'address' =>$rest[4],
						'lat' => '0.00', // 经纬度
						'lng' => '0.00', // 经纬度
						'long' => '', // 距离
						'longtime' => $rest[5], // 所需时间分钟
					); // 外卖结束时间
				}
			}else{
				if(!empty($waimaistore[$rest[2]])){
					$point = explode(",",$rest[6]);
					$lng = empty($point[0]) ? 0.00 : $point[0];
					$lat = empty($point[1]) ? 0.00 : $point[1];
					$data [] = array (
							'id' => $rest[0],
							'storeid' => $rest[2],
							'storename' => '',
							'address' =>$rest[3],
							'lat' => $lat, // 经纬度
							'lng' => $lng, // 经纬度
							'long' => $rest[5], // 距离
							'longtime' => $rest[4], // 所需时间分钟
					); // 外卖结束时间
				}
			}
		}
		return array (
				'msg' => $ret['msg'],
				'data' => $data,
				'success' => $ret['code']==1 ? true : false,
		);
		
	}
	
	/**
	 * 获取我的送餐地址列表
	 */
	public function getMyAddress(){
		$params = array("uid"=> $_SESSION['USERINFO']['uid']);
		$ret = getPingtaiApiData('public.weixindata.getUserAddresslist',$params);
		return array (
				'msg' => "查询成功！",
				'data' => empty($ret['data']) ? array() : $ret['data'],
				'success' => true,
		);
	}
	/**
	 * 获取可用城市列表
	 */
	public function getClityList(){
		$data = S(WXAPPID."getClityList");
		if(empty($data)){
			$ret = getPingtaiApiData('public.weixindata.getCityList');
			if($ret['code']==1){
				$data = $ret['data'];
				S(WXAPPID."getClityList",$ret['data']);
			}
		}
		return array (
			'msg' => "查询成功！",
			'data' => empty($data) ? array() : $data,
			'success' => true,
		);
	}
	/**
	 * 保存我的送餐地址
	 */
	public function addAddress(){
		$postdata = json_decode($_POST['datajson'],true);
		$params = array (
				'uid' => $_SESSION['USERINFO']['uid'],
				'storeid' => $postdata['storeid'],
				'default' => $postdata['default'] ,
				'lng' => $postdata ['lng'],
				'lat' => $postdata ['lat'],
				'name' => $postdata ['name'],
				'phone' => $postdata ['phone'],
				'cityid' => $postdata ['cityid'],
				'address' => $postdata ['address'],
				'addressdetail' => $postdata ['addressdetail'],
				'addressall' => $postdata ['address'] . $postdata ['addressdetail']
		);
		$ret = getPingtaiApiData('public.weixindata.addUserAddress',$params);
		$params['addressid'] = $ret['data'];
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['code'] == 1 ? $params : array(),
				'success' => $ret['code']== 1 ? true :false ,
		);
	}
	/**
	 * 修改我的送餐地址
	 */
	public function editAddress(){
		$postdata = json_decode($_POST['datajson'],true);
		$params = array (
				'addressid' => $postdata['addressid'],
				'uid' => $_SESSION['USERINFO']['uid'],
				'storeid' => $postdata ['storeid'],
				'default' => '1',
				'lng' => $postdata ['lng'],
				'lat' => $postdata ['lat'],
				'name' => $postdata ['name'],
				'phone' => $postdata ['phone'],
				'cityid' => $postdata ['cityid'],
				'address' => $postdata ['address'],
				'addressdetail' => $postdata ['addressdetail'],
				'addressall' => $postdata ['address'] . $postdata ['addressdetail']
		);
		$ret = getPingtaiApiData('public.weixindata.editUserAddress',$params);
		return array (
				'msg' => $ret['msg'],
				'data' => $ret['code'] == 1 ? $params : array(),
				'success' => $ret['code']== 1 ? true :false ,
		);
	}
	/**
	 * 删除我的送餐地址
	 */
	public function delAddress(){
		$params = array(
				"uid"=> $_SESSION['USERINFO']['uid'],
				"addressid" => $_POST['addressid'],
		);
		$ret = getPingtaiApiData('public.weixindata.delUserAddress',$params);
		return array (
				'msg' => $ret['msg'],
				'data' => array(),
				'success' => $ret['code']== 1 ? true :false ,
		);
	}
	
}