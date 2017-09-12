/*This is Index/login js file!*/
var phoneNumber,checkbox=false;
var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(14[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
$(function(){
	var app = new Vue({
		el : '#body',
		data : {
			phone : "",
			code : "",
			checkbox : false,
			countdown : true ,
			time : 60 
		},
		methods : {
			getPhone : function () {
				//验证手机号
				if(!myreg.test(this.phone)){ 
					if(this.phone==""){
						weui.topTips('请填写手机号', 2000);
					}else{
						weui.topTips('请填写正确的手机号', 2000);
					}
				}else{
					//手机号正确时
					var loading = weui.loading('loading', {
					    className: 'custom-classname'
					});
					phoneNumber = this.phone;
					var _this = this;
					//获取验证码
					$.post('{:U("Datainfo/sendsmscode")}',{phone:phoneNumber,type:1},function(result){
						loading.hide();
						if(result.success){
							_this.countdown = false;
							_this.interval = setInterval(function (){
								_this.time--;
								if(_this.time == 0){
									_this.countdown = true;
									clearInterval(_this.interval);
									_this.time = 60;
								}
							},1000);
							weui.toast('已发送', 3000);
						}else{
							weui.topTips(result.msg, 3000);
						}
					},"json")
				}
	        },
	        submitForm : function(){
	        	//表单验证
	        	if(!myreg.test(this.phone)){ 
					if(this.phone==""){
						weui.topTips('请填写手机号', 2000);
					}else{
						weui.topTips('请填写正确的手机号', 2000);
					}
				}else if(this.code==""){
					weui.topTips('请填写验证码', 2000);
				}else if(!this.checkbox){
					weui.topTips('请勾选同意相关条款', 2000);
				}else{
					//确认登录调登录接口
					xcode=this.code;
					phoneNumber=this.phone;
					var _this = this;
					var loading = weui.loading('loading', {
					    className: 'custom-classname'
					});
					$.post('{:U("Datainfo/binduser")}',{phone:phoneNumber,code:xcode},function(result){
						loading.hide();
						if(result.success){
		                    weui.toast('登录成功', {
							    duration: 2000,
							    className: 'custom-classname',
							    callback: function(){ 
							    	//location.href = '{:getjumpurl()}'
									location.href = jumpurl;
							    }
							});
						}else{
		                    weui.topTips(result.msg, 3000);
						}
					},"json")
				}
	        },
	        boxSelect : function(){
	        	checkbox = this.checkbox;
	        }
		}
	})
})
