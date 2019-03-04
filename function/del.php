<meta charset="utf-8">
<?php
include_once '../config.php';

if ($_GET['pwd']!=$pwd||$_GET['pwd']=='') {
	exit();
}

require 'file/php-sdk-7.2.7/autoload.php'; #引入七牛
use Qiniu\Auth;  #鉴权类
use Qiniu\Storage\BucketManager;

$db = mysqli_connect($db_address,$db_user,$db_pwd,$db_name); #连接数据库

$sql = "SELECT * FROM file WHERE is_del = 1";
$sql_end = mysqli_query($db,$sql);

$i = [];
$j = 0;
while ($result = mysqli_fetch_array($sql_end,MYSQLI_ASSOC)) {
	$i[$j] = $result;
	$j++;
}

for($k = 0 ;$k < sizeof($i) ; $k++){
	$f_id = $i[$k]['id'];
	$sql = "delete from file WHERE id = '$f_id'";
	mysqli_query($db,$sql);  //删除数据库

	if ($is_delqiniu = '1') {
		$key = $i[$k]['qiniu_name'];
		$accessKey = $GLOBALS['accessKey'];
		$secretKey = $GLOBALS['secretKey'];
		$bucket = $GLOBALS['bucket'];
		$auth = new Auth($accessKey, $secretKey);
		$config = new \Qiniu\Config();
		$bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
		$err = $bucketManager->delete($bucket, $key);
		if ($err) {
		    print_r($err);
		}
	}
}

echo "success!删除共计".sizeof($i)."份文件";
?>