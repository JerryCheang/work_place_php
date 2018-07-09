<?php
function deleteAll($path) {
    $op = dir($path);
    while(false != ($item = $op->read())) {
        if($item == '.' || $item == '..') {
            continue;
        }
        if(is_dir($op->path.'/'.$item)) {
            deleteAll($op->path.'/'.$item);
            rmdir($op->path.'/'.$item);
        } else {
            unlink($op->path.'/'.$item);
        }
    }
}

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
}else{
//header("content-type: image/jpg");
require_once "random_compat/lib/random.php";
if($_POST["picture"])
{
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

  mkdir('./download/picture/'.$_POST["picture"]);
  deleteAll('./download/picture/'.$_POST["picture"]);
  //左count
  $arr0 = scandir('./pictures/'.$_POST["picture"].'/'.$_POST["layout"].'/left');
  $jpg_count_left = count(preg_grep("/\.jpg$/", $arr0));

  //右count
  $arr1 = scandir('./pictures/'.$_POST["picture"].'/'.$_POST["layout"].'/right');
  $jpg_count_right = count(preg_grep("/\.jpg$/", $arr1));

  echo '<div id="container">
  	<h1>随机图像选取生成</h1>
  	<p class=\'lead\'></p>
  	<div class="picker">
    <form action="./upload.php" method="post">
  	<select id="pic[]" name="pic[]" multiple="multiple" class="image-picker" style="display:none">';
  for($i=0;$i<12;$i++)
  {
  // 图片左一
  $path_1 = './pictures/'.$_POST["picture"].'/'.$_POST["layout"].'/left/'.random_int(1,$jpg_count_left).'.jpg';
  $image_1 = imagecreatefromjpeg($path_1);

  // 图片右一
  $p2 = random_int(1,$jpg_count_right);
  $path_2 = './pictures/'.$_POST["picture"].'/'.$_POST["layout"].'/right/'.$p2.'.jpg';
  $image_2 = imagecreatefromjpeg($path_2);

  if($_POST["layout"] == "1L3R" || $_POST["layout"] == "1L2R")
  {
    // 图片右二
    $p3 = random_int(1,$jpg_count_right);
    while( $p2 == $p3)
    {
    $p3 = random_int(1,$jpg_count_right);
    }
    $path_3 = './pictures/'.$_POST["picture"].'/'.$_POST["layout"].'/right/'.$p3.'.jpg';
    $image_3 = imagecreatefromjpeg($path_3);

    if($_POST["layout"] == "1L3R")
    {
      // 图片右三
      $p4 = random_int(1,$jpg_count_right);
      while( $p4 == $p3 || $p4 == $p2)
      {
      $p4 = random_int(1,$jpg_count_right);
      }
      $path_4 = './pictures/'.$_POST["picture"].'/'.$_POST["layout"].'/right/'.$p4.'.jpg';
      $image_4 = imagecreatefromjpeg($path_4);
    }

  }

  //生成 1000*1000
  $background = imagecreatetruecolor(1000, 1000);
  $white = imagecolorallocate($background, 255, 255, 255);
  imagefill($background, 0, 0, $white);

  // 合成图片
  if($_POST["layout"] == "1L3R")
  {
  imagecopymerge($background, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), 100);
  imagecopymerge($background, $image_2, 559, 0, 0, 0, imagesx($image_2), imagesy($image_2), 100);
  imagecopymerge($background, $image_3, 559, 333, 0, 0, imagesx($image_3), imagesy($image_3), 100);
  imagecopymerge($background, $image_4, 559, 666, 0, 0, imagesx($image_4), imagesy($image_4), 100);
  }
  if($_POST["layout"] == "1L2R")
  {
  imagecopymerge($background, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), 100);
  imagecopymerge($background, $image_2, 618, 0, 0, 0, imagesx($image_2), imagesy($image_2), 100);
  imagecopymerge($background, $image_3, 618, 500, 0, 0, imagesx($image_3), imagesy($image_3), 100);
  }
  if($_POST["layout"] == "1L1R")
  {
  imagecopymerge($background, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), 100);
  imagecopymerge($background, $image_2, 500, 0, 0, 0, imagesx($image_2), imagesy($image_2), 100);
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
  mkdir('./download/picture/'.$_POST["picture"]);
  imagejpeg($background, './download/picture/'.$_POST["picture"].'/'.$i.'.jpg', 85);
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
  <img src="./download/picture/1L3R.jpg" width="178">&nbsp
  <img src="./download/picture/1L2R.jpg" width="178">&nbsp
  <img src="./download/picture/1L1R.jpg" width="178">
  </tr>
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
  <option value="1L3R" checked>1L3R</option>
  <option value="1L2R">1L2R</option>
  <option value="1L1R">1L1R</option>
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
}
?>
