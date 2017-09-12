/*This is Shopping/orderconfirm js file!*/
$(function() {
	// 从本地的获取购物车数据
	var uid = localStorage.getItem('uid');
	var submitLoading;
	var showCartDataCache = localStorage.getItem("waimaidiancan-" + uid + "-" + storeid); // 购物车数据
	showCartDataCache = JSON.parse(showCartDataCache);
	if(!showCartDataCache) {
		window.location.href = "{:U('Index/index')}";
		return;
	}
	var address = localStorage.getItem("addressAll");
	address = JSON.parse(address);
	console.log(showCartDataCache);
	var timeinfo = showCartDataCache.timeinfo;
	var paytype = showCartDataCache.paytype;
	var pay = showCartDataCache.pay;
	var member,ptid;
	for(var i = 0; i < pay.length; i++) {
		if(pay[i].paytype == paytype) {
			pay[i].checked = true;
			member = pay[i].member;
			ptid = pay[i].ptid;
		}
	}
	var paylistobj = {"ptid":ptid,"paytype":paytype,"price":showCartDataCache.totalPrice,"member":member};
	var sendtime;
	var reg = /[\u4E00-\u9FA5]/g;
	var app = new Vue({
		el: "#body",
		data: {
			goodsList: showCartDataCache.goodsdata,
			totalPrice: 　showCartDataCache.totalPrice,
			packboxPrice: showCartDataCache.packboxPrice,
			feePrice: 　showCartDataCache.feePrice,
			storefapiao: showCartDataCache.storefapiao,
			address: address,
			sendTime: "",
			paytype: paytype,
			pay: pay,
			member: member,
			orderno: false,
			error: 　false,
			useryue:showCartDataCache.useryue,
		},
		methods: {
			setChecked: function(e) {
				app.paytype = e.target.id;
				showCartDataCache.paytype = e.target.id;
				localStorage.setItem("waimaidiancan-" + uid + "-" + storeid, JSON.stringify(showCartDataCache));
				app.member = e.target.dataset.id;
				app.ptid = e.target.dataset.ptid;
				paylistobj.ptid = app.ptid;
				paylistobj.paytype = app.paytype;
				paylistobj.member = app.member;
				console.log(paylistobj);
			},
			cancel:function(){
				this.error = false;
			},
			setPayapi:function(){
				var _this = this;
				if(app.orderno){
					var postdata={
							price: showCartDataCache.totalPrice,
					        trade_type: 'JSAPI',
					        paytype: "maidan",
					        body: '支付' + showCartDataCache.totalPrice + '元',
					        orderno: app.orderno
						};
						console.log(postdata);
						$.post('{:U("Datainfo/createJsPayOrder")}', postdata, function(rest) {
							submitLoading.hide();
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
										console.log(res.err_msg);
										// 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回
										// ok，但并不保证它绝对可靠。
										if(res.err_msg == "get_brand_wcpay_request:ok") {
											// console.log(res.err_msg);
											window.location.href = "{:U('Shopping/paysuccess')}?type=2&orderno="+app.orderno;
										}else if(res.err_msg == "get_brand_wcpay_request:cancel"){
											weui.confirm('您创建的订单尚未支付,请尽快完成支付！', {
											    title: '确定要取消支付?',
											    buttons: [{
											        label: '继续支付',
											        type: 'default',
											        onClick: function(){
											        	_this.setPayapi();
											        }
											    }, {
											        label: '查看订单',
											        type: 'primary',
											        onClick: function(){
									                	window.location.href = "{:U('Myorder/detail')}?type=2&orderno="+app.orderno;
											        }
											    }]
											});
										}else{
											weui.confirm('您创建的订单尚未付款成功', {
											    title: '订单支付失败',
											    buttons: [{
											        label: '继续支付',
											        type: 'default',
											        onClick: function(){
											        	_this.setPayapi();
											        }
											    }, {
											        label: '查看订单',
											        type: 'primary',
											        onClick: function(){
									                	window.location.href = "{:U('Myorder/detail')}?type=2&orderno="+app.orderno;
											        }
											    }]
											});
										}
									}
								);
								
							}else{
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
						},'json')
				}
			},
			submit: function() {
				var orderGoods = showCartDataCache.goodsdata;
				var order = { 'storeid': storeid, 'totalprice': showCartDataCache.totalPrice, 'paytype': app.paytype, 'member': app.member, 'addressid': address.addressid, 'allnumber': showCartDataCache.allnumber, 'reservation': '1', 'yytime': sendtime, 'packboxPrice': showCartDataCache.packboxPrice };
				submitLoading = weui.loading('Loading', {
					className: 'custom-classname'
				});
				var paylist=[];
				paylist.push(paylistobj);
				var _this = this;
				$.post('{:U("Datainfo/createOrder")}', { 'goods': JSON.stringify(orderGoods), 'order': JSON.stringify(order), 'paylist': JSON.stringify(paylist) }, function(rest) {
					console.log(rest);
					if(rest.success) {
						localStorage.removeItem("waimaidiancan-" + uid + "-" + storeid);
						app.orderno = rest.data.orderno;
						if(app.paytype == "2") {
							_this.setPayapi();
						} else {
							submitLoading.hide();
							if(rest.data.payremarks != '') {
								var confirmDom = weui.confirm("支付异常，点击确定按钮继续支付", {
									title: '订单支付失败',
									buttons: [{
										label: '确定',
										type: 'primary',
										onClick: function() {
						                	window.location.href = "{:U('Myorder/detail')}?type=2&orderno="+app.orderno;
										}
									}]
								});
							} else {
								window.location.href = "{:U('Shopping/paysuccess')}?type=2&orderno="+rest.data.orderno;
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
			}
		}
	})
	// 计算时间picker
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
	var selectDate = [];
	var i = 0;
	var n = 1;
	var nowsendTime = "";
	var day;
	var nowsendDate,nowsendHour,nowsendMinute;
	while(i < timeinfo.maketime) {
		// 如果当前时间大于结束时间-配送时间
		if(Number(nowTime) > Number(timeEnd) - Number(timeinfo.deliverytime)) {
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
	
	// 如果现在的时间大于结束时间-配送时间
	if(Number(newtime) > (Number(timeEnd) - Number(timeinfo.deliverytime)) && Number(newtime) < 2400) {
		if(selectDate[1]){
			nowsendTime = "明天" + " " + timeinfo.starttime;
			nowsendDate = "明天";
			nowsendHour = timestartHours;
			nowsendMinute = timestartMinutes;
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
		nowsendTime = "今天" + " " + timeinfo.starttime;
		nowsendDate = "今天";
		nowsendHour = timestartHours;
		nowsendMinute = timestartMinutes;
		weui.alert('当前店铺休息中，请稍后再来下单哦', {
		    title: '温馨提示',
		    buttons: [{
		        label: '确定',
		        type: 'primary',
		        onClick: function(){
		        	window.history.go(-1);
		        }
		    }]
		});
	} else {
		// 配送的默认时间
		if(nowMinutes + Number(timeinfo.deliverytime) >= 50) {
			nowMinutes = (Math.ceil((nowMinutes + Number(timeinfo.deliverytime) - 60) / 10)) + "0";
			nowsendTime = "今天" + " " + (nowHours + 1) + ":" + nowMinutes;
			nowsendDate = "今天";
			nowsendHour = (nowHours + 1 );
			nowsendMinute = nowMinutes;
		} else {
			nowsendTime = "今天" + " " + nowHours + ":" + (Math.ceil((nowMinutes + Number(timeinfo.deliverytime)) / 10)) + "0";
			nowsendDate = "今天";
			nowsendHour = nowHours;
			nowMinutes = (Math.ceil((nowMinutes + Number(timeinfo.deliverytime)) / 10)) + "0";
		}
	}
	app.sendTime = nowsendTime;
	var selpicker = [];
	var mdate = now.getFullYear() + '/' + (now.getMonth() + 1) + '/' + (now.getDate() + 1);
	var timestart = timeinfo.starttime.split(":");
	var timestartHours = Number(timestart[0]);
	var timestartMinutes = Number(timestart[1]);
	var timestop = timeinfo.stoptime.split(":");
	var timestopHours = Number(timestop[0]);
	var timestopMinutes = Number(timestop[1]);
	for(var i = 0; i < timeinfo.maketime; i++) {
		if(mydate == selectDate[i]) {
			var child1 = [];
			var children0 = [];
			var children1 = [];
			var children10 = [];
			if(now.getMinutes() + Number(timeinfo.deliverytime) >= 60) {
				nowMinutes = now.getMinutes() + Number(timeinfo.deliverytime) - 60;
				nowMinutes = Number(Math.ceil(nowMinutes / 10) + "0");
				nowHours++;
			}
			if(nowHours < timestartHours){
				nowHours = timestartHours;
				nowMinutes = timestartMinutes;
			}
			var num = 0;
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
			var j = 0;
			for(j = nowHours + 1; j < timestopHours; j++) {
				child1.push({
					label: j + "",
					value: j + "",
					children: children1
				})
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
						value: num + 1,
					})
				} else {
					children2.push({
						label: k + "",
						value: num + 1,
					})
				}

				num++;
			}
			var num = 0;
			for(l = 0; l <= 50; l = l + 10) {
				if(l == 0) {
					children3.push({
						label: "00",
						value: num + 1,
					})
				} else {
					children3.push({
						label: l + "",
						value: num + 1,
					})
				}

				num++;
			}
			child2.push({
				label: timestartHours + "",
				value: 1,
				children: children2
			})
			var num = 1;
			var j = 0;
			for(j = timestartHours + 1; j < timestopHours; j++) {
				child2.push({
					label: j + "",
					value: num + 1,
					children: children3
				})
				num++;
			}
			if(timestopMinutes >= 10) {
				var num = 0;
				for(var s = 0; s <= timestopMinutes; s = s + 10) {
					children23.push({
						label: s + "",
						value: num + 1,
					})
					num++;
				}
				child2.push({
					label: j + "",
					value: 1,
					children: children23
				})
			} else {
				children23.push({
					label: "00",
					value: 1,
				})
				child2.push({
					label: j + "",
					value: 1,
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
				if(k == 0) {
					children4.push({
						label: "00",
						value: num + 1,
					})
				} else {
					children4.push({
						label: k + "",
						value: num + 1,
					})
				}

				num++;
			}
			var num = 0;
			for(l = 0; l <= 50; l = l + 10) {
				if(l == 0) {
					children5.push({
						label: "00",
						value: num + 1,
					})
				} else {
					children5.push({
						label: l + "",
						value: num + 1,
					})
				}
				num++;
			}
			child3.push({
				label: timestartHours + "",
				value: 1,
				children: children4
			})
			var num = 1;
			var j = 0;
			for(j = timestartHours + 1; j < timestopHours; j++) {
				child3.push({
					label: j + "",
					value: num + 1,
					children: children5
				})
				num++;
			}
			if(timestopMinutes >= 10) {
				var num = 0;
				for(var s = 0; s <= timestopMinutes; s = s + 10) {
					children45.push({
						label: s + "",
						value: num + 1,
					})
					num++;
				}
				child3.push({
					label: j + "",
					value: 1,
					children: children45
				})
			} else {
				children45.push({
					label: "00",
					value: 1,
				})
				child3.push({
					label: j + "",
					value: 1,
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
	$('#showPicker').on('click', function() {
		weui.picker(selpicker, {
			className: 'custom-classname',
			defaultValue: [nowsendDate, nowsendHour, nowsendMinute],
			onChange: function(result) {
				// console.log(result);
			},
			onConfirm: function(result) {
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
	});
	// 判断日期
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