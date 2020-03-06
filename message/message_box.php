<?php 
  session_start(); 
 include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
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
if(isset($_SESSION["user_grade"])){
  $user_grade = $_SESSION["user_grade"];
} else {
  $user_grade = "";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>HELF :: 메시지함</title>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <link
            rel="stylesheet"
            type="text/css"
            href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/message/css/message.css">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
        <script
            type="text/javascript"
            src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/message/js/message.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
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
      if (isset($_GET['page'])) {
        $page = (int)$_GET['page'];
      } else {
        $page = 1;
      }
  
      if(isset($_GET['mode'])) {
        $mode = $_GET['mode'];
      } else {
        $mode = "receive";
      }
      

    ?>
        <div id="message_main_content">
            <div id="title_messagee">
            <?php
                if($mode=="send"){
                  echo "<h2>보낸 메시지함</h2>";
                } else {
                  echo "<h2>받은 메시지함</h2>";
                }
?>
            </div>
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
                <ul class="message">
                    <li>
                        <span class="col1">번호</span>
                        <span class="col2">제목</span>
                        <span class="col3">
                        <?php
                if($mode=="send"){
                  echo "받은 이";
                } else {
                  echo "보낸 이";
                }
?>
                        </span>
                        <span class="col4">등록일</span>
                    </li>
                <?php

  if($mode == "send"){
    $sql = "select * from message where send_id='$user_id' order by num desc";
  } else {
    $sql = "select * from message where rv_id='$user_id' order by num desc";
  }

  $result = mysqli_query($conn, $sql);
  $total_record = mysqli_num_rows($result);

  $scale = 10;

  // 전체 페이지 수 계산
  if($total_record % $scale == 0){
    $total_page = floor($total_record / $scale);
  } else {
    $total_page = floor($total_record / $scale) + 1;
  }

  $start = ($page - 1) * $scale; // 표시할 페이지에 따라 시작 위치 계산
  $number = $total_record - $start; // 원하는 페이지의 첫번째 위치

  for($i = $start; $i < $start+$scale && $i <$total_record; $i++){
    mysqli_data_seek($result, $i);
    $row = mysqli_fetch_array($result);
    $num = $row['num'];
    $subject = $row['subject'];
    $regist_day = $row['regist_day'];

    if($mode=='send'){
      $msg_id = $row['rv_id'];
    } else {
      $msg_id = $row['send_id'];
    }

    $result2 = mysqli_query($conn, "select name from members where id='$msg_id'");
    $record = mysqli_fetch_array($result2);
    $msg_name = $record['name'];
?>
                    <li>
                        <span class="col1"><?=$number?></span>
                        <span class="col2">
                            <a href="message_view.php?mode=<?=$mode?>&num=<?=$num?>"><?=$subject?></a>
                        </span>
                        <span class="col3"><?=$msg_name?>(<?=$msg_id?>)</span>
                        <span class="col4"><?=$regist_day?></span>
                    </li>
                    <?php
      $number--;
    } // end of for
?>
                </ul>
                <ul id="page_num">
                <?php
  if($total_page>=2 && $page >=2){
    $new_page = $page-1;
    echo "<li><a href='message_box.php?mode=$mode&page=$new_page'>◀ 이전</a></li>";
  } else {
    echo "<li>&nbsp;</li>";
  }

  // 게시판 목록 하단 페이지 링크 번호
  for($i = 1; $i<=$total_page; $i++){
    if($page == $i){
      echo "<li><b> $i </b></li>";
    } else {
      echo "<li><a href='message_box.php?mode=$mode&page=$i'> $i </a></li>";
    }
  } // end of for
  if($total_page>=2 && $page != $total_page){
    $new_page = $page + 1;
    echo "<li> <a href='message_box.php?mode=$mode&page=$new_page'>다음 ▶</a> </li>";
  } else {
    echo "<li>&nbsp;</li>";
  }
?>
                </ul>
            </div>
            <!-- message_content -->
            <div class="bottom_buttons">
                <button onclick="location.href='message_form.php'">쪽지 보내기</button>
            </div>
        </div>
        <!-- message_main_content -->

    </body>
</html>