<?php
  include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

  $kakao_name = $_POST["kakao_name"];
  $kakao_email = $_POST["kakao_email"];
  $test = "#";

  $kakao_name = str_replace("\"", "", $kakao_name);
  $kakao_email = str_replace("\"", "", $kakao_email);

  $sql = "select * from members where name='$kakao_name' and email='$kakao_email';";
  $result = mysqli_query($conn,$sql);

  echo $kakao_name;
  echo $test;
  echo $kakao_email;
  
  // $rowcount=mysqli_num_rows($result);
  // if(!$rowcount){
  //   $s = '[{"kakao_id":"실패"}]';
  // }else{
  //   $row = mysqli_fetch_array($result);
  //   $_SESSION['userid']=$row['id'];
  //   $_SESSION['username']=$row['name'];
  //   $s = '[{"kakao_id":"성공"}]';
  // }
 ?>
