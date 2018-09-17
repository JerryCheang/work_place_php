<?php
set_time_limit(0);
include('src/conn_mysql.php');

$post = array (
	'username' => $_COOKIE["username"],
	'password' => $_COOKIE["password"],
	'submit' => '登录'
);
//登录地址
$url = "http://".$web_site."/index.php/myibay/login";
//设置cookie保存路径
$cookie = dirname(__FILE__) . '/cookie_ibay.txt';
//登录后要获取信息的地址
$url2 = "http://".$web_site."/index.php/muban/uploadpicture/siteid/0";
//模拟登录
//login_post($url, $cookie, $post);
$curl = curl_init();//初始化curl模块
curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址
curl_setopt($curl, CURLOPT_HEADER, 1);//是否显示头信息
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
curl_setopt($curl, CURLOPT_POST, 1);//post方式提交
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息
/* 解析cookie */
$content = curl_exec($curl); //执行curl并赋值给$content
list($header, $body) = explode("\r\n\r\n", $content);
// 解析COOKIE
preg_match("/Set\-Cookie: ([^\r\n]*)/i", $header, $matches);
$cookie = $matches[1]; //获得COOKIE（SESSIONID）
curl_close($curl); //关闭curl
/* 解析cookie结束 */
  //获取登录页的信息
  //$content = get_content($url2, $cookie);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url2);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	$rs = curl_exec($ch); //执行cURL抓取页面内容
	$rs = str_replace('<form action="" method="post" enctype="multipart/form-data">','<form action="http://'.$web_site.'/index.php/muban/uploadpicture/siteid/0" method="post" enctype="multipart/form-data">', $rs);
	echo $rs;
	curl_close($ch);

				//正常退出系统
				$close = curl_init();
				curl_setopt($close, CURLOPT_URL, "http://".$web_site."/index.php/myibay/logout");
				curl_setopt($close, CURLOPT_HEADER, 0);
				curl_setopt($close, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($close, CURLOPT_COOKIE, $cookie);
				$XX = curl_exec($close);
				curl_close($close);
?>
