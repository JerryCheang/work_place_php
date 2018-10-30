<?php
//ignore_user_abort(true);
require_once "../vendor/paragonie/random_compat/lib/random.php";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://m.hcbql.cn/submit.asp");//登录提交的地址
curl_setopt($curl, CURLOPT_HEADER, 1);//是否显示头信息
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
curl_setopt($curl, CURLOPT_POST, 1);//post方式提交

$exit_i = 0;

function random($count){

  for($i = 1 ; $i <= $count; $i++){
    $ra .= random_int(0,9);
  }
  return $ra;

}

function random1(){
  return random_int(0,9).chr(random_int(65,90));
}

while(1){
  
  if(random_int(0,100)%2 ==0){
    $shouji_n = random_int(6,8);
  }else{
    $shouji_n = 3;
  }
  
  $id_date = 0;
  $id_date = $id_date - random_int(7951,23742);
  $post = array (
    'idType' => '6',
    'cardtype' => '0',
    'hsw' => '',
    'yh' => '冥界银行',
    'yx' => '',
	  'idcard' => "62".random(17),
	  'pwd1' => random(6),
	  'idNo1' => random_int(1,9).random(5).date("Ymd",strtotime($id_date." day")).random(4),
    'shouji' => "1".$shouji_n.random(9),
    'sl' => '0'
  );
  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息
  print_r($post);
  unset($content);
  while(!$content){
    echo $content = curl_exec($curl);
    if(!$content){
      sleep(10);
      $exit_i ++;
      if($exit_i == 6000){
       mkdir('./fuck_up_end_'.date("m-d_Hi"),0777,true);
       curl_close($curl); //关闭curl
       exit;
      }
    }
  }

  if($content && !strstr($content,"lateron.asp")){
    $exit_i ++;
    if($exit_i == 10){
      mkdir('./fuck_up_end_'.date("m-d_Hi"),0777,true);
      curl_close($curl); //关闭curl
      exit;
    }
    sleep(600);
    continue;
  }else if(strstr($content,"lateron.asp")){
    $exit_i = 0;
  }

}
?>
