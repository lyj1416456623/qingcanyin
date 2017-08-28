/*This is Myorder/paycode js file!*/
$(function(){
	var app;
  	app = new Vue({
		el : '#body',
		data : {
			code:"取款码："+code,
			qrcode : 'http://api.xinyisoft.cn/open/qrcode?text=' + code,
			brcode : 'http://api.xinyisoft.cn/open/barcode?text=' + code
			
		}
	})
})