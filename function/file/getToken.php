<?php
include_once "../../config.php";
require 'php-sdk-7.2.7/autoload.php'; #引入七牛
use Qiniu\Auth;  #鉴权类
use Qiniu\Storage\BucketManager;
// 引入上传类
use Qiniu\Storage\UploadManager;


#上传Token
function uploadToken(){
 	// 用于签名的公钥和私钥
	$accessKey = $GLOBALS['accessKey']; #公'WMOuej-P_84LO4bKrsuNSstudJ0BOMBOCbAFLtmz'
	$secretKey = $GLOBALS['secretKey']; #私'hfAtmg3TPm4cf1qJfql8Qa7f_1u3dB78HsSjmpgM';
	//空间名
	$bucket =$GLOBALS['bucket'];
	// 初始化签权对象
	$auth = new Auth($accessKey, $secretKey);
	//token过期时间
	$expires = 3600; #1小时
  //自定义上传回复的凭证 返回的数据
  $returnBody = '{"key":"$(key)","hash":"$(etag)","fsize":$(fsize),"name":"$(x:name)"}';
  $policy = array(
      'returnBody' => $returnBody,
      'callbackBodyType' => 'application/json'
  );

  // 生成上传Token
  $UPtoken = $auth->uploadToken($bucket, null, $expires, $policy, true);
  $res = array('token' => $UPtoken, 'domain' => $GLOBALS['qiniuUrl']);
  $json = json_encode($res);
  exit($json);
}

if ($_GET['type'] = 1) {
	$token = uploadToken();
	exit($json);
}


?>