/*This is Selfshopping/index js file!*/
var typedata = [], //商品分类数据
	goodsdata = [], //商品数据
	goodsdataObj = {}, //商品ID为键值的商品数据索引
	suitnowselect = {}, //当前套餐被选中的项
	storeid, //门店id
	packboxPrice = 0, //打包盒价格
	packboxNumber = 0, //打包盒数量
	feeprice = 0, //配送费
	freecharge, //免配送费金额
	showCartDataCache, //本地缓存
	typeId,
	isweixinpay = true,
	url = "{:U('shopping/orderconfirm')}?storeid=";
var uid = localStorage.getItem('uid');
var topheight = [];
$(function() {
	var app = new Vue({
		el: '#body',
		data: {
			typedata: {}, //分类信息
			goodsdata: [], //商品信息
			suitflagdata: [], //小项信息
			currentGoods: [], //当前商品信息
			currentImg:[],//当前商品的图片
			cartGoodsData: showCartDataCache, //购物车商品
			typeid: "", //当前的类型id
			remarks: [], //备注信息
			loading: true, //等待
			locationFlag: false, //判断是否要跳转
			showCartanimationData: false, //购物车
			showSuitflag: false, //小项
			showCartbox: true, //底部购物车的显示
			allnumber: 0, //购物车里的商品数量
			allprice: 0, //购物车商品总价格
			suitflag: "",
			totalPrice: 0, //商品加餐盒费+配送费的价格
			feePrice: 0, //配送费
			packboxPrice: 0, //餐盒费
			freePrice:0,//免配送费
			address: "", //地址
			url: url,
			timeinfo: {},
			storedatu:false,
			paytype: "",
			pay: "",
			imgflag:false,
			storefapiao:false,
			useryue:''
		},
		updated: function() {
			$('.goods_list').each(function(i) {
				if($(this).offset().top - 45>=0){
					topheight.push($(this).offset().top - 45);
				}
			})
		},
		methods: {
			floor:function(index){
				var newtop = topheight[index];
				$({ top: $(".right").scrollTop() }).animate({ top: newtop }, {
					duration: 700,
					step: function() {
						$(".right").scrollTop(this.top);
					}
				});
			},
			//返回首页
			back: function() {
				history.back();
			},
			//显示购物车
			showCart: function() {
				if(this.allnumber > 0) {
					if(this.showCartanimationData == true) {
						this.showCartanimationData = true;
					} else {
						this.showCartanimationData = !this.showCartanimationData;
						this.showCartbox = !this.showCartbox;
					}
				} else {
					this.showCartbox = true;
				}
			},
			//隐藏购物车
			hideCart: function() {
				if(this.showCartanimationData == false) {
					this.showCartanimationData = false;
				} else {
					this.showCartanimationData = !this.showCartanimationData;
					this.showCartbox = !this.showCartbox;
				}
			},
			//点击添加购物车
			addCart: function(goods, index, typeid) {
				this.typeid = typeid;
				this.currentGoods = goods;
				this.currentImg = {
					backgroundImage:'url('+goods.goodspic+')'
				}
				if(goods.suitflag == 1 || goods.remarks.length > 0) {
					this.suitflag = goods.suitflag;
					if(goods.suitflag == 1 && goods.suitflagdata.length < 1){
						var confirmDom = weui.confirm('这个套餐还没有设置小项，现在还不能点哦！', {
						    title: '温馨提示',
						    buttons: [{
						        label: '确定',
						        type: 'primary',
						        onClick: function(){
						        	confirmDom.hide();
						        }
						    }]
						});
					}else{
						this.setSelect(goods);
					}
				} else {
					this.suitflag = "0";
					this.addShopcart();
				}
			},
			//点击商品减
			minusCart: function(goods) {
				this.allnumber--;
				for(var i = 0; i < showCartDataCache.goodsdata.length; i++) {
					console.log(showCartDataCache.goodsdata[i].goodsid);
					if(goods.goodsid == showCartDataCache.goodsdata[i].goodsid) {
						if(showCartDataCache.goodsdata[i].goodsno > 1) {
							showCartDataCache.goodsdata[i].goodsno--;
							showCartDataCache.goodsdata[i].priceFormat = showCartDataCache.goodsdata[i].goodsno * showCartDataCache.goodsdata[i].price;
							showCartDataCache.goodsdata[i].priceFormat = (showCartDataCache.goodsdata[i].priceFormat).toFixed(2);
						} else {
							showCartDataCache.goodsdata.splice(i, 1);
							break;
						}
					}
				}
				showCartDataCache.allnumber = this.allnumber;
				localStorage.setItem("waimaidiancan-" + uid + "-" + storeid, JSON.stringify(showCartDataCache));
				this.reloadGoodsList();
			},
			//点击确定加入购物车
			addShopcart: function() {
				this.allnumber++; //购物车总数量
				var form = $("#selectSuitOrRemark").serializeArray();
				this.showSuitflag = false;
				var suitflag = []; //套餐小项
				var remarks = []; //备注
				var suitflagVal = [];
				var remarksVal = [];
				//处理套餐小项
				for(var i = 0; i < form.length; i++) {
					if(form[i].name.indexOf("select") != -1) {
						suitflagVal.push(form[i].value);
					} else {
						remarksVal.push(form[i].value);
					}
				}
				//添加的备注信息
				for(var i in remarksVal) {
					var remark = remarksVal[i];
					for(var j in this.remarks) {
						if(remark == this.remarks[j].remarksid) {
							remarks.push({ "remarksid": this.remarks[j].remarksid, "remarks": this.remarks[j].remarks });
						}
					}
				}
				//添加的小项信息
				for(var i in suitflagVal) {
					var suit = suitflagVal[i];
					for(var j in this.suitflagdata[i]) {
						if(suit == this.suitflagdata[i][j].goodsid) {
							suitflag.push({
								"addprice": this.suitflagdata[i][j].addprice,
								"goodsid": this.suitflagdata[i][j].goodsid,
								"goodsname": this.suitflagdata[i][j].goodsname,
								"goodsno": this.suitflagdata[i][j].goodsno,
								"goodspic": this.suitflagdata[i][j].goodspic,
								"goodsprice": this.suitflagdata[i][j].goodsprice
							})
							break;
						}
					}
				}
				var cartData = {
					goodsid: this.currentGoods.goodsid, //商品ID
					typeid: this.typeid, //类型ID
					goodsname: this.currentGoods.goodsname, //商品名称
					goodspic: this.currentGoods.goodspic, //商品图片
					goodsprice: this.currentGoods.goodsprice, //商品原单价
					discount: (this.currentGoods.goodsprice - this.currentGoods.price), //优惠金额
					price: this.currentGoods.price, //实际金额
					goodsno: 1,
					remarks: remarks,
					suitflag: this.currentGoods.suitflag, //是否为套餐
					suitflagdata: suitflag, //套餐小项列表
					addprice: 0,
					packbox: this.currentGoods.packbox //打包盒数量
				};
				var hash = md5(JSON.stringify(cartData));
				cartData.hash = hash;
				for(var i = 0; i < cartData.suitflagdata.length; i++) {
					if(cartData.suitflagdata[i].addprice != undefined) {
						cartData.addprice += cartData.suitflagdata[i].addprice * cartData.goodsno;
					}
				}
				cartData.priceFormat = (cartData.addprice + cartData.goodsno * cartData.price).toFixed(2);
				//获取本地存储的数据  如果没有  就重新添加
				showCartDataCache = localStorage.getItem("waimaidiancan-" + uid + "-" + storeid);
				showCartDataCache = JSON.parse(showCartDataCache);
				if(showCartDataCache == null || !showCartDataCache) {
					showCartDataCache = {};
					showCartDataCache.goodsdata = [];
					showCartDataCache.allnumber = 0;
					showCartDataCache.totalPrice = 0;
					showCartDataCache.packboxPrice = 0;
					showCartDataCache.feePrice = 0;
					showCartDataCache.timeinfo = {};
				}
				var is_have = false;
				//如果购物车有数据   再次加入的时候需要判断购物车的数据是否购物车中已经有了  如果有的话 直接在数量上加一
				for(var i = 0; i < showCartDataCache.goodsdata.length; i++) {
					if(hash == showCartDataCache.goodsdata[i].hash) {
						is_have = true;
						showCartDataCache.goodsdata[i].goodsno++;
						showCartDataCache.goodsdata[i].addprice += cartData.addprice;
						showCartDataCache.goodsdata[i].priceFormat = Number(showCartDataCache.goodsdata[i].priceFormat) + Number(cartData.priceFormat);
						showCartDataCache.goodsdata[i].priceFormat = (showCartDataCache.goodsdata[i].priceFormat).toFixed(2);
						break;
					}
				}
				if(!is_have) {
					cartData.goodsno = 1;
					cartData.hash = hash;
					showCartDataCache.goodsdata.push(cartData);
				}
				showCartDataCache.allnumber = this.allnumber;
				localStorage.setItem("waimaidiancan-" + uid + "-" + storeid, JSON.stringify(showCartDataCache));
				this.reloadGoodsList();

			},
			//购物车数据加
			plusCartdata: function(goods) {
				this.allnumber++;
				for(var i = 0; i < showCartDataCache.goodsdata.length; i++) {
					if(goods.hash == showCartDataCache.goodsdata[i].hash) {
						showCartDataCache.goodsdata[i].goodsno++;
						if(showCartDataCache.goodsdata[i].suitflag == "1") {
							showCartDataCache.goodsdata[i].addprice = 0;
							console.log(showCartDataCache.goodsdata[i].addprice);
							for(var j = 0; j < showCartDataCache.goodsdata[i].suitflagdata.length; j++) {
								showCartDataCache.goodsdata[i].addprice += showCartDataCache.goodsdata[i].suitflagdata[j].addprice * showCartDataCache.goodsdata[i].goodsno;
							}
							showCartDataCache.goodsdata[i].priceFormat = showCartDataCache.goodsdata[i].goodsno * showCartDataCache.goodsdata[i].price + showCartDataCache.goodsdata[i].addprice;
							showCartDataCache.goodsdata[i].priceFormat = (showCartDataCache.goodsdata[i].priceFormat).toFixed(2);
						} else {
							showCartDataCache.goodsdata[i].priceFormat = showCartDataCache.goodsdata[i].goodsno * showCartDataCache.goodsdata[i].price;
							showCartDataCache.goodsdata[i].priceFormat = (showCartDataCache.goodsdata[i].priceFormat).toFixed(2);
						}
					}
				}
				showCartDataCache.allnumber = this.allnumber;
				localStorage.setItem("waimaidiancan-" + uid + "-" + storeid, JSON.stringify(showCartDataCache));
				this.reloadGoodsList();
			},
			//购物车减
			minusCartdata: function(goods) {
				this.allnumber--;
				for(var i = 0; i < showCartDataCache.goodsdata.length; i++) {
					if(goods.hash == showCartDataCache.goodsdata[i].hash) {
						if(showCartDataCache.goodsdata[i].goodsno > 1) {
							showCartDataCache.goodsdata[i].goodsno--;
							if(showCartDataCache.goodsdata[i].suitflag == "1") {
								showCartDataCache.goodsdata[i].addprice = 0;
								console.log(showCartDataCache.goodsdata[i].addprice);
								for(var j = 0; j < showCartDataCache.goodsdata[i].suitflagdata.length; j++) {
									showCartDataCache.goodsdata[i].addprice += showCartDataCache.goodsdata[i].suitflagdata[j].addprice * showCartDataCache.goodsdata[i].goodsno;
								}
								showCartDataCache.goodsdata[i].priceFormat = showCartDataCache.goodsdata[i].goodsno * showCartDataCache.goodsdata[i].price + showCartDataCache.goodsdata[i].addprice;
								showCartDataCache.goodsdata[i].priceFormat = (showCartDataCache.goodsdata[i].priceFormat).toFixed(2);

							} else {
								showCartDataCache.goodsdata[i].priceFormat = showCartDataCache.goodsdata[i].goodsno * showCartDataCache.goodsdata[i].price;
								showCartDataCache.goodsdata[i].priceFormat = (showCartDataCache.goodsdata[i].priceFormat).toFixed(2);

							}
						} else {
							showCartDataCache.goodsdata.splice(i, 1);
							break;
						}
					}
				}
				if(this.allnumber < 1) {
					localStorage.removeItem("waimaidiancan-" + uid + "-" + storeid);
				} else {
					showCartDataCache.allnumber = this.allnumber;
					localStorage.setItem("waimaidiancan-" + uid + "-" + storeid, JSON.stringify(showCartDataCache));
				}
				this.reloadGoodsList();
			},
			//设置套餐小项
			setSelect: function(goods) {
				this.showSuitflag = true;
				this.suitflagdata = goods.suitflagdata;
				this.remarks = goods.remarks;
			},
			//清空购物车
			clearCart: function() {
				localStorage.removeItem("waimaidiancan-" + uid + "-" + storeid);
				this.reloadGoodsList();
			},
			//点击取消
			cancel: function() {
				this.showSuitflag = false;
			},
			//获取购物车
			reloadGoodsList: function() {
				var cartList = localStorage.getItem("waimaidiancan-" + uid + "-" + storeid);
				cartList = JSON.parse(cartList);
				if(cartList == null) {
					this.cartGoodsData = [];
					this.allnumber = 0;
					this.allprice = 0;
					this.showCartanimationData = false;
					this.showCartbox = true;
					//页面商品数据
					for(var i = 0; i < this.typedata.length; i++) {
						var typeid = this.typedata[i].typeid;
						this.typedata[i].typenumber = 0;
						for(var j = 0; j < this.goodsdata[typeid].length; j++) {
							var goodsid = this.goodsdata[typeid][j].goodsid;
							this.goodsdata[typeid][j].count = 0;
						}
					}
				} else {
					this.cartGoodsData = cartList.goodsdata; //购物车
					//判断页面商品数据
					for(var i = 0; i < this.typedata.length; i++) {
						var typeid = this.typedata[i].typeid;
						for(var j = 0; j < this.goodsdata[typeid].length; j++) {
							var goodsid = this.goodsdata[typeid][j].goodsid;
							this.goodsdata[typeid][j].count = 0;
							this.goodsdata[typeid][j].backgroundImage = {
								backgroundImage:'url('+this.goodsdata[typeid][j].goodspic+')'
							};
							for(var k = 0; k < cartList.goodsdata.length; k++) {
								if(goodsid == cartList.goodsdata[k].goodsid) {
									this.goodsdata[typeid][j].count += cartList.goodsdata[k].goodsno;
								}
							}
						}
					}
					this.allprice = 0;
					packboxNumber = 0;
					for(var i = 0; i < this.typedata.length; i++) {
						this.typedata[i].typenumber = 0;
						for(var j = 0; j < showCartDataCache.goodsdata.length; j++) {
							if(this.typedata[i].typeid == showCartDataCache.goodsdata[j].typeid) {
								this.typedata[i].typenumber += showCartDataCache.goodsdata[j].goodsno;
								this.allprice += Number(showCartDataCache.goodsdata[j].priceFormat);
								packboxNumber += showCartDataCache.goodsdata[j].packbox * showCartDataCache.goodsdata[j].goodsno;
							}
						}
					}
					this.allprice = this.allprice.toFixed(2); //商品总价
					this.packboxPrice = (packboxNumber * packboxPrice).toFixed(2); //餐盒费总价
					if(Number(this.allprice)+Number(this.packboxPrice) >= Number(freecharge)) {
						this.feePrice = "0.00";
						this.totalPrice = Number(this.allprice) + Number(this.packboxPrice);
					} else {
						this.feePrice = feeprice;
						this.totalPrice = Number(this.allprice) + Number(this.packboxPrice);
						this.totalPrice += Number(this.feePrice);
					}
					this.totalPrice = (this.totalPrice).toFixed(2);
					showCartDataCache.totalPrice = this.totalPrice;
					showCartDataCache.packboxPrice = this.packboxPrice;
					showCartDataCache.feePrice = this.feePrice;
					showCartDataCache.timeinfo = this.timeinfo;
					showCartDataCache.storefapiao =  this.storefapiao;
					showCartDataCache.pay = this.pay;
					showCartDataCache.paytype = this.paytype;
					showCartDataCache.useryue = this.useryue;
					console.log("购物车存储",showCartDataCache);
					localStorage.setItem("waimaidiancan-" + uid + "-" + storeid, JSON.stringify(showCartDataCache));
				}
			}
		}
	})
	var addressAll = localStorage.getItem("addressAll");
	//判断如果本地有存储的地址数据   配送地址就是本地存储的  否则就是默认地址
	if(addressAll != null) {
		addressAll = JSON.parse(addressAll);
		storeid = addressAll.storeid;
		app.address = addressAll.addressall;
		url += storeid;
		app.url = url;
	}
	showCartDataCache = localStorage.getItem("waimaidiancan-" + uid + "-" + storeid); //购物车数据缓存
	if(showCartDataCache) {
		showCartDataCache = JSON.parse(showCartDataCache);
	} else {
		showCartDataCache = {};
		showCartDataCache.goodsdata = [];
		showCartDataCache.allnumber = 0;
	}

	//获取storeid来加载商品数据
	$.post('{:U("Datainfo/getWaimaiGoodsData")}', { storeid: storeid }, function(rest) {
		if(rest.success) {
			app.loading = false;
			console.log("外卖",rest);
			if(rest.storestatus){
				if(rest.data.length < 1 || rest.data.goods.length < 1 || rest.data.type.length<1) {
					app.locationFlag = true;
					return;
				}
			}else{
				weui.dialog({
				    content: '当前门店暂未营业',
				    className: 'custom-classname',
				    buttons: [{
				        label: '返回地址列表',
				        type: 'primary',
				        onClick: function () {
				        	history.back();
				        }
				    }]
				});
			}
			app.typedata = rest.data.type; //类型
			app.goodsdata = rest.data.goods; //商品数据
			app.cartGoodsData = showCartDataCache.goodsdata; //购物车数据
			app.paytype = showCartDataCache.paytype;
			app.storedatu = rest.data.storedatu;
			app.storefapiao = rest.data.storefapiao;
			app.useryue = rest.data.useryue;
			isweixinpay = rest.data.isweixinpay;
			if(!showCartDataCache.paytype && isweixinpay) {
				app.paytype = "2";
			}else if(!showCartDataCache.paytype && !isweixinpay){
				app.paytype = "0";
			}else if(showCartDataCache.paytype && !isweixinpay){
				app.paytype = "0";
			}
			app.pay = rest.data.paytype;
			//配送费
			var fee = rest.data.deliveryinfo;
			if(fee == null) {
				feeprice = 0.00; //配送费价格
				freecharge = 0.00; //配送费满多少买配送
				app.freePrice = 0.00;
			} else {
				feeprice = fee.goodsprice; //配送费价格
				freecharge = fee.freecharge; //配送费满多少买配送
				app.freePrice = fee.freecharge;//免配送费
			}
			if(rest.data.packbox==null){
				packboxPrice = 0.00;
			}else{
				packboxPrice = rest.data.packbox.goodsprice;
			}
			if(rest.data.timesinfo) {
				app.timeinfo = rest.data.timesinfo;
			}
			app.feePrice = feeprice;
			var newCart = [];
			//遍历商品  获取商品添加到购物车的数量
			for(var i = 0; i < app.typedata.length; i++) {
				var typeid = app.typedata[i].typeid;
				for(var j = 0; j < app.goodsdata[typeid].length; j++) {
					var goodsid = app.goodsdata[typeid][j].goodsid;
					app.goodsdata[typeid][j].count = 0;
					var goodsname = app.goodsdata[typeid][j].goodsname;
					var oldprice = app.goodsdata[typeid][j].price;
					var goodssuitflag = app.goodsdata[typeid][j].suitflag;
					for(var k = 0; k < showCartDataCache.goodsdata.length; k++) {
						if(goodsid == showCartDataCache.goodsdata[k].goodsid && goodsname == showCartDataCache.goodsdata[k].goodsname && goodssuitflag == showCartDataCache.goodsdata[k].suitflag){
							showCartDataCache.goodsdata[k].price = oldprice;
							if(goodssuitflag=='1'){
								showCartDataCache.goodsdata[k].priceFormat = oldprice * showCartDataCache.goodsdata[k].goodsno + showCartDataCache.goodsdata[k].addprice;
							}else{
								showCartDataCache.goodsdata[k].priceFormat = oldprice * showCartDataCache.goodsdata[k].goodsno;
							}
							showCartDataCache.goodsdata[k].priceFormat = (showCartDataCache.goodsdata[k].priceFormat).toFixed(2);
							app.goodsdata[typeid][j].count += showCartDataCache.goodsdata[k].goodsno;
							newCart.push(showCartDataCache.goodsdata[k]);
							//计算打包盒数量
							packboxNumber += showCartDataCache.goodsdata[k].goodsno * showCartDataCache.goodsdata[k].packbox;
						}
					}
				}
			}
			console.log("新购物车",newCart);
			showCartDataCache.goodsdata = newCart;
			//计算购物车总数量  总价格   和分类的数量
			for(var i = 0; i < app.typedata.length; i++) {
				app.typedata[i].typenumber = 0;
				for(var j = 0; j < showCartDataCache.goodsdata.length; j++) {
					if(app.typedata[i].typeid == showCartDataCache.goodsdata[j].typeid) {
						app.typedata[i].typenumber = app.typedata[i].typenumber + showCartDataCache.goodsdata[j].goodsno;
						app.allprice += Number(showCartDataCache.goodsdata[j].priceFormat);
					}
				}
				app.allnumber += app.typedata[i].typenumber;
			}
			app.allprice = (app.allprice).toFixed(2);
			if(Number(app.allprice)+Number(app.packboxPrice) >= Number(freecharge)) {
				app.feePrice = "0.00";
			}
			showCartDataCache.allnumber = app.allnumber;
			localStorage.setItem("waimaidiancan-" + uid + "-" + storeid,JSON.stringify(showCartDataCache));
			app.cartGoodsData = newCart;//购物车商品
			console.log(showCartDataCache.goodsdata);
			app.packboxPrice = packboxNumber * packboxPrice;
			app.packboxPrice = app.packboxPrice.toFixed(2);
			app.totalPrice = showCartDataCache.totalPrice;
			app.reloadGoodsList();
		} else {
			app.locationFlag = true;
			return;
		}
	}, "json")
})