<?php session_start(); 

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: 관리자페이지</title>
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
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
  </head>
  <body>
    <script src="./chart/highcharts.js"></script>
    <script src="./chart/exporting.js"></script>
    <script src="./chart/export-data.js"></script>
    <script src="./chart/accessibility.js"></script>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php";?>
    </header>
    <section>
      <?php
      $sql="select month(s.sales_day) as 'month', sum(p.price) as 'm_sales' from sales s ";
      $sql.="inner join program p on s.o_key = p.o_key ";
      $sql.="group by month order by month";

      $result = mysqli_query($conn, $sql);

      $array =array(0,0,0,0,0,0,0,0,0,0,0,0);
      while($row=mysqli_fetch_array($result)) {
        $month = $row['month'];
        $sales = $row['m_sales'];
        $array[$month-1] = $sales/10000;
      }
      ?>

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
      var arr1 = <?php echo  json_encode($array);?> ;
      console.log(arr1);
      var arr2 = <?php echo  json_encode($array2);?> ;
      console.log(arr2);
      </script>
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
            <h3>통계 > 월별 매출</h3><br>

            <div id="container" style="min-width: 300px;min-height: 300px; max-height: 500px; max-width: 750px; margin-left:20px;"></div>



            <script type="text/javascript">
        Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Monthly Revenue'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: '매출액(만원)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: '매출',
                data: [<?=$array[0]?>, <?=$array[1]?>, <?=$array[2]?>,<?=$array[3]?>, <?=$array[4]?>, <?=$array[5]?>,
              <?=$array[6]?>,<?=$array[7]?>,<?=$array[8]?>,<?=$array[9]?>,<?=$array[10]?>,<?=$array[11]?>]
            }]
        });
            </script>
            <br><br>

            <h3>통계 > 가게별 매출</h3><br>


    <figure class="highcharts-figure">
        <div id="container2" style="height: 480px; max-width:750px; margin-left:20px;"></div>
    </figure>

    <script type="text/javascript">
        Highcharts.chart('container2', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Revenue by Shop'
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
                    '<td style="padding:0"><b>{point.y:.1f} 만원</b></td></tr>',
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
                name: 'SHOP',
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

          </div><!-- //content -->
        </div>
    </section>
  <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
  </footer>
  </body>
</html>
