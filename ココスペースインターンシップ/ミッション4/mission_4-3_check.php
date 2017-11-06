<?php

//function cache_test($param) { 
  include_once "Cache/Lite.php"; 
  $option = array( 
    "cacheDir" => "/tmp/", 
    "lifeTime" => 6000 
  ); 
  $cache = new Cache_Lite($option); 


//  if ($data = $cache->get($param, "cache_test")) { 
  if ($data = $cache->get(1)) { 

    echo $data; 

  } else { 
    // $str を生成するロジック 
    $str = 2;
//    $cache->save($str, $param, "cache_test"); 
    $cache->save($str,2); 

//    echo $str; 
  } 
//}

//$param = 2;

//cache_test($param);

?>
