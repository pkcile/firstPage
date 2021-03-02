<?php
$servername = "cdb-nv0web2g.cd.tencentcdb.com:10165";
$username = "pkcile";
$password = "Qqmm7591251314";
$dbname = "lab1";
$message = $_GET['message'];
$array_infor = array();
$array_time = array();
$array_link = array();
$array_email = array();
$array_user = array();

$current_infor = '测试';
$current_time = date("F d").",&nbsp;".date("Y")."&nbsp;at&nbsp;".date("h:i a");
//$current_time = "test";
$current_link = "http://www";
$current_email = "wang";
$current_user = "pkcile";
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 插入sql
$sql1 = "insert into message(message_infor, message_time, message_link, message_email, message_name) values('$current_infor', '$current_time', '$current_link', '$current_email', '$current_user')";
// 查询sql
$sql2 = "select * from message";

// 执行插入sql
if ($conn->query($sql1) === TRUE) {
//    echo "新记录插入成功";
} else {
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}
// 执行查询sql
$result = $conn->query($sql2);
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
        <div class="message_box"  style="">
            <div class="user_infor">
                <div class="user_image">
                    <img src="https://1.gravatar.com/avatar/a7504a3e4788015bcdb28dcb74347045?s=32" alt="用户头像">
                </div>
                <div class="user_name">
                    <a href="'.$array_email[$i].'" target="_blank" id="user_name_link_email">'.$array_user[$i].'</a>
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

$conn->close();
?>
