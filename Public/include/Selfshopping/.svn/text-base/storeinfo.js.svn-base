/*This is Selfshopping/storeinfo js file!*/
var longFormat = localStorage.getItem('longFormat');
$(function(){
	var url = "{:U('Selfshopping/index')}?storeid="+storeid+"&localcode="+localcode+"&staid="+staid+"&stid="+stid;//跳转到商品页
	var app;
	var len;
  	app = new Vue({
		el : '#body',
		data : {
			loading:true,
			content : [],
			pics:[],
			url: url,
			longFormat:　longFormat,
			localcode:localcode,
			staid: staid,
			stid: stid,
			storetype:false,
			showModel:false
		},
		updated:function (){
			$('.flexslider').flexslider({
		    	animation: "slide",
			 	animationLoop: true,
			 	animationDuration: 600,
			 	slideshow:true,
			 	slideshowSpeed: 2000,
			 	manualControls: ".js-slidernav li",
		  	});
		},
		methods:{
			hideModel:function(){
				this.showModel = false;
			},
			submit:function(){
				console.log(localcode);
				this.showModel = true;
//				if(localcode==1 && this.storetype=='3'){
//					var confirm = weui.confirm('点击立即点餐,点餐下单完成后,稍后会有服务员为你送餐哦!', {
//					    title: '温馨提示',
//					    buttons: [{
//					        label: '取消',
//					        type: 'default',
//					        onClick: function(){
//					        	confirm.hide();
//					        }
//					    }, {
//					        label: '立即点餐',
//					        type: 'primary',
//					        onClick: function(){
//					        	window.location.href = "{:U('Selfshopping/index')}?storeid="+storeid+"&localcode="+localcode+"&staid="+staid+"&stid="+stid;
//					        }
//					    }]
//					});
//				}else if(localcode==1 && this.storetype=='1'){
//					var confirm = weui.confirm('点击立即点餐,点餐下单完成后,可在取餐口直接取餐哦!', {
//					    title: '温馨提示',
//					    buttons: [{
//					        label: '取消',
//					        type: 'default',
//					        onClick: function(){
//					        	confirm.hide();
//					        }
//					    }, {
//					        label: '立即点餐',
//					        type: 'primary',
//					        onClick: function(){
//					        	window.location.href = "{:U('Selfshopping/index')}?storeid="+storeid+"&localcode="+localcode+"&staid="+staid+"&stid="+stid;
//					        }
//					    }]
//					});
//				}else if(localcode==0 && this.storetype=='3'){
//					var confirm = weui.confirm('点击立即点餐,点餐下单完成,到店后,进入订单详情点击扫一扫取餐,扫描二维码,稍后会有服务员为你送餐哦!', {
//					    title: '温馨提示',
//					    buttons: [{
//					        label: '取消',
//					        type: 'default',
//					        onClick: function(){
//					        	confirm.hide();
//					        }
//					    }, {
//					        label: '立即点餐',
//					        type: 'primary',
//					        onClick: function(){
//					        	window.location.href = "{:U('Selfshopping/index')}?storeid="+storeid+"&localcode="+localcode+"&staid="+staid+"&stid="+stid;
//					        }
//					    }]
//					});
//				}else if(localcode==0 && this.storetype=='1'){
//					var confirm = weui.confirm('点击立即点餐,点餐下单完成后,到店后,进入订单详情点击扫一扫取餐,扫描二维码,即可到取餐口取餐哦!', {
//					    title: '温馨提示',
//					    buttons: [{
//					        label: '取消',
//					        type: 'default',
//					        onClick: function(){
//					        	confirm.hide();
//					        }
//					    }, {
//					        label: '立即点餐',
//					        type: 'primary',
//					        onClick: function(){
//					        	window.location.href = "{:U('Selfshopping/index')}?storeid="+storeid+"&localcode="+localcode+"&staid="+staid+"&stid="+stid;
//					        }
//					    }]
//					});
//				}
				
			}
		}
	})
	$.post('{:U("Datainfo/getZizhuStoreData")}',{storeid:storeid}, function(rest) {
		console.log(rest);
		if(rest.success){
			if(rest.data.storeid){
				app.loading = false;
				rest.data.styleobj = {
					backgroundImage:'url('+rest.data.icon+')'
				}
				app.content = rest.data;
				app.pics = app.content.images;
				app.storetype = rest.data.storetype;
			}else{
				weui.dialog({
				    content: '当前门店暂未营业',
				    className: 'custom-classname',
				    buttons: [{
				        label: '返回',
				        type: 'primary',
				        onClick: function () {
				        	console.log(localcode);
				        	if(localcode==1){
								WeixinJSBridge.call('closeWindow');
							}else{
								history.back();
							}
				        }
				    }]
				});
			}
			
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
