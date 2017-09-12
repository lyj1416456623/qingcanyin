/*This is Myorder/invoive js file!*/
$(function() {
var myreg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
var phoneReg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(14[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
var money = Number(effective).toFixed(2);
var app = new Vue({
		el: "#body",
		data: {
			content: 　{
				title: "",//抬头
				money: money,//发票金额
				email: "",//邮箱
				phone: "",//手机号
				orderno:orderno,//订单号
				identification:"",//纳税人识别号
				openingBank:"",//开户行
				bankNumber:"",//银行账号
				address:"",//地址
				telephone:""//电话
			}
		},
		methods: {
			location: function() {
				var _this = this;
				console.log(this.content);
				var addressCode = this.content.identification.substring(0,6); //截取字符串前六位
			    var check = this.checkAddressCode(addressCode); // 校验地址码
				if(this.content.title == '') {
					weui.topTips('请填写发票抬头');
				}else if(this.content.identification == ''){
					weui.topTips('请填写纳税人识别号');
				}else if(!check||this.content.identification.length<15||this.content.identification.length>20){
			    	weui.topTips('请填写正确的纳税人识别号');
				}else if(this.content.email == '') {
					weui.topTips('请填写邮箱');
				} else if(!myreg.test(this.content.email)) {
					weui.topTips('邮箱格式错误');
				} else if(!phoneReg.test(this.content.phone)){
					if(this.content.phone==""){
						weui.topTips('请填写手机号', 2000);
					}else{
						weui.topTips('请填写正确的手机号', 2000);
					}
				} else {
					var loading = weui.loading('创建发票...', {
						className: 'custom-classname'
					});
					$.post("{:U('Datainfo/setOrderInvoice')}", {storeid:storeid,title: this.content.title, orderno: orderno,phone: this.content.phone ,email: this.content.email,identification:this.content.identification,openingBank:this.content.openingBank,bankNumber:this.content.bankNumber,address:this.content.address,telephone:this.content.telephone}, function(rest) {
						loading.hide();
						console.log(rest);
						if(rest.success){
							weui.toast(rest.msg, {
							    duration: 3000,
							    className: 'custom-classname',
							    callback: function(){
							    	history.back();
							    }
							});
						}else{
							weui.topTips(rest.msg, 3000);
						}
					}, 'json')
				}
			},
			// 校验地址码
			checkAddressCode: function(addressCode){				
				var provinceAndCitys={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",
			       31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",
			       45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",
			       65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"};				
			    var check = /^[1-9]\d{5}$/.test(addressCode);
			    if(!check) return false;
			    if(provinceAndCitys[parseInt(addressCode.substring(0,2))]){
			    	return true;
			    }else{
			        return false;
			    }
			}			
		}
	})
})