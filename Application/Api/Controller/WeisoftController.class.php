<?php
namespace Api\Controller;
use Think\Controller;

/**
 * 更新配置
 * 
 * @author qiude
 *        
 */
class WeisoftController extends Controller {
	
	public function api() {
		if (!empty($_POST ['mothed'])) {
			$mothed = str_replace( 'Weisoft/', '', $_POST ['mothed']);
			if(method_exists($this,$mothed)){
				if (!empty($mothed)) {
					$this->$mothed();
					die();
				}
			}else{
				die(json_encode(array(
						'msg' => 'mothed方法不存在',
						'success' => false
				)));
			}
			
		}
		die(json_encode(array(
			'msg' => 'mothed参数错误哦',
			'success' => false
		)));
	}
	/**
	 * 发送短信验证码
	 */
	public function sendsmscode() {
		$model = new \Common\Model\SmsModel();
		msg($model->send());
		
	}
	/**
	 * 微信小程序注册接口
	 */
	public function binduser(){
		$model = new \Common\Model\UserModel();
		msg($model->regWesoftUser());
	}
	/**
	 * 获取首页配置数据
	 */
	public function getindexData(){
		$model = new \Common\Model\GetindexModel();
		msg($model->getWeisoftData());
	}
	
	/**
	 * 获取用户数据
	 */
	public function getUserdata(){
		$model = new \Common\Model\GetindexModel();
		msg($model->getUserdata());
	}
	
	/**
	 * 获取微信小程序二维码
	 */
	public function getWesoftQrcode(){
		$model = new \Common\Model\SysModel();
		msg($model->getWesoftQrcode());
	}
	/**
	 * 获取用户信息
	 */
	public function getUserInfo(){
		$model = new \Common\Model\UserModel();
		msg($model->getUserInfo());
	}
	public function getCity() {
		$model = new \Common\Model\AddressModel();
		msg($model->getClityList());
	}
	/**
	 * 获取用户付款码
	 */
	public function getUserPayCode(){
		$model = new \Common\Model\UserModel();
		msg($model->getPayCode());
	}
	public function getpaycodestatus(){
		$model = new \Common\Model\UserModel();
		msg($model->getpaycodestatus());
	}
	
	
	/**
	 * 根据关键词搜索可以配送的地址
	 */
	public function searchAddress() {
		$model = new \Common\Model\AddressModel();
		msg($model->searchAddress());
	}
	/**
	 * 获取我的送餐地址列表
	 */
	public function getUserAddress() {
		$model = new \Common\Model\AddressModel();
		msg($model->getMyAddress());
	}
	/**
	 * 添加我的送餐地址
	 */
	public function addUserAddress() {
		$model = new \Common\Model\AddressModel();
		msg($model->addAddress());
	}
	/**
	 * 修改我的送餐地址
	 */
	public function editUserAddress() {
		$model = new \Common\Model\AddressModel();
		msg($model->editAddress());
	}
	/**
	 * 删除我的送餐地址
	 */
	public function delUserAddress() {
		$model = new \Common\Model\AddressModel();
		msg($model->delAddress());
	}
	/**
	 * 获取js SDK 配置
	 */
	public function getSDkconfig(){
		$model = new \Common\Model\SysModel();
		msg($model->getJsSdkconfig());
	}
	public function createJsPayOrder(){
		$model = new \Common\Model\SysModel();
		msg($model->getJsPayOrder());
	}
	/**
	 * 获取门店数据
	 */
	public function getZizhuStoreData() {
		$model = new \Common\Model\StoreModel();
		msg($model->getZizhuStore());
	}
	/**
	 * 获取门店数据
	 */
	public function getStoreData() {
		$model = new \Common\Model\StoreModel();
		msg($model->getAllStore());
	}
	/**
	 * 获取商品数据
	 */
	public function getWaimaiGoodsData() {
		$model = new \Common\Model\GoodsModel();
		msg($model->getWaimaiGoods());
	}
	public function getZizhuGoodsData(){
		$model = new \Common\Model\GoodsModel();
		msg($model->getZizhuGoods());
	}
	/**
	 * 获取积分余额
	 */
	public function getjifenyue() {
		$model = new \Common\Model\UserModel();
		msg($model->getUserIntegral());
	}
	/**
	 * 获取订单列表
	 * 参数：uid，page，pagenumber
	 */
	public function getjifenlist() {
		$model = new \Common\Model\UserModel();
		msg($model->getUserIntegralList());
	}
	/**
	 * 获取支付码
	 */
	public function getzhifuma(){
		$model = new \Common\Model\SysModel();
		msg($model->getPayCode());
	}
	/**
	 * 获取账户余额
	 */
	public function getUserbalance(){
		$model = new \Common\Model\UserModel();
		msg($model->getUserBalance());
	}
	/**
	 * 无痕注册
	 */
	public function phoneregister(){
		$model = new \Common\Model\UserModel();
		msg($model->phoneregister());
	}
	/**
	 * 我的页面
	 */
	public function getMyPage(){
		$model = new \Common\Model\UserModel();
		msg($model->getMyInfoList());
	}
	/**
	 * 获取会员财务流水
	 */
	public function getFinancialflow(){
		$model = new \Common\Model\UserModel();
		msg($model->getUserFinancialflow());
	}
	/**
	 * 获取充值金额列表
	 */
	public function getchongzhiitems(){
		$model = new \Common\Model\SysModel();
		msg($model->getChongzhiData());
	}
	/**
	 * 获取我的现金券
	 */
	public function getmycoupons(){
		$model = new \Common\Model\CouponsModel();
		msg($model->getMyCoupons());
	}
	/**
	 * 获取我的现金券详细
	 */
	public function getmycoupon(){
		$model = new \Common\Model\CouponsModel();
		msg($model->getDetail());
	}
	/**
	 * 获取订单列表
	 * 参数：ucode，page，pagenumber
	 */
	public function getorderlist() {
		$model = new \Common\Model\OrderModel();
		msg($model->getMyOrder());
	}
	public function createOrder(){
		$model = new \Common\Model\OrderModel();
		msg($model->creatWaimaiOrder());
	}
	
	public function createzizhuOrder(){
		$model = new \Common\Model\OrderModel();
		msg($model->createzizhuOrder());
	}
	public function getPaytype(){
		$model = new \Common\Model\OrderModel();
		msg($model->getPaytype());
	}
	public function setPaytype(){
		$model = new \Common\Model\OrderModel();
		msg($model->setPaytype());
	}
	/**
	 * 创建电子发票
	 */
	public function setOrderInvoice(){
		$model = new \Common\Model\OrderModel();
		msg($model->setOrderInvoice());
	}
	
	/**
	 * 获取电子发票
	 */
	public function sendfapiaoEmail(){
		$model = new \Common\Model\OrderModel();
		msg($model->sendfapiaoEmail());
	}
	
	public function getfapiao(){
		$model = new \Common\Model\OrderModel();
		msg($model->getfapiao());
	}
	
	/**
	 * 获取订单详情
	 */
	public function getOrderDetail(){
		$model = new \Common\Model\OrderModel();
		msg($model->getOrderDetail());
	}
	public function getcancelreason(){
		$model = new \Common\Model\OrderModel();
		msg($model->getcancelreason());
	}
	public function cancleOrder(){
		$model = new \Common\Model\OrderModel();
		msg($model->cancleOrder());
	}
	/* 余额支付 */
	public function yuePay(){
		$model = new \Common\Model\OrderModel();
		msg($model->yuePay());
	}
	
	/**
	 * 获取可用的积分兑换列表
	 */
	public function getIntergnal() {
		$model = new \Common\Model\IntegralModel();
		msg($model->getList());
	
	}
	
	/**
	 *积分 兑换
	 */
	public function Exchange() {
		$model = new \Common\Model\IntegralModel();
		msg($model->Exchange());
	
	}
	/**
	 * 兑换记录
	 */
	public function  getExchangeLog(){
		$model = new \Common\Model\IntegralModel();
		msg($model->getExchangeLog());
	}
	public function getexchangedetail(){
		$model = new \Common\Model\IntegralModel();
		msg($model->getexchangedetail());
	}
	/**
	 * 获取可兑换商品详情
	 */
	public function getIntergnalDetail() {
		$model = new \Common\Model\IntegralModel();
		msg($model->getDetail());
	}
	public function setchongzhi(){
		$model = new \Common\Model\UserModel();
		msg($model->setChongzhiOrder());
	}
	/**
	 * 获取用户门店未完成订单
	 */
	public function getUserOrderList() {
		$model = new \Common\Model\OrderModel();
		msg($model->getUserOrderList());
	}
	/**
	 * 获取用户门店未完成订单绑定桌台或取餐
	 */
	public function completeUserOrder() {
		$model = new \Common\Model\OrderModel();
		msg($model->completeUserOrder());
	}
}