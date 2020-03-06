
<div id="main_content">
<div id="carousel_section">
<ul class="slider">
    <li>
        <a href="http://localhost/helf/notice/view.php?num=6"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/img01.jpg"></a>
    </li>
    <li>
        <a href="http://localhost/HELF/notice/view.php?num=7"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/img02.jpg"></a>
    </li>
    <li>
        <a href="http://localhost/helf/health_info/exercise/view.php?num=2&page=1&hit=3"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/img03.jpg"></a>
    </li>
    <li>
        <a href="http://localhost/HELF/notice/view.php?num=8"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/img04.jpg"></a>
    </li>
</ul>
<div id="slideshow_nav">
    <a href="#" class="prev">prev</a>
    <a href="#" class="next">next</a>
</div>


</div>
<ol class="pagination">

</ol>
  <div id=board_preview>
<div id="latest">
    <h4>인기게시글</h4>
    <ul>
<?php
  $sql = "SELECT post_id, COUNT(post_id) AS likeit FROM rating_community_info where rating_action='like'
  Group by post_id
  HAVING COUNT(post_id) > 0 order by likeit desc, post_id desc limit 5;";
  $result = mysqli_query($conn, $sql);
  $like_num = mysqli_num_rows($result);
  if(!$result){
    echo(mysqli_error($result));
  } else {
    for($i=0;$i<$like_num;$i++){
      $row = mysqli_fetch_array($result);
      $best_number = $row['post_id'];
      $sql = "select distinct name, subject, regist_day, community.num, hit, community.b_code from community 
      inner join rating_community_info 
      on community.num=rating_community_info.post_id where community.num=$best_number;";
      $result2 = mysqli_query($conn, $sql);
      if(!$result2){
        echo "게시판 DB 테이블이 생성 전이거나 아직 게시글이 없습니다.";
      } else {
        while($row2 = mysqli_fetch_array($result2)){
          $b_code = $row2["b_code"];
          $regist_day = substr($row2["regist_day"], 0, 10);
          $num = $row2['num'];
          $hit = $row2['hit'];
          if($b_code == "자유게시판"){
            $location = "/helf/community/free/";
          } else {
            $location = "/helf/community/review/";
          }
?>
      <li>
        <a href="http://<?php echo $_SERVER['HTTP_HOST'].$location; ?>view.php?num=<?=$num?>&hit=<?=$hit=$hit+1?>">
        <span><?= $row2["subject"]?></span>
        </a>
        <span><?= $row2["name"]?></span>
        <span><?= $regist_day?></span>
      </li>
<?php
        }
      }
    }
  }
?>
    </ul>
  </div>
  <div id="point_rank">
    <h4>같이할건강</h4>
      <ul>
<?php
  $sql = "select * from together order by num desc limit 5";
  $result = mysqli_query($conn, $sql);

  if(!$result){
    echo "게시판 DB 테이블이 생성 전이거나 아직 게시글이 없습니다.";
  } else {
    while($row = mysqli_fetch_array($result)){
      $regist_day = substr($row["regist_day"], 0, 10);
      $num = $row['num'];
      $hit = $row['hit'];
?>
      <li>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/together/view.php?num=<?=$num?>&hit=<?=$hit=$hit+1?>">
        <span>[<?= $row['area']?>] <?= $row["subject"]?></span>
        </a>
        <span><?= $row["name"]?></span>
        <span><?= $regist_day?></span>
      </li>
<?php
    }
  }
?>
      </ul>
  </div>
  </div>
  <div id="health_info">
    <h3 id="health_info_title">건강 정보</h3>
    <ul>
    <?php
  $sql = "select * from health_info order by num desc limit 9";
  $result = mysqli_query($conn, $sql);

  if(!$result){
    echo "게시판 DB 테이블이 생성 전이거나 아직 게시글이 없습니다.";
  } else {
    while($row = mysqli_fetch_array($result)){
      $b_code = $row["b_code"];
      $file_copied = $row['file_copied'];
      $data_location = "data/";
      $num = $row['num'];
      $hit = $row['hit'];
      if($b_code == "레시피"){
        $location = "/helf/health_info/recipe/";
      } else {
        $location = "/helf/health_info/exercise/";
      }
?>
      <li>
        <div class="img">
          <a href="http://<?php echo $_SERVER['HTTP_HOST'].$location; ?>view.php?num=<?=$num?>&hit=<?=$hit=$hit+1?>">
          <img src="http://<?php echo $_SERVER['HTTP_HOST'].$location.$data_location.$file_copied; ?>" alt="<?= $row["subject"]?>">
          </a>
        </div>
        <div class="txt">
          <p><?= $row["subject"]?></p>
          <em><?= $b_code?></em>
          <strong>|&nbsp;&nbsp;&nbsp;조회수
          <span id="hit"><?= $row["hit"]?></span></strong>
        </div>
      </li>
<?php
    }
  }
?>

    </ul>
  </div>
</div>
