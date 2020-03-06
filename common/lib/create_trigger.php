<?php
function create_trigger($conn){
  $flag="NO";
  $sql = "SHOW TRIGGERS;";
  $result=mysqli_query($conn,$sql) or die('Error: '.mysqli_error($conn));

  if(mysqli_num_rows($result) > 0){
      $flag="OK";
  }      

    if($flag==="NO"){
        $sql="create trigger deleted_members
        after delete
        on members
        for each row
        begin
        insert into deleted_members values (old.id, old.password, old.name, old.phone, 
        old.email, old.address, old.grade, curdate());
        end";

        if(mysqli_query($conn,$sql)){
        echo "<script>alert('trigger가 생성되었습니다.');</script>";
        }else{
        echo "trigger 생성 중 실패원인".mysqli_error($conn);
        }
  }//end of if flag

}//end of function
?>