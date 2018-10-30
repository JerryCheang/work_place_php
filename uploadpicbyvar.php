<?php

include('src/conn_mysql.php');

if(strstr($_POST['picurl'],"ebayimg")){
	echo "ebaypic";
	exit;
}

//模拟登录
//login_post($url, $cookie, $post);
$curl = curl_init();//初始化curl模块
curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
curl_setopt($curl, CURLOPT_POST, 1);//post方式提交
curl_setopt($curl, CURLOPT_URL, "http://120.24.217.87/index.php/ebaymanage/uploadpicbyvar");//登录提交的地址
curl_setopt($curl, CURLOPT_COOKIE, $_POST['ibay_cookie']);
curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);//要提交的信息
$sz = curl_exec($curl);

$i = 1;
while(strstr($sz, "error")){

	if($i >= 10){
		break;
	}

	$sz = curl_exec($curl);
	$i++;

}

echo $sz;
curl_close($curl);
?>
