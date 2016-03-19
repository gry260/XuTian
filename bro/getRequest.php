<?php
/* summaryPage.php      written : 12/21/2015   by: Tianxing CHeng


This is the summary page of the affiliates. It allow user(s) to choose to update or add an affiliate.


This page expects the following input:
$_SESSION['sec'] - whether using http or https
$_SESSION['roles'] - roles permitted to this validated user
$_SESSION['pid'] - key of authenticated user in users table
$_SESSION['roles']['programs_admin']

Copyright 2010. The Regents of the University of California (Regents). All
Rights Reserved.

IN NO EVENT SHALL REGENTS BE LIABLE TO ANY PARTY FOR DIRECT, INDIRECT, SPECIAL,
INCIDENTAL, OR CONSEQUENTIAL DAMAGES, INCLUDING LOST PROFITS, ARISING OUT OF THE
USE OF THIS SOFTWARE AND ITS DOCUMENTATION, EVEN IF REGENTS HAS BEEN ADVISED OF
THE POSSIBILITY OF SUCH DAMAGE.

REGENTS SPECIFICALLY DISCLAIMS ANY WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.
THE SOFTWARE AND ACCOMPANYING DOCUMENTATION, IF ANY, PROVIDED HEREUNDER IS
PROVIDED "AS IS". REGENTS HAS NO OBLIGATION TO PROVIDE MAINTENANCE, SUPPORT,
UPDATES, ENHANCEMENTS, OR MODIFICATIONS.
*/
session_start();
date_default_timezone_set('America/Los_Angeles');
require_once('c_header.inc.php');
require_once('../includes/checkLoggedIn.php');
require '../includes/conn.php'; /* connect to database */
require_once '../includes/pdo-mysql-conn.php'; /* connect to database */



$_SESSION['msgs'] [] = array();
if (!empty($_SESSION['affiliate_user']) && $_SESSION['affiliate_user']['type'] == "add") {
  $types = array();
  $data = array("first_name" => $_SESSION['affiliate_user']["first_name"], "last_name" => $_SESSION["affiliate_user"]["last_name"],
    "uid" => $_SESSION["affiliate_user"]["uid"], "email" => $_SESSION["affiliate_user"]["email"], "active" => "1");
  foreach ($data as $key => $value) {
    if (stripos($key, "id"))
      $types[$key] = PDO::PARAM_INT;
    else
      $types[$key] = PDO::PARAM_STR;
  }
  $lastID = insert('SUMCDS.users', $data, $types);
  $irc_ids = array();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  if (is_array($_SESSION["affiliate_user"]['affiliate_irc_ids']) && !empty($_SESSION["affiliate_user"]['affiliate_irc_ids'])) {
    $types = array("user_id" => PDO::PARAM_INT, "irc_id" => PDO::PARAM_INT);
    foreach ($_SESSION["affiliate_user"]['affiliate_irc_ids'] as $val) {
      if (!preg_match('/^[0-9]+$/', $val)) {
        echo 'IRC ID is not valid. Please contact IT.';
        exit;
      } else {
        $data = array("user_id" => $lastID, "irc_id" => $val);
        insert('SUMMER.affiliate_users', $data, $types);
      }
    }
  } else {
    $_SESSION['msgs'][] = "Please associate aleast one affiliate to the user.";
    header("location: addAffiliate.php");
    exit;
  }
  $_SESSION['msgs'][] = 'You have inserted the users with the appropriate affiliates.';
  header("location: dispUpdateAffiliateUsers.php?user_id=" . $lastID);
  exit;
} else if (!empty($_SESSION['affiliate_user']) && $_SESSION['affiliate_user']['type'] == "update") {
  if (is_array($_POST['irc_id']) && !empty($_POST['irc_id'])) {
    $ircs = array();
    foreach ($_POST['irc_id'] as $val) {
      if (!preg_match('/^[0-9]+$/', $val)) {
        echo 'IRC ID is not valid. Please contact IT.';
        exit;
      } else {
        $ircs[] = $val;
      }
    }

    $del = array_diff($_SESSION['ircs_id'], $ircs);
    if (!empty($del)) {
      foreach ($del as $d) {
        $dd = 'delete from SUMMER.affiliate_users where user_id = :USER_ID and irc_id = :IRC_ID';
        $sth = $pdo_dbh->prepare($dd);
        $sth->bindValue(':IRC_ID', $d, PDO::PARAM_INT);
        $sth->bindValue(':USER_ID', $user_id, PDO::PARAM_INT);
        $sth->execute();
      }
    }

    $ins = array_diff($ircs, $_SESSION['ircs_id']);
    if (!empty($ins)) {
      $types = array("user_id" => PDO::PARAM_INT, "irc_id" => PDO::PARAM_INT);
      foreach ($ins as $i) {
        $sdata = array("irc_id" => $i, "user_id" => $user_id);
        insert("SUMMER.affiliate_users", $sdata, $types);
      }
    }

  } else {
    $dd = 'delete from SUMMER.affiliate_users where user_id = :USER_ID ';
    $sth = $pdo_dbh->prepare($dd);
    $sth->bindValue(':USER_ID', $user_id, PDO::PARAM_INT);
    $sth->execute();
  }

  $q = 'update SUMCDS.users set first_name= :FIRST_NAME, last_name =:LAST_NAME, uid = :UID, email = :EMAIL where id=' . $user_id;
  $sth = $pdo_dbh->prepare($q);
  $sth->bindValue(':FIRST_NAME', $data["first_name"], PDO::PARAM_STR);
  $sth->bindValue(':LAST_NAME', $data["last_name"], PDO::PARAM_STR);
  $sth->bindValue(':UID', $data["uid"], PDO::PARAM_STR);
  $sth->bindValue(':EMAIL', $data["email"], PDO::PARAM_STR);
  $sth->execute();
  $_SESSION['affiliate_user'] = array();
  $_SESSION['msgs'][] = 'User Information Updated.';
  header("location: dispUpdateAffiliateUsers.php?user_id=" . $user_id . '&irc_id=' . $irc_id);
  exit;

}


?>