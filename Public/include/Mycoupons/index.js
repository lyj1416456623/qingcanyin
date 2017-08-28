/*This is Mycoupons/index js file!*/
var url = "{:U('Mycoupons/detail')}?id=";
var index = 0,
	app,
	myScroll,       
	pullDownOffset,  
	pullUpOffset,
	loading,
	page = 0,
	pagenumber = 10;//每次加载的步长

function getData(page,pagenumber) {
    $.ajax({
        type:"post",
        url:'{:U("Datainfo/getmycoupons")}',
        dataType:"json",
        data:{page:page,pagenumber:pagenumber},
        success: function (rest) {
        	loading.hide();
        	if(rest.success){
        		var data=rest.data;
        		if(data.length < pagenumber){
    				app.pullUpText = "没有更多数据";
    			}else{
    				app.pullUpText = "上拉加载更多...";
    			}
        		if(page === 0){
        			for(var i in data){
        				data[i].styleobj = {
							background:rest.data[i].background
						}
						data[i].url = url + data[i].id;
        			}
        			app.List = data;
        		}else{
        			$.each(rest.data,function (i,o){
        				if(!o.background){
        					o.styleobj = {
	        					border : '1px solid #eee'
	        				};	
        				}else{
        					o.styleobj = {
	        					background : o.background
	        				};
        				}
            			app.List.push(o);
            		})
        		}
        		setTimeout('myScroll.refresh()',200)
        	}
        },
        error:function(){
        	app.errorText = true;
        }
    })
}
$(function(){
	loading = weui.loading('loading', {
	    className: 'custom-classname'
	});
	app = new Vue({
		el:'#wrapper',
		data : {
			List : [],
			total: 0,
			refreshType : 'down',
			pullDownText : '下拉刷新',
			pullUpText : '上拉刷新',
			pullUpclassName : 'loading',
			pullDownclassName : 'loading',
			errorText : false
		},
		methods : {
			back : function(){
				history.back();
			}
		}
	})
	pullDownOffset = $('#pullDown').outerHeight();
    pullUpOffset = $('#pullUp').outerHeight();
	myScroll = new iScroll('wrapper', {
        useTransition: true,
        topOffset: pullDownOffset,
        onRefresh: function () {
            if(app.refreshType == 'down'){
            	app.pullDownclassName == 'loading';
            	app.pullDownText = '下拉刷新';
            }else{
            	app.pullUpclassName == 'loading';
            }
        },
        onScrollMove: function () {
            if (this.y > 5 && app.pullDownclassName == 'loading') {
                app.pullDownclassName = 'flip';
                app.pullDownText = '下拉刷新';
                this.minScrollY = 0;
            } else if (this.y < 5 && app.pullDownclassName == 'flip') {
            	app.pullDownclassName = 'loading';
                app.pullDownText = '下拉刷新';
                this.minScrollY = -pullDownOffset;
            } else if (this.y < (this.maxScrollY - 5) && app.pullUpclassName == 'loading') {
            	app.pullUpclassName = 'flip';
                this.maxScrollY = this.maxScrollY;
            } else if (this.y > (this.maxScrollY + 5) && app.pullUpclassName == 'flip') {
            	app.pullUpclassName = 'loading';
                this.maxScrollY = pullUpOffset;
            }
        },
        onScrollEnd: function () {
            if (app.pullDownclassName == 'flip') {
            	app.pullDownclassName = 'loading';
                app.refreshType = 'down';
                app.pullDownText = '正在加载...';
                page = 0;
                getData(page,pagenumber);
            } else if (app.pullUpclassName == 'flip') {
            	app.pullUpclassName = 'loading';
                app.refreshType = 'up';
            	if(app.pullUpText!="没有更多数据"){
	                app.pullUpText = '正在加载...';
	                page+=1;
	                getData(page,pagenumber);
            	}
            	
            }
        }
    });
	document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
	getData(page,pagenumber);
})
