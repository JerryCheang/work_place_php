<?php
//设置post的数据
set_time_limit(0);
date_default_timezone_set('PRC');
include('../src/conn_mysql.php');

$post = array (
	'username' => $web_username,
	'password' => $web_password,
	'submit' => '登录'
);

if(date("H")>=20)
{
	$XXA = 1;
	$XXB = 0;
}else{
	$XXA = 0;
	$XXB = -1;
}

function login_ibay($web_username,$web_password,$web_site){
	$post = array (
		'username' => $web_username,
		'password' => $web_password,
		'submit' => '登录'
	);
	//登录地址
	$url = "http://".$web_site."/index.php/myibay/login";
	//登录后要获取信息的地址
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
	curl_close($curl); //关闭curl
	return $cookie = $matches[1]; //获得COOKIE（SESSIONID）
  	/* 解析cookie结束 */
}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://".$web_site."/index.php?controller=dingzhi&action=transactionsoldv2");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	echo $cookie = login_ibay($web_username,$web_password,$web_site);

if($cookie){

  curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_POST, 1);//post方式提交

	$rows = $db_web->query('select * from sellersold')->fetchAll();
	$rows_count = $db_web->query('select * from sellersold')->rowCount();

	for($i=0; $i < $rows_count; $i++)//转成数组，且返回第一条数据,当不是一个对象时候退出
	{
 	$site[$i] = $rows[$i]['site'];
 	$sku[$i] = $rows[$i]['sku'];
 	$selleruserid[$i] = $rows[$i]['selleruserid'];
	}

try{
	$db_web->query("DROP table "."SOLD_".date("Ymd",strtotime($XXA." day")));
	$db_web->query("CREATE TABLE "."SOLD_".date("Ymd",strtotime($XXA." day"))."
	(
	site varchar(255),
	sku varchar(255),
	selleruserid varchar(255),
	date varchar(255),
	total varchar(255),
	count varchar(255)
	)");
} catch (Exception $e) {
	$db_web->query("CREATE TABLE "."SOLD_".date("Ymd",strtotime($XXA." day"))."
	(
	site varchar(255),
	sku varchar(255),
	selleruserid varchar(255),
	date varchar(255),
	total varchar(255),
	count varchar(255)
	)");
}

for($gh = 0 ; $gh < count($selleruserid); $gh++)
{
	$post1 = array (
		'selleruserid' => $selleruserid[$gh],
		'sku' => $sku[$gh],
		'site[]' => $site[$gh], //美国（0）德国（77）英国（3）
		'sold_starttime' => date("Y-m-d",strtotime($XXB." day"))." 15:00:00",
		'sold_endtime' => date("Y-m-d",strtotime($XXA." day"))." 15:00:00",
		'perpage' => "200",
		'submit' => '搜索'
	);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post1));//要提交的信息
  $page = curl_exec($ch); //执行cURL抓取页面内容
	if($site[$gh] == "3")
	{
		preg_match_all('/GBP<br\/>([^\/]*)/i', $page, $prices);
	}
	if($site[$gh] == "0")
	{
		preg_match_all('/USD<br\/>([^\/]*)/i', $page, $prices);
	}
	if($site[$gh] == "77")
	{
		preg_match_all('/EUR<br\/>([^\/]*)/i', $page, $prices);
	}
	$bigtt = 0;
	$bigcount = 0;
	$i=0;
	for($iv = 0; $prices[1][$iv]!=""; $iv++)
	{
		if($site[$gh] == "3")
		{
			$fws = "GBP<br/>".$prices[1][$iv]."/";
			$bws = "GBP";
		}

		if($site[$gh] == "0")
		{
			$fws = "USD<br/>".$prices[1][$iv]."/";
			$bws = "USD";
		}

		if($site[$gh] == "77")
		{
			$fws = "EUR<br/>".$prices[1][$iv]."/";
			$bws = "EUR";
		}

		if($iv == 0)
		{
 		$i = strpos($page, $fws);
	 }else{
		$i = strpos($page, $fws, $i + 1 + strlen($fws));
  	}
		$j = strpos($page,$bws, $i + strlen($fws));
		$k = $j - $i - strlen($fws);
		$r = substr($page, $i + strlen($fws), $k)."/".$prices[1][$iv];
		$total = $prices[1][$iv] + $r;
		$bigtt = $bigtt + $total;
		$bigcount = $bigcount + trim(substr($page, $i + strlen($fws) + 46, 6));
  	}

		$sql1 = "insert into "."SOLD_".date("Ymd",strtotime($XXA." day"))."(site,sku,selleruserid,date,total,count) values('".$site[$gh]."','".$sku[$gh]."','".$selleruserid[$gh]."','".date("Y-m-d",strtotime($XXA." day"))."','".$bigtt."','".$bigcount."')";
		$db_web->query($sql1);

}

	//正常退出系统
	curl_setopt($ch, CURLOPT_URL, "http://".$web_site."/index.php/myibay/logout");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_exec($ch);
	curl_close($ch);
}
?>
