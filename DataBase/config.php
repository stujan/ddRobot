<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/26
 * Time: 15:16
 */
#数据库配置文件
/*
 * 数据库对象
 * 帐号
 * 密码
 * sql语句---建库  建表  增删改查
 */
$SERVERNAME = "localhost";
$USERNAME = "root";
$PASSWORD = "";
$DBNAME = "RobotDB";
$CREATEDB= "CREATE DATABASE RobotDB";
$CREATETABLE1 = "CREATE TABLE ROBOT (
   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   url VARCHAR(100) NOT NULL,
   type VARCHAR(20),
   belong VARCHAR(20),
   name VARCHAR(60) NOT NULL  DEFAULT 'Stupid Robot',
   addtime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

)";
$CREATETABLE2 = "CREATE TABLE Message (
   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   rid INT(6),
   msg TEXT,
   type VARCHAR(10),
   pattern VARCHAR(30),
   savetime TIMESTAMP  NOT NULL default CURRENT_TIMESTAMP
)";

function __InsertRb($url,$name,$type,$belong){
    return "Insert into ROBOT(url,name,type,belong) VALUES ('$url','$name','$type','$belong')";
}

function __InsertMs($id,$message,$type,$pattern){
    return "Insert into Message(rid,msg,type,pattern) VALUES ('$id','$message','$type','$pattern')";
}
function __UpdateRb($id,$url,$name,$type,$belong){
    return "Update ROBOT set url = '$url', name = '$name', type = '$type',belong = '$belong' Where id = '$id' ";
}
function __UpdateMs($id,$message,$type,$pattern){
    return "Update Message set msg = '$message', type ='$type' ,pattern = '$pattern'  Where id = '$id'";
}
function __DelRb($id){
    return "Delete FROM ROBOT WHERE id = '$id' ";
}
function __DelMs($id){
    return "Delete FROM Message WHERE id = '$id' ";
}
function __DelMsByRid($id){
    return "Delete FROM Message WHERE rid = '$id' ";
}
function __SelectRb($id=null){
    if ($id)
        return "Select * from ROBOT WHERE id = '$id' ";
    else
        return "Select * from ROBOT ORDER BY id DESC ";
}

function __SelectMs($rid){
    return "Select * from Message WHERE rid = '$rid' ";
}
function __GETCron(){
    return "Select * from Message";
}
