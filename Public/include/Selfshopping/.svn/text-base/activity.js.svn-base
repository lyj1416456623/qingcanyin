/*This is Selfshopping/activity js file!*/
$(function(){
	var showCartDataCache = localStorage.getItem("tangshidiancan--" + activityid); //购物车数据缓存
	if(showCartDataCache) {
		showCartDataCache = JSON.parse(showCartDataCache);
	}else{
		showCartDataCache={};
	}
	console.log(showCartDataCache,"购物车");
	var continueUrl = "{:U('Selfshopping/orderconfirm')}?storeid="+storeid+"&activityid="+activityid+"&localcode=1"; 
	var app = new Vue({
		el:'#body',
		data:{
			number:0,
			localcode:1,
			islogin:'',
			url:continueUrl,
			loading:true,
		},
		methods: {
			isLogin:function(){
				var _this = this;
				//无痕登录
				console.log("code=",code,"appid=",appid,"state=",state,"returnwx",returnwx);
				var jumpurl = '{:U("Selfshopping/activity")}?storeid='+storeid +"&activityid="+activityid;
				if(returnwx == '1'){
					_this.loading = true;
					var postdata = {code:code,appid:appid,state:state,jumpurl:jumpurl};
				}else{
					var postdata = {jumpurl: jumpurl,weburl:jumpurl};
				}
				$.get('{:U("Index/hiddenlogin")}', postdata, function(rest) {
					if(rest.success){
						if(rest.continue && rest.continue==1){
							_this.onload();
						}else if(rest.islogin){
							_this.islogin = true;
							showCartDataCache.useryue = rest.yue;
							showCartDataCache.islogin = true;
							localStorage.setItem("tangshidiancan--"+ activityid, JSON.stringify(showCartDataCache));
						}else{
							location.href = rest.jumpurl;
						}
					}else{
						console.log(rest,"返回信息");
						weui.topTips(rest.msg, 3000);
					}
				},"json")
			},
			onload:function(){
				$.post('{:U("Datainfo/getactivityGoods")}', { storeid: storeid,activityid:activityid }, function(rest) {
					if(rest.success) {
						console.log(rest,"商品信息");
						var goods = rest.data.goods;
						var goodsid = goods[0].goodsid;
						goods[0].price = goods[0].goodsprice;
						goods[0].priceFormat = goods[0].goodsprice;
						goods[0].goodsno = 1;
						var goodsdata = [];
						goodsdata.push(goods[0]);
						app.islogin = rest.data.islogin;
						var isweixinpay = rest.data.isweixinpay;
						if(!showCartDataCache.paytype && isweixinpay) {
							showCartDataCache.paytype = "2";
						}else if(!showCartDataCache.paytype && !isweixinpay){
							showCartDataCache.paytype = "0";
						}else if(showCartDataCache.paytype && !isweixinpay){
							showCartDataCache.paytype = "0";
						}
						console.log(showCartDataCache.paytype,"paytype");
						showCartDataCache.goodsdata = goodsdata;
						showCartDataCache.allnumber = 1;
						showCartDataCache.totalPrice = goods[0].goodsprice;
						showCartDataCache.timeinfo = rest.data.timesinfo;
						showCartDataCache.pay = rest.data.paytype;
						showCartDataCache.storetype = rest.data.storetype;
						showCartDataCache.storefapiao = rest.data.storefapiao;
						showCartDataCache.useryue = rest.data.yue;
						showCartDataCache.islogin = rest.data.islogin;
						localStorage.setItem("tangshidiancan--" + activityid,JSON.stringify(showCartDataCache));
						console.log(showCartDataCache);
						if(rest.data.ucode==''){
							app.number = 3;
							app.loading = false;
						}else{
							$.post('{:U("Datainfo/getLimitGoods")}',{activityid:activityid},function(rest) {
								console.log(rest,"获取数量");
								if(rest.success) {
									app.number = rest.data[goodsid];
								}else{
									app.number = 3;
								}
								app.loading = false;
							},"json")
						}
						
					}else{
						console.log(rest,"goods信息");
						weui.topTips(rest.msg, 3000);
					}
				},"json")
				
			},
			jump:function(confirmUrl){
				window.location.href = confirmUrl;
			},
		}
	})
	app.isLogin();
})
