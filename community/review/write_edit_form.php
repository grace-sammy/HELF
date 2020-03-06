<?php
session_start();

include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";
$num=$id=$subject=$content=$day=$hit="";
$mode="insert";
$checked="";

$id= $_SESSION['user_id'];


if (isset($_GET["mode"])&&$_GET["mode"]=="update") {
    $mode="update";
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    $sql="SELECT * from `community` where num ='$q_num';";
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
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="../css/community.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/main.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/carousel.css">
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <title>HELF :: 커뮤니티게시판</title>
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
             <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/community/free/list.php">자유게시판</a></li>
             <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/community/review/list.php">다이어트후기</a></li>
           </ul>
         </div>
       </div><!--end of col1  -->

       <div id="col2">
         <div id="title"><span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp다이어트후기</span></div>
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
              </div><!--end of write_row2  -->
              <div class="write_line"></div>

              <div id="write_row3">
                <div class="col1">내&nbsp;&nbsp;용</div>
                <div class="col2"><textarea name="content" rows="15" cols="79"><?=$content?></textarea></div>
              </div><!--end of write_row3  -->
              <div class="write_line"></div>
              <div id="write_row4">
                <div class="col1">파일업로드</div>
                <div class="col2">
                  <?php
                    if ($mode=="insert") {
                        echo '<input type="file" name="upfile[]" multiple="multiple" >';
                    } else {
                        ?>
                    <input type="file" name="upfile[]" multiple="multiple" onclick='document.getElementById("del_file").checked=true; document.getElementById("del_file").disabled=true'>
                 <?php
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
