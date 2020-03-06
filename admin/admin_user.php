<?php
  session_start();

  if(isset($_GET["page"])) {
    $page = $_GET["page"];
  } else {
    $page = "1";
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: 관리자페이지</title>
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/admin_user.css">

    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
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

    <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/js/main.js"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/admin/js/materialize.js"></script>

    <script>
  //     document.addEventListener('DOMContentLoaded', function() {
  //   var elems = document.querySelectorAll('.collapsible');
  //   var instances = M.Collapsible.init(elems, options);

  // });

  // Or with jQuery

    $(document).ready(function(){
      M.AutoInit();
      $('.collapsible').collapsible();
    });
</script>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
    </header>
    <section>
        <div id="admin_border">
          <div id="snb">
            <div id="snb_title">
              <h1>관리자 페이지</h1>
            </div>
            <div id="admin_menu_bar">
              <h2>회원관리</h2><!-- /.menu-title -->
                <ul>
                  <li><a href="admin_user.php">회원관리</a></li>
                </ul>

              <h2>게시글 관리</h2>
                <ul>
                  <li><a href="admin_board_free.php">자유게시판</a></li>
                  <li><a href="admin_board_review.php">후기게시판</a></li>
                  <li><a href="admin_board_together.php">같이할건강</a></li>
                </ul>

              <h2>프로그램 관리</h2>
                <ul>
                  <li><a href="admin_program_regist.php">프로그램 등록</a></li>
                  <li><a href="admin_program_manage.php">프로그램 관리</a></li>
                  <li><a href="admin_program_payment.php">결제 관리</a></li>

                </ul>

              <h2>통계</h2>
                <ul id="sta_ul">
                  <li><a href="admin_statistics1.php">매출 분석</a></li>
                  <li><a href="admin_statistics2.php">인기 프로그램</a></li>
                </ul>
            </div>
          </div><!--  end of sub -->

          <div id="content">
            <h1 id="content_title">회원관리 > 회원<p>아이디를 클릭하시면 해당 회원의 상세 정보를 보실 수 있습니다.</p></h1><br>
            <ul class = "collapsible" data-collapsible = "accordion">

            <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                }

                $sql = "select * from members";
                $result = mysqli_query($conn, $sql);
                $total_record = mysqli_num_rows($result); // 전체 글 수

                $scale = 10;

                // 전체 페이지 수($total_page) 계산
                if ($total_record % $scale == 0) {
                    $total_page = floor($total_record/$scale);
                } // 소수점 내림, 반올림은 round, 올림은 ceil
                else {
                    $total_page = floor($total_record/$scale) + 1;
                }

                // 표시할 페이지($page)에 따라 $start 계산
                $start = ($page - 1) * $scale; // 페이지 세팅 넘버!!!!!

                $number = $total_record - $start;

               for ($i=$start; $i<$start+$scale && $i < $total_record; $i++) {
                   mysqli_data_seek($result, $i);
                   // 가져올 레코드로 위치(포인터) 이동
                   $row = mysqli_fetch_array($result);
                   // 하나의 레코드 가져오기
                   $id             = $row["id"];
                   $name           = $row["name"];
                   $phone          = $row["phone"];
                   $email          = $row["email"];
                   $address        = $row["address"];
                   $grade          = $row["grade"];

                   ?>
                   <li>
                     <div class = "collapsible-header"><span><?=$id?></span></div>
                     <div class = "collapsible-body">
                      <table>
                        <tr id="first_tr">
                          <td class="td1">아이디 (이름)</td>
                          <td class="td2"><?=$id?> (<?=$name?>)</td>
                          <td class="td1">등급</td>
                          <td class="td2">
                            <select id="update_grade_<?=$i?>" name="" class="no-autoinit">
                              <?php if($grade === "admin") { ?>
                                <option value="admin" selected>admin</option>
                                <option value="master">master</option>
                                <option value="user">user</option>
                              <?php } else if($grade === "master") {?>
                                <option value="admin">admin</option>
                                <option value="master" selected>master</option>
                                <option value="user">user</option>
                              <?php } else { ?>
                                <option value="admin">admin</option>
                                <option value="master">master</option>
                                <option value="user" selected>user</option>
                              <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td class="td1">전화번호</td>
                          <td class="td2"><?=$phone?></td>
                          <td class="td1">이메일 주소</td>
                          <td class="td2"><?=$email?></td>
                        </tr>
                        <tr>
                          <td class="td1">주소</td>
                          <td colspan="3" class="td3"><?=$address?></td>
                        </tr>
                      </table>
                      <div class="butoon_col">
                        <button type="button" name="button" id="modify_btn_<?=$i?>">수정</button>
                        <button type="button" name="button" onclick="location.href='user_curd.php?mode=delete&delete_id=<?=$id?>'">탈퇴</button>
                      </div>
                      <script type="text/javascript">
                        $("#modify_btn_<?=$i?>").click(function () {
                          var selected_option =   $("#update_grade_<?=$i?> option:selected").val();
                          $.ajax({
                              url: 'user_curd.php?mode=modify',
                              type: 'POST',
                              data: {
                                "id": "<?=$id?>",
                                "grade": selected_option
                              },
                              success: function(data) {
                                console.log(data);
                                if(data === "수정 완료") {
                                  alert("회원등급 수정 완료!");
                                }else if(data === "수정 실패") {
                                  alert("회원등급 수정 실패!");
                                }
                              }
                            })
                            .done(function() {
                              console.log("done");
                            })
                            .fail(function() {
                              console.log("error");
                            })
                            .always(function() {
                              console.log("complete");
                            });
                        })
                      </script>
                     </div>
                   </li>
            <?php
                   $number--;
               }

            ?>
                    </ul>

                  <ul id="page_num">
            <?php
                if ($total_page>=2 && $page >= 2) {
                    $new_page = $page-1;
                    echo "<li><a href='admin_user.php?page=$new_page'>◀ 이전</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }

                // 게시판 목록 하단에 페이지 링크 번호 출력
                for ($i=1; $i<=$total_page; $i++) {
                    if ($page == $i) {     // 현재 페이지 번호 링크 안함
                        echo "<li><b> $i </b></li>";
                    } else {
                        echo "<li><a href='admin_user.php?page=$i'>  $i  </a><li>";
                    }
                }
                if ($total_page>=2 && $page != $total_page) {
                    $new_page = $page+1;

                    echo "<li> <a href='admin_user.php?page=$new_page'>다음 ▶</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }
            ?>
            </ul> <!-- page -->
          </div>		<!-- end of content -->

        </div><!--  end of admin_board -->
    </section>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>


  </body>
</html>
