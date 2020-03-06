<script type="text/javascript">
    function gym_search() {
        window.open(
            "http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/map/gym.php",
            "헬스장찾기",
            "_blanck,resizable=no,menubar=no,status=no,toolbar=no,location=no,top=100px, le" +
                    "ft=100px , width=350px, height=200px"
        );
    }
</script>
<div id="aside_menu">
    <ul id="aside_shortcut">
        <?php
  if(strpos(basename($_SERVER['PHP_SELF']), 'index') !== false){
    ?>
        <li>
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/bmi.php">
                <img
                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/link_shortcut01.png"
                    alt='BMI 측정(비만도 계산)'>
            </a>
        </li>
        <li class="right">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/kcal.php">
                <img
                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/link_shortcut02.png"
                    alt="칼로리처방"></a>
        </li>
        <li>
            <a href="#" onclick="gym_search();">
                <img
                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/link_shortcut03.png"
                    alt="우리동네 헬스장찾기"></a>
        </li>
        <li class="right">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/map/map.php">
                <img
                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/link_shortcut04.png"
                    alt="인바디 측정 보건소 찾기"></a>
        </li>
    <?php
  } else {
?>
        <li>
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/bmi.php">
                <img
                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/link_shortcut01_1.png"
                    alt='BMI 측정(비만도 계산)'>
            </a>
        </li>
        <li class="right">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/kcal.php">
                <img
                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/link_shortcut02_1.png"
                    alt="칼로리처방"></a>
        </li>
        <li>
            <a href="#" onclick="gym_search();">
                <img
                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/link_shortcut03_1.png"
                    alt="우리동네 헬스장찾기"></a>
        </li>
        <li class="right">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/map/map.php">
                <img
                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/link_shortcut04_1.png"
                    alt="인바디 측정 보건소 찾기"></a>
        </li>
        <?php
  }
?>
    </ul>

    <div id="aside_notice">
        <p class="aside_title">공지사항</p>
        <ul id="notice_area">
<?php
  if(strpos(basename($_SERVER['PHP_SELF']), 'index') !== false){
    $sql = "select * from notice order by num desc limit 10";
  }
  else{
    $sql = "select * from notice order by num desc limit 3";
  }
  $result = mysqli_query($conn, $sql);

  if(!$result){
    echo "공지사항 DB 테이블이 생성 전이거나 아직 게시글이 없습니다.";
  } else {
    while($row = mysqli_fetch_array($result)){
      $num = $row['num'];
      $hit = $row['hit'];
?>
            <li>
                <span><nobr><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/notice/view.php?num=<?=$num?>&hit=<?=$hit+1?>"><?= $row["subject"]?></a></nobr></span>
            </li>
            <?php
    }
  }
?>
        </ul>
    </div>

    <?php

 ?>
    <div id="aside_keyword">
        <p class="aside_title">최근 본 상품</p>
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

          <h3>프로그램 인기순위 Top 5!</h3><br>
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
