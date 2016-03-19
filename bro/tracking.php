<?php
/**
 * Created by PhpStorm.
 * User: gry260
 * Date: 2/5/2016
 * Time: 4:47 PM
 */


if(preg_match('/^[0-9]+$/', $_GET['id'])){
  $id = $_GET['id'];
  require_once('db.php');
  $q = 'update sand.ads
  set total_clicks = total_clicks + 1
  where id = '.$id;
  $sth = $pdo_dbh->prepare($q);
  $sth->execute();
}


if(!empty($_GET['url'])){
  header('Location: '.urldecode($_GET['url']));
  exit;
}

?>