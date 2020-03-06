<?php
date_default_timezone_set("Asia/seoul");

$servername = "localhost";
$username = "root";
$password = "123456";


$dbflag = "NO";
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "show databases";
$result = mysqli_query($conn, $sql) or die('Error: ' . mysqli_error($conn));
while ($row = mysqli_fetch_row($result)) {
    if ($row[0]==="helf") {
        $dbflag="OK";
        break;
    }
}
//$name=$sub1=$sub2=$sub3=$sub4=$sub5=$sum=$avg="";
//$mode=$result="";
if ($dbflag==="NO") {
    $sql = "CREATE database helf";

    if (mysqli_query($conn, $sql)) {
        echo '<script >
        alert("helf 데이터베이스가 생성되었습니다.");
      </script>';
    } else {
        //echo "실패원인".mysqli_query($conn,$sql);
        echo "실패원인".mysqli_error($conn);
    }
}


$dbconn = mysqli_select_db($conn, "helf") or die('Error:' . mysqli_error($conn));