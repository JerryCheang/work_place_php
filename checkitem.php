<?php
set_time_limit(0);
$ts = spliti('#########',$_POST["inputitem"]);
for( $i = 0 ; $i< count($ts) ; $i++ )
{
  $vari = 1;
  $fh = file_get_contents('https://www.ebay.com/itm/'.$ts[$i]);
  if(strpos($fh, "United Kingdom</div>") == true)
  {
    echo $ts[$i]."英国站<br/>";
    $vari = 0;
  }
  if(strpos($fh, "United States</div>") == true)
  {
    echo $ts[$i]."美国站<br/>";
    $vari = 0;
  }
  if( $vari == 1 )
  {
    echo $ts[$i]."其他站点<br/>";
  }
  /*
 if(strpos($fh, "Value Added Tax Number:") == true)
    {
      echo $ts[$i]."存在VAT<br/>";
    }else{
      echo "<font size=\"4px\" color=\"red\">".$ts[$i]."</font><br/>";
    }*/
}
?>
