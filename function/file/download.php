<?php

include_once "../../config.php";
$db = mysqli_connect($db_address,$db_user,$db_pwd,$db_name); #连接数据库
require 'php-sdk-7.2.7/autoload.php'; #引入七牛
use Qiniu\Auth;  #鉴权类
use Qiniu\Storage\BucketManager;
// 引入上传类
use Qiniu\Storage\UploadManager;
#文件下载签名授权
function downloadToken($db,$result){
	// 用于签名的公钥和私钥
	$accessKey = $GLOBALS['accessKey']; #公'WMOuej-P_84LO4bKrsuNSstudJ0BOMBOCbAFLtmz'
	$secretKey = $GLOBALS['secretKey']; #私'hfAtmg3TPm4cf1qJfql8Qa7f_1u3dB78HsSjmpgM';
	//空间名
	$bucket = $GLOBALS['bucket'];
	// 初始化签权对象
	$auth = new Auth($accessKey, $secretKey);
	//token过期时间
	$expires = 3600; #1小时
	
	$baseUrl = $GLOBALS['qiniuUrl'].'/'.$result['qiniu_name']."?attname=".urlencode($result['file_name']);
	// 对链接进行签名
	$downloadUrl = $auth->privateDownloadUrl($baseUrl); #签名意味着授权该下载连接
	return $downloadUrl;
}

$get_pwd = $_GET['pwd'];

$sql = "SELECT * FROM file WHERE t_pwd = '$get_pwd' AND is_del = 0";
$result = mysqli_fetch_array(mysqli_query($db,$sql));
if ($result['qiniu_name']!='') {
	$sql_change = "UPDATE file SET is_del = 1 WHERE id = '$result[id]'";
	mysqli_query($db,$sql_change);//修改状态为已经提取
	echo downloadToken($db,$result);
}else{
	echo "error";
}


?>