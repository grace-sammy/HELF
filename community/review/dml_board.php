<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";

?>
<?php
if(!isset($_SESSION['user_id'])){
  echo "<script>alert('로그인 후 이용해주세요.');history.go(-1);</script>";
  exit;
}
?>
<meta charset="utf-8">

<?php
$content= $q_content = $sql= $result = $user_id= $user_name ="";
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

if(isset($_GET["mode"])&&$_GET["mode"]=="insert"){
    $content = trim($_POST["content"]);
    $subject = trim($_POST["subject"]);
    if(empty($content)||empty($subject)){
      alert_back('내용이나 제목을 입력해주세요.');
      exit;
    }
    $subject = test_input($_POST["subject"]);
    $content = test_input($_POST["content"]);
    $user_id = test_input($user_id);
    $hit = 0;
    $q_subject = mysqli_real_escape_string($conn, $subject);
    $q_content = mysqli_real_escape_string($conn, $content);
    $q_userid = mysqli_real_escape_string($conn, $user_id);
    $q_username = mysqli_real_escape_string($conn, $user_name);
    $regist_day=date("Y-m-d (H:i)");

    //include 파일업로드기능
    include  "./lib/file_upload.php";

    //8 파일의 실제명과 저장되는 명을 삽입한다.
    $sql="INSERT INTO `community` VALUES (null,'$q_userid','$q_username','$q_subject','$q_content','$regist_day',0,'$db_name', '$db_type','$copied_file_name',0,'다이어트후기');";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      alert_back('Error:5 ' . mysqli_error($conn));
      // die('Error: ' . mysqli_error($conn));
    }

    //등록된사용자가 최근 입력한 이미지게시판을 보여주기 위하여 num 찾아서 전달하기 위함이다.
    $sql="SELECT num from `community` where id ='$q_userid' and b_code='다이어트후기' order by num desc limit 1;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      alert_back('Error: 6' . mysqli_error($conn));
      // die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $num=$row['num'];
    mysqli_close($conn);

    echo "<script>alert('게시글이 등록되었습니다.');</script>";
    echo "<script>location.href='./view.php?num=$num&hit=$hit';</script>";

}else if(isset($_GET["mode"])&&$_GET["mode"]=="delete"){
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    //삭제할 게시물의 이미지파일명을 가져와서 삭제한다.
    $sql="SELECT `file_copied` from `community` where num ='$q_num';";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      alert_back('Error: 6' . mysqli_error($conn));
      // die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $file_copied=$row['file_copied'];

    if(!empty($file_copied)){
      unlink("./data/".$file_copied);
    }

    $sql ="DELETE FROM `community` WHERE num=$q_num";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    $sql ="DELETE FROM `community` WHERE parent=$q_num";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);

    echo "<script>location.href='./list.php';</script>";

}else if(isset($_GET["mode"])&&$_GET["mode"]=="update"){
  $content = trim($_POST["content"]);
  $subject = trim($_POST["subject"]);
  if(empty($content)||empty($subject)){
    echo "<script>alert('내용이나 제목을 입력해주세요');history.go(-1);</script>";
    exit;
  }
  $subject = test_input($_POST["subject"]);
  $content = test_input($_POST["content"]);
  $user_id = test_input($user_id);
  $num = test_input($_POST["num"]);
  $hit = test_input($_POST["hit"]);
  $q_subject = mysqli_real_escape_string($conn, $subject);
  $q_content = mysqli_real_escape_string($conn, $content);
  $q_user_id = mysqli_real_escape_string($conn, $user_id);
  $q_num = mysqli_real_escape_string($conn, $num);
  $regist_day=date("Y-m-d (H:i)");

  //1번과 2번이 해당이 된다. 파일삭제만 체크한다..
  if(isset($_POST['del_file']) && $_POST['del_file'] =='1'){
    //삭제할 게시물의 이미지파일명을 가져와서 삭제한다.
    $sql="SELECT `file_copied` from `community` where `num` ='$q_num' and `b_code`='다이어트후기';";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      alert_back('Error: 6' . mysqli_error($conn));
      // die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $file_copied=$row['file_copied'];
    if(!empty($file_copied)){
      unlink("./data/".$file_copied);
    }

    $sql="UPDATE `community` SET `file_name`='', `file_copied` ='', `file_type` =''  WHERE `num`=$q_num and `b_code`='다이어트후기';";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

  }

  //1번과 2번 파일삭제신경쓰지 않고 업로드가 됬느냐? 안됐는냐?
  if(!empty($_FILES['upfile']['name'])){
    //include 파일업로드기능
    include  "./lib/file_upload.php";

    $sql="UPDATE `community` SET `file_name`= '$db_name', `file_copied` ='$copied_file_name', `file_type` ='$db_type' WHERE `num`=$q_num;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
  }

  //3번 파일과 상관없이 무조건 내용중심으로 update한다.
  $sql="UPDATE `community` SET `subject`='$q_subject',`content`='$q_content',`regist_day`='$regist_day' WHERE `num`=$q_num;";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }

  echo "<script>alert('수정이 완료되었습니다.');</script>";
  echo "<script>location.href='./view.php?num=$num&page=1&hit=$hit';</script>";

}else if(isset($_GET["mode"])&&$_GET["mode"]=="insert_ripple"){
  if(empty($_POST["ripple_content"])){
    echo "<script>alert('댓글 내용을 입력해주세요');history.go(-1);</script>";
    exit;
  }
  //"덧글을 다는사람은 로그인을 해야한다." 말한것이다.
  $user_id=$_SESSION['user_id'];
  $q_userid = mysqli_real_escape_string($conn, $user_id);
  $sql="select * from members where id = '$q_userid'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $rowcount=mysqli_num_rows($result);

  if(!$rowcount){
    echo "<script>alert('없는 아이디입니다.');history.go(-1);</script>";
    exit;
  }else{
    $content = test_input($_POST["ripple_content"]);
    $page = test_input($_POST["page"]);
    $parent = test_input($_POST["parent"]);
    $hit = test_input($_POST["hit"]);
    $q_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    $q_username = mysqli_real_escape_string($conn, $_SESSION['user_name']);
    $b_code = test_input($_POST["b_code"]);
    $q_content = mysqli_real_escape_string($conn, $content);
    $q_parent = mysqli_real_escape_string($conn, $parent);
    $regist_day=date("Y-m-d (H:i)");

    $sql="INSERT INTO `comment` VALUES (null,'$q_parent','$q_userid','$q_username','$q_content','$regist_day','$b_code')";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);
    echo "<script>location.href='./view.php?num=$parent&page=$page&hit=$hit';</script>";
  }//end of if rowcount


}else if(isset($_GET["mode"])&&$_GET["mode"]=="delete_ripple"){
  $page= test_input($_GET["page"]);
  $hit= test_input($_GET["hit"]);
  $num = test_input($_POST["num"]);
  $parent = test_input($_POST["parent"]);
  $q_num = mysqli_real_escape_string($conn, $num);

  $sql ="DELETE FROM `comment` WHERE `b_code`='다이어트후기' and `num` =$q_num";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  mysqli_close($conn);
  echo "<script>location.href='./view.php?num=$parent&page=$page&hit=$hit';</script>";

}//end of if insert

?>
