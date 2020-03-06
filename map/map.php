<?php
//도시 = 서울,경기등등 city
//지역 = 구 용산구,성동구 area
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>HELF :: 인바디 보건소 찾기</title>
    <link
        rel="stylesheet"
        type="text/css"
        href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link
        rel="stylesheet"
        type="text/css"
        href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/main.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
        <script src="http://code.jquery.com/jquery-1.12.4.min.js" charset="utf-8"></script>
        <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
        <link rel="stylesheet" href="./css/greet.css">
        <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
</head>
<body>
  <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
      <?php
      define('SCALE', 10);
      define('BLOCK', 10); // 한번에 보여질 페이지 수
      //*****************************************************
      $sql=$result=$total_record=$total_page=$start="";
      $row="";
      $memo_id=$memo_num=$memo_date=$memo_nick=$memo_content="";
      $total_record=0;
      if (isset($_GET["mode"])&&$_GET["mode"]=="search") {
          $find = $_POST["find"];
          $search = $_POST["search"];
          if(isset($_GET["find"])&&isset($_GET["search"])){
            $find = $_GET["find"];
            $search = $_GET["search"];
          }
          $q_search = mysqli_real_escape_string($conn, $search);
          $sql="SELECT * from `carecenter` where $find like '%$q_search%'";
      } else {
          $sql="SELECT * from carecenter";
      }
      $result=mysqli_query($conn, $sql);
      $total_record=mysqli_num_rows($result);
      $total_page=($total_record % SCALE == 0)?($total_record/SCALE):(ceil($total_record/SCALE));

      //2.페이지가 없으면 디폴트 페이지 1페이지
       if (empty($_GET['page'])) {
          $page=1;
      }else {
        $page=$_GET['page'];
      }

      $start=($page -1) * SCALE;
      $number = $total_record - $start;
      $block_num = ceil($total_page/BLOCK);
      $now_block = ceil($page/BLOCK);
      $start_page = ($now_block * BLOCK) - (BLOCK - 1);

if ($start_page <= 1) {
    $start_page = 1;
}
$end_page = $now_block*BLOCK;
if ($total_page <= $end_page) {
    $end_page = $total_page;
}

       ?>
  </header>

  <div id="wrap">
    <div id="content">
     <div id="col2">
       <div id="title">
         <span>인바디 측정 가능 보건소 위치</span>
       </div>
       <form name="board_form" action="map.php?mode=search" method="post">
         <input type="hidden" id="page" name="page">
         <div id="list_search">
           <div id="list_search1">총 <?=$total_record?>개의 게시물이 있습니다.</div>
           <div id="list_search_right">
           <div id="list_search3">
             <select id="find" name="find">
               <option value="city">지역</option>
               <option value="area">구</option>
               <option value="name">이름</option>
               <option value="address">주소</option>
             </select>
           </div><!--end of list_search3  -->
           <div id="list_search4"><input type="text" id="search" name="search"></div>
            <div id="list_search5"><input type="image" src="./img/search.png"></div>
           </div>
         </div><!--end of list_search  -->
       </form>
       <div id="clear"></div>
       <div id="list_top_title">
         <ul>
           <li id="list_title1">지역</li>
           <li id="list_title2">시,군,구</li>
           <li id="list_title3">측정장소</li>
           <li id="list_title4">주소</li>
           <li id="list_title5">연락처</li>
           <li id="list_title6">링크</li>
         </ul>
       </div><!--end of list_top_title  -->

       <div id="list_content">
       <?php
        for ($i = $start; $i < $start+SCALE && $i<$total_record; $i++) {
            mysqli_data_seek($result, $i);
            $row=mysqli_fetch_array($result);
            $city=$row['city'];
            $area=$row['area'];
            $areahealth=$row['area_health'];
            $adderrs=$row['address'];
            $tel=$row['tel'];?>
          <div id="list_item">
            <!-- 지역 구 OOO보건소 (진료소,보건소) 이름 주소 번호 지도(링크)-->
            <div id="list_item1"><?=$city?></div>
            <div id="list_item2"><?=$area?></div>
            <div id="list_item3"><?=$areahealth?></div>
            <div id="list_item4"><?=$adderrs?></div>
            <div id="list_item5"><?=$tel?></div>
            <div id="list_item6">
              <!-- 구글맵 -->
              <!-- <a href="https://www.google.com/maps/search/?api=1&query=php변수명($name) "> -->
                <!--네이버 https://map.naver.com/v5/search/php변수명($name) -->

                <a href="https://map.kakao.com/?q=<?=$city.$areahealth?>">
                <!--카카오맵 https://map.kakao.com/link/search/php변수명($name)  -->
                <img src="./img/btn_spot.gif" width="18" height="24" alt="">
              </a>
            </div>
          </div><!--end of list_item -->
      <?php
          $number--;
        }//end of for
      ?>
      <div id="page_button">
        <div id="page_num">
          <?php
          if($page>1){
            $val=(int)$page-1;
            if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
              ?>
              <a href="./map.php?mode=search&page=<?=$val?>&find=<?=$find?>&search=<?=$q_search?>">이전◀ </a>&nbsp;&nbsp;&nbsp;&nbsp;
              <?php
            }else{
              echo "<a href='./map.php?page=$val'>이전◀ </a>&nbsp;&nbsp;&nbsp;&nbsp";
            }
          }?>
        <?php
          for ($i=$start_page; $i <= $end_page ; $i++) {
              if ($page==$i) {
                  echo "<b>&nbsp;$i&nbsp;</b>";
              } else {
                if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
                  ?>
                  <a href="./map.php?mode=search&page=<?=$i?>&find=<?=$find?>&search=<?=$q_search?>">&nbsp;<?=$i?>&nbsp;</a>
                  <?php
                }else{
                  echo "<a href='./map.php?page=$i'>&nbsp;$i&nbsp;</a>";
                }
              }
          }
        ?>
        <?php
        if($page>=1 && $total_page!=$page){
          $val=(int)$page+1;
          if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
            ?>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="./map.php?mode=search&page=<?=$val?>&find=<?=$find?>&search=<?=$q_search?>">▶ 다음</a>
              <?php
          }else{
            echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='./map.php?page=$val'>▶ 다음</a>";
          }
        }
         ?>
           <a id="btn_a" href="./map.php"><button type="button" id="btn">목록</button></a>
        <br><br><br><br><br><br><br>
      </div><!--end of page num -->
    </div><!--end of page button -->
    </div><!--end of list content -->
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
