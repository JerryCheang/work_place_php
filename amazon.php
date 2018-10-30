<?php
set_time_limit(0);
date_default_timezone_set("UTC");
$curl = curl_init();//初始化curl模块
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
//curl_setopt($curl, CURLOPT_USERAGENT, $GLOBALS ['user_agent']); // 模拟用户使用的浏览器
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
curl_setopt($curl, CURLOPT_HTTPGET, 1); // 发送一个常规的Post请求
//    curl_setopt($curl, CURLOPT_COOKIE, $cookie); // 读取上面所储存的Cookie信息
//    curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS ['cookie_file']); // 读取上面所储存的Cookie信息
curl_setopt($curl, CURLOPT_TIMEOUT, 120); // 设置超时限制防止死循环
curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
curl_setopt($curl, CURLOPT_SSLVERSION, 4);

$i_page = 0;
while(1){

  $i_page ++ ;
  $matches = null;
  $aliexpress_search_url = "https://www.aliexpress.com/wholesale?catId=0&initiative_id=&SearchText=".$key."human+hair+wig&page=".$i_page;
  curl_setopt($curl, CURLOPT_URL, $aliexpress_search_url); // 要访问的地址
	echo $i_page."</br>";
  echo $rs = curl_exec($curl);
  preg_match_all("/aliexpress.com\/item\/(.*).html/iU", $rs, $matches);

  if($i_page == 41){
    break;
  }

  for($i=0;$i<count($matches[0]);$i++){
    if($matches[0][$i-1]==$matches[0][$i]){
      continue;
    }
    echo $matches[0][$i]."</br>";
  }

}



?>
