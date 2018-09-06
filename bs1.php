<?php

$curlitem = curl_init(); // 启动一个CURL会话
curl_setopt($curlitem, CURLOPT_URL, "http://www.ebay.com/itm/302668343053"); // 要访问的地址
curl_setopt($curlitem, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
curl_setopt($curlitem, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
//curl_setopt($curlitem, CURLOPT_USERAGENT, $GLOBALS ['user_agent']); // 模拟用户使用的浏览器
curl_setopt($curlitem, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
curl_setopt($curlitem, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
curl_setopt($curlitem, CURLOPT_HTTPGET, 1); // 发送一个常规的Post请求
//    curl_setopt($curl, CURLOPT_COOKIE, $cookie); // 读取上面所储存的Cookie信息
//    curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS ['cookie_file']); // 读取上面所储存的Cookie信息
curl_setopt($curlitem, CURLOPT_TIMEOUT, 120); // 设置超时限制防止死循环
curl_setopt($curlitem, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
curl_setopt($curlitem, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
//curl_setopt($curlitem, CURLOPT_SSLVERSION, 4);
$sx23 = curl_exec($curlitem); // 执行操作
preg_match("/<span class=\"mbg-nw\">(.*)\<\/span>/iU", $sx23, $sellerid);
preg_match("/itemprop=\"image\" src=\"(.*)\\\"/iU", $sx23, $img);
preg_match("/etafsharetitle=\"(.*)\\\"/iU", $sx23, $ititle);
preg_match("/data-itemid=\"(.*)\\\"/iU", $sx23, $itemid);
print_r($sellerid);
print_r($img);
print_r($ititle);
print_r($itemid);
?>
