<?
date_default_timezone_set("Asia/Hong_Kong");
$proxy = "218.66.146.75:45982";
$curl = curl_init(); // 启动一个CURL会话
define('IS_PROXY', 0);
if (IS_PROXY) {
    //以下代码设置代理服务器
    //代理服务器地址
    curl_setopt($curl, CURLOPT_PROXY, $proxy);
}
$user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
$header[] = "Content-type: application/x-www-form-urlencoded";
curl_setopt($curl, CURLOPT_URL, "https://offer.ebay.com/ws/eBayISAPI.dll?ViewBidsLogin&item=222617608878&rt=nc&_trksid=p2047675.l2564"); // 要访问的地址
curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
curl_setopt($curl, CURLOPT_USERAGENT, $user_agent); // 模拟用户使用的浏览器
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
echo $rs = curl_exec($curl);
if(substr_count($rs , date("M-d-y",strtotime('-1 day'))) == 0)
{
  echo date("M-d-y",strtotime('-1 day'));
  continue;
}else{
  echo $row['item']."<br/>";
}
preg_match_all("/<td align\=\"middle\" valign\=\"top\" class\=\"contentValueFont\">(.*)<\/td>/iU", $rs, $soldcount);
preg_match_all("/<td align\=\"left\" nowrap valign\=\"top\" class\=\"contentValueFont\">(.*)<\/td>/iU", $rs, $soldquantity);
for ($i=0; $i<substr_count($rs , date("M-d-y",strtotime('-1 day'))) ; $i++)
{
  $soldquantity[1][$i] = str_replace('US $',"", $soldquantity[1][$i]);
  $c = $soldcount[1][$i] + $c;
  $q = $soldquantity[1][$i] + $q;
}
echo $c."<br/>";
echo $q."<br/>";
curl_close($curl);//关闭curl
?>
