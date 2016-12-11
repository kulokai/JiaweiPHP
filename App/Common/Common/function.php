<?php

/**
 * 模拟请求
 * @param $url string 请求地址
 * @param $data array 数据数组
 * @param bool $isJson
 * @return string 返回结果
 */
function post_https($url,$data,$isJson=true,$headers=null){
    if($isJson)
	    $data = json_encode($data);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	if($headers){
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	}
	$data = curl_exec($ch);
	curl_close($ch);
	return json_decode($data,true);
}

/**
 * 验证图片验证码
 * @param $code
 * @param string $id
 * @return bool
 */
function check_verify($code, $id = ''){
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}

/**
 * 加解密
 * @param array $arr
 * @param $operation String D 解密 E 加密
 * @return mixed|string
 */
function encrypt_kai($arr, $operation = 'E')
{
	if ($operation == 'D') {
		$string = $arr;
	} else {
		$string = serialize($arr);
	}
	$key = md5(C('COOKIE_KEY'));
	$key_length = strlen($key);
	$string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
	$string_length = strlen($string);
	$rndkey = $box = array();
	$result = '';
	for ($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($key[$i % $key_length]);
		$box[$i] = $i;
	}
	for ($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for ($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if ($operation == 'D') {
		if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
			return unserialize(substr($result, 8));
		} else {
			return '';
		}
	} else {
		return str_replace('=', '', base64_encode($result));
	}
}

/**
 * 加密版的cookie操作函数
 * @param $key
 * @param null $value
 * @param $param
 * @return mixed|string
 */
function my_cookie($key, $value = null,$param=null){
	if($value===null){//取值
		return encrypt_kai(cookie($key),'D');
	}else{//存值
		if($param===null){
			cookie($key,encrypt_kai($value,'E'));
		}else{
			cookie($key,encrypt_kai($value,'E'),$param);
		}
	}
}