<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 自助点餐
 * @author qiude
 *
 */
class SelfshoppingController extends Controller{
	/**
	 * 点餐界面
	 */
	public function index(){
		$this->display();
	}
	/**
	 * 活动界面
	 */
	public function activity(){
		$this->display();
	}
	/**
	 * 订单确认
	 */
	public function orderconfirm(){
		$this->display();
	}
	/**
	 * 支付成功
	 */
	public function paysuccess(){
		$this->display();
	}
	/**
	 * 订单列表
	 */
	public function orderlist(){
		$urldata = '';
		if(isset($_GET['storeid'])) $urldata .= "storeid=".$_GET['storeid']."&";
		if(isset($_GET['stid'])) $urldata .= "stid=".$_GET['stid']."&";
		if(isset($_GET['staid'])) $urldata .= "staid=".$_GET['staid']."&";
		if(isset($_GET['localcode'])) $urldata .= "localcode=".$_GET['localcode'];
		if(!is_login()){
			if(isset($_GET['code'])){
				//通过code获取用户信息
				$params = array(
						'code' => $_GET['code'],
				);
				$ret = getPingtaiApiData("public.weixinuser.getUserinfo",$params);
			
				if($ret['code'] == '1'){
					if(!empty($ret['data']['user']['uid'])){
						$_SESSION['USERINFO'] = $ret['data']['user'];
// 						is_login()  == true
						$params = array(
								'storeid'=> $_GET['storeid'],
								'uid' => $_SESSION['USERINFO']['uid'],
						);
						$ret = getPingtaiApiData("public.weixindata.getUserOrderConduct",$params);
						if(!empty($ret['data'])){
							$this->assign('data',$ret['data']);
							$this->display();
						}else{
							redirect(U('Selfshopping/storeinfo').'?'.$urldata);
						}
					}else{
						//是否有uid
						/* $_SESSION['WXLOGINKEY'] = $ret['data']['key'];
						$this->assign('wxkey',$ret['data']['key'])->assign('title','绑定帐号');
						redirect(U('Selfshopping/storeinfo') */
						redirect(U('Selfshopping/storeinfo').'?'.$urldata);
					}
				}
			}else{
				//通过接口生成跳转授权的地址
				$params = array(
						//'jumpurl' => 'http://'.$_SERVER['HTTP_HOST'].URL('Selfshopping/orderceshi').'&returnwx=1',
					'jumpurl' => getFullUrl()."&returnwx=1",
				);
				$ret = getPingtaiApiData("public.weixinuser.getJumpUrl",$params);
				if($ret['code'] == '1'){
					redirect($ret['data']);
				}else{
					redirect(U('Selfshopping/storeinfo').'?'.$urldata);
				}
			}
		}else{
			$params = array(
					'storeid'=> $_GET['storeid'],
					'uid' => $_SESSION['USERINFO']['uid'],
			);
			$ret = getPingtaiApiData("public.weixindata.getUserOrderConduct",$params);
			if(!empty($ret['data'])){
				$this->assign('data',$ret['data']);
				$this->display();
			}else{
				redirect(U('Selfshopping/storeinfo').'?'.$urldata);
			}
		}
		/* 判断该门店下是否有未完成订单，如果有就显示当前页面，如果没有就指向门店详情页 */
	}
	/**
	 * 订单详情
	 */
	public function orderdetail(){
		$this->display();
	}
	/**
	 * 选择门店
	 */
	public function selectstore(){
		$this->display();
	}
	/**
	 * 门店详情
	 */
	public function storeinfo(){
		$this->display();
	}
	/**
	 * 测试订单列表
	 */
	public function orderceshi(){
		$this->display();
//		$urldata = '';
//		if(isset($_GET['storeid'])) $urldata .= "storeid=".$_GET['storeid']."&";
//		if(isset($_GET['stid'])) $urldata .= "stid=".$_GET['stid']."&";
//		if(isset($_GET['staid'])) $urldata .= "staid=".$_GET['staid']."&";
//		if(isset($_GET['localcode'])) $urldata .= "localcode=".$_GET['localcode'];
//		if(!is_login()){
//			if(isset($_GET['code'])){
//				//通过code获取用户信息
//				$params = array(
//						'code' => $_GET['code'],
//				);
//				$ret = getPingtaiApiData("public.weixinuser.getUserinfo",$params);
//			
//				if($ret['code'] == '1'){
//					if(!empty($ret['data']['user']['uid'])){
//						$_SESSION['USERINFO'] = $ret['data']['user'];
//// 						is_login()  == true
//						$params = array(
//								'storeid'=> $_GET['storeid'],
//								'uid' => $_SESSION['USERINFO']['uid'],
//						);
//						$ret = getPingtaiApiData("public.weixindata.getUserOrderConduct",$params);
//						if(!empty($ret['data'])){
//							$this->assign('data',$ret['data']);
//							$this->display();
//						}else{
//							redirect(U('Selfshopping/storeinfo').'?'.$urldata);
//						}
//					}else{
//						//是否有uid
//						/* $_SESSION['WXLOGINKEY'] = $ret['data']['key'];
//						$this->assign('wxkey',$ret['data']['key'])->assign('title','绑定帐号');
//						redirect(U('Selfshopping/storeinfo') */
//						redirect(U('Selfshopping/storeinfo').'?'.$urldata);
//					}
//				}
//			}else{
//				//通过接口生成跳转授权的地址
//				$params = array(
//						//'jumpurl' => 'http://'.$_SERVER['HTTP_HOST'].URL('Selfshopping/orderceshi').'&returnwx=1',
//					'jumpurl' => getFullUrl()."&returnwx=1",
//				);
//				$ret = getPingtaiApiData("public.weixinuser.getJumpUrl",$params);
//				if($ret['code'] == '1'){
//					redirect($ret['data']);
//				}else{
//					redirect(U('Selfshopping/storeinfo').'?'.$urldata);
//				}
//			}
//		}else{
//			$params = array(
//					'storeid'=> $_GET['storeid'],
//					'uid' => $_SESSION['USERINFO']['uid'],
//			);
//			$ret = getPingtaiApiData("public.weixindata.getUserOrderConduct",$params);
//			if(!empty($ret['data'])){
//				$this->assign('data',$ret['data']);
//				$this->display();
//			}else{
//				redirect(U('Selfshopping/storeinfo').'?'.$urldata);
//			}
//		}
//		/* 判断该门店下是否有未完成订单，如果有就显示当前页面，如果没有就指向门店详情页 */
	}
	
}