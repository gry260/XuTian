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


  public  static function ValidateFile($file)
  {
    /* check size of file is less than max file size. We have to do it this way
       because $_FILES[] array will be empty if a file exceeds the upload limit
       in php.ini. For the same reason put this check before the empty() checks. */

    /* First set max file size allowed for uploading. */
    if (isset($file['max_file_size']) && !empty($file['max_file_size']))
      $max_file_size = $file['max_file_size'];
    else
      $max_file_size = file_upload_max_size();


    if (isset($_SERVER['CONTENT_LENGTH'])
      && (int) $_SERVER['CONTENT_LENGTH'] > $max_file_size) {
      $msg[] = 'You cannot upload more than ' .
        round($max_file_size / 1024 / 1024, 2) . 'MB at a time.';
      return $msg;
    } /* Warn if a file wasn't selected for uploading. */
    elseif ($file['file_info']['error'] === UPLOAD_ERR_NO_FILE) {
      $msg[] = 'Please select a file to upload.';
      return $msg;
    } /* Warn if file is empty. */
    elseif (empty($file['file_info']['size'])) {
      $msg[] = 'The file you uploaded is empty.';
      return $msg;
    } /* Warn if file size isn't an integer. */
    elseif (!preg_match('/^[0-9]+$/',$file['file_info']['size'])) {
      $msg[] = 'Invalid file size.';
      return $msg;
    }

    /* Warn if file extension is in not array of allowable extensions. Allow devs
       to supply uppercase or lowercase extensions in array. */
    foreach ($file['allowed_extensions'] as $extension) {
      $allowed_extensions_lcase[] = strtolower($extension);
    }

    if (!in_array(
      strtolower(pathinfo($file['file_info']['name'], PATHINFO_EXTENSION)),
      $allowed_extensions_lcase)) {
      $m = "Please upload one of the following file types: " .
        implode(', ', $allowed_extensions_lcase) . ".";

      $msg[] = $m;
    }

    $m = self::get_file_error_msg($file['file_info']['error']);

    if ($m !== true) {
      $msg[] = $m;
    }


    if (isset($msg) && count($msg) > 0) {
      return $msg;
    } else {
      return true;
    }
  }

  /* returns an appropriate error code along with the file array.
 * The error code can be found in the error segment
 * of the file array that is created during the file upload by PHP.
 * */
  private static function get_file_error_msg($error_code)
  {
    switch ($error_code) {
      case 0:
        return true;
      case 1:
        return "The uploaded file exceeds the upload_max_filesize
      directive in php.ini.";
        break;
      case 2:
        return "The uploaded file exceeds the MAX_FILE_SIZE directive that
      was specified in the HTML form.";
        break;
      case 3:
        return "The uploaded file was only partially uploaded.";
        break;
      case 4:
        return "No file was uploaded.";
        break;
      case 6:
        return "Missing a temporary folder.";
        break;
      case 7:
        return "Unable to write the file.";
        break;
      default:
        return false;
    }
  }
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
    $q = 'select * from sand.ads where active = "1" order by id desc';
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