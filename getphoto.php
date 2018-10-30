<?php
set_time_limit(0);
$count1 = 0;
  $bigc = 0;
for($bi = 1; $bi < 40; $bi++)
{
  if($bi == 1)
  {
    $url = "https://www.ebay.com/sch/m.html?_ssn=summersunny1688&_sop=10&_armrs=1&_from=R40&_sacat=0&_nkw=human+hair+wig&rt=nc&_ipg=200";
  }else{
    $dv = $bi - 1 ;
    $skc = $dv * 2 * 100;
    $url = "https://www.ebay.com/sch/m.html?_ssn=summersunny1688&_sop=10&_armrs=1&_from=R40&_ipg=200&_sacat=0&_nkw=human+hair+wig&_pgn=".$bi."&_skc=".$skc."&rt=nc";
  }
  //登录地址
  //模拟登录
  //login_post($url, $cookie, $post);
  $curl = curl_init();//初始化curl模块
  curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址
  curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息
  curl_setopt($curl, CURLOPT_COOKIE, "nonsession=BAQAAAWMOsvEbAAaAAAgAHFsYqh0xNTI1NzUxMDQ1eDQwMTI5NTI2MzI2NngweDJZADMABFzSUJ0sVVNBAMsAAlrxJCUyMwDKACBkVx6dM2RkNWNjZTAxNjMwYTljYzVkNGJlOTZkZmZmZjUyYma+abNcqvqfKyfJOXpSgQtiS8YwIA**");
  echo $rs = curl_exec($curl);
  //$rs = str_replace("s-l225.jpg","s-l1600.jpg", $rs);
  preg_match_all("/https:\/\/i.ebayimg.com\/thumbs\/images\/(.*)\/s\-l225.jpg/iU", $rs, $matches[$bi]);
  if($matches[$bi][0] == $matches[$bi - 1][0])
  {
    curl_close($curl); //关闭curl
    break;
  }
  echo "<table>
  <tbody>";
  $ph = 1;
  echo "<tr>";
  if(count($matches[$bi][0]) == 0)
  {
    break;
  }
  for( $i=0; $i < count($matches[$bi][0]); $i++)
  {
    if($count1 >= 200)
    {
      $count1 = 0;
      break;
    }
    $count1++;
    $count2 = $count1;
    echo "<td><img src=\"".$matches[$bi][0][$i]."\" width=\"100\" height=\"100\">"."</td>";
  }
  echo "
  </tr>
  </tbody>
  </table>";
  $bigc = $bigc + $count2;
  curl_close($curl); //关闭curl
}
echo "count: ".$bigc;
?>
