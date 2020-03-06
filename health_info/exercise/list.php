<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/health_info.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/main.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/carousel.css">
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <title>HELF :: 운동정보</title>
  </head>
  <body>
    <div id="wrap">
      <div id="header">
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";
        define('SCALE', 9);

        //*****************************************************
        $sql=$result=$total_record=$total_page=$start="";
        $row=$memo_content="";
        $total_record=0;
        //*****************************************************
        if (isset($_GET["mode"])&&$_GET["mode"]=="search") {
            //제목, 내용, 아이디
            $find = $_POST["find"];
            $search = $_POST["search"];
            $q_search = mysqli_real_escape_string($conn, $search);
            $sql="SELECT * from `health_info` where $find like '%$q_search%' AND b_code='운동' order by num desc;";
        } else {
            $sql="SELECT * from `health_info` where b_code='운동' order by num desc;";
        }
        $result=mysqli_query($conn, $sql);
        $total_record=mysqli_num_rows($result);
        $total_page=($total_record % SCALE == 0)?($total_record/SCALE):(ceil($total_record/SCALE));

        //2.페이지가 없으면 디폴트 페이지 1페이지
        if (empty($_GET['page'])) {
            $page=1;
        } else {
            $page=$_GET['page'];
        }
        $start=($page -1) * SCALE;
        $number = $total_record - $start;?>
      </div><!--end of header  -->
      <div id="content">
        <div id="col1">
         <div id="left_menu">
           <div id="sub_title"><span>&nbsp</span></div>
           <ul>
             <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/health_info/exercise/list.php">운동 정보</a></li>
             <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/health_info/recipe/list.php">요리 레시피</a></li>
           </ul>
         </div>
       </div><!--end of col1  -->

       <div id="col2">
         <div id="title">
           <span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp건강정보 > 운동(홈트레이닝)</span>
         </div>
         <form name="board_form" action="list.php?mode=search" method="post">
           <div id="list_search">
             <div id="list_search1">총 <?=$total_record?>개의 게시물이 있습니다.</div>
             <div id="list_search2"><span></span></div>
             <div id="list_search3">
               <select  name="find">
                 <option value="subject">제목</option>
                 <option value="content">내용</option>
               </select>
             </div><!--end of list_search3  -->
             <div id="list_search4"><input type="text" name="search"></div>
             <div id="list_search5"><input type="image" src="../pic/search.png"></div>
           </div><!--end of list_search  -->
         </form>
           <div class="list_content">
             <?php
             for ($i = $start; $i < $start+SCALE && $i<$total_record; $i++) {
                 mysqli_data_seek($result, $i);
                 $row = mysqli_fetch_array($result);
                 $num=$row['num'];
                 $id=$row['id'];
                 $name=$row['name'];
                 $hit=$row['hit'];
                 $date= substr($row['regist_day'], 0, 10);
                 $subject=$row['subject'];
                 $subject=str_replace("\n", "<br>", $subject);
                 $subject=str_replace(" ", "&nbsp;", $subject);
                 $file_name=$row['file_name'];
                 $file_copied=$row['file_copied'];
                 $file_type=$row['file_type'];
                 $file_type_tok=explode('/', $file_type);
                 $file_type=$file_type_tok[0];

                 if (!empty($file_copied)&&$file_type ==="image") {
                     //이미지 정보를 가져오기 위한 함수 width, height, type
                     $image_info=getimagesize("./data/".$file_copied);
                     $image_width=$image_info[0];
                     $image_height=$image_info[1];
                     $image_type=$image_info[2];
                     //사진 크기 조절
                     if (!($image_width===175) && !($image_height===130)) {
                         $image_width = 175;
                         $image_height = 120;
                     }
                 } else {
                     $image_width=0;
                     $image_height=0;
                     $image_type="";
                 } ?>

             <div id="list_item">
               <div id="list_item_container">
                 <div id="list_item3">
                    <?php
                    if (!($file_name === "")) {
                        $hit=$hit+1;
                        echo "<a href='./view.php?num=$num&page=$page&hit=$hit'><img src='./data/$file_copied' width='$image_width'></a><br>";
                    } else {
                        echo "사진이 존재하지 않습니다.";
                    } ?>
                  </div>
               </div>
               <div id="list_1542">
                 <!-- <div id="list_item1"><em>번호</em><span><?=$number?></span></div> -->
                 <div id="list_item5"><em>조회수</em><span><?=$hit?></span></div>
                 <div id="list_item4"><em>날짜</em><span><?=$date?></span></div>
                 <div id="list_item2"><img src="../pic/exercise_icon.png" alt=""><em><?=$subject?></em></div>
               </div>
             </div><!--end of list_item -->
         <?php
             $number--;
             }//end of for
         ?>
          <div id="page_button">
            <div id="page_num">
  <!-- /////////////////////////////////////////////////// -->
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
  <!-- /////////////////////////////////////////////// -->
            <br><br><br><br><br><br><br>
          </div><!--end of page num -->

          <div id="button">
            <?php //세션아디가 있으면 글쓰기 버튼을 보여줌.
            if (!empty($_SESSION['user_id'])) { //login에서 저장한 세션값을 가져옴
              if ($_SESSION["user_grade"]==="admin" || $_SESSION["user_grade"]==="master") {
                echo '<a href="write_edit_form.php"><button type="button" class="button_write">글쓰기</button></a>';
              }
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
