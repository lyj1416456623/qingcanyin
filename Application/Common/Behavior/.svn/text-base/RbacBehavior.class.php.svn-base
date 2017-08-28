<?php
namespace Common\Behavior;
use Think\Behavior;
defined('THINK_PATH') or exit();

// 权限验证行为信息
class RbacBehavior extends Behavior {
	// 权限验证行为
	public function run(&$params) {
		$module_name = strtolower(MODULE_NAME);
		$heads = getallheaders();
		if(isset($heads['user-key']) && !empty($heads['user-key'])){
			session(array('id'=>$heads['user-key']));
		}else{
			session('[start]');
		}
		if($module_name != 'api' && strtolower(CONTROLLER_NAME) != 'load'){
			//检测APPID是否传了
			if(empty($_GET['appid'])){
				if(ACTION_NAME != 'noappid'){
					redirect(U('Msghtml/noappid'));
					die();
				}
			}else{
				//判断wxappid的配置文件是否存在
				$wxconfigFile = $_SERVER['DOCUMENT_ROOT'].'/Wxconfig/'.$_GET['appid'].'.php';
				$wxconfigFileOther = $_SERVER['DOCUMENT_ROOT'].'/Wxconfig/'.$_GET['appid'].'_other.php';
				if(!file_exists($wxconfigFile)){
					if(ACTION_NAME != 'nowxconfig'){
						redirect(U('Msghtml/nowxconfig'));
						die();
					}
				}else{
					define('WXAPPID',$_GET['appid']);
					$data = load_config($wxconfigFile);
					foreach ($data as $k=>$v){
						C($k,$v);
					}
					$data = load_config($wxconfigFile);
					foreach ($data as $k=>$v){
						C($k,$v);
					}
					if(C('ISWESOFT') == '1'){
						if(ACTION_NAME != 'iswesoft'){
							redirect(U('Msghtml/iswesoft'));
							die();
						}
					}else{
						$path = strtolower('/'.MODULE_NAME.'/'.CONTROLLER_NAME . '/' . ACTION_NAME);
						$path2 = strtolower('/'.MODULE_NAME.'/'.CONTROLLER_NAME . '/*');
						if(!in_array($path, C('MODULE_NO_RBAC')) && (!in_array($path2, C('MODULE_NO_RBAC')))){	//需要验证权限的模块
							if(!is_login()){
								if(IS_AJAX){
									die ( json_encode ( array (
											'msg' => $path.'登录授权失败！',
											'errcode'=> '100',
											'success' => false
									) ) );
								}else{
									if(is_weixin()){
										if(isset($_GET['state']) && $_GET['state'] == 'xinyi3dopen'){
											if(isset($_GET['code']) && isset($_GET['appid'])){
												//跳转到登录页
												redirect(U('Index/login').'?code='.$_GET['code'].'&appid='.$_GET['appid'].'&state='.$_GET['state'].'&jumpurl='.getFullUrl());
											}else{
												//如果只存在state
												redirect(U('Msghtml/noautologin'));
											}
										}else{
											redirect(U('Index/login').'?jumpurl='.getFullUrl());
										}
									}else{
										redirect(U('Index/login').'?jumpurl='.getFullUrl());
									}
										
								}
							}
						}
					}
					
				}
				
			}
		}else{
			if(isset($heads['user-key']) && !empty($heads['user-key'])){
				define('WXAPPID',$heads['wxappid']);
				$_GET['appid'] = $heads['wxappid'];
				$wxconfigFile = $_SERVER['DOCUMENT_ROOT'].'/Wxconfig/'.WXAPPID.'.php';
				if(!file_exists($wxconfigFile)){
					msg(array(
						'msg'=>'没有检测到小程序配置',
						'errcode'=> '90',
						'success'=>false
					));
				}
				$data = load_config($wxconfigFile);
				foreach ($data as $k=>$v){
					C($k,$v);
				}
				if(C('ISWESOFT') != '1'){
					msg(array(
							'msg'=>'这个应用不是小程序，无法使用对应接口',
							'errcode'=> '91',
							'success'=>false
					));
				}
			}
		}
	}
}
