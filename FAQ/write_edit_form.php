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
    <title>HELF :: FAQ</title>
  </head>
  <body>
    <div id="wrap">
    <div id="header">
          <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
</div>
      <?php
      include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";
      $num=$id=$subject=$content=$day=$hit="";
      $mode="insert";
      $checked="";
      $disabled="";

      if(!(isset($_SESSION['user_grade']))||!($_SESSION['user_grade']==="admin")){
        echo "alert('관리자 접근이 아닙니다.')";
        exit;
      }

      // 수정 추가 삭제 기능만 넣기
      if(isset($_GET["mode"])&&$_GET["mode"]=="update"){
          $mode=$_GET["mode"]; //$mode="update"or"response"
          $num = test_input($_GET["num"]);
          $q_num = mysqli_real_escape_string($conn, $num);

          //update 이면 해당된글, response이면 부모의 해당된글을 가져옴.
          $sql="SELECT * from `faq` where num ='$q_num';";
          $result = mysqli_query($conn,$sql);
          if (!$result) {
            die('Error: ' . mysqli_error($conn));
          }
          $row=mysqli_fetch_array($result);
          $subject= htmlspecialchars($row['subject']);
          $content= htmlspecialchars($row['content']);
          $subject=str_replace("\n", "<br/>",$subject);
          $subject=str_replace(" ", "&nbsp;",$subject);
          $content=str_replace("\n", "<br/>",$content);
          $content=str_replace(" ", "&nbsp;",$content);
          mysqli_close($conn);
      }
       ?>
      <div id="content">
       <div id="col2">
         <div id="title"><span>FAQ</span></div>
         <div class="clear"></div>
         <form name="board_form" action="dml_board.php?mode=<?=$mode?>" method="post">
          <input type="hidden" name="num" value="<?=$num?>">
          <input type="hidden" name="hit" value="<?=$hit?>">
          <div id="write_form">
              <div class="write_line"></div>
              <div class="write_line"></div>
              <div id="write_row2">
                <div class="col1">제&nbsp;&nbsp;목</div>
                <div class="col2"><input type="text" name="subject" value=<?=$subject?>></div>
              </div><!--end of write_row2  -->
              <div class="write_line"></div>

              <div id="write_row3">
                <div class="col1">내&nbsp;&nbsp;용</div>
                <div class="col2"><textarea style="resize: none;" name="content" rows="15" cols="79"><?=$content?></textarea>  </div>
              </div><!--end of write_row3  -->
              <div class="write_line"></div>
            </div><!--end of write_form  -->

            <div id="write_button">
              <!-- 완료버튼 및 목록버튼 -->
              <input type="submit" value="완료"></input>
              <a href="./list.php">목록</a>
            </div><!--end of write_button-->
         </form>
      </div><!--end of col2  -->
      <aside id="aside">
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/aside.php";?>
      </aside>
      </div><!--end of content -->
    </div><!--end of wrap  -->
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>
  </body>
</html>
