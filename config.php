<?php
/**
 * Created by 术与道.
 * User: Sad
 * Date: 2019/3/2
 * Time: 20:02
 */
$db_address = "127.0.0.1";  //数据库地址
$db_name = "wenchuan";	//
$db_user = "root";
$db_pwd = "root";

global $accessKey;
global $secretKey;
global $bucket;
global $qiniuUrl;
global $is_delqiniu;

$accessKey = "";  //七牛云公钥
$secretKey = '';	//七牛云私钥
$bucket =''; //七牛云空间
$qiniuUrl = '';  //七牛云加速域名  不要以 ‘/’ 结尾
$pwd = '233233'; //内容清理密码  清理已被下载标记的内容
$is_delqiniu = '1';  //1删除数据库记录与七牛云文件  0 仅仅删除数据记录
?>
