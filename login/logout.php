<?php
  session_start();
  unset($_SESSION["user_id"]);
  unset($_SESSION["user_name"]);
  unset($_SESSION["user_grade"]);


  echo("
       <script>
          alert('로그아웃 되었습니다!');
          location.href = '../index.php';
          </script>
       ");
?>
