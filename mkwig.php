<?php
/*
@param $username mysql user
@param $password mysql password
*/

set_time_limit(0);
date_default_timezone_set("Asia/Hong_Kong");
//require 'vendor/autoload.php';

use phpspider\core\requests;
use phpspider\core\selector;
use phpspider\core\db;

$servername = "localhost";
$username = "";
$password = "";
$dbname = "web";
$conn = mysql_connect($servername, $username, $password, $dbname);
mysql_select_db($dbname, $conn);
$sql = "CREATE TABLE "."MKWIG_".date("Ymd")."
(
sellerid varchar(255),
img varchar(255),
ititle varchar(255),
itemid varchar(255)
)";
$delsql = "DROP table "."MKWIG_".date("Ymd");
mysql_query($delsql, $conn);
mysql_query($sql, $conn);
mysql_close($conn);

/* Do NOT delete this comment */
/* 不要删除这段注释 */
$out_sta = "\033[32m";
$out_end = "\033[0m";
$out_sta1 = "\033[31m";
$out_end1 = "\033[0m";
//define('IS_PROXY', 0); //是否启用代理
/* cookie文件 */
$cookie_file = dirname(__FILE__) . "/cookie_" . md5(basename(__FILE__)) . ".txt"; // 设置Cookie文件保存路径及文件名
/* 模拟浏览器 */
$user_agent = "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36";
function vget($url) { // 模拟获取内容函数
//    $proxy = "114.228.138.145:36839";
    $curl = curl_init(); // 启动一个CURL会话
  //  if (IS_PROXY) {
        //以下代码设置代理服务器
        //代理服务器地址
    //    curl_setopt($curl, CURLOPT_PROXY, $proxy);
  //  }
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $GLOBALS ['user_agent']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_HTTPGET, 1); // 发送一个常规的Post请求
//    curl_setopt($curl, CURLOPT_COOKIE, $cookie); // 读取上面所储存的Cookie信息
//    curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS ['cookie_file']); // 读取上面所储存的Cookie信息
    curl_setopt($curl, CURLOPT_TIMEOUT, ); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    curl_setopt($curl, CURLOPT_SSLVERSION, 4);
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno' . curl_error($curl);
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}

function inputdata($item) {
  $servername = "localhost";
  $username = "";
  $password = "";
  $dbname = "web";
  $curlitem = curl_init(); // 启动一个CURL会话
  curl_setopt($curlitem, CURLOPT_URL, $item); // 要访问的地址
  curl_setopt($curlitem, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
  curl_setopt($curlitem, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
  curl_setopt($curlitem, CURLOPT_USERAGENT, $GLOBALS ['user_agent']); // 模拟用户使用的浏览器
  curl_setopt($curlitem, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
  curl_setopt($curlitem, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
  curl_setopt($curlitem, CURLOPT_HTTPGET, 1); // 发送一个常规的Post请求
  //    curl_setopt($curl, CURLOPT_COOKIE, $cookie); // 读取上面所储存的Cookie信息
  //    curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS ['cookie_file']); // 读取上面所储存的Cookie信息
  curl_setopt($curlitem, CURLOPT_TIMEOUT, 120); // 设置超时限制防止死循环
  curl_setopt($curlitem, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
  curl_setopt($curlitem, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
  curl_setopt($curlitem, CURLOPT_SSLVERSION, 4);
  $sx23 = curl_exec($curlitem); // 执行操作
  preg_match("/<span class=\"mbg-nw\">(.*)\<\/span>/iU", $sx23, $sellerid);
  if($sellerid == "")
  {
    return;
  }
  preg_match("/itemprop=\"image\" src=\"(.*)\\\"/iU", $sx23, $img);
  preg_match("/etafsharetitle=\"(.*)\\\"/iU", $sx23, $ititle);
  preg_match("/data-itemid=\"(.*)\\\"/iU", $sx23, $itemid);
  $conn = mysql_connect($servername, $username, $password, $dbname);
  mysql_select_db($dbname, $conn);
  $sql1 = "insert into "."MKWIG_".date("Ymd")."(sellerid,img,ititle,itemid) values('".$sellerid[1]."','".$img[1]."','".$ititle[1]."','".$itemid[1]."')";
  mysql_query($sql1, $conn);
  mysql_close($conn);

  return $item."\r\n";
}
for($i=0; $i<=10; $i++)
{
$sch = "";
  if( $i == 0 )
  {
 echo  $anay = vget("https://www.ebay.com/sch/i.html?_sacat=0&_nkw=human+hair+wig&rt=nc&_ipg=200");
  }else{
    $skc = $i * 200;
    $png = $i + 1;
 echo  $anay = vget("https://www.ebay.com/sch/i.html?_sacat=0&_nkw=human+hair+wig&_pgn=".$png."&_skc=".$skc."&rt=nc");
  }
 preg_match_all("/<a class=\"s-item__link\" href=\"(.*)\\\"/iU", $anay, $sch[$i] );
  if($sch[$i][1][0] == "")
  {
    $sch = "";
    preg_match_all("/<a href=\"(.*)\\\"/iU", $anay, $sch[$i] );
  }
  for($xx=0; $xx < count($sch[$i][1]); $xx++)
  {
    inputdata($sch[$i][1][$xx]);
  }
}
die();

?>
