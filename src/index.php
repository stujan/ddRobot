<?php
/**
 * Created by PhpStorm.
 * User: 2010104-0071
 * Date: 2017/7/26
 * Time: 17:12
 */
require_once "../DataBase/DatabaseObj.php";
require_once  "index.html";
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

$date = SelectRb();
if($date->num_rows > 0){
    while($row = $date->fetch_assoc()){
        $msg = SelectMs();
        echo "<script>";
        echo "newData = {}";
        echo "newData.id = ".$row["id"];
        echo "newData.url = ".$row["url"];
        echo "newData.addDate = ".$row["addtime"];
        echo "newData.name = ".$row["name"];
        echo "newData.type = ".$row["type"];
        echo "newData.belong = ".$row["belong"];
        echo "newData.status = [] ";
        if($msg->num_rows > 0){

            while($msgrow = $msg->fetch_assoc())
                echo "newData.status.push({";
                echo "addDate :".$msgrow["savetime"];
                echo "id :".$msgrow["id"];
                echo "type :".$msgrow["type"];
                echo "message :".$msgrow["msg"];
        }
        echo "\$scope.trackList.push(newDate)";
        echo "</script>";
    }
}

echo "<script>";
echo "newData = {};";
echo "newData.id = 1;";
echo "newData.url = 2;";
echo "newData.addDate = 3;";
echo "newData.name = 4;";
echo "newData.type = 5;";
echo "newData.belong = 7;";
echo "newData.status = []; ";
echo "newData.status.push({";
echo "addDate :6,";

echo "id :8,";
echo "type :8,";
echo "message :10});";

echo "var appElement = document.querySelector('[ng-controller=trackerAdminCtrl]');";
#echo "var scope = angular.element(appElement).scope();"


echo "alert(appElement)";

echo "</script>";

CloseDB();





