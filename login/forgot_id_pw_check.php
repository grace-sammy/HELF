<?php
  include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

  $find_type = $_POST["find_type"];

  if($find_type === "id") {
    if(isset($_POST["find_id_name"])){
      $name = $_POST["find_id_name"];
    } else {
      $name="";
    }

    if(isset($_POST["find_id_email"])){
      $email = $_POST["find_id_email"];
    } else {
      $email = "";
    }

    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "select * from members where name='$name' and email='$email';";
    $result = mysqli_query($conn,$sql) or die("실패원인 : ".mysqli_error($conn));

    if(mysqli_num_rows($result)==0){
      echo "fail";
    }else{
      $row = mysqli_fetch_array($result);
      echo "{$row['id']}";
    }
  } else if($find_type === "password") {
      if(isset($_POST["find_password_id"])){
        $id = $_POST["find_password_id"];
      } else {
        $id="";
      }

      if(isset($_POST["phone_one"])){
        $phone_one = $_POST["phone_one"];
      } else {
        $phone_one = "";
      }

      if(isset($_POST["phone_two"])){
        $phone_two = $_POST["phone_two"];
      } else {
        $phone_two = "";
      }
      if(isset($_POST["phone_three"])){
        $phone_three = $_POST["phone_three"];
      } else {
        $phone_three = "";
      }

      $phone = $phone_one."-".$phone_two."-".$phone_three;

      $id = mysqli_real_escape_string($conn, $id);
      $phone = mysqli_real_escape_string($conn, $phone);

      $sql = "select * from members where id='$id' and phone='$phone';";
      $result = mysqli_query($conn,$sql) or die("실패원인 : ".mysqli_error($conn));

      if(mysqli_num_rows($result)==0){
        echo "fail";
      }else{
        $row = mysqli_fetch_array($result);
        echo "{$row['password']}";
      }
  } else if($find_type == "signup_duplicate_check"){

    if(isset($_POST["input_name"])){
      $name = $_POST["input_name"];
    } else {
      $name="";
    }

    if(isset($_POST["email_one"])){
      $email_one = $_POST["email_one"];
    } else {
      $email_one = "";
    }

    if(isset($_POST["email_two"])){
      $email_two = $_POST["email_two"];
    } else {
      $email_two = "";
    }



    $name = mysqli_real_escape_string($conn, $name);
    $email_one = mysqli_real_escape_string($conn, $email_one);
    $email_two = mysqli_real_escape_string($conn, $email_two);

    $email = $email_one."@".$email_two;

    $sql = "select * from members where name='$name' and email='$email';";
    $result = mysqli_query($conn,$sql) or die("실패원인 : ".mysqli_error($conn));

    if(mysqli_num_rows($result)==0){
      echo "ok";
    }else{
      $row = mysqli_fetch_array($result);
      echo "{$row['id']}";
    }
  }

  mysqli_close($conn);
 ?>
