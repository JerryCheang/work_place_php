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

    $rows = $db_web->query('select * from settings')->fetchAll();
    $row_count = $db_web->query('select * from settings')->rowCount();

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

    }

}catch(PDOException  $e ){
    echo '连接web数据库失败！';
    exit;
}

?>
