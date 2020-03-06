<?php
// 후기 작성하는것에 기능만을 구현중
  session_start();
  if(empty($_SESSION['user_id'])||$_SESSION['user_id']===""){
    echo "<script>alert('로그인후 이용해주세요');history.go(-1);</script>";
    exit;
  }
 include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/create_table.php";
 include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";
?>

 <meta charset="utf-8">
 <?php
 //*****************************************************
 $content= $q_content = $sql= $result = $userid="";

 // 삽입하는경우
 if(isset($_POST["mode"])&&$_POST["mode"]=="insert"){
     $content = trim($_POST["content"]);
     if(empty($content)){
       echo "<script>alert('내용을 입력해주세요');history.go(-1);</script>";
       exit;
     }
     $id=$_SESSION["user_id"];
     $o_key=$_POST["o_key"];
     $type=$_POST["type"];
     $shop=$_POST["shop"];
     $star=(int)$_POST["star"];
     if($star == 0){
       $star = 1;
     }
     $regist_day=date("Y-m-d (H:i)");
     $content = test_input($_POST["content"]);
     $q_content = mysqli_real_escape_string($conn, $content);
     // 구성순서 (id,o_key,content,day,type,shop,star);
     $sql="INSERT INTO `p_review` VALUES (null,'$id',$o_key,'$q_content','$regist_day','$type','$shop',$star);";
     $result = mysqli_query($conn,$sql);
     if (!$result) {
       die('Error: '. mysqli_error($conn));
     }
     mysqli_close($conn);
     echo "<script>alert('평가가 입력되었습니다.');</script>";
     echo "<script>location.href='./program_detail.php?o_key=$o_key';</script>";
 }else if(isset($_GET["mode"])&&$_GET["mode"]=="delete"){
    $num = $_POST['num'];
    $o_key = $_POST['o_key'];
     $sql ="DELETE FROM `p_review` WHERE num='$num';";
     $result = mysqli_query($conn,$sql);
     if (!$result) {
       die('Error: ' . mysqli_error($conn));
     }
     mysqli_close($conn);
     echo "<script>alert('평가가 삭제되었습니다.');</script>";
     echo "<script>location.href='./program_detail.php?o_key=$o_key';</script>";

 }else if(isset($_POST["mode"])&&$_POST["mode"]=="update"){
   $num = $_POST['num'];
   $o_key=$_POST["o_key"];
   $content = trim($_POST["content"]);
   if(empty($content)){
     echo "<script>alert('내용을 입력해주세요');history.go(-1);</script>";
     exit;
   }
   $star=(int)$_POST["star"];
   $q_content = mysqli_real_escape_string($conn, $content);

   $sql="UPDATE `p_review` SET `content`='$q_content',`score`='$star' WHERE num='$num';";
   $result = mysqli_query($conn,$sql);
   if (!$result) {
     die('Error: ' . mysqli_error($conn));
   }
   echo "<script>alert('평가가 수정되었습니다.');</script>";
   echo "<script>location.href='./program_detail.php?o_key=$o_key';</script>";
 }
 ?>
