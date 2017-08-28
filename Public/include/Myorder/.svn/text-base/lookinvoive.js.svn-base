/*This is Myorder/lookinvoive js file!*/
$(function(){
	var myreg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 
	var app = new Vue({
		el : "#body",
		data : {
			invoive:[],
			loading:true,
			pdf:'',
		},
		methods : {
			sendemail:function(){
				var _this = this;
				var loading = weui.loading('loading...', {
					className: 'custom-classname'
				});
				$.post("{:U('Datainfo/sendfapiaoEmail')}",{orderno:orderno},function(rest){
					loading.hide();
					if(rest.success){
						weui.toast(rest.msg, {
						    duration: 3000,
						    className: 'custom-classname'
						});
					}else{
						weui.topTips(rest.msg, 3000);
					}
				},'json')
			}
		}
	})
	$.post("{:U('Datainfo/getfapiao')}",{orderno:orderno},function(rest){
		console.log(rest);
		if(rest.success){
			app.loading = false;
			app.invoive = rest.data;
			app.pdf = rest.data.url+'.pdf';
		}else{
			weui.alert(rest.msg, function(){
				history.back();
			});
		}
	},'json')
})