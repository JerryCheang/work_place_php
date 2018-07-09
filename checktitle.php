<?php
/*
@param $mainpasswd private password
@param $secondpasswd other password
@param $work_website working website
*/

//设置post的数据
set_time_limit(0);
$post = array (
	'username' => $_COOKIE["username"],
	'password' => $_COOKIE["password"],
	'submit' => '登录'
);
//登录地址
$url = $work_website."/index.php/myibay/login";
//设置cookie保存路径
//$cookie = dirname(__FILE__) . '/cookie_ibay.txt'; //2018-4-1 摆脱文件cookies
//登录后要获取信息的地址
$url2 = $work_website."/index.php?controller=toebay&action=items&tab=0";
//模拟登录
//login_post($url, $cookie, $post);
$curl = curl_init();//初始化curl模块
curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址
curl_setopt($curl, CURLOPT_HEADER, 1);//是否显示头信息
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
//curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中 //2018-4-1 摆脱文件cookies
curl_setopt($curl, CURLOPT_POST, 1);//post方式提交
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息

/*//2018-4-1 摆脱文件cookies
if(curl_exec($curl)){
echo '账号或密码错误
<table>
<tbody>
<tr>
<td>
<label>账号：</label>
</td>
<td>
<input name="username1" id="username1" type="text">
</td>
</tr>
<tr>
<td>
<label>密码：</label>
</td>
<td>
<input name="password1" id="password1" type="text">
</td>
<tr>
<input id="submit" name="Login" value="Login" type="submit" onClick="javascript:login('.'\'pwdcookie\''.')" style="width:100px;height:30px;">
</tr>
</tr>
</table>
</tbody>
<script language="javascript">
function login(action)
 {
   if(action=='.'\'pwdcookie\''.')
   {
     var user = document.getElementById("username1").value;
     var pwd = document.getElementById("password1").value;
     var expireDate = new Date();
     expireDate.setDate(expireDate.getDate()+30);;
    document.cookie = escape(\'username\') + \'=\' + user +\';expires=\' + expireDate.toGMTString();
    document.cookie = escape(\'password\') + \'=\' + pwd +\';expires=\' + expireDate.toGMTString();
   }
 }
</script>';
//执行cURL
curl_close($curl);//关闭cURL资源，并且释放系统资源
}else{

  /* 解析cookie */
	$content = curl_exec($curl); //执行curl并赋值给$content
	list($header, $body) = explode("\r\n\r\n", $content);
	// 解析COOKIE
	preg_match("/Set\-Cookie: ([^\r\n]*)/i", $header, $matches);
	$cookie = $matches[1]; //获得COOKIE（SESSIONID）
	curl_close($curl); //关闭curl
  /* 解析cookie结束 */

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url2);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); //读取cookie //2018-4-1 摆脱文件cookies
  curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_POST, 1);//post方式提交
	$ts = spliti('#########',$_POST["posttitle"]);

	for( $i = 0 ; $i< count($ts) ; $i++ )
{
	if( strlen($ts[$i]) < 40 )
	{
		$i++;
		continue;
	}
	$post1 = array (
		'posttitle' => $ts[$i],
		'posttitle_like' => "1",
		'submit' => '开始搜索'
	);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post1));//要提交的信息
  $rs = curl_exec($ch); //执行cURL抓取页面内容
  //输出内容
		$i2 = strpos($rs,"Total", $i1 );
		$j = strpos($rs, '<' , $i2);
		$l = $j - $i2;
		$r = substr($rs, $i2 , $l);
		if($r == "Total: 0")
		{
			echo "<font size=\"3px\">".$ts[$i]."----------".$r."</font><br/>";
		}else{
			echo "<font size=\"4px\" color=\"red\">".$ts[$i]."----------".$r."</font><br/>";
		}
}
	curl_close($ch);
	//删除cookie文件 //2018-4-1 摆脱文件cookies
//	@ unlink($cookie);
//}
//正常退出系统
$close = curl_init();
curl_setopt($close, CURLOPT_URL, $work_website."/index.php/myibay/logout");
curl_setopt($close, CURLOPT_HEADER, 0);
curl_setopt($close, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($close, CURLOPT_COOKIE, $cookie);
$XX = curl_exec($close);
curl_close($close);
?>
