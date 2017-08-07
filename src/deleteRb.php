<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/27
 * Time: 11:08
 */
require_once "../DataBase/DatabaseObj.php";
include "configure.php";
$id = $_POST['id'];
$res =DelRb($id);
if($res)
    header('status:200');
else
    header('status:500');
