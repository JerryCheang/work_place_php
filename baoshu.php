<?php
/*
@param $username mysql user
@param $password mysql password
@param $mainpasswd private password
@param $secondpasswd other password
*/

date_default_timezone_set("Asia/Hong_Kong");
echo ' <form action="" method="post">
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
 <input id="submit" name="submit" value="DATE" type="submit" style="width:100px;height:30px;">
 </form>';
$servername = "localhost";
$username = "";
$password = "";
$dbname = "web";
date_default_timezone_set("Asia/Hong_Kong");
// 创建连接
if($_COOKIE["password"] == $mainpasswd || $_COOKIE["password"] == $secondpasswd)
{
$con = mysql_connect($servername, $username, $password, $dbname);
if(!$con){
die('connect failed!');
}
mysql_select_db($dbname, $con);
if($_POST["transactionsolddate"])
{
$result = mysql_query("SELECT * FROM "."SOLD_".$_POST["transactionsolddate"]);
echo $_POST["transactionsolddate"]."<br/>";
}else{
$result = mysql_query("SELECT * FROM "."SOLD_".date("Ymd",strtotime("0 day")));
echo date("Ymd",strtotime("0 day"))."<br/>";
}
$EURUSD = 1.17572024142866;
$GBPUSD = 1.32742630988245;
while($row = mysql_fetch_array($result))//转成数组，且返回第一条数据,当不是一个对象时候退出
{
 if($row['selleruserid'] =="firstchoice-beauty" && $row['site'] == 77 && $row['sku'] == "TW")
 {
   echo " TW ".$row['selleruserid']." ".round($row['total']*$EURUSD,2)."/".$row['count']."<br/>";
 }
 if($row['selleruserid'] =="firstchoice-beauty" && $row['site'] == 77 && $row['sku'] == "TH")
 {
   echo " TH ".$row['selleruserid']." ".round($row['total']*$EURUSD,2)."/".$row['count']."<br/>";
 }
 if($row['selleruserid'] =="hairfactoryonline" && $row['site'] == 77 && $row['sku'] == "TW")
 {
   echo " TW ".$row['selleruserid']." ".round($row['total']*$EURUSD,2)."/".$row['count']."<br/>";
 }
 if($row['selleruserid'] =="hairfactoryonline" && $row['site'] == 77 && $row['sku'] == "TH")
 {
   echo " TH ".$row['selleruserid']." ".round($row['total']*$EURUSD,2)."/".$row['count']."<br/>";
 }
 if($row['selleruserid'] =="de_hair_mall5" && $row['site'] == 77 && $row['sku'] == "TW")
 {
   echo " TW ".$row['selleruserid']." ".round($row['total']*$EURUSD,2)."/".$row['count']."<br/>";
 }
 if($row['selleruserid'] =="de_hair_mall5" && $row['site'] == 77 && $row['sku'] == "TH")
 {
   echo " TH ".$row['selleruserid']." ".round($row['total']*$EURUSD,2)."/".$row['count']."<br/>";
 }
}
}


if($_COOKIE["password"] == $mainpasswd)
{
  echo "<br/><br/>";
  if($_POST["transactionsolddate"])
  {
  $result = mysql_query("SELECT * FROM "."SOLD_".$_POST["transactionsolddate"]);
  echo $_POST["transactionsolddate"]."<br/>";
  }else{
  $result = mysql_query("SELECT * FROM "."SOLD_".date("Ymd",strtotime("0 day")));
  echo date("Ymd",strtotime("0 day"))."<br/>";
  }
  while($row = mysql_fetch_array($result))//转成数组，且返回第一条数据,当不是一个对象时候退出
  {
   if($row['selleruserid'] =="hair_trends" && $row['site'] == 3 && $row['sku'] == "TW")
   {
     echo " TW ".$row['selleruserid']." ".round($row['total']*$GBPUSD,2)." ".$row['count']."<br/>";
   }
   if($row['selleruserid'] =="anothermart" && $row['site'] == 0 && $row['sku'] == "TW")
   {
     echo " TW ".$row['selleruserid']." ".round($row['total'],2)." ".$row['count']."<br/>";
   }
   if($row['selleruserid'] =="tracy.hair" && $row['site'] == 0 && $row['sku'] == "TW")
   {
     echo " TW ".$row['selleruserid']." ".round($row['total'],2)." ".$row['count']."<br/>";
   }
   if($row['selleruserid'] =="us.city-boutique" && $row['site'] == 77 && $row['sku'] == "TW")
   {
     echo " TW ".$row['selleruserid']." ".round($row['total']*$EURUSD,2)." ".$row['count']."<br/>";
   }
   if($row['selleruserid'] =="us.city-boutique" && $row['site'] == 77 && $row['sku'] == "TH")
   {
     echo " TH ".$row['selleruserid']." ".round($row['total']*$EURUSD,2)." ".$row['count']."<br/>";
   }
  }
}
  mysql_close($con);
?>
