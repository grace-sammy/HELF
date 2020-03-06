<?php

if (isset($_FILES["upfile"]["name"])) {
    $upfile_name = $_FILES["upfile"]["name"];
    for ($i=0;$i<count($upfile_name);$i++) {
        if ($i === 0) {
            $db_name = $upfile_name[$i];
        } else {
            $db_name = $db_name.",".$upfile_name[$i];
        }
    }
} else {
    $upfile_name="";
}

if (isset($_FILES["upfile"]["tmp_name"])) {
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
} else {
    $upfile_tmp_name="";
}

  if (isset($_FILES["upfile"]["type"])) {
      $upfile_type = $_FILES["upfile"]["type"];
      for ($i=0; $i<count($upfile_type);$i++) {
          if ($i === 0) {
              $db_type = $upfile_type[$i];
          } else {
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

$regist_day = date("Y-m-d");
$upload_dir='./data/';

if ($upfile_name[0]) {
    for ($i=0; $i<count($upfile_name);$i++) {
        $file = explode(".", $upfile_name[$i]);
        $file_ext  = $file[1];
        $new_file_name = date("Y_m_d_H_i_s").mt_rand(1, 1000);
        $copied_file_named = $new_file_name.".".$file_ext;
        $uploaded_file = $upload_dir.$copied_file_named;
        if ($i === 0) {
            $copied_file_name = $copied_file_named;
        } else {
            $copied_file_name = $copied_file_name.",".$copied_file_named;
        }
        if ($upfile_size[$i]  > 1000000) {
            echo("
    <script>
    alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
    history.go(-1);
    </script>
    ");
            exit;
        }

        if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file)) {
            echo("
        <script>
        alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
        history.go(-1);
        </script>
      ");
            exit;
        }
    }
    //echo "<script>alert('$copied_file_name')</script>";
} else {
  $copied_file_name="";
  $db_name="";
  $db_type="";

  echo "<script>location.href='./list.php';</script>";

}
