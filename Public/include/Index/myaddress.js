/*This is Index/myaddress js file!*/
$(function(){
	var app = new Vue({
		el : '#body',
		data : {
			loading : true,
			addressList : []
		},
		methods:{
			select:function(data){
				localStorage.setItem("myaddress",JSON.stringify(data));
				location.href="{:U('Index/editaddress')}?addressid="+data.addressid;
			},
			addAddress:function(){
				location.href="{:U('shopping/addaddress')}";
			}
		}
	})
	$.get('{:U("Datainfo/getUserAddress")}',"",function(rest){
		app.loading = false;
		if(rest.success){
			var data = rest.data;
			app.addressList = data;
			console.log(data);
		}
	},"json")
	var isPageHide = false; 
  	window.addEventListener('pageshow', function () { 
	    if (isPageHide) { 
	      window.location.reload(); 
	    } 
  	}); 
  	window.addEventListener('pagehide', function () { 
    	isPageHide = true; 
  	}); 
})
