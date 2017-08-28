<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 自助点餐
 * @author qiude
 *
 */
class SelfshopingController extends Controller{
	/**
	 * 点餐界面
	 */
	public function index(){
		$this->display();
	}
	/**
	 * 订单确认
	 */
	public function orderconfirm(){
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
}