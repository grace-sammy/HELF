<?php
session_start();

include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";

$num=$id=$subject=$content=$day=$hit=$video_name="";
$mode="insert";
$checked="";

$id= $_SESSION['user_id'];

if (isset($_GET["mode"])&&$_GET["mode"]=="update") {
    $mode="update";
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    $sql="SELECT * from `health_info` where num ='$q_num';";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        alert_back("Error: " . mysqli_error($conn));
    }

    $row=mysqli_fetch_array($result);
    $id=$row['id'];
    $subject= htmlspecialchars($row['subject']);
    $content= htmlspecialchars($row['content']);
    $subject=str_replace("\n", "<br>", $subject);
    $subject=str_replace(" ", "&nbsp;", $subject);
    $content=str_replace("\n", "<br>", $content);
    $content=str_replace(" ", "&nbsp;", $content);
    $file_name=$row['file_name'];
    $file_copied=$row['file_copied'];
    $day=$row['regist_day'];
    $hit=$row['hit'];
    $video_name= htmlspecialchars($row['video_name']);
    $video_name=str_replace("\n", "<br>", $video_name);
    $video_name=str_replace(" ", "&nbsp;", $video_name);

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/health_info.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/main.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/carousel.css">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <title>HELF :: 건강정보게시판</title>
  </head>
  <body>
    <div id="wrap">
      <div id="header">
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
      </div><!--end of header  -->
      <div id="content">
        <div id="col1">
         <div id="left_menu">
           <div id="sub_title"><span></span></div>
           <ul>
             <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/health_info/exercise/list.php">운동 정보</a></li>
             <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/health_info/recipe/list.php">요리 레시피</a></li>
           </ul>
         </div>
       </div><!--end of col1  -->

       <div id="col2">
         <div id="title">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp요리 레시피</div>
         <div class="clear"></div>
         <div id="write_form_title">글쓰기</div>
         <div class="clear"></div>
         <form name="board_form" action="dml_board.php?mode=<?=$mode?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="num" value="<?=$num?>">
          <input type="hidden" name="hit" value="<?=$hit?>">
          <div id="write_form">
              <div class="write_line"></div>
              <div id="write_row1">
                <div class="col1">아이디</div>
                <div class="col2"><?=$id?></div>
                <div class="col3">
                </div>
              </div><!--end of write_row1  -->

              <div class="write_line"></div>

              <div id="write_row2">
                <div class="col1">제&nbsp;&nbsp;목</div>
                <div class="col2"><input type="text" name="subject" value=<?=$subject?>></div>
              </div><!--end of write_row2 -->
              <div class="write_line"></div>

              <div id="write_row3">
                <div class="col1">내&nbsp;&nbsp;용</div>
                <div class="col2"><textarea name="content" rows="17" cols="80"><?=$content?></textarea></div>
              </div><!--end of write_row3  -->
            <div class="write_line"></div>
              <!-- <div class="write_line"></div> -->

              <div id="write_row3_video">
                <div class="col1">첨부 동영상 URL</div>
                <div class="col2"><input type="text" name="video_name" value=<?=$video_name?>></div>
              </div><!--end of write_row3_video  -->
              <div class="write_line"></div>

              <div id="write_row4">
                <div class="col1">메인사진</div>
                <div class="col2">
                  <?php
                    if ($mode=="insert") {
                        echo '<input type="file" name="upfile" >';
                    } else {
                        ?>
                    <input type="file" name="upfile" onclick='document.getElementById("del_file").checked=true; document.getElementById("del_file").disabled=true'>
                 <?php
                    }
                  ?>
                  <?php
                    if ($mode=="update" && !empty($file_name)) {
                        echo "$file_name 파일등록";
                        echo '<input type="checkbox" id="del_file" name="del_file" value="1">삭제';
                        echo '<div class="clear"></div>';
                    }
                  ?>
                </div><!--end of col2  -->
              </div><!--end of write_row4  -->

              <div class="clear"></div>
              <div class="write_line"></div>
              <div class="clear"></div>
            </div><!--end of write_form  -->
            <div id="write_button">
              <input type="submit" onclick='document.getElementById("del_file").disabled=false' value="완료">
              <a href="./list.php">목록</a>
            </div><!--end of write_button-->
         </form>
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
