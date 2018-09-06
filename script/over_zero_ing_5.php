<?php
date_default_timezone_set('PRC');
include('../src/conn_mysql.php');
ignore_user_abort(true);
set_time_limit(0); // 取消脚本运行时间的超时上限

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

while(1){

	$ing_bool = "OFF";

	if($i){
		$sql_bool="update settings set over_zero_process='OFF'" ;
		try {
				$db_web->query($sql_bool);
			} catch (Exception $e) {
				echo $e->getMessage();
		}
		unset($i);
	}

	while( $ing_bool == "OFF" ){

		sleep(10);
		echo "be waiting\n";
		$query = "SELECT * FROM `settings`";//需要执行的sql语句
		$res = $db_web->prepare($query); //准备查询语句
		$res->execute();            //执行查询语句，并返回结果集
		while($result=$res->fetch(PDO::FETCH_ASSOC)){
			$ing_bool = $result["over_zero_process"];
		}

	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://".$web_site."/index.php/ebaymanage/ajaxanyrevisesuper");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);//post方式提交
	echo $cookie = login_ibay($web_username,$web_password,$web_site);

	if($cookie){
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);

		$stmt = $db_web->query('select * from over_zero'); //返回一个PDOStatement对象
		//$row = $stmt->fetch(); //从结果集中获取下一行，用于while循环
		$rows = $stmt->fetchAll(); //获取所有
		$row_count = $stmt->rowCount(); //记录数，2

	 for( $i = 5; $i < $row_count; $i = $i + 6 ){

			if($rows[$i]["status"] == "Success"){
				continue;
			}

  	$post1 = NULL;
  	$post1 = array (
    	"itemid" => $rows[$i]["itemid"],
    	"sku" => $rows[$i]["sku"],
    	"quantity" => $rows[$i]["quantity"],
    	"startprice" => $rows[$i]["startprice"]
  	);
  	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post1));
  	$page = curl_exec($ch);

		if(!$page){
			$sql42="update over_zero set status='ERROR' where "."sku='".$rows[$i]["sku"]."'"." and itemid='".$rows[$i]["itemid"]."'" ;
			try {
					$db_web->query($sql42);
					echo "ERROR\n";
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}else if(strpos($page,"Failure")){
				$sql42="update over_zero set status='Failure' where "."sku='".$rows[$i]["sku"]."'"." and itemid='".$rows[$i]["itemid"]."'" ;
				try {
					$db_web->query($sql42);
					echo "Failure\n";
				} catch (Exception $e) {
					echo $e->getMessage();
				}
  	}else if(strpos($page,"Success") || strpos($page,"Warning")){
			$sql42="update over_zero set status='Success' where "."sku='".$rows[$i]["sku"]."'"." and itemid='".$rows[$i]["itemid"]."'" ;
			try {
				$db_web->query($sql42);
				echo "Success\n";
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}else{
			$sql42="update over_zero set status='unknown' where "."sku='".$rows[$i]["sku"]."'"." and itemid='".$rows[$i]["itemid"]."'" ;
			try {
					$db_web->query($sql42);
					echo "unknown\n";
				} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

	}

}

	//正常退出系统
	curl_setopt($ch, CURLOPT_URL, "http://".$web_site."/index.php/myibay/logout");
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_exec($ch);
	curl_close($ch);

}
?>
