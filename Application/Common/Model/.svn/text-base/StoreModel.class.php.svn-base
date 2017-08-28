<?php
namespace Common\Model;
class StoreModel{
	
	/**
	 * 获取全部门店列表
	 */
	public function getAllStore(){
		$params = array();
		$ret = getPingtaiApiData('public.weixindata.getAllstore',$params);
		return array (
			'data' => empty($ret['data'])?array():$ret['data'],
			'msg' => '数据获取成功',
			'rest' => $ret,
			'success' => true
		);
	}
	/**
	 * 获取支持自助点餐的门店
	 */
	public function getZizhuStore(){
		$storeidtodata = S(WXAPPID."_Zizhu_StoreList");
		$storeidtodata = json_decode($storeidtodata,true);
		$storeidtodatavalue = array_values($storeidtodata);
		if(md5(json_encode($storeidtodatavalue)) != md5(json_encode($zizhuStore)) || empty($storeidtodata)){
			if(empty($zizhuStore)){
				$ret = getPingtaiApiData('public.weixindata.getSelfHelepStoreList');
				if($ret['code']=='1'){
					if(empty($ret['data'])){
						return array (
								'data' => array(),
								'msg' => '店家未设置营业门店！',
								'success' => false
						);
					}
					S(WXAPPID."_Zizhu_StoreData",json_encode($ret['data']));
					$zizhuStore = $ret['data'];
				}
			}
			$storeidtodata = array();
			foreach($zizhuStore as &$v){
				$storenotice = S(WXAPPID.'_Zizhu_StoreNoticeConfig'.$v['storeid']);
				$storenotice = json_decode($storenotice,true);
				$notice = empty($storenotice['SHOPPING_DEFAULTNOTICE'])?"暂无公告":$storenotice['SHOPPING_DEFAULTNOTICE'];
				$v['notice'] = $notice;
				$storeidtodata[$v['storeid']] = $v;
			}
			S(WXAPPID."_Zizhu_StoreList",json_encode($storeidtodata));
		}else{
			$zizhuStore = $storeidtodata;
		}
		
		$data = array();
		if(!empty($_POST['storeid'])){
			$data = $storeidtodata[$_POST['storeid']];
			$zizhuConfig = S(WXAPPID."_Zizhu_StoreConfig".$_POST['storeid']);
			if($zizhuConfig['SHOPPING_DEFAULTCONFIG']) $zizhuConfig = C("ZIZHUCONFIG");
			$data['starttime'] = $zizhuConfig['SHOPPING_STIME'];
			$data['endtime'] = $zizhuConfig['SHOPPING_TTIME'];
			$data['starttime'] = date("H:i:s",strtotime($data['starttime']));
			$data['endtime'] = date("H:i:s",strtotime($data['endtime']));

			$waimaiConfig = S(WXAPPID."_Waimai_StoreConfig".$_POST['storeid']);
			if($waimaiConfig['DELIVERY_DATUCONFIG']) $waimaiConfig = C("WAIMAICONFIG");
			$data['waisongstime'] = empty($waimaiConfig['DELIVERY_STIME'])?$data['waisongstime']:$waimaiConfig['DELIVERY_STIME'];
			$data['waisongttime'] = empty($waimaiConfig['DELIVERY_YTIME'])?$data['waisongttime']:$waimaiConfig['DELIVERY_YTIME'];
			$data['waisongstime'] = date("H:i:s",strtotime($data['waisongstime']));
			$data['waisongttime'] = date("H:i:s",strtotime($data['waisongttime']));
		}else{
			$data = $zizhuStore;
		}
		return array (
				'data' => $data ? $data : array(),
				'msg' => '数据获取成功',
				'success' => true
		);
	}
}