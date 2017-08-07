- 初始化

  执行 php    /DataBase/DataBase.php  建库和表

- 执行后台调度程序

  执行php   /src/cronTab.php



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