<meta charset="utf-8">
<?php
 include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

  date_default_timezone_set('Asia/Seoul');

  $send_id = $_POST['send_id'];
  $rv_id = $_POST['rv_id'];
  $subject = $_POST['subject'];
  $content = $_POST['content'];

  // echo("<script>console.log('$send_id');</script>");

  $subject = htmlspecialchars($subject, ENT_QUOTES);
  $content = htmlspecialchars($content, ENT_QUOTES);
  $regist_day = date("Y-m-d (H:i)");

  if(!$send_id){
    echo ("
      <script>
        alert('로그인 후 이용해 주세요!');
        history.go(-1);
      </script>
    ");
  }

  $sql = "select * from members where id='$rv_id'";
  $result = mysqli_query($conn, $sql);
  $num_recode = mysqli_num_rows($result);

  if($num_recode){
    $sql = "insert into message values(null, '$send_id', '$rv_id', '$subject', '$content', '$regist_day', 'n')";
    mysqli_query($conn, $sql);
  } else {
    echo ("
      <script>
        alert('수신 아이디가 잘못되었습니다!');
        history.go(-1);
      </script>
    ");
  }

  mysqli_close($conn);

  echo("
    <script>
      location.href = 'message_box.php?mode=send';
    </script>
  ");
?>
