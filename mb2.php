<?php
include('src/conn_mysql.php');
set_time_limit(0);
require_once "../vendor/paragonie/random_compat/lib/random.php";
date_default_timezone_set("Asia/Hong_Kong");

function str_replace_once($needle, $replace, $haystack) {
    // Looks for the first occurence of $needle in $haystack
    // and replaces it with $replace.
    $pos = strpos($haystack, $needle);
    if ($pos === false) {
        // Nothing found
        return $haystack;
    }
    return substr_replace($haystack, $replace, $pos, strlen($needle));
}

function jsformat($str) {
	$str = trim($str);
	$str = str_replace('\\s\\s', '\\s', $str);
	$str = str_replace(chr(10), '', $str);
	$str = str_replace(chr(13), '', $str);
	//$str = str_replace(' ', '', $str);
	$str = str_replace('\\', '\\\\', $str);
	$str = str_replace('"', '\\"', $str);
	$str = str_replace('\\\'', '\\\\\'', $str);
	$str = str_replace("'", "\'", $str);
	return $str;
}

if($_POST["submit"]=="OPEN")
{
//设置post的数据

$itts = explode(PHP_EOL, $_POST["inputtitle"]);
$itts = str_replace(array("\r\n", "\r", "\n"), '', $itts);

for($i = 0 ; $i <= count($itts); $i++){
	if( strlen($itts[$i]) < 40 ){
		unset($itts[$i]);
	}
}

$itts = str_replace("Uk", "UK", $itts);
$itts = str_replace("Us", "US", $itts);
$itts = str_replace("Usa", "USA", $itts);
$itts = str_replace("USa", "USA", $itts);
$itts = str_replace("0Cm", "0cm", $itts);
$itts = str_replace("5Cm", "5cm", $itts);

$mpts = $_POST["imgurl"];
if(count($mpts) != count($itts))
{
	echo "数量不一致！";
	exit;
}

$post = array (
	'username' => $_COOKIE["username"],
	'password' => $_COOKIE["password"],
	'submit' => '登录'
);

//模拟登录
//login_post($url, $cookie, $post);
$curl = curl_init();//初始化curl模块
curl_setopt($curl, CURLOPT_URL, "http://".$web_site."/index.php/myibay/login");//登录提交的地址
curl_setopt($curl, CURLOPT_HEADER, 1);//是否显示头信息
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
curl_setopt($curl, CURLOPT_POST, 1);//post方式提交
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息
/* 解析cookie */
$content = curl_exec($curl); //执行curl并赋值给$content
list($header, $body) = explode("\r\n\r\n", $content);
// 解析COOKIE
preg_match("/Set\-Cookie: ([^\r\n]*)/i", $header, $matches);
$cookie = $matches[1]; //获得COOKIE（SESSIONID）
curl_close($curl); //关闭curl
/* 解析cookie结束 */

  //获取登录页的信息
  //$content = get_content($url2, $cookie);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://".$web_site."/index.php/muban/editmuban/muban_id/".$_POST['mubanid']);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_COOKIE, $cookie);
  $rs = curl_exec($ch); //执行cURL抓取页面内容
  curl_close($ch);
  //输出内容

	$rs = str_replace("<html>","", $rs);
  $rs = str_replace("</html>","", $rs);
  $rs = str_replace("/index.php","http://".$web_site."/index.php", $rs);
  $rs = str_replace("/link","http://".$web_site."/link", $rs);
  $rs = str_replace("alert('服务器无响应！');","", $rs);
  $rs = str_replace("<div style=\"float:left\">","<input id=\"paypal\" name=\"paypal\" value=\"", $rs);
	$rs = str_replace("&nbsp;&nbsp;&nbsp;</div>","\"", $rs);
	$rs = str_replace("function initPaypalSelect(e){","function xasdw(e){", $rs);
	$rs = str_replace('<form action="" method="post" name="m" id=\'m\' target="_self">',"<form action=\"http://".$web_site."/index.php/muban/editmuban/muban_id/\" method=\"post\" name=\"m\" id=\"m\" target=\"_self\">", $rs);
	$rs = str_replace('if(!confirm("该',"if(aktion==\"该", $rs);
	$rs = str_replace('value="另存为新模板"','value="另存为新模板" id="lingcunwei" name="lingcunwei" ', $rs);
	$rs = str_replace('存吗?"))','存吗?")', $rs);
	$rs = str_replace('吗?\'))','吗?\')', $rs);
	$vrs = $rs;
	echo '
	<table>
	<tbody>
<tr>
<td>
<input id="submit" name="submit" value="INPUT" onClick="javascript:inputMuban('.'\'INPUT\''.')" type="submit" style="width:100px;height:30px;">
</td>
</tr>
</tr>
<script language="javascript">
	function inputMuban(action){
		if(action==\'INPUT\')
		{
			var mubancount = document.getElementById(\'mubancount\').value;
			var f = 1;
				for (var i = 0; i < mubancount; i++) {
				if(f == 1)
				{
					window.frames[ "mubaninput" + i ].document.getElementById(\'listingduration\').value = \'Days_5\';
				}
				if(f == 2)
				{
					window.frames[ "mubaninput" + i ].document.getElementById(\'listingduration\').value = \'Days_7\';
				}
				if(f == 3)
				{
					window.frames[ "mubaninput" + i ].document.getElementById(\'listingduration\').value = \'Days_10\';
				}
				if(f == 4)
				{
				window.frames[ "mubaninput" + i ].document.getElementById(\'listingduration\').value = \'Days_30\';
				f = 0
				}
				f++;
				window.frames[ "mubaninput" + i ].document.getElementById(\'lingcunwei\').onclick();
				}
		}
	}
	</script>';
	function random_6 ($random_len){
		for($i=1; $i<= $random_len ;$i++){
			if(random_int(0,100)%2 == 0){
				$rc .= chr(random_int(65,90));
			}
			else{
				$rc .= random_int(0,9);
			}
		}
		return $rc;
	}

			for( $ui = 0 ; $ui <= count($itts) ; $ui++ )
		{
			if( strlen($mpts[$ui]) < 5 )
			{
				break;
			}
			$vrs = $rs; //重新载入页面

			/* 随机改价格 */
			$i = 1;
			for($i1 = 0; $i > 0; $i1 = $i + 1)
			{
				$i = strpos($vrs,"\"StartPrice\":\"", $i1 );
				$j = strpos($vrs, '.' , $i);
				$k = strpos($vrs, '"' , $j);
				$l = $k - $i;
				if($i == false)
				{
					break;
				}
				$r = substr($vrs, $i + 14 , $l - 14);
				$rr = "0.0".random_int(8,9);
				$rf = $r - $rr;
				$vrs = substr_replace($vrs, $rf,$i + 14 , $l - 14);
			}
			/* 随机改价格 */

			//$itts[$ui] = str_replace("\"","&quot;", $itts[$ui]);
			$itts[$ui] = htmlspecialchars($itts[$ui]);
			$vrs = str_replace("zcyinputtitle",$itts[$ui], $vrs);
			$vrs = str_replace('zcymainphoto',$mpts[$ui], $vrs);
			$vrs = str_replace('zcyinputtime',$showtime=date("Ymd")."-".$ui, $vrs);

			for($i_chr = 65; $i_chr < 91; $i_chr++){
					$vrs = str_replace('http://'.strtolower(chr($i_chr)) , 'https://'.strtolower(chr($i_chr)) , $vrs);
					$vrs = str_replace('http://'.strtoupper(chr($i_chr)) , 'https://'.strtoupper(chr($i_chr)) , $vrs);
					$vrs = str_replace('http:\/\/'.strtolower(chr($i_chr)) , 'https:\/\/'.strtolower(chr($i_chr)) , $vrs);
					$vrs = str_replace('http:\/\/'.strtoupper(chr($i_chr)) , 'https:\/\/'.strtoupper(chr($i_chr)) , $vrs);
			}

			if(strpos($vrs,'value="Human Hair"') == true)
			{
				if(strpos($itts[$ui],'Malaysian') == true){
					$vrs = str_replace('value="Malaysian Hair" class="is_specific"','checked value="Malaysian Hair" class="is_specific"', $vrs);
				}else if(strpos($itts[$ui],'Brazilian') == true){
					$vrs = str_replace('value="Brazilian Hair" class="is_specific"','checked value="Brazilian Hair" class="is_specific"', $vrs);
				}else if(strpos($itts[$ui],'Indian') == true){
					$vrs = str_replace('value="Indian Hair" class="is_specific"','checked value="Indian Hair" class="is_specific"', $vrs);
				}else{
					if(random_int(0,100)%2 == 0){
						$vrs = str_replace('value="Russian Hair" class="is_specific"','checked value="Russian Hair" class="is_specific"', $vrs);
					}
					if(random_int(0,100)%2 == 0){
						$vrs = str_replace('value="Malaysian Hair" class="is_specific"','checked value="Malaysian Hair" class="is_specific"', $vrs);
					}
					if(random_int(0,100)%2 == 0){
						$vrs = str_replace('value="Brazilian Hair" class="is_specific"','checked value="Brazilian Hair" class="is_specific"', $vrs);
					}
					if(random_int(0,100)%2 == 0){
						$vrs = str_replace('value="Indian Hair" class="is_specific"','checked value="Indian Hair" class="is_specific"', $vrs);
					}
				}
			}
			$vrs = str_replace('zcyrandom1',random_6(4), $vrs);
			$vrs = str_replace('zcyrandom2',random_6(4), $vrs);
			$vrs = str_replace('zcyrandom3',random_6(4), $vrs);
			$vrs = str_replace('zcyskurandom',random_6(4), $vrs);
			if(random_int(0,100)%2 == 0){
				$vrs = str_replace('zcy_capsize','Average', $vrs);
			}else if(random_int(0,100)%2 == 0){
				$vrs = str_replace('zcy_capsize','One Size', $vrs);
			}else if(random_int(0,100)%2 == 0){
				$vrs = str_replace('zcy_capsize','Medium', $vrs);
			}else{
				$vrs = str_replace('zcy_capsize','Adjustable', $vrs);
			}

		$varations_img_sql_table_name = date("Y_m_d",strtotime("0 day"))."_random_".$_POST["ebaysellerid"];

		try {
			$rows = $db_varations_image->query('select * from '.$varations_img_sql_table_name)->fetchAll();
			$row_count = $db_varations_image->query('select * from '.$varations_img_sql_table_name)->rowCount();
		} catch (Exception $e) {
			echo '<script type="text/javascript">
			alert("'.jsformat($e).'");
			</script>';
			unset($rows);
		}

		if($rows){
			$count = $ui + 1;
				for( $i = 0; $i < $row_count; $i++ ){
					if($rows[$i]['muban_count'] == $count){
						$vrs = str_replace('zcy_'.$rows[$i]['sku'], $rows[$i]['random_id'], $vrs);
						$vrs = str_replace_once('zcy_imgs_'.$rows[$i]['sku'], $rows[$i]['url'], $vrs);
					}
				}
			}

			if(random_int(0,100)%2 == 0){
				$vrs = str_replace("<option value=\"China\" >","'value=\"China\" selected>'", $vrs);
			}

			$html = fopen($ui.".html", "w") or die("Unable to open file!");
			fwrite($html, $vrs);
			fclose($html);
			echo '
			<iframe id="mubaninput'.$ui.'" name="mubaninput'.$ui.'" style="width:455px;height:250px;" src="'.$ui.'.html">
			</iframe>
			';
		}

		echo '
		<td>
		<input id="mubancount" type="text" name="mubancount" hidden="hidden" readonly="readonly" value="'.$ui.'" style="width:50px;height:30px;">
		</td>
		</table>
				</tbody>';
				//正常退出系统
				$close = curl_init();
				curl_setopt($close, CURLOPT_URL, "http://".$web_site."/index.php/myibay/logout");
				curl_setopt($close, CURLOPT_HEADER, 0);
				curl_setopt($close, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($close, CURLOPT_COOKIE, $cookie);
				$XX = curl_exec($close);
				curl_close($close);

}else if($_POST["submit"] == "CHECK")
{
	$post = array (
		'username' => $_COOKIE["username"],
		'password' => $_COOKIE["password"],
		'submit' => '登录'
	);
	//登录地址
	$url = "http://".$web_site."/index.php/myibay/login";
	//设置cookie保存路径
	//$cookie = dirname(__FILE__) . '/cookie_ibay.txt'; //2018-4-1 摆脱文件cookies
	//登录后要获取信息的地址
	$url2 = "http://".$web_site."/index.php?controller=toebay&action=items&tab=0";
	//模拟登录
	//login_post($url, $cookie, $post);
	$curl = curl_init();//初始化curl模块
	curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址
	curl_setopt($curl, CURLOPT_HEADER, 1);//是否显示头信息
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
	//curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中 //2018-4-1 摆脱文件cookies
	curl_setopt($curl, CURLOPT_POST, 1);//post方式提交
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息

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
		//	$ts = spliti('#########',$_POST["posttitle"]);
		$ts = explode(PHP_EOL, $_POST["inputtitle"]);
		for( $i = 0 ; $i< count($ts) ; $i++ )
	{
		if( strlen($ts[$i]) < 40 )
		{

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
	//}
	//正常退出系统
	$close = curl_init();
	curl_setopt($close, CURLOPT_URL, "http://".$web_site."/index.php/myibay/logout");
	curl_setopt($close, CURLOPT_HEADER, 0);
	curl_setopt($close, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($close, CURLOPT_COOKIE, $cookie);
	$XX = curl_exec($close);
	curl_close($close);
}else if($_POST["submit"] == "Edit Muban"){
	echo "<html><head><title>稍候。。。</title></head>
	<body>
	<script language='javascript'>document.location = 'http://".$web_site."/index.php?controller=muban&action=lister&tab=0&id=".$_POST['mubanid']."'</script>
	</body>
	</html>";
}
?>
