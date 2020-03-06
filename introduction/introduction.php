<?php
  session_start();
 include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/create_table.php";
 $mater="강윤해";
?>
<!DOCTYPE html>
<!-- 회사소개 -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: HELF 소개</title>
    <link
        rel="stylesheet"
        type="text/css"
        href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/css/common.css">
    <script type="text/javascript" src="./common/js/main.js"></script>
    <link rel="stylesheet" href="./css/introduction.css">
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
    </header>
    <div id="div-body">
    <section>
      <article>
        <div id="div_header">
          <b><span>HELF</span></b>
        </div>
        <div id="div_introduction">
          <!-- 운동과 친구 라이프  -->
          <p>안녕하세요 HELF 대표 <b><?=$mater?></b> 입니다. <br/> <br/>
            저희 <span>HELF</span>&nbsp;는 건강한 몸을 키우고 윤택한 삶을 살기 원하는 여러분께 <br/> <br/>
            활력을 드리고자 마음이 맞는 사람들이 모여 만든 커뮤니티입니다.<br/> <br/>

            </p>
            <img src="./img/introduction1.jpg" width="800" alt=""><br/><br/>
            <p>

            <div class="one">
              <div class="two">
                “&nbsp;&nbsp;
              </div>
              <div class="span_em">HELF에는</div><br>
              <b>&nbsp;<span>Health&nbsp;,&nbsp;Life&nbsp;,&nbsp;Friends</span>&nbsp;</b><br><br>
              <div class="span_em">세 가지 의미가 담겨 있습니다.</div>
                <div class="two">
                &nbsp;”
              </div>
              </div><br/> <br/>
            <span>HELF</span>&nbsp;의 뜻은 운동, 활력, 친구로 <br/> <br/>
            건강한 삶을 위해 노력하는 여러분 곁에서 도와드리는 친구를 뜻합니다.<br/> <br/> <br/>

            운동을 같이할 친구를 찾기 힘들 때,<br/> <br/>
            원하는 시간과 원하는 장소에 맞추어서 같이 운동할 친구를 만들 수 있는<br/> <br/>
            그러한 장소를 찾았지만 처음 시작하는 분들께는 그러한 손길이 닿기 힘든 경우가 많습니다.<br/> <br/> <br/>

            </p>
            <img src="./img/introduction2.jpg" width="800" alt=""><br/><br/>
            <p>

            <span>HELF</span>&nbsp;에서는 운동을 배우고자 하는 초심자들과 숙련자, 전문가들이 공존하며 <br/> <br/>
            그 만남이 딱딱하게 가르쳐주고 가르침을 받는 관계가 아닌, 친구처럼 다가와<br/> <br/>
            담소를 나누거나 정보를 주고 받는 모습을 담고자 하였습니다.<br/> <br/><br/>

          </p>
            <img src="./img/introduction3.jpg" width="800" alt=""><br/><br/>
            <p>

            <span>HELF</span>&nbsp;는 여러분 곁에서 오랜 친구처럼<br/> <br/>
            항상 처음 마음 가짐 그대로 함께 하겠습니다.<br/> <br/> <br/>
           오늘도 건강하고, 활기차고, 힘찬 하루를 보내시기 바랍니다.  감사합니다. <br/> <br/>
</p>
<br/>
<p>
            <div class="master">
              <b>HELF 대표 <?=$mater?></b><br/><br/>
            </div>
        </p>
        </div>
      </article>
    </section>
  
  </div>
  <footer>
  <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
  </footer>
  </body>
</html>
