<meta charset="utf-8">
<?php
  include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

  $num = $_GET['num'];
  $mode = $_GET['mode'];

  $sql = "delete from message where num=$num";

  mysqli_query($conn, $sql);
  mysqli_close($conn);

  if($mode == "send"){
    $url = "message_box.php?mode=send";
  } else {
    $url = "message_box.php?mode=receive";
  }

  echo("
  <script>
    alert('메시지가 삭제되었습니다.');
    location.href = '$url';
  </script>
  ");
?>
