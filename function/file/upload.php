
<?php
#将返回的数据信息加入数据库
include '../../config.php';
$db = mysqli_connect($db_address,$db_user,$db_pwd,$db_name);
if (!$db) 
{ 
    die("连接错误: " . mysqli_connect_error()); 
} 
$file_name = $_GET['file_name']."";
$fsize = $_GET['fsize']."";
$qiniu_name = $_GET['qiniu_name']."";
$pwd = substr($qiniu_name,0,6);
$sql = "INSERT into file (qiniu_name,file_name,is_del,del_time,file_size,t_pwd) VALUES ('$qiniu_name','$file_name',0,now(),'$fsize','$pwd')";
echo $sql;
if(mysqli_query($db,$sql)){
  echo "success";
}else{
  echo mysqli_connect_error();
  echo "error";
}

?>