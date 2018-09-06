<?php
set_time_limit(0);
for( $i=0; $i < 10; $i++)
{
$UserAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36";
$ch = curl_init("https://www.dhgate.com/w/human+hair+wig/".$i.".html");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_USERAGENT, $UserAgent);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面获取的cookies
$response = curl_exec($ch);
curl_close($ch);
preg_match_all("/itemcode=\"(.*)\"/iU", $response, $matches);

for( $xm=0; $xm < count($matches[1]); $xm++)
{
echo $matches[1][$xm]."<br/>";
}
}
?>
