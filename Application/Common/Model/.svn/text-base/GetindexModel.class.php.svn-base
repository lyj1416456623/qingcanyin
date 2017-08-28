<?php
namespace Common\Model;
class GetindexModel{
	
	public function getWeisoftData(){
		$items = C('WEIXININDEXBUTTON');
		$data ['title'] = C('BUSINESSNAME');
		$data ['headBgImage'] = $items['background']; // 头部背景图片
		$data ['qrcode'] = $items['payqrcode']; //扫码支付功能
		$data ['copyright'] = 'Copyright © 2008-2016 qingcanyin.cn';
		if(isset($items['guanggaodata']) && $items['guanggao']['status']){
			$order = $items['guanggaodata'];
			$len = count($order);
			for($k=1;$k<$len;$k++) {
				for($j=0;$j<$len-$k;$j++){
					if($order[$j]['ordering']>$order[$j+1]['ordering']){
						$temp =$order[$j+1];
						$order[$j+1] =$order[$j] ;
						$order[$j] = $temp;
					}
				}
			}
			$data['guanggaodata'] = $order;
		}else{
			$data['guanggaodata'] = array();
		}
		if (is_login()) {
			$uid = getUid();
			$data['uid'] = md5($uid);
			if(empty($_SESSION['USERINFO']['jifen'])){
				$ret = getPingtaiApiData("public.weixindata.getUserAccount",array('ucode'=>$_SESSION['USERINFO']['ucode']));
				$_SESSION['USERINFO']['jifen'] = $ret['data']['jifen'];
				$_SESSION['USERINFO']['yue'] = $ret['data']['yue'];
			}
			//@todo 通过逻辑查询这些信息
			$data ['username'] = $_SESSION['USERINFO']['nickname'];
			$data ['usericon'] = empty($_SESSION['USERINFO']['icon'])?'http://f.xinyisoft.org/a43a238a74cf7cc61177ba64b9ff13d2_480':$_SESSION['USERINFO']['icon'];
			$data ['jifen'] = $_SESSION['USERINFO']['jifen'];
			$data ['yue'] = $_SESSION['USERINFO']['yue'];
		} else {
			$data ['username'] = '请登录';
			$data ['usericon'] = 'http://f.xinyisoft.org/a43a238a74cf7cc61177ba64b9ff13d2_480';
			$data ['jifen'] = '请登录';
			$data ['yue'] = '请登录';
		}
		$tmp = array (
				array (
						'id' => 'zizhu',
						'link' => '/pages/zizhu/selectstore',
						'name' => '自助点餐',
						'icon' => '/style/images/zizhudiancan.png'
				),
				array (
						'id' => 'waimai',
						'link' => '/pages/waimai/selectaddress',
						'name' => '外卖订餐',
						'icon' => '/style/images/waimaidiancan.png'
				),
				array (
						'id' => 'jifenshangcheng',
						'link' => '/pages/jifenshangcheng/index',
						'name' => '积分商城',
						'icon' => '/style/images/jifenshangcheng.png'
				),
				array (
						'id' => 'chongzhi',
						'link' => '/pages/zhanghu/index',
						'name' => '账户充值',
						'icon' => '/style/images/zhanghuchongzhi.png'
				),
				array (
						'id' => 'myorder',
						'link' => '/pages/myorder/index',
						'name' => '我的订单',
						'icon' => '/style/images/maidan.png'
				),
				array (
						'id' => 'mycoupons',
						'link' => '/pages/mycoupons/index',
						'name' => '我的券码',
						'icon' => '/style/images/dianping.png'
				),
				array (
						'id' => 'mycaiwuliushui',
						'link' => '/pages/caiwuliushui/index',
						'name' => '财务流水',
						'icon' => '/style/images/caiwujilu.png'
				),
				array (
						'id' => 'myjifenliushui',
						'link' => '/pages/jifenliushui/index',
						'name' => '积分流水',
						'icon' => '/style/images/jifenjilu.png'
				)
		);
		$data ['headItems'] =array();
		foreach($tmp as $k=>$v){
			if($items[$v['id']]['status']){
				$v['name'] =  $items[$v['id']]['text'];
				$v['icon'] =  $items[$v['id']]['icon'];
				$data ['headItems'][] = $v;
			}
		}
		return array(
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true
		);
	}
	
	public function getWebData(){
		$items = C('WEIXININDEXBUTTON');
		$data ['title'] = C('BUSINESSNAME');
		$data ['headBgImage'] = $items['background']; // 头部北京图片
		$data ['qrcode'] = $items['payqrcode']; //扫码支付功能
		$data ['copyright'] = 'Copyright © 2008-2016 qingcanyin.cn';
		if(isset($items['guanggaodata']) && $items['guanggao']['status']){
			$order = $items['guanggaodata'];
			$len = count($order);
			for($k=1;$k<$len;$k++) {
				for($j=0;$j<$len-$k;$j++){
					if($order[$j]['ordering']>$order[$j+1]['ordering']){
						$temp =$order[$j+1];
						$order[$j+1] =$order[$j] ;
						$order[$j] = $temp;
					}
				}
			}
			$data['guanggaodata'] = $order;
		}else{
			$data['guanggaodata'] = array();
		}
		if (is_login()) {
			$uid = getUid();
			$data['uid'] = md5($uid);
			$ret = getPingtaiApiData("public.weixindata.getUserAccount",array('ucode'=>$_SESSION['USERINFO']['ucode']));
			$_SESSION['USERINFO']['jifen'] = $ret['data']['jifen'];
			$_SESSION['USERINFO']['yue'] = $ret['data']['yue'];
			//@todo 通过逻辑查询这些信息
			$data ['username'] = $_SESSION['USERINFO']['nickname'];
			$data ['usericon'] = empty($items['usericon']['icon']) ?  'http://f.xinyisoft.org/a43a238a74cf7cc61177ba64b9ff13d2_480' : $items['usericon']['icon'];
			$data ['jifen'] = $_SESSION['USERINFO']['jifen'];
			$data ['yue'] = $_SESSION['USERINFO']['yue'];
		} else {
			$data ['username'] = '请登录';
//			$data ['usericon'] = 'http://f.xinyisoft.org/a43a238a74cf7cc61177ba64b9ff13d2_480';
			$data ['jifen'] = '请登录';
			$data ['yue'] = '请登录';
			$data ['usericon'] = empty($items['usericon']['icon']) ?  'http://f.xinyisoft.org/a43a238a74cf7cc61177ba64b9ff13d2_480' : $items['usericon']['icon'];
		}
		//这些信息不需要判断是否登陆，只需要根据后台的设置显示即可
		$tmp = array (
				array (
						'id' => 'zizhu',
						'link' => U('Selfshopping/selectstore'),
						'name' => '自助点餐',
						'icon' => '/Public/images/icon/zizhudiancan.png'
				),
				array (
						'id' => 'waimai',
						'link' => U('Shopping/selectaddress'),
						'name' => '外卖订餐',
						'icon' => '/Public/images/icon/waimaidiancan.png'
				),
				array (
						'id' => 'jifenshangcheng',
						'link' => U('Integralshop/index'),
						'name' => '积分商城',
						'icon' => '/Public/images/icon/jifenshangcheng.png'
				),
				array (
						'id' => 'chongzhi',
						'link' => U('Recharge/index'),
						'name' => '账户充值',
						'icon' => '/Public/images/icon/zhanghuchongzhi.png'
				),
				array (
						'id' => 'myorder',
						'link' => U('Myorder/index'),
						'name' => '我的订单',
						'icon' => '/Public/images/icon/maidan.png'
				),
				array (
						'id' => 'mycoupons',
						'link' => U('Mycoupons/index'),
						'name' => '我的券码',
						'icon' => '/Public/images/icon/dianping.png'
				),
				array (
						'id' => 'mycaiwuliushui',
						'link' => U('Myaccount/index'),
						'name' => '财务流水',
						'icon' => '/Public/images/icon/caiwujilu.png'
				),
				array (
						'id' => 'myjifenliushui',
						'link' => U('Myintegral/index'),
						'name' => '积分流水',
						'icon' => '/Public/images/icon/jifenjilu.png'
				)
		);
		$data ['headItems'] = array();
		foreach($tmp as $k=>$v){
			if($items[$v['id']]['status']){
				$v['name'] =  $items[$v['id']]['text'];
				$v['icon'] =  $items[$v['id']]['icon'];
				$data ['headItems'][] = $v;
			}
		}
		return array(
				'msg' => "数据拉取成功！",
				'data' => $data,
				'index' => $items,
				'success' => true
		);
	}
	/* 获取用户基本信息 */
	public function getUserdata(){
		if (is_login()) {
			$uid = getUid();
			$data['uid'] = md5($uid);
			$ret = getPingtaiApiData("public.weixindata.getUserAccount",array('ucode'=>$_SESSION['USERINFO']['ucode']));
			$_SESSION['USERINFO']['jifen'] = $ret['data']['jifen'];
			$_SESSION['USERINFO']['yue'] = $ret['data']['yue'];
			$data ['username'] = $_SESSION['USERINFO']['nickname'];
			$data ['usericon'] = empty($_SESSION['USERINFO']['icon'])?'http://f.xinyisoft.org/a43a238a74cf7cc61177ba64b9ff13d2_480':$_SESSION['USERINFO']['icon'];
			$data ['jifen'] = $_SESSION['USERINFO']['jifen'];
			$data ['yue'] = $_SESSION['USERINFO']['yue'];
		}else{
			$data ['username'] = '请登录';
			$data ['usericon'] = 'http://f.xinyisoft.org/a43a238a74cf7cc61177ba64b9ff13d2_480';
			$data ['jifen'] = '请登录';
			$data ['yue'] = '请登录';
		}
		
		return array(
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true
		);
	}
}