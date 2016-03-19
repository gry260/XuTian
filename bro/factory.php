<?php
/**
 * Created by PhpStorm.
 * User: gry260
 * Date: 2/5/2016
 * Time: 3:32 PM
 */

require_once("ads.php");
require_once("db.php");

class AdsFactory
{

  /* the error code resulting from the file upload */
  public static function UploadFile($file_upload)
  {
    if (!empty($file_upload['destination_file_path'])) {

      $pwd = getcwd();

      $path_info = pathinfo($file_upload['destination_file_path']);

      if (!empty($path_info['dirname'])) {
        $dirname = $path_info['dirname'];
      }

      if (!empty($path_info['basename'])) {
        $basename = $path_info['basename'];
      } else {
        $msg[] = 'No basename is not found.';
        return $msg;
      }

      if (strpos($dirname, '/')) {
        $directories = explode('/', $dirname);
      } else {
        $directories = null;
      }

      $path = 'vfs/';

      $path .= $dirname;

      /* create dir if it does not exist */
      if (!(self::checkNmakeDir3($path, 0774))) {
        $msg = 'Unable to create ' . $path;
        return $msg;
      }

      $destination_file_path = 'vfs/' . $file_upload['destination_file_path'];

      if (!empty($file_upload['file_content'])) {
        /*binds a named resource, specified by filename, to a stream. */
        $fHandle = fopen($destination_file_path, 'w+');
        if ($fHandle == -1) {
          $msg[] = "Problem: Could not open file handler. Please contact IT.";
          return $msg;
        }
        /*write the content to the file*/
        if (fwrite($fHandle, $file_upload['file_content']) == -1) {
          $msg[] = "Unable to write the file.";
          return $msg;
        }
        /*close file handle*/
        fclose($fHandle);
      } else {
        if (!empty($file_upload['tmp_name'])) {
          if (!empty($file_upload['seed'])) {

            require_once('mCrypt.php');

            $file_upload['file_content'] = file_get_contents(
              $file_upload['tmp_name']);

            $file_upload['file_content'] = encrypt(
              $file_upload['file_content'],
              $file_upload['seed']
            );

            /*binds a named resource, specified by filename, to a stream. */
            $fHandle = fopen($destination_file_path, 'w+');
            if ($fHandle == -1) {
              $msg[] = "Problem: Could not open file handler. Please contact IT.";
              return $msg;
            }

            if (fwrite($fHandle, $file_upload['file_content']) == -1) {
              $msg[] = "Unable to write the file.";
              return $msg;
            }
            /*close file handle*/
            fclose($fHandle);
          } else {
            if (!move_uploaded_file(
              $file_upload['tmp_name'],
              $destination_file_path
            )
            ) {
              $msg[] = "The content of file or temporary path of file is not given.";
              return $msg;
            }
          }
        } else {
          $msg[] = "The uploaded file cannot be moved without content or temp path.";
          return $msg;
        }
      }
      chdir($pwd);
      return true;
    } else {
      $msg[] = "The file path is not a directory or the file path does not exists.";
      return $msg;
    }
  }

  public static function checkNMakeDir3($path, $perm)
  {
    $dirs = explode('/', $path);
    if (empty($dirs)) {
      return false;
    }

    if (!is_dir("vfs/" . $dirs[1])) { /* create dir if do not exist */
      if (!mkdir("vfs/" . $dirs[1], $perm)) /* mkdir failed, return false */ {
        return false;
      }
    }

    return true; /* no errors, return true */
  }

  public static function insert($table, $data, $types)
  {
    if (empty($data))
      return false;

    global $pdo_dbh;

    $q = ' insert into ' . $table . '(';
    $q2 = '';

    foreach ($data as $key => $value) {
      $q .= $key . ', ';
      $q2 .= ':' . strtoupper($key) . ', ';
    }

    $q = substr_replace($q, "", -2) . ')values(';
    $q2 = substr_replace($q2, "", -2) . ');';
    $q .= $q2;

    $sth = $pdo_dbh->prepare($q);

    foreach ($data as $key => $value) {
      $sth->bindValue(':' . strtoupper($key), $value, $types[$key]);
    }

    $sth->execute();
    if (!$sth) {
      echo $pdo_dbh->errorInfo();
      exit;
      return false;
    }
    return $pdo_dbh->lastInsertId();
  }


  public static function fetchAllAds()
  {
    global $pdo_dbh;
    $q = 'select * from sand.ads order by id desc';
    $sth = $pdo_dbh->prepare($q);
    $sth->execute();
    $count = $sth->rowCount();
    if ($count > 0) {
      $res = array();
      for ($i = 0; $i < $count; $i++) {
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $obj = new ads($result["id"], $result["title"], $result["description"], $result["register_datetime"], $result["total_clicks"], $result["url"], $result["user_id"], $result["file_name"]);
        $res[] = $obj;
      }
      return $res;
    } else
      return false;
  }
}

$q = 'update sand.total_web_clicks
  set total_clicks = total_clicks + 1
  where id = 1';
$sth = $pdo_dbh->prepare($q);
$sth->execute();

$objs = AdsFactory::fetchAllAds();

$q = 'SELECT * FROM sand.total_web_clicks';
$sth = $pdo_dbh->prepare($q);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);
ads::totalVisitingtime($result["total_clicks"]);

$totalclicks = ads::getTotalClick() + $result["total_clicks"];


?>