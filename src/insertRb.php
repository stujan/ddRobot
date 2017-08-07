<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/27
 * Time: 11:08
 */
require_once "../DataBase/DatabaseObj.php";
include "configure.php";
$url = $_POST['rurl'];
$name = $_POST['rname'];
$type = $_POST['rtype'];
$belong = $_POST['rbelong'];
$res =InsertRb($url,$name,$type,$belong);
if($res != 0)
  #header('status:200');
  echo $res;
else
  header('status:500');
