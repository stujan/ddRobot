
<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/26
 * Time: 14:59
 */
require_once "config.php";

$con = mysqli_connect($SERVERNAME,$USERNAME,$PASSWORD);
if(!$con){
    die('Could not connect:' .$con->connect_errno);
}


#create databas

if($con->query($CREATEDB) === true){
    echo "DataBase created\n";
}else{
    echo "Error creating database: ".$con->error."\n";
}
CloseDB();
$con = mysqli_connect($SERVERNAME,$USERNAME,$PASSWORD,$DBNAME);
#create table
if($con->query($CREATETABLE1) === true && $con->query($CREATETABLE2) === true){
    echo "Table create successfully\n";
}else{
    echo "create table error:" . $con->error."\n";
}

function CloseDB(){
    global $con;
    $con->close();
}
