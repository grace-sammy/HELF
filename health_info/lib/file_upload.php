<?php
//1. $_FILES['upfile']로부터 5가지 배열명을 가져와서 저장한다.
$upfile = $_FILES['upfile'];//한개파일업로드정보(5가지정보배열로들어있음)
$upfile_name= $_FILES['upfile']['name'];//f03.jpg
$upfile_type= $_FILES['upfile']['type'];
$upfile_tmp_name= $_FILES['upfile']['tmp_name'];
$upfile_error= $_FILES['upfile']['error'];
$upfile_size= $_FILES['upfile']['size'];

if ($upfile_name && !$upfile_error) {
    //2. 파일명과 확장자를 구분해서 저장한다.
$file = explode(".", $upfile_name); //파일명과 확장자구분에서 배열저장
$file_name = $file[0];              //파일명
$file_extension = $file[1];         //확장자

//3.업로드될 폴더를 지정한다.
$upload_dir ="./data/"; //업로드된파일을 저장하는장소지정

//4.파일업로드가성공되었는지 점검한다. 성공:0 실패:1
    //파일명이 중복되지 않도록 임의파일명을 정한다.
    if (!$upfile_error) {
        $new_file_name=date("Y_m_d_H_i_s");
        $new_file_name = $new_file_name."_"."0";
        $copied_file_name= $new_file_name.".".$file_extension;
        $uploaded_file = $upload_dir.$copied_file_name;
        // $uploaded_file = "./data/2019_04_22_15_09_30_0.jpg";
    }

    //6 업로드된 파일확장자를 체크한다.  "image/gif"
    // $type=explode("/", $upfile_type);
    $file_type = $upfile_type;


    //7. 임시저장소에 있는 파일을 서버에 지정한 위치로 이동한다.
    if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
        alert_back('서버 전송에러!!');
    }
} else {
    $upfile_name="";
    $upfile_type="";
    $copied_file_name="";

    echo "<script>location.href='./list.php';</script>";
}
