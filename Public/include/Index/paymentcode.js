/*This is Index/paymentcode js file!*/
var flag = true;
var app;
$(function(){
	var len;
	var id=window.location.search.replace(/[^0-9]/ig, "");
  	app = new Vue({
		el : '#body',
		data : {
			loading:true,
			qrcode : "",
			brcode : "",
			time : 60,
			scanned : false,
			code:""
		}
	})
  	setInterval(function(){
  		app.time--;
  		if(app.time == 0){
  			app.time = 60;
  		}
  	},1000);
  	getUserPayCode(app);
	getpaycodestatus(app.code);
	var time = setInterval(function(){
		getUserPayCode(app);
	},60000);
  	setInterval(function(){
		getpaycodestatus(app);
  	},2000);
})
function getpaycodestatus(app){
	$.post('{:U("Datainfo/getpaycodestatus")}',{code:app.code},function(rest){
		if(rest.success){
			console.log("状态码",rest.data);
			if(rest.data=="2"){
				app.scanned = true;
				clearInterval(time);
			}else if(rest.data=="3"){
				app.scanned = false;
				location.href="{:U('Index/paymsg')}";
			}else if(rest.data == "4"){
				app.scanned = false;
				weui.topTips('付款失败，请重新付款', 2000);
				getUserPayCode(app);
			}
		}
	},'json')
}
function getUserPayCode(app){
	$.post('{:U("Datainfo/getUserPayCode")}', {}, function(rest) {
		console.log(rest);
		if(rest.success){
			app.time = 60;
			app.code = rest.data;
			app.qrcode = 'http://api.xinyisoft.cn/open/qrcode?text=' + rest.data;
          	app.brcode = 'http://api.xinyisoft.cn/open/barcode?text=' + rest.data;
          	if(flag){
				app.loading = false;
				flag = false;
			}
		}
		
	}, 'json')
}
