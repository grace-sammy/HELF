<?php  
session_start();
if(isset($_SESSION["user_id"])){
  $user_id = $_SESSION["user_id"];
} else {
  $user_id = "";
}
if(isset($_SESSION["user_name"])){
  $user_name = $_SESSION["user_name"];
} else {
  $user_name = "";
}
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: 메시지함</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css">
    <link rel="stylesheet" type="text/css" href="./css/message.css">
    <link rel="shortcut icon" href="./favicon.ico">
    <script src="./js/message.js"></script>
  </head>
  <body>
    <section>
    <div id="message_main_content">

        <h2 id="write_title">답변 메시지 보내기</h2>
<?php
  $num = $_GET['num'];

  $sql = "select * from message where num=$num";
  $result = mysqli_query($conn, $sql);

  $row = mysqli_fetch_array($result);
  $send_id = $row['send_id'];
  $rv_id = $row['rv_id'];
  $subject = $row['subject'];
  $content = $row['content'];

  $subject = "RE: ".$subject;
  $content = "> ".$content;
  $content = str_replace("\n", "\n>", $content );
  $content = "\n\n\n-----------------------------------------------\n".$content;

  $result2 = mysqli_query($conn, "select name from members where id='$send_id'");
  $record = mysqli_fetch_array($result2);
  $send_name = $record['name'];
?>
<div id="message_buttons">
                <ul class="tab">
                    <li>
                        <a href="./message_box.php?mode=receive" id="received">받은 메시지</a>
                    </li>
                    <li>
                        <a href="./message_box.php?mode=send" id="sent">보낸 메시지</a>
                    </li>
                </ul>
            </div>
            <div id="message_content">

        <form name="message_form" action="message_insert.php" method="post">
          <div id="write_msg">
            <ul>
              <li>
                <span class="col1">보내는 사람: </span>
                <span class="col2"><?=$user_id?></span>
                <input type="hidden" name="send_id" value="<?=$user_id?>">
              </li>
              <li>
                <span class="col1">받는 사람 <br>아이디: </span>
                <span class="col2"><?=$send_name?>(<?=$send_id?>)</span>
                <input type="hidden" name="rv_id" value="<?=$send_id?>">
              </li>
              <li>
                <span class="col1">제목: </span>
                <span class="col2"><input type="text" name="subject" value="<?=$subject?>"></span>
              <li id="text_area">
                <span class="col1">내용 : </span>
                <span class="col2">
                  <textarea name="content"><?=$content?></textarea>
                </span>
              </li>
            </ul>
            <div class="bottom_buttons">
            <button type="button" onclick="check_back()">뒤로가기</button>
            <button type="button" onclick="check_message()">보내기</button>
            </div>
          </div>
        </form>
            </div>
    </div>
    </section>
  </body>
</html>
