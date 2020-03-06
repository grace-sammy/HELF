<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "./src/PHPMailer.php";
require "./src/SMTP.php";
require "./src/Exception.php";


$id = $_POST["email_one"];
$address = $_POST["email_two"];

$rv_id = $id."@".$address;

$mail = new PHPMailer(true);

try {
// 서버세팅
//디버깅 설정을 0 으로 하면 아무런 메시지가 출력되지 않습니다
$mail -> SMTPDebug = 2; // 디버깅 설정
$mail -> isSMTP(); // SMTP 사용 설정

// 지메일일 경우 smtp.gmail.com, 네이버일 경우 smtp.naver.com
$mail -> Host = "smtp.naver.com";               // 네이버의 smtp 서버
$mail -> SMTPAuth = true;                         // SMTP 인증을 사용함
$mail -> Username = "neul713@naver.com";    // 메일 계정 (지메일일경우 지메일 계정)
$mail -> Password = "quf4xkddd!";                  // 메일 비밀번호
$mail -> SMTPSecure = "ssl";                       // SSL을 사용함
$mail -> Port = 465;                                  // email 보낼때 사용할 포트를 지정
$mail -> CharSet = "utf-8"; // 문자셋 인코딩

// 보내는 메일
$mail -> setFrom("neul713@naver.com", "HELF");

// 받는 메일
$mail -> addAddress($rv_id, "");

// 메일 내용
$mail -> isHTML(true); // HTML 태그 사용 여부
$mail -> Subject = "HELF에서 발송하는 이메일 인증 요청 입니다.";  // 메일 제목

//랜덤 인증 번호
srand((double)microtime()*1000000); //난수값 초기화
$code=rand(100000,999999);

$mail -> Body = "이메일 인증번호 입니다.\n인증번호 : ".$code."\n정확히 입력해주세요.";     // 메일 내용

// Gmail로 메일을 발송하기 위해서는 CA인증이 필요하다.
// CA 인증을 받지 못한 경우에는 아래 설정하여 인증체크를 해지하여야 한다.
$mail -> SMTPOptions = array(
  "ssl" => array(
  "verify_peer" => false
  , "verify_peer_name" => false
  , "allow_self_signed" => true
  )
);

// 메일 전송
$mail -> send();
echo "$code";

} catch (Exception $e) {
echo "fail", $mail -> ErrorInfo;
}
?>
