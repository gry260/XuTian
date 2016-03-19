<?php
/**
 * Created by PhpStorm.
 * User: gry260
 * Date: 3/8/2016
 * Time: 2:20 PM
 */





require_once("db.php");
require_once("factory.php");

$date = new DateTime();
$registration_time = $date->getTimestamp();

$data = array("title"=>$_POST["title"], "description"=>$_POST["description"],
  "register_datetime"=>$registration_time, "total_clicks"=>0,
  "url"=>$_POST["url"], "user_id"=>3,
  "file_name"=>$_FILES["image"]["name"]);


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