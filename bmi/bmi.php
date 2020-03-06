<?php
  session_start();
 include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/create_table.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: BMI</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/css/label.css">
    <link
        rel="stylesheet"
        type="text/css"
        href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1:400,500,700|Nanum+Gothic+Coding:400,700|Nanum+Gothic:400,700,800|Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/HELF/bmi/css/label.css">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <script>
    function btn_bmi() {
      let $age = document.form_bmi.age;
      let $cm = document.form_bmi.cm;
      let $kg = document.form_bmi.kg;
      if(document.getElementById('man').checked==false &&
        document.getElementById('girl').checked==false){
        alert("성별을 체크해주세요");
        return;
      }else if($age.value===""||$age.value<=0||$age.value>150){
        alert("나이를 입력해주세요 0세이상 150세 이하로 넣어주세요");
        return;
      }else if($cm.value === ""|| isNaN($cm.value) || $cm.value < 50 || $cm.value > 300){
        alert("신장(cm)을 입력해주세요 50cm 이상 300cm이하로 적어주세요");
        return
      }else if($kg.value === "" ||$kg.value<=29||$kg.value>300){
        alert("몸무게(kg)을 입력해주세요 29kg이상 300kg이하로 입력해주세요");
        return
      }
      <?php $mode="bmi"?>
      document.form_bmi.submit();
    }
    </script>
  </head>
  <body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
    </header>
<!--  -->
    <section>
      <div id="div_bmi">
        <div id="div_form">
      <form class="" name="form_bmi" action="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/bmi/calculator.php?mode=<?=$mode?>" method="post">
        <div class="div-bmi">
          <h2>나의 BMI지수를 재보자</h2>
          <br/>
        <!-- get방식으로 안에 모드(타입)을 넣는다 bmi와 kcal을 한번에 처리한다 -->
        <ul>
          <li>
            <label for="gen">성별</label>
            <input type="radio" name="gen" id="man" value="man" checked>남
            <input type="radio" name="gen" id="girl" value="girl">여
          </li>
          <li>
            <label for="age">나이(연령)</label>
            <input type="number" name="age" id="age" value="">세
          </li>
          <li>
            <label for="cm">신장(cm)</label>
            <input type="number" name="cm" id="cm" value="">cm
          </li>
          <li>
            <label for="kg">몸무게</label>
            <input type="number" name="kg" id="kg" value="">kg
          </li>
        </ul>
        <br/>
        <p id="p_bmi">
          <b>비만도 측정(BMI)이란?<br/>
            나이, 신장(cm), 몸무게(kg)만으로 비만을 판정하는 비만 지수</b>
        </p>
        <br/>
        <div class="div_btn">
        <input id="bmi_btn" type="button" name="" value="확인" onclick="btn_bmi();">
      </div>
        </div>
      </form>
        </div>
        <div id="div_aside">
          <aside>
            <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/aside.php";?>
          </aside>
        </div>
      </div>
    </section>
<!--  -->
<footer>
    <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
</footer>
  </body>
</html>
