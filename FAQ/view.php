<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/greet.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/carousel.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <script src="http://code.jquery.com/jquery-1.12.4.min.js" charset="utf-8"></script>
    <script type="text/javascript">
    function check_delete(num) {
      var result=confirm("삭제하시겠습니까?\n Either OK or Cancel.");
      if(result){
            window.location.href='./dml_board.php?mode=delete&num='+num;
      }
    }
    </script>
  <title>HELF :: FAQ</title>
  </head>
  <body>
    <div id="wrap">
    <div id="header">
          <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
      </div><!--end of header  -->
      <?php
      include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";
      $num=$id=$subject=$content=$day=$hit="";

      if(empty($_GET['page'])){
        $page=1;
      }else{
        $page=$_GET['page'];
      }

      if(isset($_GET["num"])&&!empty($_GET["num"])){
          $num = test_input($_GET["num"]);
          $q_num = mysqli_real_escape_string($conn, $num);
          $sql="SELECT * from `faq` where num ='$q_num';";
          $result = mysqli_query($conn,$sql);
          if (!$result) {
            die('Error: ' . mysqli_error($conn));
          }
          $row=mysqli_fetch_array($result);
          $subject= htmlspecialchars($row['subject']);
          $content= htmlspecialchars($row['content']);
          $subject=str_replace("\n", "<br>",$subject);
          $subject=str_replace(" ", "&nbsp;",$subject);
          $content=str_replace("\n", "<br>",$content);
          $content=str_replace(" ", "&nbsp;",$content);
      }?>
      <div id="content">
       <div id="col1">
       </div><!--end of col1  -->
       <div id="col2">
         <div id="title"><span>FAQ</span></div>
         <div class="clear"></div>
            <div id="write_form">
              <div class="write_line"></div>
              <div id="write_row2">
                <div class="col1">제&nbsp;&nbsp;목</div>
                <div class="col2"> <p><?=$subject?></p></div>
              </div><!--end of write_row2  -->
              <div class="write_line"></div>
              <div id="write_row3">
                <div class="col2"><p><?=$content?></p></div>
              </div><!--end of write_row3  -->
              <div class="write_line"></div>
            </div><!--end of write_form  -->

            <div id="write_button">
              <!--목록보기 -->
              <button type="button"><a href="./list.php?page=<?=$page?>">목록</a></button>&nbsp;
            <?php
              //세션값이 존재하면 수정기능과 삭제기능부여하기
              if(isset($_SESSION['user_id'])){
                if($_SESSION['user_grade']=="admin"){
                  echo('<button type="button"><a href="./write_edit_form.php?mode=update&num='.$num.'">수정</a></button>&nbsp;&nbsp;');
                  echo('<button type="button" id="write_button_delete" onclick="check_delete('.$num.')"><a>삭제</a></button>&nbsp');
                }
              }
              // 세션값이 존재하면 글쓰기 기능부여하기\
              if(isset($_SESSION['user_grade'])){
              if($_SESSION['user_grade']=="admin"){
                echo ' <button type="button"><a href="write_edit_form.php">글쓰기</a></button>';
              }
            }
            ?>
            </div><!--end of write_button-->
      </div><!--end of col2  -->
      <aside>
    <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/aside.php";?>
</aside>
      </div><!--end of content -->
    </div><!--end of wrap  -->
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>
  </body>
</html>
