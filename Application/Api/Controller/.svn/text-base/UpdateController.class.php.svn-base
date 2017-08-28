<?php

namespace Api\Controller;

/**
 * 更新配置
 * 
 * @author qiude
 *        
 */
class UpdateController extends CommonController {
	public function test(){
		msg (array(
			'success' => true,
			'msg' => '通信成功',
			'key' => $_GET['key']
		),'JSON');
	}
	/**
	 * 删除config
	 */
	public function removeconfig() {
		/**
		 * 判断参数
		 */
		if(empty($_POST['appid'])){
			msg(array (
					'success' => false,
					'errcode' => '102',
					'msg' => '缺少appid'
			),'JSON');
		}
		$configFile = $_SERVER['DOCUMENT_ROOT'].'/Wxconfig/'.$_POST['appid'].'.php';
		if(file_exists($configFile)) unlink($configFile);
		msg(array (
			'success' => true,
			'msg' => '取消授权成功'
		),'JSON');
	}
	
	/**
	 * 更新配置文件
	 * $_POST['config']
	 */
	public function config() {
		/**
		 * 判断参数
		 */
		if(empty($_POST['appid'])){
			msg(array (
				'success' => false,
				'errcode' => '102',
				'msg' => '缺少appid'
			),'JSON');
		}
		if(empty($_POST['config'])){
			msg(array (
				'success' => false,
				'errcode' => '102',
				'msg' => '缺少config'
			),'JSON');
		}
		$config = xinyi_decrypt($_POST['config'],C('CRYPT_KEY'));
		if(empty($config)){
			msg(array (
				'success' => false,
				'errcode' => '102',
				'msg' => 'config解析失败'
			),'JSON');
		}
		$configFile = $_SERVER['DOCUMENT_ROOT'].'/Wxconfig/'.$_POST['appid'].'.php';
		file_put_contents($configFile, '<?php return '.$config.';');
		msg(array (
			'success' => true,
			'msg' => '配置更新完成',
		),'JSON');
	}

	/**
	 * 更新本地缓存数据
	 */
	public function updata(){
		/**
		 * 判断参数
		 */
		if(empty($_POST['appid'])){
			msg(array (
					'success' => false,
					'errcode' => '102',
					'msg' => '缺少appid'
			),'JSON');
		}
		if(empty($_POST['filename'])){
			msg(array (
					'success' => false,
					'errcode' => '102',
					'msg' => '缺少filename'
			),'JSON');
		}
		if(empty($_POST['data'])){
			msg(array (
					'success' => false,
					'errcode' => '102',
					'msg' => $_POST
			),'JSON');
		}
		$config = xinyi_decrypt($_POST['data'],C('CRYPT_KEY'));
		if(empty($config)){
			msg(array (
					'success' => false,
					'errcode' => '102',
					'msg' => 'data解析失败'
			),'JSON');
		}
		S($_POST['filename'],$config);
		msg(array (
				'success' => true,
				'msg' => '缓存数据更新成功'.$_POST['filename'],
		),'JSON');

	}
	
}