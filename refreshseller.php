<?
set_time_limit(0);
date_default_timezone_set("Asia/Hong_Kong");
if($_GET['wd'] && $_GET['seller'] == "Search")
{
  $_GET['wd'] = str_replace("-","一",$_GET['wd']);
  $_GET['wd'] = str_replace(".","。",$_GET['wd']);
  $bigc = 0;
  $servername = "localhost";
  $username = "root";
  $password = "18818419012";
  $dbname = "seller";
  $conn = mysql_connect($servername, $username, $password, $dbname);
  mysql_select_db($dbname, $conn);
  $sql = "CREATE TABLE ".$_GET['wd']."
  (
  item varchar(255),
  date varchar(255)
  )";
  $delsql = "DROP table ".$_GET['wd']."";
  mysql_query($delsql, $conn);
  mysql_query($sql, $conn);
  mysql_close($conn);
  function inputdata($item) {
    $servername = "localhost";
    $username = "root";
    $password = "18818419012";
    $dbname = "seller";
    $conn = mysql_connect($servername, $username, $password, $dbname);
    mysql_select_db($dbname, $conn);
    $sql1 = "insert into ".$_GET['wd']."(item,date) values('".$item."','".date("Y-m-d")."')";
    mysql_query($sql1, $conn);
    mysql_close($conn);
    return $item;
  }
for($bi = 1; $bi < 40; $bi++)
{
  if($bi == 1)
  {
    $_GET['wd'] = str_replace("一","-",$_GET['wd']);
    $_GET['wd'] = str_replace("。",".",$_GET['wd']);
    $url = "https://www.ebay.com/sch/m.html?_ssn=".$_GET['wd']."&_sop=10&_armrs=1&_from=R40&_sacat=0&_nkw=human+hair+wig&rt=nc&_ipg=200";
    $_GET['wd'] = str_replace("-","一",$_GET['wd']);
    $_GET['wd'] = str_replace(".","。",$_GET['wd']);
//  $url = "https://www.ebay.co.uk/sch/m.html?_fcid=77&_ssn=".$_POST[$SWITCHS]."&_armrs=1&_clu=2&gbr=1&_from=R40&_sacat=0&_nkw=".$_POST['sch']."&rt=nc&_fcid=3";
  }else{
    $dv = $bi - 1 ;
    $skc = $dv * 2 * 100;
    $_GET['wd'] = str_replace("一","-",$_GET['wd']);
    $_GET['wd'] = str_replace("。",".",$_GET['wd']);
   $url = "https://www.ebay.com/sch/m.html?_ssn=".$_GET['wd']."&_sop=10&_armrs=1&_from=R40&_ipg=200&_sacat=0&_nkw=human+hair+wig&_pgn=".$bi."&_skc=".$skc."&rt=nc";
   $_GET['wd'] = str_replace("-","一",$_GET['wd']);
   $_GET['wd'] = str_replace(".","。",$_GET['wd']);
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
  //curl_setopt($curl, CURLOPT_COOKIE, "nonsession=BAQAAAWKns8EdAAaAAAgAHFr1nukxNTIzMzg0ODk4eDE0MjcxMjMxMzkxN3gweDJZADMABFyvRWksVVNBAMsAAlrOGPExNQDKACBkNBNpMGI1NGIzZjQxNjIwYTljYjA3NTdhYjYyZmZmNThmMTSoIJ/AO5OpnE/fwMmTVLnn6cgbsw**");
  $rs = curl_exec($curl);
  preg_match("/<form id=\"gh-f\" method=\"get\" action=\"(.*)\">/iU", $rs, $getback);
  echo $rs = str_replace($getback[1],"", $rs);
  preg_match_all("/<div class\=\"lvpic pic img left\" iid=\"(.*)\"/iU", $rs, $matches[$bi]);
  for( $i=0; $i < count($matches[$bi][0]); $i++)
  {
    inputdata($matches[$bi][1][$i]);
  }
  $bigc = $bigc + count($matches[$bi][0]);
  curl_close($curl); //关闭curl
  if(count($matches[$bi][0]) < 200)
  {
    break;
  }
}
echo "count: ".$bigc;
}else if($_GET['seller'] == "Count"){
  $servername = "localhost";
  $username = "root";
  $password = "18818419012";
  $dbname = "seller";
  // 创建连接
  $con = mysql_connect($servername, $username, $password, $dbname);
  mysql_select_db($dbname, $con);
  $result = mysql_query("SELECT * FROM ".$_GET['wd']);
  while($row = mysql_fetch_array($result))//转成数组，且返回第一条数据,当不是一个对象时候退出
  {
    $curl = curl_init();//初始化curl模块
    curl_setopt($curl, CURLOPT_URL, "https://offer.ebay.com/ws/eBayISAPI.dll?ViewBidsLogin&_trksid=p2047675.l2564&rt=nc&item=".$row['item']."&ViewBidsLogin=&__HPAB_token_text__=715931&__HPAB_token_string__=12wgEhcAAAA%3D"); // 要访问的地址
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
    //curl_setopt($curl, CURLOPT_COOKIE, "nonsession=BAQAAAWKns8EdAAaAAAgAHFr1nukxNTIzMzg0ODk4eDE0MjcxMjMxMzkxN3gweDJZADMABFyvRWksVVNBAMsAAlrOGPExNQDKACBkNBNpMGI1NGIzZjQxNjIwYTljYjA3NTdhYjYyZmZmNThmMTSoIJ/AO5OpnE/fwMmTVLnn6cgbsw**");
    $rs = curl_exec($curl);
    if(substr_count($rs , date("M-d-y",strtotime('-1 day'))) == 0)
    {
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
  }
  mysql_close($con);
  echo '
  <form name="f" id="form" action="">
  <div style="position:relative; width: 240px;height:50px;">
    <select id="sel"  style="float: right; height: 60%;width: 80%; z-index:88; position:absolute; left:10%; top:23%;" onchange="changeF();">
';
$servername = "localhost";
$username = "root";
$password = "18818419012";
$dbname = "seller";
// 创建连接
$conn = mysql_connect($servername, $username, $password, $dbname);
$result = mysql_list_tables($dbname);
while ($row = mysql_fetch_row($result)) {
  echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
mysql_close($conn);
echo '
    </select>
   <input type="text" name="wd" id="txt" value="" style="position:absolute; width:66%; height:50%; left:11%;top:25%;z-index:99; border:1px #FFF solid" />
  </div>
  <input type="submit" name="seller" value="Search" id="su" class="btn self-btn bg s_btn">
  <input type="submit" name="seller" value="Count" id="su" class="btn self-btn bg s_btn" >
  </form>

<script type="text/javascript">
    function changeF() {
      document.getElementById(\'txt\').value = document.getElementById(\'sel\').options[document.getElementById(\'sel\').selectedIndex].value;
    }
</script>
  ';
}else{
  echo '
  <form name="f" id="form" action="">
  <div style="position:relative; width: 240px;height:50px;">
    <select id="sel"  style="float: right; height: 60%;width: 80%; z-index:88; position:absolute; left:10%; top:23%;" onchange="changeF();">
';
$servername = "localhost";
$username = "root";
$password = "18818419012";
$dbname = "seller";
// 创建连接
$conn = mysql_connect($servername, $username, $password, $dbname);
$result = mysql_list_tables($dbname);
while ($row = mysql_fetch_row($result)) {
  echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
mysql_close($conn);
echo '
  </select>
  <input type="text" name="wd" id="txt" value="" style="position:absolute; width:66%; height:50%; left:11%;top:25%;z-index:99; border:1px #FFF solid" />
  </div>
  <input type="submit" name="seller" value="Search" id="su" class="btn self-btn bg s_btn">
  <input type="submit" name="seller" value="Count" id="su" class="btn self-btn bg s_btn" >
  </form>
<script type="text/javascript">
    function changeF() {
      document.getElementById(\'txt\').value = document.getElementById(\'sel\').options[document.getElementById(\'sel\').selectedIndex].value;
    }
</script>
  ';
}
?>
