<?php
  session_start();
  if(isset($_SESSION["user_id"])){
    $id = $_SESSION["user_id"];
  } else {
    echo ("<script>alert('로그인 후 이용해 주세요!')
    history.go(-2);
    </script>");
  }?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: 장바구니</title>
    <link rel="stylesheet" href="./css/mypage.css">
    <link rel="stylesheet" href="./css/cart.css">
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
        history.pushState(null, null, "http://localhost/helf/mypage/cart_list.php");

        setTimeout(function() {
          $("input[type=checkbox]").prop("checked",true);
          $("input[type=checkbox]").trigger("click");
        }, 10);

        // 전체 선택
        $("#all_agree").change(function() {
          if($("#all_agree").prop("checked")) {
            $("input[type=checkbox]").prop("checked",true);

          } else {
             $("input[type=checkbox]").prop("checked",false);
          }
        });

        // 체크된 프로그램 가격 계산
        $("input[type=checkbox]").change(function () {

          if($("input[type=checkbox]:checked").length !== $("input[type=checkbox]").length) {
            $("#all_agree").prop("checked",false);
          }

          if($("input[type=checkbox]:checked").length === $("input[type=checkbox]").length-1) {
            $("#all_agree").prop("checked",true);
          }

          if($("input[type=checkbox]:checked").length === 0) {
            $("#total_price").html("0");
          } else {
            var items = [];
            $("input[type=checkbox]:checked").each(function () {
              var check_value = $(this).val();
              // console.log("밸류확인 : " + check_value);
              items.push($(this).val());
              console.log("확인 : " + items);

              $.ajax({
                  url: 'cart_price_cal.php',
                  type: 'POST',
                  traditional: true,
                  data: {
                    "items[]": items
                  },
                  success: function(data) {
                    data = Number(data);
                    console.log("총합은 "+data)
                    $("#total_price").html(data);
                  }
                })
                .done(function() {
                  console.log("done");
                })
                .fail(function() {
                  console.log("error");
                })
                .always(function() {
                  console.log("complete");
                });
            });
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

        $sql = "delete from cart where num=$num;";
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
          $sql = "delete from cart where num=$no[$i];";
          $result = mysqli_query($conn, $sql);
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
        <div id="cart_main_content">
          <div id="title_mypage">
            <h1>장바구니</h1>
          </div>
          <div id="mypage_content">
            <form id="delete_cart_form" method="post">
              <div id="all_check">
                <input type="checkbox" id="all_agree" value="0">
                <span>전체선택</span>
                <input type="button" id="btn_submit" onclick="delete_cart();" value="선택 상품 삭제">
              </div>
            <ul id="program_list">
            <?php

                $sql = "select * from cart A inner join program B on A.o_key = B.o_key where id = '$id' order by num;";
                $result = mysqli_query($conn, $sql);
                $total_record = mysqli_num_rows($result); // 전체 글 수

               for ($i=0; $i<$total_record; $i++) {
                   $row = mysqli_fetch_array($result);
                   // 하나의 레코드 가져오기
                   $num          = $row["num"];
                   $o_key        = $row["o_key"];
                   $shop         = $row["shop"];
                   $type         = $row["type"];
                   $subject      = $row["subject"];
                   $end_day      = $row["end_day"];
                   $price        = $row["price"];
                   $choose       = $row["choose"];
                   $location     = $row["location"];
                   $file_copied  = $row["file_copied"];
                   $file_type    = $row["file_type"];

                   $location = str_replace(","," ",$location);

                   $file_copied = explode(",",$file_copied);
                   $file_copied1 = $file_copied[0];


                    ?>

                          <li>
                            <div class="program_cart_li">
                              <div class="program_image">
                                <a href="../program/program_detail.php?o_key=<?=$o_key?>">
                                <img src='../admin/data/<?=$file_copied1?>'>
                                </a>
                              </div>
                              <div class="program_detail">
                                <a href="../program/program_detail.php?o_key=<?=$o_key?>">
                                  <div class="info_1"><?=$shop?> | <?=$type?> | <?=$location?></div>
                                  <div class="info_2"><?=$subject?></div>
                                  <div class="info_3">모집기간 : <?=$end_day?> 까지</div>
                                  <div class="info_4">선택한 옵션 : <?=$choose?></div>
                                </a>
                              </div>
                              <div class="program_price">
                                <p><?=$price?><span> 원</span>
                                <div class="buttons">
                                  <button type="button" id="buy_btn" onclick="location.href='../program/program_purchase.php?num=<?=$num?>'">구매하기</button> <br>
                                  <button type="button" id="delete_btn" onclick="location.href='cart_list.php?num=<?=$num?>&page=<?=$page?>'">삭제</button>
                                </div>
                              </div>
                              <div class="checkbox_div">
                                <input type="checkbox" id="checked_num" name="no[]" value="<?=$num?>">
                              </div>
                            </div>
                          </li>

                    <?php
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
                  <script type="text/javascript">
                    function delete_cart() {
                      $("#delete_cart_form").prop("action","cart_list.php?page=<?=$page?>");
                      $("#delete_cart_form").submit();
                    }

                    function go_purchase() {
                      $("#delete_cart_form").prop("action","../program/program_purchase.php");
                      $("#delete_cart_form").submit();
                    }
                  </script>
          </div>
          <div id="calculate_price">
            <div id="price_div">
              총 결제 금액 : <span id="total_price">0</span> 원
            </div>
          </div>
          <div id="calculate_buttons">
            <button type="button" id="shopping_btn" onclick="location.href='../program/program.php'">계속 쇼핑하기</button>
            <button type="button" id="select_buy_btn" onclick="go_purchase();">구매하기</button>
          </div>
        </div>
      </section>
    </div>

    <footer>
    <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>
  </body>
</html>
