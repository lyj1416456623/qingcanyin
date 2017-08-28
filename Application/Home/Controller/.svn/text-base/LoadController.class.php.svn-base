<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 加载CSS文件等
 * @author qiude
 *
 */
class LoadController extends Controller{

	/**
	 * 加载CSS文件
	 */
	public function css(){
		header('Content-Type:text/css');
		header("Cache-Control:public,max-age=315360000");
		header("Pragma:public");
		header('X-Powered-By:XinyisoftFileserver');
		$name = $_GET['cssname'];
		$path = $_SERVER['DOCUMENT_ROOT'].'/Public/include/'.ucwords($_GET['path']);
		$filepath = $path.'/'.$name.'.css';
		if(!file_exists($filepath)) {
			$filecontent = '/*This is '.ucwords($_GET['path']).'/'.$name.' css file!*/';
			mkdir($path);
			file_put_contents($filepath, $filecontent);
			die($filecontent);
		}
		echo @file_get_contents($filepath);
		die();
	}
	/**
	 * 加载JS文件
	 */
	public function js(){
		header("Pragma:public");
		header('Content-Type:application/javascript');
		header("Cache-Control:max-age=315360000");
		header('X-Powered-By:XinyisoftFileserver');
		$name = $_GET['jsname'];
		$path = $_SERVER['DOCUMENT_ROOT'].'/Public/include/'.ucwords($_GET['path']);
		$filepath = $path.'/'.$name.'.js';
		if(!file_exists($filepath)) {
			$filecontent = '/*This is '.ucwords($_GET['path']).'/'.$name.' js file!*/';
			mkdir($path);
			file_put_contents($filepath, $filecontent);
			die($filecontent);
		}
		$data = @file_get_contents($filepath);
		$this->show($data);
		die();
	}
}