<?php
/**
 * Created by PhpStorm.
 * User: gry260
 * Date: 2/5/2016
 * Time: 3:33 PM
 */

class ads
{
  private $_title;
  private $_register_time;
  private $_click;
  private static $total_click=0;
  private static $total_time=0;
  private static $total_ads=0;
  private static $total_click_time=0;
  private static $total_visiting_time=0;
  const TOTAL_T = 10000000000000;
  private $_description;
  private $_url;
  private $_user_id;
  private $_file_name;
  private $_id;

  public function __construct($id, $title, $description, $register_time, $click, $url, $user_id, $file_name)
  {
    $this->_id = $id;
    $this->_title = $title;
    $this->_register_time = $register_time;
    $this->_click= $click;
    self::$total_time += time()-$this->_register_time;
    self::$total_ads++;
    self::$total_click_time += $this->_click * 60;
    self::$total_click += $click;
    $this->_url = $url;
    $this->_user_id = $user_id;
    $this->_file_name = $file_name;
  }

  public function getURL()
  {
    return $this->_url;
  }

  public function getID()
  {
    return $this->_id;
  }

  public function getDescription()
  {
    return $this->_description;
  }

  public function getUserId()
  {
    return $this->_user_id;
  }

  public function getFileName()
  {
    return $this->_file_name;
  }

  public function getTitle()
  {
    return $this->_title;
  }

  public function getRegisterTime()
  {
    return $this->_register_time;
  }

  public static function getTotalTime()
  {
     return self::$total_time;
  }

  public static function getRemainingTime()
  {
    return self::TOTAL_T - (self::$total_time + self::$total_click_time + self::$total_visiting_time);
  }

  public static function getTotalAds()
  {
    return self::$total_ads;
  }

  public static function getTotalClickTime()
  {
    return self::$total_click_time;
  }

  public static function getTotalClick()
  {
    return self::$total_click;
  }

  public static function totalVisitingtime($total_visiting_click)
  {
    self::$total_visiting_time  =  $total_visiting_click * 60;
  }

  public function getDifferenceTime()
  {
    $nowtime = time();
    $time_elasped = $nowtime - $this->_register_time;
    $hours =  str_pad(round($time_elasped / 3600, 0), 4, '0', STR_PAD_LEFT);
    $minutes = str_pad($time_elasped/60%60, 2, '0', STR_PAD_LEFT);
    $seconds = str_pad($time_elasped % 60, 2, '0', STR_PAD_LEFT);
    return $hours.':'.$minutes.':'.$seconds;

  }

  private function time_elapsed_A($secs)
  {
    $bit = array(
      'y' => $secs / 31556926 % 12,
      'w' => $secs / 604800 % 52,
      'd' => $secs / 86400 % 7,
      'h' => $secs / 3600 % 24,
      'm' => $secs / 60 % 60,
      's' => $secs % 60
    );

    echo $bit["m"];
  }

}


?>