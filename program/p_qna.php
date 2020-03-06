<?php
session_start();
if(empty($_SESSION['user_id'])||$_SESSION['user_id']===""){
  echo "<script>alert('로그인후 이용해주세요');</script>";
  echo "<script>opener.parent.location.reload();self.close();</script>";
}
include $_SERVER['DOCUMENT_ROOT']."/HELF/common/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";

$qna_subject=$qna_content=$shop=$type="";
if(isset($_GET['mode'])){
  $mode=$_GET['mode'];
}
if(isset($_GET['o_key'])){
  $o_key=(int)$_GET['o_key'];
  $sql="select * from `program` where o_key=$o_key;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $shop=$row['shop'];
  $type=$row['type'];
}
if(isset($_GET['num'])){
  $num=$_GET['num'];
}
if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}
if($mode==="update"){
  $sql="select * from `p_qna` where num='$num';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  $shop=$row['shop'];
  $type=$row['type'];
  $qna_group_num=$row['group_num'];
  $qna_subject=$row['subject'];
  $qna_content=$row['content'];
}
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: QnA</title>
    <link rel="stylesheet" href="./css/p_qna.css">
  </head>
  <body>
    <form class="" action="./p_qna_db.php?mode=<?=$mode?>" method="post">
      <input type="hidden" name="num" value="<?=$num?>">
      <input type="hidden" name="o_key" value="<?=$o_key?>">
      <input type="hidden" name="group_num" value="<?=$qna_group_num?>">
      <input type="hidden" name="type" value="<?=$type?>">
      <input type="hidden" name="shop" value="<?=$shop?>">
      <div id="qna_content">
        <h1>프로그램 문의</h1>
        <div id="write_row1">
          <div id="qna_id1">아이디 : </div>
          <div id="qna_id2"><?=$user_id?></div>
        </div><!--end of write_row1  -->
        <div class="write_line"></div>
        <div id="write_row2">
          <div>제&nbsp;&nbsp;목</div>
          <div><input type="text" id="qna_subject" name="subject" value=<?=$qna_subject?>></div>
          <br>
        </div><!--end of write_row2  -->
        <div class="write_line"></div>

        <div id="write_row3">
          <div class="col1">내&nbsp;&nbsp;용</div>
          <div class="col2"><textarea style="resize: none;" name="content" rows="1" cols="1"><?=$qna_content?></textarea></div>
        </div><!--end of write_row3  -->
        <input type="submit" name="" value="등록">
        <input type="button" name="" value="취소">
      </div>
      </div>
    </form>
  </body>
</html>
