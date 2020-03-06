<?php
  session_start();

if(isset($_GET['ord_num'])){
  $ord_num = $_GET['ord_num'];
} else {
  $ord_num = "";
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HELF :: 관리자페이지</title>
    <link rel="stylesheet" type="text/css" href="../css/payment_complete.css">
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
  	<header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/header.php"; 
        $sql = "select * from sales where ord_num='$ord_num'";
        $result = mysqli_query($conn, $sql);
        $paid_num = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result)){
          $amount   = $row['total_price'];
          $program_num = $row['ord_num'];
          $paid_date = $row['sales_day'];
          $o_key =$row['o_key'];
  
          $sql = "select subject from program where o_key=$o_key";
          $result2 = mysqli_query($conn, $sql);
          $row2 = mysqli_fetch_array($result2);
          $subject = $row2['subject'];
        } 
       
?>
    </header>
    <section>
     <div id="admin_border">

       <div id="content">
            <?php
            if(isset($_GET['bank'])&&($_GET['bank']!=="")){
          
                ?>
                         <h1>주문 완료</h1><br>
         <p>주문 내용을 확인하신 후 결제 진행 바랍니다.</p>
         <table>
            <tr>
                 <th>주문일자</th><td>&nbsp;<?=$paid_date?></td>
            </tr>
            <tr>
                 <th>주문번호</th><td>&nbsp;<?=$program_num?></td>
            </tr>
             <tr>
               <?php 
                if($paid_num > 1) {
                    $paid_num -= 1;
                    echo("<th>상품명</th><td>&nbsp;$subject 외 $paid_num 개</td>");
                } else {
                  echo("<th>상품명</th><td>&nbsp;$subject</td>");
                }
               ?>
            </tr>
            <tr>
                 <th>주문금액</th><td>&nbsp;<?=$amount?>원</td>
</tr>
                <tr>
                 <th>결제은행</th>
                 <?php
                 switch($_GET['bank']){
                    case "shinhan":
                      $sql = "update sales set payment='신한은행,HELF,000000-000-00000' where o_key=$o_key";
                      mysqli_query($conn, $sql);
                        echo("<td>&nbsp;
                            신한은행 <br>
                            &nbsp;예금주: HELF, 계좌번호: 000000-000-00000
                        </td>");
                    break;
                    case "hana":
                      $sql = "update sales set payment='하나은행,HELF,111111-111-11111' where o_key=$o_key";
                      mysqli_query($conn, $sql);
                        echo("<td>&nbsp;
                        하나은행 <br>
                        &nbsp;예금주: HELF, 계좌번호: 111111-111-11111
                    </td>");
                    break;
                    case "woori":
                      $sql = "update sales set payment='우리은행,HELF,222222-222-22222' where o_key=$o_key";
                      mysqli_query($conn, $sql);
                        echo("<td>&nbsp;
                        우리은행 <br>
                        &nbsp;예금주: HELF, 계좌번호: 222222-222-22222
                    </td>");
                    break;
                 }
                 ?>
                </tr>
                <tr>
                 <th>진행상태</th><td>&nbsp;결제대기</td>
                </tr>
                <?php
          } else {
           
            ?>
                     <h1>결제 완료</h1><br>
         <p>결제 내용을 확인해 주시기 바랍니다.</p>
         <table>
            <tr>
                 <th>주문일자</th><td>&nbsp;<?=$paid_date?></td>
            </tr>
            <tr>
                 <th>주문번호</th><td>&nbsp;<?=$program_num?></td>
            </tr>
             <tr>
             <?php 
              if($paid_num > 1) {
                $paid_num -= 1;
                echo("<th>상품명</th><td>&nbsp;$subject 외 $paid_num 개</td>");
            } else {
              echo("<th>상품명</th><td>&nbsp;$subject</td>");
            }
               ?>
            </tr>
            <tr>
                 <th>주문금액</th><td>&nbsp;<?=$amount?>원</td>
</tr>
            <tr>
                 <th>진행상태</th><td>&nbsp;결제완료</td>
                </tr>
                <?php
          }
          ?>

         </table>
         <div class="buttons">
         <button type="botton" onclick="location.href='../../index.php'">메인으로 돌아가기</button>
         </div>
       </div> <!--  end of content -->
     </div><!--  end of admin_board -->
  </section>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/footer.php";?>
    </footer>
  </body>
</html>
