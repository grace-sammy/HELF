<!-- bmi와 kcal이 모드를 가져오면 확인후 계간해서 화면 출력하는부분 -->
<?php
  if(isset($_GET['mode'])){
    $mode=$_GET['mode'];
  }else{
    echo "<script>
    alert('오류가 발생했습니다');
    <script/>";
    return;
  }
  switch ($mode) {
    case 'bmi'://
      $gen = $_POST['gen']; //성별
      $age = $_POST['age']; //나이
      if($gen==="man"){
        $gen="남성";
      }else{
        $gen="여성";
      }
      $cm = $_POST['cm']; //신장
      $kg = $_POST['kg']; //무게
      $meter = $cm*0.01;
      $bmi = ceil($kg/($meter*$meter)); //bmi지수
      // 공식 bmi지수= 몸무게 / (신장*신장)
      break;
    case 'kcal'://
    $gen = $_POST['gen'];
    $age = $_POST['age'];

    $cm = $_POST['cm'];
    $kg = $_POST['kg'];
    $goal_kg = $_POST['goal_kg'];
    $term = $_POST['term']; //기간
    $work = $_POST['work']; //활동량 수치
    //기초대사량
    if($gen==="man"){
      $basic_met=293-(3.8*$age)+456.4*($cm/100)+10.12*$kg;
      $gen="남성";
    }else{
      $basic_met=247-(2.67*$age)+401.5*($cm/100)+8.60*$kg;
      $gen="여성";
    }
    $basic_met = $basic_met; //기초 대사량
	  $active_met = $basic_met*$work; //활동대사량
	  $digest_met = (($basic_met+$active_met)/0.9)*0.1; //소화 대사량
	  $all_met = $basic_met+$active_met+$digest_met; //전체 대사량

    $minus_weight=$kg-$goal_kg; //현재 몸무게 - 목표 몸무게
	  $target_cal	= 7700*$minus_weight;		//목표감량
	  $day_cal = $target_cal / ($term*30);		//일일감량 칼로리
	  $day_target_cal	= $all_met - $day_cal;			//일일 목표칼로리
	  $day_eat_cal = ceil($day_target_cal*1.2);			//음식칼로리
	  $day_exercise_cal = ceil($day_target_cal * 0.2);		//운동칼로리
      break;
    default://
      return;
  }
 ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link
        rel="stylesheet"
        type="text/css"
        href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/css/label.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/css/calcuator.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/js/bmi.js" charset="utf-8"></script>
  </head>
  <body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
    </header>
    <div class="div_calculator">

  <?php
if($mode==="bmi"){
  ?>
  <div>
    <div class="div_bmi">
         <h2>BMI수치 결과</h2>
    <ul>
      <li>
        <label for="gen">성별</label>
        <span id="gen"><?=$gen?></span>
      </li>
      <li>
        <label for="age">나이(연령)</label>
        <span id="age"><?=$age?> 세</span>
      </li>
      <li>
        <label for="cm">신장(cm)</label>
        <span  id="cm"><?=$cm?> cm</span>
      </li>
      <li>
          <label for="kg">몸무게</label>
          <span id="kg"><?=$kg?>kg</span>
      </li>
      <li>
        <label for="bmi">BMI수치</label>
        <span id="bmi"><?=$bmi?> BMI</span>
      </li>
    </ul>
    <div class="bmi-wrap">
				<div class="bmi">
					<p class="tit"><span class="p-red">비만도(BMI)</span> 검사 결과</p>
					<div class="graph">
						<div class="inner">
							<img id="bar" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/img/img_bmi.png" alt="">
							<a href="javascript:;" id="grapnavi" class="btn-point">
								<img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/img/btn_point.png" alt="">
								<span id="bmicnt"></span>
							</a>
						</div>
					</div>
					<ul class="bul-x-list">
						<li id="bmi_text"></li>
					</ul>
				</div>
			</div>
      </div>
    </div>
  <?php
  echo ("<script>bmi_fun($bmi)</script>");
}else{
   ?>
   <div id="div_form">
     <div class="div-bmi">
   <h2>칼로리 처방 결과</h2>
   <ul>
     <li>
       <label for="gen">성별</label>
       <span id="gen"><?=$gen?></span>
     </li>
     <li>
       <label for="age">나이(연령)</label>
       <span id="age"><?=$age?></span>
     </li>
     <li>
       <label for="cm">신장(cm)</label>
        <span id="cm"><?=$cm?></span>
     </li>
     <li>
       <label for="term">기간</label>
        <span id="term"><?=$term?> 개월</span>
     </li>
     <li>
       <label for="kg">몸무게</label>
        <span id="kg"><?=$kg?></span>
     </li>
     <li>
       <label for="goal_kg">목표 몸무게</label>
       <span id="goal_kg"><?=$goal_kg?></span>
     </li>
     <li>
       <label for="all_met">하루 활동량에 대한 예상대사량</label>
       <span id="all_met"><?=ceil($all_met)?> kcal</span>
     </li>
     <li>
       <label for="day_eat_cal">하루 섭취 권장 음식 칼로리</label>
       <span id="day_eat_cal"><?=$day_eat_cal?> kcal</span>
     </li>
     <li>
       <label for="day_exercise_cal">하루 동안 운동으로 소모해야 할 칼로리</label>
       <span id="day_exercise_cal"><?=$day_exercise_cal?> kcal</span>
     </li>
     <li>

     </li>
   </ul>
 </div>
   </div>
   <?php
}
 ?>
 <div id="div_aside">
   <aside>
     <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/aside.php";?>
   </aside>
 </div>
</div>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>

  </body>
</html>
