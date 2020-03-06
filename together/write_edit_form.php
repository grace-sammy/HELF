<?php
session_start();

include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";

$num=$id=$subject=$content=$day=$hit=$area="";
$mode="insert";
$checked="";

$id= $_SESSION['user_id'];

if (isset($_GET["mode"])&&$_GET["mode"]=="update"||(isset($_GET["mode"])&&$_GET["mode"]=="response")) {
    $mode=$_GET["mode"];
    $num = test_input($_GET["num"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    $sql="SELECT * from `together` where num ='$q_num';";
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
    $area=$row['area'];
    $file_name=$row['file_name'];
    $file_copied=$row['file_copied'];
    $day=$row['regist_day'];
    $hit=$row['hit'];
    $area=$row['area'];
    if($mode == "response"){
      $subject="[답변]".$subject;
      $content="[원본]".$content;
      $content=str_replace("<br>", "<br>▶",$content);
      $disabled="disabled";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/together.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/main.css">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/carousel.css">
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <title>HELF :: 같이할건강게시판</title>
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
         <div id="title">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp같이할건강</div>
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
                  활동 지역 <select name="area">
                  <option value="전국" <?php if($area === "전국") echo "selected";?>>전국</option>
                  <option value="서울" <?php if($area === "서울") echo "selected";?>>서울</option>
                  <option value="부산" <?php if($area === "부산") echo "selected";?>>부산</option>
                  <option value="대구" <?php if($area === "대구") echo "selected";?>>대구</option>
                  <option value="인천" <?php if($area === "인천") echo "selected";?>>인천</option>
                  <option value="광주" <?php if($area === "광주") echo "selected";?>>광주</option>
                  <option value="대전" <?php if($area === "대전") echo "selected";?>>대전</option>
                  <option value="울산" <?php if($area === "울산") echo "selected";?>>울산</option>
                  <option value="강원" <?php if($area === "강원") echo "selected";?>>강원</option>
                  <option value="경기" <?php if($area === "경기") echo "selected";?>>경기</option>
                  <option value="경남" <?php if($area === "경남") echo "selected";?>>경남</option>
                  <option value="경북" <?php if($area === "경북") echo "selected";?>>경북</option>
                  <option value="전남" <?php if($area === "전남") echo "selected";?>>전남</option>
                  <option value="전북" <?php if($area === "전북") echo "selected";?>>전북</option>
                  <option value="제주" <?php if($area === "제주") echo "selected";?>>제주</option>
                  <option value="충남" <?php if($area === "충남") echo "selected";?>>충남</option>
                  <option value="충북" <?php if($area === "충북") echo "selected";?>>충북</option>
                  <option value="세종" <?php if($area === "세종") echo "selected";?>>세종</option>
                </select>
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
