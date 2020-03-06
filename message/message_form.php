<?php
session_start();
if(isset($_SESSION["user_id"])){
  $user_id = $_SESSION["user_id"];
} else {
  $user_id = "";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: 메시지함</title>
    <script src="http://code.jquery.com/jquery-1.12.4.min.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/message.css">
    <link rel="shortcut icon" href="./favicon.ico">
    <script src="./js/message.js"></script>
  </head>
  <body>
    <?php
      if(!$user_id){
        echo ("<script>
          alert('로그인 후 이용해 주세요!');
          history.go(-1);
          </script>
        ");
      }
    ?>
    <section>
    <div id="message_main_content">
        <h2 id="write_title">메시지 보내기</h2>
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
                <span class="col2"><input type="text" id="id_input" name="rv_id" value="" onkeyup="complete_id()"></span>
                <ul id="receive_id_list"></ul>

              </li>
              <li>
                <span class="col1">제목: </span>
                <span class="col2"><input type="text" name="subject" value=""></span>
              </li>
              <li id="text_area">
                <span class="col1">내용: </span>
                <span class="col2"><textarea name="content"></textarea></span>
              </li>
            </ul>
            <div class="bottom_buttons">
            <button type="button" onclick="check_back()">뒤로가기</button>
            <button type="button" onclick="check_message()">보내기</button>
            </div>          </div>
        </form>
      </div>
      </div>
    </section>
  </body>
</html>
