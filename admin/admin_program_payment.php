<?php
  session_start();
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>HELF :: 관리자페이지</title>
        <link rel="stylesheet" type="text/css" href="./css/admin.css">
        <link rel="stylesheet" href="./css/program_manager.css">
        <script src="http://code.jquery.com/jquery-1.12.4.min.js" charset="utf-8"></script>
        <script src="./js/register.js"></script>
        <link
            rel="shortcut icon"
            href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
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

        <link
            href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean"
            rel="stylesheet">
        <script
            type="text/javascript"
            src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/js/main.js"></script>
    </head>
    <body>
        <header>
            <?php include "../common/lib/header.php";?>
        </header>
        <section>
            <div id="admin_border">
                <div id="snb">
                    <div id="snb_title">
                        <h1>관리자 페이지</h1>
                    </div>
                    <div id="admin_menu_bar">
                        <h2>회원관리</h2>
                        <!-- /.menu-title -->
                        <ul>
                            <li>
                                <a href="admin_user.php">회원관리</a>
                            </li>
                        </ul>

                        <h2>게시글 관리</h2>
                        <ul>
                            <li>
                                <a href="admin_board_free.php">자유게시판</a>
                            </li>
                            <li>
                                <a href="admin_board_review.php">후기게시판</a>
                            </li>
                            <li>
                                <a href="admin_board_together.php">같이할건강</a>
                            </li>
                        </ul>

                        <h2>프로그램 관리</h2>
                        <ul>
                            <li>
                                <a href="admin_program_regist.php">프로그램 등록</a>
                            </li>
                            <li>
                                <a href="admin_program_manage.php">프로그램 관리</a>
                            </li>
                            <li>
                                <a href="admin_program_payment.php">결제 관리</a>
                            </li>
                        </ul>

                        <h2>통계</h2>
                        <ul id="sta_ul">
                            <li>
                                <a href="admin_statistics1.php">매출 분석</a>
                            </li>
                            <li>
                                <a href="admin_statistics2.php">인기 프로그램</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- end of sub -->
                <div id="content">
                <h1 id="content_title">프로그램 관리 > 결제 관리</h1><br>
                <div id="admin_box">
          <form name="board_form" action="./admin_program_payment.php?mode=search" method="post">
               <div id="list_search">
                 <select  name="find">
                   <option value="ord_num">주문번호</option>
                   <option value="id">아이디</option>
                   <option value="complete">결제상태</option>
                 </select>
                 <div id="list_search4"><input type="text" name="search"></div>
                 <div id="list_search5"><input type="submit" value="검색"></div>
                 <div id="list_search6"><input type="button" value="목록" onclick="location.href='./admin_program_payment.php'"></div>
             </div><!--end of list_search  -->
           </form>
              <ul id="pay_ul">
                  <li id="pay_first_li">
                      <span class="col1">주문번호</span>
                      <span class="col2">주문자</span>
                      <span class="col3">주문개수</span>
                      <span class="col4">가격</span>
                      <span class="col5">주문일</span>
                      <span class="col6">결제상태</span>
                      <span class="col7">결제방법</span>
                      <span class="col8"> </span>
                  </li>

    <?php
      define('SCALE', 10);
      define('BLOCK', 10);
      $total_record=0;
    if (isset($_GET["mode"])&&$_GET["mode"]=="search") {
          //제목, 내용, 아이디
          if(isset($_GET["find"])&&isset($_GET["search"])){
            $find = $_GET["find"];
            $search = $_GET["search"];
          }else{
            $find = $_POST["find"];
            $search = $_POST["search"];
          }
          $q_search = mysqli_real_escape_string($conn, $search);
          $sql="SELECT * from `sales` where $find like '%$q_search%' group by ord_num order by num desc";
    } else {
          $sql = "SELECT * from sales group by ord_num order by complete asc";
    }
    $result = mysqli_query($conn, $sql);
    $total_record=mysqli_num_rows($result);
    $total_page=($total_record % SCALE == 0)?($total_record/SCALE):(ceil($total_record/SCALE));

      //2.페이지가 없으면 디폴트 페이지 1페이지
       if (empty($_GET['page'])) {
          $page=1;
      }else {
          $page=$_GET['page'];
      }
      $start=($page-1) * SCALE;
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

        if(!$result){
          echo ("<tr><td colspan='10'>처리할 결제 내역이 없습니다.<td></tr>");
        } else {
          for($i = $start; $i < $start+SCALE && $i<$total_record; $i++){
                mysqli_data_seek($result, $i);
                $row = mysqli_fetch_array($result);
                $ord_num     = $row["ord_num"];
                $id          = $row["id"];
                $total_price = $row["total_price"];
                $sales_day   = $row["sales_day"];
                $complete    = $row["complete"];
                $payment = $row["payment"];
                $payment =explode(',' , $payment);
                $sql = "select * from sales where ord_num='$ord_num'";
                $result_for_num = mysqli_query($conn, $sql);
                $record = mysqli_num_rows($result_for_num);

              ?>
                            <li>
                                <span class="col1"><?=$ord_num?></span>
                                <span class="col2"><?=$id?></span>
                                <span class="col3"><?=$record?>종류</span>
                                <span class="col4"><?=$total_price?>원</span>
                                <span class="col5"><?=$sales_day?></span>
                                <span class="col6">
                                    <select id="payment_status_<?=$i?>" class="no-autoinit">
                                        <?php if($complete === "결제완료") { ?>
                                        <option value='결제완료' selected="selected">결제완료</option>
                                        <option value='결제대기'>결제대기</option>
                                        <option value='주문취소'>주문취소</option>

                                    <?php } else if($complete === "결제대기") {?>
                                        <option value='결제완료'>결제완료</option>
                                        <option value='결제대기' selected="selected">결제대기</option>
                                        <option value='주문취소'>주문취소</option>
                                    <?php } else { ?>
                                        <option value='결제완료'>결제완료</option>
                                        <option value='결제대기'>결제대기</option>
                                        <option value='주문취소' selected="selected">주문취소</option>
                                        <?php } ?>
                                    </select>
                                </span>
                                <span class="col7"><?=$payment[0]?></span>
                                <span class="col8">
                                    <button type="button" class="btn_modify" id="btn_modify_<?=$i?>">수정</button>
                                </span>
                            </li>
                            <script type="text/javascript">
                                $("#btn_modify_<?=$i?>").click(function () {
                                    var selected_option = $("#payment_status_<?=$i?> option:selected").val();
                                    $
                                        .ajax({
                                            url: 'payment_curd.php',
                                            type: 'POST',
                                            data: {
                                                "ord_num": "<?=$ord_num?>",
                                                "complete": selected_option
                                            },
                                            success: function (data) {
                                                console.log(data);
                                                if (data === "수정 완료") {
                                                    alert("결제정보 수정 완료!");
                                                    location.href='admin_program_payment.php';
                                                } else if (data === "수정 실패") {
                                                    alert("결제정보 수정 실패!");
                                                }
                                            }
                                        })
                                        .done(function () {
                                            console.log("done");
                                        })
                                        .fail(function () {
                                            console.log("error");
                                        })
                                        .always(function () {
                                            console.log("complete");
                                        });
                                })
                            </script>
                            <?php
                }//end of for
            }
        ?>
      </ul>
    </div> <!-- admin_box -->
        <div id="page_button">
          <div id="page_num">
            <?php
            if($page>1){
              $val=(int)$page-1;
              if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
                ?>
                <a href="./admin_program_payment.php?mode=search&page=<?=$val?>&find=<?=$find?>&search=<?=$q_search?>">이전◀ </a>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php
              }else{
                echo "<a href='./admin_program_payment.php?page=$val'>이전◀ </a>&nbsp;&nbsp;&nbsp;&nbsp";
              }
            }?>
          <?php
            for ($i=$start_page; $i <= $end_page ; $i++) {
                if ($page==$i) {
                    echo "<b>&nbsp;$i&nbsp;</b>";
                } else {
                  if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
                    ?>
                    <a href="./admin_program_payment.php?mode=search&page=<?=$i?>&find=<?=$find?>&search=<?=$q_search?>">&nbsp;<?=$i?>&nbsp;</a>
                    <?php
                  }else{
                    echo "<a href='./admin_program_payment.php?page=$i'>&nbsp;$i&nbsp;</a>";
                  }
                }
            }
          ?>
          <?php
          if($page>=1 && $total_page!=$page){
            $val=(int)$page+1;
            if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
              ?>
              &nbsp;&nbsp;&nbsp;&nbsp;<a href="./admin_program_payment.php?mode=search&page=<?=$val?>&find=<?=$find?>&search=<?=$q_search?>">▶ 다음</a>
                <?php
            }else{
              echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='./admin_program_payment.php?page=$val'>▶ 다음</a>";
            }
          }
           ?>
          <br><br><br><br><br><br><br>
        </div><!--end of page num -->
      </div>
    </div>		<!-- end of content -->
  </div><!--  end of admin_board -->
    </section>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>
  </body>
</html>
