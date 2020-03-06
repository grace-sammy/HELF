<?php 
session_start();
 include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
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
    <link rel="stylesheet" type="text/css" href="./css/message.css">
    <link rel="shortcut icon" href="./favicon.ico">
  </head>
  <body>
    <section>
    <div id="message_main_content">
        <h2 class="title">
<?php
  $mode = $_GET['mode'];
  $num = $_GET['num'];

  $sql = "select * from message where num=$num";
  $result = mysqli_query($conn, $sql);

  $row = mysqli_fetch_array($result);
  $send_id = $row['send_id'];
  $rv_id = $row['rv_id'];
  $regist_day = $row['regist_day'];
  $subject = $row['subject'];
  $content = $row['content'];
  $read_mark = $row['read_mark'];

  $content = str_replace(" ", "&nbsp;", $content);
  $content = str_replace("\n", "<br>", $content);
  if($user_id === $rv_id){
    $sql = "update message set read_mark ='y' where rv_id='$user_id'";
    mysqli_query($conn, $sql);
  }
  if($mode == 'send'){
    $result2 = mysqli_query($conn, "select name from members where id='$rv_id'");
  } else {
    $result2 = mysqli_query($conn, "select name from members where id='$send_id'");
  }

  $record = mysqli_fetch_array($result2);
  $msg_name = $record['name'];

  if($mode == "send"){
    echo "보낸 메시지 > 내용보기";
  } else {
    echo "받은 메시지 > 내용보기";
  }
?>
        </h2>
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
        <ul id="view_content">
          <li>
            <span class="col1"><b>제목: </b><?=$subject?></span>
            <span class="col2"><?=$msg_name?> | <?=$regist_day?></span>
          </li>
          <li>
            <?=$content?>
          </li>
        </ul>
        <ul class="buttons">
<?php
  if($mode == "send"){
    echo ("
    <li><button onclick='delete_confirm()'>삭제</button></li>
    ");
  } else {
    echo ("
    <li><button onclick=\"location.href='message_response_form.php?num=$num'\">답변하기</button></li>
    <li><button onclick='delete_confirm()'>삭제</button></li>
    ");
  }
?>
        </ul>
      </div>
</div>
</div>
    </section>
    <script>
      function delete_confirm(){
        if('<?=$user_id?>' !== '<?=$rv_id?>' && '<?=$read_mark?>'==='y'){
          alert('상대방이 확인한 메시지는 삭제할 수 없습니다!');
          return;
        } else {
          var con_val = confirm('정말 삭제하시겠습니까?');
    if(con_val === true){
      location.href='message_delete.php?num=<?=$num?>&mode=<?=$mode?>';
   }
     else if(con_val === false){
      return;
     }
        }
        
      }
  </script>
  </body>
</html>
