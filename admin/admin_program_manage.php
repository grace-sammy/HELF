<?php session_start();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>HELF :: 관리자페이지</title>
  <link rel="stylesheet" type="text/css" href="./css/admin.css">
  <link rel="stylesheet" href="./css/program_manager.css">
  <link rel="stylesheet" type="text/css" href="./css/admin_user.css">


  <script src="http://code.jquery.com/jquery-1.12.4.min.js" charset="utf-8"></script>
  <script src="./js/register.js"></script>
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


  <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
  <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/js/main.js"></script>

  <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/js/main.js"></script>
  <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/admin/js/materialize.js"></script>
  <script>
    $(document).ready(function(){
      M.AutoInit();
      $('.collapsible').collapsible();
    });
</script>
</head>
  <body>
    <header>
      <?php include "../common/lib/header.php";?>
    </header>
    <section>
      <div id="admin_border">
         <div id="snb">
           <div id="snb_title">
             <h1>관리자 페이지</h1>
           </div>
           <div id="admin_menu_bar">
             <h2>회원관리</h2><!-- /.menu-title -->
               <ul>
                 <li><a href="admin_user.php">회원관리</a></li>
               </ul>

             <h2>게시글 관리</h2>
               <ul>
                 <li><a href="admin_board_free.php">자유게시판</a></li>
                 <li><a href="admin_board_review.php">후기게시판</a></li>
                 <li><a href="admin_board_together.php">같이할건강</a></li>
               </ul>

             <h2>프로그램 관리</h2>
               <ul>
                 <li><a href="admin_program_regist.php">프로그램 등록</a></li>
                 <li><a href="admin_program_manage.php">프로그램 관리</a></li>
                 <li><a href="admin_program_payment.php">결제 관리</a></li>
               </ul>

             <h2>통계</h2>
               <ul id="sta_ul">
                 <li><a href="admin_statistics1.php">매출 분석</a></li>
                 <li><a href="admin_statistics2.php">인기 프로그램</a></li>
               </ul>
           </div>
         </div><!--  end of sub -->

         <div id="content">
            <h1 id="content_title">프로그램 관리 > 관리<p>프로그램명을 클릭하시면 해당 프로그램의 상세 정보를 보실 수 있습니다.</p></h1><br>
            <ul class = "collapsible" data-collapsible = "accordion">

            <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                }

                $sql = "select * from program group by shop, type, subject order by o_key";
                $result = mysqli_query($conn, $sql);
                $total_record = mysqli_num_rows($result); // 전체 글 수

                $scale = 10;

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

                    $shop         = $row["shop"];
                    $type         = $row["type"];
                    $subject      = $row["subject"];
                    $content      = $row["content"];
                    $phone_number    = $row["phone_number"];
                    $end_day      = $row["end_day"];
                    $location      = $row["location"];

                    $location = str_replace(","," ",$location);
                    ?>
                   <li>
                     <div class = "collapsible-header">
                       <span>
                         <div id="subjects">
                           <?=$subject?>
                         </div>
                         <div id="shop_type">
                           <?=$shop?> | <?=$type?>
                         </div>
                       </span>
                     </div>
                     <div class = "collapsible-body">
                      <table>
                        <tr id="first_tr">
                          <td class="td1">상호명</td>
                          <td class="td2"><?=$shop?></td>
                          <td class="td1">종류</td>
                          <td class="td2"><?=$type?></td>
                        </tr>
                        <tr>
                          <td class="td1">제목</td>
                          <td class="td2" colspan="3"><?=$subject?></td>
                        </tr>
                        <tr>
                          <td class="td1">전화번호</td>
                          <td class="td2"><?=$phone_number?></td>
                          <td class="td1">모집마감일</td>
                          <td class="td2"><?=$end_day?></td>
                        </tr>
                        <tr>
                          <td class="td1">내용</td>
                          <td class="td2" colspan="3" style="height:200px"><?=$content?></td>
                        </tr>
                        <tr>
                          <td class="td1">장소</td>
                          <td class="td2" colspan="3"><?=$location?></td>
                        </tr>
                        <tr>
                          <td class="td1">옵션</td>
                          <td class="td2" colspan="3">
                            <ul>

                              <?php
                                $sql2 = "select o_key,choose,price from program where shop='$shop' and type='$type' and subject='$subject';";
                                $result2 = mysqli_query($conn, $sql2);

                                while($row2 = mysqli_fetch_array($result2)) {
                                  $o_key        = $row2["o_key"];
                                  $choose = $row2["choose"];
                                  $price  = $row2["price"];
                                  ?>

                                  <li>
                                    <form class="program_modify_form" id="program_modify_form_<?=$o_key?>" action="program_curd.php?mode=modify&o_key=<?=$o_key?>" method="post">
                                        <input type="hidden" name="shop" value="<?=$shop?>">
                                        <input type="hidden" name="type" value="<?=$type?>">
                                        <input type="hidden" name="subject" value="<?=$subject?>">
                                        <input id="options" type="text" name="choose[]" value="<?=$choose?>" > &
                                        <input id="prices" type="number" name="price[]" value="<?=(int)$price?>" > 원
                                        <?php if(!($choose === "선택")) { ?>
                                        <button id="modify_btn_<?=$o_key?>" type="button" name="button" >수정</button>
                                        <?php } ?>
                                        <button id="delete_btn_<?=$o_key?>" type="button" name="button">삭제</button>
                                    </form>
                                  </li>
                                  <script type="text/javascript">
                                      $("#modify_btn_<?=$o_key?>").click(function() {
                                        $("#program_modify_form_<?=$o_key?>").submit();
                                      });
                                      $("#delete_btn_<?=$o_key?>").click(function() {
                                        location.href = 'program_curd.php?mode=delete&o_key=<?=$o_key?>';
                                      });
                                  </script>

                              <?php

                                 }
                              ?>
                            </ul>

                          </td>
                        </tr>
                      </table>
                     </div>
                   </li>
            <?php
                   $number--;
               }

            ?>
                    </ul>

                  <ul id="page_num">
            <?php
                if ($total_page>=2 && $page >= 2) {
                    $new_page = $page-1;
                    echo "<li><a href='admin_user.php?page=$new_page'>◀ 이전</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }

                // 게시판 목록 하단에 페이지 링크 번호 출력
                for ($i=1; $i<=$total_page; $i++) {
                    if ($page == $i) {     // 현재 페이지 번호 링크 안함
                        echo "<li><b> $i </b></li>";
                    } else {
                        echo "<li><a href='admin_user.php?page=$i'>  $i  </a><li>";
                    }
                }
                if ($total_page>=2 && $page != $total_page) {
                    $new_page = $page+1;

                    echo "<li> <a href='admin_user.php?page=$new_page'>다음 ▶</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }
            ?>
            </ul> <!-- page -->
          </div>		<!-- end of content -->
        </div><!--  end of admin_board -->
    </section>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>
  </body>
</html>
