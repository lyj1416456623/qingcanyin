/*This is Selfshopping/orderdetail js file!*/
$(function() {
	console.log(staid,stid,"桌台");
	var loading,storetype;
	var app = new Vue({
		el: "#body",
		data: {
			order: [],
			goods: [],
			pay: [],
			other: [],
			error: false,
			list: [],
			price: "",
			paytype: [],
			loading: true,
			storetype: storetype
		},
		methods:{
			bindTable:function(item){
				var loading = weui.loading('loading', {
				    className: 'custom-classname'
				});
				$.post("{:U("Datainfo/completeUserOrder")}",{storeid:storeid,orderno:orderno,staid:staid,stid:stid,addtime:item},function(rest){
					loading.hide();
					if(rest.success){
						console.log(rest);
						window.location.href="{:U('Selfshopping/paysuccess')}?orderno=" + orderno+ "&localcode=1&storetype="+storetype+"&serial="+rest.data.serial+"&bind=1";
					}else{
						weui.topTips(rest.msg, 3000);
					}
				},'json')
			}
		}
	})

	function Load() {
		$.post("{:U('Datainfo/getOrderDetail')}", { 'orderno': orderno }, function(rest) {
			console.log(rest.data);
			if(rest.success) {
				app.loading = false;
				app.order = rest.data.order;
				app.goods = rest.data.goods;
				app.pay = rest.data.pay;
				app.address = rest.data.address;
				storetype = rest.data.storetype;
				if(staid!=''){
					storetype = '3';
				}
				app.storetype = storetype;
				for(var i = 0; i < app.pay.length; i++) {
					if(app.pay[i].paytype == "0" || app.pay[i].paytype == "2") {
						app.price = app.pay[i].price;
					}
				}
			} else {
				weui.topTips(rest.msg, 2000);
				setTimeout(function() {
					history.back();
				}, 2000);
			}
		}, 'json')
	}
	Load(); 
})