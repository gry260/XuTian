<?php
/**
 * Created by PhpStorm.
 * User: gry260
 * Date: 3/8/2016
 * Time: 2:20 PM
 */


session_start();
require_once("db.php");
require_once("factory.php");

$date = new DateTime();
$registration_time = $date->getTimestamp();
$_SESSION['msgs'] = array();

$_SESSION['userinput']['title'] = strip_tags(urlencode($_POST['title'], ""));
if(!empty($_POST['title'])){
  $title = urlencode($_POST['title']);
}
else{
  $_SESSION['msgs'][] = 'Please provide a title.';
}

$_SESSION['userinput']['description'] = strip_tags(urlencode($_POST['description']));
if(!empty($_POST['description'])){
  $description= urlencode($_POST['description']);
}
else{
  $_SESSION['msgs'][] = 'Please provide a description.';
}


$_SESSION['userinput']['url'] = strip_tags(urlencode($_POST['url']));
if(!empty($_POST['url'])) {
  if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {
    $url = $_POST['url'];
  } else {
    $_SESSION['msgs'][] = 'Please provide a valid url.';
  }
}
else{
  $_SESSION['msgs'][] = 'Please provide an url.';
}



if(count($_SESSION['msgs']) > 0 ){
  header("Location: ./");
  exit;
}

$data = array("title"=>$title, "description"=>$description,
  "register_datetime"=>$registration_time, "total_clicks"=>0,
  "url"=>$url, "file_name"=>$_FILES["image"]["name"]);


$types = array();
foreach ($data as $key => $value) {
  if (stripos($key, "_ID"))
    $types[$key] = PDO::PARAM_INT;
  else
    $types[$key] = PDO::PARAM_STR;
}


$file_path="3/".$_FILES["image"]["name"];
$tmp_name = $_FILES["image"]["tmp_name"];
$uploads = array("destination_file_path"=>$file_path, "tmp_name"=>$tmp_name, "seed"=>false);
$r = AdsFactory::UploadFile($uploads);
AdsFactory::insert("sand.ads", $data, $types);
header("location:index.php");
exit;



?>