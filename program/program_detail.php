<!-- 구매전 페이지 -->
<?php
  session_start();
 if(isset($_GET['o_key'])){
   $o_key=$_GET['o_key'];
   $o_key=(int)$o_key;
 }else{
   echo "<script>alert('접속 오류 발생');</script>";
   return;
 }
 define('SCALE', 5);
 $mode="insert";
 $update="";
 $user_id="";
 if(isset($_SESSION['user_id'])&&$_SESSION['user_id']!==""){
   $user_id=$_SESSION['user_id'];
 }
 if(isset($_SESSION["user_grade"])){
   $user_grade=$_SESSION["user_grade"];
 }

 if(!isset($_COOKIE['today_view'])){
 	setcookie('today_view', $o_key, time() + 21600, "/");
 } else {
   $tmp_array=explode(",", $_COOKIE['today_view']); // today_view 쿠키를 ','로 나누어 구분한다.
   $tv_array=array_reverse($tmp_array); // 최근 목록 3개를 뽑기 위해 배열을 최신 것부터로 반대로 정렬해준다.
     setcookie('today_view', $_COOKIE['today_view'].", ".$o_key, time() + 21600, "/");

   // if(!in_array($o_key, $tv_array)){ // 저장된 쿠키값이 존재하고, 중복된 값이 아닌 경우 기존의 today_view 쿠키에 현재 쿠키를 추가하는 소스

   //   }
 }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: 구매확인페이지</title>
    <script src="http://code.jquery.com/jquery-1.12.4.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="./css/program_detail.css">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <link
        rel="stylesheet"
        type="text/css"
        href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
    <script src="./js/program_detail.js" charset="utf-8"></script>

  </head>
  <body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
    </header>
    <?php
     // ==============================
     $sql = "select * from program where o_key=$o_key";
     $result = mysqli_query($conn, $sql);
     $row = mysqli_fetch_array($result);

     $shop     = $row["shop"];
     $type      = $row["type"];
     $subject   = $row["subject"];
     $end_day   = $row["end_day"];
     $content = $row["content"];
     $location  = $row["location"];
     $phone_number = $row["phone_number"];

     $location = str_replace(",", " ",$location);

     $file_copied= $row["file_copied"];
     $min_price = $row["price"];
     $image               = explode(",",$file_copied);
     $file_type  = $row["file_type"];

     ?>
      <div class="clear"></div>
    <div id="div_main_body">
            <section>
              <script type="text/javascript">
              function move1(){
                var offset = $("#program_explain_h3").offset();
                $('html, body').animate({scrollTop : offset.top-220}, 200);
              }
              function move2(){
                var offset = $('#price_h3').offset();
                $('html').animate({scrollTop : offset.top-220}, 200);
              }
              function move3(){
                var offset = $('#calcel_h3').offset();
                $('html').animate({scrollTop : offset.top-220}, 200);
              }
              function move4(){
                var offset = $('#qna_h3').offset();
                $('html').animate({scrollTop : offset.top-220}, 200);
              }

              </script>
              <div id="div_main">
                 <img id="main_img" src='../admin/data/<?=$image[0]?>'>
                 <br><br>
                <div class="buttons" id="myHeader">
                  <ul>
                    <li><a onclick="move1()">프로그램 설명</a></li> |
                    <li><a onclick="move2()">가격 정보</a></li> |
                    <li><a onclick="move3()">취소 및 환불규정</a> </li> |
                    <li><a onclick="move4()">QnA / 후기</a> </li>
                  </ul>
                </div>
                <br><br>
                <script type="text/javascript">
                window.onscroll = function() {myFunction()};
                var header = document.getElementById("myHeader");
                var sticky = header.offsetTop;

                function myFunction() {
                  if (window.pageYOffset > sticky+25) {
                    header.classList.add("sticky");
                  } else {
                    header.classList.remove("sticky");
                  }
                }

                </script>
                <div class="" id="see">
                  <br><br><br>
                  <h3 id="program_explain_h3">프로그램 설명</h3>
                  <div class="see_body">
                    <p><?=$content?></p>
                    <div class="clear"></div>
                    <table id="content_table">
                      <tr>
                        <td class="content_td1">지역</td>
                        <td><?=$location?></td>
                      </tr>
                      <tr>
                        <td class="content_td1">분야</td>
                        <td><?=$type?></td>
                      </tr>
                      <tr>
                        <td class="content_td1">모집 마감일</td>
                        <td><?=$end_day?></td>
                      </tr>
                      <tr>
                        <td class="content_td1">연락처</td>
                        <td><?=$phone_number?></td>
                      </tr>
                    </table>
                  <br/><br/>
                </div>
              </div>
                <?php

                for($i=1;$i<count($image);$i++){
                ?>
                  <img src='../admin/data/<?=$image[$i]?>' style="height:280px; width:400px;">
                <?php
                }
                ?>
                    <div class="clear"></div>
                <div class="" id="pay">
                  <h3 id="price_h3">가격 정보</h3>
                  <div class="pay_table">
                    <table>
                      <tr>
                        <th>옵션</th>
                        <th>가격</th>
                      </tr>
                       <?php
                         $sql="select * from program where shop='$shop'and type='$type' order by price";
                         $result = mysqli_query($conn, $sql);
                       while($row = mysqli_fetch_array($result)){
                         $table_choose = $row["choose"]; //옵션 내용
                         $table_price = (int)$row["price"]; //옵션에 대한 가격
                         if(!($table_choose==="선택")){
                        ?>
                        <tr>
                          <td><?=$table_choose?></td>
                          <td><?=$table_price?>원</td>
                        </tr>

                         <?php
                         }
                         }
                            ?>
                    </table>

                  </div>
                </div>
                  <div class="clear"></div><br/><br/>
                <div class="" id="cancel">
              <h3 id="calcel_h3">취소 및 환불 규정</h3>
<p>가. 레슨 환불기준 원칙<br/>
학원의 설립/운영 및 과외교습에 관한 법률 제 18조(교습비 등의 반환 등)<br/>
- 학원설립, 운영자, 교습자 및 개인과외교습자는 학습자가 수강을 계속할 수 없는 경우 또는 학원의 등록말소, 교습소 폐지 등으로 교습을 계속할 수 없는 경우에는 학습자로부터 받은<br/>
교습비를 반환하는 등 학습자를 보호하기 위하여 필요한 조치를 하여야 한다.<br/><br/>

1. 레슨을 제공할 수 없거나, 레슨 장소를 제공할 수 없게 된 날 : 이미 납부한 레슨비 을 일한 계산한 금액 환불<br/>
<br/>
2. 레슨기간이 1개월 이내의 경우<br/>
- 레슨 시작전 : 이미 납부한 레슨비 전액 환불<br/>
- 총 레슨 시간의 1/3 경과전 : 이미 납부한 레슨비의 2/3에 해당액 환불<br/>
- 총 레슨 시간의 1/2 경과전 : 이미 납부한 레슨비용의 1/2에 해당액 환불<br/>
- 총 레슨시간의 1/2 경과후 : 반환하지 않음<br/><br/>

3.레슨 기간이 1개월을 초과하는 경우<br/>
- 레슨 시작전 : 이미 납부한 레슨비 전액 환불<br/>
- 레슨 시작후 : 반환사유가 발생한 당해 월의 반환 대상 레슨비(레슨비 징수기간이 1개월 이내인 경우에 따라 산출된 수강료를 말한다)와 나머지 월의 레슨비 전액을 합산한 금액 환불<br/>
<br/>
* 총 레슨 시간의 레슨비 징수기간 중의 총레슨시간을 말하며, 반환 금액의 산정은 반환 사유가 발생한 날까지 경과 된 레슨시간을 기준으로 함<br/>
</p>  </div>
                <div class="clear"></div><br/><br/>
                <div id="program_qna"> <!--프로그램 qna 게시판이 들어갈 자리-->
                  <h3 id="qna_h3">QnA</h3>
                  <p style="text-align:left; display:inline-block;">구매하시려는 상품에 대해 궁금하신 점이 있으신 경우 문의해주세요.</p>&nbsp
                  <br><br><button type="button" id="question_btn" onclick="qna_mode(this.value,<?=$o_key?>,null)" name="button" value="new_insert">문의하기</button>
                  <br><br>
                  <?php
                  $sql="select * from `p_qna` where `shop`='$shop' and `type`='$type' order by group_num desc, ord asc;";
                  $result = mysqli_query($conn, $sql);
                  $total_record=mysqli_num_rows($result);
                  $total_page=($total_record % SCALE == 0)?($total_record/SCALE):(ceil($total_record/SCALE));
                  if (empty($_GET['page'])) {
                      $page=1;
                  } else {
                      $page=$_GET['page'];
                  }
                  $start=($page -1) * SCALE;
                  $number = $total_record - $start;
                  for ($i = $start; $i < $start+SCALE && $i<$total_record; $i++) {
                      mysqli_data_seek($result, $i);
                      $row = mysqli_fetch_array($result);
                      $qna_num=$row['num'];
                      $qna_o_key=$row['o_key'];
                      $qna_group_num=$row['group_num'];
                      $qna_id=$row['id'];
                      $qna_regist_day=$row['regist_day'];
                      $qna_subject=$row['subject'];
                      $qna_content=$row['content'];
                      $qna_depth=(int)$row['depth'];
                      $space="";
                      if($qna_depth == 0){
                      ?>
                      <div class="if_queation">
                        <div class="qna_image">
                          <img src="./img/question.png" alt="">
                        </div>
                        <div id="div_question">
                          <div class="qna_head"><!--제목 머릿부분-->
                            <div style="display:inline-block">
                              <span>&nbsp&nbsp<?=$space.$qna_subject?></span>
                            </div>

                          </div>
                          <div class="qna_body"><!--내용부분-->
                            <div class="qna_content">
                              &nbsp&nbsp<?=$qna_content?>
                            </div>
                          </div>
                          <div class="qna_buttons">
                            <div style="display:inline-block; width:120px">
                              <span>작성자&nbsp;:&nbsp;<?=$qna_id?></span>
                            </div>
                            <div style="display:inline-block; width:180px">
                              <span>작성일&nbsp;:&nbsp;<?=$qna_regist_day?></span>
                            </div>
                            <div class="ta_right" style="width:340px">
                            <?php
                            if($user_id =="admin"){
                            ?>
                              <button type="button" onclick="qna_mode(this.value,<?=$o_key?>,<?=$qna_num?>)" name="button" value="insert">답글달기</button>
                            <?php
                             }
                             ?>

                            <?php
                            if($qna_id===$user_id || $user_grade ==="admin"){
                              echo '<button type="button" onclick="qna_mode(this.value,'.$o_key.','.$qna_num.')" name="button" value="delete">삭제</button>&nbsp';
                              echo '<button type="button" onclick="qna_mode(this.value,'.$o_key.','.$qna_num.')" name="button" value="update">수정</button>';
                            }
                            ?>
                            </div>
                          </div>
                        </div>
                      </div><!--end of if_question-->

                      <?php
                    }else{
                      ?>
                      <div class="if_answer">
                        <div class="qna_image">
                          <img src="./img/answer.png" alt="" style="margin-left:30px;">
                        </div>
                        <div id="div_answer">
                          <div class="qna_head"><!--제목 머릿부분-->
                            <div style="display:inline-block">
                              <span>&nbsp&nbsp<?=$space.$qna_subject?></span>
                            </div>
                          </div>
                          <div class="qna_body"><!--내용부분-->
                            <div class="qna_content">
                              &nbsp&nbsp<?=$qna_content?>
                            </div>
                          </div>
                          <div class="qna_buttons">
                            <div style="display:inline-block; width:120px">
                              <span>작성자&nbsp;:&nbsp;<?=$qna_id?></span>
                            </div>
                            <div style="display:inline-block; width:180px;">
                              <span>작성일&nbsp;:&nbsp;<?=$qna_regist_day?></span>
                            </div>
                            <div class="ta_right" style="width:285px">
                            <?php
                            if($qna_id===$user_id || $user_grade ==="admin"){
                              echo '<button type="button" onclick="qna_mode(this.value,'.$o_key.','.$qna_num.')" name="button" value="delete">삭제</button>&nbsp';
                              echo '<button type="button" onclick="qna_mode(this.value,'.$o_key.','.$qna_num.')" name="button" value="update">수정</button>';
                            }
                            ?>
                            </div>
                          </div>
                        </div>

                      </div><!--end of if_answer-->
                    <?php
                     }
                     ?>
                    <?php
                      $number--;
                    }
                   ?>

                   <div id="page_button">
                     <div id="page_num">
                       <?php
                       if($page>1){
                         $val=(int)$page-1;
                         echo "<a href='./program_detail.php?page=$val&o_key=$o_key'>이전◀ </a>&nbsp;&nbsp;&nbsp;&nbsp";
                       }?>
                     <?php
                       for ($i=1; $i <= $total_page ; $i++) {
                           if ($page==$i) {
                               echo "<b>&nbsp;$i&nbsp;</b>";
                           } else {
                               echo "<a href='./program_detail.php?page=$i&o_key=$o_key'>&nbsp;$i&nbsp;</a>";
                           }
                       }
                     ?>
                     <?php
                     if($total_page>=1 && $total_page!=$page){
                       $val=(int)$page+1;
                       echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='./program_detail.php?page=$val&o_key=$o_key'>▶ 다음</a>";
                     }
                      ?>
                     <br><br><br><br><br>
                   </div><!--end of page_num-->
                 </div><!--end of page_button-->
                <div class="clear"></div><br/>
                <div id="div_review">
                  <h3>후기작성</h3>
                  <ul>
                  <li >
                    <div id=""><!--댓글 달기 insert-->
                      <form class="form_review" name="form_review" action="./program_review.php" method="post">
                       <div id="star_div" >
                       <div class="starRev" style="text">
                         <!-- <span class="starR1" >0.5</span> -->
                         <span class="starR2 on" >1</span>
                         <!-- <span class="starR1" >1.5</span> -->
                         <span class="starR2" >2</span>
                         <!-- <span class="starR1" >2.5</span> -->
                         <span class="starR2" >3</span>
                         <!-- <span class="starR1" >3.5</span> -->
                         <span class="starR2" >4</span>
                         <!-- <span class="starR1" >4.5</span> -->
                         <span class="starR2" >5</span>
                       </div> <br>
                        <textarea style="resize: none;" name="content" id="reviwe_content"></textarea>
                         <input type="hidden" id="num" name="num" value="">
                         <input type="hidden" name="o_key" value="<?=$o_key?>">
                         <input type="hidden" name="type" value="<?=$type?>">
                         <input type="hidden" name="shop" value="<?=$shop?>">
                         <input type="hidden" id="star" name="star" value="0">
                         <input type="hidden" id="mode" name="mode" value="<?=$mode?>">
                         <input type="button" id="review_btn" value="등록" onclick="review_insert();">
                        </div>
                      </form>
                    </div>
                  </li>
                </ul>
                  <ul>
                  <?php
                    $sql="select * from `p_review` where `shop`='$shop' and `type`='$type' order by num desc";
                    $result = mysqli_query($conn, $sql);
                  while($row = mysqli_fetch_array($result)){
                    $num=$row['num'];
                    $review_id = $row["id"];
                    $review_content = $row["content"];
                    $review_regist_day = $row["regist_day"];
                    $review_score = (int)$row["score"];
                    switch ($review_score) {
                      case 0: $width=0;  break;
                      case 1: $width=25;  break;
                      case 2: $width=50;  break;
                      case 3: $width=75;  break;
                      case 4: $width=98;  break;
                      case 5: $width=123;  break;
                      default: break;
                    }
                   ?>

                   <li class="review_main">
                     <form class="" action="program_review.php?mode=delete" method="post">
                     <div class="review" style="margin:10px 20px;">
                       <div class="h_review" style="text-align:left; height:70px; margin-bottom:20px;">
                         <span class="review_start_img" style="width:150px;" >
                           <img id="user_star" width="<?=$width?>" style="height:25px;">
                         </span>
                         <span class="review_content" style="display:inline-block; padding-bottom:10px; width:380px; height:65px;">
                             <?=$review_content?>
                         </span>

                       </div>
                       <div class="h_review2" style="text-align:left; margin-left:150px;">
                         <span style="display: inline-block; width:150px">
                            &nbsp글작성자&nbsp;:&nbsp;<?=$review_id?>&nbsp&nbsp
                         </span>
                         <span style="display: inline-block; width:250px">
                           작성시간&nbsp;:&nbsp;<?=$review_regist_day?>
                         </span>
                         <?php
                          if ($user_id==$review_id || $user_grade=="admin") {
                          ?>
                            <input type="button" value="수정" onclick="review_update('<?=$num?>','<?=$review_content?>')"/>
                            <input type="submit" value="삭제">&nbsp&nbsp
                          <?php
                          }
                          ?>

                       </div>





                      <?php if ($review_id===$user_id ||$user_grade==="admin"){ ?>

                          <input type="hidden" name="shop" value="<?=$shop?>">
                          <input type="hidden" name="num" value="<?=$num?>">
                          <input type="hidden" name="type" value="<?=$type?>">
                          <input type="hidden" name="o_key" value="<?=$o_key?>">

                     </form>
                      <?php } ?>
                     </div>
                   </li>
                    <?php
                  }
                     ?>

                     <div class="clear"></div><br/>

                   </ul>
                </div><!--end of div_review-->
              </div><!--end of program_qna-->
            </section>
            <aside>
              <div id="div_aside">
                <!-- 작업대 -->

                <h2><?=$shop?></h2>
                <form class="" action="#" method="post">
                  <p style="height:56px;">
                    <?=$subject?><br/>
                  </p>
                  <h3><span><?=$min_price?></span>원 부터~</h3>
                  <input type="hidden" id="input_h_pay" name="" value="0">
                  <select class="" name="option" id="choose" onchange="pay(this.value);">
                    <option name ="basic" value="없음,0원">옵션선택</option>
                  <?php
                  $minimum_price=0; //최소가격
                  $sql="select * from program where shop='$shop'and type='$type' order by price";
                  $result = mysqli_query($conn, $sql);
                  while($row = mysqli_fetch_array($result)){
                    $shop          = $row["shop"]; //장소 이름
                    $type          = $row["type"]; //헬스나 pt
                    $end_day      = $row["end_day"]; //날짜
                    $choose       = $row["choose"]; //옵션 내용
                    $price        = (int)$row["price"]; //옵션에 대한 가격
                    $file_copied   = $row["file_copied"]; //이미지파일 이름
                    $file_type     = $row["file_type"]; //이미지파일에 타입
                    if(!($choose==="선택")){
                      if($minimum_price===0){
                        $minimum_price=$price;
                      }
                   ?>
                     <option value="<?=$choose?>,<?=$price?>원" ><?=$choose?> : <?=$price?>원</option>
                    <?php
                    }
                  }
                     ?>
                  </select>

                  <script type="text/javascript">
                    $('.starRev span').click(function(){
                      $(this).parent().children('span').removeClass('on');
                      $(this).addClass('on').prevAll('span').addClass('on');
                      valr=$(this).text();
                      document.getElementById("star").value=valr;
                      return false;
                    });
                    function pay(x){
                      var pick_option = x.split(",");
                      var rprice = pick_option[1].replace("원","");
                      if(pick_option[0] == "없음"){
                        document.getElementById("h_pay").innerHTML= "없음";
                      }else{
                        document.getElementById("h_pay").innerHTML= x;
                      }
                      document.getElementById("input_h_pay").value=rprice;
                    }
                    function program_purchase(){
                      let price = document.getElementById("input_h_pay").value;
                      if(price!=="0"){
                        location.href='./program_purchase.php?o_key=<?=$o_key?>&shop=<?=$shop?>&type=<?=$type?>&price='+price;
                        // var op_split = x.split(',');
                        // document.getElementById("h_pay").innerHTML=op_split[0];
                        document.getElementById("h_pay").innerHTML= x;
                      }else{
                        alert("옵션을 선택해주세요");
                      }
                    }
                    function program_pick_db(){
                      let price = document.getElementById("input_h_pay").value;
                      location.href='./pick_db.php?mode=cart_insert&shop=<?=$shop?>&type=<?=$type?>&price='+price;
                    }
                    function review_update(num,contenttext){
                      document.getElementById('mode').value="update";
                      document.getElementById('num').value=num;
                      document.getElementById('reviwe_content').value=contenttext;
                    }
                  function qna_mode(modetype,key,num) {
                     if(modetype==="delete"){
                         location.href="./p_qna_db.php?mode="+modetype+"&num="+num+"&o_key="+key;
                     }else{
                       window.open(
                         "http://<?php echo $_SERVER['HTTP_HOST'];?>/helf/program/p_qna.php?mode="+modetype+"&o_key="+key+"&num="+num,
                         "QnA",
                         "_blanck,resizable=no,menubar=no,status=no,toolbar=no,location=no,top=100px, le" +
                         "ft=100px , width=600px, height=450px"
                       );
                     }
                  }
                  function review_insert(){
                    let mode=document.getElementById('mode').value;
                    if(mode==="update"){
                      document.getElementById('mode').value="update";
                    }else{
                      document.getElementById('mode').value="insert";
                    }
                    document.form_review.submit();
                  }

                  </script>
                  <br/>
                  <div class="">
                    <p>선택옵션:</p>
                    <h3 style="margin-bottom:50px;"><span id="h_pay">없음</span></h3>

                  </div>

                  <?php
                  $sql4 = "select num from pick where id ='$user_id' and o_key = $o_key";
                  $result4 = mysqli_query($conn, $sql4);
                  $row4 = mysqli_fetch_array($result4);
                  $pick  = $row4["num"];

                  if($pick==""){
                   echo "<input type='button' value='찜하기' onclick=\"location.href='pick_db.php?detail=ok&mode=insert&o_key=$o_key&shop=$shop';\"><br>";
                 }else{
                   echo "<input type='button' id='pick' value='찜한 상품입니다' onclick=\"location.href='pick_db.php?detail=ok&mode=delete&o_key=$o_key&shop=$shop';\"><br>";
                 }
                   ?>
                  <input type="button" name="" value="장바구니" onclick="program_pick_db();">
                  <input type="button" name="" value="구매하기" onclick="program_purchase();">
                </form>


                <br><br><br>

                <div class="">
                  <div id="aside_keyword">
                      <p class="aside_title">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp최근 본 상품</p>
                      <ol id="keyword_area">
                      <?
                    $photo="none.png";
                    $subject="최근 본 상품이 없습니다.";
                    $shop=$type="";
                      if(isset($_COOKIE['today_view'])){
                          $cookie_array=explode(",", $_COOKIE['today_view']);
                          $cookie_count=sizeof($cookie_array);
                          if($cookie_count>3){
                              $cookie_count = 3;
                          }
                          $recent_array=array_reverse($cookie_array);
                          for($i=0; $i < $cookie_count; $i++){

                                  $sql = "SELECT * from `program` where `o_key`='$recent_array[$i]';";
                                  $result = mysqli_query($conn, $sql) or die("최근 본 상품 불러오기 실패: ".mysqli_error($conn));
                                  $row = mysqli_fetch_array($result);
                                  $photo = $row['file_copied'];
                                  $photo = explode(",", $photo);
                                  $subject = $row['subject'];
                                  $shop = $row['shop']." / ";
                                  $type = $row['type'];

                  ?>
                      <li>
                      <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/program/program_detail.php?o_key=<?=$cookie_array[$i]?>"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/admin/data/<?=$photo[0]?>"></a>
              <div><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/program/program_detail.php?o_key=<?=$cookie_array[$i]?>"><?=$shop?><?=$type?><br><?=$subject?></a></div>
                      </li>
                  <?php
                      }
                          } else {
                              ?>
                                <li>
                      <a href="#"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/admin/data/<?=$photo?>"></a>
              <div><a href="#" style="color:gray;"><?=$shop?><?=$type?><?=$subject?></a></div>
                      </li>
                              <?php

                          }
                  ?>
                      </ul>
                  </div>
                  <div id="program_ranking">
                      <div class="" style="text-align:center;">
                        <h3>프로그램 인기순위 Top 5!</h3>
                      </div>
                      <br>

                          <ul id="ul_program">
                            <li id="r_menu">
                              <p class="pr1">랭킹</p>
                              <p class="pr2">샵</p>
                              <p class="pr3">옵션</p>
                              <p class="pr4">판매량</p>
                            </li>
                            <?php
                            $sql="select p.o_key, p.shop, p.choose, count(s.num) as 'sales_rate' from sales s ";
                            $sql.="inner join program p on s.o_key = p.o_key ";
                            $sql.="group by p.o_key order by count(s.num) desc limit 5";

                            $result = mysqli_query($conn, $sql);
                            $array = array();

                            for($i=0;$row=mysqli_fetch_array($result);$i++) {
                              for ($j=0; $j<3; $j++) {
                                if($j == 0){
                                  $array[$i][$j] = $row["shop"];
                                }else if($j == 1){
                                  $array[$i][$j] = $row["choose"];
                                }else if($j == 2){
                                  $array[$i][$j] = $row["sales_rate"];
                                }
                              }
                            }

                              for($i=0; $i<count($array); $i++){
                                echo "<li>";
                                $rank=$i + 1;
                            ?>
                                <p class="pr1"><?=$rank?></p>
                                <p class="pr2">
                                <?php
                                if(strlen($array[$i][0]) > 15){
                                ?>
                                <MARQUEE><?=$array[$i][0]?></MARQUEE>
                                <?php
                              }else{
                                ?>
                                <?=$array[$i][0]?>
                                <?php
                                  }
                                 ?>
                                  </p>
                                <p class="pr3"><?=$array[$i][1]?></p>
                                <p class="pr4"><?=$array[$i][2]?></p>

                             <?php

                               echo "</li>";
                             }
                             ?>
                          </ul>


                  </div>

                </div>



              </div>




            </aside>
          </div>
            <div class="clear"></div>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>
  </body>
</html>
