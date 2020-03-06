<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/HELF/common/lib/db_connector.php";
  include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";
?>
<?php
if(!isset($_SESSION['user_grade'])==="admin"){
  echo "<script>alert('권한없음!');history.go(-1);</script>";
  exit;
}
?>
<meta charset="utf-8">
<?php //faq
//*****************************************************
$content= $q_content = $sql= $result = $userid="";
$group_num = 0;

// 삽입하는경우
if(isset($_GET["mode"])&&$_GET["mode"]=="insert"){
    $content = trim($_POST["content"]);
    $subject = trim($_POST["subject"]);
    if(empty($content)||empty($subject)){
      echo "<script>alert('내용이나제목입력요망!');history.go(-1);</script>";
      exit;
    }
    $subject = test_input($_POST["subject"]);
    $content = test_input($_POST["content"]);
    $q_subject = mysqli_real_escape_string($conn, $subject);
    $q_content = mysqli_real_escape_string($conn, $content);

    $sql="INSERT INTO `faq` VALUES (null,'$q_subject','$q_content');";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: '. mysqli_error($conn));
    }
    mysqli_close($conn);

    // echo "<script>location.href='./view.php?num=$max_num&hit=$hit';</script>";
    echo "<script>location.href='./list.php';</script>";
}else if(isset($_GET["mode"])&&$_GET["mode"]=="delete"){
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    $sql ="DELETE FROM `faq` WHERE num=$q_num";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);
    echo "<script>location.href='./list.php?page=1';</script>";

}else if(isset($_GET["mode"])&&$_GET["mode"]=="update"){
  $content = trim($_POST["content"]);
  $subject = trim($_POST["subject"]);
  if(empty($content)||empty($subject)){
    echo "<script>alert('내용이나제목입력요망!');history.go(-1);</script>";
    exit;
  }
  $subject = test_input($_POST["subject"]);
  $content = test_input($_POST["content"]);
  $num = test_input($_POST["num"]);
  $q_subject = mysqli_real_escape_string($conn, $subject);
  $q_content = mysqli_real_escape_string($conn, $content);
  $q_num = mysqli_real_escape_string($conn, $num);

  $sql="UPDATE `faq` SET `subject`='$q_subject',`content`='$q_content' WHERE `num`=$q_num;";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script>location.href='./view.php?num=$num&hit=$hit';</script>";
}//end of if insert
// Header("Location: p260_score_list.php");
?>
