<?php

  include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

  $id = $_POST["input_id"];

  $sql = "select * from members where id = '$id'";

  $result = mysqli_query($conn, $sql);
  $result_record = mysqli_num_rows($result);

  if($result_record){
    echo "1";
  }else{
    echo "0";
  }

  mysqli_close($conn);

 ?>
