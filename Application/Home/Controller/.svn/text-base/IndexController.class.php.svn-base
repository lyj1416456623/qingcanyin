<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 微信服务号
 * @author qiude
 *
 */
class IndexController extends Controller{
	/**
	 * 首页
	 */
	public function index(){
		if(is_weixin()){
			$this->assign('wx','微信');
		}
		$this->display();
	}
	/**
	 * 登陆页面
	 */
	public function login(){
		/* 从哪里来到哪里去 */
		if(!empty($_GET['jumpurl'])){
			$this->assign('jumpurl',getjumpurl());
		}

		if(is_login()){
			$this->redirect(getjumpurl());
		}
		if(is_weixin()){
			//存在用户授权唯一编号
			if(isset($_GET['code'])){
				//通过code获取用户信息
				$params = array(
					'code' => $_GET['code'],
				);
				$ret = getPingtaiApiData("public.weixinuser.getUserinfo",$params);
				if($ret['code'] == '1'){
					if(!empty($ret['data']['user']['uid'])){
						$_SESSION['USERINFO'] = $ret['data']['user'];
						redirect(getjumpurl());
						die();
					}else{
						//是否有uid
						$_SESSION['WXLOGINKEY'] = $ret['data']['key'];
						$this->assign('wxkey',$ret['data']['key'])->assign('title','绑定帐号');
					}
				}else{
					$this->error($ret['msg'],U('Index/index'));
				}
			}else{
				//通过接口生成跳转授权的地址
				$params = array(
					'jumpurl' => getjumpurl(),
				);
				$ret = getPingtaiApiData("public.weixinuser.getJumpUrl",$params);
				if($ret['code'] == '1'){
					redirect($ret['data']);
				}else{
					$this->error($ret['msg'],U('Index/index'));
				}
			}
		}else{
			$this->assign('title','用户登录');
		}
		$this->display();
	}
	
	/**
	 * 无痕登录
	 */
	public function hiddenlogin(){
		if(!isset($_GET['jumpurl']) || empty($_GET['jumpurl'])){
			$array = array(
				'success' => false,
				'jumpurl' => $_GET['jumpurl'],
				'msg' => '参数传递错误，请重试！'
			);
			echo json_encode($array);
			exit;
		}
		if(!is_login() && is_weixin()){
			//存在用户授权唯一编号
			if(isset($_GET['code'])){
				//通过code获取用户信息
				$params = array(
					'code' => $_GET['code'],
				);
				$ret = getPingtaiApiData("public.weixinuser.getUserinfo",$params);
				
				if($ret['code'] == '1'){
					if(!empty($ret['data']['user']['uid'])){
						$_SESSION['USERINFO'] = $ret['data']['user'];
						$array = array(
							'success' => true,
							'jumpurl' => $_GET['jumpurl'],
							'islogin' => true,
							'yue' => $_SESSION['USERINFO']['yue'],
							'continue'=>1
						);
						echo json_encode($array);
						exit;
					}else{
						//是否有uid
						$_SESSION['WXLOGINKEY'] = $ret['data']['key'];
						$array = array('success' => true,'jumpurl'=>'http://'.$_SERVER['HTTP_HOST'].$_GET['jumpurl'],'continue'=>1);
						echo json_encode($array);
						exit;
					}
				}
			}else{
				//通过接口生成跳转授权的地址
				
				$params = array(
					'jumpurl' => 'http://'.$_SERVER['HTTP_HOST'].$_GET['jumpurl'].'&returnwx=1',
				);
				$ret = getPingtaiApiData("public.weixinuser.getJumpUrl",$params);
				if($ret['code'] == '1'){
					$array = array(
						'success' => true,
						'jumpurl' => $ret['data'],
						'params' => $params
					);
					echo json_encode($array);
					exit;
				}
			}
		}else if(!is_login() && !is_weixin()){
			$jumpurl = 'http://'.$_SERVER['HTTP_HOST'].URL('Index/login').'?jumpurl='.'http://'.$_SERVER['HTTP_HOST'].$_GET['jumpurl'];
			$array = array('success' => true,'jumpurl'=>$jumpurl);
			echo json_encode($array);
			exit;
		}
		$array = array('success' => true,'jumpurl'=>$_GET['jumpurl'],'continue'=>1);
		echo json_encode($array);
		exit;
	}
	
	
	
	public function info(){
		$this->display();
	}
	public function mine(){
		$this->display();
	}
	public function paymentcode(){
		$this->display();
	}
	public function myaddress(){
		$this->display();
	}
	public function editaddress(){
		$this->display();
	}
	public function paymsg(){
		$this->display();
	}
	public function payerror(){
		$this->display();
	}
}