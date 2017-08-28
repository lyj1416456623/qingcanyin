/*This is Shopping/selectaddress js file!*/
var addressAll = localStorage.getItem("addressAll");
if(addressAll){
	addressAll = JSON.parse(addressAll);
}
console.log(addressAll);
$(function() {
	var app = new Vue({
		el: '#body',
		data: {
			loading: true,
			addressList: [],
			checkAddress: {},
		},
		methods: {
			select: function(data) {
				localStorage.setItem("addressAll", JSON.stringify(data));
				location.href = "{:U('shopping/index')}?storeid=" + data.storeid;
			},
			addAddress: function() {
				location.href = "{:U('shopping/addaddress')}";
			}
		}
	})
	$.get('{:U("Datainfo/getUserAddress")}', "", function(rest) {
		app.loading = false;
		if(rest.success) {
			var data = rest.data;
			app.checkAddress = addressAll;
			if(!addressAll){
				app.checkAddress = data[0];
			}
			app.addressList = data;
			console.log(app.checkAddress);
		}
	}, "json")
	var isPageHide = false; 
  	window.addEventListener('pageshow', function () { 
	    if (isPageHide) { 
	      window.location.reload(); 
	    } 
  	}); 
  	window.addEventListener('pagehide', function () { 
    	isPageHide = true; 
  	}); 
	//监听返回事件
//	window.addEventListener("popstate", function(e) {
//		location.href = "{:U('Index/index')}";
//	}, false);
//	function pushHistory() {
//	  	var state = {
//	  		title: "title",
//	  		url: "#"
//	  	};
//	  	window.history.pushState(state, "title", "#");
//	  }
//	pushHistory();
})