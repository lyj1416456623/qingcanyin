/*This is Integralshop/exchangelist js file!*/
$(function(){
	var app = new Vue({
		el :　"#body",
		data:{
			exchangeList : [],
			loading : true
		}
	})
	$.get("{:U('Datainfo/getExchangeLog')}",function(rest){
		console.log(rest);
		app.loading = false;
		if(rest.success){
			if(rest.data.length<1){
				weui.confirm('您还没有兑换记录哦', {
				    title: '提示',
				    buttons: [{
				        label: '返回',
				        type: 'default',
				        onClick: function(){
				        	history.back();
				        }
				    }, {
				        label: '去兑换',
				        type: 'primary',
				        onClick: function(){
				        	location.href="{:U('Integralshop/index')}";
				        }
				    }]
				});
			}
			app.exchangeList = rest.data;
		}
	},'json')
})
