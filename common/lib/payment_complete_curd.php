<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
  $user_id = $_SESSION['user_id'];
  if(isset($_POST['bank'])){
    $bank = $_POST['bank'];
    $subject =  $_POST["subject"];
    $amount   = $_POST["paid_amount"];
    $program_num = $_POST["name"];
    $paid_date = $_POST["paid_at"];
    $o_key = $_POST["o_key"];
  } else {
    $bank = "";
    $subject =  $_POST["subject"];
    $amount   = $_POST["paid_amount"];
    $program_num = $_POST["name"];
    $paid_date = $_POST["paid_at"];
    $o_key = $_POST["o_key"];
  }

  if(isset($_POST['bank'])&&($_POST['bank']!=="")){
    if(is_array($o_key) == 1) {
      foreach($o_key as $value) {
        $sql = "insert into sales values (null, '$program_num', '$user_id', $value, $amount, '$paid_date', '결제대기', '$bank')";
        $result = mysqli_query($conn, $sql);
        $sql = "delete from cart where o_key=$value;";
        mysqli_query($conn, $sql);
      }
    } else {
      $sql = "insert into sales values (null, '$program_num', '$user_id', $o_key, $amount, '$paid_date', '결제대기', '$bank')";
      $result = mysqli_query($conn, $sql);
      $sql = "delete from cart where o_key=$o_key;";
      mysqli_query($conn, $sql);
    }
  }else {
    if(is_array($o_key) == 1) {
      foreach($o_key as $value) {
        $sql = "insert into sales values (null, '$program_num', '$user_id', $value, $amount, '$paid_date', '결제완료', '카카오페이')";
        $result = mysqli_query($conn, $sql);
        $sql = "delete from cart where o_key=$value;";
        mysqli_query($conn, $sql);
      }    
    } else {
      $sql = "insert into sales values (null, '$program_num', '$user_id', $o_key, $amount, '$paid_date', '결제완료', '카카오페이')";
      $result = mysqli_query($conn, $sql);
      $sql = "delete from cart where o_key=$o_key;";
      mysqli_query($conn, $sql);
    }
  }
  
    mysqli_close($conn);
    echo ("<script>location.href = 'payment_complete.php?ord_num=$program_num&bank=$bank'</script>");
 ?>