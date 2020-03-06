<?php 
 include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";

if(isset($_POST["keyword"])){
    $keyword = $_POST["keyword"];
    $sql = "select id from members where id like '%$keyword%' limit 10;";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)){
        $id = $row['id'];
        echo "<li class='id_lists' onclick='set_item(\"$id\")'>".$id."</li>";
    }
  }

?>