<?php

session_start();
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
$id = $_SESSION["user_id"];

$total = 0;

if(isset($_POST["items"])) {
  $items = $_POST["items"];

  for ($i=0; $i<count($items); $i++) {
    $sql = "select B.* from cart A inner join program B on A.o_key = B.o_key where num=$items[$i];";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $price = $row["price"];

    $total += (int)$price;
  }

  echo "$total";

} else {
  $items = "";
}

if(isset($_POST["shop"]) && isset($_POST["type"]) && isset($_POST["choose"])) {
  $shop = $_POST["shop"];
  $type = $_POST["type"];
  $choose = $_POST["choose"];

  // echo "$shop,$type,$choose";

  $sql = "select price from program where shop='$shop' and type='$type' and choose='$choose';";

  // echo ",$sql";

  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $price = $row["price"];

  echo "$price";
} else {
  $shop = "";
  $type = "";
  $choose = "";
}

mysqli_close($conn);

 ?>
