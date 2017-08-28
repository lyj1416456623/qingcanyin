/*This is Myorder/detail js file!*/
$(function() {
	var loading;
	var app = new Vue({
		el: "#body",
		data: {
			order: [],
			goods: [],
			pay: [],
			other: [],
			storename:"",
			storefapiao:false,
			box: "",
			song: "",
			fapiao: "",
			fapiaostatus:"",
			loading: true,
			brcode: "",
			showlist: false,
			error: false,
			list: [],
			doiid: "",
			oldptid: "",
			oldpaytype: "",
			price: "",
			paytypeid: "",
			ptid: "",
			paymoney: 0,
			showpaytype: false,
			effective: 0,
			paytype: [],
			time:-1,
			useryue:'',
		},
		methods: {
			//取消订单理由
			cancelorder: function() {
				var _this = this;
				loading = weui.loading('loading', {
					className: 'custom-classname'
				});
				$.post("{:U('Datainfo/getcancelreason')}", {}, function(rest) {
					console.log(rest);
					loading.hide();
					if(rest.success) {
						_this.showlist = true;
						rest.data[0].checked = true;
						_this.list = rest.data;
						_this.doiid = rest.data[0].dociid;
					}
				}, 'json')
			},
			select: function(item) {
				clearInterval(stime);
				this.doiid = item;
			},
			selectpaytype: function(item) {
				clearInterval(stime);
				console.log(item);
				this.paytypeid = item.paytype;
				this.ptid = item.ptid;
			},
			//支付方式
			getPaytype: function(type) {
				var _this = this;
				_this.hideCode();
				loading = weui.loading('loading', {
					className: 'custom-classname'
				});

				$.post("{:U('Datainfo/getPaytype')}", { type: type }, function(rest) {
					console.log(rest);
					loading.hide();
					if(rest.success) {
						_this.showpaytype = true;
						for(var i = 0; i < rest.data.length; i++) {
							if(_this.oldpaytype == rest.data[i].paytype) {
								rest.data[i].checked = true;
								_this.paytypeid = rest.data[i].paytype;
								_this.ptid = rest.data[i].ptid;
							}
						}
						_this.paytype = rest.data;
						_this.useryue = rest.useryue;
						console.log(_this.useryue);

					}
				}, 'json')
			},
			//到店扫一扫
			scanQRCode:function(){
				var _this = this;
				console.log('路径0',location.href.split('#')[0]);
				var url = location.href.split('#')[0];
				$.post('{:U("Datainfo/getSDkconfig")}', {
					url : url
				}, function(rest) {
					if (rest.success) {
						console.log("config",rest);
						wx.config(rest.data);
						wx.error(function(res) {  
					        console.log("出错了：" + res.errMsg); 
					        weui.topTips(res.errMsg, 3000);
					    }); 
						wx.ready(function() {
							wx.scanQRCode({
				                // 默认为0，扫描结果由微信处理，1则直接返回扫描结果
				                needResult : 1,
				                desc : 'scanQRCode desc',
				                success : function(res) {
				                   console.log(res);
				                   	if(res.errMsg == "scanQRCode:ok"){
					                   	var resultStr = res.resultStr;
					                   	console.log(resultStr,"路径");
					                   	if(resultStr.indexOf("http") > -1 ){
					                   		var storeid = getQueryString(resultStr,'storeid');
											var stid = getQueryString(resultStr,'stid')?getQueryString(resultStr,'stid'):'';
						                   	var staid = getQueryString(resultStr,'staid')?getQueryString(resultStr,'staid'):'';
						                   	var localcode = getQueryString(resultStr,'localcode');
						                   	if(staid!=''){
						                   		storetype = "3";
						                   	}
						                   	console.log(storeid,stid,staid,"桌台号");
											if(storeid==_this.order.storeid){
							                   	$.post("{:U("Datainfo/completeUserOrder")}",{storeid:_this.order.storeid,orderno:_this.order.orderno,stid:stid,staid:staid,addtime:_this.order.addtime},function(rest){
													if(rest.success){
														console.log(rest,"返回信息，取餐号码");
														window.location.href="{:U('Selfshopping/paysuccess')}?orderno=" + _this.order.orderno+ "&localcode=" + localcode +"&storetype="+storetype+"&storeid="+_this.order.storeid+"&serial="+rest.data.serial+"&bind=1";
													}else{
														weui.topTips(rest.msg, 3000);
													}
												},'json')
											}else{
												var alertDomer = weui.alert("您所在的门店与您当前订单所属的门店【"+_this.storename+"】不一致", function(){
												    alertDomer.hide();
												});
											}
										}else{
											var alertDom = weui.alert('请扫描服务号的二维码', function(){
											    alertDom.hide();
											});
										}
				                   	}
				                }
				            });
				        });
					}else{
						console.log("出错原因",rest.msg);
						weui.topTips(res.errMsg, 3000);
					}
				},'json')
			},
			//支付
			payorder: function() {
				var _this = this;
				_this.hideCode();
				loading = weui.loading('loading', {
					className: 'custom-classname'
				});
				//获取nowLocalcode（本地用订单编号存储的localcode）
				var nowLocalcode = localStorage.getItem(this.order.orderno);
				console.log(nowLocalcode);
				console.log("oldpaytype=",this.oldpaytype,"paytypeid=",this.paytypeid,"ptid=",this.ptid,"oldptid=",this.oldptid);
				$.post('{:U("Datainfo/setPaytype")}', {localcode:nowLocalcode,orderid: this.order.orderid, price: this.price, oldptid: this.oldptid, oldpaytype: this.oldpaytype, paytype: this.paytypeid, ptid: this.ptid, orderno: this.order.orderno, storeid: this.order.storeid }, function(rest) {
					console.log(rest);
					loading.hide();
					if(rest.success) {
						if(_this.paytypeid == "2") {
							var postdata = {
								price: _this.price,
								trade_type: 'JSAPI',
								paytype: "maidan",
								body: '支付' + _this.price + '元',
								orderno: _this.order.orderno,
								localcode: nowLocalcode
							};
							console.log(postdata);
							$.post('{:U("Datainfo/createJsPayOrder")}', postdata, function(rest) {
								loading.hide();
								console.log(rest);
								if(rest.success) {
									WeixinJSBridge.invoke(
										'getBrandWCPayRequest', {
											"appId": rest.data.appId, // 公众号名称，由商户传入
											"timeStamp": rest.data.timeStamp + '', // 时间戳，自1970年以来的秒数
											"nonceStr": rest.data.nonceStr, // 随机串
											"package": rest.data.package,
											"signType": rest.data.signType, // 微信签名方式：
											"paySign": rest.data.paySign // 微信签名
										},
										function(res) {
											console.log(res);
											// 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回
											// ok，但并不保证它绝对可靠。
											if(res.err_msg == "get_brand_wcpay_request:ok") {
												Load();
											}else if(res.err_msg == "get_brand_wcpay_request:cancel") {
												weui.confirm('您还有支付，确定要取消支付吗?', {
													title: '确定要取消支付?',
													buttons: [{
														label: '继续支付',
														type: 'default',
														onClick: function() {
															_this.payorder();
														}
													}, {
														label: '取消支付',
														type: 'primary',
														onClick: function() {
															Load();
														}
													}]
												});
											}else if(res.err_msg == "get_brand_wcpay_request:fail"){
												weui.confirm('支付失败！', {
													title: '支付失败',
													buttons: [{
														label: '重试支付',
														type: 'default',
														onClick: function() {
															_this.payorder();
														}
													}, {
														label: '取消支付',
														type: 'primary',
														onClick: function() {
															Load();
														}
													}]
												});
											}
										}
									);
								}else{
									var msg = rest.msg.return_msg?rest.msg.return_msg:rest.msg;
									weui.topTips(msg, 3000);
								}
							}, 'json')

						} else if(_this.paytypeid == "0") {
							Load();
							weui.toast('支付成功', {
								duration: 3000,
								className: 'custom-classname'
							});
						}
					} else {
						if(rest.msg == "您的账户余额不足") {
							_this.error = true;
						} else {
							weui.topTips(rest.msg, 3000);
						}
					}
				}, 'json')

			},
			//取消订单
			cancel: function() {
				var _this = this;
				var loading = weui.loading("正在取消...", {
					className: 'custom-classname'
				});
				$.post("{:U('Datainfo/cancleOrder')}", { 'storeid': this.order.storeid, 'orderno': this.order.orderno, 'status': this.order.status, 'dociid': this.doiid }, function(rest) {
					_this.showlist = false;
					loading.hide();
					console.log(rest);
					if(rest.success) {
						Load();
						weui.toast(rest.msg, {
							duration: 3000,
							className: 'custom-classname',
						});
					} else {
						weui.topTips(rest.msg, 3000);
					}
				}, 'json')
			},
			hideCode: function() {
				this.showlist = false;
				this.showpaytype = false;
				this.error = false;
				showTime(addtime);
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
				app.box = rest.data.box;
				app.song = rest.data.song;
				app.fapiao = rest.data.fapiao;
				if(rest.data.fapiaostatus){
					app.fapiaostatus = rest.data.fapiaostatus;
				}
				app.effective = rest.data.effective;
				app.storename = rest.data.storename;
				app.storefapiao = rest.data.storefapiao;
				app.brcode = 'http://api.xinyisoft.cn/open/qrcode?text=' + rest.data.order.code;
				storetype = rest.data.storetype;
				for(var i = 0; i < app.pay.length; i++) {
					if(app.pay[i].paytype == "0" || app.pay[i].paytype == "2") {
						app.oldpaytype = app.pay[i].paytype;
						app.oldptid = app.pay[i].ptid;
						app.price = app.pay[i].price;
					}
				}
				addtime = rest.data.order.addtime;
				if(app.time!=0 && rest.data.order.pstatus!='1'){
					showTime(rest.data.order.addtime);
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
	//获取tableid和areaid方法
	function getQueryString(url,name) {
        var reg = new RegExp('(^|/?|&)' + name + '=([^&]*)(&|$)', 'i');
        var r = url.substr(1).match(reg);
        console.log(r,"方法");
        if (r != null) {
            return unescape(r[2]);
        }
        return null;
    }
	var time=900,stime,cutTime,addtime;
		//转换时间格式
    function formateTime(time) {
        var minute = parseInt(time / 60);
        var lateSecond = time % 60;
        minute = minute < 10 ? ("0" + minute) : minute;
        lateSecond = lateSecond < 10 ? ("0" + lateSecond) : lateSecond;
        return minute + '分钟' + lateSecond +'秒';
    }
   	function showTime(CREATE_TIME){
   	//CREATE_TIME这个时间为订单创建时间，应该服务器返，因为本地的可能不准确
        var sendTimedate = CREATE_TIME.substr(0, 10);
	    var sendTimehour = CREATE_TIME.substr(11, 2) == '00' ? 0 : CREATE_TIME.substr(11, 2).replace(/\b(0+)/gi, "");
	    var sendTimeminute = CREATE_TIME.substr(14, 2) == '00' ? 0 : CREATE_TIME.substr(14, 2).replace(/\b(0+)/gi, "");
	    var sendTimesecond = CREATE_TIME.substr(17, 2) == '00' ? 0 : CREATE_TIME.substr(17, 2).replace(/\b(0+)/gi, "");
	    var thisCreatTime = parseInt(new Date(sendTimedate).getTime() / 1000) + parseInt(sendTimehour) * 3600 + parseInt(sendTimeminute) * 60 + parseInt(sendTimesecond) - 28800;
	    var orderTime = new Date();
	    var currentTime = (Date.parse(new Date(orderTime))) / 1000;
	    var subTime = Math.floor(currentTime) - Math.floor(thisCreatTime);
	    console.log(currentTime,thisCreatTime);
	    console.log('时间',subTime);
        //当前时间和创建时间时间差
        var countTimes = time - subTime; 
        //总时间15分钟减去时间差就是剩下的时间
        if (countTimes <= 0) {
            app.time = 0;
            return false;
        }
        cutTime = formateTime(countTimes);
        countDown(countTimes);
    }
    function countDown(timeNum) {
    	//时间倒计时动画
        var syTime = timeNum;
        console.log('时间',syTime);
        clearInterval(stime);
     	stime = setInterval(function () {
            syTime--;
            if (syTime <= 0) {
            	console.log(app.time);
                clearInterval(stime);
                app.time = 0;
            	Load(); 
            } else {
                //永久存储时间
                cutTime = formateTime(syTime);
                app.time = cutTime;
            }
        }, 1000);
    }
	pushHistory();
	window.addEventListener("popstate", function(e) {
		if(type != 1) {
			window.location.href = "{:U('Index/index')}";
		}else{
			history.back();
//			if (/(iPhone|iPad|iPod)/i.test(navigator.userAgent)) {             
//          	window.location.href = window.document.referrer;
//  		} else { 
//  			window.history.go("-1"); 
//  		}
		}
	}, false);

	function pushHistory() {
		var state = {
			title: "title",
			url: "#"
		};
		window.history.pushState(state, "title", "#");
	}
})