<?php
function create_table($conn, $table_name){
  $flag="NO";
  $sql = "show tables from helf";
  $result=mysqli_query($conn,$sql) or die('Error: '.mysqli_error($conn));

  while ($row=mysqli_fetch_row($result)) {
    if($row[0] === "$table_name"){//문자열로 넘어오므로 ""으로 처리 ''은 문자열뿐아니라 속성도 반영
      //ansisung 스키마에 찾는 테이블이 있는 경우
      $flag="OK";
      break;
    }
  }//end of while

  if($flag==="NO"){
    switch($table_name){
          case 'members' :
            $sql = "create table members(
              id char(20) not null,
              password char(15) not null,
              name char(10) not null,
              phone char(13) not null,
              email char(40) not null,
              address char(50),
              grade char(10) not null default 'user',
              primary key(id)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
          case 'pick' :
            $sql = "CREATE TABLE pick(
              num int not null auto_increment,
               id char(20) not null,
               o_key int not null,
               primary key (num),

              constraint pick_members_id FOREIGN KEY (id) REFERENCES members(id) on delete cascade on update cascade,
               constraint pick_program_o_key FOREIGN KEY (o_key) REFERENCES program(o_key) on delete cascade on update cascade
         )ENGINE=InnoDB DEFAULT CHARSET=utf8;
         ";
            break;
            case 'cart' :
              $sql = "CREATE TABLE cart(
                num int not null auto_increment,
                 id char(20) not null,
                 o_key int not null,
                 primary key (num),

                constraint cart_members_id FOREIGN KEY (id) REFERENCES members(id) on delete cascade on update cascade,
                 constraint cart_program_o_key FOREIGN KEY (o_key) REFERENCES program(o_key) on delete cascade on update cascade
           )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
              break;

          case 'message' :
            $sql = "create table message (
              num int not null auto_increment,
              send_id char(20) not null,
              rv_id char(20) not null,
              subject char(200) not null,
              content text not null,
              regist_day char(20),
              read_mark char(2),
              primary key(num)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
          case 'program' :
            $sql = "create table program (
              o_key int not null auto_increment,
              shop char(10) not null,
              type char(20) not null,
              subject varchar(50) not null,
              content text not null,
              phone_number char(17) not null,
              end_day char(20) not null,
              choose char(20) not null,
              price int not null,
              location char(50) not null,
              file_name char(100),
              file_type char(100),
              file_copied char(200),
              regist_day char(15),
              primary key(o_key)
          )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
          case 'p_review' :
            $sql = "create table p_review(
              num int not null auto_increment,
              id char(20) not null,
              o_key int(11) not null,
              content text,
              regist_day char(30) not null,
              type char(20) not null,
              shop char(10) not null,
              score float not null,
              primary key(num),
             constraint review_members_id FOREIGN KEY (id) REFERENCES members(id) on delete cascade on update cascade,
              constraint review_program_o_key FOREIGN KEY (o_key) REFERENCES program(o_key) on delete cascade on update cascade
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
          case 'p_qna' :
            $sql = "create table p_qna(
              num int not null auto_increment,
              group_num int not null,
              depth int not null,
              ord int not null,
               id char(20) not null,
               o_key int not null,
               shop char(20) not null,
               type char(20) not null,
               subject char(200) not null,
               content text not null,
               regist_day char(20),
               primary key(num),
               constraint qna_members_id FOREIGN KEY (id) REFERENCES members(id) on delete cascade on update cascade,
               constraint qna_program_o_key FOREIGN KEY (o_key) REFERENCES program(o_key) on delete cascade on update cascade
           )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
            case 'notice' :
              $sql = "create table notice(
                num int not null auto_increment,
                subject char(200) not null,
                content text not null,
                regist_day char(20) not null,
                hit int not null,
                file_name char(40),
                file_type char(40),
                file_copied char(40),
                primary key(num)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
              break;
              case 'faq' :
                $sql = "create table faq(
                  num int not null auto_increment,
                  subject text not null,
                  content text not null,
                  primary key(num)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                break;
          case 'community' :
            $sql = "create table community (
              num int not null auto_increment,
              id char(15) not null,
              name char(10) not null,
              subject char(200) not null,
              content text not null,
              regist_day char(20) not null,
              hit int not null,
              file_name char(100),
              file_type char(100),
              file_copied char(200),
              likeit int not null,
              b_code char(15) NOT NULL,
              primary key(num)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
          case 'comment' :
            $sql = "create table comment (
              num int not null auto_increment,
              parent int not null,
              id char(15) not null,
              name char(10) not null,
              content text not null,
              regist_day char(20) not null,
              b_code char(15) not null,
              primary key(num)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
          case 'health_info' :
            $sql = "create table health_info(
              num int not null auto_increment,
              id char(15) not null,
              name char(10) not null,
              subject char(200) not null,
              content text not null,
              regist_day char(20) not null,
              hit int not null,
              file_name char(100),
              file_type char(100),
              file_copied char(200),
              likeit int not null,
              b_code char(15) not null,
              video_name char(200),
              primary key(num)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
          case 'together' :
            $sql = "create table together(
              num int not null auto_increment,
              id char(15) not null,
              name char(10) not null,
              area char(10) not null,
              subject char(200) not null,
              content text not null,
              regist_day char(20) not null,
              hit int not null,
              file_name char(100),
              file_type char(100),
              file_copied char(200),
              likeit int not null,
              b_code char(15) not null,
              group_num int UNSIGNED NOT NULL,
              depth int UNSIGNED NOT NULL,
              ord int UNSIGNED NOT NULL,
              primary key(num)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
          case 'carecenter' :
            $sql = "create table carecenter(
              city char(20) not null,
               area char(20) not null,
               area_health char(40) not null,
               type char(10) not null,
               name char(20) not null,
               address char(200) not null,
               tel char(20) not null,
              primary key(address)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
            case 'rating_health_info' :
            $sql = "CREATE TABLE `rating_health_info` (
              `num` int not null primary key auto_increment,
              `user_id` char(20) NOT NULL,
              `post_id` int(11) NOT NULL,
              `b_code` char(20) not null,
              `rating_action` varchar(30) NOT NULL,
               CONSTRAINT UC_rating_info UNIQUE (user_id, post_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
            case 'rating_together_info' :
              $sql = "CREATE TABLE `rating_together_info` (
                `num` int not null primary key auto_increment,
                `user_id` char(20) NOT NULL,
                `post_id` int(11) NOT NULL,
                `b_code` char(20) not null,
                `rating_action` varchar(30) NOT NULL,
                 CONSTRAINT UC_rating_info UNIQUE (user_id, post_id)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
              ";
              break;
              case 'rating_community_info' :
                $sql = "CREATE TABLE `rating_community_info` (
                  `num` int not null primary key auto_increment,
                  `user_id` char(20) NOT NULL,
                  `post_id` int(11) NOT NULL,
                  `b_code` char(20) not null,
                  `rating_action` varchar(30) NOT NULL,
                   CONSTRAINT UC_rating_info UNIQUE (user_id, post_id)
                   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                ";
                break;
            case 'sales' :
              $sql = "CREATE TABLE sales(
                num int not null auto_increment,
                ord_num char(25) not null,
                id char(20) not null,
                o_key int not null,
                total_price int not null,
                sales_day char(20) not null,
                complete char(10) not null,
                payment char(50) not null,
                primary key (num),

               constraint sales_members_id FOREIGN KEY (id) REFERENCES members(id) on delete cascade on update cascade,
                constraint sales_program_o_key FOREIGN KEY (o_key) REFERENCES program(o_key) on delete cascade on update cascade
          )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
              break;
              case 'deleted_members' :
                $sql = "CREATE TABLE `deleted_members` (
                id char(20),
                password char(15),
                name char(10),
                phone char(13),
                email char(40),
                address char(50),
                grade char(10),
                `deleted_date` date
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
              break;
      default:
        echo "<script>alert('해당 테이블 이름이 없습니다. ');</script>";
        break;
    }//end of switch

    if(mysqli_query($conn,$sql)){
      echo "<script>alert('$table_name 테이블이 생성되었습니다.');</script>";
    }else{
      echo "table 생성 실패원인: ".mysqli_error($conn);
    }
  }//end of if flag

}//end of function

?>
