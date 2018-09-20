<?php
if($_SERVER['DOCUMENT_ROOT']){
  $sis = explode(PHP_EOL,file_get_contents($_SERVER['DOCUMENT_ROOT']."/../mysql.key"));
}else{
  $sis = explode(PHP_EOL,file_get_contents("../../mysql.key"));
}
$sis = str_replace(array("\r\n", "\r", "\n"), '', $sis);
define('DBHOST', $sis[0]);
define('DBUSER', $sis[1]);
define('DBPWD', $sis[2]);
define('DBNAME1', $sis[3]);
define('DBNAME2', $sis[4]);
define('DBNAME3', $sis[5]);
define('DBPREFIX', 'hw_');
define('DBCHARSET', 'utf8');
define('CONN', '');
define('TIMEZONE', 'Asia/Shanghai');

try{
    $db_web = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME2, DBUSER, DBPWD);
    $db_web->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_web->query('SET NAMES utf8;');

    $query="SELECT * FROM `settings`";//需要执行的sql语句
    $res = $db_web->prepare($query);//准备查询语句
    $res->execute();            //执行查询语句，并返回结果集

    while($result=$res->fetch(PDO::FETCH_ASSOC)){
      $web_username = $result["username"];
      $web_password = $result["password"];
      $web_site = $result["ibay_site"];
    }

    if($_POST["submit"]=="setLogin")
    {
    setcookie("username",$_POST["ibyusr"], time()+3600*24*31);
    setcookie("password",$_POST["ibypwd"], time()+3600*24*31);
    echo "<html><head><title>稍候。。。</title></head>
    <body>
    <script language='javascript'>document.location = '/index.php'</script>
    </body>
    </html>";
    exit;
    }

    if($_COOKIE["password"] != $web_password && $_COOKIE["password"] != "123321"){
      echo '<form action="" method="post">
          <label>user: </label>
          <input id="ibyusr" name="ibyusr" value="" type="text" style="width:100px;height:20px;">
          <label>passwd: </label>
          <input id="ibypwd" name="ibypwd" value="" type="password" style="width:100px;height:20px;">
          <input id="submit" name="submit" value="setLogin" type="submit" style="width:70px;height:25px;">
          </form><br/>';
      exit;
    }

}catch(PDOException  $e ){
    echo '连接web数据库失败！';
    exit;
}

try{
    $db_test = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME1, DBUSER, DBPWD);
    $db_test->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_test->query('SET NAMES utf8;');

}catch(PDOException  $e ){
    echo '连接test数据库失败！';
    exit;
}

try{

    $db_varations_image = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME3, DBUSER, DBPWD);
    $db_varations_image->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_varations_image->query('SET NAMES utf8;');

}catch(PDOException  $e ){
    echo '连接varations_image数据库失败！';
    exit;
}
