<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/HELF/common/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";

// 삽입하는경우

if(isset($_GET["mode"])&&$_GET["mode"]=="new_insert"){
  $user_id = $_SESSION["user_id"];
  $o_key = $_POST["o_key"];
  $group_num = $_POST["group_num"];
  $shop = $_POST["shop"];
  $type = $_POST["type"];
  $content = trim($_POST["content"]);
  $subject = trim($_POST["subject"]);
  if(empty($content)||empty($subject)){
    alert_back('내용이나 제목을 입력해주세요.');
    exit;
  }
  $subject = test_input($_POST["subject"]);
  $content = test_input($_POST["content"]);

  $user_id = test_input($user_id);
  $q_subject = mysqli_real_escape_string($conn, $subject);
  $q_content = mysqli_real_escape_string($conn, $content);
  $q_userid = mysqli_real_escape_string($conn, $user_id);
  $regist_day=date("Y-m-d (H:i)");
  //그룹번호, 들여쓰기 기본값
  $group_num = 0;
  $depth=0;
  $ord=0;

  $sql="INSERT INTO `p_qna` VALUES (null,$group_num,$depth,$ord,'$user_id',$o_key,'$shop','$type','$q_subject','$q_content','$regist_day');";
  $result = mysqli_query($conn,$sql);

  if (!$result) {
    alert_back('Error:5 ' . mysqli_error($conn));
    // die('Error: ' . mysqli_error($conn));
  }
  //현재 최대큰번호를 가져와서 그룹번호로 저장하기
  $sql="SELECT max(num) from p_qna;";
  $result = mysqli_query($conn, $sql);
  if (!$result) {
      die('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $max_num=$row['max(num)'];
  $sql="UPDATE `p_qna` SET `group_num`= $max_num WHERE `num`=$max_num;";
  $result = mysqli_query($conn, $sql);
  if (!$result) {
      die('Error: ' . mysqli_error($conn));
  }

  mysqli_close($conn);

// echo "<script>location.href='./program_detail.php?o_key=$o_key';</script>";
echo "<script>alert('QnA가 등록되었습니다.');</script>";
echo "<script>opener.parent.location.reload();self.close();</script>" ;
}else if(isset($_GET["mode"])&&$_GET["mode"]=="insert"){
    $user_id = $_SESSION["user_id"];
    $o_key = (int)$_POST["o_key"];
    $group_num = (int)$_POST["group_num"];
    $num = test_input($_POST["num"]);
    $shop = $_POST["shop"];
    $type = $_POST["type"];
    $content = trim($_POST["content"]);
    $subject = trim($_POST["subject"]);
    $regist_day=date("Y-m-d (H:i)");
    if(empty($content)||empty($subject)){
      echo "<script>alert('내용이나제목입력요망!');history.go(-1);</script>";
      exit;
    }
    $subject = test_input($_POST["subject"]);
    $content = test_input($_POST["content"]);
    $q_subject = mysqli_real_escape_string($conn, $subject);
    $q_content = mysqli_real_escape_string($conn, $content);
    $q_num = mysqli_real_escape_string($conn, $num);

    $sql="SELECT * from `p_qna` where num =$q_num;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);

    //현재 그룹넘버값을 가져와서 저장한다.
    $group_num=(int)$row['group_num'];
    //현재 들여쓰기값을 가져와서 증가한후 저장한다.
    $depth=(int)$row['depth'] + 1;
    //현재 순서값을 가져와서 증가한후 저장한다.
    $ord=(int)$row['ord'] + 1;

    $sql="UPDATE `p_qna` SET `ord`=`ord`+1 WHERE `group_num` = $group_num and `ord` >= $ord";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    $sql="INSERT INTO `p_qna` VALUES (null,$group_num,$depth,$ord,'$user_id',$o_key,'$shop','$type','$q_subject','$q_content','$regist_day');";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: '. mysqli_error($conn));
    }

    mysqli_close($conn);

    // echo "<script>location.href='./view.php?num=$max_num&hit=$hit';</script>";
    // echo "<script>location.href='./program_detail.php?o_key=$group_num';</script>";
    echo "<script>alert('답변이 등록되었습니다.');</script>";
    echo "<script>opener.parent.location.reload();self.close();</script>";
}else if(isset($_GET["mode"])&&$_GET["mode"]=="delete"){
    $o_key = $_GET["o_key"];
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    $sql ="DELETE FROM `p_qna` WHERE num=$q_num";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);
    // echo "<script>location.href='./program_detail.php?o_key=$o_key';</script>";
    echo "<script>alert('QnA가 삭제되었습니다.');</script>";
    echo "<script>location.href='./program_detail.php?o_key=$o_key';</script>";
}else if(isset($_GET["mode"])&&$_GET["mode"]=="update"){
  $group_num = $_POST["group_num"];
  $shop = $_POST["shop"];
  $type = $_POST["type"];
  $content = trim($_POST["content"]);
  $subject = trim($_POST["subject"]);
  $regist_day=date("Y-m-d (H:i)");
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

  $sql="UPDATE `p_qna` SET `subject`='$q_subject',`content`='$q_content' WHERE `num`=$q_num;";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  // echo "<script>location.href='./view.php?num=$num&hit=$hit';</script>";
  echo "<script>alert('QnA가 수정되었습니다.');</script>";
  echo "<script>opener.parent.location.reload();self.close();</script>";
}
?>
