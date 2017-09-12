/*This is Recharge/rechar js file!*/
var configStatus = false;
$(function() {
	// @todo 通过sessionStorge来判断域名是否已经获取JS授权
	var app,isweixinpay = true;
	app = new Vue({
		el: '#body',
		data: {
			loading: true,
			List: [],
			title:''
		},
		methods: {
			submitOrder: function(data) {
				var _this = this;
				//并且参数名称大小写是区分的
				WeixinJSBridge.invoke(
					'getBrandWCPayRequest', {
						"appId": data.appId, //公众号名称，由商户传入     
						"timeStamp": data.timeStamp + '', //时间戳，自1970年以来的秒数     
						"nonceStr": data.nonceStr, //随机串     
						"package": data.package,
						"signType": "MD5", //微信签名方式：     
						"paySign": data.paySign //微信签名 
					},
					function(res) {
						console.log(res);
						if(res.err_msg == "get_brand_wcpay_request:ok"){
							weui.dialog({
							    title: '温馨提示',
							    content: '余额充值成功',
							    className: 'custom-classname',
							    buttons: [{
							        label: '返回',
							        type: 'default',
							        onClick: function () {
							        	history.back();
							        }
							    }, {
							        label: '查看记录',
							        type: 'primary',
							        onClick: function () {
							        	location.href = '{:U("Myaccount/index")}';
							        }
							    }]
							});
							
						}else if(res.err_msg == "get_brand_wcpay_request:fail"){
							weui.dialog({
							    title: '温馨提示',
							    content: '支付失败，是否立即重试？',
							    className: 'custom-classname',
							    buttons: [{
							        label: '取消支付',
							        type: 'default',
							        onClick: function () {
							        	history.back();
							        }
							    }, {
							        label: '立即支付',
							        type: 'primary',
							        onClick: function () {
							        	_this.openpay();
							        }
							    }]
							});
						}else if(res.err_msg == "get_brand_wcpay_request:cancel"){
							weui.dialog({
							    title: '温馨提示',
							    content: '您选择了取消支付，是否立即支付？',
							    className: 'custom-classname',
							    buttons: [{
							        label: '取消支付',
							        type: 'default',
							        onClick: function () {
							        	history.back();
							        }
							    }, {
							        label: '立即支付',
							        type: 'primary',
							        onClick: function () {
							        	_this.openpay();
							        }
							    }]
							});
						}
					}
				);
				
			},
			openpay:function(item){
				if(!isweixinpay || isweixinpay=='false'){
					weui.alert('暂未开通微信支付', {
					    title: '温馨提示',
					    buttons: [{
					        label: '确定',
					        type: 'primary',
					        onClick: function(){
					        	window.history.go(-1);
					        }
					    }]
					});
				}else{
					var postdata = {
						price: item.recharge,
						amraid:item.amraid,
						body: '充值' + item.recharge + '元到账户余额！',
						paytype: "chongzhi",
						trade_type: "JSAPI",
				};
				console.log(postdata);
				$.post('{:U("Datainfo/setJsPayOrder")}', postdata, function(rest) {
					console.log(rest);
					if(rest.success) {
						if (typeof WeixinJSBridge == "undefined"){
						   if( document.addEventListener ){
						       document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
						   }else if (document.attachEvent){
						       document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
						       document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
						   }
						}else{
						   	app.submitOrder(rest.data);
						}
					} else {
						weui.alert('哎呀，出错了，请重试！');
					}
				}, 'json')
				}
				
			}
		}
	})
	$.post('{:U("Datainfo/getRuleList")}', {'activityid':activityid}, function(rest) {
		console.log(rest);
		app.loading = false;
		if(rest.success) {
			app.List = rest.data;
			isweixinpay = rest.other.isweixinpay;
			app.title = rest.other.merchantname;
			console.log(isweixinpay,"支付方式");
		}else{
			weui.alert('该活动暂未开始，敬请期待！',function(){
				window.history.go(-1);
			});
		}
	}, 'json')
})