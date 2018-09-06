<?
  set_time_limit(0);
  date_default_timezone_set("Asia/Hong_Kong");
    $bigc = 0;
    $servername = "localhost";
    $username = "root";
    $password = "18818419012";
    $dbname = "web";
    $conn = mysql_connect($servername, $username, $password, $dbname);
    mysql_select_db($dbname, $conn);
    $sql = "CREATE TABLE djt2543
    (
    item varchar(255),
    date varchar(255)
    )";
    $delsql = "DROP table djt2543";
    mysql_query($delsql, $conn);
    mysql_query($sql, $conn);
    mysql_close($conn);
    function inputdata($item) {
      $servername = "localhost";
      $username = "root";
      $password = "18818419012";
      $dbname = "web";
      $conn = mysql_connect($servername, $username, $password, $dbname);
      mysql_select_db($dbname, $conn);
      $sql1 = "insert into djt2543(item,date) values('".$item."','".date("Y-m-d")."')";
      mysql_query($sql1, $conn);
      mysql_close($conn);
      return $item;
    }
  for($bi = 1; $bi < 40; $bi++)
  {
    if($bi == 1)
    {
      $url = "https://www.ebay.com/sch/m.html?_ssn=djt2543&_sop=10&_armrs=1&_from=R40&_sacat=0&_nkw=human+hair+wig&rt=nc&_ipg=200";
  //  $url = "https://www.ebay.co.uk/sch/m.html?_fcid=77&_ssn=".$_POST[$SWITCHS]."&_armrs=1&_clu=2&gbr=1&_from=R40&_sacat=0&_nkw=".$_POST['sch']."&rt=nc&_fcid=3";
    }else{
      $dv = $bi - 1 ;
      $skc = $dv * 2 * 100;
     $url = "https://www.ebay.com/sch/m.html?_ssn=djt2543&_sop=10&_armrs=1&_from=R40&_ipg=200&_sacat=0&_nkw=human+hair+wig&_pgn=".$bi."&_skc=".$skc."&rt=nc";
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
    echo $rs = curl_exec($curl);
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
?>
