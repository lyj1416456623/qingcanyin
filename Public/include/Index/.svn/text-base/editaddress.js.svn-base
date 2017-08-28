/*This is Index/editaddress js file!*/
$(function(){
	var name = "",
		phone = "",
		address = "",
		cityid ="",
		addressdetail = "",
		addressid = "",
		storeid = "",
		isdefault = "",
		lng="",
		lat = "",
		addressall = "",
		search="";
	//获取本地存储的地址信息
	var myaddress = localStorage.getItem("myaddress");
	myaddress = JSON.parse(myaddress);
	var addressAll = localStorage.getItem("addressAll");
	if(addressAll){
		addressAll = JSON.parse(addressAll);
	}
	lng = myaddress.lng;
	lat = myaddress.lat;
	address = myaddress.address;
	addressid = myaddress.addressid;
	isdefault = myaddress.default;
	storeid = myaddress.storeid;
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	var app = new Vue({
		el : "#body",
		data : {
			addressList : [],
			cityList : [],
			showSearchDiv : false,
			addresText : "",
			search: '',
			myaddressText : [],
		},
		methods:{
			searchData: function() {
		      	search = this.search;
	      		searchAddress(search);
		   },
			showSearch:function(){
				$("#rightDisgo").show().animate({'left':0}, 500); 
			},
			addressText:function(event){
				console.log(event);
				$("#rightDisgo").show().animate({'left':"100%"}, 500);
				this.addresText = event.address;
				storeid = event.storeid;
				lng = event.lng;
				lat = event.lat;
				address = event.address;
			},
			delAddress: function(){
				var loading = weui.loading('loading', {
				    className: 'custom-classname'
				});
				var _this = this;
				$.post('{:U("Datainfo/delUserAddress")}',{addressid:addressid},function(rest){
					loading.hide();
					console.log(rest,addressid,addressAll);
					if(rest.success){
						if(addressAll && addressid == addressAll.addressid){
							localStorage.removeItem('addressAll');
						}
						weui.toast(rest.msg, {
						    duration: 1000,
						    className: 'custom-classname',
						    callback: function(){ 
						    	history.back();
						    }
						});
					}else{
						weui.toast(rest.msg, 3000);
					}
				},"json")
				
			},
			submitForm:function(){
				var form = $("#form").serializeArray();
				for(var i = 0;i < form.length;i++){
					if(form[i].name == "name"){
						name = form[i].value;
					}else if(form[i].name == "phone"){
						phone = form[i].value;
					}else if(form[i].name == "select"){
						cityid = form[i].value;
					}else if(form[i].name == "address"){
						address = form[i].value;
					}else if(form[i].name == "room"){
						addressdetail = form[i].value;
					}
				}
				if(name==""){
					weui.topTips('请输入姓名', 1000);
				}else if(phone == ""){
                    weui.topTips('请输入手机号', 1000);
				}else if(cityid == ""){
                    weui.topTips('请选择城市', 1000);
				}else if(address == ""){
                    weui.topTips('请选择地址', 1000);
				}else if(addressdetail == ""){
                    weui.topTips('请输入详细地址', 1000);
				}else{
					addressall = address + addressdetail;
					if(!myreg.test(phone)){
	                    weui.topTips('请输入正确的手机号', 1000);
					}else{
						var loading = weui.loading('loading', {
						    className: 'custom-classname'
						});
						var _this = this;
						var data = {"storeid":storeid,"default":isdefault,"addressid":addressid,"lng":lng,"lat":lat,"name":name,"phone":phone,"cityid":cityid,"address":address,"addressdetail":addressdetail,"addressall":addressall};
						data = JSON.stringify(data);
						$.post('{:U("Datainfo/editUserAddress")}',{datajson:data},function(rest){
							loading.hide();
							if(rest.success){
								weui.toast('修改成功', {
								    duration: 2000,
								    className: 'custom-classname',
								    callback: function(){ 
								    	history.back();
								    }
								});
							}else{
								weui.topTips('修改失败', 3000);
							}
						},"json")
					}
					
				}
			}
		}
	})
	$.get('{:U("Datainfo/getCity")}',{},function(rest){
		if(rest.success){
			var data = rest.data;
			console.log(data,"获取的城市");
			app.cityList = data;
			for(var i in data){
				if(myaddress.cityid==data[i].cityid){
					myaddress.cityname=data[i].name;
				}
			}
			app.myaddressText = myaddress;
			app.addresText = myaddress.address;
		}
	},"json");
	function searchAddress(search){
		$.post('{:U("Datainfo/searchAddress")}',{key:search},function(rest){
			if(rest.success){
				var data = rest.data;
				app.addressList = data;
			}
		},"json")
	}
	
	//WEUI 效果
    var $searchBar = $('#searchBar'),
        $searchResult = $('#searcher'),
        $searchText = $('#searchText'),
        $searchInput = $('#searchInput'),
        $searchClear = $('#searchClear'),
        $searchCancel = $('#searchCancel');

    function hideSearchResult(){
        $searchResult.hide();
        $searchInput.val('');
    }
    function cancelSearch(){
        hideSearchResult();
        $searchBar.removeClass('weui-search-bar_focusing');
        $searchText.show();
        $("#rightDisgo").show().animate({'left':"100%"}, 500);
    }

    $searchText.on('click', function(){
        $searchBar.addClass('weui-search-bar_focusing');
        $searchInput.focus();
    });
    $searchInput
        .on('blur', function () {
            if(!this.value.length) cancelSearch();
        })
        .on('input', function(){
            if(this.value.length) {
                $searchResult.show();
            } else {
                $searchResult.hide();
            }
        })
    ;
    $searchClear.on('click', function(){
        hideSearchResult();
        $searchInput.focus();
    });
    $searchCancel.on('click', function(){
        cancelSearch();
        $searchInput.blur();
    });
})
