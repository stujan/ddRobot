
<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/27
 * Time: 10:29
 */
require_once "../DataBase/DatabaseObj.php";
include "configure.php";
$id = $_POST['id'];
$msg = $_POST['mmsg'];
$type = $_POST['mtype'];
$pattern = $_POST['mpattern'];
$res =UpdateMs($id,$msg,$type,$pattern);
if($res)
    header('status:200');
else
    header('status:500');
