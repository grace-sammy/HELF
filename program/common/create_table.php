<?php
function create_table($conn, $table_name)
{
    $flag="NO";
    $sql = "show tables from health";
    $result=mysqli_query($conn, $sql) or die('Error: '.mysqli_error($conn));

    while ($row=mysqli_fetch_row($result)) {
        if ($row[0] === "$table_name") {
            $flag="OK";
            break;
        }
    }//end of while

    if ($flag==="NO") {
        switch ($table_name) {
      case 'program':
        $sql = "CREATE TABLE `program` (
        num int not null auto_increment,
        title varchar(100) not null,
        content text not null,
        recruit_num int not null,
        recruit_end char(20) not null,
        price int not null,
        w_type varchar(20) not null,
        location char(50) not null,
        file_name char(50),
        file_type char(30),
        file_copied char(30),
        primary key(num)

        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        break;
      case 'memo_ripple':
        $sql = "CREATE TABLE `memo_ripple` (
        `num` int(11) NOT NULL AUTO_INCREMENT,
        `parent` int(11) NOT NULL,
        `id` char(15) NOT NULL,
        `name` char(10) NOT NULL,
        `nick` char(10) NOT NULL,
        `content` text NOT NULL,
        `regist_day` char(20) DEFAULT NULL,
        PRIMARY KEY (`num`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        break;
      case 'member':
        $sql = "CREATE TABLE `member` (
          `id` char(15) NOT NULL,
          `pass` char(15) NOT NULL,
          `name` char(10) NOT NULL,
          `nick` char(10) NOT NULL,
          `hp` char(20) NOT NULL,
          `email` char(80) DEFAULT NULL,
          `regist_day` char(20) DEFAULT NULL,
          `level` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        break;
        case 'greet_board':
          $sql = "CREATE TABLE `greet_board` (
          `num` int(11) NOT NULL AUTO_INCREMENT,
          `id` char(15) NOT NULL,
          `subject` varchar(100) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) DEFAULT NULL,
          `hit` int(11) DEFAULT NULL,
          `is_html` char(1) DEFAULT NULL,
          PRIMARY KEY (`num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'concert_board':
          $sql = "CREATE TABLE `concert_board` (
          `num` int(11) NOT NULL AUTO_INCREMENT,
          `id` char(15) NOT NULL,
          `name` char(10) NOT NULL,
          `nick` char(10) NOT NULL,
          `subject` varchar(100) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) DEFAULT NULL,
          `hit` int(11) DEFAULT NULL,
          `is_html` char(1) DEFAULT NULL,
          `file_name_0` char(40) DEFAULT NULL,
          `file_copied_0` char(30) DEFAULT NULL,
          PRIMARY KEY (`num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
      case 'download_board':
          $sql = "CREATE TABLE `download_board` (
          `num` int(11) NOT NULL AUTO_INCREMENT,
          `id` char(15) NOT NULL,
          `name` char(10) NOT NULL,
          `nick` char(10) NOT NULL,
          `subject` varchar(100) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) DEFAULT NULL,
          `hit` int(11) DEFAULT NULL,
          `file_name_0` char(40) DEFAULT NULL,
          `file_copied_0` char(30) DEFAULT NULL,
          `file_type_0` char(30) DEFAULT NULL,
          PRIMARY KEY (`num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
         break;
      case 'free':
          $sql = "CREATE TABLE `free` (
          `num` int(11) NOT NULL AUTO_INCREMENT,
          `id` char(15) NOT NULL,
          `name` char(10) NOT NULL,
          `nick` char(10) NOT NULL,
          `subject` varchar(100) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) DEFAULT NULL,
          `hit` int(11) DEFAULT NULL,
          `is_html` char(1) DEFAULT NULL,
          `file_name_0` char(40) DEFAULT NULL,
          `file_copied_0` char(30) DEFAULT NULL,
          `file_type_0` char(30) DEFAULT NULL,
          PRIMARY KEY (`num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
     case 'free_ripple':
          $sql = "CREATE TABLE `free_ripple` (
          `num` int(11) NOT NULL AUTO_INCREMENT,
          `parent` int(11) NOT NULL,
          `id` char(15) NOT NULL,
          `name` char(10) NOT NULL,
          `nick` char(10) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) DEFAULT NULL,
          PRIMARY KEY (`num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'qna':
            $sql = "CREATE TABLE `qna` (
            `num` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `group_num` int UNSIGNED NOT NULL,
            `depth` int UNSIGNED NOT NULL,
            `ord` int UNSIGNED NOT NULL,
            `id` char(15) NOT NULL,
            `name` char(10) NOT NULL,
            `nick` char(10) NOT NULL,
            `subject` varchar(100) NOT NULL,
            `content` text NOT NULL,
            `regist_day` char(20) DEFAULT NULL,
            `hit` TINYINT UNSIGNED  DEFAULT 0,
            `is_html` char(1) DEFAULT NULL,
            PRIMARY KEY (`num`)
            )CHARSET=utf8;";
            break;
        case 'survey':
            $sql = "CREATE TABLE `survey` (
            `ans1` int UNSIGNED default 0,
            `ans2` int UNSIGNED default 0,
            `ans3` int UNSIGNED default 0,
            `ans4` int UNSIGNED default 0
            )CHARSET=utf8;";

            $sql_insert = "INSERT INTO `survey`
            (`ans1`,`ans2`,`ans3`,`ans4`) VALUES( 0, 0, 0, 0);";
            break;
      default:
      echo "<script>alert('해당 테이블이름이 없습니다. ');</script>";
      break;
    }//end of switch

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('$table_name 테이블이 생성되었습니다.');</script>";
        } else {
            echo "실패원인".mysqli_error($conn);
        }

        if (!empty($sql_insert)) {
            if (mysqli_query($conn, $sql_insert)) {
                echo "<script>alert('survey 초기값 설정이 되었습니다.');</script>";
            } else {
                echo "실패원인".mysqli_error($conn);
            }
        }
    }//end of if flag
}//end of function
