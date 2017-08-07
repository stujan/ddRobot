
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
$url = $_POST['url'];
$name = $_POST['name'];
$type = $_POST['type'];
$belong = $_POST['belong'];
$res =UpdateRb($id,$url,$name,$type,$belong);
if($res)
    header('status:200');
else{
    global $con;
    echo mysqli_error($ocn);
    header('status:500');
}
