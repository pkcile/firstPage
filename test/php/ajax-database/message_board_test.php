<?php
// 外部传入变量
$message_comment = $_GET['comment'];
$message_name = $_GET['name'];
$message_email = $_GET['email'];
$message_website = $_GET['website'];
$message_time = date("F d").",&nbsp;".date("Y")."&nbsp;at&nbsp;".date("h:i a");
// 数据库变量
$servername = "cdb-nv0web2g.cd.tencentcdb.com:10165";
$username = "pkcile";
$password = "Qqmm7591251314";
$dbname = "lab1";

$array_infor = array();
$array_time = array();
$array_link = array();
$array_email = array();
$array_user = array();
echo $message_comment;
// 操作数据库
// 创建连接
$message_connect = new mysqli($servername, $username, $password, $dbname);
// sql查询语句
$sql2 = "select * from message";
// 执行查询sql
$result = $message_connect->query($sql2);
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        array_push($array_infor, $row["message_infor"]);
        array_push($array_time, $row["message_time"]);
        array_push($array_link, $row["message_link"]);
        array_push($array_email, $row["message_email"]);
        array_push($array_user, $row["message_name"]);
        //echo "id: " . $row["nth"]. " - Name: " . $row["infor"]. " " . "<br>";
    }
} else {
    echo "读取失败";
}
for($i = 0; $i < count($array_infor); $i++) {
    echo
    '
        <div class="message_box" style="display: block">
        <div class="user_infor">
            <div class="user_image">
                <img src="https://1.gravatar.com/avatar/a7504a3e4788015bcdb28dcb74347045?s=32" alt="用户头像">
            </div>
            <div class="user_name">
                <a href="'.$array_link[$i].'" target="_blank" class="user_name_link_email">'.$array_user[$i].'</a>
            </div>
        </div>
        <div class="user_device_infor">
            <div class="user_comment_time"><span>'.$array_time[$i].'</span></div>
    <!--            <div class="user_IP"><span>192.168.1.1</span></div>-->
    <!--            <div class="user_where"><span>河北，邯郸</span></div>-->
    <!--            <div class="user_platform"><span>via andorid</span></div>-->
        </div>
        <div class="user_comment_infor">
            <div class="user_comment_item">
                '.$array_infor[$i].'
            </div>
        </div>
        <div class="user_button_on_off">
            <span>开关</span>
        </div>
    <!--        <div class="user_test_brother" style="width: 100%; height: 100px; background-color: #bfa;">4444</div>-->
    </div>
        <div class="reply_box" style="display: none">
            <div class="reply_infor">
                <div class="reply_to_user">
                    <span class="to_user">Reply to cloudy</span>
                    <span class="cancel_reply">Cancel reply</span>
                </div>
                <div class="reply_note">
                    <span class="note_for_reply">Your email address will not be published. Required fields are marked*</span>
                </div>
            </div>
            <div class="reply_content">
                <div class="reply_content_comment">
                    <span class="reply_content_titles reply_content_comment_title">Comment</span>
                    <div>
                        <textarea name="" id="" cols="30" rows="5" class="reply_content_comment_item"></textarea>
                    </div>
                </div>
                <div class="reply_content_name">
                    <span class="reply_content_titles reply_content_name_title">Name*</span>
                    <div>
                        <input type="text" class="reply_content_input_name">
                    </div>
                </div>
                <div class="reply_content_email">
                    <span class="reply_content_titles reply_content_email_title">Email*</span>
                    <div>
                        <input type="text" class="reply_content_input_email">
                    </div>
                </div>
                <div class="reply_content_website">
                    <span class="reply_content_titles reply_content_website_title">Website*</span>
                    <div>
                        <input type="text" class="reply_content_input_website">
                    </div>
                </div>
    
            </div>
            <div class="reply_forsure">
                <div class="reply_forsure_note">
                    <div class="reply_forsure_note_item">
                        <input type="checkbox" class="reply_forsure_save">
                        <span class="reply_forsure_save_infor">Save my name, email, and website in this browser for the next time I comment.</span>
                    </div>
                    <div class="reply_forsure_note_item">
                        <input type="checkbox" class="reply_forsure_notice">
                        <span class="reply_forsure_save_notice">Notify me via e-mail if anyone answers my comment.</span>
                    </div>
                </div>
                <div class="reply_forsure_button">
                    <span class="reply_forsure_button_infor">Post Comment</span>
                </div>
            </div>
        </div>
     ';

}
echo '
  <script>
    alert("php测试script标签");
    function ajax_button_click() {
        alert("566666");
    }
</script>  
';
if($message_comment == "" || $message_time == "" || $message_email == "" || $message_name == "" || $message_website == "") {
    echo "插入数据暂停";
    return;
} else {
    echo "准备插入数据库";
}
// sql插入语句
$message_insert_sql = "insert into message(message_infor, message_time, message_link, message_email, message_name) values('$message_comment', '$message_time', '$message_website', '$message_email', '$message_name')";;
// 检测连接
if ($message_connect -> connect_error) {
    die("连接失败: " . $message_connect -> connect_error);
} else {
    // 执行插入
    if($message_connect -> query($message_insert_sql) === true) {
        echo "插入成功！";
    } else {
        echo "插入失败"."<br>".$message_connect -> error;
    }
    $message_connect -> close();
}

// 执行sql，执行结果反馈
