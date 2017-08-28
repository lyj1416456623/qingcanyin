<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 我的订单记录
 * @author qiude
 *
 */
class MyorderController extends Controller{
	/**
	 * 我的订单记录
	 */
	public function index(){
		$this->display();
	}
	/**
	 * 我的订单详情
	 */
	public function detail(){
		$this->display();
	}
	/**
	 * 评价订单
	 */
	public function comment(){
		$this->display();
	}
	/**
	 * 领取发票
	 */
	public function invoice(){
		$this->display();
	}
	/**
	 * 发票pdf
	 */
	public function invoicepdf(){
		$this->display();
	}
	/**
	 * 付款码
	 */
	public function paycode(){
		$this->display();
	}
	/**
	 * 查看发票
	 */
	public function lookinvoice(){
		$this->display();
	}
}