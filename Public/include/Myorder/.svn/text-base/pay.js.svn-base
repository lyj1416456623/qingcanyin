/*This is Myorder/pay js file!*/
var invoice = {};//存储数据在领取发票页使用
$(function(){
	var app = new Vue({
		el : "#body",
		data : {
			order : [],
			goods : [],
			pay : [],
			other : [],
			box : "",
			song : "",
			fapiao : "",
			loading : true,
			brcode : "",
			showCode : false,
			showlist : false,
			list: [],
			doiid:"",
			paymoney:0,
		},
		methods:{
			cancelorder:function(){
				var _this = this;
				_this.showlist = true;
				$.post("{:U('Datainfo/getcancelreason')}",{},function(rest){
					console.log(rest);
					if(rest.success){
						rest.data[0].checked = true;
						_this.list = rest.data;
						_this.doiid = rest.data[0].dociid;
						console.log(_this.doiid);
					}
				},'json')
			},
			select:function(item){
				console.log(item);
				this.doiid = item;
			},
			cancel:function(){
				var loading = weui.loading('正在取消', {
					className: 'custom-classname'
				});
				var _this = this;
				$.post("{:U('Datainfo/cancleOrder')}",{'orderno':this.order.orderno,'status':this.order.status,'dociid':this.doiid},function(rest){
					loading.hide();
					_this.showlist = false;
					console.log(rest);
					if(rest.success){
						weui.toast(rest.msg, {
						    duration: 3000,
						    className: 'custom-classname',
						    callback: function(){
						    	Load();
						    }
						});
					}else{
						weui.toast(rest.msg, 2000)
					}
				},'json')
			},
			takeMeal:function(code){
				this.showCode = true;
				this.brcode = 'http://api.xinyisoft.cn/open/qrcode?text=' + code;
			},
			hideCode:function(){
				this.showCode = false;
				this.showlist = false;
			}
		}
	})
	function Load(){
		$.post("{:U('Datainfo/getOrderDetail')}",{'orderno':orderno},function(rest){
			if(rest.success){
				app.loading = false;
				app.order = rest.data.order;
				app.goods = rest.data.goods;
				app.pay = rest.data.pay;
				app.address = rest.data.address;
				app.box = rest.data.box;
				app.song = rest.data.song;
				app.fapiao = rest.data.fapiao;
				if(rest.data.address.title){
					invoice.title = rest.data.address.title;
				}
				console.log(app.pay);
				for(var i=0;i< app.pay.length;i++){
					app.paymoney+=Number(app.pay[i].price);
				}
				invoice.storeid = rest.data.pay.storeid;
				invoice.money = rest.data.pay.price;
				invoice.orderno = rest.data.order.orderno;
				invoice.addtime = rest.data.order.addtime;
				invoice.orderid = rest.data.order.orderid;
				localStorage.setItem('invoice',JSON.stringify(invoice));
			}else{
				var loading = weui.loading(rest.msg, {
				    className: 'custom-classname'
				});
				setTimeout(function () {
				    history.back();
				}, 2000);
			}
		},'json')
	}
	Load();
})
