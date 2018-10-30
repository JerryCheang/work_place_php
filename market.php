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
//curl_setopt($curl, CURLOPT_COOKIE, "nonsession=BAQAAAWKns8EdAAaAAAgAHFr1nukxNTIzMzg0ODk4eDE0MjcxMjMxMzkxN3gweDJZADMABFyvRWksVVNBAMsAAlrOGPExNQDKACBkNBNpMGI1NGIzZjQxNjIwYTljYjA3NTdhYjYyZmZmNThmMTSoIJ/AO5OpnE/fwMmTVLnn6cgbsw**");
function download($url, $path = 'images/'."ss/")
{
  
  $dir = iconv("UTF-8", "GBK", $path);
  if (!file_exists($dir)){
    mkdir ($dir,0777,true);
  }

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
  $file = curl_exec($ch);
  curl_close($ch);
  $filename = pathinfo($url, PATHINFO_BASENAME);
  $resource = fopen($path . $filename, 'a');
  fwrite($resource, $file);
  fclose($resource);
}


$i_page = 1;
while(1){

  $i_page++;
  $matches = null;
  $aliexpress_feedback_list_url = "https://feedback.aliexpress.com/display/productEvaluation.htm?productId=32895066352&ownerMemberId=231782566&companyId=241036360"."&withPictures=true&page=".$i_page;
  curl_setopt($curl, CURLOPT_URL, $aliexpress_feedback_list_url); // 要访问的地址
  $rs = curl_exec($curl);
  preg_match_all("/https:\/\/ae01.alicdn.com\/kf\/(.*).jpg/iU", $rs, $matches);

  if(strpos($rs,"no-feedback")){
    break;
  }

  for($i=0;$i<count($matches[0]);$i++){
    if($matches[0][$i-1]==$matches[0][$i]){
      continue;
    }
    echo $matches[0][$i]."\n";
    download($matches[0][$i]);

  }

}

curl_close($curl);//关闭curl
?>
