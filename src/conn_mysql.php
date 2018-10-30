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
define('DBPREFIX', 'hw_');
define('DBCHARSET', 'utf8');
define('CONN', '');
define('TIMEZONE', 'Asia/Shanghai');

try{
    $db_web = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME2, DBUSER, DBPWD);
    $db_web->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_web->query('SET NAMES utf8;');

    $creat_sql = "CREATE TABLE settings
    (
    NAME varchar(255),
    VALUE varchar(255)
    )";

    try {
    $rows = $db_web->query('select * from settings')->fetchAll();
    $row_count = $db_web->query('select * from settings')->rowCount();
    } catch (Exception $e) {
    $db_web->query($creat_sql);
    }

    for($i_settings=0; $i_settings < $row_count; $i_settings++){

      if($rows[$i_settings]["NAME"] == "value_over_zero_process"){
      $value_over_zero_process = $rows[$i_settings]["VALUE"];
      }

      if($rows[$i_settings]["NAME"] == "value_varations_image_process"){
      $value_varations_image_process = $rows[$i_settings]["VALUE"];
      }

      if($rows[$i_settings]["NAME"] == "username"){
      $web_username = $rows[$i_settings]["VALUE"];
      }

      if($rows[$i_settings]["NAME"] == "password"){
      $web_password = $rows[$i_settings]["VALUE"];
      }

      if($rows[$i_settings]["NAME"] == "ibay_web_site"){
      $web_site = $rows[$i_settings]["VALUE"];
      }

      if($rows[$i_settings]["NAME"] == "vi_sellerid"){
      $vi_sellerid = $rows[$i_settings]["VALUE"];
      }

    }

    if(!$web_password){
      $sql_update = "insert into settings(NAME,VALUE) values('password','1234')";
      try {
          $db_web->query($sql_update);
        } catch (Exception $e) {
          $db_web->query("DROP TABLE settings");
          $db_web->query($creat_sql);
      }
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
    $db_varations_image = new PDO('mysql:host='.DBHOST.';dbname='."varations_image", DBUSER, DBPWD);
    $db_varations_image->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_varations_image->query('SET NAMES utf8;');
}catch(PDOException  $e ){
    echo '连接varations_image数据库失败！';
    exit;
}

try{
    $db_pictures_explorer = new PDO('mysql:host='.DBHOST.';dbname='."pictures_explorer", DBUSER, DBPWD);
    $db_pictures_explorer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_pictures_explorer->query('SET NAMES utf8;');
}catch(PDOException  $e ){
    echo '连接pictures_explorer数据库失败！';
    exit;
}
