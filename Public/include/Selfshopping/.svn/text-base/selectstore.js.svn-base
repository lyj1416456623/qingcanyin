/*This is Selfshopping/selectstore js file!*/
var url = "{:U('Selfshopping/storeinfo')}?storeid=";
var latitude, longitude,store;// 纬度、经度
var uid = localStorage.getItem('uid');
var app;// 全局定义app
$(function() {
	app = new Vue({
		el : '#body',
		data : {
			loading : true,
			content : [],
			pics : [],
			errorText : false
		},
		methods : {
			back : function() {
				history.back();
			},
			select : function(item){
				localStorage.setItem('longFormat',item.longFormat);
				window.location.href = item.url;
			},
			loadLocation : function() {
				$.post('{:U("Datainfo/getSDkconfig")}', {
					url : location.href
				}, function(rest) {
					if (rest.success) {
						if(rest.isweixin){
							if ((/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent))||(/(Android)/i.test(navigator.userAgent))) {  
							    wx.config(rest.data);
								wx.ready(function() {
									// 获取地理位置接口
									wx.getLocation({
										type : 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
										success : function(res) {
											latitude = res.latitude; // 纬度，浮点数，范围为90
											longitude = res.longitude; // 经度，浮点数，范围为180
											app.loadStore();
										},
										fail : function(xhr) {
											console.log(xhr);
										}
									});
								});
							}else {  
								weui.alert('网页版无法获取定位，请在手机微信客户端打开', function(){
									history.back();
								});
							};  
							
						}else{
							weui.alert('网页版无法获取定位，请在手机微信客户端打开', function(){
								history.back();
							});
						}
					} else {
						weui.alert('网络连接不通畅，请稍后重试', function(){
							history.back();
						});
					}
				}, 'json')
			}
			,loadStore:function (){
				store = getCache('storeList');
				if(!store){
					app.reloadStoredata();
				}else{
					app.getContent();
				}
			}
			,reloadStoredata: function (){
				$.post('{:U("Datainfo/getZizhuStoreData")}', {}, function(rest) {
					console.log(rest);
					if (rest.success) {
						app.loading = false;
						if(rest.data.length > 0){
							store = rest.data;
							setCache('storeList',store);
							app.getContent();
						}else{
							app.errorText = true;
						}
					}
				}, 'json')
			}
			,getContent : function() {
				for ( var i in store) {
					app.pics = store[i].images;
					store[i].url = url + store[i].storeid;
					store[i].long = getLong(latitude, longitude,store[i].lat, store[i].lng);
					store[i].longFormat = getLongFormat(store[i].long);
					var cart = localStorage.getItem("tangshidiancan-"+ store[i].storeid);
					if (cart != null || cart != undefined) {
						cart = JSON.parse(cart);
						console.log(cart,"购物车");
						store[i].number = cart.allnumber;
					}
				}
				app.content = store.sort(compare('long'));
			}
		}
	})
	app.loadLocation();
	var isPageHide = false; 
  	window.addEventListener('pageshow', function () { 
	    if (isPageHide) { 
	      window.location.reload(); 
	    } 
  	}); 
  	window.addEventListener('pagehide', function () { 
    	isPageHide = true; 
  	}); 
})
 
