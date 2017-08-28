/*This is Integralshop/index js file!*/
var app;
var url = "{:U('Integralshop/exchange')}?id=";
$(function() {
	app = new Vue({
		el : '#body',
		data : {
			loading:true,
			List : [],
		}
	})
	$.post('{:U("Datainfo/getIntergnal")}', {}, function(rest) {
		if(rest.success){
			app.loading = false;
			for(var i in rest.data){
				rest.data[i].styleobj = {
					backgroundImage:'url('+rest.data[i].pic+')'
				}
				rest.data[i].url = url+rest.data[i].id;
			}
			if(rest.data.length<1){
				weui.confirm('目前还没有可以兑换的商品哦！', {
				    title: '提示',
				    buttons: [{
				        label: '返回首页',
				        type: 'primary',
				        onClick: function(){
				        	location.href="{:U('Index/index')}";
				        }
				    }]
				});
			}
			app.List = rest.data;
		}
	}, 'json')
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
