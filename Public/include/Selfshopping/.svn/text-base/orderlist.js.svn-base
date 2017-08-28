/*This is Selfshopping/orderlist js file!*/
var storetype="1";
$(function(){
	var app = new Vue({
		el:'#body',
		data : {
			List : [],
			loading: true,
			storeid: storeid,
			localcode: localcode,
			stid: stid,
			staid: staid
		},
		methods : {
			isLogin:function(){
				var _this = this;
				//无痕登录
				console.log("code=",code,"appid=",appid,"state=",state,"returnwx",returnwx);
				var jumpurl = '{:U("Selfshopping/orderceshi")}?storeid='+storeid +"&localcode=1&staid="+staid+"&stid="+stid;
				if(returnwx == '1'){
					_this.loading = true;
					var postdata = {code:code,appid:appid,state:state,jumpurl:jumpurl};
				}else{
					var postdata = {jumpurl: jumpurl,weburl:jumpurl};
				}
				$.get('{:U("Index/hiddenlogin")}', postdata, function(rest) {
					if(rest.success){
						console.log(rest,"测试");
						if((rest.continue && rest.continue==1) || rest.islogin){
							_this.onload();
						}else{
//								window.location.href=rest.jumpurl;
							
							setTimeout(function(){
								window.location.href=rest.jumpurl;
							},2000)
						}
					}else{
						console.log(rest,"返回信息");
						weui.topTips(rest.msg, 3000);
					}
				},"json")
			},
			bind:function(item){
				var loading = weui.loading('loading', {
				    className: 'custom-classname'
				});
				if(staid!=''){
					storetype = '3';
				}
				$.post("{:U("Datainfo/completeUserOrder")}",{storeid:storeid,orderno:item.orderno,stid:stid,staid:staid,addtime:item.addtime},function(rest){
					loading.hide();
					console.log(rest);
					if(rest.success){
						window.location.href="{:U('Selfshopping/paysuccess')}?orderno=" + item.orderno+ "&localcode=1&storetype="+storetype+"&storeid="+storeid+"&serial="+rest.data.serial+"&bind=1";
					}else{
						weui.topTips(rest.msg, 3000);
					}
				},'json')
			},
			onload:function(){
				$.post("{:U("Datainfo/getUserOrderList")}",{storeid:storeid},function(rest){
					if(rest.success){
						console.log(rest);
						if(rest.data.length > 0){
							app.loading = false;
							app.list = rest.data;
							storetype = rest.data[0].storetype;
						}else{
							window.location.href="{:U('Selfshopping/storeinfo')}?storeid=" + storeid+ "&localcode=1&staid="+ staid +"&stid=" +stid;
						}
					}else{
						window.location.href="{:U('Selfshopping/storeinfo')}?storeid=" + storeid+ "&localcode=1&staid="+ staid +"&stid=" +stid;
					}
				},'json')
			}
		}
	})
	app.isLogin();
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
