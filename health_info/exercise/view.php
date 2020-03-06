<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";
include('server.php');

$num=$id=$subject=$content=$day=$hit=$image_width=$q_num=$video_name="";

if (empty($_GET['page'])) {
    $page=1;
} else {
    $page=$_GET['page'];
}

if (isset($_GET["num"])&&!empty($_GET["num"])) {
    $num = test_input($_GET["num"]);
    $hit = test_input($_GET["hit"]);
    $q_num = mysqli_real_escape_string($conn, $num);
    // echo "<script>alert('게시판 번호 : {$num}');</script>";
    $sql="UPDATE `health_info` SET `hit`=$hit WHERE b_code='운동' and `num`=$q_num;";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    $sql="SELECT * from `health_info` where b_code='운동' and num ='$q_num';";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $id=$row['id'];
    $name=$row['name'];
    $hit=$row['hit'];
    $subject= $row['subject'];
    $content= $row['content'];
    $subject=str_replace("\n", "<br>", $subject);
    $subject=str_replace(" ", "&nbsp;", $subject);
    $content=str_replace("\n", "<br>", $content);
    $content=str_replace(" ", "&nbsp;", $content);
    $b_code=$row['b_code'];
    $video_name= htmlspecialchars($row['video_name']);
    $video_name=str_replace("\n", "<br>", $video_name);
    $video_name=str_replace(" ", "&nbsp;", $video_name);
    $video_name=substr($video_name, -11);

    $file_name=$row['file_name'];
    $file_copied=$row['file_copied'];
    $file_type=$row['file_type'];
    $day=$row['regist_day'];

    $file_type_tok=explode('/', $file_type);
    $file_type=$file_type_tok[0];

    if (!empty($file_copied)&&$file_type =="image") {
        //이미지 정보를 가져오기 위한 함수 width, height, type
        $image_info=getimagesize("./data/".$file_copied);
        $image_width=$image_info[0];
        $image_height=$image_info[1];
        $image_type=$image_info[2];
        if ($image_width>400) {
            $image_width = 400;
        }
    } else {
        $image_width=0;
        $image_height=0;
        $image_type="";
    }
}
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">

<?php
function free_ripple_delete($id1, $num1, $page1, $page, $hit, $parent)
{
    if (isset($_SESSION['user_id'])) {
        $message="";
        if ($_SESSION['user_grade']=="admin"||$_SESSION['user_grade']=="master"||$_SESSION['user_id']==$id1) {
            $message=
            '<form style="display:inline;" action="'.$page1.'?mode=delete_ripple&page='.$page.'&hit='.$hit.'" method="post">
              <input type="hidden" name="num" value="'.$num1.'">
              <input type="hidden" name="parent" value="'.$parent.'">
              <input type="submit" style="border:1px solid #F23005; color:#F23005; background-color:white;" value="&nbsp&nbsp삭제&nbsp&nbsp">
            </form>';
        }
        return $message;
    }
}

 ?>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/health_info.css">
    <link rel="stylesheet" href="../css/memo.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/main.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/carousel.css">
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <title>HELF :: 건강정보게시판</title>
    <script type="text/javascript">
    function check_delete(num) {
      var result=confirm("삭제하시겠습니까?");
      if(result){
            window.location.href='./dml_board.php?mode=delete&num='+num;
            window.history.go(-1);
      }
    }
    </script>
  </head>
  <body>
    <div id="wrap">
      <div id="header">
          <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
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
         <div id="title"><span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp운동정보</span></div>
         <div class="clear"></div>
         <div id="write_form_title"><?=$subject?></div>
         <div class="clear"></div>
            <div id="write_form">
              <div class="write_line"></div>
              <div id="write_row1">
                <div class="col1">아이디</div>
                <div class="col2"><?=$id?>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  조회 : <?=$hit?> &nbsp;&nbsp;&nbsp; 입력날짜: <?=$day?>
                </div>

              </div><!--end of write_row1  -->
              <div class="write_line"></div>
              <div id="write_row2">
                <div class="col1">제&nbsp;&nbsp;목</div>
                <div class="col2"> <input type="text" name="subject" value="<?=$subject?>" readonly></div>
              </div><!--end of write_row2  -->
              <div class="write_line"></div>
              <div id="view_content">
                <div class="col2">
                  <!-- 첨부한 동영상 보기 -->
                    <p align="middle">
                    <iframe width="740" height="432" src="https://www.youtube.com/embed/<?=$video_name?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </p>
                  <br>
                  <strong>프로그램 소개</strong><br><br>
                  <div class="write_line"></div>
                  <br>
                    <?=$content?>
                </div><!--end of col2  -->
              </div><!--end of view_content  -->
            </div><!--end of write_form  -->

        <div class="posts-wrapper">
           <?php foreach ($communities as $post): ?>
             <!-- foreach($array as $value)  value 값만 가져오기-->
              <div class="post">
              <div class="post-info">
               <!-- if user likes post, style button differently -->
                 <i <?php if (userLiked($post['num'])): ?>
                      class="fa fa-thumbs-up like-btn"
                   <?php else: ?>
                      class="fa fa-thumbs-o-up like-btn"
                   <?php endif ?>
                   data-id="<?php echo $post['num'] ?>">
                 </i>
                 <span class="likes"><?php echo getLikes($post['num'], $q_num); ?></span>

                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;

               <!-- if user dislikes post, style button differently -->
                 <i
                   <?php if (userDisliked($post['num'])): ?>
                      class="fa fa-thumbs-down dislike-btn"
                   <?php else: ?>
                      class="fa fa-thumbs-o-down dislike-btn"
                   <?php endif ?>
                   data-id="<?php echo $post['num'] ?>"></i>
                 <span class="dislikes"><?php echo getDislikes($post['num']); ?></span>
              </div>
              </div>
           <?php endforeach ?>
         </div><!--end of posts-wrapper --!>
          <script src="scripts.js"></script>

<!--덧글내용시작  -->
<div id="ripple">
  <div id="ripple2">
    <?php
      $sql="select * from `comment` where b_code='운동' and parent='$q_num' ";
      $ripple_result= mysqli_query($conn, $sql);
      while ($ripple_row=mysqli_fetch_array($ripple_result)) {
          $ripple_num=$ripple_row['num'];
          $ripple_id=$ripple_row['id'];
          $ripple_name =$ripple_row['name'];
          $ripple_date=$ripple_row['regist_day'];
          $ripple_b_code=$ripple_row['b_code'];
          $ripple_content=$ripple_row['content'];
          $ripple_content=str_replace("\n", "<br>", $ripple_content);
          $ripple_content=str_replace(" ", "&nbsp;", $ripple_content); ?>
        <div id="ripple_title">
          <ul>
            <li><?=$ripple_id."&nbsp;&nbsp;".$ripple_date?></li>
            <li id="mdi_del">
            <?php
            $message =free_ripple_delete($ripple_id, $ripple_num, 'dml_board.php', $page, $hit, $q_num);
          echo $message; ?>
            </li>
          </ul>
        </div>
        <div id="ripple_content">
          <?=$ripple_content?>
        </div>
    <?php
      }//end of while
      //mysqli_close($conn);
    ?>
    <form name="ripple_form" action="dml_board.php?mode=insert_ripple" method="post">
      <input type="hidden" name="parent" value="<?=$q_num?>">
      <input type="hidden" name="hit" value="<?=$hit?>">
      <input type="hidden" name="page" value="<?=$page?>">
      <input type="hidden" name="user_id" value="<?=$user_id?>">
      <input type="hidden" name="b_code" value="운동">
      <div id="ripple_insert">
        <div id="ripple_textarea"><img src="../pic/ripple.png" alt=""><textarea name="ripple_content" rows="3" cols="86"></textarea><input type="submit" value="&nbsp&nbsp입력&nbsp&nbsp"></div>
      </div><!--end of ripple_insert -->
    </form>
  </div><!--end of ripple2  -->
</div><!--end of ripple  -->

<div id="write_button">
    <a href="./list.php?page=<?=$page?>">목록</a>
  <?php
    //master or admin이거나 해당된 작성자일경우 수정, 삭제가 가능하도록 설정
    // echo "<script>alert('{$_SESSION['user_id']}');</script>";
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION["user_grade"]=="admin" ||$_SESSION['user_grade']=="master") {
            echo('<a href="./write_edit_form.php?mode=update&num='.$num.'">수정</a>&nbsp;');
            echo('<button type="button" id="write_button_delete" onclick="check_delete('.$num.')">삭제</button>&nbsp;');
        }
    }
    //로그인하는 유저에게 글쓰기 기능을 부여함.
    if ($_SESSION['user_grade']=="admin"||$_SESSION['user_grade']=="master") {
        echo '<a href="write_edit_form.php">글쓰기</a>';
    }
  ?>
</div><!--end of write_button-->
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
