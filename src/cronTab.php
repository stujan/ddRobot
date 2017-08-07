<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/31
 * Time: 15:08
 */
require_once "log.php";
require_once "../DataBase/DatabaseObj.php";
set_time_limit(0);
while(true){
    $data =GetCron();
    if($data->num_rows > 0){
        while($row = $data->fetch_assoc()){
            if(parse_crontab($row['pattern'])){
                $robot = SelectRb($row['rid']);
                $url = "";
		if($robot->num_rows>0){
                  while($rorow = $robot->fetch_assoc()) {
                      $url = $rorow['url'];
                  
		  }
		#echo $url;
                $message = $row['msg'];
               # $sendmsg = array('msgtype' => $row['type'],$row['type'] => array ('content' => $message));
		$sendmsg = array('msgtype'=> $row['type'], $row['type']=>json_decode($message,true));
 		$msg_string = json_encode($sendmsg);
                $result = request_by_curl($url,$msg_string);
                $logmsg = 'running at :'.date('Y-m-d H:i:s') . 'url:' .$url . $result;
                writeLog($logmsg);
                echo $result."\n";
		}
            }
        }
    }
    sleep(60);
}
function request_by_curl($remote_server,$post_string){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function parse_crontab($frequency='* * * * *', $time=false) {
    # Example of job definition:
    # .---------------- minute (0 - 59)
    # |  .------------- hour (0 - 23)
    # |  |  .---------- day of month (1 - 31)
    # |  |  |  .------- month (1 - 12) OR jan,feb,mar,apr ...
    # |  |  |  |  .---- day of week (0 - 6) (Sunday=0 or 7) OR sun,mon,tue,wed,thu,fri,sat
    # |  |  |  |  |
    # *  *  *  *  * user-name  command to be executed
    # replace month and day of week names with numbers
    $patterns = array('/jan/i','/feb/i','/mar/i','/apr/i','/may/i','/jun/i','/jul/i','/aug/i','/sep/i','/oct/i','/nov/i','/dec/i');
    $replace = array(1,2,3,4,5,6,7,8,9,10,11,12);
    $frequency = preg_replace($patterns,$replace,$frequency);
    $patterns = array('/sun/i','/mon/i','/tue/i','/wed/i','/thu/i','/fri/i','/sat/i');
    $replace = array(0,1,2,3,4,5,6);
    $frequency = preg_replace($patterns,$replace,$frequency);
    # make the time now, or the time input into the function
    $time = is_string($time) ? strtotime($time) : time();
    # pull out the values from our time
    $time = explode(' ', date('i G j n w', $time));
    # ensure that any 0-padded minutes are converted to integers
    $time[0] = $time[0] + 0;
    # pull out our job definition frequencies
    $crontab = explode(' ', $frequency);
    foreach ($crontab as $k => &$v) {
        $v = explode(',', $v);
        $regexps = array(
            '/^\*$/', # every
            '/^\d+$/', # digit
            '/^(\d+)\-(\d+)$/', # range
            '/^\*\/(\d+)$/' # every digit
        );
        $content = array(
            "true", # every
            "{$time[$k]} === $0", # digit
            "($1 <= {$time[$k]} && {$time[$k]} <= $2)", # range
            "{$time[$k]} % $1 === 0" # every digit
        );
        foreach ($v as &$v1)
            $v1 = preg_replace($regexps, $content, $v1);
        $v = '('.implode(' || ', $v).')';
    }
    $crontab = implode(' && ', $crontab);
    return eval("return {$crontab};");
}

