/*This is Mycoupons/detail js file!*/
$(function(){
	var app;
	var len;
	var id=window.location.search.replace(/[^0-9]/ig, "");
  	app = new Vue({
		el : '#body',
		data : {
			loading:true,
			content : [],
			qrcode : "",
			brcode : ""
			
		}
	})
	$.post('{:U("Datainfo/getmycoupon")}', {id:id}, function(rest) {
		console.log(rest);
		if(rest.success){
			app.loading = false;
			rest.data.styleobj = {
				background:rest.data.background
			}
			app.content = rest.data;
			app.qrcode = 'http://api.xinyisoft.cn/open/qrcode?text=' + rest.data.code;
          	app.brcode = 'http://api.xinyisoft.cn/open/barcode?text=' + rest.data.code;
		}
		
	}, 'json')
})