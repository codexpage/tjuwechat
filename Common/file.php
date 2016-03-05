<?php

function download($url, $cookie, $file="", $timeout=60) {
	$file = empty($file) ? pathinfo($url,PATHINFO_BASENAME) : $file;
	$dir = pathinfo($file,PATHINFO_DIRNAME);
	!is_dir($dir) && @mkdir($dir,0755,true);
	$url = str_replace(" ","%20",$url);

	if(function_exists('curl_init')) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		$temp = curl_exec($ch);
		if(@file_put_contents($file, $temp) && !curl_error($ch)) {
			return $file;
		} else {
			return false;
		}
	} else {
		$opts = array(
			"http"=>array(
			"method"=>"GET",
			"header"=>"",
			"timeout"=>$timeout)
		);
		$context = stream_context_create($opts);
		if(@copy($url, $file, $context)) {
			//$http_response_header
			return $file;
		} else {
			return false;
		}
	}
}

function clear_dir($dir) {
  //先删除目录下的文件：
  $dh = opendir($dir);
  while ($file = readdir($dh)) {
    if($file != "." && $file != "..") {
      $fullpath = $dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }
 
  closedir($dh);
}

function find_empty($dir) {
	$r = array();
  //先删除目录下的文件：
  $dh = opendir($dir);
  while ($file = readdir($dh)) {
    if($file != "." && $file != "..") {
    	$fullpath = $dir."/".$file;
      	if (filesize($fullpath) <= 0){
      		array_push($r, $file);
      	}
    }
  }
 
  closedir($dh);
  return $r;
}
?>