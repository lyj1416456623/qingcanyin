/*This is Selfshopping/orderconfirm js file!*/
var submitLoading;
var app;
$(function() {
	//从本地的获取购物车数据
	var showCartDataCache = {};
	if(activityid && activityid!=null){
		showCartDataCache = localStorage.getItem("tangshidiancan--" + activityid); //购物车数据
	}else{
		showCartDataCache = localStorage.getItem("tangshidiancan-" + storeid); //购物车数据
		console.log(showCartDataCache);
	}
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(14[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	var longFormat = localStorage.getItem('longFormat');
	showCartDataCache = JSON.parse(showCartDataCache);
	if(!showCartDataCache) {
		window.location.href = "{:U('Index/index')}";
		return;
	}
	console.log(showCartDataCache);
	var timeinfo = showCartDataCache.timeinfo;
	var sendtime;
	var paytype = showCartDataCache.paytype;
	var pay = showCartDataCache.pay;
	var storetype = showCartDataCache.storetype;
	var storename = showCartDataCache.storename;
	var member, ptid, isconfirm = 0,phoneNumber,xcode;
	if(pay.length < 1){
		weui.alert('当前店铺尚未配置支付方式，请稍后再来哦！', {
		    title: '温馨提示',
		    buttons: [{
		        label: '确定',
		        type: 'primary',
		        onClick: function(){
		        	window.history.go(-1);
		        }
		    }]
		});
	}
	for(var i = 0; i < pay.length; i++) {
		if(pay[i].paytype == paytype) {
			pay[i].checked = true;
			member = pay[i].member;
			ptid = pay[i].ptid;
		}
	}
	var paylistobj = { "ptid": ptid, "paytype": paytype, "price": showCartDataCache.totalPrice, "member": member };
	var reg = /[\u4E00-\u9FA5]/g;
	app = new Vue({
		el: "#body",
		data: {
			goodsList: showCartDataCache.goodsdata,
			totalPrice: showCartDataCache.totalPrice,
			storefapiao: showCartDataCache.storefapiao,
			sendTime: "",
			paytype: paytype,
			pay: pay,
			member: member,
			orderno: false,
			error: false,
			longFormat: longFormat,
			ptid: ptid,
			localcode: localcode,
			storetype: storetype,
			storename: storename,
			tablelist: '',
			tableLabel: '001',
			areaLabel: '',
			useryue: showCartDataCache.useryue,
			phone: '',
			islogin: showCartDataCache.islogin,
			packboxPrice:showCartDataCache.packboxPrice,
			code : "",
			countdown : true,
			time : 60 ,
			interval:'',
			loading:false,
			serial:'',
			showPackbox:false
			
		},
		methods: {
			isLogin:function(){
				var _this = this;
				//无痕登录
				console.log("code=",code,"appid=",appid,"state=",state,"returnwx",returnwx);
				console.log(_this.pay,"pay");
				if(returnwx == '1'){
					_this.loading = true;
					console.log("进来",returnwx);
					var url = "{:U('Selfshopping/orderconfirm')}?storeid=" + storeid + "&localcode=" + localcode +"&stid="+ stid +"&staid="+ staid;
					$.get('{:U("Index/hiddenlogin")}', {code:code,appid:appid,state:state,jumpurl:url}, function(rest) {
						console.log(rest);
						_this.loading = false;
						if(rest.success){
							if(rest.islogin){
								_this.islogin = true;
								_this.useryue = rest.yue;
								showCartDataCache.islogin = true;
								showCartDataCache.useryue = rest.yue;
								if(activityid && activityid!=null){
									localStorage.setItem("tangshidiancan--" + activityid, JSON.stringify(showCartDataCache));
								}else{
									localStorage.setItem("tangshidiancan-" + storeid, JSON.stringify(showCartDataCache));
								}
							}
						}else{
							weui.topTips(rest.msg, 3000);
						}
					},"json")
				}
			},
			showPicker:function(){
				weui.picker(selpicker, {
					className: 'custom-classname',
					defaultValue: [nowsendDate, nowsendHour, nowsendMinute],
					onChange: function(result) {
						//		       console.log(result);
					},
					onConfirm: function(result) {
						console.log(result);
						showPickerTime = result[0].label + " " + result[1].label + ":" + result[2].label;
						app.sendTime = showPickerTime;
						sendtime = app.sendTime;
						if(sendtime.indexOf("今天") != -1) {
							sendtime = mydate + sendtime.replace(reg, '');
						} else if(sendtime.indexOf("明天") != -1) {
							sendtime = mdate + sendtime.replace(reg, '');
						}
					},
					id: 'doubleLinePicker'
				});
			},
			setChecked: function(e) {
				var _this = this;
				app.paytype = e.target.id;
				paytype = e.target.id;
				for(var i = 0; i < pay.length; i++) {
					pay[i].checked = pay[i].paytype == paytype;
				}
				showCartDataCache.paytype = e.target.id;
				if(activityid && activityid!=null){
					localStorage.setItem("tangshidiancan--" + activityid, JSON.stringify(showCartDataCache));
				}else{
					localStorage.setItem("tangshidiancan-" + storeid, JSON.stringify(showCartDataCache));
				}
				app.member = e.target.dataset.id;
				app.ptid = e.target.dataset.ptid;
				paylistobj.ptid = app.ptid;
				paylistobj.paytype = app.paytype;
				paylistobj.member = app.member;
				console.log(paylistobj);
				console.log(pay,"支付");
			},
			cancel: function() {
				this.error = false;
			},
			setPayapi: function(data) {
				var _this = this;
				console.log(location.href);
				if(app.orderno) {
					var postdata = {
						price: showCartDataCache.totalPrice,
						trade_type: 'JSAPI',
						paytype: "maidan",
						body: '支付' + showCartDataCache.totalPrice + '元',
						orderno: app.orderno,
						localcode: localcode
					};
					console.log(postdata);
					$.post('{:U("Datainfo/createJsPayOrder")}', postdata, function(rest) {
						console.log(submitLoading,"loading");
						submitLoading.hide();
						console.log(rest,"微信支付");
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
										// console.log(res.err_msg);
										window.location.href = "{:U('Selfshopping/paysuccess')}?orderno=" + app.orderno + "&localcode=" + localcode + "&storetype=" + storetype + "&storeid=" + storeid+"&serial="+app.serial;
									} else if(res.err_msg == "get_brand_wcpay_request:cancel") {
										weui.confirm('您创建的订单尚未支付,请尽快完成支付！', {
											title: '确定要取消支付?',
											buttons: [{
												label: '继续支付',
												type: 'default',
												onClick: function() {
													_this.setPayapi();
												}
											}, {
												label: '查看订单',
												type: 'primary',
												onClick: function() {
													window.location.href = "{:U('Myorder/detail')}?type=2&orderno=" + app.orderno + "&localcode=" + localcode + "&storetype=" + storetype + "&storeid=" + storeid;
												}
											}]
										});
									} else {
										weui.confirm('您创建的订单尚未付款成功', {
											title: '订单支付失败',
											buttons: [{
												label: '继续支付',
												type: 'default',
												onClick: function() {
													_this.setPayapi();
												}
											}, {
												label: '查看订单',
												type: 'primary',
												onClick: function() {
													window.location.href = "{:U('Myorder/detail')}?type=2&orderno=" + app.orderno + "&localcode=" + localcode + "&storetype=" + storetype + "&storeid=" + storeid;
												}
											}]
										});
									}
								}
							);

						} else {
							var msg = rest.msg.return_msg?rest.msg.return_msg:rest.msg;
							weui.confirm(msg, {
								title: '订单支付失败',
								buttons: [{
									label: '继续支付',
									type: 'default',
									onClick: function() {
										_this.setPayapi();
									}
								}, {
									label: '查看订单',
									type: 'primary',
									onClick: function() {
										window.location.href = "{:U('Myorder/detail')}?type=2&orderno=" + app.orderno + "&localcode=" + localcode + "&storetype=" + storetype + "&storeid=" + storeid;
									}
								}]
							});
						}
					}, 'json')
				}
			},
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
								console.log(app.paytype,"支付paytypeid");
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
	        	var _this = this;
	        	//表单验证
	        	if(!myreg.test(this.phone)){ 
					if(this.phone==""){
						weui.topTips('请填写手机号', 2000);
					}else{
						weui.topTips('请填写正确的手机号', 2000);
					}
				}else if(this.code==""){
					weui.topTips('请填写验证码', 2000);
				}else{
					//确认登录调登录接口
					xcode=this.code;
					phoneNumber=this.phone;
					var _this = this;
					var loading = weui.loading('loading', {
					    className: 'custom-classname'
					});
					$.post('{:U("Datainfo/binduser")}',{phone:phoneNumber,code:xcode},function(result){
//						loading.hide();
						console.log(result,"绑定");
						if(result.success){
							_this.islogin = true;
		                    _this.submit();
						}else{
							loading.hide();
		                    weui.topTips(result.msg, 3000);
						}
					},"json")
				}
	        },
			submit: function() {
				var _this = this;
				var orderGoods = showCartDataCache.goodsdata;
				var orderTime = new Date();
				var reservation = '1';
				var paylist = [];
				paylist.push(paylistobj);
				var sendtimed = sendtime + ":00";
				console.log(sendtimed,"预约时间");
				console.log(paylist);
				console.log(pay,"支付paytypeid");
				if(localcode == 1) {
					isconfirm = 1
				}
				if(staid != '') {
					storetype = "3";
				}
				var order = { 'isconfirm': isconfirm, 'storeid': storeid, 'stid': stid, 'staid': staid, 'totalprice': showCartDataCache.totalPrice, 'allnumber': showCartDataCache.allnumber, 'yytime': sendtimed ,'packboxPrice': showCartDataCache.packboxPrice};
				console.log(order);
				if(_this.islogin) {
					submitLoading = weui.loading('正在创建订单', {
						className: 'custom-classname'
					});
					$.post('{:U("Datainfo/createzizhuOrder")}', { 'goods': JSON.stringify(orderGoods), 'order': JSON.stringify(order), 'paylist': JSON.stringify(paylist) }, function(rest) {
						console.log(rest);
						if(rest.success) {
							//下单保存订单编号数据
							localStorage.setItem(rest.data.orderno, localcode);
							if(activityid && activityid!=null){
								localStorage.removeItem("tangshidiancan--" + activityid);
							}else{
								localStorage.removeItem("tangshidiancan-" + storeid);
							}
							app.orderno = rest.data.orderno;
							app.serial = rest.data.serial;
							if(app.paytype == "2") {
								_this.setPayapi();
							} else {
								submitLoading.hide();
								if(rest.data.payremarks != '') {
									var confirmDom = weui.confirm('支付异常，点击确定按钮继续支付', {
										title: '订单支付失败',
										buttons: [{
											label: '确定',
											type: 'primary',
											onClick: function() {
												window.location.href = "{:U('Myorder/detail')}?type=2&orderno=" + app.orderno + "&localcode=" + localcode + "&storetype=" + storetype + "&storeid=" + storeid;
											}
										}]
									});
								} else {
									window.location.href = "{:U('Selfshopping/paysuccess')}?orderno=" + rest.data.orderno + "&localcode=" + localcode + "&storetype=" + storetype + "&storeid=" + storeid+"&serial="+rest.data.serial;
								}
							}
						} else {
							submitLoading.hide();
							if(rest.data == "您的账户余额不足") {
								var comfirm = weui.confirm("您的账户余额不足", {
									title: '下单失败',
									buttons: [{
										label: '立即去充值',
										type: 'default',
										onClick: function() {
											window.location.href = "{:U('Recharge/index')}";
										}
									}, {
										label: '使用其他支付方式',
										type: 'primary',
										onClick: function() {
											comfirm.hide();
										}
									}]
								});
							}else{
								weui.topTips(rest.msg, 3000);
							}
							
						}
					}, 'json')
				} else {
					if(!myreg.test(this.phone)){ 
						if(this.phone==""){
							weui.topTips('请填写手机号', 2000);
						}else{
							weui.topTips('请填写正确的手机号', 2000);
						}
					}else if(this.code==""){
						weui.topTips('请填写验证码', 2000);
					}else{
				        _this.submitForm();
				    }
				}
			}
		}
	})
	app.isLogin();
	//计算时间picker
	var date = new Date();
	var timeStart = timeinfo.starttime.replace(new RegExp(/(:)/g), "");
	var timeEnd = timeinfo.stoptime.replace(new RegExp(/(:)/g), "");
	var now = new Date();
	var mydate = now.getFullYear() + '/' + (now.getMonth() + 1) + '/' + now.getDate();
	var newgetMinures;
	if(now.getMinutes() < 10) {
		newgetMinures = "0" + now.getMinutes();
	} else {
		newgetMinures = now.getMinutes();
	}
	var nowTime = now.getHours() + ":" + now.getMinutes();
	var newtime = now.getHours() + ":" + newgetMinures;
	var nowHours = now.getHours();
	var nowMinutes = now.getMinutes();
	nowTime = nowTime.replace(new RegExp(/(:)/g), "");
	newtime = newtime.replace(new RegExp(/(:)/g), "");
	var timestart = timeinfo.starttime.split(":");
	var timestartHours = Number(timestart[0]);
	var timestartMinutes = Number(timestart[1]);
	var timestop = timeinfo.stoptime.split(":");
	var timestopHours = Number(timestop[0]);
	var timestopMinutes = Number(timestop[1]);
	timestartMinutes = Number(Math.ceil(timestartMinutes / 10) + "0");
	var selectDate = [];
	var i = 0;
	var n = 1;
	var nowsendTime = "";
	var day;
	var nowsendDate, nowsendHour, nowsendMinute;
	while(i < timeinfo.maketime) {
		//如果当前时间大于结束时间-配送时间
		if(Number(newtime) > Number(timeEnd)) {
			day = now.getDate() + 1 + i;
			if(day < 10) {
				day = "0" + day;
			}
			if(check(now.getFullYear() + '/' + (now.getMonth() + 1) + '/' + day)) {
				selectDate.push(now.getFullYear() + '/' + (now.getMonth() + 1) + '/' + (now.getDate() + 1 + i));
			} else {
				selectDate.push(now.getFullYear() + '/' + (now.getMonth() + 2) + '/' + n);
				n++;
			}
		} else {
			day = now.getDate() + i;
			if(day < 10) {
				day = "0" + day;
			}
			if(check(now.getFullYear() + '/' + (now.getMonth() + 1) + '/' + day)) {
				selectDate.push(now.getFullYear() + '/' + (now.getMonth() + 1) + '/' + (now.getDate() + i));
			} else {
				selectDate.push(now.getFullYear() + '/' + (now.getMonth() + 2) + '/' + n);
				n++;
			}
		}
		i++;
	}
	//如果现在的时间大于结束时间
	if(Number(newtime) > Number(timeEnd) && Number(newtime) < 2400) {
		nowsendTime = "明天" + " " + timestartHours+":"+timestartMinutes;
		nowsendDate = "明天";
		nowsendHour = timestartHours;
		nowsendMinute = timestartMinutes;
		if(selectDate[1]){
			var confirmDom = weui.confirm('当前店铺休息中，是否预约明日订单?', {
			    title: '温馨提示',
			    buttons: [{
			        label: '取消',
			        type: 'default',
			        onClick: function(){
			        	window.history.go(-1);
			        }
			    }, {
			        label: '确定',
			        type: 'primary',
			        onClick: function(){
			        	confirmDom.hide();
			        }
			    }]
			});
		}else{
			weui.alert('当前店铺休息中，请明天再来下单', {
			    title: '温馨提示',
			    buttons: [{
			        label: '确定',
			        type: 'primary',
			        onClick: function(){
			        	window.history.go(-1);
			        }
			    }]
			});
		}
	} else if(Number(newtime) < Number(timeStart)) {
		nowsendTime = "今天" + " " + timestartHours+":"+timestartMinutes;
		nowsendDate = "今天";
		nowsendHour = timestartHours;
		nowsendMinute = timestartMinutes;
		weui.alert('当前店铺休息中，请稍后再来下单', {
		    title: '温馨提示',
		    buttons: [{
		        label: '确定',
		        type: 'primary',
		        onClick: function(){
		        	window.history.go(-1);
		        }
		    }]
		});
		console.log("时间",nowsendDate, nowsendHour, nowsendMinute);
	} else {
		//预定时间
		if(Math.ceil((nowMinutes) / 10) == 6) {
			nowMinutes = 0;
			nowHours = nowHours + 1;
			nowsendTime = "今天" + " " + nowHours + ":" + "00";
			nowsendDate = "今天";
			nowsendHour = nowHours;
			nowsendMinute = "00";
		} else {
			nowMinutes = Number(Math.ceil((nowMinutes) / 10) + "0");
			nowsendTime = "今天" + " " + nowHours + ":" + (Math.ceil((nowMinutes) / 10)) + "0";
			nowsendDate = "今天";
			nowsendHour = nowHours;
			nowsendMinute = (Math.ceil((nowMinutes) / 10)) + "0";
		}
		
	}
	app.sendTime = nowsendTime;
	var selpicker = [];
	var mdate = now.getFullYear() + '/' + (now.getMonth() + 1) + '/' + (now.getDate() + 1);
	
	for(var i = 0; i < timeinfo.maketime; i++) {
		if(mydate == selectDate[i]) {
			var child1 = [];
			var children0 = [];
			var children1 = [];
			var children10 = [];
			var num = 0;
			if(nowHours < timestartHours) {
				nowHours = timestartHours;
				nowMinutes = timestartMinutes;
			}
			var j = nowHours;
			if(nowHours != timestopHours) {
				for(var o = nowMinutes; o <= 50; o = o + 10) {
					if(o == 0) {
						children0.push({
							label: "00",
							value: "00",
						})
					} else {
						children0.push({
							label: o + "",
							value: o + "",
						})
					}
					num++;
				}
				var num = 0;
				for(var p = 0; p <= 50; p = p + 10) {
					if(p == 0) {
						children1.push({
							label: "00",
							value: "00",
						})
					} else {
						children1.push({
							label: p + "",
							value: p + "",
						})
					}
					num++;
				}
				child1.push({
					label: nowHours + "",
					value: nowHours + "",
					children: children0
				})
				for(j = j + 1; j < timestopHours; j++) {
					child1.push({
						label: j + "",
						value: j + "",
						children: children1
					})
				}
			}
			if(timestopMinutes >= 10) {
				var num = 0;
				for(var s = 0; s <= timestopMinutes; s = s + 10) {
					if(s == 0) {
						children10.push({
							label: "00",
							value: "00",
						})
					} else {
						children10.push({
							label: s + "",
							value: s + "",
						})
					}
					num++;
				}
				child1.push({
					label: j + "",
					value: j + "",
					children: children10
				})
			} else {
				children10.push({
					label: "00",
					value: "00",
				})
				child1.push({
					label: j + "",
					value: j + "",
					children: children10
				})
			}
			selpicker.push({
				label: '今天',
				value: '今天',
				children: child1
			})
		} else if(mdate == selectDate[i]) {
			var child2 = [];
			var children2 = [];
			var children3 = [];
			var children23 = [];
			var k = 0;
			var num = 0;
			for(k = timestartMinutes; k < 60; k = k + 10) {
				if(k == 0) {
					children2.push({
						label: "00",
						value: "00",
					})
				} else {
					children2.push({
						label: k + "",
						value: k + "",
					})
				}
				num++;
			}
			var num = 0;
			for(l = 0; l <= 50; l = l + 10) {
				if(l == 0) {
					children3.push({
						label: "00",
						value: "00",
					})
				} else {
					children3.push({
						label: l + "",
						value: l + "",
					})
				}

				num++;
			}
			child2.push({
				label: timestartHours + "",
				value: timestartHours + "",
				children: children2
			})
			var num = 1;
			var j = 0;
			for(j = timestartHours + 1; j < timestopHours; j++) {
				child2.push({
					label: j + "",
					value: j + "",
					children: children3
				})
				num++;
			}
			if(timestopMinutes >= 10) {
				var num = 0;
				for(var s = 0; s <= timestopMinutes; s = s + 10) {
					children23.push({
						label: s + "",
						value: s + "",
					})
					num++;
				}
				child2.push({
					label: j + "",
					value: j + "",
					children: children23
				})
			} else {
				children23.push({
					label: "00",
					value: "00",
				})
				child2.push({
					label: j + "",
					value: j + "",
					children: children23
				})
			}
			selpicker.push({
				label: '明天',
				value: '明天',
				children: child2
			})

		} else {
			var child3 = [];
			var children4 = [];
			var children5 = [];
			var children45 = [];
			var k = 0;
			var num = 0;
			for(k = timestartMinutes; k < 60; k = k + 10) {
				children4.push({
					label: k + "",
					value: k + "",
				})
				num++;
			}
			var num = 0;
			for(l = 0; l <= 50; l = l + 10) {
				if(l == 0) {
					children5.push({
						label: "00",
						value: "00",
					})
				} else {
					children5.push({
						label: l + "",
						value: l + "",
					})
				}
				num++;
			}
			child3.push({
				label: timestartHours + "",
				value: timestartHours + "",
				children: children4
			})
			var num = 1;
			var j = 0;
			for(j = timestartHours + 1; j < timestopHours; j++) {
				child3.push({
					label: j + "",
					value: j + "",
					children: children5
				})
				num++;
			}
			if(timestopMinutes >= 10) {
				var num = 0;
				for(var s = 0; s <= timestopMinutes; s = s + 10) {
					children45.push({
						label: s + "",
						value: s + "",
					})
					num++;
				}
				child3.push({
					label: j + "",
					value: j + "",
					children: children45
				})
			} else {
				children45.push({
					label: "00",
					value: "00",
				})
				child3.push({
					label: j + "",
					value: j + "",
					children: children45
				})
			}
			selpicker.push({
				label: selectDate[i],
				value: selectDate[i],
				children: child3
			})
		}

	}
	var showPickerTime = "";
	//判断日期
	sendtime = app.sendTime;
	if(sendtime.indexOf("今天") != -1) {
		sendtime = mydate + sendtime.replace(reg, '');
	} else if(sendtime.indexOf("明天") != -1) {
		sendtime = mdate + sendtime.replace(reg, '');
	}
	
})

function check(date) {
	return(new Date(date).getDate() == date.substring(date.length - 2));
}