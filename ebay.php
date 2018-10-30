<?php
set_time_limit(0);
//登录后要获取信息的地址
$url2 = "https://www.ebay.co.uk/sch/i.html?_from=R40&_nkw=human+hair+wig&_sacat=0&_dmd=2&_ipg=192&_pgn=1&_fcid=3";
$curl = curl_init();//初始化curl模块
curl_setopt($curl, CURLOPT_URL, $url2);//登录提交的地址
curl_setopt($curl, CURLOPT_HEADER, 1);//是否显示头信息
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
/* 解析cookie */
echo $content = curl_exec($curl); //执行curl并赋值给$content
list($header, $body) = explode("\r\n\r\n", $content);
// 解析COOKIE
preg_match_all("/Set\-Cookie: ([^\r\n]*)/i", $header, $cookie);
for( $i=0; $i < count($cookie[1]); $i++)
{
  $sc = str_replace("Path=/;","",$cookie[1][$i]);
  $sc = str_replace("HttpOnly","",$sc);
  $sc = str_replace("Path=/","",$sc);
  $sc = str_replace("  ","",$sc);
  $sc1 = $sc1.$sc;
}
$ssx = $sc1."Path=/;HttpOnly";
curl_close($curl); //关闭curl
$bi = 1;
//for($bi = 1; $bi < 40; $bi++)
//{
//登录地址
$url = "https://www.ebay.co.uk/sch/i.html?_from=R40&_nkw=human+hair+wig&_sacat=0&_dmd=2&_ipg=192&_pgn=1&_fcid=3";
//模拟登录
//login_post($url, $cookie, $post);
$curl = curl_init();//初始化curl模块
curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址
curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
curl_setopt($curl, CURLOPT_COOKIE, $ssx);
//curl_setopt($curl, CURLOPT_COOKIE, "nonsession=CgADLAAFa6+CDMgDKACBkUdr7Mjk0OTYxOTcxNjMwYWIxMzZhMDY3ODE3ZmZmNDU5Nzg9g3Ca");
//curl_setopt($curl, CURLOPT_COOKIE, "nonsession=BAQAAAWKns8EdAAaAAAgAHFr1nukxNTIzMzg0ODk4eDE0MjcxMjMxMzkxN3gweDJZADMABFyvRWksVVNBAMsAAlrOGPExNQDKACBkNBNpMGI1NGIzZjQxNjIwYTljYjA3NTdhYjYyZmZmNThmMTSoIJ/AO5OpnE/fwMmTVLnn6cgbsw**");
echo $rs = curl_exec($curl);
//$rs = str_replace("s-l225.jpg","s-l1600.jpg", $rs);
preg_match_all("/<a href=\"(.*)\/?hash\=item/iU", $rs, $matches[$bi]);
//if($matches[$bi][0] == $matches[$bi - 1][0])
//{
//  curl_close($curl); //关闭curl
//  break;
//}
//if(count($matches[$bi][0]) == 0)
//{
//  break;
//}
//for( $i=0; $i < count($matches[$bi][1]); $i++)
//{
  //$xx = curl_init();
  //curl_setopt($xx, CURLOPT_URL, $matches[$bi][1][$i]);//登录提交的地址
  //curl_setopt($xx, CURLOPT_HEADER, 0);//是否显示头信息
  //curl_setopt($xx, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
  //$xxxx = file_get_contents($matches[$bi][1][$i]);
  //preg_match("/class=\"mbg\-nw\">(.*)</iU", $xxxx, $name);
  //preg_match("/iti\-act\-num\">(.*)</iU", $xxxx, $item);
  //echo $name[1]."<a href=\"http://www.ebay.co.uk/itm/".$item[1]."\">".$item[1]."</a>"."<br/>";
  //echo $i."<br/>";
  //print_r($matches[$bi][1]);
//  curl_close($xx);
//}
curl_close($curl); //关闭curl
//}
  //输出内容
?>
