<?php
date_default_timezone_set("Asia/Hong_Kong");
require_once "../vendor/paragonie/random_compat/lib/random.php";

//composer require phpoffice/phpspreadsheet
require '../vendor/autoload.php';
include('src/conn_mysql.php');

function html_return($html_content,$html_meun,$web_password){
  return '<html lang="en">
  	<head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="theme-color" content="#2196f3">
      <link rel="stylesheet" href="/css/materialize.min.css">
      <link rel="stylesheet" href="//fonts.loli.net/icon?family=Material+Icons">
      <link rel="stylesheet" href="/css/main.css">
      <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="//cdnjs.loli.net/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
      <script type="text/javascript" src="/js/main.js"></script>
      <title>小黑网</title>
  	</head>
    <body>
    <header>
          <nav class="top-nav blue">
            <div class="nav-wrapper">
              <div class="container">
              <script type="text/javascript" src="js/time.js"></script>
              <style type="text/css">
              *{margin:0;padding:0;list-style:none;border:none;}
              #pdata{width:320px;margin:2px auto;}
              </style>
                <div id="pdata"></div>
              </div>
            </div>
          </nav>
          <div class="container">
            <a href="#" data-activates="slide-out" class="button-collapse top-nav full hide-on-large-only">
              <i class="material-icons">menu</i>
            </a>
          </div>
          <ul id="slide-out" class="side-nav fixed">
            <li style="padding-top:50px"><a class="subheader">MEUN</a></li>
            '.$html_meun.'
          </ul>
        </header>
      <main>
        <div class="container" style="margin-top: 20px">
          <div class="row">
            <div class="col s12">
              <div class="card info">
                <div class="card-content">
  '.$html_content.'
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
  </body></html>
  ';
}

$html_meun_lock = '
<li id="type_aliexpress_feedback_image"><a class="waves-effect" href="?action=aliexpress_feedback_image" >Aliexpress feedback image</a></li>
<li id="type_rolling"><a class="waves-effect" href="?action=Rolling" >Rolling Title</a></li>
<li id="type_add_items"><a class="waves-effect" href="?action=add_items" >Add Items</a></li>
<li id="type_settings"><a class="waves-effect" href="?action=settings" >Settings</a></li>
';

$html_meun = '
<li id="type_picture_search"><a class="waves-effect" href="?action=picture_search" >Pictures Search</a></li>
<li id="type_clear_zero"><a class="waves-effect" href="?action=clear_zero" >Clear Zero</a></li>
<!-- <li id="type_transaction_sold"><a class="waves-effect" href="?action=transaction_sold" >Transaction Sold</a></li>-->
';

$html_active = 'class="active blue"';

if($_GET["action"]=="Rolling" && $_COOKIE["password"] == $web_password)
{
  function rolling_content($db_test){
    $contents .= '<form name="form0" method="post" action="?action=Rolling">
        <table>
        <tbody>
        <tr>
          <textarea id="title" class="search-wrapper card" style="resize:none"></textarea>
        </tr>
          <tr height="35">
            <td>';

      $listing_type_tables = $db_test->query('show tables'); //返回一个PDOStatement对象
      $rows = $listing_type_tables->fetchAll(); //获取所有
    	$contents .= '<select id="listingtype" name="listingtype" >';
      for( $i= 0; $i < count($rows); $i++ ){
        $contents .= '<option value="'.$rows[$i][0].'">'.$rows[$i][0].'</option>';
    	}

    	$contents .= '</select>
        </td><td>	<input id="no_wigs" name="no_wigs" value="checked" type="checkbox">
      		<label id="no_wigs_lable" name="no_wigs_lable" for="no_wigs" class="">no wigs</label></td>
                    </tr>
                    <tr height="35">
                      <td><input id="submit" name="submit" value="Roll" type="submit" class="btn-large waves-effect waves-light blue">&nbsp</td>
      								<td><input id="count" name="count" value="" type="text" style="width:100px;height:30px;">&nbsp</td>
      									</form>
                              </tr>
                              <tr><input type="button" onClick="copyUrl2()" value="Copy" class="btn-large waves-effect waves-light blue">&nbsp
                                 <input type="button" onClick="editroll()" value="Edit Roll" class="btn-large waves-effect waves-light blue">&nbsp</tr>
        </tbody>
        </table>
      		</form>';
     	if($_POST["submit"]=="Roll")
      	{
          $keyword_rows = $db_test->query('select * from '.$_POST["listingtype"].'')->fetchAll();
          $keyword_rows_count = $db_test->query('select * from '.$_POST["listingtype"].'')->rowCount();

      		$i = 0;
      		for($i=0; $i < $keyword_rows_count; $i++)//转成数组，且返回第一条数据,当不是一个对象时候退出
      		{
      		 $tArra[$i] = $keyword_rows[$i]['r1'];
      		 $tArrb[$i] = $keyword_rows[$i]['r2'];
      		 $tArrc[$i] = $keyword_rows[$i]['r3'];
      		 $tArrd[$i] = $keyword_rows[$i]['r4'];
      	 }

      	 $contents .= "<script>document.getElementById('title').innerHTML='";
      	 for ($t = 0; $t < $_POST["count"]; $t++)
      	 {
      		 if($_POST["no_wigs"] =="checked" )
      		 {
      					$wigs = 1;
      		 }else {
      		 			$wigs = 0;
      		 }
      		$space = 0;
      		$i1 = random_int(0,$i);
      	 	$i2 = random_int(0,$i);
      		$i3 = random_int(0,$i);
      		$i4 = random_int(0,$i);
      		while(empty($tArra[$i1])||empty($tArrb[$i2])||empty($tArrc[$i3])||empty($tArrd[$i4])){
      					$i1 = random_int(0,$i);
      					$i2 = random_int(0,$i);
      					$i3 = random_int(0,$i);
      					$i4 = random_int(0,$i);
      		}
      		if(strlen($tArra[$i1]." ".$tArrb[$i2]." ".$tArrc[$i3]." ") <= 36)
      		{
      			if($_POST["no_wigs"] != "checked" )
      			{
      			$titles1 = $tArra[$i1]." ".$tArrb[$i2]." wig ".$tArrc[$i3]." ".$tArrd[$i4];
      		}else{
      			$titles1 = $tArra[$i1]." ".$tArrb[$i2]." ".$tArrc[$i3]." ".$tArrd[$i4];
      		}

      		}else{
      			if($_POST["no_wigs"] != "checked" )
      			{
      			$titles1 = $tArra[$i1]." ".$tArrb[$i2]." ".$tArrc[$i3]." wig ".$tArrd[$i4];
      		}else{
      			$titles1 = $tArra[$i1]." ".$tArrb[$i2]." ".$tArrc[$i3]." ".$tArrd[$i4];
      		}
      		}
      		$t1 = 0;
      		$i6 = array();
      		while( strlen($titles1) < 79 ){
      			$i5 = random_int(0,$i);
            while(empty($tArra[$i5])){
                  $i5 = random_int(0,$i);
            }
      			if($i4 == $i5){
      				continue;
      			}
      			if (in_array($i5, $i6)) {
      				continue;
      			}
      			if( strlen($titles1) >= 75 )
      			{
      				$titles1 .= " ".chr(random_int(97, 122)).random_int(0,9).chr(random_int(97, 122));
      			}else{
      			if(random_int(0,100)%2 == 0 and $wigs == 0)
      			{
      				$titles1 .= " wigs ".$tArrd[$i5];
      				$wigs = 1;
      			}else {
              $titles1 .= " ".$tArrd[$i5];
      			}
          }
      			$i6[$t1] = $i5;
      			$t1++;
      	}
          $contents .= $titles1.'\n';
      	 }
      	$contents .= "';
          document.getElementById('listingtype').value='".$_POST["listingtype"]."';
          document.getElementById('count').value='".$_POST["count"]."';";
          if($_POST["no_wigs"] == "checked"){
          $contents .= "document.getElementById('no_wigs').checked='checked';";
          }
        $contents .= "</script>";
      	}

      $contents .= '
      </div>
          <!-- copy script-->
      		<script type="text/javascript">
      function copyUrl2()
          {
            var oContent=document.getElementById("title");
      			oContent.select(); // 选择对象
      			document.execCommand("Copy"); // 执行浏览器复制命令
      			alert("复制完毕，可粘贴");
          }
          function editroll()
              {
                window.open(\'/editroll.php\',\'Edit Roll\',\'width=800,height=500,menubar=no,scrollbars=yes\',\'true\');
              }
      </script>';
         return $contents;

    }

  $html_meun .= $html_meun_lock;
  $html_meun = str_replace('"type_rolling"','"type_rolling" '.$html_active, $html_meun);
  echo html_return(rolling_content($db_test),$html_meun,$web_password);

}else if($_GET["action"]=="picture_search"){

  if($_COOKIE["password"] == $web_password){
    $html_meun = $html_meun.$html_meun_lock;
  }

  $html_meun = str_replace('"type_picture_search"','"type_picture_search" '.$html_active, $html_meun);

  function ps_content($db_web){
    $contents .= '<form name="bf" method="post" action="">
<select name="ebayusr_WIG" id="ebayusr_WIG" style="width:150px;height:30px;">
<option value=""></option>
';

$ps_tw_seller = $db_web->query('select * from mkwig_20180607')->fetchAll(); //获取所有
$row_count = $db_web->query('select * from mkwig_20180607')->rowCount(); //记录数，2

// 创建连接
for( $i= 0; $i < $row_count; $i++ ){
  if($ps_tw_seller[$i]['sellerid']){
  $contents .= '<option value="'.$ps_tw_seller[$i]['sellerid'].'">'.$ps_tw_seller[$i]['sellerid'].'</option>';
  }
}
unset($ps_tw_seller);

$contents .= '
</select>
<input id="no_he" name="no_he" value="checked" type="checkbox">
<label id="no_he_lable" name="no_he_lable" for="no_he" class=""></label>
<select name="ebayusr_HE" id="ebayusr_HE" style="width:150px;height:30px;">
<option value=""></option>
';

$ps_th_seller = $db_web->query('select * from mkhe_20180606')->fetchAll(); //获取所有
$row_count = $db_web->query('select * from mkhe_20180606')->rowCount(); //记录数，2
// 创建连接
for( $i= 0; $i < $row_count; $i++ ){
  if($ps_th_seller[$i]['sellerid']){
  $contents .= '<option value="'.$ps_th_seller[$i]['sellerid'].'">'.$ps_th_seller[$i]['sellerid'].'</option>';
  }
}
unset($ps_th_seller);

$contents .= '
</select>
<input id="no_wigs" name="no_wigs" value="checked" type="checkbox">
<label id="no_wigs_lable" name="no_wigs_lable" for="no_wigs" class=""></label>
<select name="sch" id="sch" style="width:150px;height:30px;">
<option value="human+hair+wig">human+hair+wig</option>
<option value="human+hair+extensions">human+hair+extensions</option>
</select>
<input id="submit" name="submit" value="search" type="submit" class="btn-large waves-effect waves-light blue">
</form>
';
if($_POST["submit"]=="submitebay")
{
$contents .= '
<script>
document.getElementById(\'tab2\').checked=\'checked\';
document.getElementById(\'ebayusr_HE\').value=\''.$_POST["ebayusr_HE"].'\';
document.getElementById(\'ebayusr_WIG\').value=\''.$_POST["ebayusr_WIG"].'\';
document.getElementById(\'sch\').value=\''.$_POST[sch].'\';
';
    if($_POST["no_wigs"] == "checked"){
    $contents .= 'document.getElementById(\'no_wigs\').checked=\'checked\';';
    }
    if($_POST["no_he"] == "checked"){
    $contents .= 'document.getElementById(\'no_he\').checked=\'checked\';';
    }
$contents .= "</script>";
}
if($_POST['no_wigs'] || $_POST['no_he'])
{
  if($_POST['no_wigs'])
  {
    $SWITCHS = "ebayusr_HE";
  }else{
    $SWITCHS = "ebayusr_WIG";
  }
if($_POST[$SWITCHS] && $_POST['sch'])
{
  set_time_limit(0);
  $count1 = 0;
    $bigc = 0;
  for($bi = 1; $bi < 40; $bi++)
  {
    if($bi == 1)
    {
      $url = "https://www.ebay.com/sch/m.html?_ssn=".$_POST[$SWITCHS]."&_sop=10&_armrs=1&_from=R40&_sacat=0&_nkw=".$_POST['sch']."&rt=nc&_ipg=200";
  //  $url = "https://www.ebay.co.uk/sch/m.html?_fcid=77&_ssn=".$_POST[$SWITCHS]."&_armrs=1&_clu=2&gbr=1&_from=R40&_sacat=0&_nkw=".$_POST['sch']."&rt=nc&_fcid=3";
    }else{
      $dv = $bi - 1 ;
      $skc = $dv * 2 * 100;
     $url = "https://www.ebay.com/sch/m.html?_ssn=".$_POST[$SWITCHS]."&_sop=10&_armrs=1&_from=R40&_ipg=200&_sacat=0&_nkw=".$_POST['sch']."&_pgn=".$bi."&_skc=".$skc."&rt=nc";
  //$url = "https://www.ebay.co.uk/sch/m.html?_fcid=77&_ssn=".$_POST[$SWITCHS]."&_armrs=1&_clu=2&gbr=1&_from=R40&_sacat=0&_nkw=".$_POST['sch']."&_pgn=".$bi."&_skc=".$skc."&rt=nc&_fcid=3";
    }
    //登录地址
    //模拟登录
    //login_post($url, $cookie, $post);
    $curl = curl_init();//初始化curl模块
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $GLOBALS ['user_agent']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_HTTPGET, 1); // 发送一个常规的Post请求
//    curl_setopt($curl, CURLOPT_COOKIE, $cookie); // 读取上面所储存的Cookie信息
//    curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS ['cookie_file']); // 读取上面所储存的Cookie信息
    curl_setopt($curl, CURLOPT_TIMEOUT, 120); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    curl_setopt($curl, CURLOPT_SSLVERSION, 4);
    curl_setopt($curl, CURLOPT_COOKIE, "nonsession=BAQAAAWKns8EdAAaAAAgAHFr1nukxNTIzMzg0ODk4eDE0MjcxMjMxMzkxN3gweDJZADMABFyvRWksVVNBAMsAAlrOGPExNQDKACBkNBNpMGI1NGIzZjQxNjIwYTljYjA3NTdhYjYyZmZmNThmMTSoIJ/AO5OpnE/fwMmTVLnn6cgbsw**");
    $rs = curl_exec($curl);
    $rs = str_replace("s-l225.jpg","s-l1600.jpg", $rs);
    preg_match_all("/https:\/\/i.ebayimg.com\/thumbs\/images\/(.*)\/s\-l1600.jpg/iU", $rs, $matches[$bi]);
    if($matches[$bi][0] == $matches[$bi - 1][0])
    {
      curl_close($curl); //关闭curl
      break;
    }
    $ph = 1;
    if(count($matches[$bi][0]) == 0)
    {
      break;
    }
    for( $i=0; $i < count($matches[$bi][0]); $i++)
    {
      if($count1 >= 200)
      {
        $count1 = 0;
        break;
      }
      $count1++;
      $count2 = $count1;
      $contents .= "<img src=\"".$matches[$bi][0][$i]."\" width=\"100\" height=\"100\">";
    }
    $bigc = $bigc + $count2;
    curl_close($curl); //关闭curl
  }
  $contents .= "count: ".$bigc;
}
}
  return $contents;
  }

  $html_content = "picture_search";
  echo html_return(ps_content($db_web),$html_meun,$web_password);

}else if($_GET["action"]=="transaction_sold")
{

  if($_COOKIE["password"] == $web_password ){
    $html_meun = $html_meun.$html_meun_lock;
  }

  $html_meun = str_replace('"type_transaction_sold"','"type_transaction_sold" '.$html_active, $html_meun);

function transactionssold_data_show($db_web,$container,$site_code,$sku){
  if($site_code == 0){
    $site = "USD";
  }else if($site_code == 77){
    $site = "EUR";
  }else if($site_code == 3){
    $site = "GBP";
  }else{
    echo "ERROR SITE CODE";
    exit;
  }

  $data_return .='
  $(function () {
  $(\'#'.$container.'\').highcharts({
      chart: {
          type: \'column\'
      },
      subtitle: {
          text: \'数据日期 '.$_POST["transactionsolddate"].'\'
      },
      xAxis: {
          type: \'category\',
          labels: {
              rotation: -45,
              style: {
                  fontSize: \'13px\',
                  fontFamily: \'Verdana, sans-serif\'
              }
          }
      },
      yAxis: {
          min: 0,
          title: {
              text: \''.$site.'\'
          }
      },
      legend: {
          enabled: false
      },
      tooltip: {
          pointFormat: \'业绩: <b>{point.y:.1f} '.$site.'</b>\'
      },
      series: [{
          name: \'总业绩\',
          data: [
';

  if($_POST["transactionsolddate"])
  {
    $data = "SELECT * FROM "."SOLD_".$_POST["transactionsolddate"];
  }else{
    $data = "SELECT * FROM "."SOLD_".date("Ymd",strtotime("0 day"));
  }

  $i = 0;
  $totalrow = 0;
  $rows = $db_web->query($data)->fetchAll();
  $rows_count = $db_web->query($data)->rowCount();

  for($i = 0; $i< $rows_count; $i++)//转成数组，且返回第一条数据,当不是一个对象时候退出
  {
   if($rows[$i]['site'] == $site_code && $rows[$i]['sku'] == $sku)
   {
     $data_return .='[\''.$rows[$i]['selleruserid']." ".$rows[$i]['count'].'\', '.$rows[$i]['total'].'],';
     $totalrow = $totalrow + $rows[$i]['total'];
   }
  }
    return $data_return .='],
          dataLabels: {
              enabled: true,
              rotation: -90,
              color: \'#FFFFFF\',
              align: \'right\',
              format: \'{point.y:.1f}\', // one decimal
              y: 10, // 10 pixels down from the top
              style: {
                  fontSize: \'13px\',
                  fontFamily: \'Verdana, sans-serif\'
              }
          }
      }],
      title: {
          text: \'ebay '.$site.'站点'.$sku.'产品 （团队业绩：'.$totalrow.' '.$site.'）\'
      },
  });
});';

}

function ts_content($db_web,$web_password){
    $contents .= '<form action="" method="post">
 <select name="transactionsolddate" id="transactionsolddate" style="width:150px;height:30px;">
  <option value="'.date("Ymd",strtotime("1 day")).'">'.date("Y-m-d",strtotime("1 day")).'</option>
 <option value="'.date("Ymd",strtotime("0 day")).'">'.date("Y-m-d",strtotime("0 day")).'</option>
 <option value="'.date("Ymd",strtotime("-1 day")).'">'.date("Y-m-d",strtotime("-1 day")).'</option>
 <option value="'.date("Ymd",strtotime("-2 day")).'">'.date("Y-m-d",strtotime("-2 day")).'</option>
 <option value="'.date("Ymd",strtotime("-3 day")).'">'.date("Y-m-d",strtotime("-3 day")).'</option>
 <option value="'.date("Ymd",strtotime("-4 day")).'">'.date("Y-m-d",strtotime("-4 day")).'</option>
 <option value="'.date("Ymd",strtotime("-5 day")).'">'.date("Y-m-d",strtotime("-5 day")).'</option>
 <option value="'.date("Ymd",strtotime("-6 day")).'">'.date("Y-m-d",strtotime("-6 day")).'</option>
 <option value="'.date("Ymd",strtotime("-7 day")).'">'.date("Y-m-d",strtotime("-7 day")).'</option>
 <option value="'.date("Ymd",strtotime("-8 day")).'">'.date("Y-m-d",strtotime("-8 day")).'</option>
 <option value="'.date("Ymd",strtotime("-9 day")).'">'.date("Y-m-d",strtotime("-9 day")).'</option>
 </select>
 <input id="submit" name="submit" value="DATE" type="submit" class="btn-large waves-effect waves-light blue">
 </form>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="/js/hightcharts.js"></script>
<script src="/js/exporting.js"></script>
';
if($_COOKIE["password"] == $web_password || $_COOKIE["password"] == "123321")
{
  $contents .= '
<div id="container1" class="card-content card"></div>
<div id="container2" class="card-content card"></div>
<div id="container3" class="card-content card"></div>
<div id="container4" class="card-content card"></div>
<div id="container5" class="card-content card"></div>
<script>
';

if($_COOKIE["password"] == $web_password)
{
  $contents .= transactionssold_data_show($db_web,"container1",0,"TW");
  $contents .= transactionssold_data_show($db_web,"container2",3,"TW");
  $contents .= transactionssold_data_show($db_web,"container3",77,"TW");
}

if($_COOKIE["password"] == $web_password || $_COOKIE["password"] == "123321"){
  $contents .= transactionssold_data_show($db_web,"container3",77,"TW");
  $contents .= transactionssold_data_show($db_web,"container4",0,"TH");
  $contents .= transactionssold_data_show($db_web,"container5",77,"TH");
}

$contents .='
function editseller()
  {
    window.open(\'/editseller.php\',\'Edit Seller\',\'width=600,height=800,menubar=no,scrollbars=yes\',\'true\');
  }
</script>
<input type="button" onClick="editseller()" value="Edit SellerID" class="btn-large waves-effect waves-light blue">';
return $contents;
  }
}

  echo html_return(ts_content($db_web,$web_password),$html_meun,$web_password);

}else if($_GET["action"]=="add_items" && $_COOKIE["password"] == $web_password)
{

  $html_meun .= $html_meun_lock;
  $html_meun = str_replace('"type_add_items"','"type_add_items" '.$html_active, $html_meun);

  $html_content = '
  <form action="/mb2.php" method="post" name="m" id="m" target="_blank">
  <table>
  <tbody>
  <tr>
  <td>
  <input id="submit" name="submit" value="CHECK" type="submit" class="btn-large waves-effect waves-light blue">
  <input id="submit" name="submit" value="CHECKITEM" type="submit" class="btn-large waves-effect waves-light blue">
  </td>
  </tr>
  </tbody>
  </table>
  <textarea id="inputtitle" name="inputtitle" class="search-wrapper card" style="resize:none"></textarea>
  <div style="margin:0 5px;">
           刊登主图
                  <input type="button" title="可一次性选择多张本地图片进行上传" value="上传ebay服务器" onclick="window.open(\'http://'.$web_site.'/index.php/muban/uploadpicture/siteid/0\',\'上传图片\',\'width=1024,height=600,menubar=no,scrollbars=yes\',\'true\')">
          <input type="button" title="可一次性选择多张本地图片进行上传" value="随机生成获取图片" onclick="window.open(\'./photo.php\',\'上传图片\',\'width=1024,height=600,menubar=no,scrollbars=yes\',\'true\')">
                &nbsp;&nbsp;
             <input type="button" value="再添加一个图片" onclick="javascript:Addimgurl_input();return false;">
             &nbsp;&nbsp;<input type="button" value="清空主图" onclick="Deleteimgurl_input()">
               <script type="application/javascript" language="javascript">
               function Deleteimgurl_input(){
                   $(\'#div_imgurl_input\').find(\'.movebox\').each(function (index){
                      if(index==0){
                          $(this).find(\'input[type=text]\').val(\'\');
                          $(this).find(\'img\').attr(\'src\',\'\');
                      }else{
                         $(this).remove();
                      }
                   })
            }
          </script>
       <div id="div_imgurl_input">
       <script src="/js/ddsort.js"></script>
               <div class="movebox"></div></div>
                 </div>
  <script language="javascript">
  $( \'#div_imgurl_input\').DDSort({
  	target: \'.movebox\',
  	floatStyle: {
  		\'position\':\'absolute\',
  		\'border\': \'1px solid #ccc\',
  		\'background-color\': \'#fff\',
  	},
  });
  function setimgtagurl(id,url){
  	$(\'#\'+id).prev().attr(\'src\',url);
  }
  function addimgtagurl(id,url){
  	var name=$(\'#\'+id).attr(\'name\');
  	//说明是刊登图片
  	//alert(name.indexOf(\'imgurl\')+"--"+name.indexOf(\'imgshow\')+"--"+name.indexOf(\'rollingimg\'));
  	if(name.indexOf(\'imgurl\')>=0){
  		Addimgurl_input(url);
  	}//特效图片
  	else if(name.indexOf(\'imgshow\')>=0){
  		Addimgurl_input2(url);
  	}//图片轮播
  	else if(name.indexOf(\'rollingimg\')>=0){
  		Addimgurl_input3(url);
  	}//多属性图片
      else if(name.indexOf(\'picture\')>=0){
  		var obj=$(\'#\'+id).next().next().next();
  		addimgurl(obj,url);
  	}
  }
  function setimgtagurl(id,url){
  	$(\'#\'+id).prev().attr(\'src\',url);
  }
  function imgurl_input_blur(obj){
      var t=$(obj).val();
      if(t.indexOf(\'{-BINDPRODUCTPICTURE-}\')>=0){
          t= t.replace(\'{-BINDPRODUCTPICTURE-}\',$(\'#bindproductpicture_val\').val());
      }
      //一个多属性可以加多张图
      //$(obj).parent().children(\'img\').attr(\'src\',t);
      $(obj).prev().attr(\'src\',t);
  }

   //上移

  function moveup(obj){
  	var img=$(obj).parent().children(\'img\').attr(\'src\');
  	var upimg=$(obj).parent().prev().children(\'img\').attr(\'src\');
  	var va=$(obj).parent().children(\'input[type=text]\').val();
  	var upva=$(obj).parent().prev().children(\'input[type=text]\').val();
  	$(obj).parent().children(\'input[type=text]\').val(upva);
  	$(obj).parent().prev().children(\'input[type=text]\').val(va);
  	$(obj).parent().children(\'img\').attr(\'src\',upimg);
  	$(obj).parent().prev().children(\'img\').attr(\'src\',img);
  }
  //下移
  function movedown(obj){
  	var img=$(obj).parent().children(\'img\').attr(\'src\');
  	var downimg=$(obj).parent().next().children(\'img\').attr(\'src\');
  	var va=$(obj).parent().children(\'input[type=text]\').val();
  	var downva=$(obj).parent().next().children(\'input[type=text]\').val();
  	$(obj).parent().children(\'input[type=text]\').val(downva);
  	$(obj).parent().next().children(\'input[type=text]\').val(va);
  	$(obj).parent().children(\'img\').attr(\'src\',downimg);
  	$(obj).parent().next().children(\'img\').attr(\'src\',img);
  }
  //删除
  function removeaway(obj){
  	var div=$(obj).parent();
  	if(div.nextAll().length==0&&div.prevAll().length!=0)
  	{
  		div.prev().children(\'a:last-child\').remove();
  	}
  	if(div.prevAll().length==0&&div.nextAll().length!=0)
  	{
  		div.next().children(\'a\')[1].remove();
  	}
  	$(obj).parent().remove();
  	return false;
  }
  //选择商品
  function opengoodswindow(vvalue,siteid)
  {
  //	alert(vvalue+"&"+siteid);
  	//把SKU的input的id值(动态)传给隐藏input
  	$("#childwintoparentwin").val(vvalue);
  	$("#setnext_text").val(siteid);
  	window.open(\'/index.php/goods/selectmygoodstovar\',\'selectGoods\',\'width=850,height=500,menubar=no,scrollbars=yes\',\'true\');
  }

  //增加行
  function addRows(){
  	var num=$(\'#number\').val();
      for(var i=0;i<num;i++){
      	addRow();
      }
  }
  function addRow(obj)
  {
  	vtr=$(\'#variation_table\').find(\'tr:last\').clone().find(\'input[type=text]\').val(\'\').removeAttr(\'readonly\').end();
  	iii=parseInt(vtr.find(\'.vskubox\').attr(\'id\').replace(\'variationsku\',\'\'));
  	iii++;
  	vtr.find(\'input[name^=newattribute]\').each(function (){
  		var oldname=$(this).prev().attr(\'name\');
  		$(this).attr(\'name\',oldname);
  		$(this).prev().remove();
  	});

  	//vtr.find(\'input:first\').attr(\'onkeyup\',\'imgshuxing(\'+iii+\')\');
  	if(typeof(glindex)!=\'undefined\'){
  		name=$.trim($(\'#variation_table\').find(\'tr\').eq(0).find(\'th\').eq(glindex).find(\'input\').eq(1).val());
  		nname = name.replace(/\\\'/g,"%1122%");
  		vname = name.replace(/\s/g,"");
  		vname =vname.replace(/\&/g,"");
  		vtr.find(\'input[type=text]\').eq(glindex).attr(\'onkeyup\',\'imgshuxing(\'+iii+\',\'+glindex+\',\"\'+vname+\'\")\');

  		//vtr.find(\'input\').eq(glindex).attr(\'onblur\',\'imgshuxing(\'+iii+\',\'+glindex+\',\'+name+\');addrelationshuxing(\'+iii+\',\'+glindex+\');\');
  	}
  	var delname=name+iii;
  	vtr.attr(\'id\',iii);
  	vtr.find(\'td:last\').html("<input type=\'button\' onclick=\'delduoshuxin("+iii+",\""+delname+"\",this);\' value=\'删除\'>");
  	vtr.find(\'.vskubox\').attr(\'id\',\'variationsku\'+iii.toString());
  	vtr.find(\'.vskubtn\').attr(\'id\',\'selected\'+iii.toString());
  	vtr.find(\'label\').attr(\'id\', \'setprice_eps\'+iii.toString());

  	vtr.find(\'.vskubtn\').removeAttr("onclick");
  	/*vtr.find(\'.vskubtn\').bind(\'click\', function(){
  		opengoodswindow(\'variationsku\'+iii.toString(), \'setprice_eps\'+iii.toString());
  	});*/
  	var variationsku_num = \'variationsku\'+iii.toString();
  	var setprice_eps_num = \'setprice_eps\'+iii.toString();
  	vtr.find(\'.vskubtn\').attr(\'onclick\', \'opengoodswindow("\'+variationsku_num+\'","\'+setprice_eps_num+\'")\');
  	vtr.appendTo(\'#variation_table\');
  	addimgRow(iii);
  }
  //删除行
  function delduoshuxin(i,id,obj){
  	//$("#"+id).remove();
  	$(obj).parent().parent().remove();
  	$(\'table[name=variationimg]\').each(function (){
  		var name=$.trim($(this).attr(\'id\'))+i;
  		delimg(name);
  	});

  }
  //修改关联属性触发改变组合属性列的onkeup
  function  xiugaishijian(index,name){
  	//$(\'#variation_table\').find(\'tr:last\').find(\'input\').eq(glindex).removeAttr(\'onkeyup\');
  	$(\'#variation_table\').find(\'tr\').each(function (){
           $(this).find(\'input\').eq(glindex).removeAttr(\'onkeyup\');

  	});
  	glindex=index;
  	//$(\'#variation_table\').find(\'tr:last\').find(\'input\').eq(glindex).attr(\'onkeyup\',\'imgshuxing(\'+iii+\',\'+glindex+\')\');
  	$(\'#variation_table\').find(\'tr\').each(function (i){
  		a=i-1;
  		nname = name.replace(/\\\'/g,"%1122%");
           $(this).find(\'input[type=text]\').eq(glindex).attr("onkeyup","imgshuxing("+a+","+glindex+",\""+nname+"\")");
  	});

  }
  //给新增图片的名称列赋值
  function imgshuxing(id,index,name){
      var tr_name=name+id;
      //缺陷 #10176 B_在线listing多属性-增加项后，图片关联属性的部分，属性不会自动填写，手动也无法填写
      tr_name = tr_name.replace(/\s/g,"");
      tr_name =tr_name.replace(/\(/g,"\\\(");
      tr_name =tr_name.replace(/\)/g,"\\\)");
      tr_name =tr_name.replace(/\[/g,"\\\[");
      tr_name =tr_name.replace(/\]/g,"\\\]");
      tr_name =tr_name.replace(/\:/g,"\\\:");
      tr_name =tr_name.replace(/\//g,"\\\/");
      tr_name =tr_name.replace(/\%1122%/g,"\\\\\'");
      tr_name =tr_name.replace(/\#/g,"\\\#");
  	var val=$("#"+id).find(\'input[type=text]\').eq(index).val();
  	$("#"+tr_name.replace(/(^\s*)|(\s*$)/g, "")).find(\'input:first\').val(val);
  	setnewimgvalue($("#"+tr_name).find(\'input:first\'), val);
  }
  //增加关联属性的值
  function addrelationshuxing(id, index){
  	var val=$("#"+id).find(\'input\').eq(index).val();
  	val = \'"\'+val+\'"\';
  	var text = $(\'#variation_table\').find(\'input[type=hidden]\').eq(index).val();
  	var value = $(\'#text\'+text).val();
  	$(\'#text\'+text).text(value.replace(\']}\', ","+val+"]}"));
  	$(\'#text\'+text).attr(\'name\',\'varvalue\');
  }
  //根据listing所支持的ean等添加属性
  function  addcolean(){
  		var val=$(\'#tishi\').text().split(\',\');
  		for(v in val){
  			 if(val[v].indexOf(\'MPN\')>=0){
  				 eanaddcol(\'MPN\');
  	           }
  	           if(val[v].indexOf(\'EAN\')>=0){
  	        	   eanaddcol(\'EAN\');
  	           }
  	           if(val[v].indexOf(\'ISBN\')>=0){
  	        	   eanaddcol(\'ISBN\');
  	           }
  	           if(val[v].indexOf(\'UPC\')>=0){
  	        	   eanaddcol(\'UPC\');
  	           }
  		}
  }
  //增加属性ean等
  function eanaddcol(name)
  {
  	var table = document.getElementById("variation_table");
  	var oth=document.createElement(\'th\');
  	oth.innerHTML="<input type=\'text\'name=\'nvl_name[]\'  value=\'"+name+"\' /><img src=\'/link/img/action/delete.png\' style=\'cursor: pointer;\' name=\'deletecol\' onclick=\'deleteCol(this)\'>";
  	var length=table.rows[0].childNodes.length;
  	table.rows[0].insertBefore(oth,table.rows[0].childNodes[length-4]);
  	var b = new Base64();
      name=b.encode(name);
  	for(var i=1;i<table.rows.length;i++){
  		var otd=document.createElement(\'td\');
  		otd.innerHTML="<input type=\'text\' name=\'"+name+"[]\' />";
  		table.rows[i].insertBefore(otd,table.rows[i].childNodes[length-4]);
  	}
  }
  //增加列
  function addcol(obj)
  {
  	var random=Math.round((Math.random())*100000000);
  	var table = document.getElementById("variation_table");
  	var oth=document.createElement(\'th\');
  	oth.innerHTML="<input piclabelid=\'"+random+"\' type=\'text\'name=\'nvl_name[]\' onblur=\'updateattr(this)\'/><img src=\'/link/img/action/delete.png\' style=\'cursor: pointer;\' name=\'deletecol\' onclick=\'deleteCol(this)\'>";
  	var length=table.rows[0].childNodes.length;
  	table.rows[0].insertBefore(oth,table.rows[0].childNodes[length-6]);
  	//关联图片table
  	var pictable=\'<table piclabelid="\'+random+\'" class="ebay_table" name="variationimg" style="width: 100%; display: none;"><tbody>\';
  	pictable+=\'<tr><th></th><th>图片地址</th></tr>\';
  	for(var i=1;i<table.rows.length;i++){
  		var otd=document.createElement(\'td\');
  		otd.innerHTML="<input type=\'text\' />";
  		table.rows[i].insertBefore(otd,table.rows[i].childNodes[length-6]);

  		var iiiids="";
  		for(iid=0;iid<10;iid++){
  			iiiids=iiiids+Math.round(Math.random()*10);
  		}
  		var  trnum=parseInt($(\'#variation_table\').find(\'tr[uname=zhi]\').eq(i-1).find(\'.vskubox\').attr(\'id\').replace(\'variationsku\',\'\'));
  		var imgselectid="imgselect"+iiiids;
  		pictable+=\'<tr trnum="\'+trnum+\'">\'
  						+\'<th>\'
  							+\'<strong><input type="text" size="14" readonly="readonly" onblur="setnewimgvalue($(this),$(this).val())"></strong>\'
  						+\'</th>\'
  						+\'<td>\'
  							+\'<img src="" style="width:50px;height:50px;"/>\'
  							+\'<input id="\'+imgselectid+\'" size="140" class="property_pic" onblur="imgurl_input_blur(this)" name="imgselect" value="" type="text"/>\'
  							+\'<label class="main_pic"></label><input onclick="selectPicture(\\\'\'+imgselectid+\'\\\')" iid="xuantu" value="选择图片" type="button"/>\'
  							+\'<input onclick="bdupload(this)" value="本地上传图片" type="button"/><input value="添加图片" onclick="addimgurl(this)" type="button"/>\'
  						+\'</td>\'
  				  +\'</tr>\';
  	}
  	pictable+="</tbody></table>";
  	//增加属性后 还需要增该属性对应的图片选项
  	var countlabel=$(\'#variation_table\').find(\'tr\').eq(0).children(\'th\').length-5;
  	$(\'#pic_and_attribute\').children(\'label:last\').before(\'<label><input id="\'+random+\'" name="variationspecificname"  value="" onclick="changename($(this),\'+countlabel+\')" type="radio"></label>\');
  	//创建关联图片table;

  	$(\'#pic_and_attribute\').children(\'table:last\').before(pictable);
  }
  //删除列
  function  deleteCol(obj){
      //获取当前td在table下tr中的index
      var index="";
      $(\'#variation_table\').find(\'tr:eq(0)\').find(\'th\').each(function (i){
          if($(this).find(\'img\').attr(\'name\')=="deletecol"){
              index=i;
          }
      });

      if(index!=""){
       //执行删除
       var pic_label_id;
       $(\'#variation_table\').find(\'tr\').each(function (e){
           if(e==0){
          	 pic_label_id=$(this).find(\'th\').eq(index).find(\'input\').attr(\'piclabelid\');
          	 $(this).find(\'th\').eq(index).remove();
           }else{
          	 $(this).find(\'td\').eq(index).remove();
           }

       });
       //删除之后  还需要把关联的图片项删除
       $(\'#\'+pic_label_id).parent().remove();
       $(\'.ebay_table[piclabelid=\'+pic_label_id+\']\').remove();
      }else{
           alert("系统错误   请联系管理员");
      }
  }
  function updateattr(obj)
  {
  	var value = $(obj).val();
  	var piclabelid=$(obj).attr(\'piclabelid\');
  	//获得当前节点是在第几个input中
  	var num=0;
  	$(\'#variation_table tr:eq(0)\').find(\'input[type="text"]:visible\').each(function(i){
  		if($(this).val()==value){
  			num = i;
  		}
  	});
  	//如果为0就是没找到要报错，以免客户改错数据了
  	if(num!=0){
  		$(\'#variation_table tr:gt(0)\').each(function(){
  			 var b = new Base64();
  			 var values= b.encode(obj.value)+"[]";
  			$(this).find(\'input[type="text"]:visible\').eq(num).attr(\'name\',values);
  		});
  		//属性改掉后  需要把名称添加到图片关联选项
  		$(\'#\'+piclabelid).val(value);
  		$(\'#\'+piclabelid).parent().html(document.getElementById(piclabelid).outerHTML+value);
  		$(\'.ebay_table[piclabelid=\'+piclabelid+\']\').find(\'tr\').eq(0).find(\'th\').eq(0).html(value);
  		//名称每变化一次   相应的关联图片相关的也需要变化一下
  		$(\'.ebay_table[piclabelid=\'+piclabelid+\']\').find(\'tr\').each(function (inum){
  			if(inum!=0){
  				trid = value.replace(/\s/g,"");
  				trid = trid.replace(/\&amp;/g,"");
  				$(this).attr(\'id\',trid+$(this).attr(\'trnum\'));
  			}
  		});
  	}else{
  		alert(\'请联系客服\');
  	}
  }
  //js 实现base64_encode()
  function Base64() {
      // private property
      _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

      // public method for encoding
      this.encode = function (input) {
          var output = "";
          var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
          var i = 0;
          input = _utf8_encode(input);
          while (i < input.length) {
              chr1 = input.charCodeAt(i++);
              chr2 = input.charCodeAt(i++);
              chr3 = input.charCodeAt(i++);
              enc1 = chr1 >> 2;
              enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
              enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
              enc4 = chr3 & 63;
              if (isNaN(chr2)) {
                  enc3 = enc4 = 64;
              } else if (isNaN(chr3)) {
                  enc4 = 64;
              }
              output = output +
              _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
              _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
          }
          return output;
      }
      // private method for UTF-8 encoding
      _utf8_encode = function (string) {
          string = string.replace(/\r\n/g,"\n");
          var utftext = "";
          for (var n = 0; n < string.length; n++) {
              var c = string.charCodeAt(n);
              if (c < 128) {
                  utftext += String.fromCharCode(c);
              } else if((c > 127) && (c < 2048)) {
                  utftext += String.fromCharCode((c >> 6) | 192);
                  utftext += String.fromCharCode((c & 63) | 128);
              } else {
                  utftext += String.fromCharCode((c >> 12) | 224);
                  utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                  utftext += String.fromCharCode((c & 63) | 128);
              }

          }
          return utftext;
      }
  }
  //增加图片行
  function addimgRow(imgid)
  {
  	//vtr=$(\'#variation_table\').find(\'tr:last\').clone().find(\'input[type=text]\').val(\'\').removeAttr(\'readonly\').end();

  	$(\'table[name=variationimg]\').each(function (){
  		var trid1=$(this).find(\'tr th\').html();
  		var trid=$.trim(trid1)+imgid;
  		//缺陷 #10176 B_在线listing多属性-增加项后，图片关联属性的部分，属性不会自动填写，手动也无法填写
  		trid = trid.replace(/\s/g,"");
  		trid = trid.replace(/\&amp;/g,"");
  // 		vtr=\'<tr id="\'+trid+\'"><th><strong><input type="text" size="14" readonly="readonly" onblur="setnewimgvalue($(this),$(this).val())"></strong></th>\'+
  // 	        \'<td><input name="" id="" value="" size="150" class="property_pic"> <label class="processing_pic"></label><input type="button" value="添加图片" onclick="addimgurl(this)" value="添加图片"></td></tr>\';
  //		$(this).find(\'tr:last\').end().append(vtr);
  		var obj=$(this).find(\'tr:last\').end();
  		$.ajax({
              url:\'/index.php/muban/getpicselect\',
              type:\'post\',
              data:\'class=property_pic&size=140\',
              success:function (res){
              	obj.append(\'<tr id="\'+trid+\'"><th><strong><input type="text" size="14" readonly="readonly" onblur="setnewimgvalue($(this),$(this).val())"></strong></th><td><img src="" style="width:50px;height:50px;">\'+res+\'<input type="button" onclick="bdupload(this)" value="本地上传图片"><input type="button" value="添加图片" onclick="addimgurl(this)" value="添加图片"></td></tr>\');

               },
  		});
  	});
  	imgid++;
  }
  //删除图片行
  function delimg(id){
  	$("#"+id).remove();
  }
  //$(this).parent().parent().parent().children(\\\'td\\\').children(\\\'input\\\').val($(this).val())
  function setnewimgvalue(obj,v){
  	$(obj).parent().parent().parent().children(\'td\').children(\'input\').attr("name","picture["+v+"][]");
  	//$(obj).parent().parent().parent().children(\'td\').children(\'input\').attr("id","picture"+v);
  }

  $.each([0,1,2,3,4,5],function(i){
      $(\'#ship\'+i).change(function(){
          if(this.checked){
              $(\'#tobecost\'+i).hide();
              $(\'#tobecost\'+i*7).hide();
              $(\'#tobecost\'+i*11).hide();
              $(\'#tobecost\'+i*13).hide();
          }else{
              $(\'#tobecost\'+i).show();
              $(\'#tobecost\'+i*7).show();
              $(\'#tobecost\'+i*11).show();
              $(\'#tobecost\'+i*13).show();
          }
          }
      );})
  function inputbox_left(inputId,limitLength){
      var o=document.getElementById(inputId);
      var value=replaceBindInformation(o.value);
      left=limitLength-value.length;
      //left=limitLength-$(\'#\'+inputId).val().length;
      //left=limitLength-$(\'input[name=\'+inputId+\']\').val().length;
      $(\'#length_\'+inputId).html(left);
      if(left>=0){
          $(\'#length_\'+inputId).css({\'color\':\'green\'});
      }else{
          $(\'#length_\'+inputId).css({\'color\':\'red\'});
      }
  }

  //键盘监听，自动切换到下一行
  document.onkeydown=function(event){
  	var e = event || window.event || arguments.callee.caller.arguments[0];
  	//Down Arrow监听
  	if(e && e.keyCode==40){
  		var obj=e.srcElement||e.target;
  		var type=$(obj).parent().parent().next().get(0).tagName;
  		if(type==\'TR\'){
  			$(obj).blur();
  			var inputname=$(obj).attr(\'name\');
  			var nexttr=$(obj).parent().parent().next();
  			var nextinput=nexttr.find(\'input[name^=\'+inputname.substring(0,inputname.length-2)+\']\');
  			nextinput.focus();
  		}
  	}
  	//Up Arrow监听
  	if(e && e.keyCode==38){
  		var obj=e.srcElement;
  		var type=$(obj).parent().parent().prev().prev().get(0).tagName;
  		if(type==\'TR\'){
  			$(obj).blur();
  			var inputname=$(obj).attr(\'name\');
  			var prevtr=$(obj).parent().parent().prev();
  			var previnput=prevtr.find(\'input[name^=\'+inputname.substring(0,inputname.length-2)+\']\');
  			previnput.focus();
  		}
  	}
  }

  function Addimgurl_input(src)
  {
    if (typeof(src) == \'undefined\')
    {
      src = \'\';
    }
    var iiiids="";
    for(i=0;i<10;i++){
      iiiids=iiiids+Math.round(Math.random()*10);
    }
    var ress =\'<input type="text" id="imgss__\'+iiiids+\'" size="77" onblur="imgurl_input_blur(this)" class="mainpic"   name="imgurl[]" value="\'+src+\'">\';
    $(\'#div_imgurl_input\').append("<div class=\'movebox\'><img src=\'"+src+"\' width=\'50\' height=\'50\'>"+ress+"<input type=\'button\' value=\'删除此图片\' onclick=\'javascript:$(this).parent().empty();return false;\' ></div>");
  }

  </script>
  <input id="submit" name="submit" value="OPEN" type="submit" style="width:100px;height:30px;">
  <select name="mubanid" id="mubanid" style="width:150px;height:30px;">
  				<optgroup label="TH">
          <option value="250770">TH-150%LF</option>
          <option value="275097">TH-360plus</option>
          <option value="359041">TH-141618LF-</option>
          <option value="339309">TH-LF</option>
          <option value="250722">TH-FLLF</option>
          <option value="153487">TH-SB</option>
          <option value="212308">TH-HHB</option>
          <option value="154417">TH-BSLF</option>
          <option value="161605">TH-HF</option>
          <option value="173821">TH-FTS</option>
          <option value="385504">TH-DPLF</option>
          <option value="363344">TH-DLF</option>
          <option value="424914">TH-ZD</option>
          <option value="203877">TH-shaggy</option>
          <option value="478653">TH-BCW</option>
          <option value="484612">TH-CZ+HC</option>
  									</optgroup>
  				<optgroup label="AM">
          <option value="272638">AM-360plus-</option>
          <option value="401757">AM-KS</option>
          <option value="339303">AM-LFplus-</option>
          <option value="350071">AM-141618LF-</option>
          <option value="249974">AM-150%LF</option>
          <option value="265356">AM-SB-</option>
          <option value="278017">Kinky</option>
          <option value="194278">AM-FLLF</option>
          <option value="164315">AM-360LTS</option>
          <option value="209780">AM-HHB</option>
          <option value="233167">AM-BSLF</option>
          <option value="278025">Deep360</option>
          <option value="178181">AM-HF</option>
          <option value="203871">AM-MIX</option>
          <option value="363441">AM-DLF</option>
          <option value="202705">AM-shaggy</option>
          <option value="237543">AM-HHF</option>
          <option value="424873">AM-CZ+HC</option>
  								</optgroup>
  				<optgroup label="HTA">
          <option value="257523">HT-4*4</option>
          <option value="264345">HT-kinky</option>
          <option value="237487">HT-HHF</option>
          <option value="256479">HT-150-</option>
          <option value="273722">HT-SB</option>
          <option value="230192">HT-HHB</option>
          <option value="229982">HT-LOOSE</option>
          <option value="229932">HT-YAKI</option>
          <option value="227820">HT-360</option>
          <option value="227768">HT-SB</option>
          <option value="231347">HT-BSLF</option>
          <option value="270583">HT-MIX</option>
          <option value="278737">HT-360LTScurly-</option>
          <option value="290465">HT-FLLF-</option>
          <option value="238942">HT-FTS-</option>
          <option value="238845">HT-Shaggy</option>
          <option value="295697">HT-DLF</option>
          <option value="300226">HT-P-</option>
          <option value="300385">HT-BOB</option>
          <option value="273757">HT-HF-</option>
          <option value="327965">HT-NFW-</option>
          <option value="401286">HT-ZD+CZ</option>
          <option value="408963">HT-ZD</option>
          <option value="377819">HT-TW013</option>
          <option value="377824">HT-TW015</option>
          <option value="424799">HT-CZ+HC-</option>

  								</optgroup>
  				<optgroup label="UCB">
          <option value="259286">UCB-BSLF</option>
          <option value="195411">UCB-THT</option>
          <option value="192059">UCB-THMD</option>
          <option value="220696">UCB-THC</option>
          <option value="181199">UCB-THV</option>
          <option value="354857">UCB-TH-BD</option>
          <option value="195436">UCB-THE</option>
          <option value="195404">UCB-THSL</option>
          <option value="195424">UCB-TH2</option>
          <option value="278424">Deep</option>
          <option value="262801">UCB-VS</option>
          <option value="218140">UCB-LF</option>
          <option value="288775">UCB-8tress</option>
          <option value="393112">UCB-BLF</option>
          <option value="393080">UCB-DLF</option>
          <option value="393042">UCB-SLF</option>
  								</optgroup>

  			</select>

        <select id="ebaysellerid" name="ebaysellerid" style="width:150px;height:30px;">
        <option value="anothermart">anothermart</option>
        <option value="tracy.hair">tracy.hair</option>
        <option value="us.city-boutique">us.city-boutique</option>
        <option value="hair_trends">hair_trends</option>
        </select>

  <input id="submit" name="submit" value="Edit Muban" type="submit" style="width:100px;height:30px;">
  </form>';
  echo html_return($html_content,$html_meun,$web_password);
}else if($_GET["action"]=="clear_zero"){

  if($_COOKIE["password"] == $web_password){
      $html_meun = $html_meun.$html_meun_lock;
  }
    $html_meun = str_replace('"type_clear_zero"','"type_clear_zero" '.$html_active, $html_meun);

function cz($db_web,$web_password){
  //creating new table
  $creat_sql = "CREATE TABLE "."over_zero
  (
  itemid varchar(255),
  sku varchar(255),
  quantity varchar(255),
  startprice varchar(255),
  status varchar(255)
  )";
  $del_sql = "DROP table "."over_zero";

  try {
      $db_web->query($creat_sql);
      $return .=  '</br>Creat success';
  } catch (Exception $e) {
    if($_POST["clean"]){
      $db_web->query($del_sql);
      $db_web->query($creat_sql);
    }
  }

  $return =  '
  <iframe style="width:100%;height:80%;" class="search-wrapper card" src="over_zero.php">
  </iframe>
  <table>
  <tbody>
  <tr>
  <td>
  <form action="" method="post" enctype="multipart/form-data">
  <input name="file" id="file" accept="" type="file" style="width:200" class="waves-light blue">
  ';
if($_COOKIE["password"] == $web_password){
  $return .= '
  <input id="clean" name="clean" value="checked" type="checkbox" style="width:20px;height:20px;">
  <label id="clean_lable" name="clean_lable" for="clean" class="">clean all</label>
  ';
}
  $return .= '
  <input value="upload" type="submit" class="btn-large waves-effect waves-light blue">
  <div style = "text-align:right;">
  ';
if($_COOKIE["password"] == $web_password){
  $return .= '<input id="clean_success" name="clean_success" value="clean success" type="submit" class="btn-large waves-effect waves-light blue" align="center">';
}
  $return .='
  </td>
  </tr>
  </tbody>
  </table>
  </div>
  </form>
  ';

  $stmt = $db_web->query('select * from over_zero'); //返回一个PDOStatement对象
  //$row = $stmt->fetch(); //从结果集中获取下一行，用于while循环
  $rows = $stmt->fetchAll(); //获取所有
  $row_count = $stmt->rowCount(); //记录数，2

  $tmp = $_FILES['file']['tmp_name'];
  if($_POST["clean_success"]){

    for( $i= 0; $i < $row_count; $i++ ){

      if($rows[$i]["status"] == "Success"){
        $sql_delete_success = "delete from over_zero where "."sku='".$rows[$i]["sku"]."'"." and itemid='".$rows[$i]["itemid"]."'";
        $db_web->query($sql_delete_success);
      }

    }

  }

  if (!empty ($tmp)) {
  mkdir("xls",0777,true);
  $save_path = "xls/";
  $file_name = $save_path."over_zero".date('Ymd-h-i:s-').$_FILES['file']['name'];

  if (copy($tmp, $file_name)) {
    $extension = strtolower( pathinfo($file_name, PATHINFO_EXTENSION) );
    if ($extension =='xlsx') {
        $return .=  "xlsx</br>";
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($file_name);
    } else if ($extension =='xls') {
      $return .=  "xls</br>";
      $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
      $reader->setReadDataOnly(TRUE);
      $spreadsheet = $reader->load($file_name);
    } else if ($extension=='csv') {
        $return .=  "csv</br>";
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Csv');
        $reader->setReadDataOnly(TRUE);
        //$PHPReader->setInputEncoding('GBK');
        $spreadsheet = $reader->load($file_name);
    } else {
    unlink($file_name);
    return $return .= '</br>Please upload *.xls, *.xlsx or *.csv file</br>'."The file is ".$extension;
    }
  }

  $worksheet = $spreadsheet->getActiveSheet();
  $highestRow = $worksheet->getHighestRow(); // 总行数
  $highestColumn = $worksheet->getHighestColumn(); // 总列数
  $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

  $lines = $highestRow - 2;
  if ($lines <= 0) {
      unlink($file_name);
      return $return .= '</br>empty excel file';
  }
  //creating new table end
  $sql = "INSERT INTO `over_zero` (`itemid`, `sku`, `quantity`, `startprice`) VALUES ";

  for ($row = 2; $row <= $highestRow; ++$row) {
      $itemid = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
      $sku = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
      $quantity = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
      $startprice = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

      $sql .= "('".$itemid."','".$sku."','".$quantity."','".$startprice."'),";
  }

  $sql = rtrim($sql, ","); //去掉最后一个,号

    try {
        $db_web->query($sql);
        $return .=  '</br>upload success';
      } catch (Exception $e) {
        $return .=  "</br>".$e->getMessage();
    }

    }else{
    $return .=  'Please upload excel file!';
    return $return;
    }
  return $return;
}
    echo html_return(cz($db_web,$web_password), $html_meun,$web_password);

}else if($_GET["action"] == "settings" && $_COOKIE["password"] == $web_password ){

  if($_COOKIE["password"] == $web_password){
    $html_meun = $html_meun.$html_meun_lock;
  }
  $html_meun = str_replace('"type_settings"','"type_settings" '.$html_active, $html_meun);

  function settings($db_web){

  //  $db_web->query($creat_sql);

    if($_POST["over_zero_process"] == "OFF" ){
      $bool_over_zero_process = "ON";
      $sql_bool="update settings set over_zero_process='ON'" ;
      try {
          $db_web->query($sql_bool);
        } catch (Exception $e) {
          echo $e->getMessage();
      }
    } else if($_POST["over_zero_process"] == "ON") {
      $bool_over_zero_process = "OFF";
      $sql_bool="update settings set over_zero_process='OFF'" ;
      try {
          $db_web->query($sql_bool);
        } catch (Exception $e) {
          echo $e->getMessage();
      }
    }

    $query="SELECT * FROM `settings`";//需要执行的sql语句
    $res=$db_web->prepare($query);//准备查询语句
    $res->execute();            //执行查询语句，并返回结果集

    while($result=$res->fetch(PDO::FETCH_ASSOC)){
      $over_zero_process = $result["over_zero_process"];
      $username = $result["username"];
      $password = $result["password"];
      $ibay_site = $result["ibay_site"];
    }

    if(!$over_zero_process){
      $over_zero_process = "OFF";
    }

    if($_POST["save"]){

      try {
        $db_web->query($del_sql);
        $db_web->query($creat_sql);
      } catch (Exception $e) {
        $return =  $e->getMessage();
      }

      $sql_insert = "insert into settings(ibay_site,username,password,over_zero_process) values('".$_POST["ibay_site"]."','".$_POST["username"]."','".$_POST["password"]."','".$over_zero_process."')";
      try {
        $db_web->query($sql_insert);

      } catch (Exception $e) {
        $return .=  $e->getMessage();
      }

    }

    $return .='
    <form action="" method="post">
    <table class="bordered striped highlight scrollable-table">
                      <thead>
                        <tr>
                          <th>NAME</th>
                          <th>STATUS</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span>over_zero_ing</span><br><small class="md5"></small></td>
                          <td>
                            <input id="over_zero_process" name="over_zero_process" type="submit" class="btn-large waves-effect waves-light blue" value="'.$over_zero_process.'" >
                            </div>
                            </td>
                        </tr>
                        <tr>
                          <td><span>username</span><br><small class="md5"></small></td>
                          <td>
                            <input id="username" name="username" value="'.$username.'" type="text" style="width:150px;height:30px;">
                            </div>
                            </td>
                        </tr>
                        <tr>
                          <td><span>password</span><br><small class="md5"></small></td>
                          <td>
                            <input id="password" name="password" value="'.$password.'" type="password" style="width:150px;height:30px;">
                            </div>
                            </td>
                        </tr>
                        <tr>
                          <td><span>ibay_site</span><br><small class="md5"></small></td>
                          <td>
                            <input id="ibay_site" name="ibay_site" value="'.$ibay_site.'" type="text" style="width:150px;height:30px;">
                            </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h5 class="header col s12 light"></h5>
                    <div class="row center">
                    <input id="save" name="save" type="submit" class="btn-large waves-effect waves-light blue" value="Save">
                    </div>
                    </form>
                    ';
          return $return;

  }

  echo html_return(settings($db_web), $html_meun,$web_password);

}else{

  if($_COOKIE["password"] == $web_password){
    $html_meun = $html_meun.$html_meun_lock;
  }

  echo html_return("Please Choice MEUN", $html_meun,$web_password);

}
?>
