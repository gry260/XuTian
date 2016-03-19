<?php
/**
 * Created by PhpStorm.
 * User: gry260
 * Date: 2/5/2016
 * Time: 3:42 PM
 */

if ($_SERVER['SERVER_NAME'] == 'localhost') /* if localhost  */ {
  $pdo_dbport = 3306;
  $pdo_dbuser = 'root';
  $pdo_pass = '';
  $pdo_dbserver = 'localhost';
}

$conn = 'mysql:host=' . $pdo_dbserver . ';port=' . $pdo_dbport .  ';charset=utf8';

try {
  $pdo_dbh = new PDO($conn, $pdo_dbuser, $pdo_pass);
}
catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

