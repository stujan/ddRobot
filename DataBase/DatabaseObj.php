<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/26
 * Time: 17:16
 */
require_once  "config.php";
$con = mysqli_connect($SERVERNAME,$USERNAME,$PASSWORD,$DBNAME);
if($con->error){
    die('Could not connect:' .$con->connect_errno);
}
function SelectRb($id=null){
    global $con;
    return $con->query(__SelectRb($id));
}
function SelectMs($id){
    global $con;
    return $con->query(__SelectMs($id));
}

function GetCron(){
    global $con;
    return $con->query(__GETCron());
}

function InsertRb($url,$name,$type,$belong){
    global $con;
    if($con->query(__InsertRb($url,$name,$type,$belong)))
	return mysqli_insert_id($con);
    else
	return 0;
}

function InsertMs($id,$message,$type,$pattern){
    global $con;
    if($con->query(__InsertMs($id,$message,$type,$pattern)))
	return mysqli_insert_id($con);
    else
	return 0;

}
function UpdateRb($id,$url,$name,$type,$belong){
    global $con;
    return $con->query(__UpdateRb($id,$url,$name,$type,$belong));
}
function UpdateMs($id,$message,$type,$pattern){
    global $con;
    return $con->query(__UpdateMs($id,$message,$type,$pattern));
}
function DelRb($id){
    global $con;
    return $con->query(__DelRb($id)) && $con->query(__DelMsByRid($id));
}
function DelMs($id){
    global $con;
    return $con->query(__DelMS($id));
}


function CloseDB(){
    global $con;
    $con->close();
}


