<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

  if (isset($_GET["mode"])) $mode = $_GET["mode"];
  else $mode = "";

  if (isset($_GET["delete_id"])) {$delete_id = $_GET["delete_id"]; echo "$delete_id ///";}
  else {$delete_id = "";}

  if (isset($_POST["id"])) $id = $_POST["id"];
  else $id = "";

  if (isset($_POST["name"])) $type = $_POST["name"];
  else $type = "";

  if (isset($_POST["phone"])) $subject = $_POST["phone"];
  else $subject = "";

  if (isset($_POST["email"])) $content = $_POST["email"];
  else $content = "";

  if (isset($_POST["address"])) $phone_number = $_POST["address"];
  else $phone_number = "";

  if (isset($_POST["grade"])) $grade = $_POST["grade"];
  else $grade = "왜안떠";



 //게시글 등록
  function program_insert($conn, $shop, $type, $subject, $content, $phone_number, $end_day, $choose, $price, $location,
    $upfile_name, $upfile_type, $copied_file_name, $regist_day)
  {
      $sql = "insert into program (shop , type, subject, content, phone_number, end_day, choose, price, location, file_name, file_type, file_copied, regist_day) ";
      $sql .= "values('$shop', '$type', '$subject', '$content', $phone_number,'$end_day','$choose', $price,'$location', ";
      $sql .= "'$upfile_name', '$upfile_type', '$copied_file_name','$regist_day')";

      mysqli_query($conn, $sql);
  }

  //유저삭제
  function user_delete($conn, $delete_id)
  {
    $sql = "delete from members where id = '$delete_id';";

    mysqli_query($conn, $sql);
    mysqli_close($conn);

  }

//유저등급
  function user_modify($conn, $id, $grade)
  {
    $sql = "update members set grade ='$grade' where id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "수정 완료";
    } else {
      echo "수정 실패";
    }
    // echo "<script>alert('회원등급 수정완료')</script>";
  }

  switch ($mode) {
    case 'delete':
      user_delete($conn, $delete_id);
      echo "
         <script>
          alert('탈퇴되었습니다.');
          location.href = 'admin_user.php';
         </script>
       ";
      break;
    case 'modify':
        user_modify($conn, $id, $grade);
      // echo "
      //    <script>
      //        location.href = 'admin_user.php';
      //    </script>
      //  ";
      break;
    case 'insert':
     program_insert($conn, $shop, $type, $subject, $content, $phone_number, $end_day, $choose, $price, $location, $upfile_name, $upfile_type, $copied_file_name, $regist_day);
     echo "
   	   <script>
   	    location.href = 'admin_page.php';
   	   </script>
   	";
    break;

    default:

      break;
  }
?>
