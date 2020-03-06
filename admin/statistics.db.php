<?php
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error($conn));
    exit();
}

    $sql="select month(s.sales_day) as 'month', sum(p.price) as 'm_sales' from sales s";
    $sql.="inner join program p on s.o_key = p.o_key ";
    $sql.="group by month order by month";

    // execute query to effect changes in the database ...
    $result = mysqli_query($conn, $sql);

    for($i=0; $program=mysqli_fetch_array($result); $i++){
      $array[] = array("month" => $program[0] , "sales" => $program[1]);
    }

    echo json_encode($array);
