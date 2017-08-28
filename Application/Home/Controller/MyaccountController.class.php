<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 我的财务记录
 * @author qiude
 *
 */
class MyaccountController extends Controller{
	/**
	 * 我的财务记录
	 */
	public function index(){
		$this->display();
	}
	/**
	 * 财务记录详情
	 */
	public function detail(){
		$this->display();
	}
}