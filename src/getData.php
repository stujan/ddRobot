<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/28
 * Time: 11:48
 */
require_once "configure.php";
require_once "../DataBase/DatabaseObj.php";
$date = SelectRb();
if($date->num_rows > 0){
    $res = array();
    while($row = $date->fetch_assoc()){
        $msg = SelectMs($row['id']);
        $arr = array("id"=>$row['id'],"url"=>$row['url'],"addDate"=>$row['addtime'],"name"=>$row['name'],"type"=>$row['type'],"belong"=>$row['belong'],"statuses"=>array());
        if($msg->num_rows > 0){
            while($msgrow = $msg->fetch_assoc()){
                array_push($arr["statuses"],array("id"=>$msgrow["id"],"message"=>$msgrow["msg"],"type"=>$msgrow["type"],"addDate"=>$msgrow["savetime"],"pattern"=>$msgrow["pattern"]));
            }
        }
	array_push($res,$arr);
    }
    echo json_encode($res);
}


//   {
//     id : 1,
//     url : 'CN12343549',
//     addDate : new Date('12/11/2016'),
//     name : 'Wanxiang',
//     type : 'Алена',
//     belong : 1,
//     statuses : [
//       {
//         id : 1,
//         addDate : new Date('12/17/2016'),
//         message : 'Груз отгружен. Направляется в порт Ротердама.',
//         type : 'Петр'
//       },
//       {
//         id : 3,
//         addDate : new Date('12/15/2016'),
//         message : 'Груз прибыл в Москву.',
//         type : 'Иван'
//       }
//     ]
//   },
