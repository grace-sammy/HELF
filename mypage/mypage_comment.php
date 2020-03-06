<?php
  session_start();
  if(isset($_SESSION["user_id"])){
    $id = $_SESSION["user_id"];
  } else {
    echo ("<script>alert('로그인 후 이용해 주세요!')
    history.go(-2);
    </script>");
  }
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
    <title>HELF :: 내가 쓴 댓글</title>
    <link rel="stylesheet" href="./css/mypage.css">
    <link rel="stylesheet" href="./css/board.css">
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
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
    </header>
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
            <div id="mywrite_comment" class="select_tap" onclick="location.href='./mypage_comment.php'">
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
            <div id="buy_list" onclick="location.href='./mypage_buy.php'">
              <a>
                <p>구매 내역</p>
              </a>
            </div>
          </div>
          <div id="mypage_content">
            <ul id="board_list">
            	<li>
                  <span class="col1">번호</span>
                  <span class="col2">게시판</span>
                  <span class="col7">내용</span>
                  <span class="col8">날짜</span>
            	</li>
            <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                }

                $sql = "select * from comment where id='$id' order by regist_day desc";
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
                   $parent      = $row["parent"];
                   $b_code      = $row["b_code"];
                   $content     = $row["content"];
                   $regist_day  = $row["regist_day"];


                   $sql2 = "select num,hit from community where num=$parent and b_code='$b_code' union ";
                   $sql2 .= "select num,hit from together where num=$parent and b_code='$b_code' union ";
                   $sql2 .= "select num,hit from health_info where num=$parent and b_code='$b_code';";

                   $result2 = mysqli_query($conn, $sql2);
                   $row2 = mysqli_fetch_array($result2);
                   $num       = $row2["num"];
                   $hit       = $row2["hit"];

                    ?>
            				<li id="board_content">
            					<span class="col1"><?=$number?></span>
            					<span class="col2"><?=$b_code?></span>
                      <?php if ($b_code === "자유게시판") { ?>
                        <span class="col7"><a href="../community/free/view.php?num=<?=$num?>&page=<?=$page?>&hit=<?=$hit+1?>"><?=str_cutting($content,93)?></a></span>
                      <?php } else if ($b_code === "다이어트후기") { ?>
                        <span class="col7"><a href="../community/review/view.php?num=<?=$num?>&page=<?=$page?>&hit=<?=$hit+1?>"><?=str_cutting($content,93)?></a></span>
                      <?php } else if ($b_code === "같이할건강") { ?>
                        <span class="col7"><a href="../together/view.php?num=<?=$num?>&page=<?=$page?>&hit=<?=$hit+1?>"><?=str_cutting($content,93)?></a></span>
                      <?php } else if ($b_code === "레시피") { ?>
                        <span class="col7"><a href="../health_info/recipe/view.php?num=<?=$num?>&page=<?=$page?>&hit=<?=$hit+1?>"><?=str_cutting($content,93)?></a></span>
                      <?php } else { ?>
                        <span class="col7"><a href="../health_info/exercise/view.php?num=<?=$num?>&page=<?=$page?>&hit=<?=$hit+1?>"><?=str_cutting($content,93)?></a></span>
                      <?php } ?>
                      <span class="col8"><?=$regist_day?></span>
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

            			<ul id="page_num">
            <?php
                if ($total_page>=2 && $page >= 2) {
                    $new_page = $page-1;
                    echo "<li><a href='mypage_comment.php?page=$new_page'>◀ 이전</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }

                // 게시판 목록 하단에 페이지 링크 번호 출력
                for ($i=1; $i<=$total_page; $i++) {
                    if ($page == $i) {     // 현재 페이지 번호 링크 안함
                        echo "<li><b> $i </b></li>";
                    } else {
                        echo "<li><a href='mypage_comment.php?page=$i'>  $i  </a><li>";
                    }
                }
                if ($total_page>=2 && $page != $total_page) {
                    $new_page = $page+1;

                    echo "<li> <a href='mypage_comment.php?page=$new_page'>다음 ▶</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }
            ?>
            </ul> <!-- page -->
          </div>
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
