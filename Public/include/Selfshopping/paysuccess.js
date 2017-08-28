/*This is Selfshopping/paysuccess js file!*/
var app;
$(function(){
	if(bind=='1'){
		document.title = "取餐成功";
	}
  	app = new Vue({
		el : '#container',
		data : {
			storetype: storetype,
			orderno:orderno,
			localcode:localcode,
			bind:bind,
			serial:serial
		}
	})
})