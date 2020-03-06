<meta charset="utf-8">
<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/helf//common/lib/db_connector.php";

  if (isset($_GET["mode"])) $mode = $_GET["mode"];
  else $mode = "";


//게시글 삭제
  function board_delete($conn)
  {
    for($i=0; $i<count($_POST["item"]); $i++){
        $num = $_POST["item"][$i];

        $sql = "select * from community where num = $num";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        $copied_name = $row["file_copied"];

        if ($copied_name)
        {
            $file_path = "./data/".$copied_name;
            unlink($file_path);
        }

        $sql = "delete from community where num = $num";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }
  }


  switch ($mode) {
    case 'delete':
      board_delete($conn);
      echo "
         <script>
             location.href = 'admin_board.php';
         </script>
       ";
      break;

    default:
      break;
  }
?>
