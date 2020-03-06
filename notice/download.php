<?php
include $_SERVER['DOCUMENT_ROOT']."/HELF/common/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";
$row=$file_name=$file_copied=$file_type="";

if(isset($_GET["mode"])&&$_GET["mode"]=="download"){
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    //등록된사용자가 최근 입력한 다운로드게시판을 보여주기 위하여 num 찾아서 전달하기 위함이다.
    $sql="SELECT * from `notice` where num ='$q_num';";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      alert_back('Error: 1' . mysqli_error($conn));
      // die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $file_name=$row['file_name'];
    $file_copied=$row['file_copied'];
    $file_type=$row['file_type'];
    mysqli_close($conn);
}

// 1. 테이블에서 파일명이 있는지 점검


if(empty($file_copied)){
    alert_back(' 테이블에 파일명이 존재 하지 않습니다.!');
}
$file_path = "./data/$file_copied";

//2. 서버에 Data영역에 실제 파일이 있는지 점검
if(file_exists($file_path)){
  $fp=fopen($file_path,"rb");  //$fp 파일 핸들값
  //지정된 파일타입일경우에는 모든 브라우저 프로토콜 규약이 되어있음.
  if($file_type){
    Header("Content-type: application/x-msdownload");
    Header("Content-Length: ".filesize($file_path));
    Header("Content-Disposition: attachment; filename=$file_name");
    Header("Content-Transfer-Encoding: binary");
    Header("Content-Description: File Transfer");
    Header("Expires: 0");
  //지정된 파일타입이 아닌경우

  }else{
    //타입이 알려지지 않았을때 익스플러러 프로토콜 통신방식
    if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)",$_SERVER['HTTP_USER_AGENT'])){
      Header("Content-type: application/octet-stream");
      Header("Content-Length: ".filesize($file_path));
      Header("Content-Disposition: attachment; filename=$file_name");
      Header("Content-Transfer-Encoding: binary");
      Header("Expires: 0");
    }else{
      Header("Content-type: file/unknown");
      Header("Content-Length: ".filesize($file_path));
      Header("Content-Disposition: attachment; filename=$file_name");
      Header("Content-Description: PHP3 Generated Data");
      Header("Expires: 0");
    }
  }

  fpassthru($fp);
  fclose($fp);
}else{
    alert_back(' 서버에 실제 파일이 존재 하지 않습니다.!');
}
?>
