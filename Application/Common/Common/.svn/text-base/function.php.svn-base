<?php
/**
 * 获取当前时间
 * @return string
 */
function getCtime() {
	return date('Y-m-d H:i:s');
}

/**
 * 获取当前完整域名
 * @return string
 */
function getFullUrl(){
	
	$url =C('DOMAIN_HTTP').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$key = uniqid();
	S($key,C('DOMAIN_HTTP').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	//return $key;
	return $url;
}

/**
 * 登录页面获取登陆成功后跳转地址
 */
function getjumpurl(){
	if(empty($_GET['jumpurl'])){
		return URL('Index/index');
	}
	$url = $_GET['jumpurl'];
	if(isset($_GET['staid'])){
		$url.="&staid=".$_GET['staid'];
	}
	if(isset($_GET['stid'])){
		$url.="&stid=".$_GET['stid'];
	}
	if(isset($_GET['localcode'])){
		$url.="&localcode=".$_GET['localcode'];
	}
	if(isset($_GET['activityid'])){
		$url.="&activityid=".$_GET['activityid'];
	}
	//return S($_GET['jumpurl']);
	return $url;
}

/**
 * 
 */
function getUserInfo(){
	//否则判断是否存在用户登录的session
	if(isset($_SESSION['USERINFO'])){
		return $_SESSION['USERINFO'];
	}
	return false;
}

/**
 * 用户是否登录
 * @return boolean
 */
function is_login(){
	$userinfo = getUserInfo();
	if($userinfo && isset($userinfo['uid']) && !empty($userinfo['uid'])){
		return true;
	}
	return false;
}

/**
 * 获取当前登录用户ID，没有登录返回false
 * @return unknown|boolean
 */
function getUid(){
	if(is_login()){
		return getUserInfo()['uid'];
	}
	return false;
}

//微信相关
/**
 * 通过xinyiapi获取openid
 */
function getOpenid(){
	//此处需要缓存
	
}
/**
 * 通过openapi获取用户的微信信息
 * @param unknown $openid
 */
function getUserWxInfo(){
	//此处需要缓存
}
/**
 * 通过接口判断微信用户是否绑定了用户
 */
function is_wxbinduser(){
	//此处需要缓存
}
/**
 * 如果绑定了用户， 需要刷新用户数据
 * @param unknown $uid
 */
function loadUserInfo($uid){
	
}



/**
 * 验证手机号码是否正确
 * @param unknown $phone
 * @return boolean
 */
function is_phone($phone){
	if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|14[79]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/",$phone)){
		return true;
	}else{
		return false;
	}
}


/**
 * 跳转路径
 * @param unknown $str
 * @param string $group
 * @param string $sid
 * @return string
 */
function URL($str,$group = false,$sid = false){
	if (strpos($str, '/') === false) {
		$urlstr = CONTROLLER_NAME . '/' . $str;
	} else {
		$urlstr = $str;
	}
	$groupModel = C('APP_MODULE_URL');

	if($group){
		//return C('DOMAIN_HTTP')."://".( $sid ? $sid.'.':'' ).$groupModel[$group].'.'.C('DOMAIN_ROOT').U($urlstr);
		return C('DOMAIN_ROOT').U($urlstr);
	}else{
		//return C('DOMAIN_HTTP')."://".( $sid ? $sid.'.':'' ).$_SERVER['HTTP_HOST'].U($urlstr);
		return U($urlstr);
	}
}


/**
 * 输出信息并停止
 * @param string $data  
 * @param string $type
 */
function msg($data,$type = ''){
	if(func_num_args()>2) {// 兼容3.0之前用法
		$args           =   func_get_args();
		array_shift($args);
		$info           =   array();
		$info['info']   =   $data;
		$info['data']   =   array_shift($args);
		$info['status'] =   array_shift($args);
		$data           =   $info;
		$type           =   $args?array_shift($args):'';
	}
	if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
	switch (strtoupper($type)){
		case 'JSON' :
			// 返回JSON数据格式到客户端 包含状态信息
			header('Content-Type:text/html; charset=utf-8');
			exit(json_encode($data));
		case 'XML'  :
			// 返回xml格式数据
			header('Content-Type:text/xml; charset=utf-8');
			exit(xml_encode($data));
		case 'JSONP':
			// 返回JSON数据格式到客户端 包含状态信息
			header('Content-Type:application/json; charset=utf-8');
			$handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
			exit($handler.'('.json_encode($data).');');
		case 'EVAL' :
			// 返回可执行的js脚本
			header('Content-Type:text/html; charset=utf-8');
			exit($data);
		default     :
			header('Content-Type:text/html; charset=utf-8');
			exit(json_encode($data));
	}
}


/**
 * 记录日志信息
 * @param unknown $data		记录数据信息
 * @param string $saveSrc	日志文件保存路径
 * @param string $otherName	特殊名称
 */
function writeLogFile($data='',$saveSrc='',$otherName=''){

	if(stripos($saveSrc,'_saveup_') === 0){
		$fileNameArr = explode('_saveup_', $saveSrc);
		$fileDir = getCacheFileSrc().$fileNameArr[1].'/'.date('Ymd').'/';
		$saveSrc = '';
	}else{
		$fileDir = getCacheFileSrc().date('Ymd').'/';
	}
	if(empty($saveSrc)){
		if(!empty($otherName))$otherName = mb_convert_encoding($otherName,'gbk','utf-8');
		if (!file_exists($fileDir)){
			mkdirs($fileDir);
			if (!file_exists($fileDir)) return true;
		}
		list($usec, $sec) = explode(" ", microtime());
		$saveSrc = $fileDir.$otherName.strtolower('_' . MODULE_NAME . '_' . CONTROLLER_NAME . '_' . ACTION_NAME).date('Y_m_d H_i_s').$sec.rand(10,99).'_log.txt';
	}else{
		$saveSrc =mb_convert_encoding($saveSrc,'gbk','utf-8');
	}

	$newData = array();
	$newData['msg1'] = '请求信息来源URL地址：';
	$newData['source_url'] = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$newData['msg2'] = '请求者IP地址：';
	$newData['source_id'] = getClientIp();
	$newData['msg3'] = '接收$_POST数据信息：';
	$newData['source_post'] = $_POST;
	$newData['msg4'] = '接收$_GET数据信息：';
	$newData['source_get'] = $_GET;
	if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
		$newData['msg5'] = '接收HTTP_RAW_POST_DATA数据信息：';
		$newData['source_raw_post'] = $GLOBALS["HTTP_RAW_POST_DATA"];
	}
	$insertDataStr = var_export($newData,true);
	if(!empty($data)){
		$insertDataStr = rtrim($insertDataStr,')');
		$insertDataStr .= '"msg6"=>"------记录日志信息------",';
		if(stripos($data,'array (') ===0){
			$insertDataStr .="\n'logdata'=>{$data},\n)";
		}else{
			$insertDataStr .="\n'logdata'=>'{$data}',\n)";
		}
	}
	@file_put_contents($saveSrc, $insertDataStr,FILE_APPEND);
}

//输出true或false
function trueorfalse($val){
	if($val == true){
		return true;
	}else{
		return false;
	}
}

/**
 * 模拟发送POST请求信息
 * @param unknown $url			访问地址
 * @param unknown $messageArr	提交信息
 * @param unknown $timeout		设置cURL允许执行的最长秒数
 * @return mixed
 */
function httpPost($url,$messageArr,$timeout='60',$post = false){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
	if($post){
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($messageArr)); // Post提交的数据包
	}else {
		curl_setopt($ch, CURLOPT_POSTFIELDS, $messageArr); // Post提交的数据包
	}
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	$data = curl_exec($ch);
	@curl_close($ch);
	return $data;
}

/**
 * 远程获取数据，GET模式
 * 注意：
 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
 * @param $url 指定URL完整路径地址
 * @param $cacert_url 指定当前工作目录绝对路径
 * return 远程输出的数据
 */
function httpGet($url,$timeout='30') {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	// 过滤HTTP头
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
	// 显示输出结果
	$responseText = curl_exec($curl);
	//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
	curl_close($curl);
	return $responseText;
}

/**
 * 芯易openAPI获取MD5签名信息
 * @param unknown $data		需要签名验证的信息
 * @param unknown $secret	参与签名验证的密钥
 * @return string
 */
function xinyiOpenApiSign($data,$secret){
	$data['secret'] = $secret;
	ksort($data);//array按照key进行排序
	$querystring = array();
	foreach ($data as $key=>$value) {//字符串拼接
		if($key == 'sign')continue;
		$querystring[] = "{$key}={$value}";
	}
	return md5(implode('&', $querystring));
}


/**
 * 判断是否为微信
 * @return boolean
 */
function is_weixin(){
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
		return true;
	}
	return false;
}

/**
 * 模拟请求用户相关操作API接口
 * @param unknown $method
 * @param unknown $data
 * @return boolean|mixed
 */
function getPingtaiApiData($method,$data=array()){
	$url = C('OPEN_API_URL').'?xinyidebug=1';
	$appid = C('APPID');
	$secret = C('APP_SECRET');
	$httpData = array();
	$httpData['appid'] = $appid;
	$httpData['xinyitoken'] = C('XINYITOKEN');
	$httpData['timestamp'] = time();
	$httpData['version'] = 1;
	$httpData['wxappid'] = WXAPPID;
	$httpData['method'] = $method;
	if(is_array($data))$httpData = array_merge($httpData,$data);
	$httpData['sign'] = xinyiOpenApiSign($httpData,$secret);
	$rest = httpPost($url, $httpData);
	$ret = json_decode($rest,true);
	if(empty($ret)){
		return array('code'=>'406','msg'=>'接口请求失败：'.$rest,'url' => $url,'postdata'=>$httpData);
	}else{
		return $ret;
	}
}
//非微信接口
function getOpenApiData($method,$data=array()){
	//@todo
	$url = C('OPEN_API_URL').'?xinyidebug=1';
	$appid = C('APPID');
	$secret = C('APP_SECRET');
	$httpData = array();
	$httpData['appid'] = $appid;
	$httpData['xinyitoken'] = C('XINYITOKEN');
	$httpData['timestamp'] = time();
	$httpData['version'] = 1;
	$httpData['method'] = $method;
	if(is_array($data))$httpData = array_merge($httpData,$data);
	$httpData['sign'] = xinyiOpenApiSign($httpData,$secret);
	$rest = httpPost($url, $httpData);
	$ret = json_decode($rest,true);
// 	dump($url);
// 	dump($rest);
	if(empty($ret)){
		return false;
	}else{
		return $ret;
	}
}

function long2str($v, $w) {
	$len = count($v);
	$n = ($len - 1) << 2;
	if ($w) {
		$m = $v[$len - 1];
		if (($m < $n - 3) || ($m > $n)) return false;
		$n = $m;
	}
	$s = array();
	for ($i = 0; $i < $len; $i++) {
		$s[$i] = pack("V", $v[$i]);
	}
	if ($w) {
		return substr(join('', $s), 0, $n);
	}
	else {
		return join('', $s);
	}
}

function str2long($s, $w) {
	$v = unpack("V*", $s. str_repeat("\0", (4 - strlen($s) % 4) & 3));
	$v = array_values($v);
	if ($w) {
		$v[count($v)] = strlen($s);
	}
	return $v;
}

function int32($n) {
	while ($n >= 2147483648) $n -= 4294967296;
	while ($n <= -2147483649) $n += 4294967296;
	return (int)$n;
}
/**
 * 芯易加密算法，支持和JS通信
 * @param unknown $str
 * @param unknown $key
 */
function xinyi_encrypt($str, $key) {
	$str = urlencode($str);
	if ($str == "") {
		return "";
	}
	$v = str2long($str, true);
	$k = str2long($key, false);
	if (count($k) < 4) {
		for ($i = count($k); $i < 4; $i++) {
			$k[$i] = 0;
		}
	}
	$n = count($v) - 1;

	$z = $v[$n];
	$y = $v[0];
	$delta = 0x9E3779B9;
	$q = floor(6 + 52 / ($n + 1));
	$sum = 0;
	while (0 < $q--) {
		$sum = int32($sum + $delta);
		$e = $sum >> 2 & 3;
		for ($p = 0; $p < $n; $p++) {
			$y = $v[$p + 1];
			$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$z = $v[$p] = int32($v[$p] + $mx);
		}
		$y = $v[0];
		$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
		$z = $v[$n] = int32($v[$n] + $mx);
	}
	return bin2hex(long2str($v, false));
}
/**
 * 芯易解密算法支持和JS通信用
 * @param unknown $str
 * @param unknown $key
 */
function xinyi_decrypt($str, $key) {
	if ($str == "") {
		return "";
	}
	$str = hex2bin($str);
	$v = str2long($str, false);
	$k = str2long($key, false);
	if (count($k) < 4) {
		for ($i = count($k); $i < 4; $i++) {
			$k[$i] = 0;
		}
	}
	$n = count($v) - 1;

	$z = $v[$n];
	$y = $v[0];
	$delta = 0x9E3779B9;
	$q = floor(6 + 52 / ($n + 1));
	$sum = int32($q * $delta);
	while ($sum != 0) {
		$e = $sum >> 2 & 3;
		for ($p = $n; $p > 0; $p--) {
			$z = $v[$p - 1];
			$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$y = $v[$p] = int32($v[$p] - $mx);
		}
		$z = $v[$n];
		$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
		$y = $v[0] = int32($v[0] - $mx);
		$sum = int32($sum - $delta);
	}
	return urldecode(long2str($v, true));
}


/**
 * 生成缓存信息
 * @param unknown $name		缓存名字
 * @param string $value		缓存值
 * @param string $options	缓存参数
 * @param string $prefix	保存数据扩展名
 */
function S_apidata($name,$value='',$prefix='',$isuser=''){

	if(empty($prefix))$prefix = C('APPID').'_#_';
	//if(!empty($isuser))$prefix .= getUid().'_#_';
	if(!empty($isuser)) $prefix .= $_SESSION["USERINFO"]['uid'].'_#_';
	$key = $prefix.$name;

	if(''=== $value){ // 获取缓存
		return  S($key);
	}elseif(is_null($value)) { // 删除缓存
		return S($key,NULL);
	}else {
		return S($key,$value);
	}
}