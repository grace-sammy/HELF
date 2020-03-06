<?php
  session_start();
  if(isset($_SESSION["user_id"])){
    $id = $_SESSION["user_id"];
  } else {
    echo ("<script>alert('로그인 후 이용해 주세요!')
    history.go(-2);
    </script>");
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: 구매 내역</title>
    <link rel="stylesheet" href="./css/mypage.css">
    <link rel="stylesheet" href="./css/program.css">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <link
        rel="stylesheet"
        type="text/css"
        href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link
        rel="stylesheet"
        type="text/css"
        href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/main.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>

    <script src="http://code.jquery.com/jquery-1.12.4.min.js" charset="utf-8"></script>
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
    <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/js/main.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        // url에서 get 값 지워줌;
        history.pushState(null, null, "http://localhost/helf/mypage/mypage_buy.php");

        $("#all_agree").click(function() {
          if($("#all_agree").prop("checked")) {
            $("input[type=checkbox]").prop("checked",true);
          } else {
             $("input[type=checkbox]").prop("checked",false);
          }
        });

        $("input[type=checkbox]").change(function() {
          if($("input[type=checkbox]:checked").length !== $("input[type=checkbox]").length) {
            $("#all_agree").prop("checked",false);
          }

          if($("input[type=checkbox]:checked").length === $("input[type=checkbox]").length-1) {
            $("#all_agree").prop("checked",true);
          }

        });
      })
    </script>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
    </header>
    <?php


      if(isset($_GET["page"])) {
        $page = $_GET["page"];
      } else {
        $page = "1";
      }

      if(isset($_GET["num"])) {
        $num = $_GET["num"];

        $sql = "delete from sales where num=$num;";
        mysqli_query($conn, $sql);

        echo "
        <script>
          alert('삭제되었습니다.');
        </script>
        ";

      } else {
        $num = "";
      }

      if(isset($_POST["no"])) {
        $no = $_POST["no"];

        for ($i=0; $i<count($no); $i++) {
          $sql = "delete from sales where num=$no[$i];";
          mysqli_query($conn, $sql);
        }

        echo "
        <script>
          alert('삭제되었습니다.');
        </script>
        ";

      } else {
        $no = "";
      }

    ?>
    <div id="mypage_container">
      <section>
        <div id="mypage_main_content">
          <div id="title_mypage">
            <h1>마이페이지</h1>
          </div>
          <div id="mypage_buttons">
            <div id="mywrite_board" onclick="location.href='./mypage_board.php'">
              <a>
                <p>내가 쓴 글</p>
              </a>
            </div>
            <div id="mywrite_comment"onclick="location.href='./mypage_comment.php'">
              <a>
                <p>내가 쓴 댓글</p>
              </a>
            </div>
            <div id="mywrite_review" onclick="location.href='./mypage_review.php'">
              <a>
                <p>내가 쓴 상품평</p>
              </a>
            </div>
            <div id="mywrite_question" onclick="location.href='./mypage_question.php'">
              <a>
                <p>내가 쓴 상품문의</p>
              </a>
            </div>
            <div id="fick_list" onclick="location.href='./mypage_pick.php'">
              <a>
                <p>찜한 상품</p>
              </a>
            </div>
            <div id="buy_list" class="select_tap" onclick="location.href='./mypage_buy.php'">
              <a>
                <p>구매 내역</p>
              </a>
            </div>
          </div>
          <div id="mypage_content">
            <form id="delete_buy_form" action="mypage_buy.php?page=<?=$page?>" method="post">
              <div id="all_check">
                <input type="checkbox" id="all_agree">
                <span>전체 선택</span>
                <input type="submit" id="btn_submit" value="선택 상품 삭제">
              </div>
            <ul id="program_list">
            <?php

                $sql = "select * from sales A inner join program B on A.o_key = B.o_key where id = '$id' order by num;";
                $result = mysqli_query($conn, $sql);
                $total_record = mysqli_num_rows($result); // 전체 글 수

                $scale = 5;

                // 전체 페이지 수($total_page) 계산
                if ($total_record % $scale == 0) {
                    $total_page = floor($total_record/$scale);
                } // 소수점 내림, 반올림은 round, 올림은 ceil
                else {
                    $total_page = floor($total_record/$scale) + 1;
                }

                // 표시할 페이지($page)에 따라 $start 계산
                $start = ($page - 1) * $scale; // 페이지 세팅 넘버!!!!!

                $number = $total_record - $start;

               for ($i=$start; $i<$start+$scale && $i < $total_record; $i++) {
                   mysqli_data_seek($result, $i);
                   // 가져올 레코드로 위치(포인터) 이동
                   $row = mysqli_fetch_array($result);
                   // 하나의 레코드 가져오기
                   $sales_day    = $row["sales_day"];
                   $payment = $row["payment"];
                   $num          = $row["num"];
                   $o_key        = $row["o_key"];
                   $shop         = $row["shop"];
                   $type         = $row["type"];
                   $subject      = $row["subject"];
                   $end_day      = $row["end_day"];
                   $price        = $row["price"];
                   $choose       = $row["choose"];
                   $location     = $row["location"];
                   $location = str_replace(","," ",$location);
                   $payment_status = $row["complete"];
                   $file_copied  = $row["file_copied"];
                   $file_type    = $row["file_type"];

                    ?>

                          <li>
                            <div class="program_pick_li">
                              <div class="program_image">
                                <a href="../program/program_detail.php?o_key=<?=$o_key?>">
                                <img src='../admin/data/<?=$file_copied?>'>
                                </a>
                              </div>
                              <div class="program_detail">
                                <a href="../program/program_detail.php?o_key=<?=$o_key?>">
                                  <div class="info_1"><?=$shop?> | <?=$type?> | <?=$location?></div>
                                  <div class="info_2"><?=$subject?></div>
                                  <div class="info_3">모집기간 : <?=$end_day?> 까지</div>
                                  <div class="info_4">선택한 옵션 : <?=$choose?></div>
                                  <div class="program_buy_day">구매일 : <?=$sales_day?></div>
                                  <div class="status"><?=$payment_status?> (<?=$payment?>)</div>
                                </a>
                              </div>
                              <div class="program_price">
                                <p><?=$price?><span> 원</span>
                                <div class="buttons">
                                  <button type="button" id="delete_btn" onclick="location.href='mypage_buy.php?num=<?=$num?>&page=<?=$page?>'">삭제</button>
                                </div>
                              </div>
                              <div class="checkbox_div">
                                <input type="checkbox" name="no[]" value="<?=$num?>">
                              </div>
                            </div>
                          </li>

                    <?php
                   $number--;
                    }

                   function str_cutting($string, $len){
                    if(strlen($string)<$len) {
                         return $string; //자를길이보다 문자열이 작으면 그냥 리턴
                    }
                    else {
                         $string = substr($string, 0, $len);
                         $cnt = 0;
                         for ($i=0; $i<strlen($string); $i++)
                             if (ord($string[$i]) > 127) $cnt++; //한글일 경우 2byte 옮김,자릿수
                             $string = substr($string, 0, $len - ($cnt % 3));
                         $string.="..."; //커팅된 문자열에 꼬리부분을 붙여서 리턴
                         return $string;
                    }
                  }
            ?>
                    </ul>

                  </form>
                  <ul id="page_num">
            <?php
                if ($total_page>=2 && $page >= 2) {
                    $new_page = $page-1;
                    echo "<li><a href='mypage_buy.php?page=$new_page'>◀ 이전</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }

                // 게시판 목록 하단에 페이지 링크 번호 출력
                for ($i=1; $i<=$total_page; $i++) {
                    if ($page == $i) {     // 현재 페이지 번호 링크 안함
                        echo "<li><b> $i </b></li>";
                    } else {
                        echo "<li><a href='mypage_buy.php?page=$i'>  $i  </a><li>";
                    }
                }
                if ($total_page>=2 && $page != $total_page) {
                    $new_page = $page+1;

                    echo "<li> <a href='mypage_buy.php?page=$new_page'>다음 ▶</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }
            ?>
            </ul> <!-- page -->
        </div>
      </section>
      <aside>
          <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/aside.php";?>
      </aside>
    </div>

    <footer>
    <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>
  </body>
</html>
