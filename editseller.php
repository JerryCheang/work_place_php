<?php
include('src/conn_mysql.php');

echo '
<form name="form1" method="post" action="">
<table>
<tbody>
';
$rows = $db_web->query('select * from sellersold')->fetchAll();
$row_count = $db_web->query('select * from sellersold')->rowCount();

$i = 0;
for($i = 0;$i < $row_count;$i++)
{
 $gArra[$i] = $rows[$i]['site'];
 $gArrb[$i] = $rows[$i]['sku'];
 $gArrc[$i] = $rows[$i]['selleruserid'];
}

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

if($_POST["submit"]=="Save" && $_COOKIE["password"] == $web_password)
{

$sql = 'CREATE TABLE sellersold
(
site varchar(255),
sku varchar(255),
selleruserid varchar(255)
)';
$delsql = "DROP table sellersold";

try{

  $db_web->query($sql);

  for( $ini=0; $_POST[a.$ini] !=""; $ini++){
  $sql1 ="insert into sellersold(site,sku,selleruserid) values('".$_POST[a.$ini]."','".$_POST[b.$ini]."','".$_POST[c.$ini]."')";
  $db_web->query($sql1);
  }

  $sde1 = "创建数据记录。";
  echo "<script>
  alert('".$sde1."');location.href='".$_SERVER["HTTP_REFERER"]."';
  </script>";

} catch (Exception $e) {

  $db_web->query($delsql);
  $db_web->query($sql);

  for( $ini=0; $_POST[a.$ini] !=""; $ini++){
  $sql1 ="insert into sellersold(site,sku,selleruserid) values('".$_POST[a.$ini]."','".$_POST[b.$ini]."','".$_POST[c.$ini]."')";
  $db_web->query($sql1);
  }

  $sde2 = "替换数据记录。";
  echo "<script>
  alert('".$sde3.$sde2."');location.href='".$_SERVER["HTTP_REFERER"]."';
  </script>";
}

}
?>
