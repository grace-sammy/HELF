<?php
  session_start();

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: 관리자페이지</title>
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helf/common/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="../common/css/common.css">
    <link rel="stylesheet" type="text/css" href="../common/css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" href="./css/statistics.css">

  </head>
  <body>
    <script src="./chart/highcharts.js"></script>
    <script src="./chart/exporting.js"></script>
    <script src="./chart/export-data.js"></script>
    <script src="./chart/accessibility.js"></script>


    <header>
      <?php
      include "../common/lib/header.php";
      include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
      ?>
    </header>

    <?php
    $sql2="select p.shop, sum(p.price) as 'p_sales' from sales s ";
    $sql2.="inner join program p on s.o_key = p.o_key ";
    $sql2.="group by p.shop order by sum(p.price) desc";

    $result2 = mysqli_query($conn, $sql2);
    $array2 = array();

    for($i=0;$row2=mysqli_fetch_array($result2);$i++) {
      for ($j=0; $j<2; $j++) {
        if($j==0){
          $array2[$i][$j] = $row2['shop'];
        }else{
          $array2[$i][$j] = $row2['p_sales']/10000;
        }

      }
    }
    ?>

    <script>
    var arr2 = <?php echo  json_encode($array2);?> ;
    console.log(arr2);
    </script>

  <div id="admin">
    <div id="admin_border">
  		<p>관리자페이지</p>
  		<!-- snb -->
  		<div id="snb">
        <aside id="left-panel" class="left-panel">


          <div id="main-menu" class="main-menu collapse navbar-collapse">
            <h3 class="menu-title">-회원관리-</h3><!-- /.menu-title -->
            <ul>
              <li><a href="admin_user.php">회원관리</a></li>
            </ul>
            <br>
            <h3 class="menu-title">-게시글 관리-</h3>
            <ul>
              <li><a href="admin_board.php">자유게시판 관리</a></li>
              <li><a href="admin_board2.php">후기게시판 관리</a></li>
            </ul>
            </ul>
            <br>
            <h3 class="menu-title">-프로그램 관리-</h3>
            <ul>
              <li><a href="admin_program_regist.php">프로그램 등록</a></li>
              <li><a href="admin_program_manage.php">프로그램 관리</a></li>
              <li><a href="admin_program_payment.php">결제 관리</a></li>

            </ul>
            <br>
            <h3>-통계-</h3>
            <ul>
              <li><a href="admin_statistics1.php">월별매출</a></li>
              <li><a href="admin_statistics2.php">프로그램별 매출</a></li>
              <li><a href="admin_statistics3.php">회원별 매출</a></li>
            </ul>


              </div><!-- /.navbar-collapse -->

      </aside><!-- /#left-panel -->
  		</div>
  		<!-- //snb -->
  		<!-- content -->
  		<div id="content">
        <h3>통계 > 가게별 매출</h3><br>


<figure class="highcharts-figure">
    <div id="container2"></div>
</figure>



		<script type="text/javascript">
Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: '회원 매출'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: {
        categories: [
          <?php
          for($i=0; $i<count($array2); $i++){
            if($i < count($array2)-1){
              echo "'".$array2[$i][0]."',";
            }else{
              echo "'".$array2[$i][0]."'";

            }
          }
          ?>
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: '매출액 (만원)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Tokyo',
        data: [
          <?php
          for($i=0; $i<count($array2); $i++){
            if($i < count($array2)-1){
              echo $array2[$i][1].",";
            }else{
              echo $array2[$i][1];

            }
          }
          ?>
        ]

    }]
});
		</script>

  		</div>
  		<!-- //content -->
  	</div>



  </div>

  <div id="footer">
    <p>#footer</p>
  </div>


  </body>
</html>
