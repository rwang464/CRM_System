<?php

header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:*");
header("Content-Type:text/json;charset=utf-8");
header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding, Access-Token");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// require "conn.php";

$action = $_GET['action'];

if ($action)
{
	$path = $action.'.php';
	if (file_exists($path)) {
		include_once $path;
	}
				
} 


exit();

?>