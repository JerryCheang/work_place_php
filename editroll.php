<?php
/*
@param $username mysql user
@param $password mysql password
@param $mainpasswd private passwork
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
    $result = mysql_query("SELECT * FROM edittable");
    GLOBAL $gArr;
    $i = 0;
    while($row = mysql_fetch_array($result))//转成数组，且返回第一条数据,当不是一个对象时候退出
    {
     $gArra[$i] = $row['r1'];
     $gArrb[$i] = $row['r2'];
     $gArrc[$i] = $row['r3'];
     $gArrd[$i] = $row['r4'];
     $i++;
}
      mysql_close($con);
echo '<tr>
<td>&nbsp&nbsp<input id="a1" name="a1" value="'.$gArra[0].'"></td>
<td>&nbsp&nbsp<input id="b1" name="b1" value="'.$gArrb[0].'"></td>
<td>&nbsp&nbsp<input id="c1" name="c1" value="'.$gArrc[0].'"></td>
<td>&nbsp&nbsp<input id="d1" name="d1" value="'.$gArrd[0].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a2" name="a2" value="'.$gArra[1].'"></td>
<td>&nbsp&nbsp<input id="b2" name="b2" value="'.$gArrb[1].'"></td>
<td>&nbsp&nbsp<input id="c2" name="c2" value="'.$gArrc[1].'"></td>
<td>&nbsp&nbsp<input id="d2" name="d2" value="'.$gArrd[1].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a3" name="a3" value="'.$gArra[2].'"></td>
<td>&nbsp&nbsp<input id="b3" name="b3" value="'.$gArrb[2].'"></td>
<td>&nbsp&nbsp<input id="c3" name="c3" value="'.$gArrc[2].'"></td>
<td>&nbsp&nbsp<input id="d3" name="d3" value="'.$gArrd[2].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a4" name="a4" value="'.$gArra[3].'"></td>
<td>&nbsp&nbsp<input id="b4" name="b4" value="'.$gArrb[3].'"></td>
<td>&nbsp&nbsp<input id="c4" name="c4" value="'.$gArrc[3].'"></td>
<td>&nbsp&nbsp<input id="d4" name="d4" value="'.$gArrd[3].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a5" name="a5" value="'.$gArra[4].'"></td>
<td>&nbsp&nbsp<input id="b5" name="b5" value="'.$gArrb[4].'"></td>
<td>&nbsp&nbsp<input id="c5" name="c5" value="'.$gArrc[4].'"></td>
<td>&nbsp&nbsp<input id="d5" name="d5" value="'.$gArrd[4].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a6" name="a6" value="'.$gArra[5].'"></td>
<td>&nbsp&nbsp<input id="b6" name="b6" value="'.$gArrb[5].'"></td>
<td>&nbsp&nbsp<input id="c6" name="c6" value="'.$gArrc[5].'"></td>
<td>&nbsp&nbsp<input id="d6" name="d6" value="'.$gArrd[5].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a7" name="a7" value="'.$gArra[6].'"></td>
<td>&nbsp&nbsp<input id="b7" name="b7" value="'.$gArrb[6].'"></td>
<td>&nbsp&nbsp<input id="c7" name="c7" value="'.$gArrc[6].'"></td>
<td>&nbsp&nbsp<input id="d7" name="d7" value="'.$gArrd[6].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a8" name="a8" value="'.$gArra[7].'"></td>
<td>&nbsp&nbsp<input id="b8" name="b8" value="'.$gArrb[7].'"></td>
<td>&nbsp&nbsp<input id="c8" name="c8" value="'.$gArrc[7].'"></td>
<td>&nbsp&nbsp<input id="d8" name="d8" value="'.$gArrd[7].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a9" name="a9" value="'.$gArra[8].'"></td>
<td>&nbsp&nbsp<input id="b9" name="b9" value="'.$gArrb[8].'"></td>
<td>&nbsp&nbsp<input id="c9" name="c9" value="'.$gArrc[8].'"></td>
<td>&nbsp&nbsp<input id="d9" name="d9" value="'.$gArrd[8].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a10" name="a10" value="'.$gArra[9].'"></td>
<td>&nbsp&nbsp<input id="b10" name="b10" value="'.$gArrb[9].'"></td>
<td>&nbsp&nbsp<input id="c10" name="c10" value="'.$gArrc[9].'"></td>
<td>&nbsp&nbsp<input id="d10" name="d10" value="'.$gArrd[9].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a11" name="a11" value="'.$gArra[10].'"></td>
<td>&nbsp&nbsp<input id="b11" name="b11" value="'.$gArrb[10].'"></td>
<td>&nbsp&nbsp<input id="c11" name="c11" value="'.$gArrc[10].'"></td>
<td>&nbsp&nbsp<input id="d11" name="d11" value="'.$gArrd[10].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a12" name="a12" value="'.$gArra[11].'"></td>
<td>&nbsp&nbsp<input id="b12" name="b12" value="'.$gArrb[11].'"></td>
<td>&nbsp&nbsp<input id="c12" name="c12" value="'.$gArrc[11].'"></td>
<td>&nbsp&nbsp<input id="d12" name="d12" value="'.$gArrd[11].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a13" name="a13" value="'.$gArra[12].'"></td>
<td>&nbsp&nbsp<input id="b13" name="b13" value="'.$gArrb[12].'"></td>
<td>&nbsp&nbsp<input id="c13" name="c13" value="'.$gArrc[12].'"></td>
<td>&nbsp&nbsp<input id="d13" name="d13" value="'.$gArrd[12].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a14" name="a14" value="'.$gArra[13].'"></td>
<td>&nbsp&nbsp<input id="b14" name="b14" value="'.$gArrb[13].'"></td>
<td>&nbsp&nbsp<input id="c14" name="c14" value="'.$gArrc[13].'"></td>
<td>&nbsp&nbsp<input id="d14" name="d14" value="'.$gArrd[13].'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a15" name="a15" value="'.$gArra[14].'"></td>
<td>&nbsp&nbsp<input id="b15" name="b15" value="'.$gArrb[14].'"></td>
<td>&nbsp&nbsp<input id="c15" name="c15" value="'.$gArrc[14].'"></td>
<td>&nbsp&nbsp<input id="d15" name="d15" value="'.$gArrd[14].'"></td>
</tr>
</table>
</tbody>
<br>
<input id="submit" name="submit" value="Save" type="submit" style="width:100px;height:30px;">
<label>name: </label>
<input id="tablename" name="tablename" value="" type="text" style="width:100px;height:30px;">
<input id="submit" name="submit" value="Delete" type="submit" style="width:100px;height:30px;">
<input id="submit" name="submit" value="Read" type="submit" style="width:100px;height:30px;">
';
$servername = "localhost";
$username = "";
$password = "";
$dbname = "test";
// 创建连接
$conn = mysql_connect($servername, $username, $password, $dbname);
$result = mysql_list_tables($dbname);
echo '<select id="listingtype" name="listingtype" style="width:100px;height:30px;" >';
while ($row = mysql_fetch_row($result)) {
  echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select>';
mysql_close($conn);

if($_POST["submit"]=="Save" && $_COOKIE["password"]==$mainpasswd)
{
$servername = "localhost";
$username = "";
$password = "";
$dbname = "test";
// 创建连接
$conn = mysql_connect($servername, $username, $password, $dbname);
mysql_select_db($dbname, $conn);
$sql = "CREATE TABLE ".$_POST[tablename]."
(
r1 varchar(255),
r2 varchar(255),
r3 varchar(255),
r4 varchar(255)
)";
$delsql = "DROP table ".$_POST[tablename];
$sql1 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a1]."','".$_POST[b1]."','".$_POST[c1]."','".$_POST[d1]."')";
  $sql2 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a2]."','".$_POST[b2]."','".$_POST[c2]."','".$_POST[d2]."')";
  $sql3 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a3]."','".$_POST[b3]."','".$_POST[c3]."','".$_POST[d3]."')";
  $sql4 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a4]."','".$_POST[b4]."','".$_POST[c4]."','".$_POST[d4]."')";
  $sql5 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a5]."','".$_POST[b5]."','".$_POST[c5]."','".$_POST[d5]."')";
  $sql6 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a6]."','".$_POST[b6]."','".$_POST[c6]."','".$_POST[d6]."')";
  $sql7 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a7]."','".$_POST[b7]."','".$_POST[c7]."','".$_POST[d7]."')";
  $sql8 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a8]."','".$_POST[b8]."','".$_POST[c8]."','".$_POST[d8]."')";
  $sql9 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a9]."','".$_POST[b9]."','".$_POST[c9]."','".$_POST[d9]."')";
  $sql10 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a10]."','".$_POST[b10]."','".$_POST[c10]."','".$_POST[d10]."')";
  $sql11 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a11]."','".$_POST[b11]."','".$_POST[c11]."','".$_POST[d11]."')";
  $sql12 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a12]."','".$_POST[b12]."','".$_POST[c12]."','".$_POST[d12]."')";
  $sql13 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a13]."','".$_POST[b13]."','".$_POST[c13]."','".$_POST[d13]."')";
  $sql14 ="insert into ".$_POST[tablename]."(r1,r2,r3,r4) values('".$_POST[a14]."','".$_POST[b14]."','".$_POST[c14]."','".$_POST[d14]."')";
if(mysql_query($sql, $conn)){
  mysql_query($sql1, $conn);
  mysql_query($sql2, $conn);
  mysql_query($sql3, $conn);
  mysql_query($sql4, $conn);
  mysql_query($sql5, $conn);
  mysql_query($sql6, $conn);
  mysql_query($sql7, $conn);
  mysql_query($sql8, $conn);
  mysql_query($sql9, $conn);
  mysql_query($sql10, $conn);
  mysql_query($sql11, $conn);
  mysql_query($sql12, $conn);
  mysql_query($sql13, $conn);
  mysql_query($sql14, $conn);
  $sde1 = "创建 ".mysql_affected_rows()." 条数据记录。";
  echo "<script>
  alert('".$sde1."');location.href='".$_SERVER["HTTP_REFERER"]."';
  </script>";
} else {
  mysql_query($delsql, $conn);
  mysql_query($sql, $conn);
  mysql_query($sql1, $conn);
  mysql_query($sql2, $conn);
  mysql_query($sql3, $conn);
  mysql_query($sql4, $conn);
  mysql_query($sql5, $conn);
  mysql_query($sql6, $conn);
  mysql_query($sql7, $conn);
  mysql_query($sql8, $conn);
  mysql_query($sql9, $conn);
  mysql_query($sql10, $conn);
  mysql_query($sql11, $conn);
  mysql_query($sql12, $conn);
  mysql_query($sql13, $conn);
  mysql_query($sql14, $conn);
  $sde3 = "创建数据失败或替换：".mysql_error();
  $sde2 = "创建 ".mysql_affected_rows()." 条数据记录。";
  echo "<script>
  alert('".$sde3.$sde2."');location.href='".$_SERVER["HTTP_REFERER"]."';
  </script>";
}
  mysql_close($conn);
}
if($_POST["submit"]=="Delete" && $_COOKIE["password"]==$mainpasswd)
{
$servername = "localhost";
$username = "";
$password = "";
$dbname = "test";
// 创建连接
// 创建连接
$conn = mysql_connect($servername, $username, $password, $dbname);
mysql_select_db($dbname, $conn);
$sql = "DROP table ".$_POST[listingtype];
if(mysql_query($sql, $conn)){
$sde = "删除 ".mysql_affected_rows()." 条数据记录。";
echo "<script>
alert('".$sde."');location.href='".$_SERVER["HTTP_REFERER"]."';
</script>";

} else {
echo ("删除数据失败：".mysql_error());
echo "<script>
var inputELe = document.getElementById('tab2'); //input元素
inputELe.checked = true;
</script>";
}
  mysql_close($conn);
}
if($_POST["submit"]=="Read")
{
$servername = "localhost";
$username = "";
$password = "";
$dbname = "test";
$dbname1 = "web";
// 创建连接
$con = mysql_connect($servername, $username, $password, $dbname);
if(!$con){
die('connect failed!');
}
mysql_select_db($dbname, $con);
$result = mysql_query("SELECT * FROM ".$_POST[listingtype]);
$i = 0;
while($row = mysql_fetch_array($result))//转成数组，且返回第一条数据,当不是一个对象时候退出
{
$step1[] = $row['r1'];
$step2[] = $row['r2'];
$step3[] = $row['r3'];
$step4[] = $row['r4'];
}
  mysql_close($con);
  $con1 = mysql_connect($servername, $username, $password, $dbname1);
  mysql_select_db($dbname1, $con1);
  $delsql1 = "DROP table edittable";
  $crsql1 = "CREATE TABLE edittable
  (
  r1 varchar(255),
  r2 varchar(255),
  r3 varchar(255),
  r4 varchar(255)
  )";
   mysql_query($delsql1, $con1);
   mysql_query($crsql1, $con1);
  for ($o = 0; $o <= 14;$o++ ) {
    $sql1 ="insert into edittable(r1,r2,r3,r4) values('".$step1[$o]."','".$step2[$o]."','".$step3[$o]."','".$step4[$o]."')";
    mysql_query($sql1, $con1);
  }
  mysql_close($con1);
  echo "<script>
  location.href='".$_SERVER["HTTP_REFERER"]."';
  </script>";
}

echo '
</form>
';
?>
