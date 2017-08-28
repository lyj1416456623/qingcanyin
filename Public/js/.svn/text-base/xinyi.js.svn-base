function reloadAclickLoading(){
	$("a").unbind('click').bind('click',function (){
//		var loading = weui.loading('loading', {
//		    className: 'custom-classname'
//		});
//		setTimeout(function () {
//		    loading.hide(function() {
//		         console.log('`loading` has been hidden');
//		     });
//		}, 3000);
	})
}
function setCache(key,value){
	localStorage[key] = {data:value,time:(time()+3600)};
	
}
function getCache(key){
	if(localStorage[key]){
		if(localStorage[key].time < time()){
			return localStorage[key].data;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
function time() {
	// discuss at: http://locutus.io/php/time/
	// original by: GeekFG (http://geekfg.blogspot.com)
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// improved by: metjay
	// improved by: HKM
	// example 1: var $timeStamp = time()
	// example 1: var $result = $timeStamp > 1000000000 && $timeStamp <
	// 2000000000
	// returns 1: true
	return Math.floor(new Date().getTime() / 1000)
}
function SortBy(arr, prop, desc) {
    var props = [], ret = [], i = 0, len = arr.length;
    if (typeof prop == 'string') {
      for (; i < len; i++) {
        var oI = arr[i];
        (props[i] = new String(oI && oI[prop] || ''))._obj = oI;
      }
    } else if (typeof prop == 'function') {
      for (; i < len; i++) {
        var oI = arr[i];
        (props[i] = new String(oI && prop(oI) || ''))._obj = oI;
      }
    } else {
      throw '参数类型错误';
    }
    props.sort();
    for (i = 0; i < len; i++) {
      ret[i] = props[i]._obj;
    }
    console.log(ret,desc)
    if (desc){
    	ret.reverse();
    	console.log(ret)
    }
    return ret;
}
var compare = function (prop) {
    return function (obj1, obj2) {
        var val1 = obj1[prop];
        var val2 = obj2[prop];
        if (!isNaN(Number(val1)) && !isNaN(Number(val2))) {
            val1 = Number(val1);
            val2 = Number(val2);
        }
        if (val1 < val2) {
            return -1;
        } else if (val1 > val2) {
            return 1;
        } else {
            return 0;
        }            
    } 
}
function getLong (lat_a, lng_a, lat_b, lng_b) {
    /**
     * 根据两个地图坐标计算两点间的直线距离
     */
    //获取两点距离
    var pk = 180 / 3.14169;
    var a1 = lat_a / pk;
    var a2 = lng_a / pk;
    var b1 = lat_b / pk;
    var b2 = lng_b / pk;
    var t1 = Math.cos(a1) * Math.cos(a2) * Math.cos(b1) * Math.cos(b2);
    var t2 = Math.cos(a1) * Math.sin(a2) * Math.cos(b1) * Math.sin(b2);
    var t3 = Math.sin(a1) * Math.sin(b1);
    var tt = Math.acos(t1 + t2 + t3);
    return 6366000 * tt;
}
function getLongFormat (long) {
    /**
     * 对距离进行格式化
     */
    //格式化距离
    if (long > 1000) {
      return (long / 1000).toFixed(2) + '千米';
    } else {
      return long.toFixed(2) + '米';
    }
}