
<?php
echo "6666";
$servername = "cdb-nv0web2g.cd.tencentcdb.com:10165";
$username = "pkcile";
$password = "Qqmm7591251314";
$dbname = "lab1";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$sql = "insert into message (infor) VALUES ('测试1')";
if ($conn->query($sql) === TRUE) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql2 = "select * from message";
$result = $conn->query($sql2);

if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["nth"]. " - Name: " . $row["infor"]. " " . "<br>";
    }
} else {
    echo "读取失败";
}
$conn->close();
?>
