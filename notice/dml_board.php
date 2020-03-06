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
<?php
//*****************************************************
$content= $q_content = $sql= $result = $userid="";
$group_num = 0;
//*****************************************************
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_grade = $_SESSION['user_grade'];

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
    $user_id = test_input($user_id);
    $hit = 0;
    $q_subject = mysqli_real_escape_string($conn, $subject);
    $q_content = mysqli_real_escape_string($conn, $content);
    $q_userid = mysqli_real_escape_string($conn, $user_id);
    $q_username = mysqli_real_escape_string($conn, $user_name);
    $regist_day=date("Y-m-d (H:i)");

    $upload_dir = './data/';

    $upfile_name	 = $_FILES["upfile"]["name"];
  	$upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
  	$upfile_type     = $_FILES["upfile"]["type"];
  	$upfile_size     = $_FILES["upfile"]["size"];
  	$upfile_error    = $_FILES["upfile"]["error"];

    if ($upfile_name && !$upfile_error)
  	{
  		$file = explode(".", $upfile_name);
  		$file_name = $file[0];
  		$file_ext  = $file[1];

  		$new_file_name = date("Y_m_d_H_i_s");
  		$new_file_name = $new_file_name;
  		$copied_file_name = $new_file_name.".".$file_ext;
  		$uploaded_file = $upload_dir.$copied_file_name;

      $type=explode("/", $upfile_type);

      if ($type[0]=='image') {
          switch ($type[1]) {
      case 'gif': case 'jpg': case 'png': case 'jpeg':
        case 'pjpeg': break;
        default:alert_back('3. gif jpg png 확장자가아닙니다.');
      }
          if ($upfile_size>2000000) {
              alert_back('2. 이미지파일사이즈가 2MB이상입니다.');
          }
      } else {
          if ($upfile_size>500000) {
              alert_back('2. 파일사이즈가 500KB이상입니다.');
          }
      }
      if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
          alert_back('4. 서버 전송에러!!');
      }
  	}
  	else
  	{
  		$upfile_name      = "";
  		$upfile_type      = "";
  		$copied_file_name = "";
  	}

    //그룹번호, 들여쓰기 기본값
    $sql="INSERT INTO `notice` VALUES (null,'$q_subject','$q_content','$regist_day',$hit,'$upfile_name','$type[0]','$copied_file_name');";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);

    // echo "<script>location.href='./view.php?num=$max_num&hit=$hit';</script>";
    echo "<script>location.href='./notice.php';</script>";
}else if(isset($_GET["mode"])&&$_GET["mode"]=="delete"){
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    $sql ="DELETE FROM `notice` WHERE num=$q_num";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    mysqli_close($conn);
    echo "<script>location.href='./notice.php?page=1';</script>";

}else if(isset($_GET["mode"])&&$_GET["mode"]=="update"){
  if(isset($_POST['del_file'])&&$_POST['del_file']==1){
    $del_file=$_POST['del_file'];
  }
  $content = trim($_POST["content"]);
  $subject = trim($_POST["subject"]);
  if(empty($content)||empty($subject)){
    echo "<script>alert('내용이나제목입력요망!');history.go(-1);</script>";
    exit;
  }
  $subject = test_input($_POST["subject"]);
  $content = test_input($_POST["content"]);
  $userid = test_input($userid);
  $num = test_input($_POST["num"]);
  $hit = test_input($_POST["hit"]);
  $q_subject = mysqli_real_escape_string($conn, $subject);
  $q_content = mysqli_real_escape_string($conn, $content);
  $q_userid = mysqli_real_escape_string($conn, $userid);
  $q_num = mysqli_real_escape_string($conn, $num);
  $regist_day=date("Y-m-d (H:i)");

  $upload_dir = './data/';

  $upfile_name	 = $_FILES["upfile"]["name"];
  $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
  $upfile_type     = $_FILES["upfile"]["type"];
  $upfile_size     = $_FILES["upfile"]["size"];
  $upfile_error    = $_FILES["upfile"]["error"];

  if ($upfile_name && !$upfile_error)
  {
    $file = explode(".", $upfile_name);
    $file_name = $file[0];
    $file_ext  = $file[1];

    $new_file_name = date("Y_m_d_H_i_s");
    $new_file_name = $new_file_name;
    $copied_file_name = $new_file_name.".".$file_ext;
    $uploaded_file = $upload_dir.$copied_file_name;

    $type=explode("/", $upfile_type);

    if ($type[0]=='image') {
        switch ($type[1]) {
    case 'gif': case 'jpg': case 'png': case 'jpeg':
      case 'pjpeg': break;
      default:alert_back('3. gif jpg png 확장자가아닙니다.');
    }
        if ($upfile_size>2000000) {
            alert_back('2. 이미지파일사이즈가 2MB이상입니다.');
        }
    } else {
        if ($upfile_size>500000) {
            alert_back('2. 파일사이즈가 500KB이상입니다.');
        }
    }
    if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
        alert_back('4. 서버 전송에러!!');
    }
  }
  else
  {
    $upfile_name      = "";
    $upfile_type      = "";
    $copied_file_name = "";
  }
  if($upfile_name==="" || $upfile_type==="" || $copied_file_name===""){
    $sql="UPDATE `notice` SET `subject`='$q_subject',`content`='$q_content',`regist_day`='$regist_day' WHERE `num`=$q_num;";
  }else{
    $sql="UPDATE `notice` SET `subject`='$q_subject',`content`='$q_content',`regist_day`='$regist_day',`file_name`='$upfile_name',`file_type`='$type[0]',`file_copied`='$copied_file_name' WHERE `num`=$q_num;";
  }
  if($del_file==="1"){
    $upfile_name      = "";
    $upfile_type      = "";
    $copied_file_name = "";
    $sql="UPDATE `notice` SET `subject`='$q_subject',`content`='$q_content',`regist_day`='$regist_day',`file_name`='$upfile_name',`file_type`='$type[0]',`file_copied`='$copied_file_name' WHERE `num`=$q_num;";
  }
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script>location.href='./view.php?num=$num&hit=$hit';</script>";
}//end of if insert
// Header("Location: p260_score_list.php");
?>
