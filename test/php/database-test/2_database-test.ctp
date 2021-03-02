<?php
$servername = "cdb-nv0web2g.cd.tencentcdb.com:10165";
$username = "pkcile";
$password = "Qqmm7591251314";
$dbname = "lab1";
//连接数据库
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM student_infor");
    $stmt->execute();
    // 设置结果集为关联数组
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo "test";
    echo $result;
//    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
//        echo $v;
//    }
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>
