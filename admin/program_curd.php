<meta charset="utf-8">
<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/helf//common/lib/db_connector.php";

  if (isset($_GET["mode"])) {
    $mode = $_GET["mode"];
  }
  else $mode = "";

  if (isset($_GET["o_key"])) $o_key = $_GET["o_key"];
  else $o_key = "";



  if (isset($_POST["shop"])) $shop = $_POST["shop"];
  else $shop = "";

  if (isset($_POST["type"])) $type = $_POST["type"];
  else $type = "";

  if (isset($_POST["subject"])) $subject = $_POST["subject"];
  else $subject = "";

  if (isset($_POST["content"])) $content = $_POST["content"];
  else $content = "";

  if (isset($_POST["phone_number"])) $phone_number = $_POST["phone_number"];
  else $phone_number = "";

  if (isset($_POST["end_day"])) $end_day = $_POST["end_day"];
  else $end_day = "";

  if (isset($_POST["choose"])) $choose = $_POST["choose"];
  else $choose = "";

  if (isset($_POST["price"])) $price = $_POST["price"];
  else $price = "";

  if (isset($_POST["s_area1"])){
    switch ($_POST["s_area1"]) {
      case '1':
        $h_area1 = "서울";
        break;
      case '2':
        $h_area1 = "부산";
        break;
      case '3':
        $h_area1 = "대구";
        break;
      case '4':
        $h_area1 = "인천";
        break;
      case '5':
        $h_area1 = "광주";
        break;
      case '6':
        $h_area1 = "대전";
        break;
      case '7':
        $h_area1 = "울산";
        break;
      case '8':
        $h_area1 = "강원";
        break;
      case '9':
        $h_area1 = "경기";
        break;
      case '10':
        $h_area1 = "경남";
        break;
      case '11':
        $h_area1 = "경북";
        break;
      case '12':
        $h_area1 = "전남";
        break;
      case '13':
        $h_area1 = "전북";
        break;
        case '14':
        $h_area1 = "제주";
        break;
      case '15':
        $h_area1 = "충남";
        break;
      case '16':
        $h_area1 = "충북";
        break;
      case '17':
        $h_area1 = "세종";
        break;
      default:
        $h_area1 = "전체";
        break;
    }

  }

  if (isset($_POST["s_area2"])){
    if($_POST["s_area2"] === "-선택-"){
      $h_area2 = "전체";
    }else{
      $h_area2 = $_POST["s_area2"];
    }
  }

  if (isset($_POST["detail"])) $detail = $_POST["detail"];
  else $detail = "";

  if($mode === "insert"){
    $location = $h_area1.",".$h_area2.",".$detail;
  }
  $db_name = "";



  if (isset($_FILES["upfile"]["name"])) {
      $upfile_name = $_FILES["upfile"]["name"];
      for($i=0; $i<count($upfile_name);$i++){
        if($i === 0){
          $db_name = $upfile_name[$i];
        }else{
          $db_name = $db_name.",".$upfile_name[$i];
        }
      }

  } else {
      $upfile_name = "";
  }

  if (isset($_FILES["upfile"]["tmp_name"])) {
      $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
  } else {
      $upfile_tmp_name = "";
  }

  if (isset($_FILES["upfile"]["type"])) {
      $upfile_type = $_FILES["upfile"]["type"];
      for($i=0; $i<count($upfile_type);$i++){
        if($i === 0){
          $db_type = $upfile_type[$i];
        }else{
          $db_type = $db_type.",".$upfile_type[$i];
        }
      }

  } else {
      $upfile_type = "";
  }

  if (isset($_FILES["upfile"]["size"])) {
      $upfile_size = $_FILES["upfile"]["size"];
  } else {
      $upfile_size = "";
  }
  if (isset($_FILES["upfile"]["error"])) {
      $upfile_error = $_FILES["upfile"]["error"];
  } else {
      $upfile_error = "";
  }

  $regist_day = date("Y-m-d");  // 현재의 '년-월-일-시-분'을 저장

  $upload_dir = './data/';

if($mode === "insert"){
  if ($upfile_name[0]) {
    for($i=0; $i<count($upfile_name);$i++){
      $file = explode(".", $upfile_name[$i]);
      $file_ext  = $file[1];
      $new_file_name = date("Y_m_d_H_i_s").mt_rand(1,1000);
      $copied_file_named = $new_file_name.".".$file_ext;
      $uploaded_file = $upload_dir.$copied_file_named;
      if($i === 0){
         $copied_file_name = $copied_file_named;
       }else{
         $copied_file_name = $copied_file_name.",".$copied_file_named;
       }

      if ($upfile_size[$i]  > 1000000) {
          echo("
      <script>
      alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
      history.go(-1)
      </script>
      ");
          exit;
      }

      if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file)) {
            echo("
          <script>
          alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
          history.go(-1)
          </script>
        ");
            exit;
        }

    }
  //  echo "<script>alert('$copied_file_name')</script>";
    }else {
      echo("
    <script>
    alert('이미지를 선택해주세요');
    history.go(-1)
    </script>
  ");
      exit;
    }
}


 //게시글 등록
  function program_insert($conn, $shop, $type, $subject, $content, $phone_number, $end_day, $choose, $price, $location,
    $db_name, $db_type, $copied_file_name, $regist_day)
  {
    $min_price = 10000000;
    for($i=0; $i<count($_POST["choose"]); $i++){
      $choose = $_POST["choose"][$i];
      $price = $_POST["price"][$i];
      if($min_price > $price){
        $min_price = $price;
      }

      $sql = "insert into program (shop , type, subject, content, phone_number, end_day, choose, price, location, file_name, file_type, file_copied, regist_day) ";
      $sql .= "values('$shop', '$type', '$subject', '$content', $phone_number,'$end_day','$choose', $price,'$location', ";
      $sql .= "'$db_name', '$db_type', '$copied_file_name','$regist_day')";

      mysqli_query($conn, $sql);
    }
    $choose = "선택";

    $sql = "insert into program (shop , type, subject, content, phone_number, end_day, choose, price, location, file_name, file_type, file_copied, regist_day) ";
    $sql .= "values('$shop', '$type', '$subject', '$content', $phone_number,'$end_day','$choose', $min_price,'$location', ";
    $sql .= "'$db_name', '$db_type', '$copied_file_name','$regist_day')";


    mysqli_query($conn, $sql);


      mysqli_close($conn);                // DB 연결 끊기
  }

//프로그램 삭제
function program_delete($conn, $o_key){

      $sql = "select * from program where o_key = $o_key";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $copied_name = $row["file_copied"];

      if ($copied_name)
      {
          $file_path = "./data/".$copied_name;
          unlink($file_path);
      }

      $sql = "delete from program where o_key = $o_key";
      mysqli_query($conn, $sql);
      mysqli_close($conn);

}

//게시글 수정
function program_modify($conn, $o_key, $choose, $price, $s_key, $shop, $type, $subject){

    $choose = $_POST["choose"][0];
    $price = $_POST["price"][0];

      $sql = "update program set choose = '$choose', price = '$price' where o_key=$o_key;";
      $result = mysqli_query($conn, $sql);

      $sql2 = "select price from program where shop='$shop' and type='$type' and subject='$subject' and choose not in('선택') order by price;";
      $result2 = mysqli_query($conn, $sql2);
      $row2 = mysqli_fetch_array($result2);

      $low_price = $row2["price"];

      $sql3 = "update program set price = '$low_price' where o_key=$s_key;";
      $result3 = mysqli_query($conn, $sql3);

      mysqli_close($conn);
  }


  switch ($mode) {
    case 'delete':
      program_delete($conn , $o_key);
      echo "
         <script>
              alert('삭제되었습니다.');
             location.href = 'admin_program_manage.php';
         </script>
       ";
      break;
    case 'modify':

      $sql = "select o_key from program where shop='$shop' and type='$type' and subject='$subject' and choose='선택';";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $s_key = $row["o_key"];

      program_modify($conn, $o_key, $choose, $price, $s_key, $shop, $type, $subject);
      echo "
         <script>
              alert('수정되었습니다.');
              location.href = 'admin_program_manage.php';
         </script>
       ";
      break;
    case 'insert':
    program_insert($conn, $shop, $type, $subject, $content, $phone_number, $end_day, $choose, $price, $location, $db_name, $db_type, $copied_file_name, $regist_day);
     echo "
   	   <script>
   	    location.href = 'admin_program_payment.php';
   	   </script>
   	";
    break;

    default:

      break;
  }
?>
