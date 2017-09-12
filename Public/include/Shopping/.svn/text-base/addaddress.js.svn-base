/*This is Shopping/addaddress js file!*/
$(function(){
	var name = "",
		phone = "",
		address = "",
		cityid ="",
		addressdetail = "",
		addressid = "",
		uid = 1,
		storeid = "",
		isdefault = 1,
		lng="",
		lat = "",
		addressall = "";
		var search="";
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(14[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	var app = new Vue({
		el : "#body",
		data : {
			addressList : [],
			cityList : [],
			showSearchDiv : false,
			addresText : "点击搜索地址",
			search: '',
		},
		watch: {
		    // 如果 question 发生改变，这个函数就会运行
		    search: function (newQuestion) {
			    this.getAnswer();
		    }
		},
		methods:{
			getAnswer: _.debounce(
		      function () {
		        var vm = this;
		        searchAddress(vm.search);
		      },
		      // 这是我们为用户停止输入等待的毫秒数
		      500
		  ),
			showSearch:function(){
				$("#rightDisgo").show().animate({'left':0}, 300); 
			},
			addressText:function(event){
				console.log(event);
				$("#rightDisgo").show().animate({'left':"100%"}, 300);
				this.addresText = event.address;
				storeid = event.storeid;
				lng = event.lng;
				lat = event.lat;
				address = event.address;
				addressid = event.id;
			},
			submitForm:function(){
				var form = $("#form").serializeArray();
				console.log(form);
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
						var data = {"storeid":storeid,"default":isdefault,"lng":lng,"lat":lat,"name":name,"phone":phone,"cityid":cityid,"address":address,"addressdetail":addressdetail,"addressall":addressall};
						data = JSON.stringify(data);
						$.post('{:U("Datainfo/addUserAddress")}',{datajson:data},function(rest){
							loading.hide();
							if(rest.success){
								weui.toast('添加成功', {
								    duration: 2000,
								    className: 'custom-classname',
								    callback: function(){ 
								    	history.back();
								    }
								});
							}else{
								weui.topTips('添加失败', 3000);
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
			app.cityList = data;
		}
	},"json");
	function searchAddress(search){
		$.post('{:U("Datainfo/searchAddress")}',{key:search},function(rest){
			if(rest.success){
				var data = rest.data;
				app.addressList = data;
			}else{
				weui.topTips('没有您要搜索的地址', 2000);
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
        $("#rightDisgo").show().animate({'left':"100%"}, 100);
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
