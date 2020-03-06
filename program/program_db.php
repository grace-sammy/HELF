<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

    if (!$conn) {
        die("Error connecting to database: " . mysqli_connect_error($conn));
        exit();
    }

    $num = 5;

    if (isset($_POST['list'])) {
      $count = $_POST['list'];
    }

    if(isset($_SESSION["user_id"])){
      $user_id = $_SESSION["user_id"];
    } else{
      $user_id = "로그인안함";
    }

    if(isset($_POST["s_type"])){
      $s_type = $_POST["s_type"];
    } else{
      $s_type = "";
    }

    if (isset($_POST["s_area1"])){
      switch ($_POST["s_area1"]) {
        case '1':
          $s_area1 = "서울";
          break;
        case '2':
          $s_area1 = "부산";
          break;
        case '3':
          $s_area1 = "대구";
          break;
        case '4':
          $s_area1 = "인천";
          break;
        case '5':
          $s_area1 = "광주";
          break;
        case '6':
          $s_area1 = "대전";
          break;
        case '7':
          $s_area1 = "울산";
          break;
        case '8':
          $s_area1 = "강원";
          break;
        case '9':
          $s_area1 = "경기";
          break;
        case '10':
          $s_area1 = "경남";
          break;
        case '11':
          $s_area1 = "경북";
          break;
        case '12':
          $s_area1 = "전남";
          break;
        case '13':
          $s_area1 = "전북";
          break;
          case '14':
          $s_area1 = "제주";
          break;
        case '15':
          $s_area1 = "충남";
          break;
        case '16':
          $s_area1 = "충북";
          break;
        case '17':
          $s_area1 = "세종";
          break;
        default:
          $s_area1 = "";
          break;
      }

    }else{
      $s_area1 = "";
    }

    if(isset($_POST["s_area2"])){
      $s_area2 = $_POST["s_area2"];
    } else{
      $s_area2 = "";
    }

     $s_area = $s_area1.",".$s_area2;

     if($s_area == ","){
       $s_area = "";
     }

    $sql = "select * from program ";
    // $sql .= "where choose = '선택' and type like '".$s_type."%' and location like '".$s_area."%' and price between ".$s_min_price." and ".$s_max_price." order by o_key desc limit ".$count.",".$num;
    $sql .= "where choose = '선택' order by o_key desc limit ".$count.",".$num;
    // execute query to effect changes in the database ...
    $result = mysqli_query($conn, $sql);

    for($i=0; $program=mysqli_fetch_array($result); $i++){
      $shop = $program[1];
      $type = $program[2];
      $o_key = $program[0];

      $sql2 = "select price from program where shop='".$shop."' and type='".$type."' order by price asc";
      $result2 = mysqli_query($conn, $sql2);
      $row2 = mysqli_fetch_array($result2);

      $sql3 = "select num from pick where id ='".$user_id."' and o_key =".$o_key;
      $result3 = mysqli_query($conn, $sql3);
      $row3 = mysqli_fetch_array($result3);

      $array[] = array("o_key" => $program[0] , "shop" => $program[1] , "type" => $program[2] , "subject" => $program[3] , "phone_number" => $program[5],
      "end_day" => $program[6] , "choose" => $program[7] , "price" => $row2["price"] , "location" => $program[9] , "file_copied" => $program[11], "pick" =>$row3["num"]);
    }

    echo json_encode($array);
