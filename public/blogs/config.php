<?php 
$host = $_SERVER['HTTP_HOST'];  
$base_url = "https://" . $host . "/blogs/";

// Define constants
define('base_url', $base_url);
define('asset_url', $base_url . 'assets/');
define('upload_path', $base_url);
?>