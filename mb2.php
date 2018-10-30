<?php
include('src/conn_mysql.php');
set_time_limit(0);
require_once "../vendor/paragonie/random_compat/lib/random.php";
date_default_timezone_set("Asia/Hong_Kong");
$zcymainpic_url = "http://rz.qwe310.com/mainpic/";

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
	'username' => $web_username,
	'password' => $web_password,
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
  $rs = str_replace("/index.php/ebaymanage/uploadpicbyvar","/uploadpicbyvar.php", $rs);
  $chage_ajax = "var main_pic = obj_mainpic.val();\r\n
			 if(main_pic.indexOf('ebayimg')>=0){\r\n			 obj_mainpic.next().text('ebay图片地址, 无需上传');\r\n			 return;\r\n			 }";
  $rs = str_replace("var main_pic = obj_mainpic.val();",$chage_ajax, $rs);
  $rs = str_replace("picurl: main_pic","picurl: main_pic, ibay_cookie: '".$cookie.'\'', $rs);
  $rs = str_replace("/index.php","http://".$web_site."/index.php", $rs);
  $rs = str_replace("$('#startprice').change(initPaypalSelect);","", $rs);
  $rs = str_replace("$('#ntr10').change(initPaypalSelect);","", $rs);
  $rs = str_replace("$('#buyitnowprice').change(initPaypalSelect);","", $rs);
  $rs = str_replace("$('#listingtype').change(initPaypalSelect);","", $rs);
  $rs = str_replace("initPaypalSelect('1');","", $rs);
  $rs = str_replace("initPaypalSelect();","", $rs);
  //$rs = str_replace("/link","http://".$web_site."/link", $rs);
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
<input id="submit" name="submit" value="upload mainpic" onClick="javascript:inputMuban('.'\'upload_mainpic\''.')" type="submit" style="width:100px;height:30px;">
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

    if(action==\'upload_mainpic\')
    {
        var mubancount = document.getElementById(\'mubancount\').value;
        for (var i = 0; i < mubancount; i++) {
        window.frames[ "mubaninput" + i ].uploadpic();
        }
    }
	}
	</script>';
  function check_mainpic_url($url){

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HEADER, 1); //获取Header
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //数据存到成字符串吧，别给我直接输出到屏幕了
    curl_setopt($curl, CURLOPT_URL, $url); //设置URL
    $data = curl_exec($curl);
    curl_close($curl);

    $u = 1;
    while(1){
      if(!strstr($data,$u.".jpg")){
        $u = $u - 1;
        if($u == 1){
          return 1;
        }else{
          return $u;
        }
      }
      $u ++;
    }

  }

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

  $luckywords = chr(random_int(65,90)).chr(random_int(65,90));
	for( $ui = 0 ; $ui <= count($itts) ; $ui++ ){
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
			$vrs = str_replace('zcyinputtime',$luckywords.date("md")."-".$ui, $vrs);

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
				}else if(strpos($itts[$ui],'Peruvian') == true){
					$vrs = str_replace('value="" name="specificsvalue[Features][]"','value="Peruvian Hair" name="specificsvalue[Features][]"', $vrs);
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

      $vrs = str_replace("zcymainpic_synthetic/FTS/A/", $zcymainpic_url."synthetic/FTS/A/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/FTS/A/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/FTS/B/",$zcymainpic_url."synthetic/FTS/B/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/FTS/B/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/FTS/C/",$zcymainpic_url."synthetic/FTS/C/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/FTS/C/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/FTS/",$zcymainpic_url."synthetic/FTS/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/FTS/")).".jpg", $vrs);

      $vrs = str_replace("zcymainpic_synthetic/ZD/A/", $zcymainpic_url."synthetic/ZD/A/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/ZD/A/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/ZD/B/",$zcymainpic_url."synthetic/ZD/B/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/ZD/B/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/ZD/C/",$zcymainpic_url."synthetic/ZD/C/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/ZD/C/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/ZD/",$zcymainpic_url."synthetic/ZD/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/ZD/")).".jpg", $vrs);

      $vrs = str_replace("zcymainpic_synthetic/HF/A/", $zcymainpic_url."synthetic/HF/A/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/HF/A/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/HF/B/",$zcymainpic_url."synthetic/HF/B/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/HF/B/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/HF/C/",$zcymainpic_url."synthetic/HF/C/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/HF/C/")).".jpg", $vrs);

      $vrs = str_replace("zcymainpic_synthetic/BOB/A/", $zcymainpic_url."synthetic/BOB/A/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/BOB/A/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/BOB/B/",$zcymainpic_url."synthetic/BOB/B/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/BOB/B/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/BOB/C/",$zcymainpic_url."synthetic/BOB/C/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/BOB/C/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/BOB/D/",$zcymainpic_url."synthetic/BOB/D/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/BOB/D/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/BOB/",$zcymainpic_url."synthetic/BOB/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/BOB/")).".jpg", $vrs);

      $vrs = str_replace("zcymainpic_synthetic/SHAGGY/A/", $zcymainpic_url."synthetic/SHAGGY/A/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/SHAGGY/A/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/SHAGGY/B/",$zcymainpic_url."synthetic/SHAGGY/B/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/SHAGGY/B/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/SHAGGY/C/",$zcymainpic_url."synthetic/SHAGGY/C/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/SHAGGY/C/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/SHAGGY/D/",$zcymainpic_url."synthetic/SHAGGY/D/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/SHAGGY/D/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/SHAGGY/",$zcymainpic_url."synthetic/SHAGGY/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/SHAGGY/")).".jpg", $vrs);

      $vrs = str_replace("zcymainpic_synthetic/cosplay_long_model/",$zcymainpic_url."synthetic/cosplay_long_model/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/cosplay_long_model/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_synthetic/details/",$zcymainpic_url."synthetic/details/".random_int(1,check_mainpic_url($zcymainpic_url."synthetic/details/")).".jpg", $vrs);

      $vrs = str_replace("zcymainpic_classic_cap/",$zcymainpic_url."classic_cap/".random_int(1,check_mainpic_url($zcymainpic_url."classic_cap/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_sanpian_net/",$zcymainpic_url."sanpian_net/".random_int(1,check_mainpic_url($zcymainpic_url."sanpian_net/")).".jpg", $vrs);

      $vrs = str_replace("zcymainpic_human_hair/360_details/",$zcymainpic_url."human_hair/360_details/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/360_details/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_human_hair/360_lace/",$zcymainpic_url."human_hair/360_lace/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/360_lace/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_human_hair/full_lace/",$zcymainpic_url."human_hair/full_lace/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/full_lace/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_human_hair/fulllace_details/",$zcymainpic_url."human_hair/fulllace_details/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/fulllace_details/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_human_hair/human_hair_details/curly_buyer_show/",$zcymainpic_url."human_hair/human_hair_details/curly_buyer_show/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/human_hair_details/curly_buyer_show/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_human_hair/human_hair_details/length/",$zcymainpic_url."human_hair/human_hair_details/length/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/human_hair_details/length/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_human_hair/human_hair_details/statement/",$zcymainpic_url."human_hair/human_hair_details/statement/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/human_hair_details/statement/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_human_hair/human_hair_details/wash/",$zcymainpic_url."human_hair/human_hair_details/wash/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/human_hair_details/wash/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_human_hair/lace_front/",$zcymainpic_url."human_hair/lace_front/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/lace_front/")).".jpg", $vrs);
      $vrs = str_replace("zcymainpic_human_hair/silk_top_full_lace/",$zcymainpic_url."human_hair/silk_top_full_lace/".random_int(1,check_mainpic_url($zcymainpic_url."human_hair/silk_top_full_lace/")).".jpg", $vrs);

      $ss = check_mainpic_url($zcymainpic_url."human_hair/straight/");
      for($i = 1; $i < 7; $i++){
      $i5 = random_int(1,$ss);
        if(in_array($i5, $array_url)){
          $i = $i -1;
          continue;
        }
      $vrs = str_replace("zcymainpic_human_hair/straight".$i."/",$zcymainpic_url."human_hair/straight/".$i5.".jpg", $vrs);
      $array_url[$i] = $i5;
      }
      unset($array_url);

      $ss = check_mainpic_url($zcymainpic_url."human_hair/body_wave/");
      for($i = 1; $i < 7; $i++){
      $i5 = random_int(1,$ss);
        if(in_array($i5, $array_url)){
          $i = $i -1;
          continue;
        }
      $vrs = str_replace("zcymainpic_human_hair/body_wave".$i."/",$zcymainpic_url."human_hair/body_wave/".$i5.".jpg", $vrs);
      $array_url[$i] = $i5;
      }
      unset($array_url);

      $ss = check_mainpic_url($zcymainpic_url."human_hair/curly/");
      for($i = 1; $i < 7; $i++){
      $i5 = random_int(1,$ss);
        if(in_array($i5, $array_url)){
          $i = $i -1;
          continue;
        }
      $vrs = str_replace("zcymainpic_human_hair/curly".$i."/",$zcymainpic_url."human_hair/curly/".$i5.".jpg", $vrs);
      $array_url[$i] = $i5;
      }
      unset($array_url);

      $ss = check_mainpic_url($zcymainpic_url."human_hair/human_hair_details/");
      for($i = 1; $i < 4; $i++){
      $i5 = random_int(1,$ss);
        if(in_array($i5, $array_url)){
          $i = $i -1;
          continue;
        }
      $vrs = str_replace("zcymainpic_human_hair/human_hair_details".$i."/",$zcymainpic_url."human_hair/human_hair_details/".$i5.".jpg", $vrs);
      $array_url[$i] = $i5;
      }
      unset($array_url);

      $ss = check_mainpic_url($zcymainpic_url."human_hair/silk_base_details/");
      for($i = 1; $i < 4; $i++){
      $i5 = random_int(1,$ss);
        if(in_array($i5, $array_url)){
          $i = $i -1;
          continue;
        }
      $vrs = str_replace("zcymainpic_human_hair/silk_base_details".$i."/",$zcymainpic_url."human_hair/silk_base_details/".$i5.".jpg", $vrs);
      $array_url[$i] = $i5;
      }
      unset($array_url);

      $ss = check_mainpic_url($zcymainpic_url."synthetic/SHORT/");
      for($i = 1; $i < 4; $i++){
      $i5 = random_int(1,$ss);
        if(in_array($i5, $array_url)){
          $i = $i -1;
          continue;
        }

      $vrs = str_replace("zcymainpic_synthetic/SHORT".$i."/",$zcymainpic_url."synthetic/SHORT/".$i5.".jpg", $vrs);
      $array_url[$i] = $i5;
      }
      unset($array_url);

      $ss = check_mainpic_url($zcymainpic_url."synthetic/CZ_HC/");
      for($i = 1; $i < 4; $i++){
      $i5 = random_int(1,$ss);
        if(in_array($i5, $array_url)){
          $i = $i -1;
          continue;
        }
      $vrs = str_replace("zcymainpic_synthetic/CZ_HC".$i."/",$zcymainpic_url."synthetic/CZ_HC/".$i5.".jpg", $vrs);
      $array_url[$i] = $i5;
      }
      unset($array_url);
      
      $ss = check_mainpic_url($zcymainpic_url."synthetic/27FW/");
      for($i = 1; $i < 4; $i++){
      $i5 = random_int(1,$ss);
        if(in_array($i5, $array_url)){
          $i = $i -1;
          continue;
        }
      $vrs = str_replace("zcymainpic_synthetic/27FW".$i."/",$zcymainpic_url."synthetic/27FW/".$i5.".jpg", $vrs);
      $array_url[$i] = $i5;
      }
      unset($array_url);

		$varations_img_sql_table_name = date("Y_m_d",strtotime("0 day"))."_random_".$_POST["ebaysellerid"];

		try {
			$rows = $db_varations_image->query('select * from '.$varations_img_sql_table_name)->fetchAll();
			$row_count = $db_varations_image->query('select * from '.$varations_img_sql_table_name)->rowCount();
		} catch (Exception $e) {
			unset($rows);
		}

		if($rows){
			$count = $ui + 1;
				for( $i = 0; $i < $row_count; $i++ ){
					if($rows[$i]['muban_count'] == $count){
            $rows[$i]['sku'] = str_replace(".jpg","",$rows[$i]['sku']);
						$vrs = str_replace('zcy_'.$rows[$i]['sku'], $rows[$i]['random_id'], $vrs);
						$vrs = str_replace_once('zcy_imgs_'.$rows[$i]['sku'], $rows[$i]['url'], $vrs);
					}
				}
			}

      preg_match_all("/\/link\/(.*)\.js/iU", $vrs, $matches_js);
      preg_match_all("/\/link\/(.*)\.css/iU", $vrs, $matches_css);
      for($i_js=0; $i_js < count($matches_js[0]); $i_js++){
          //    echo $matches_js[0][$i_js]."<br/>";
      }
      for($i_css=0; $i_css < count($matches_css[0]); $i_css++){
            //  echo $matches_css[0][$i_css]."<br/>";
      }
			$html = fopen($ui.".html", "w") or die("Unable to open file!");
			fwrite($html, $vrs);
			fclose($html);
			echo '
			<iframe id="mubaninput'.$ui.'" name="mubaninput'.$ui.'" style="width:600px;height:600px;" src="'.$ui.'.html">
			</iframe>
			';
		}

		echo '
		<td>
		<input id="mubancount" type="text" name="mubancount" hidden="hidden" readonly="readonly" value="'.$ui.'" style="width:50px;height:30px;">
		</td>
		</table>
				</tbody>';

}else if($_POST["submit"] == "CHECK")
{
	$post = array (
		'username' => $web_username,
		'password' => $web_password,
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
}else if($_POST["submit"] == "Edit Muban"){
	echo "<html><head><title>稍候。。。</title></head>
	<body>
	<script language='javascript'>document.location = 'http://".$web_site."/index.php/muban/editmuban/muban_id/".$_POST['mubanid']."'</script>
	</body>
	</html>";
}else if($_POST["submit"] == "checkout"){
  
  $itts = explode(PHP_EOL, $_POST["inputtitle"]);
  $itts = str_replace(array("\r\n", "\r", "\n"), '', $itts);
  for($i = 0; $i < count($itts); $i++){
    
    
    $keyword = explode(' ', $itts[$i]);
    
    for($i_title = 0; $i_title < count($itts); $i_title++){
      
      $check_count = 0;
      if($i_title == $i){
        continue;
      }
      
      $checktitle_keyword = explode(' ', $itts[$i_title]);
      
      for($i_keyword = 0; $i_keyword < count($keyword); $i_keyword++){
        
        if(in_array($keyword[$i_keyword], $checktitle_keyword)){
          $check_count++;
        }
        
      }
      
      if(count($checktitle_keyword) - $check_count <= 1
         && strlen($itts[$i_title]) > 40){
        echo $i."---<font size=\"4px\" color=\"red\">".$itts[$i]."</font></br>";
        break;
      }else{
        if(count($itts) - $i_title == 1){
        echo $i."---".$itts[$i]."</br>";
        }
      }
      
    }
  
    
  }
}
?>
