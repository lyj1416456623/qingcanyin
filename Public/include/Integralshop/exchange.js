/*This is Integralshop/exchange js file!*/
$(function(){
	var app;
	var len;
	var id=window.location.search.replace(/[^0-9]/ig, "");
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
  	app = new Vue({
		el : '#body',
		data : {
			loading:true,
			content : [],
			pics:[],
			len:[],
			errorText:false,
			type : "",
			address : "",
			phone : "",
			name :""
		},
		updated:function(){
			$('.flexslider').flexslider({
		    	animation: "slide",//图片变化方式   slide滑动
			 	animationLoop: false,//是否循环滚动
			 	animationDuration: 600,//效果延时
			 	slideshow:false,//是否自动滑动
			 	slideshowSpeed: 2000,//滑动内容展示时间
			 	manualControls: ".js-slidernav li",
		  	});
		},
		methods:{
			back:function(){
				history.back();
			},
			submit:function(){
				if(this.type == "2" && this.name==""){
					weui.topTips('请填写姓名');
				}else if(this.type == "2" && !myreg.test(this.phone)){
					if(this.phone == ''){
						weui.topTips('请填写联系方式');
					}else{
						weui.topTips('请填写正确的手机号');
					}
				}else if(this.type == "2" && this.address == ""){
					weui.topTips('请填写寄送地址');
				}else{
					var data;
					if(this.type == "2"){
						data = {'id':id,'address':this.address,'phone':this.phone,'uname':this.name};
					}else{
						data = {'id':id};
					}
					var $dialog = weui.dialog({
					    title: '提示',
					    content: '确定要兑换吗？',
					    className: 'custom-classname',
					    buttons: [{
					        label: '取消',
					        type: 'default',
					        onClick: function () {
					        	$dialog.hide();
					        }
					    }, {
					        label: '立即兑换',
					        type: 'primary',
					        onClick: function () {
					        	var loading = weui.loading('loading', {
								    className: 'custom-classname'
								});
					        	$.post("{:U('Datainfo/Exchange')}",data,function(rest){
									loading.hide();
									if(rest.success){
										weui.dialog({
										    title: '提示',
										    content: '兑换成功',
										    className: 'custom-classname',
										    buttons: [{
										        label: '查看兑换记录',
										        type: 'default',
										        onClick: function () {
										        	window.location.href="{:U('Integralshop/exchangelist')}";
										        }
										    }, {
										        label: '继续兑换',
										        type: 'primary',
										        onClick: function () {
										        	window.history.go(-1);
										        }
										    }]
										});
									}else{
										weui.topTips(rest.msg);
									}
								},'json')
					        }
					    }]
					});
					
				}
			}
		}
	})
	$.post('{:U("Datainfo/getIntergnalDetail")}', {id:id}, function(rest) {
		if(rest.success){
			console.log(rest);
			app.loading = false;
			if(rest.data==null){
				app.errorText = true;
			}else{
				app.content = rest.data;
				app.pics=rest.data.images;
				app.len = 100/app.pics.length;	
				app.type = rest.data.type;
			}
		}
		
	}, 'json')
})