##钉钉机器人后台管理工具
> 环境要求，PHP  + MYSQL

可通过网页在线对钉钉机器人进行管理，功能类似crontab，`匹配的模式===周期`注意用crontab的语法！！！

- 初始化
  > 一开始使用需要先配置初始化环境，建立数据库和表
  执行 php    /DataBase/DataBase.php  建库和表

- 初始化完成后，执行后台调度程序，模拟了crontab的功能，对pattern字段进行解析

  执行php   /src/cronTab.php


- 以下是提供的一些API

| File               | method | 作用         |
| ------------------ | ------ | ---------- |
| /src/configure.php |        | 配置header   |
| /src/cronTab.php   |        | 后台调度       |
| /src/deleteMs.php  | post   | 删除一条待发送的数据 |
| /src/deleteRb.php  | post   | 删除一个机器人    |
| /src/getData.php   | get    | 获取机器人和数据   |
| /src/insertMs.php  | post   | 插入一条数据     |
| /src/insertRb.php  | post   | 插入一个机器人    |
| /src/log.php       |        | 日志         |
| /src/updateMs.php  | post   | 更新一条数据     |
| /src/updateRb.php  | post   | 更新机器人数据    |

| File                      | method | 作用      |
| ------------------------- | ------ | ------- |
| /DataBase/config.php      |        | 配置数据库   |
| /DataBase/DataBase.php    |        | 初始化数据库  |
| /DataBase/DatabaseObj.php |        | 数据库操作接口 |



- 前端文件

  Style目录下
