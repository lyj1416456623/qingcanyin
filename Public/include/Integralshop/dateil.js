/*This is Integralshop/dateil js file!*/
$(function(){
	var app = new Vue({
		el :　"#body",
		data:{
			integral: [],
			loading: true
		}
	})
	$.post("{:U('Datainfo/getexchangedetail')}",{id:id},function(rest){
		console.log(rest);
		app.loading = false;
		if(rest.success){
			app.integral = rest.data;
		}
	},'json')
})
