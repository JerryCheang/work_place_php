<?php
require '../vendor/autoload.php';

include('conn.php');

$return =  '
<form action="" method="post" enctype="multipart/form-data">
<input name="file" id="file" accept="" type="file">
<input value="上传" type="submit">
</form>
';

$tmp = $_FILES['file']['tmp_name'];
if (empty ($tmp)) {
	$return .=  '请选择要导入的Excel文件！';
	exit;
}

$save_path = "../xls/";
$file_name = $save_path."over_zero".date('Ymdhis').$_FILES['file']['name'];

if (copy($tmp, $file_name)) {
  $extension = strtolower( pathinfo($file_name, PATHINFO_EXTENSION) );
  if ($extension =='xlsx') {
      $return .=  "xlsx</br>";
      $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
      $reader->setReadDataOnly(TRUE);
      $spreadsheet = $reader->load($file_name);
  } else if ($extension =='xls') {
    $return .=  "xls</br>";
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
    $reader->setReadDataOnly(TRUE);
    $spreadsheet = $reader->load($file_name);
  } else if ($extension=='csv') {
      $return .=  "csv</br>";
      $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Csv');
      $reader->setReadDataOnly(TRUE);
      //$PHPReader->setInputEncoding('GBK');
      $spreadsheet = $reader->load($file_name);
  } else {
  print_r($_FILES['file']);
  exit('</br>Please upload *.xls, *.xlsx or *.csv file</br>'."The file is ".$extension);
  }
}

$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow(); // 总行数
$highestColumn = $worksheet->getHighestColumn(); // 总列数
$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

$lines = $highestRow - 2;
if ($lines <= 0) {
    exit('Excel表格中没有数据');
}

//creating new table
$creat_sql = "CREATE TABLE "."over_zero
(
itemid varchar(255),
sku varchar(255),
quantity varchar(255),
startprice varchar(255),
status varchar(255)
)";
$del_sql = "DROP table "."over_zero";

try {
    $db->query($creat_sql);
    $return .=  'Creat success';
} catch (Exception $e) {
    $db->query($del_sql);
    $db->query($creat_sql);
    $return .=  $e->getMessage();
}
//creating new table end


$sql = "INSERT INTO `over_zero` (`itemid`, `sku`, `quantity`, `startprice`) VALUES ";

for ($row = 2; $row <= $highestRow; ++$row) {
    $itemid = $worksheet->getCellByColumnAndRow(1, $row)->getValue(); //姓名
    $sku = $worksheet->getCellByColumnAndRow(2, $row)->getValue(); //语文
    $quantity = $worksheet->getCellByColumnAndRow(3, $row)->getValue(); //数学
    $startprice = $worksheet->getCellByColumnAndRow(4, $row)->getValue(); //外语

    $sql .= "('$itemid','$sku','$quantity','$startprice'),";
}

$sql = rtrim($sql, ","); //去掉最后一个,号

try {
    $db->query($sql);
    $return .=  'OK';
} catch (Exception $e) {
    $return .=  $e->getMessage();
}
