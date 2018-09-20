<?php
set_time_limit(0);
require_once "../../vendor/paragonie/random_compat/lib/random.php";
date_default_timezone_set("Asia/Hong_Kong");
include('conn_mysql.php');

set_time_limit(0);

$post = array (
	'username' => $_COOKIE["username"],
	'password' => $_COOKIE["password"],
	'submit' => '登录'
);
//登录地址
$url = "http://".$web_site."/index.php/myibay/login";
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
echo $cookie = $matches[1]; //获得COOKIE（SESSIONID）
curl_close($curl); //关闭curl

/* 解析cookie结束 */

$list_dir = scandir("../varations_image");

$ch = curl_init();
curl_setopt($ch , CURLOPT_URL , "http://".$web_site."/index.php/muban/uploadpicture/siteid/0");
curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch , CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_COOKIE, $cookie);

unset($dir_bool);

for($i_dir=2; $i_dir < count($list_dir); $i_dir++){

	$selleruserid = "hair_trends";

	$list_pics = scandir("../varations_image/".$list_dir[$i_dir]);
	$sql_table_name = date("Y_m_d",strtotime("0 day"))."_random_".$selleruserid;

	$creat_sql = "CREATE TABLE ".$sql_table_name."
	(
	muban_count varchar(255),
	sku varchar(255),
	random_id varchar(255),
	url varchar(255)
	)";

	try {
			$db_varations_image->query($creat_sql);
			echo '</br>Creat success';
	} catch (Exception $e) {

	}

  for($i_muban_count = 1; $i_muban_count <= 6; $i_muban_count ++){

    mkdir('../download/varations_image/'.$list_dir[$i_dir]."/".$i_muban_count,0777,true);

    for($i_pics = 2; $i_pics < count($list_pics); $i_pics++){

      $random_id_count = $i_pics - 1;
      $random_id = chr(random_int(65,90)).chr(random_int(65,90)).$random_id_count;
      $sku = str_replace(".JPG","",$list_pics[$i_pics]);

			for($i_tag_sku = 1; $i_tag_sku <= 6; $i_tag_sku++){
				$remove_tag_sku = str_replace("_tag_".$i_tag_sku, "", $sku);
			}

			$rows = $db_varations_image->query('select * from '.$sql_table_name)->fetchAll();
			$row_count = $db_varations_image->query('select * from '.$sql_table_name)->rowCount();

			$url_bool = 1;
			unset($url_update);
			for( $i = 0; $i < $row_count; $i++ ){

				if($rows[$i]['muban_count'] == $i_muban_count
				&& $rows[$i]['sku'] == $sku
				&& !$rows[$i]['url']){
					$url_update = 1;
					$random_id = $rows[$i]['random_id'];
					break;
				}

				if(strstr($rows[$i]['sku'], $remove_tag_sku)){
					$random_id = $rows[$i]['random_id'];
				}

				if($rows[$i]['muban_count'] == $i_muban_count
				&& $rows[$i]['sku'] == $sku
				&& $rows[$i]['url']){
					unset($url_bool);
				}

			}

			if(!$url_bool){
				continue;
			}

      $pics = imagecreatefromjpeg("../varations_image/".$list_dir[$i_dir]."/".$list_pics[$i_pics]);

      $newImg = imagecreatetruecolor(1000,1000);
      imagecopyresampled($newImg,$pics,0,0,0,0,1000,1000,imagesx($pics),imagesy($pics));

      $font = "../CENSCBK.TTF";
      //设置字体的颜色rgb和透明度
      $col = imagecolorallocatealpha($newImg,218,112,214,15);
      //写入文字

      $fontWidth = imagefontwidth($fontSize);//获取文字宽度
      $textWidth = $fontWidth * mb_strlen($text1);
      $x = ceil(($width - $textWidth) / 2); //计算文字的水平位置

			if(strstr($list_dir[$i_dir],"HF")){
				$fontSize  = 60;
				$y = 180;
			}else{
				$fontSize  = 75;
				$y = 920;
			}

			imagettftext($newImg, $fontSize, $x, 400, $y, $col, $font, $random_id);
      $pic_path = '../download/varations_image/'.$list_dir[$i_dir]."/".$i_muban_count.'/'.$sku.'.jpg';
      imagejpeg($newImg,$pic_path, 90);
      imagedestroy($pics);
      imagedestroy($newImg);

      $post_data = array(
    	"img" => $sis[6].'/download/varations_image/'.$list_dir[$i_dir]."/".$i_muban_count.'/'.$sku.'.jpg',
    	"size" => "Supersize",
    	"selleruserid" => $selleruserid,
    	"siteid" => "0",
    	"inputid" => "",
    	"submit" => "上传",
    	);

      curl_setopt($ch , CURLOPT_POSTFIELDS, $post_data);
      echo $output = curl_exec($ch);
      unset($matches);
      $output = str_replace("http:", "https:", $output);
      preg_match("/https:\/\/i.ebayimg.com(.*)_3.JPG/iU", $output, $matches);

			if($url_update){

			$sql_insert = "UPDATE ".$sql_table_name." SET url = '".$matches[0]."' where "."muban_count = '".$i_muban_count."'"." and sku = '".$sku."' and random_id = '".$random_id."'";

			}else{

      $sql_insert = "insert into ".$sql_table_name."(muban_count,sku,random_id,url)
      values('".$i_muban_count."','".$sku."','".$random_id."','".$matches[0]."')";

			}

			try {
        	$db_varations_image->query($sql_insert);
					echo $sql_insert."<br/>".$list_dir[$i_dir];
      	} catch (Exception $e) {
        	echo $e."<br/>".$sql_insert;
      }

    	}
  	}

}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://".$web_site."/index.php/myibay/logout");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIE, $cookie);
$XX = curl_exec($ch);
curl_close($ch);

?>
