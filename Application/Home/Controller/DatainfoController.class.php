<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 获取数据
 * @author qiude
 *
 */
class DatainfoController extends Controller{

	/**
	 * 发送短信验证码
	 */
	public function sendsmscode() {
		$model = new \Common\Model\SmsModel();
		msg($model->send());
	}
	/**
	 * 原注册接口修改为binduser
	 */
	public function binduser(){
		$model = new \Common\Model\UserModel();
		msg($model->regWebUser());
	}
	/**
	 * 获取首页数据
	 */
	public function getIndexData(){
		$model = new \Common\Model\GetindexModel();
		msg($model->getWebData());
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
	 * 获取用户信息网页版不需要该方法
	 */
// 	public function getUserInfo(){
// 		$model = new \Common\Model\UserModel();
// 		msg($model->getUserInfo());
// 	}
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
	 * 获取进行中的活动
	 */
	public function getActivitting(){
		$model = new \Common\Model\ActivityModel();
		msg($model->getActivitting());
	}
	
	/**
	 * 获取活动规则
	 */
	public function getRuleList(){
		$model = new \Common\Model\ActivityModel();
		msg($model->getRuleList());
	}	
	
	
	/**
	 * 会员充值活动
	 */
	public function setJsPayOrder(){
		$model = new \Common\Model\ActivityModel();
		msg($model->setActivityJsPayOrder());
	}
	
	/**
	 * 优惠劵，首单立减，是否已经领过
	 * return array()
	 * */
	public function getCouponData(){
		$model = new \Common\Model\ActivityModel();
		msg($model->getCouponData());
	}
	
	/**
	 * 活动中的微信支付
	 */
	public function acitivityWxPay(){
		$model = new \Common\Model\ActivityModel();
		msg($model->setActivityJsPayOrder());
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
	public function getStoreData() {
		$model = new \Common\Model\StoreModel();
		msg($model->getAllStore());
	}
	/**
	 * 获取自助门店
	 */
	public function getZizhuStoreData() {
		$model = new \Common\Model\StoreModel();
		msg($model->getZizhuStore());
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
	 * 领水
	 */
	public function getLimitGoods(){
		$model = new \Common\Model\GoodsModel();
		msg($model->getLimitGoods());
	}
	public function getactivityGoods(){
		$model = new \Common\Model\GoodsModel();
		msg($model->getactivityGoods());
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
	 * 获取充值可用金额列表
	 */
	public function getchongzhiitems(){
		$model = new \Common\Model\SysModel();
		msg($model->getChongzhiData());
	}
	/**
	 * 获取我的现金券列表
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
	 * 参数：uid，page，pagenumber
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
	/* 取消订单理由 */
	public function getcancelreason(){
		$model = new \Common\Model\OrderModel();
		msg($model->getcancelreason());
	}
	/* 取消订单 */
	public function cancleOrder(){
		$model = new \Common\Model\OrderModel();
		msg($model->cancleOrder());
	}
	/* 余额支付 */
	public function yuePay(){
		$model = new \Common\Model\OrderModel();
		msg($model->yuePay());
	}
	/* 获取支付方式 */
	public function getPaytype(){
		$model = new \Common\Model\OrderModel();
		msg($model->getPaytype());
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