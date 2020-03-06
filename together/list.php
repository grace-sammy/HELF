<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/together.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/main.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/carousel.css">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <title>HELF :: 같이할건강</title>
  </head>
  <body>
    <div id="wrap">
      <div id="header">
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";
        define('SCALE', 10);

        //*****************************************************
        $sql=$result=$total_record=$total_page=$start=$area="";
        $row=$memo_content="";
        $total_record=0;
        //*****************************************************
        if (isset($_GET["mode"])&&$_GET["mode"]=="search") {
            //제목, 내용, 아이디
            $find = $_POST["find"];
            $search = $_POST["search"];
            $q_search = mysqli_real_escape_string($conn, $search);
            $sql="SELECT * from `together` where $find like '%$q_search%' AND b_code='같이할건강' order by num desc;";
        } else {
            $sql="SELECT * from `together` where b_code='같이할건강' order by group_num desc, ord asc;";
        }
        $result=mysqli_query($conn, $sql);

        if (isset($_GET["search_area"])) {
            switch ($_GET["search_area"]) {
            case '전국':
              break;
            case '서울':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='서울' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '부산':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='부산' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '대구':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='대구' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '인천':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='인천' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '광주':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='광주' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '대전':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='대전' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '울산':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='울산' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '강원':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='강원' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '경기':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='경기' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '경남':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='경남' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '경북':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='경북' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '전남':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='전남' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '전북':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='전북' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '제주':
              $sql="SELECT * from `together` where b_code='같이할건강' and area='제주' order by group_num desc, ord asc;";
              $result=mysqli_query($conn, $sql);
              break;
            case '충남':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='충남' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '충북':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='충북' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            case '세종':
                $sql="SELECT * from `together` where b_code='같이할건강' and area='세종' order by group_num desc, ord asc;";
                $result=mysqli_query($conn, $sql);
              break;
            default:
              echo "<script>alert('지역을 선택해주세요');history.go(-1);</script>";
              break;
          }
        }

          $total_record=mysqli_num_rows($result);
          $total_page=($total_record % SCALE == 0)?($total_record/SCALE):(ceil($total_record/SCALE));

          //페이지가 없으면 디폴트 페이지 1페이지
          if (empty($_GET['page'])) {
              $page=1;
          } else {
              $page=$_GET['page'];
          }
          $start=($page -1) * SCALE;
          $number = $total_record - $start;
         ?>

      </div><!--end of header  -->
      <div id="menu">
      </div><!--end of menu  -->
      <div id="content">
        <div id="col1">
         <div id="left_menu">
           <div id="sub_title"><span>&nbsp</span></div>
           <ul>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php">전국</a></li>
            <p>경기도</p>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=서울">서울</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=경기">경기</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=인천">인천</a></li>
            <p>충청도</p>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=충북">충북</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=충남">충남</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=세종">세종</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=대전">대전</a></li>
            <p>전라도</p>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=전북">전북</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=전남">전남</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=광주">광주</a></li>
            <p>경상도</p>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=경북">경북</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=경남">경남</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=부산">부산</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=울산">울산</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=대구">대구</a></li>
            <p>강원도</p>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=강원">강원</a></li>
            <p>기타</p>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php?search_area=제주">제주</a></li>
           </ul>
         </div>
       </div><!--end of col1  -->

       <div id="col2">
         <div id="title">
           <span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp같이할건강</span>
         </div>
         <form name="board_form" action="list.php?mode=search" method="post">
           <div id="list_search">
             <div id="list_search1">총 <?=$total_record?>개의 게시물이 있습니다.</div>
             <div id="list_search2"><span></span></div>
             <div id="list_search3">
               <select  name="find">
                 <option value="subject">제목</option>
                 <option value="content">내용</option>
                 <option value="id">아이디</option>
                 <option value="area">지역</option>
               </select>
             </div><!--end of list_search3  -->
             <div id="list_search4"><input type="text" name="search"></div>
             <div id="list_search5"><input type="image" src="../community/pic/search.png"></div>
           </div><!--end of list_search  -->
         </form>
         <div id="list_top_title">
           <ul>
             <li id="list_title1">번호</li>
             <li id="list_title2">제목</li>
             <li id="list_title3">글쓴이</li>
             <li id="list_title4">등록일</li>
             <li id="list_title5">조회</li>
             <li id="list_title6">지역</li>
           </ul>
         </div><!--end of list_top_title  -->

         <div id="list_content">
         <?php
          for ($i = $start; $i < $start+SCALE && $i<$total_record; $i++) {
              mysqli_data_seek($result, $i);
              $row=mysqli_fetch_array($result);
              $num=$row['num'];
              $id=$row['id'];
              $name=$row['name'];
              $hit=$row['hit'];
              $area=$row['area'];
              $date= substr($row['regist_day'], 0, 10);
              $subject=$row['subject'];
              $subject=str_replace("\n", "<br>", $subject);
              $subject=str_replace(" ", "&nbsp;", $subject);
              $file_name=$row['file_name'];
              $depth=(int)$row['depth'];//공간을 몆칸을 띄어야할지 결정하는 숫자임
              $space="";
              for ($j=0;$j<$depth;$j++) {
                  $space="&nbsp;&nbsp;".$space;
              } ?>

            <div id="list_item">
              <div id="list_item1"><?=$number?></div>
              <div id="list_item2">
                  <a href="./view.php?num=<?=$num?>&page=<?=$page?>&hit=<?=$hit+1?>"><?=$space.$subject?></a>
              <?php
                if (!($file_name === "")) {
                    echo('<img src="../community/pic/disk.png" alt="">');
                } else {
                    echo "";
                } ?>
              </div>
              <div id="list_item3"><?=$id?></div>
              <div id="list_item4"><?=$date?></div>
              <div id="list_item5"><?=$hit?></div>
              <div id="list_item6"><?=$area?></div>
            </div><!--end of list_item -->
            <div id="memo_content"><?=$memo_content?></div>
        <?php
            $number--;
          }//end of for
        ?>

        <div id="page_button">
          <div id="page_num">
            <?php
            if($page>1){
              $val=(int)$page-1;
              echo "<a href='./list.php?page=$val'>이전◀ </a>&nbsp;&nbsp;&nbsp;&nbsp";
            }?>
          <?php
            for ($i=1; $i <= $total_page ; $i++) {
                if ($page==$i) {
                    echo "<b>&nbsp;$i&nbsp;</b>";
                } else {
                    echo "<a href='./list.php?page=$i'>&nbsp;$i&nbsp;</a>";
                }
            }
          ?>
          <?php
          if($page>=1 && $total_page!=$page){
            $val=(int)$page+1;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='./list.php?page=$val'>▶ 다음</a>";
          }

           ?>
          <br><br><br><br><br><br><br>
        </div><!--end of page num -->
        <div id="button">
          <?php //세션아디가 있으면 글쓰기 버튼을 보여줌.
          if (!empty($_SESSION['user_id'])) { //login에서 저장한 세션값을 가져옴
            echo '<a href="write_edit_form.php"><button type="button" class="button_write">글쓰기</button></a>';
          }
          ?>
          <!-- <a href="write_edit_form.php"><button type="button">글쓰기 테스트</button></a> -->
          <a href="./list.php?page=<?=$page?>"><button type="button" class="button_category">목록</button></a>
        </div><!--end of button -->
      </div><!--end of page button -->
      </div><!--end of list content -->
      </div><!--end of col2  -->
      <aside>
          <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/aside.php";?>
      </aside>
      </div><!--end of content -->
      <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
      </footer>
    </div><!--end of wrap  -->
  </body>
</html>
