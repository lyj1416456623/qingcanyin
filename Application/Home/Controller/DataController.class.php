<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 获取数据
 * @author qiude
 *
 */
class DataController extends Controller{

	/**
	 * 发送短信验证码
	 */
	public function sendsmscode() {
		
		// 本方法可以接收到微信的用户信息和phone参数，具体可以打印出来查看
		// 建议做好安全验证，比如频繁发送验证、发送次数限制
		// 由于无法通过session来鉴权，所以这里只能自己想办法临时存储这个code
		$params = array(
				'phone'=>$_POST['phone'],
				'type' =>$_POST['type'], /* 1:登录     2：找回密码 */
		);
		$ret = getPingtaiApiData("public.weixindata.sendShortMsg",$params);
		$_SESSION['phonecode'] = $ret['data'];
		die ( json_encode ( array (
				'msg' => $ret['msg'],
				'success' => $ret['code'] == 1? true :false
		) ) );
		
	}
	
	public function _initialize() {
		$_POST = $_REQUEST;
	}
	public function api() {
		if (! empty ( $_POST ['mothed'] )) {
			$mothed = str_replace ( 'Weisoft/', '', $_POST ['mothed'] );
			if (! empty ( $mothed )) {
				$this->$mothed ();
				die ();
			}
		}
		die ( json_encode ( array (
				'msg' => 'mothed参数错误哦',
				'success' => false 
		) ) );
	}
	public function test1(){
		echo session_id();
	}
	/**
	 * 用来进行分享统计
	 */
	public function fenxianglog() {
		// 检测到是通过分享进来的会调用这个接口，参数为：
		// $_POST['sharecode'] = '1sdasdsdasdasdasasdasdadsa';//分享者分享编号唯一
		// $_POST['uid'] = '2';//进入该分享页面的用户id
		// $_POST['openid'] = '2311233211232321';//访问分享连接的微信openid
		// $_POST['url'] = '/index/index';//访问者进入页面地址
		die ( json_encode ( array (
				'data' => $_POST,
				'msg' => '数据获取成功',
				'success' => true 
		) ) );
	}
	
	/**
	 * 用来进行分享统计
	 */
	public function addfenxiang() {
		// 检测到是通过分享进来的会调用这个接口，参数为：
		// $_POST['uid'] = '2';//进入该分享页面的用户id
		// $_POST['openid'] = '2311233211232321';//访问分享连接的微信openid
		// $_POST['url'] = '/index/index';//访问者进入页面地址
		die ( json_encode ( array (
				'data' => $_POST,
				'msg' => '记录成功',
				'success' => true 
		) ) );
	}
	
	/**
	 * 获取首页菜单列表
	 * 会有post参数uid，uid为空表示尚未绑定用户
	 */
	public function getindexData() {
		
		
		$data ['title'] = '首页要显示的标题';
		$data ['headBgImage'] = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1488090847640&di=74f088cbdbb886bf08e11ce6b28f68d2&imgtype=0&src=http%3A%2F%2Fp3.gexing.com%2Fshaitu%2F20130112%2F2146%2F50f1694e6ece9.jpg'; // 头部北京图片
		$data ['copyright'] = 'Copyright © 2008-2016 xinyisoft.cn';
		if (is_login()) {
			$uid = getUid();
			//@todo 通过逻辑查询这些信息
			$data ['username'] = '用户名';
			$data ['usericon'] = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1488090847640&di=74f088cbdbb886bf08e11ce6b28f68d2&imgtype=0&src=http%3A%2F%2Fp3.gexing.com%2Fshaitu%2F20130112%2F2146%2F50f1694e6ece9.jpg';
			$data ['yue'] = rand ( 100, 99999 );
			$data ['jifen'] = '10011';
		} else {
			$data ['username'] = '未绑定用户';
			$data ['usericon'] = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1488090847640&di=74f088cbdbb886bf08e11ce6b28f68d2&imgtype=0&src=http%3A%2F%2Fp3.gexing.com%2Fshaitu%2F20130112%2F2146%2F50f1694e6ece9.jpg';
			$data ['jifen'] = '未绑定用户';
			$data ['yue'] = '未绑定用户';
		}
		//这些信息不需要判断是否登陆，只需要根据后台的设置显示即可
		$data ['headItems'] = array (
				array (
						'id' => '1',
						'link' => U('Selfshopping/selectstore'),
						'name' => '自助点餐',
						'icon' => '/Public/images/icon/zizhudiancan.png'
				),
				array (
						'id' => '2',
						'link' => U('Shopping/index'),
						'name' => '外卖订餐',
						'icon' => '/Public/images/icon/waimaidiancan.png'
				),
				array (
						'id' => '3',
						'link' => U('Integralshop/index'),
						'name' => '积分商城',
						'icon' => '/Public/images/icon/jifenshangcheng.png'
				),
				array (
						'id' => '4',
						'link' => U('Recharge/index'),
						'name' => '账户充值',
						'icon' => '/Public/images/icon/zhanghuchongzhi.png'
				),
				array (
						'id' => '5',
						'link' => U('Myorder/index'),
						'name' => '我的订单',
						'icon' => '/Public/images/icon/maidan.png'
				),
				array (
						'id' => '6',
						'link' => U('Mycoupons/index'),
						'name' => '我的券码',
						'icon' => '/Public/images/icon/dianping.png'
				),
				array (
						'id' => '7',
						'link' => U('Myaccount/index'),
						'name' => '财务流水',
						'icon' => '/Public/images/icon/caiwujilu.png'
				),
				array (
						'id' => '8',
						'link' => U('Myintegral/index'),
						'name' => '积分流水',
						'icon' => '/Public/images/icon/jifenjilu.png'
				)
		);
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true
		) ) );
	}
	
	/**
	 * 通过微信接口获取用户数据
	 * 如果返回uid数据则表示已经绑定了用户，如果未返回则表示未绑定
	 */
	public function index() {
		
		// 绑定一个随机ID
		$data = @file_get_contents ( 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $_POST ['appid'] . '&secret=' . $_POST ['secret'] . '&js_code=' . $_POST ['code'] . '&grant_type=authorization_code' );
		if ($data !== false) {
			$data = json_decode ( $data, true );
			$uid = S(C('USER_SESSIONNAME'),$data ['openid']);
			if ($uid) {
				$data ['uid'] = $uid;
				$data ['sharecode'] = md5 ( 'aasdas' ); // 分享的时候用户ID方便追踪需要在服务器端存储，每个用户是唯一的
			} else {
				$ret = getPingtaiApiData('public.wxuser.loginwx',$data);
				print_r($ret);die;
				$data ['uid'] = '';
				$data ['sharecode'] = md5 ( 'public' ); // 没有绑定用户的时候分享的时候ID方便追踪需要在服务器端存储
			}
			die ( json_encode ( array (
					'data' => $data,
					'msg' => '数据获取成功',
					'success' => true 
			) ) );
		}else{
			/* 网页版 */
			$params = array(
				'phone'=> $_POST['phone'],
				'code' => $_POST['code'],
			);
			$ret = getPingtaiApiData('public.userinfo.LoingTouch',$params);
			die ( json_encode ( array (
					'msg' => $ret['msg'],
					'success' => $ret['code'],
			) ) );
		}
		
		die ( json_encode ( array (
				'msg' => '请求微信接口失败',
				'success' => false 
		) ) );
	}
	
	public function getUserAddress() {
		
		/* array (
				'addressid' => '2',
				'uid' => $_POST ['uid'],
				'storeid' => 2,
				'default' => '0',
				'lng' => '112.01245',
				'lat' => '34.12541',
				'name' => '幸福小鹿',
				'phone' => '13228889999',
				'cityid' => '22',
				'address' => '幸福大道11号',
				'addressdetail' => '5号楼2单元602室',
				'addressall' => '北京市幸福大道11号5号楼2单元602室' 
		)  */
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true 
		) ) );
	}
	/**
	 * 获取可用城市列表
	 */
	public function getCity() {
		
		$ret = getPingtaiApiData('public.address.getCityList',array());
		
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $ret['data'],
				'success' => true 
		) ) );
	}
	/**
	 * 根据坐标获取可以配送门店(自助点餐)
	 */
	public function getPointStore() {
		$randnumber = 0;
		if ($randnumber == 1) {
			$data = false;
		} else {
			$data = array (
					'storeid' => '1',
					'storename' => '测试门店',
					'long' => '10000',
					'wmstime' => '09:00',
					'wmttime' => '23:00',
					'longtime' => '45' 
			);
		}
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true 
		) ) );
	}
	/**
	 * 根据关键词搜索可以配送的地址
	 */
	public function searchAddress() {
		$key = $_POST['key'];
		/* for($i = 1; $i < 11; $i ++) {
			
			$data [] = array (
					'id' => $i,
					'storeid' => $i,
					'storename' => '门店' . $i,
					'address' => $_POST ['cityname'] . $_POST ['query'] . '小区街道等地址',
					'lat' => '39.2500', // 经纬度
					'lng' => '123.112012', // 经纬度
					'long' => '10000', // 距离
					'longtime' => '45', // 所需时间分钟
					                    // 以下为非必须参数
					'wmstime' => '09:00', // 外送开始时间
					'wmttime' => '23:00' 
			); // 外卖结束时间
		} */
		$params = array('key'=>$key);
		$ret = getPingtaiApiData('public.address.searchAddress',$params);
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $ret['data'],
				'success' => true 
		) ) );
	}
	
	public function addAddress() {
		$postdata = json_decode ( $_POST ['datajson'], true );
		$data = array (
				'addressid' => '100',
				'uid' => $postdata ['uid'],
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
		die ( json_encode ( array (
				'msg' => "送餐地址保存成功！",
				'data' => $data,
				'success' => true 
		) ) );
	}
	/**
	 * 获取门店数据
	 */
	public function getStoreData() {
		
		$data = array (
				array (
						'storeid' => '1',
						'storecode' => '100001',
						'storename' => '北清路店',
						'icon' => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1490939999041&di=c191cd209bf2cf3d49f80c6b1b4b8bc0&imgtype=0&src=http%3A%2F%2Fwww.chengwaicheng.com.cn%2Fbrand%2Fbrandwappic%2F2132385161155146.jpg',
						'images' => array (
								'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1490979492515&di=5c93bff4f2999464efa03b68fc7b4ca8&imgtype=0&src=http%3A%2F%2Fpic.chinasspp.com%2Fquan%2FNews%2Fimage%2F20141114%2F20141114084857_0596.jpg',
								'https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=2187170950,4124297284&fm=21&gp=0.jpg',
								'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1490979536750&di=701d0abf3d093d81b75d79260a0ba30c&imgtype=0&src=http%3A%2F%2Fpro.user.img30.51sole.com%2FproductImages3%2F20140223%2F1330205_20140223163417.jpg' 
						),
						'telphone' => '010-225621251',
						'bussinessphone' => '400888999',
						'address' => '北京市北清路一号院珠江摩尔国家大厦',
						'lat' => '39.921984',
						'lng' => '116.418261',
						'starttime' => '10:00',
						'endtime' => '22:00',
						'waisongstime' => '11:00',
						'waisongttime' => '21:00',
						'kaopuchi' => 1, // 是否靠谱吃认证
						'kaopuchilevel' => 'A', // 靠谱吃评级
						'kaopuchimedia' => 0, // 是否已经打开了靠谱吃视频
						'zizhudiancan' => 1, // 是否支持自助点餐
						'waimaidiancan' => 1, // 是否支持外卖点餐
						'notice' => '这里是门店外卖须知' 
				),
				array (
						'storeid' => '2',
						'storecode' => '100002',
						'storename' => '回龙观店',
						'icon' => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1491534737&di=7c106733c684c1f17686f667b07edd82&imgtype=jpg&er=1&src=http%3A%2F%2Fimg6.faloo.com%2FPicture%2F0x0%2F0%2F925%2F925007.jpg',
						'images' => array (
								'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1490979492515&di=5c93bff4f2999464efa03b68fc7b4ca8&imgtype=0&src=http%3A%2F%2Fpic.chinasspp.com%2Fquan%2FNews%2Fimage%2F20141114%2F20141114084857_0596.jpg',
								'https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=2187170950,4124297284&fm=21&gp=0.jpg',
								'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1490979536750&di=701d0abf3d093d81b75d79260a0ba30c&imgtype=0&src=http%3A%2F%2Fpro.user.img30.51sole.com%2FproductImages3%2F20140223%2F1330205_20140223163417.jpg' 
						),
						'telphone' => '010-225621251',
						'bussinessphone' => '400888999',
						'address' => '北京市北清路一号院珠江摩尔国家大厦',
						'lat' => '39.931984',
						'lng' => '116.418261',
						'starttime' => '10:00',
						'endtime' => '22:00',
						'waisongstime' => '11:00',
						'waisongttime' => '21:00',
						'kaopuchi' => 0, // 是否靠谱吃认证
						'kaopuchilevel' => 'B', // 靠谱吃评级
						'kaopuchimedia' => 0, // 是否已经打开了靠谱吃视频
						'zizhudiancan' => 0, // 是否支持自助点餐
						'waimaidiancan' => 0, // 是否支持外卖点餐
						'notice' => '这里是门店外卖须知' 
				) 
		);
		die ( json_encode ( array (
				'data' => $data,
				'msg' => '数据获取成功',
				'success' => true 
		) ) );
	}
	public function getGoodsData() {
		$data = array ();
		die ( json_encode ( array (
				'data' => $data,
				'msg' => '数据获取成功',
				'success' => true 
		) ) );
	}
	/**
	 * 获取商品数据
	 */
	public function getWaimaiGoodsData() {
		$data ['type'] = array (
				array (
						'typeid' => '4',
						'textcolor' => '#000',
						'typename' => '分类四无ICON' 
				) 
		);
		
		$data ['goods'] = array (
				'1' => array (
						array (
								'goodsid' => '1',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字，是不是',
								'goodspic' => 'http://www.4009009009.cn/Uploads/upfile5640da9ac05dd/image/20170222/s_58ad4a4187089.jpg',
								'goodsprice' => '10.00',
								'sales' => '10', // 月销售数量
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 1,
								'remarks' => array (
										array (
												'remarksid' => '5',
												'remarks' => '加辣' 
										),
										array (
												'remarksid' => '3',
												'remarks' => '加酸' 
										),
										array (
												'remarksid' => '22',
												'remarks' => '加盐' 
										) 
								),
								'suitflagdata' => array (
										array (
												array (
														'goodsid' => '5',
														'goodsno' => '1',
														'addprice' => '1.00',
														'goodsname' => '可换项1111',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '5111',
														'goodsno' => '1',
														'addprice' => '1.00',
														'goodsname' => '可换项12313',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '5222',
														'goodsno' => '1',
														'addprice' => '1.00',
														'goodsname' => '可换项11232',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '8',
														'goodsno' => 1,
														'addprice' => '1.00',
														'goodsname' => '可换项2',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												),
												array (
														'goodsid' => '9',
														'goodsno' => 1,
														'addprice' => '0.00',
														'goodsname' => '可换项3',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												) 
										),
										array (
												array (
														'goodsid' => '11',
														'goodsno' => '1',
														'addprice' => '0.00',
														'goodsname' => '可换项1111',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '22',
														'goodsno' => 1,
														'addprice' => '1.00',
														'goodsname' => '可换项2222',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												),
												array (
														'goodsid' => '33',
														'goodsno' => 1,
														'addprice' => '2.00',
														'goodsname' => '可换项3333',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												) 
										) 
								) 
						),
						array (
								'goodsid' => '2',
								'goodsname' => '好吃的菜啊',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://www.4009009009.cn/Uploads/upfile5640da9ac05dd/image/20170222/s_58ad4a4187089.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 0,
								'remarks' => array (
										array (
												'remarksid' => '5',
												'remarks' => '加辣' 
										),
										array (
												'remarksid' => '3',
												'remarks' => '加酸' 
										),
										array (
												'remarksid' => '22',
												'remarks' => '加盐' 
										) 
								) 
						),
						array (
								'goodsid' => '3',
								'goodsname' => '最常吃的菜',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://www.4009009009.cn/Uploads/upfile5640da9ac05dd/image/20170222/s_58ad4a4187089.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 0,
								'remarks' => array () 
						) 
				),
				'2' => array (
						array (
								'goodsid' => '111',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://www.4009009009.cn/Uploads/upfile5640da9ac05dd/image/20170222/s_58ad4a4187089.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 1,
								'remarks' => array (
										array (
												'remarksid' => '5',
												'remarks' => '加辣' 
										),
										array (
												'remarksid' => '3',
												'remarks' => '加酸' 
										),
										array (
												'remarksid' => '22',
												'remarks' => '加盐' 
										) 
								),
								'suitflagdata' => array (
										array (
												array (
														'goodsid' => '5',
														'goodsno' => '1',
														'addprice' => '1.00',
														'goodsname' => '可换项1',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '8',
														'goodsno' => 1,
														'addprice' => '1.00',
														'goodsname' => '可换项2',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												),
												array (
														'goodsid' => '9',
														'goodsno' => 1,
														'addprice' => '0.00',
														'goodsname' => '可换项3',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												) 
										),
										array (
												array (
														'goodsid' => '11',
														'goodsno' => '1',
														'addprice' => '0.00',
														'goodsname' => '可换项1111',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '22',
														'goodsno' => 1,
														'addprice' => '1.00',
														'goodsname' => '可换项2222',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												),
												array (
														'goodsid' => '33',
														'goodsno' => 1,
														'addprice' => '2.00',
														'goodsname' => '可换项3333',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												) 
										) 
								) 
						),
						array (
								'goodsid' => '112',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://www.4009009009.cn/Uploads/upfile5640da9ac05dd/image/20170215/s_58a3f307dc41f.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 0,
								'remarks' => array (
										array (
												'remarksid' => '5',
												'remarks' => '加辣' 
										),
										array (
												'remarksid' => '3',
												'remarks' => '加酸' 
										),
										array (
												'remarksid' => '22',
												'remarks' => '加盐' 
										) 
								) 
						),
						array (
								'goodsid' => '113',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://www.4009009009.cn/Uploads/upfile5640da9ac05dd/image/20170214/s_58a2ca1816bc4.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 0,
								'remarks' => array () 
						) 
				),
				'3' => array (
						array (
								'goodsid' => '1111',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://www.4009009009.cn/Uploads/upfile5640da9ac05dd/image/20170214/s_58a2c754c9c55.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 1,
								'remarks' => array (
										array (
												'remarksid' => '5',
												'remarks' => '加辣' 
										),
										array (
												'remarksid' => '3',
												'remarks' => '加酸' 
										),
										array (
												'remarksid' => '22',
												'remarks' => '加盐' 
										) 
								),
								'suitflagdata' => array (
										array (
												array (
														'goodsid' => '5',
														'goodsno' => '1',
														'addprice' => '1.00',
														'goodsname' => '可换项1',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '8',
														'goodsno' => 1,
														'addprice' => '1.00',
														'goodsname' => '可换项2',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												),
												array (
														'goodsid' => '9',
														'goodsno' => 1,
														'addprice' => '0.00',
														'goodsname' => '可换项3',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												) 
										),
										array (
												array (
														'goodsid' => '11',
														'goodsno' => '1',
														'addprice' => '0.00',
														'goodsname' => '可换项1111',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '22',
														'goodsno' => 1,
														'addprice' => '1.00',
														'goodsname' => '可换项2222',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												),
												array (
														'goodsid' => '33',
														'goodsno' => 1,
														'addprice' => '2.00',
														'goodsname' => '可换项3333',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												) 
										) 
								) 
						),
						array (
								'goodsid' => '1121',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://www.4009009009.cn/Uploads/upfile5640da9ac05dd/image/20170222/s_58ad4c3392f0e.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 0,
								'remarks' => array (
										array (
												'remarksid' => '5',
												'remarks' => '加辣' 
										),
										array (
												'remarksid' => '3',
												'remarks' => '加酸' 
										),
										array (
												'remarksid' => '22',
												'remarks' => '加盐' 
										) 
								) 
						),
						array (
								'goodsid' => '1131',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://pic39.nipic.com/20140314/11601387_215158881000_2.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 0,
								'remarks' => array () 
						) 
				),
				'4' => array (
						array (
								'goodsid' => '1112',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://www.4009009009.cn/Uploads/upfile5640da9ac05dd/image/20170222/s_58ad4c4680565.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 1,
								'remarks' => array (
										array (
												'remarksid' => '5',
												'remarks' => '加辣' 
										),
										array (
												'remarksid' => '3',
												'remarks' => '加酸' 
										),
										array (
												'remarksid' => '22',
												'remarks' => '加盐' 
										) 
								),
								'suitflagdata' => array (
										array (
												array (
														'goodsid' => '5',
														'goodsno' => '1',
														'addprice' => '1.00',
														'goodsname' => '可换项1',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '8',
														'goodsno' => 1,
														'addprice' => '1.00',
														'goodsname' => '可换项2',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												),
												array (
														'goodsid' => '9',
														'goodsno' => 1,
														'addprice' => '0.00',
														'goodsname' => '可换项3',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												) 
										),
										array (
												array (
														'goodsid' => '11',
														'goodsno' => '1',
														'addprice' => '0.00',
														'goodsname' => '可换项1111',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 1 
												),
												array (
														'goodsid' => '22',
														'goodsno' => 1,
														'addprice' => '1.00',
														'goodsname' => '可换项2222',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												),
												array (
														'goodsid' => '33',
														'goodsno' => 1,
														'addprice' => '2.00',
														'goodsname' => '可换项3333',
														'goodspic' => 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
														'goodsprice' => '10.00',
														'default' => 0 
												) 
										) 
								) 
						),
						array (
								'goodsid' => '1122',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://file06.16sucai.com/2016/0628/85f5299b6865236a1d9d5a5dc849119d.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 0,
								'remarks' => array (
										array (
												'remarksid' => '5',
												'remarks' => '加辣' 
										),
										array (
												'remarksid' => '3',
												'remarks' => '加酸' 
										),
										array (
												'remarksid' => '22',
												'remarks' => '加盐' 
										) 
								) 
						),
						array (
								'goodsid' => '1132',
								'goodsname' => '商品名称',
								'info' => '这是商品的介绍一般不超过10个字',
								'goodspic' => 'http://img.taopic.com/uploads/allimg/121018/240425-12101R3554049.jpg',
								'goodsprice' => '10.00',
								'sales' => '10',
								'packbox' => '1', // 打包盒数量
								'price' => '8.00',
								'suitflag' => 0,
								'remarks' => array () 
						) 
				) 
		);
		/**
		 * 打包盒信息
		 */
		$data ['packbox'] = array (
				'goodsid' => '1000',
				'goodsname' => '打包盒',
				'goodsprice' => '1.00' // 每个打包盒价格
		); 
		/**
		 * 外送费信息
		 */
		$data ['deliveryinfo'] = array (
				'goodsid' => '1000',
				'goodsname' => '外送费',
				'goodsprice' => '5.00', // 外送费价格
				'freecharge' => '99' // 免外送费价格
		); 
		/**
		 * 外卖订餐时间信息
		 */
		$data ['timesinfo'] = array (
				'maketime' => '7',	//可预约时间（天含今日）
				'starttime' => '09:45',	//开始时间（送达时间）
				'stoptime' => '22:00', // 结束时间（送达时间）
				'deliverytime' => '45' //预计配送需要的时间 
		);
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true 
		) ) );
	}
	/**
	 * 获取积分余额
	 */
	public function getjifenyue() {
		$params = array(
				'ucode'=> '10401',
		);
		$ret = getPingtaiApiData("public.weixindata.getUserAccount",$params);
		die ( json_encode ( array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true: false,
		) ) );
	}
	
	/**
	 * 获取劵码详情
	 */
	public function getmycoupons() {
		$page = $_POST ['page'];
		$pagenumber = $_POST ['pagenumber'];
		if ($page > 2) {
			$pagenumber --;
		}
		$data = array ();
		for($i = 0; $i < $pagenumber; $i ++) {
			
			$data [] = array (
					'id' => $page * 10 + $i,
					'title' => ($i % 2 == 1) ? '现金券' : '兑换券',
					'icon' => ($i % 2 == 1) ? '/images/icon/zizhudiancan.png' : 'http://x.yunshouyin.com.cn/upload/image/20170326/1490536653859904.jpg',
					'background' => ($i % 2 == 1) ? '#DF9C33' : 'url(http://img2.imgtn.bdimg.com/it/u=3186284662,1564029446&fm=23&gp=0.jpg) center no-repeat',
					'endtime' => date ( 'Y-m-d' ) 
			);
		}
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true 
		) ) );
	}
	
	/**
	 * 获取劵码详情
	 */
	public function getmycoupon() {
		$id = $_POST ['id'];
		$data = array (
				'id' => $id,
				'title' => '和合谷500元通用现金券',
				'icon' => 'http://f.xinyisoft.org/d8514b3fd987cf38995b89ca6d5b43d3_480',
				'background' => 'url(http://img2.imgtn.bdimg.com/it/u=3186284662,1564029446&fm=23&gp=0.jpg) center',
				'code' => date ( 'Ymd' ) . rand ( 1000, 9999 ) . $id,
				'starttime' => date ( 'Y-m-d' ),
				'endtime' => date ( 'Y-m-d' ) 
		);
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true 
		) ) );
	}
	/**
	 * 获取订单列表
	 * 参数：uid，page，pagenumber
	 */
	public function getjifenlist() {
		$params = array(
				'ucode'=> '10401',
				'page' => $_POST ['page'], //页码
				'page_size'=> $_POST ['pagenumber'], //页大小
				'ctime'=> $_POST['ctime'],
		);
		$ret = getPingtaiApiData("public.weixindata.getIntegralWater",$params);
		$ctime = empty($ret['data']['ctime'] )? array() : $ret['data']['ctime'];
		unset($ret['data']['ctime']);
		die ( json_encode ( array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
				'ctime' =>$ctime,
		) ) ); 
	}
	
	/**
	 * 获取会员财务流水
	 */
	public function getFinancialflow(){
		
		$params = array(
				'ucode'=> '10571',
				'page' => $_POST ['page'], //页码
				'page_size'=> $_POST ['pagenumber'], //页大小
				'ctime'=> $_POST['ctime'],
		);
		$ret = getPingtaiApiData("public.weixindata.getFinancialflow",$params);
		$ctime = empty($ret['data']['ctime'] )? array() : $ret['data']['ctime'];
		unset( $ret['data']['ctime']);
		die ( json_encode ( array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
				'ctime' =>$ctime
		) ) ); 
	}
	
	/**
	 * 获取用户财务余额
	 */
	public function getUserbalance(){
		$params = array(
			'ucode'=> '10571',
		);
		$ret = getPingtaiApiData("public.weixindata.getUserbalance",$params);
		die ( json_encode ( array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		) ) );
	}
	/**
	 * 获取订单列表
	 * 参数：uid，page，pagenumber
	 */
	public function getorderlist() {
		 $params = array(
				'ucode'=> '10714',
				'page' => $_POST ['page'], //页码
				'page_size'=> $_POST ['pagenumber'], //页大小
		);
		$ret = getPingtaiApiData("public.weixindata.getOrderlist",$params);
		
		die ( json_encode ( array (
				'msg' => $ret['msg'],
				'data' => $ret['data'],
				'success' => $ret['code'] ==1? true : false,
		) ) );
	}
	
	/**
	 * 获取可以用的充值金额列表
	 */
	public function getchongzhiitems() {
		$data = array (
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
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true 
		) ) );
	}
	/**
	 * 设置充值
	 */
	public function setchongzhi() {
		$data = array (
				'timeStamp' => '' . time (),
				'nonceStr' => uniqid (),
				'package' => '10000',
				'signType' => 'MD5',
				'paySign' => md5 ( 'test' ) 
		);
		die ( json_encode ( array (
				'msg' => "数据拉取成功！",
				'data' => $data,
				'success' => true 
		) ) );
	}
	/**
	 * 获取支付、充值二维码
	 */
	public function getzhifuma() {
		die ( json_encode ( array (
				'msg' => "拉取成功！",
				'data' => '2018' . rand ( 1000000, 99999999 ) . rand ( 1000000, 99999999 ),
				'success' => true 
		) ) );
	}
	/**
	 * 获取当前二维码状态
	 */
	public function getzhifumastatus() {
		die ( json_encode ( array (
				'msg' => "正常状态",
				'data' => 1,
				'success' => true 
		) ) );
		die ( json_encode ( array (
				'msg' => "已被扫描",
				'data' => 2,
				'success' => true 
		) ) );
		die ( json_encode ( array (
				'msg' => "失效状态",
				'data' => 3,
				'success' => true 
		) ) );
	}
	
	/**
	 * 绑定用户
	 */
	public function binduser() {
		// 本方法可以接收到微信的用户信息和phone参数，具体可以打印出来查看
		// 该方法会增加传递验证码code过来$_POST['code'];
		$data = S_db ( $_POST ['openid'], rand ( 1, 10000 ) );
		die ( json_encode ( array (
				'msg' => "绑定成功！@@" . $_POST ['openid'] . json_encode ( array (
						$data 
				) ),
				'success' => true 
		) ) );
	}
	public function test() {
		echo '访问服务器：' . $_SERVER ["SERVER_ADDR"] . '；';
	}
	
	/**
	 * 获取可用的积分兑换列表
	 */
	public function getIntergnal() {
		$params = array(
			'type'=>'1',
		);
		$ret = getPingtaiApiData("public.weixindata.getIntegralGoodsList",$params);
		echo json_encode ( array (
				'msg' => $ret['msg'],
				'data' => $ret['data']['goodslist'],
				'success' => $ret['code']==1? true : false ,
		) );
	}
	/**
	 * 获取可兑换商品详情
	 */
	public function getIntergnalDetail() {
		$id = $_POST['id'];
		$params = array('id'=>$id);
		$ret = getPingtaiApiData("public.weixindata.getIntegralGoods",$params);
		echo json_encode ( array (
				'msg' => '查询成功',
				'data' => $ret['data']['detail'][$id],
				'success' => true 
		) );
	}
	public function intergnalExchange() {
		echo json_encode ( array (
				'data' => array (
						'id' => 1000 
				),
				'msg' => '兑换成功',
				'success' => true 
		) );
	}
}