<?php
 include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

  if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
  } else {
    $user_id = "";
  }
  if(isset($_SESSION["user_name"])){
    $user_name = $_SESSION["user_name"];
  } else {
    $user_name = "";
  }
  if(isset($_SESSION["user_grade"])){
    $user_grade = $_SESSION["user_grade"];
  } else {
    $user_grade = "";
  }
?>
<script>
  function message_box() {
    window.open(
        "http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/message/message_box.php?mode=receive",
        "메시지함",
        "_blanck,resizable=no,menubar=no,status=no,toolbar=no,location=no,top=100px, le" +
                "ft=100px , width=820px, height=615px"
    );
    }
</script>
<div id="header_container">
<div id="top">
    <ul id="top_menu">
<?php
  if(!$user_id) {
?>
        <li>
            <a
                href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/member/member_form.php">회원가입</a>
        </li>
        <li>
            |
        </li>
        <li>
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/login/login_form.php">로그인</a>
        </li>
    <?php
  } else {
    $sql = "select * from message where rv_id='$user_id' and read_mark='n'";
    $result = mysqli_query($conn, $sql);
    $total_record = mysqli_num_rows($result);
    if($total_record > 0){
      $envelope = "/helf/common/img/new_message.png";
    } else {
      $envelope = "/helf/common/img/open_message.png";
    }

    $logged = $user_name."(".$user_id.") 님";
?>
      <li><a href="#"><img src="http://<?php echo $_SERVER['HTTP_HOST'].$envelope;?>" alt="쪽지함" onclick="message_box()"></a></li>
      <li id="mypage_li">
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/mypage/mypage_board.php">
          <b><?=$logged?></b>
        </a>
          <ol id="mypage_slide">
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf//mypage/mypage_board.php">내가 쓴 글</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/mypage/mypage_comment.php">내가 쓴 댓글</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/mypage/mypage_review.php">내가 쓴 상품평</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/mypage/mypage_question.php">내가 쓴 상품 문의</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/mypage/mypage_pick.php">찜 내역</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/mypage/mypage_buy.php">구매 내역</a></li>
          </ol>
      </li>
      <li> | </li>
      <li>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/member/member_form.php?modify=modify">
          <span>내 정보 수정</span>
          </a>

      </li>
      <li> | </li>
      <li>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/mypage/cart_list.php">장바구니</a>
      </li>
      <li> | </li>
      <li>
        <a
            href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/login/logout.php">로그아웃</a>
      </li>
<?php
  }
?>
<?php
    if($user_grade =='admin') {
?>
                <li> | </li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/admin/admin_program_payment.php">관리자페이지</a></li>
<?php
    }
?>
    </ul>
</div>
<nav id="menu_bar" class="no-autoinit">
    <ul class="tabs no-autoinit">
        <li class="tab no-autoinit" id="li_img">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/index.php">
                <img
                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/helf_logo.png"
                    alt="헬프 로고">
            </a>
        </li>
        <li class="tab down_menu">
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/HELF/introduction/introduction.php"><span>&nbsp;&nbsp;&nbsp;소개</span></a>
        <ol class="menu_slide" id="about_slide">
                  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/HELF/introduction/introduction.php">HELF</a></li>
                  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/HELF/notice/notice.php">공지사항</a></li>
                  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/HELF/FAQ/list.php">FAQ</a></li>
                </ol>
              </li>
        <li class="tab">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/HELF/program/program.php">
                <span>프로그램</span></a>
        </li>
        <li class="tab down_menu">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/community/free/list.php">
                <span>커뮤니티</span></a>
                <ol class="menu_slide" id="community_slide">
                  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/community/free/list.php">자유게시판</a></li>
                  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/community/review/list.php">후기게시판</a></li>
                </ol>
              </li>

        <li class="tab down_menu">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/health_info/exercise/list.php">
                <span>건강정보</span></a>
                <ol class="menu_slide" id="info_slide">
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/health_info/exercise/list.php">운동 정보</a></li>
                  <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/health_info/recipe/list.php">레시피</a></li>
                </ol>
        </li>
        <li class="tab">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/list.php">
                <span>같이할건강</span></a>
        </li>
    </ul>
</nav>
</div>
