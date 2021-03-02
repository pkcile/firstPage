<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="top1" style="width:800px;height: 100px;background-color:#bfa;margin:0 auto;">

    </div>
    <?php
//        echo "test";
        //定义变量
        $address = "cdb-nv0web2g.cd.tencentcdb.com:10165";
        $name = "pkcile";
        $password = "Qqmm7591251314";
        try {
            $conn = new PDO("mysql:host=$address;", $name, $password);
            $sql = "CREATE DATABASE lab1";
            $conn -> exec($sql);
            echo "创建数据库成功或已经存在";

            $sql_query = "SELECT * FROM student_infor";
            $result_test = $conn ->query($sql_query);
            echo "测试成功";
//            printf($result_test) ;


            $conn->close();
        }
        catch (PDOException $e){
            echo "发生错误：可能是数据库文件已经存在";
        }
        //测试连接

        //创建数据库
    ?>
</body>
</html>