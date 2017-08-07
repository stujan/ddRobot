
<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/31
 * Time: 17:15
 */

function writeLog($message){
    $logfile = fopen("log.txt","a+");
    $message.="\n";
    fwrite($logfile,$message);
    fclose($logfile);
}
