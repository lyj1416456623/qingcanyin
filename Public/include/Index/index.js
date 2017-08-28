/*This is Index/index js file!*/
var app;
$(function() {
	app = new Vue({
		el : '#body',
		data : {
			loading : true,
			showContent:false,
			headItems : [],
			qrcode : {},
			headBgImage : "#F9AB32",
			username : 'loading...',
			usericon : 'loading...',
			yue : 'loading...',
			jifen : 'loading...',
			userInfo:{},
			guanggaodata:[],
		},updated:function (){
			reloadAclickLoading();
		},
		methods:{
			mine: function(){
				location.href="{:U('Index/mine')}";
			},
			paymentcode: function(){
				location.href="{:U('Index/paymentcode')}";
			}
		}
	})
	$.post('{:U("Datainfo/getindexData")}', {}, function(rest) {
		console.log(rest);
		if(rest.success){
			rest.data.styleobj = {
				backgroundImage:'url('+rest.data.headBgImage+')'
			}
			for(var i = 0;i<rest.data.guanggaodata.length;i++){
				rest.data.guanggaodata[i].backgroundImage = {
					backgroundImage:'url('+rest.data.guanggaodata[i].icon+')'
				}
			}
			app.username = rest.data.username;
			app.usericon = rest.data.usericon;
			app.headBgImage = rest.data.styleobj;
			if(rest.data.yue==null){
				app.yue = 0;
			}else{
				app.yue = rest.data.yue;
			}
			if(rest.data.jifen==null){
				app.jifen = 0;
			}else{
				app.jifen = rest.data.jifen;
			}
			app.loading = false;
			app.showContent = true;
			app.headItems = rest.data.headItems;
			app.qrcode = rest.data.qrcode;
			app.guanggaodata = rest.data.guanggaodata;
		}else{
			app.loading = false;
			if(rest.errcode == '100'){
				weui.dialog({
				    title: '{:L("系统提示")}',
				    content: '{:L("尚未绑定用户，是否立即绑定？")}',
				    className: 'custom-classname',
				    buttons: [{
				        label: '{:L("立即登陆")}',
				        type: 'primary',
				        onClick: function () {
				        	location.href = '{:U("Index/login")}?jumpurl={:U("Index/index")}';
				        }
				    }]
				});
			}
			
		}
	}, 'json')
	//获取
	$.post('{:U("Datainfo/getUserdata")}', {}, function(rest) {
		if(rest.success){
			if(rest.data.uid){
				localStorage.setItem('uid',rest.data.uid);
			}
			app.userInfo = rest.data;
		}
	},"json")
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
