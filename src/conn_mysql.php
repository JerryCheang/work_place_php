<?php

$sis = explode(PHP_EOL,file_get_contents($_SERVER['DOCUMENT_ROOT']."/../mysql.key"));
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

    $query="SELECT * FROM `settings`";//需要执行的sql语句
    $res = $db_web->prepare($query);//准备查询语句
    $res->execute();            //执行查询语句，并返回结果集

    while($result=$res->fetch(PDO::FETCH_ASSOC)){
      $web_username = $result["username"];
      $web_password = $result["password"];
      $web_site = $result["ibay_site"];
    }

}catch(PDOException  $e ){
    //echo '连接web数据库失败！';
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
