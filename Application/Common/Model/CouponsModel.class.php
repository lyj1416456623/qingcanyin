<?php
namespace Common\Model;
class CouponsModel{
	
	public function getMyCoupons(){
		
		$params = array(
			'page'=>$_POST['page'],
			'page_size'=> $_POST['pagenumber'],
			'ucode' => $_SESSION['USERINFO']['ucode'],
		);
		
		$ret = getPingtaiApiData("public.weixindata.getCouponsList",$params);
		if($ret['code']=='1'){
			$data = array();
			foreach ($ret['data'] as $v){
				$data[] = array(
					'id'=> $v['code'],
					'title'=>'现金券¥'.$v['price'],
					'background' => '#DF9C33',
					'icon'=>C('FILEURL').'zizhudiancan.png',
					'endtime'=>$v['ttime'],
				);
			}
		}
		return array (
				'msg' => "查询成功",
				'data' => $data,
				'success' => true,
		);
	}
	/**
	 * 券码详情
	 */
	public function getDetail(){
		$id = $_POST ['id'];
		$params = array(
			'code'=>$id,
			'ucode'=> $_SESSION['USERINFO']['ucode'],	
		);
		$ret = getPingtaiApiData("public.weixindata.getCouponDetail",$params);
		return array (
				'msg' => $ret['msg'],
				'data' => empty($ret['data']) ? array(): $ret['data'],
				'success' => $ret['code'] ==1 ? true : false,
		);
	}
}