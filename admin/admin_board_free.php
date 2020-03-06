<?php
  session_start();
  if(isset($_GET["page"])) {
    $page = $_GET["page"];
  } else {
    $page = "1";
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>HELF :: 관리자페이지</title>
  <link rel="stylesheet" type="text/css" href="./css/admin.css">
  <link rel="stylesheet" type="text/css" href="./css/admin_board.css">
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
      <?php include "../common/lib/header.php";?>
    </header>
    <?php
      if(isset($_POST["items"])) {
        $items = $_POST["items"];
        echo "ㅁㅎ";
        for ($i=0; $i<count($items); $i++) {
          $sql = "delete from community where num=$items[$i];";
          $result = mysqli_query($conn, $sql);
        }

        echo "
        <script>
          alert('삭제되었습니다.');
        </script>
        ";
      } else {
        $items = "";
      }
    ?>
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
           <h1 id="content_title">게시글 관리 > 자유게시판</h1><br>
           <form id="delete_board_form" action="admin_board_free.php?page=<?=$page?>" method="post">
             <div id="all_check">
               <input type="checkbox" id="all_agree">
               <span>전체 선택</span>
               <input type="submit" id="btn_submit" value="선택 삭제">
             </div>
           <ul id="board_list">
             <li id="board_kinds">
                 <span class="col1">번호</span>
                 <span class="col2">제목</span>
                 <span class="col3">아이디 (이름)</span>
                 <span class="col4">작성일</span>
                 <span class="col5">조회</span>
                 <span class="col6">추천</span>
             </li>
           <?php
               if (isset($_GET["page"])) {
                   $page = $_GET["page"];
               } else {
                   $page = 1;
               }

               $sql = "select * from community where b_code='자유게시판' order by num desc";
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
                  $num            = $row["num"];
                  $id             = $row["id"];
                  $name           = $row["name"];
                  $subject        = $row["subject"];
                  $regist_day     = $row["regist_day"];
                  $hit            = $row["hit"];
                  $likeit         = $row["likeit"];
                  ?>
                   <li id="board_content">
                     <span class="col1"><?=$number?></span>
                     <span class="col2"><a href="../community/free/view.php?num=<?=$num?>&page=<?=$page?>&hit=<?=$hit+1?>"><?=str_cutting($subject,85)?></a></span>
                     <span class="col3"><?=$id?> (<?=$name?>)</span>
                     <span class="col4"><?=$regist_day?></span>
                     <span class="col5"><?=$hit?></span>
                     <span class="col6"><?=$likeit?></span>
                     <div class="checkbox_div">
                       <input type="checkbox" name="items[]" value="<?=$num?>">
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
                   echo "<li><a href='admin_board_free.php?page=$new_page'>◀ 이전</a> </li>";
               } else {
                   echo "<li>&nbsp;</li>";
               }

               // 게시판 목록 하단에 페이지 링크 번호 출력
               for ($i=1; $i<=$total_page; $i++) {
                   if ($page == $i) {     // 현재 페이지 번호 링크 안함
                       echo "<li><b> $i </b></li>";
                   } else {
                       echo "<li><a href='admin_board_free.php?page=$i'>  $i  </a><li>";
                   }
               }
               if ($total_page>=2 && $page != $total_page) {
                   $new_page = $page+1;

                   echo "<li> <a href='admin_board_free.php?page=$new_page'>다음 ▶</a> </li>";
               } else {
                   echo "<li>&nbsp;</li>";
               }
           ?>
           </ul> <!-- page -->
         </div>	<!-- end of content -->
       </div> <!--  end of admin_board -->
    </section>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>
  </body>
</html>
