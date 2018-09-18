<?php
//设置post的数据
include('src/conn_mysql.php');
set_time_limit(0);
$post = array (
	'username' => $_COOKIE["username"],
	'password' => $_COOKIE["password"],
	'submit' => '登录'
);
//登录地址
$url = "http://".$web_site."/index.php/myibay/login";
//login_post($url, $cookie, $post);
$curl = curl_init();//初始化curl模块
curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址
curl_setopt($curl, CURLOPT_HEADER, 1);//是否显示头信息
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
//curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中 //2018-4-1 摆脱文件cookies
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

for($i=0;$i<count($_POST["pic"]);$i++)
{
	$curl_file1 = curl_file_create($_POST["pic"][$i], 'image/png', pathinfo($_POST["pic"][0],PATHINFO_BASENAME));
	$url = "http://".$web_site."/index.php/muban/uploadpicture/siteid/0";
	$post_data = array(
	"img" => "http://",
	"size" => "Supersize",
	"selleruserid" => $_POST["selleruserid"],
	"siteid" => "0",
	"inputid" => "",
	"submit" => "上传",
	//要上传的本地文件地址
	"pic[]" => $curl_file1
	);
	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , $url);
	curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch , CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch , CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
	$output = str_replace("/index.php/muban/uploadpicture","javascript:history.back();",$output);
	echo $output;
;
	//上传完毕
}
//正常退出系统
$close = curl_init();
curl_setopt($close, CURLOPT_URL, "http://".$web_site."/index.php/myibay/logout");
curl_setopt($close, CURLOPT_HEADER, 0);
curl_setopt($close, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($close, CURLOPT_COOKIE, $cookie);
$XX = curl_exec($close);
curl_close($close);
?>
