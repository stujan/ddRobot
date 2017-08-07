<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/27
 * Time: 11:08
 */
require_once "../DataBase/DatabaseObj.php";
include "configure.php";
$name = $_POST['mmsg'];
$type = $_POST['mtype'];
$pattern = $_POST['mpattern'];
$rid = $_POST['rid'];
$res =InsertMs($rid,$name,$type,$pattern);
if($res != 0)
    #echo "down"; 
   echo $res;
else{
    header('status:500');
    #echo "123";
}
