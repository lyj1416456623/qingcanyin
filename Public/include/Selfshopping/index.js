/*This is Selfshopping/index js file!*/
$(function() {
	var typedata = [], //商品分类数据
		goodsdata = [], //商品数据
		goodsdataObj = {}, //商品ID为键值的商品数据索引
		suitnowselect = {}, //当前套餐被选中的项
		typeId,
		isweixinpay = true,
		packboxPrice = 0, //打包盒价格
		packboxNumber = 0, //打包盒数量
		url = "{:U('Selfshopping/orderconfirm')}?storeid=" + storeid + "&localcode=" + localcode +"&stid="+ stid +"&staid="+ staid;
	var longFormat = localStorage.getItem('longFormat');
	var showCartDataCache = localStorage.getItem("tangshidiancan-" + storeid); //购物车数据缓存
	if(showCartDataCache) {
		showCartDataCache = JSON.parse(showCartDataCache);
	} else {
		showCartDataCache = {};
		showCartDataCache.goodsdata = [];
		showCartDataCache.allnumber = 0;
	}
	console.log(showCartDataCache,"购物车");
	var topheight = [],height;
	var app = new Vue({
		el: '#body',
		data: {
			typedata: {}, //分类信息
			goodsdata: [], //商品信息
			suitflagdata: [], //小项信息
			currentGoods: [], //当前商品信息
			currentImg:'',
			cartGoodsData: showCartDataCache, //购物车商品
			typeid: "", //当前的类型id
			remarks: [], //备注信息
			loading: true, //等待
			showCartanimationData: false, //购物车
			showSuitflag: false, //小项
			showCartbox: true, //底部购物车的显示
			allnumber: 0, //购物车里的商品数量
			allprice: 0,
			totalPrice: 0, //购物车商品总价格
			suitflag: "",
			errorText: false,
			errorNull: "暂无商品",
			pay: "",
			paytype: "",
			url: url,
			timeinfo: [],
			longFormat:longFormat,
			storetype:'',
			storename:'',
			storedatu:false,
			localcode:localcode,
			top:'top:64px',
			imgflag:false,
			storefapiao:false,
			useryue:'',
			islogin:false,
			currentBackImg:[],
			packboxPrice: 0, //餐盒费
			switchBox:'0',
		},
		updated: function() {
			topheight = [];
			height = $(".title").outerHeight();
			var width = $(".img").outerWidth();
			$(".img").css('height',width);
			$('.goods_list').each(function(i) {
				if($(this).offset().top - height>=-2){
					topheight.push($(this).offset().top - height + 2);
				}
			})
			this.top = 'top:'+ height +'px';
		},
		methods: {
			floor:function(index){
				console.log(index,"第几个");
				var newtop = topheight[index];
				console.log(topheight,"数组");
				console.log(newtop,"高度");
				$({ top: $(".right").scrollTop() }).animate({ top: newtop }, {
					duration: 500,
					step: function() {
						$(".right").scrollTop(this.top);
					}
				});
			},
			back: function() {
				console.log('判断从哪进来的',this.localcode);
				if(this.localcode==1){
					WeixinJSBridge.call('closeWindow');
				}else{
					history.back();
				}
			},
			switchPackbox:function(){
				this.switchBox = this.switchBox=='1'?'0':'1';
				console.log(this.switchBox);
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
			jump:function(jumpurl){
				console.log(jumpurl);
				if(this.islogin){
					location.href = jumpurl;
				}else{
					$.get('{:U("Index/hiddenlogin")}', {jumpurl: jumpurl,weburl:jumpurl}, function(rest) {
						if(rest.success){
							console.log(rest.islogin,rest.jumpurl,"rest.params",rest.params,"deng");
							if(rest.islogin){
								showCartDataCache.islogin = true;
								localStorage.setItem("tangshidiancan-" + storeid, JSON.stringify(showCartDataCache));
							}
							location.href = rest.jumpurl;

						}else{
							weui.topTips(rest.msg, 3000);
						}
					},"json")
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
				this.showSuitflag = true;
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
//					this.addShopcart();
				}
			},
			//点击商品减
			minusCart: function(goods) {
				this.allnumber--;
				for(var i = 0; i < showCartDataCache.goodsdata.length; i++) {
					if(goods.goodsid == showCartDataCache.goodsdata[i].goodsid) {
						if(showCartDataCache.goodsdata[i].goodsno > 1) {
							showCartDataCache.goodsdata[i].goodsno--;
							showCartDataCache.goodsdata[i].priceFormat = showCartDataCache.goodsdata[i].goodsno * showCartDataCache.goodsdata[i].price;
							console.log(showCartDataCache.goodsdata[i].priceFormat);
							showCartDataCache.goodsdata[i].priceFormat = (showCartDataCache.goodsdata[i].priceFormat).toFixed(2);
						} else {
							showCartDataCache.goodsdata.splice(i, 1);
							break;
						}
					}
				}
				showCartDataCache.allnumber = this.allnumber;
				localStorage.setItem("tangshidiancan-" + storeid, JSON.stringify(showCartDataCache));
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
								"goodspic": this.suitflagdata[i][j].goodspic
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
					packbox: this.currentGoods.packbox, //打包盒数量
					dabao:this.switchBox
				};
				var hash = md5(JSON.stringify(cartData));
				cartData.hash = hash;
				for(var i = 0; i < cartData.suitflagdata.length; i++) {
					if(cartData.suitflagdata[i].addprice != undefined) {
						cartData.addprice += cartData.suitflagdata[i].addprice * cartData.goodsno;
					}
				}
				cartData.priceFormat = (cartData.addprice + cartData.goodsno * cartData.price).toFixed(2);
//				if(this.switchBox=='1'){
//					cartData.priceFormat = (cartData.addprice + cartData.goodsno * cartData.price + cartData.packbox*cartData.goodsno*packboxPrice).toFixed(2);
//				}else{
//					cartData.priceFormat = (cartData.addprice + cartData.goodsno * cartData.price).toFixed(2);
//				}
				console.log(cartData.priceFormat);
				//获取本地存储的数据  如果没有  就重新添加
				showCartDataCache = localStorage.getItem("tangshidiancan-" + storeid);
				showCartDataCache = JSON.parse(showCartDataCache);
				if(showCartDataCache == null || !showCartDataCache) {
					showCartDataCache = {};
					showCartDataCache.goodsdata = [];
					showCartDataCache.allnumber = 0;
					showCartDataCache.totalPrice = 0;
					showCartDataCache.packboxPrice = 0;//总的餐盒费
					showCartDataCache.timeinfo = [];
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
				console.log(showCartDataCache,"添加");
				localStorage.setItem("tangshidiancan-" + storeid, JSON.stringify(showCartDataCache));
				this.switchBox = '0';
				this.reloadGoodsList();

			},
			//购物车数据加
			plusCartdata: function(goods) {
				console.log(goods);
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
						console.log(showCartDataCache.goodsdata[i].priceFormat);
					}
				}
				showCartDataCache.allnumber = this.allnumber;
				localStorage.setItem("tangshidiancan-" + storeid, JSON.stringify(showCartDataCache));
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
					localStorage.removeItem("tangshidiancan-" + storeid);
				} else {
					showCartDataCache.allnumber = this.allnumber;
					localStorage.setItem("tangshidiancan-" + storeid, JSON.stringify(showCartDataCache));
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
				localStorage.removeItem("tangshidiancan-" + storeid);
				this.reloadGoodsList();
			},
			//点击取消
			cancel: function() {
				this.showSuitflag = false;
				this.switchBox='0';
			},
			//获取购物车
			reloadGoodsList: function() {
				var cartList = localStorage.getItem("tangshidiancan-" + storeid);
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
					packboxNumber = 0;//打包盒数量
					for(var i = 0; i < this.typedata.length; i++) {
						this.typedata[i].typenumber = 0;
						for(var j = 0; j < showCartDataCache.goodsdata.length; j++) {
							if(this.typedata[i].typeid == showCartDataCache.goodsdata[j].typeid) {
								this.typedata[i].typenumber += showCartDataCache.goodsdata[j].goodsno;
								this.allprice += Number(showCartDataCache.goodsdata[j].priceFormat);
								packboxNumber += showCartDataCache.goodsdata[j].packbox * showCartDataCache.goodsdata[j].goodsno * showCartDataCache.goodsdata[j].dabao;
							}
						}
					}
					this.allprice = this.allprice.toFixed(2);
					this.packboxPrice = (packboxNumber * packboxPrice).toFixed(2); //餐盒费总价
					this.totalPrice = (Number(this.allprice) + Number(this.packboxPrice)).toFixed(2);
					console.log(this.totalPrice,"总价");
					console.log(this.packboxPrice,"餐盒费总价");
					showCartDataCache.totalPrice = this.totalPrice;
					showCartDataCache.timeinfo = this.timeinfo;
					showCartDataCache.pay = this.pay;
					showCartDataCache.paytype = this.paytype;
					showCartDataCache.storetype = this.storetype;
					showCartDataCache.storefapiao = this.storefapiao;
					showCartDataCache.storename = this.storename;
					showCartDataCache.useryue = this.useryue;
					showCartDataCache.islogin = this.islogin;//判断是否登录
					showCartDataCache.packboxPrice = this.packboxPrice;//总的餐盒费
					localStorage.setItem("tangshidiancan-" + storeid, JSON.stringify(showCartDataCache));
				}
			}
		}
	})
	$.post('{:U("Datainfo/getZizhuGoodsData")}', { storeid: storeid}, function(rest) {
		if(rest.success) {
			console.log('商品页111',rest);
			console.log('路径',location.href);
			app.loading = false;
			if(rest.data.length < 1 || rest.data.goods.length < 1 || rest.data.type.length<1) {
				app.errorText = true;
				app.errorNull = "暂无商品信息";
				return;
			}
			if(rest.data.timesinfo) {
				app.timeinfo = rest.data.timesinfo;
			}
			if(rest.data.storetype){
				app.storetype = rest.data.storetype;
			}
			//餐盒费
			if(rest.data.packbox&&rest.data.packbox.goodsprice){
				packboxPrice = rest.data.packbox.goodsprice;
			}else{
				packboxPrice = '0.01';
			}
			console.log(app.storetype);
			app.typedata = rest.data.type;
			app.goodsdata = rest.data.goods;//后台获取过来的商品
			app.storename = rest.data.storename;
			app.storefapiao = rest.data.storefapiao;//判断是否可以开发票
			app.paytype = showCartDataCache.paytype;
			app.storedatu = rest.data.storedatu;
			app.useryue = rest.data.useryue;
			app.islogin = rest.data.islogin;
			isweixinpay = rest.data.isweixinpay;
			if(!showCartDataCache.paytype && isweixinpay) {
				app.paytype = "2";
			}else if(!showCartDataCache.paytype && !isweixinpay){
				app.paytype = "0";
			}else if(showCartDataCache.paytype && !isweixinpay){
				app.paytype = "0";
			}
			app.pay = rest.data.paytype;
			var newCart = [];
			console.log("后台获取的商品",app.goodsdata);
			console.log("购物车商品",app.cartGoodsData);
			for(var i = 0; i < app.typedata.length; i++) {
				var typeid = app.typedata[i].typeid;
				for(var j = 0; j < app.goodsdata[typeid].length; j++) {
					var goodsid = app.goodsdata[typeid][j].goodsid;
					var goodsname = app.goodsdata[typeid][j].goodsname;
					var oldprice = app.goodsdata[typeid][j].price;
					var goodssuitflag = app.goodsdata[typeid][j].suitflag;
					var newPackbox = app.goodsdata[typeid][j].packbox;
					app.goodsdata[typeid][j].count = 0;
					for(var k = 0; k < showCartDataCache.goodsdata.length; k++) {
						if(goodsid == showCartDataCache.goodsdata[k].goodsid && goodsname == showCartDataCache.goodsdata[k].goodsname && goodssuitflag == showCartDataCache.goodsdata[k].suitflag){
							showCartDataCache.goodsdata[k].price = oldprice;
							showCartDataCache.goodsdata[k].packbox = newPackbox;
							if(!showCartDataCache.goodsdata[k].dabao){
								showCartDataCache.goodsdata[k].dabao = '0';
							}
							if(goodssuitflag=='1'){
								showCartDataCache.goodsdata[k].priceFormat = oldprice * showCartDataCache.goodsdata[k].goodsno + showCartDataCache.goodsdata[k].addprice;
							}else{
								showCartDataCache.goodsdata[k].priceFormat = oldprice * showCartDataCache.goodsdata[k].goodsno;
							}
							console.log(showCartDataCache.goodsdata[k].priceFormat,"单个商品总价");
							showCartDataCache.goodsdata[k].priceFormat = (showCartDataCache.goodsdata[k].priceFormat).toFixed(2);
							newCart.push(showCartDataCache.goodsdata[k]);
							packboxNumber += showCartDataCache.goodsdata[k].goodsno * showCartDataCache.goodsdata[k].packbox * showCartDataCache.goodsdata[k].dabao;
						}
					}
				}
			}
			console.log("新购物车",newCart);
			showCartDataCache.goodsdata = newCart;
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
			showCartDataCache.allnumber = app.allnumber;
			localStorage.setItem("tangshidiancan-" + storeid,JSON.stringify(showCartDataCache));
			app.cartGoodsData = newCart;//购物车商品
			console.log(showCartDataCache.goodsdata);
			app.reloadGoodsList();
		} else {
			app.errorText = true;
			app.errorNull = "信息异常";
		}
	}, "json")
})