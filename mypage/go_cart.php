<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
$id = $_SESSION["user_id"];

if(isset($_POST["shop"])) {
  $shop = $_POST["shop"];

} else {
  $shop = "";
}

if(isset($_POST["type"])) {
  $type = $_POST["type"];

} else {
  $type = "";
}

if(isset($_POST["choose"])) {
  $choose = $_POST["choose"];

} else {
  $choose = "";
}

// echo "$shop,$type,$choose,";

if($choose === "선택") {

  echo "옵션 선택 요망";

} else {

  $sql = "select o_key from program where shop='$shop' and type='$type' and choose='$choose'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $o_key = (int)$row["o_key"];

  $sql2 = "select * from cart where id='$id' and o_key=$o_key;";
  $result2 = mysqli_query($conn, $sql2);
  $row = mysqli_fetch_array($result2);

  if($row) {

    echo "이미 존재";

  } else {

    $sql3 = "insert into cart values (null, '$id', $o_key);";
    $result3 = mysqli_query($conn, $sql3);

    if($result3) {

      echo "장바구니 성공";

    } else {

      echo "오류 발생";

    }

  }

}

?>
