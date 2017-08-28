/*This is Index/mine js file!*/
$(function(){
	var app = new Vue({
		el:"#body",
		data : {
			myPage : [],
			loading : true
		},
	})
	$.get("{:U('Datainfo/getMyPage')}",{},function(rest){
		console.log(rest);
		if(rest.success){
			app.loading = false;
			app.myPage = rest.data;
		}
	},'json')
})
