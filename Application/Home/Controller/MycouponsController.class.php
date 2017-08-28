<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 我的卡券
 * @author qiude
 *
 */
class MycouponsController extends Controller{
	/**
	 * 首页
	 */
	public function index(){
		$this->display();
	}
	/**
	 * 我的卡券详情
	 */
	public function detail(){
		$this->display();
	}
}