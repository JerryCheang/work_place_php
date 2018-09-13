<?php
include('src/conn_mysql.php');

echo '
<form name="form1" method="post" action="">
<table>
<tbody>
';
if($_POST['listingtype']){
$rows = $db_test->query('select * from '.$_POST['listingtype'])->fetchAll();

echo '<tr>
<td>&nbsp&nbsp<input id="a1" name="a1" value="'.htmlspecialchars($rows[0]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b1" name="b1" value="'.htmlspecialchars($rows[0]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c1" name="c1" value="'.htmlspecialchars($rows[0]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d1" name="d1" value="'.htmlspecialchars($rows[0]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a2" name="a2" value="'.htmlspecialchars($rows[1]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b2" name="b2" value="'.htmlspecialchars($rows[1]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c2" name="c2" value="'.htmlspecialchars($rows[1]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d2" name="d2" value="'.htmlspecialchars($rows[1]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a3" name="a3" value="'.htmlspecialchars($rows[2]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b3" name="b3" value="'.htmlspecialchars($rows[2]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c3" name="c3" value="'.htmlspecialchars($rows[2]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d3" name="d3" value="'.htmlspecialchars($rows[2]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a4" name="a4" value="'.htmlspecialchars($rows[3]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b4" name="b4" value="'.htmlspecialchars($rows[3]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c4" name="c4" value="'.htmlspecialchars($rows[3]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d4" name="d4" value="'.htmlspecialchars($rows[3]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a5" name="a5" value="'.htmlspecialchars($rows[4]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b5" name="b5" value="'.htmlspecialchars($rows[4]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c5" name="c5" value="'.htmlspecialchars($rows[4]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d5" name="d5" value="'.htmlspecialchars($rows[4]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a6" name="a6" value="'.htmlspecialchars($rows[5]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b6" name="b6" value="'.htmlspecialchars($rows[5]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c6" name="c6" value="'.htmlspecialchars($rows[5]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d6" name="d6" value="'.htmlspecialchars($rows[5]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a7" name="a7" value="'.htmlspecialchars($rows[6]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b7" name="b7" value="'.htmlspecialchars($rows[6]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c7" name="c7" value="'.htmlspecialchars($rows[6]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d7" name="d7" value="'.htmlspecialchars($rows[6]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a8" name="a8" value="'.htmlspecialchars($rows[7]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b8" name="b8" value="'.htmlspecialchars($rows[7]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c8" name="c8" value="'.htmlspecialchars($rows[7]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d8" name="d8" value="'.htmlspecialchars($rows[7]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a9" name="a9" value="'.htmlspecialchars($rows[8]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b9" name="b9" value="'.htmlspecialchars($rows[8]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c9" name="c9" value="'.htmlspecialchars($rows[8]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d9" name="d9" value="'.htmlspecialchars($rows[8]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a10" name="a10" value="'.htmlspecialchars($rows[9]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b10" name="b10" value="'.htmlspecialchars($rows[9]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c10" name="c10" value="'.htmlspecialchars($rows[9]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d10" name="d10" value="'.htmlspecialchars($rows[9]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a11" name="a11" value="'.htmlspecialchars($rows[10]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b11" name="b11" value="'.htmlspecialchars($rows[10]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c11" name="c11" value="'.htmlspecialchars($rows[10]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d11" name="d11" value="'.htmlspecialchars($rows[10]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a12" name="a12" value="'.htmlspecialchars($rows[11]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b12" name="b12" value="'.htmlspecialchars($rows[11]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c12" name="c12" value="'.htmlspecialchars($rows[11]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d12" name="d12" value="'.htmlspecialchars($rows[11]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a13" name="a13" value="'.htmlspecialchars($rows[12]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b13" name="b13" value="'.htmlspecialchars($rows[12]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c13" name="c13" value="'.htmlspecialchars($rows[12]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d13" name="d13" value="'.htmlspecialchars($rows[12]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a14" name="a14" value="'.htmlspecialchars($rows[13]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b14" name="b14" value="'.htmlspecialchars($rows[13]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c14" name="c14" value="'.htmlspecialchars($rows[13]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d14" name="d14" value="'.htmlspecialchars($rows[13]['r4']).'"></td>
</tr>
<tr>
<td>&nbsp&nbsp<input id="a15" name="a15" value="'.htmlspecialchars($rows[14]['r1']).'"></td>
<td>&nbsp&nbsp<input id="b15" name="b15" value="'.htmlspecialchars($rows[14]['r2']).'"></td>
<td>&nbsp&nbsp<input id="c15" name="c15" value="'.htmlspecialchars($rows[14]['r3']).'"></td>
<td>&nbsp&nbsp<input id="d15" name="d15" value="'.htmlspecialchars($rows[14]['r4']).'"></td>
</tr>
</table>
</tbody>
';
}
echo '<br>
<input id="submit" name="submit" value="Save" type="submit" style="width:100px;height:30px;">
<label>name: </label>
<input id="tablename" name="tablename" value="'.$_POST["listingtype"].'" type="text" style="width:100px;height:30px;">
<input id="submit" name="submit" value="Delete" type="submit" style="width:100px;height:30px;">
<input id="submit" name="submit" value="Read" type="submit" style="width:100px;height:30px;">';
// 创建连接
$listing_type_tables = $db_test->query('show tables'); //返回一个PDOStatement对象
$rows = $listing_type_tables->fetchAll(); //获取所有
echo '<select id="listingtype" name="listingtype" >';

for( $i= 0; $i < count($rows); $i++ ){
  echo '<option value="'.$rows[$i][0].'">'.$rows[$i][0].'</option>';
}

echo '</select>';

if($_POST["submit"]=="Save" && $_COOKIE["password"] == $web_password){

  if($_POST["tablename"]){
    $postname = $_POST["tablename"];
  }else{
    $postname = $_POST["listingtype"];
  }

$sql = "CREATE TABLE ".$postname."
(
r1 varchar(255),
r2 varchar(255),
r3 varchar(255),
r4 varchar(255)
)";

$delsql = "DROP table ".$postname;
$sql1 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a1]."','".$_POST[b1]."','".$_POST[c1]."','".$_POST[d1]."')";
  $sql2 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a2]."','".$_POST[b2]."','".$_POST[c2]."','".$_POST[d2]."')";
  $sql3 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a3]."','".$_POST[b3]."','".$_POST[c3]."','".$_POST[d3]."')";
  $sql4 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a4]."','".$_POST[b4]."','".$_POST[c4]."','".$_POST[d4]."')";
  $sql5 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a5]."','".$_POST[b5]."','".$_POST[c5]."','".$_POST[d5]."')";
  $sql6 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a6]."','".$_POST[b6]."','".$_POST[c6]."','".$_POST[d6]."')";
  $sql7 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a7]."','".$_POST[b7]."','".$_POST[c7]."','".$_POST[d7]."')";
  $sql8 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a8]."','".$_POST[b8]."','".$_POST[c8]."','".$_POST[d8]."')";
  $sql9 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a9]."','".$_POST[b9]."','".$_POST[c9]."','".$_POST[d9]."')";
  $sql10 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a10]."','".$_POST[b10]."','".$_POST[c10]."','".$_POST[d10]."')";
  $sql11 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a11]."','".$_POST[b11]."','".$_POST[c11]."','".$_POST[d11]."')";
  $sql12 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a12]."','".$_POST[b12]."','".$_POST[c12]."','".$_POST[d12]."')";
  $sql13 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a13]."','".$_POST[b13]."','".$_POST[c13]."','".$_POST[d13]."')";
  $sql14 ="insert into ".$postname."(r1,r2,r3,r4) values('".$_POST[a14]."','".$_POST[b14]."','".$_POST[c14]."','".$_POST[d14]."')";

  try{
    $db_test->query($sql);
    $db_test->query($sql1);
    $db_test->query($sql2);
    $db_test->query($sql3);
    $db_test->query($sql4);
    $db_test->query($sql5);
    $db_test->query($sql6);
    $db_test->query($sql7);
    $db_test->query($sql8);
    $db_test->query($sql9);
    $db_test->query($sql10);
    $db_test->query($sql11);
    $db_test->query($sql12);
    $db_test->query($sql13);
    $db_test->query($sql14);
    $sde1 = "创建".$postname."数据记录。";
    echo "<script>
    alert('".$sde1."');location.href='".$_SERVER["HTTP_REFERER"]."';
    </script>";
  } catch (Exception $e) {
    $db_test->query($delsql);
    $db_test->query($sql);
    $db_test->query($sql1);
    $db_test->query($sql2);
    $db_test->query($sql3);
    $db_test->query($sql4);
    $db_test->query($sql5);
    $db_test->query($sql6);
    $db_test->query($sql7);
    $db_test->query($sql8);
    $db_test->query($sql9);
    $db_test->query($sql10);
    $db_test->query($sql11);
    $db_test->query($sql12);
    $db_test->query($sql13);
    $db_test->query($sql14);
    $sde2 = "替换".$postname."数据记录。";
    echo "<script>
    alert('".$sde3.$sde2."');location.href='".$_SERVER["HTTP_REFERER"]."';
    </script>";
  }
}

if($_POST["submit"]=="Delete" && $_COOKIE["password"] == $web_password)
{
$sql = "DROP table ".$_POST[listingtype];

try{
  $db_test->query($sql);
  $sde = "删除 ".$_POST[listingtype]." 数据记录。";
  echo "<script>
  alert('".$sde."');location.href='".$_SERVER["HTTP_REFERER"]."';
  </script>";
  }  catch (Exception $e) {

    echo ("删除数据失败".$_POST[listingtype]);
    echo "<script>
    var inputELe = document.getElementById('tab2'); //input元素
    inputELe.checked = true;
    </script>";
  }

}

echo '</form>';

?>
