<?php
date_default_timezone_set("Asia/Hong_Kong");
include('src/conn_mysql.php');

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
if($_COOKIE["password"] == $web_password || $_COOKIE["password"] == "123321")
{

if($_POST["transactionsolddate"])
{
$result = "SELECT * FROM "."SOLD_".$_POST["transactionsolddate"];
echo $_POST["transactionsolddate"]."<br/>";
}else{
$result = "SELECT * FROM "."SOLD_".date("Ymd",strtotime("0 day"));
echo date("Ymd",strtotime("0 day"))."<br/>";
}
$EURUSD = 1.16272512802808;
$GBPUSD = 1.285994123408423;


$rows = $db_web->query($result)->fetchAll();
$row_count = $db_web->query($result)->rowCount();

for($i = 0; $i < $row_count; $i++ )//转成数组，且返回第一条数据,当不是一个对象时候退出
{
  if($rows[$i]['selleruserid'] =="firstchoice-beauty" && $rows[$i]['site'] == 77 && $rows[$i]['sku'] == "TW")
  {
  	echo " TW ".$rows[$i]['selleruserid']." ".round($rows[$i]['total']*$EURUSD,2)."/".$rows[$i]['count']."<br/>";
  }
  if($rows[$i]['selleruserid'] =="firstchoice-beauty" && $rows[$i]['site'] == 77 && $rows[$i]['sku'] == "TH")
  {
  	echo " TH ".$rows[$i]['selleruserid']." ".round($rows[$i]['total']*$EURUSD,2)."/".$rows[$i]['count']."<br/>";
  }
  if($rows[$i]['selleruserid'] =="hairfactoryonline" && $rows[$i]['site'] == 77 && $rows[$i]['sku'] == "TW")
  {
  	echo " TW ".$rows[$i]['selleruserid']." ".round($rows[$i]['total']*$EURUSD,2)."/".$rows[$i]['count']."<br/>";
  }
  if($rows[$i]['selleruserid'] =="hairfactoryonline" && $rows[$i]['site'] == 77 && $rows[$i]['sku'] == "TH")
  {
  	echo " TH ".$rows[$i]['selleruserid']." ".round($rows[$i]['total']*$EURUSD,2)."/".$rows[$i]['count']."<br/>";
  }
  if($rows[$i]['selleruserid'] =="de_hair_mall5" && $rows[$i]['site'] == 77 && $rows[$i]['sku'] == "TW")
  {
  	echo " TW ".$rows[$i]['selleruserid']." ".round($rows[$i]['total']*$EURUSD,2)."/".$rows[$i]['count']."<br/>";
  }
  if($rows[$i]['selleruserid'] =="de_hair_mall5" && $rows[$i]['site'] == 77 && $rows[$i]['sku'] == "TH")
  {
  	echo " TH ".$rows[$i]['selleruserid']." ".round($rows[$i]['total']*$EURUSD,2)."/".$rows[$i]['count']."<br/>";
  }
  if($rows[$i]['selleruserid'] =="au_salon" && $rows[$i]['site'] == 0 && $rows[$i]['sku'] == "TH")
  {
  	echo " TH ".$rows[$i]['selleruserid']." ".round($rows[$i]['total'],2)."/".$rows[$i]['count']."<br/>";
  }
}


if($_COOKIE["password"] == $web_password)
{
  echo "<br/><br/>";

  for($i = 0; $i < $row_count; $i++ )//转成数组，且返回第一条数据,当不是一个对象时候退出
  {

   if($rows[$i]['selleruserid'] =="hair_trends" && $rows[$i]['site'] == 3 && $rows[$i]['sku'] == "TW")
   {
  	 echo " TW ".$rows[$i]['selleruserid']." ".round($rows[$i]['total']*$GBPUSD,2)." ".$rows[$i]['count']."<br/>";
   }
   if($rows[$i]['selleruserid'] =="anothermart" && $rows[$i]['site'] == 0 && $rows[$i]['sku'] == "TW")
   {
  	 echo " TW ".$rows[$i]['selleruserid']." ".round($rows[$i]['total'],2)." ".$rows[$i]['count']."<br/>";
   }
   if($rows[$i]['selleruserid'] =="tracy.hair" && $rows[$i]['site'] == 0 && $rows[$i]['sku'] == "TW")
   {
  	 echo " TW ".$rows[$i]['selleruserid']." ".round($rows[$i]['total'],2)." ".$rows[$i]['count']."<br/>";
   }
   if($rows[$i]['selleruserid'] =="us.city-boutique" && $rows[$i]['site'] == 77 && $rows[$i]['sku'] == "TW")
   {
  	 echo " TW ".$rows[$i]['selleruserid']." ".round($rows[$i]['total']*$EURUSD,2)." ".$rows[$i]['count']."<br/>";
   }
   if($rows[$i]['selleruserid'] =="us.city-boutique" && $rows[$i]['site'] == 77 && $rows[$i]['sku'] == "TH")
   {
  	 echo " TH ".$rows[$i]['selleruserid']." ".round($rows[$i]['total']*$EURUSD,2)." ".$rows[$i]['count']."<br/>";
   }

  }

}

}
?>
