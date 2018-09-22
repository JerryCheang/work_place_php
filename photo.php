<?php
require_once "../vendor/paragonie/random_compat/lib/random.php";

function compressDir($dir, $zip, $prev='.')
{
    $handler = opendir($dir);
    $basename = basename($dir);
    $zip->addEmptyDir($prev . '/' . $basename);
    while($file = readdir($handler))
    {
        $realpath = $dir . '/' . $file;
        if(is_dir($realpath))
        {
            if($file !== '.' && $file !== '..')
            {
                $zip->addEmptyDir($prev . '/' . $basename . '/' . $file);
                compressDir($realpath, $zip, $prev . '/' . $basename);
            }
        }else
        {
            $zip->addFile($realpath, $prev. '/' . $basename . '/' . $file);
        }
    }

    closedir($handler);
    return null;
}

function layout_image_count($count,$side){

  $arr = scandir('./pictures/'.$_POST["picture"].'/'.$_POST["layout"].'/'.$side);
  $jpg_files_count = count(preg_grep("/\.jpg$/", $arr));

  for($i = 1; $i <= $count; $i++){
    $pic_count[$i] = random_int(1,$jpg_files_count);

    while( array_search($pic_count[$i],$pic_count,true) != $i){
      $pic_count[$i] = random_int(1,$jpg_files_count);
  }

    unset($pic_path);
    $pic_path = './pictures/'.$_POST["picture"].'/'.$_POST["layout"].'/'.$side.'/'.$pic_count[$i].'.jpg';
    $pic_image[$i] = imagecreatefromjpeg($pic_path);
  }

  print_r($pic_count);
  unset($pic_count);
  return $pic_image;

}

if($_POST["submit"] == "download")
{
$zip = new ZipArchive();
$res = $zip->open(''.$_POST["picture_name"].date("Ymd",strtotime("0 day")).'.zip', ZipArchive::OVERWRITE | ZipArchive::CREATE);
if($res)
{
    compressDir($_POST["picture_path"], $zip);
    $zip->close();
}

header('Content-Type:text/html;charset=utf-8');
header('Content-disposition:attachment;filename='.$_POST["picture_name"].date("Ymd",strtotime("0 day")).'.zip');
$filesize = filesize('./'.$_POST["picture_name"].date("Ymd",strtotime("0 day")).'.zip');
readfile('./'.$_POST["picture_name"].date("Ymd",strtotime("0 day")).'.zip');
header('Content-length:'.$filesize);
unlink('./'.$_POST["picture_name"].date("Ymd",strtotime("0 day")).'.zip');

}else if($_POST["picture"]){
  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>随机图像选取生成</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
  <link rel="stylesheet" type="text/css" href="css/examples.css">
  </head>
  <body>';

  mkdir('./download/picture/'.$_POST["picture"],0777,true);

  echo '<div id="container">
  	<h1>随机图像选取生成</h1>
  	<p class=\'lead\'></p>
  	<div class="picker">
    <form action="./upload.php" method="post">
  	<select id="pic[]" name="pic[]" multiple="multiple" class="image-picker" style="display:none">';

  for($i=0;$i<12;$i++)
  {

  //生成 1000*1000
  $background = imagecreatetruecolor(1000, 1000);
  $white = imagecolorallocate($background, 255, 255, 255);
  imagefill($background, 0, 0, $white);
  // 合成图片

  if(strstr($_POST["layout"],"1L3R") == true)
  {
    $layout_left_pic = layout_image_count(1,"left");
    $layout_right_pic = layout_image_count(3,"right");
    //left
    imagecopymerge($background, $layout_left_pic[1], 0, 0, 0, 0, imagesx($layout_left_pic[1]), imagesy($layout_left_pic[1]), 100);
    //right
    imagecopymerge($background, $layout_right_pic[1], 559, 0, 0, 0, imagesx($layout_right_pic[1]), imagesy($layout_right_pic[1]), 100);
    imagecopymerge($background, $layout_right_pic[2], 559, 333, 0, 0, imagesx($layout_right_pic[2]), imagesy($layout_right_pic[2]), 100);
    imagecopymerge($background, $layout_right_pic[3], 559, 666, 0, 0, imagesx($layout_right_pic[3]), imagesy($layout_right_pic[3]), 100);

    unset($layout_left_pic);
    unset($layout_right_pic);
  }

  if(strstr($_POST["layout"],"1L2R") == true)
  {

    $layout_left_pic = layout_image_count(1,"left");
    $layout_right_pic = layout_image_count(2,"right");
    //left
    imagecopymerge($background, $layout_left_pic[1], 0, 0, 0, 0, imagesx($layout_left_pic[1]), imagesy($layout_left_pic[1]), 100);
    //right
    imagecopymerge($background, $layout_right_pic[1], 618, 0, 0, 0, imagesx($layout_right_pic[1]), imagesy($layout_right_pic[1]), 100);
    imagecopymerge($background, $layout_right_pic[2], 618, 500, 0, 0, imagesx($layout_right_pic[2]), imagesy($layout_right_pic[2]), 100);

    unset($layout_left_pic);
    unset($layout_right_pic);

  }

  if(strstr($_POST["layout"],"1L1R") == true)
  {

    $layout_left_pic = layout_image_count(1,"left");
    $layout_right_pic = layout_image_count(1,"right");
    imagecopymerge($background, $layout_left_pic[1], 0, 0, 0, 0, imagesx($layout_left_pic[1]), imagesy($layout_left_pic[1]), 100);
    imagecopymerge($background, $layout_right_pic[1], 500, 0, 0, 0, imagesx($layout_right_pic[1]), imagesy($layout_right_pic[1]), 100);

    unset($layout_left_pic);
    unset($layout_right_pic);

  }

  if(strstr($_POST["layout"],"1L3X4R") == true)
  {

    $layout_left_pic = layout_image_count(1,"left");
    $layout_right_pic = layout_image_count(12,"right");
    imagecopymerge($background, $layout_left_pic[1], 0, 0, 0, 0, imagesx($layout_left_pic[1]), imagesy($layout_left_pic[1]), 100);
    imagecopymerge($background, $layout_right_pic[1], 559, 0, 0, 0, imagesx($layout_right_pic[1]), imagesy($layout_right_pic[1]), 100);
    imagecopymerge($background, $layout_right_pic[2], 706, 0, 0, 0, imagesx($layout_right_pic[2]), imagesy($layout_right_pic[2]), 100);
    imagecopymerge($background, $layout_right_pic[3], 853, 0, 0, 0, imagesx($layout_right_pic[3]), imagesy($layout_right_pic[3]), 100);

    imagecopymerge($background, $layout_right_pic[4], 559, 250, 0, 0, imagesx($layout_right_pic[4]), imagesy($layout_right_pic[4]), 100);
    imagecopymerge($background, $layout_right_pic[5], 706, 250, 0, 0, imagesx($layout_right_pic[5]), imagesy($layout_right_pic[5]), 100);
    imagecopymerge($background, $layout_right_pic[6], 853, 250, 0, 0, imagesx($layout_right_pic[6]), imagesy($layout_right_pic[6]), 100);

    imagecopymerge($background, $layout_right_pic[7], 559, 500, 0, 0, imagesx($layout_right_pic[7]), imagesy($layout_right_pic[7]), 100);
    imagecopymerge($background, $layout_right_pic[8], 706, 500, 0, 0, imagesx($layout_right_pic[8]), imagesy($layout_right_pic[8]), 100);
    imagecopymerge($background, $layout_right_pic[9], 853, 500, 0, 0, imagesx($layout_right_pic[9]), imagesy($layout_right_pic[9]), 100);

    imagecopymerge($background, $layout_right_pic[10], 559, 750, 0, 0, imagesx($layout_right_pic[10]), imagesy($layout_right_pic[10]), 100);
    imagecopymerge($background, $layout_right_pic[11], 706, 750, 0, 0, imagesx($layout_right_pic[11]), imagesy($layout_right_pic[11]), 100);
    imagecopymerge($background, $layout_right_pic[12], 853, 750, 0, 0, imagesx($layout_right_pic[12]), imagesy($layout_right_pic[12]), 100);

    unset($layout_left_pic);
    unset($layout_right_pic);

  }

  if(strstr($_POST["layout"],"4X3") == true)
  {

    $layout_right_pic = layout_image_count(12,"");
    imagecopymerge($background, $layout_right_pic[1], 0, 0, 0, 0, imagesx($layout_right_pic[1]), imagesy($layout_right_pic[1]), 100);
    imagecopymerge($background, $layout_right_pic[2], 250, 0, 0, 0, imagesx($layout_right_pic[2]), imagesy($layout_right_pic[2]), 100);
    imagecopymerge($background, $layout_right_pic[3], 500, 0, 0, 0, imagesx($layout_right_pic[3]), imagesy($layout_right_pic[3]), 100);
    imagecopymerge($background, $layout_right_pic[4], 750, 0, 0, 0, imagesx($layout_right_pic[4]), imagesy($layout_right_pic[4]), 100);

    imagecopymerge($background, $layout_right_pic[5], 0, 333, 0, 0, imagesx($layout_right_pic[5]), imagesy($layout_right_pic[5]), 100);
    imagecopymerge($background, $layout_right_pic[6], 250, 333, 0, 0, imagesx($layout_right_pic[6]), imagesy($layout_right_pic[6]), 100);
    imagecopymerge($background, $layout_right_pic[7], 500, 333, 0, 0, imagesx($layout_right_pic[7]), imagesy($layout_right_pic[7]), 100);
    imagecopymerge($background, $layout_right_pic[8], 750, 333, 0, 0, imagesx($layout_right_pic[8]), imagesy($layout_right_pic[8]), 100);

    imagecopymerge($background, $layout_right_pic[9], 0, 666, 0, 0, imagesx($layout_right_pic[9]), imagesy($layout_right_pic[9]), 100);
    imagecopymerge($background, $layout_right_pic[10], 250, 666, 0, 0, imagesx($layout_right_pic[10]), imagesy($layout_right_pic[10]), 100);
    imagecopymerge($background, $layout_right_pic[11], 500, 666, 0, 0, imagesx($layout_right_pic[11]), imagesy($layout_right_pic[11]), 100);
    imagecopymerge($background, $layout_right_pic[12], 750, 666, 0, 0, imagesx($layout_right_pic[12]), imagesy($layout_right_pic[12]), 100);

    unset($layout_right_pic);

  }

  if(strstr($_POST["layout"],"4X4") == true)
  {

    $layout_right_pic = layout_image_count(16,"");
    imagecopymerge($background, $layout_right_pic[1], 0, 0, 0, 0, imagesx($layout_right_pic[1]), imagesy($layout_right_pic[1]), 100);
    imagecopymerge($background, $layout_right_pic[2], 250, 0, 0, 0, imagesx($layout_right_pic[2]), imagesy($layout_right_pic[2]), 100);
    imagecopymerge($background, $layout_right_pic[3], 500, 0, 0, 0, imagesx($layout_right_pic[3]), imagesy($layout_right_pic[3]), 100);
    imagecopymerge($background, $layout_right_pic[4], 750, 0, 0, 0, imagesx($layout_right_pic[4]), imagesy($layout_right_pic[4]), 100);

    imagecopymerge($background, $layout_right_pic[5], 0, 250, 0, 0, imagesx($layout_right_pic[5]), imagesy($layout_right_pic[5]), 100);
    imagecopymerge($background, $layout_right_pic[6], 250, 250, 0, 0, imagesx($layout_right_pic[6]), imagesy($layout_right_pic[6]), 100);
    imagecopymerge($background, $layout_right_pic[7], 500, 250, 0, 0, imagesx($layout_right_pic[7]), imagesy($layout_right_pic[7]), 100);
    imagecopymerge($background, $layout_right_pic[8], 750, 250, 0, 0, imagesx($layout_right_pic[8]), imagesy($layout_right_pic[8]), 100);

    imagecopymerge($background, $layout_right_pic[9], 0, 500, 0, 0, imagesx($layout_right_pic[9]), imagesy($layout_right_pic[9]), 100);
    imagecopymerge($background, $layout_right_pic[10], 250, 500, 0, 0, imagesx($layout_right_pic[10]), imagesy($layout_right_pic[10]), 100);
    imagecopymerge($background, $layout_right_pic[11], 500, 500, 0, 0, imagesx($layout_right_pic[11]), imagesy($layout_right_pic[11]), 100);
    imagecopymerge($background, $layout_right_pic[12], 750, 500, 0, 0, imagesx($layout_right_pic[12]), imagesy($layout_right_pic[12]), 100);

    imagecopymerge($background, $layout_right_pic[13], 0, 750, 0, 0, imagesx($layout_right_pic[9]), imagesy($layout_right_pic[9]), 100);
    imagecopymerge($background, $layout_right_pic[14], 250, 750, 0, 0, imagesx($layout_right_pic[10]), imagesy($layout_right_pic[10]), 100);
    imagecopymerge($background, $layout_right_pic[15], 500, 750, 0, 0, imagesx($layout_right_pic[11]), imagesy($layout_right_pic[11]), 100);
    imagecopymerge($background, $layout_right_pic[16], 750, 750, 0, 0, imagesx($layout_right_pic[12]), imagesy($layout_right_pic[12]), 100);

    if( random_int(0,100) % 2 == 0 || strstr($_POST["layout"],"SIDE") == true){
      $layout_side_pic = layout_image_count(1,"../side");
      imagecopymerge($background, $layout_side_pic[1], 0, 0, 0, 0, imagesx($layout_side_pic[1]), imagesy($layout_side_pic[1]), 100);
    }

    unset($layout_right_pic);

  }

  if(strstr($_POST["layout"],"3X3") == true)
  {

    $layout_right_pic = layout_image_count(9,"");
    imagecopymerge($background, $layout_right_pic[1], 0, 0, 0, 0, imagesx($layout_right_pic[1]), imagesy($layout_right_pic[1]), 100);
    imagecopymerge($background, $layout_right_pic[2], 333, 0, 0, 0, imagesx($layout_right_pic[2]), imagesy($layout_right_pic[2]), 100);
    imagecopymerge($background, $layout_right_pic[3], 666, 0, 0, 0, imagesx($layout_right_pic[3]), imagesy($layout_right_pic[3]), 100);

    imagecopymerge($background, $layout_right_pic[4], 0, 333, 0, 0, imagesx($layout_right_pic[4]), imagesy($layout_right_pic[4]), 100);
    imagecopymerge($background, $layout_right_pic[5], 333, 333, 0, 0, imagesx($layout_right_pic[5]), imagesy($layout_right_pic[5]), 100);
    imagecopymerge($background, $layout_right_pic[6], 666, 333, 0, 0, imagesx($layout_right_pic[6]), imagesy($layout_right_pic[6]), 100);

    imagecopymerge($background, $layout_right_pic[7], 0, 666, 0, 0, imagesx($layout_right_pic[7]), imagesy($layout_right_pic[7]), 100);
    imagecopymerge($background, $layout_right_pic[8], 333, 666, 0, 0, imagesx($layout_right_pic[8]), imagesy($layout_right_pic[8]), 100);
    imagecopymerge($background, $layout_right_pic[9], 666, 666, 0, 0, imagesx($layout_right_pic[9]), imagesy($layout_right_pic[9]), 100);

    unset($layout_right_pic);

  }

  if(strstr($_POST["layout"],"4-1") == true)
  {

    $layout_4_pic = layout_image_count(12,"4");
    $layout_1_pic = layout_image_count(1,"1");

    imagecopymerge($background, $layout_4_pic[1], 0, 0, 0, 0, imagesx($layout_4_pic[1]), imagesy($layout_4_pic[1]), 100);
    imagecopymerge($background, $layout_4_pic[2], 250, 0, 0, 0, imagesx($layout_4_pic[2]), imagesy($layout_4_pic[2]), 100);
    imagecopymerge($background, $layout_4_pic[3], 500, 0, 0, 0, imagesx($layout_4_pic[3]), imagesy($layout_4_pic[3]), 100);
    imagecopymerge($background, $layout_4_pic[4], 750, 0, 0, 0, imagesx($layout_4_pic[4]), imagesy($layout_4_pic[4]), 100);

    imagecopymerge($background, $layout_4_pic[5], 0, 250, 0, 0, imagesx($layout_4_pic[5]), imagesy($layout_4_pic[5]), 100);
    imagecopymerge($background, $layout_1_pic[1], 250, 250, 0, 0, imagesx($layout_1_pic[1]), imagesy($layout_1_pic[1]), 100);
    imagecopymerge($background, $layout_4_pic[6], 750, 250, 0, 0, imagesx($layout_4_pic[6]), imagesy($layout_4_pic[6]), 100);

    imagecopymerge($background, $layout_4_pic[7], 0, 500, 0, 0, imagesx($layout_4_pic[7]), imagesy($layout_4_pic[7]), 100);
    imagecopymerge($background, $layout_4_pic[8], 750, 500, 0, 0, imagesx($layout_4_pic[8]), imagesy($layout_4_pic[8]), 100);

    imagecopymerge($background, $layout_4_pic[9], 0, 750, 0, 0, imagesx($layout_4_pic[9]), imagesy($layout_4_pic[9]), 100);
    imagecopymerge($background, $layout_4_pic[10], 250, 750, 0, 0, imagesx($layout_4_pic[10]), imagesy($layout_4_pic[10]), 100);
    imagecopymerge($background, $layout_4_pic[11], 500, 750, 0, 0, imagesx($layout_4_pic[11]), imagesy($layout_4_pic[11]), 100);
    imagecopymerge($background, $layout_4_pic[12], 750, 750, 0, 0, imagesx($layout_4_pic[12]), imagesy($layout_4_pic[12]), 100);

    unset($layout_4_pic);
    unset($layout_1_pic);

  }


  if($_POST["watermark_L"] && random_int(0,100)%2 == 0)
  {
    $font = "./corbelb.ttf";//c盘windows/fonts
    //2.填写水印内容
    $content = $_POST["watermark_L"];
    //3.设置字体的颜色rgb和透明度
    $col = imagecolorallocatealpha($background,255,255,0,15);
    //4.写入文字
    imagettftext($background,50,0,20,60,$col,$font,$content);
  }

  // 输出合成图片
  imagejpeg($background, './download/picture/'.$_POST["picture"].'/'.$i.'.jpg', 90);
  imagedestroy($background);
  echo '
  <option data-img-src="./download/picture/'.$_POST["picture"].'/'.$i.'.jpg" value="./download/picture/'.$_POST["picture"].'/'.$i.'.jpg">./download/picture/'.$_POST["picture"].'/'.$i.'.jpg</option>
  ';

  }
  echo "</select>
    <input id=\"submit\" name=\"submit\" value=\"Upload\" type=\"submit\" style=\"width:100px;height:30px;\">
    <select id=\"selleruserid\" name=\"selleruserid\" style=\"width:150px\">
    <option value=\"anothermart\">anothermart</option>
    <option value=\"tracy.hair\">tracy.hair</option>
    <option value=\"us.city-boutique\">us.city-boutique</option>
    <option value=\"hair_trends\">hair_trends</option>
    </select>
    </form>
        <input id=\"submit\" name=\"submit\" value=\"back\" type=\"submit\" onclick=\"javascript:history.back();\" style=\"width:100px;height:30px;\">
  	</div>";
  echo '<form action="" method="post">
  <input id="picture_path" name="picture_path" value="./download/picture/'.$_POST["picture"].'" hidden>
  <input id="picture_name" name="picture_name" value="'.$_POST["picture"].'" hidden>
  <input id="submit" name="submit" value="download" hidden type="submit" style="width:100px;height:30px;">
  </form>';
  echo '
  </form>
  <!--必要文件-->
  <link rel="stylesheet" type="text/css" href="css/image-picker.css">
  <script src="js/jquery.min.js" type="text/javascript"></script>
  <!--瀑布流布局插件-->
  <script src="js/jquery.masonry.min.js" type="text/javascript"></script>
  <!--图片选择器插件-->
  <script src="js/image-picker.min.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(document).ready(function(){

  	$("select.image-picker").imagepicker({
  		hide_select:false
  	});

  	$("select.image-picker.show-labels").imagepicker({
  		hide_select:false,
  		show_label:true
  	});

  	$("select.image-picker.limit_callback").imagepicker({
  		limit_reached:function(){
  			alert(\'We are full!\')
  		},hide_select:false
  	});

  	//瀑布流布局
  	var container = $("select.image-picker.masonry").next("ul.thumbnails");

  	container.imagesLoaded(function(){
  		container.masonry({
  			itemSelector:"li"
  		});
  	});

  });
  </script>
  </body>
  </html>
  ';
}else{
  echo '<form action="" method="post">
  <table>
  <tbody>
  <tr>
  <td>
  <select name="picture" id="picture" style="width:150px;height:30px;">
  <option value=""></option>';
  $list=scandir("./pictures");
  for($i=2;$i<count($list);$i++)
  {
  echo "<option value=\"".$list[$i]."\">".$list[$i]."</option>";
  }
  echo '</select>
  <select name="layout" id="layout" style="width:80px;height:30px;">

  <option value="1L3R">1L3R</option>
  <option value="1L2R">1L2R</option>
  <option value="1L1R">1L1R</option>

  <optgroup label="CZ_HC">
  <option value="4-1">4-1</option>
  </optgroup>

  <optgroup label="ZD,CZ_HC">
  <option value="1L3X4R_0">1L3X4R_0</option>
  </optgroup>

  <optgroup label="ZD">
  <option value="1L3X4R_1">1L3X4R_1</option>
  <option value="1L3X4R_2">1L3X4R_2</option>
  <option value="1L3X4R_3">1L3X4R_3</option>
  <option value="4X3_0">4X3_0</option>
  <option value="4X3_1">4X3_1</option>
  <option value="4X3_2">4X3_2</option>
  <option value="4X3_3">4X3_3</option>
  </optgroup>

  <optgroup label="shaggy,BOB">
  <option value="4X4_0">4X4_0</option>
  <option value="4X4_1">4X4_1</option>
  <option value="3X3_0">3X3_0</option>
  <option value="3X3_1">3X3_1</option>
  </optgroup>

  <optgroup label="BOB">
  <option value="4X4_SIDE_0">4X4_SIDE_0</option>
  <option value="4X4_SIDE_1">4X4_SIDE_1</option>
  </optgroup>

  </select>
  </td>
  </tr>
  <tr>
  <td>
  <label style="width:80px;height:30px;">watermark_L:</label>
  <input id="watermark_L" name="watermark_L" value="" type="text" style="width:150px;height:30px;">
  </td>
  </tr>
  </tbody>
  </table>
  <input id="submit" name="submit" value="submit" type="submit" style="width:80px;height:30px;">
  </form>';
}
?>
