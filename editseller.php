<?php
/*
@param $username mysql user
@param $password mysql password
@param $mainpasswd private password
*/

echo '
<form name="form1" method="post" action="">
<table>
<tbody>
';
    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "web";
    // 创建连接
    $con = mysql_connect($servername, $username, $password, $dbname);
    if(!$con){
    die('connect failed!');
    }
    mysql_select_db($dbname, $con);
    $result = mysql_query("SELECT * FROM sellersold");
    $i = 0;
    while($row = mysql_fetch_array($result))//转成数组，且返回第一条数据,当不是一个对象时候退出
    {
     $gArra[$i] = $row['site'];
     $gArrb[$i] = $row['sku'];
     $gArrc[$i] = $row['selleruserid'];
     $i++;
}
      mysql_close($con);
      echo '
      <tr><td>Site</td><td>SKU</td><td>Selleruserid</td></tr>
      <tr>
      <td><input id="a0" name="a0" value="'.$gArra[0].'"></td>
      <td><input id="b0" name="b0" value="'.$gArrb[0].'"></td>
      <td><input id="c0" name="c0" value="'.$gArrc[0].'"></td>
      </tr>';
for($si = 1; $si < $i; $si++)
{
  echo '<tr>
  <td><input id="a'.$si.'" name="a'.$si.'" value="'.$gArra[$si].'"></td>
  <td><input id="b'.$si.'" name="b'.$si.'" value="'.$gArrb[$si].'"></td>
  <td><input id="c'.$si.'" name="c'.$si.'" value="'.$gArrc[$si].'"></td>
  </tr>';
}
echo '
<tr>
<td><input id="a'.$si.'" name="a'.$si.'" value=""></td>
<td><input id="b'.$si.'" name="b'.$si.'" value=""></td>
<td><input id="c'.$si.'" name="c'.$si.'" value=""></td>
</tr>
</table>
</tbody>
<br>
<input id="submit" name="submit" value="Save" type="submit" style="width:100px;height:30px;">
</form>
';

if($_POST["submit"]=="Save" && $_COOKIE["password"]==$mainpasswd)
{
$servername = "localhost";
$username = "";
$password = "";
$dbname = "web";
// 创建连接
$conn = mysql_connect($servername, $username, $password, $dbname);
mysql_select_db($dbname, $conn);
$sql = 'CREATE TABLE sellersold
(
site varchar(255),
sku varchar(255),
selleruserid varchar(255)
)';
$delsql = "DROP table sellersold";
if(mysql_query($sql, $conn)){
  for( $ini=0; $_POST[a.$ini] !=""; $ini++)
  {
  $sql1 ="insert into sellersold(site,sku,selleruserid) values('".$_POST[a.$ini]."','".$_POST[b.$ini]."','".$_POST[c.$ini]."')";
  mysql_query($sql1, $conn);
  }
  $sde1 = "创建 ".mysql_affected_rows()." 条数据记录。";
  echo "<script>
  alert('".$sde1."');location.href='".$_SERVER["HTTP_REFERER"]."';
  </script>";
} else {
  mysql_query($delsql, $conn);
  mysql_query($sql, $conn);
  for( $ini=0; $_POST[a.$ini] !=""; $ini++)
  {
  $sql1 ="insert into sellersold(site,sku,selleruserid) values('".$_POST[a.$ini]."','".$_POST[b.$ini]."','".$_POST[c.$ini]."')";
  mysql_query($sql1, $conn);
  }
  $sde3 = "创建数据失败或替换：".mysql_error();
  $sde2 = "创建 ".mysql_affected_rows()." 条数据记录。";
  echo "<script>
  alert('".$sde3.$sde2."');location.href='".$_SERVER["HTTP_REFERER"]."';
  </script>";
}
  mysql_close($conn);
}
?>
