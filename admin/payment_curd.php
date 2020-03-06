<?php 
    include $_SERVER['DOCUMENT_ROOT']."/helf//common/lib/db_connector.php";

    if (isset($_POST["ord_num"])) $ord_num = $_POST["ord_num"];
    else $ord_num = "";
  
    if (isset($_POST["complete"])) $complete = $_POST["complete"];
    else $complete = "";
  
    $sql = "update sales set complete ='$complete' where ord_num = '$ord_num'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "수정 완료";
    } else {
      echo "수정 실패";
    }
    mysqli_close($conn);
?>