<?php
  $page = $_GET["page"];
 ?>

 <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>HELF :: 아이디 / 비밀번호 찾기</title>
  <link rel="stylesheet" href="./css/forgot_id_pw.css">
  <script src="http://code.jquery.com/jquery-1.12.4.min.js" charset="utf-8"></script>
  <script>
    $(document).ready(function () {

      $("#find_id_name").keydown(function(key) {
        if(key.keyCode == 13) {
          $("#find_id_button").click();
        }
      });
      $("#find_id_email").keydown(function(key) {
        if(key.keyCode == 13) {
          $("#find_id_button").click();
        }
      });

      var find_id_name = $("#find_id_name"),
       find_id_email = $("#find_id_email"),
       find_password_id = $("#find_password_id"),
       phone_one = $("#phone_one"),
       phone_two = $("#phone_two"),
       phone_three = $("#phone_three");

      var exp = /^[0-9]{3,4}$/;

      var phone_code = "";

      $("#find_id_button").click(function() {
        var name_value = find_id_name.val();
        var email_value = find_id_email.val();

        if(name_value === "" || email_value === "") {
          alert("입력하지 않은 사항이 있습니다. 다시 확인해주세요!");
        } else {
          $.ajax({
              url: './forgot_id_pw_check.php',
              type: 'POST',
              data: {
                "find_type": "id",
                "find_id_name": name_value,
                "find_id_email": email_value
              },
              success: function(data) {
                console.log(data);
                if (data === "fail") {
                  alert("입력하신 정보에 일치하는 아이디가 없습니다.");
                } else {
                  alert("아이디는 " + data + " 입니다.");
                }
              }
            })
            .done(function() {
              console.log("done");
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
        }
      });

      $("#find_password_id").keydown(function(key) {
        if(key.keyCode == 13) {
          $("#find_password_button").click();
        }
      });
      $("#phone_one").keydown(function(key) {
        if(key.keyCode == 13) {
          $("#find_password_button").click();
        }
      });
      $("#phone_two").keydown(function(key) {
        if(key.keyCode == 13) {
          $("#find_password_button").click();
        }
      });
      $("#phone_three").keydown(function(key) {
        if(key.keyCode == 13) {
          $("#find_password_button").click();
        }
      });

      $("#find_password_button").click(function() {
          var id_value = find_password_id.val();
          var phone_one_value = phone_one.val();
          var phone_two_value = phone_two.val();
          var phone_three_value = phone_three.val();
        if(phone_one_value === "" || phone_two_value === "" || phone_two_value === "") {
          alert("입력하지 않은 사항이 있습니다. 다시 확인해주세요!");
        }  else if ( !exp.test(phone_two_value) || !exp.test(phone_three_value)) {
          alert("번호는 3~4자의 숫자만 사용 할 수 있습니다.");
        } else {
          $.ajax({
            url: "../member/phone_certification.php",
            type: 'POST',
            data: {
              "mode": "send",
              "phone_one": phone_one_value,
              "phone_two": phone_two_value,
              "phone_three": phone_three_value
            },
            success: function(data) {
                phone_code=data;
               if (data === "발송 실패") {
                alert("문자 전송 실패되었습니다.");
                phone_code_pass = false;
                isAllPass();
                } else {
                alert("문자가 전송 되었습니다.");
                }
              }
            })
            .done(function() {
              console.log("done");
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
          }
      });

      $("#password_certification").keydown(function(key) {
        if(key.keyCode == 13) {
            $("#password_certification_button").click();
        }
      });

      $("#password_certification_button").click(function () {
          var id_value = find_password_id.val();
          var phone_one_value = phone_one.val();
          var phone_two_value = phone_two.val();
          var phone_three_value = phone_three.val();

        if($("#password_certification").val() === "") {
          alert("인증번호를 입력해주세요!")
        } else if($("#password_certification").val() === phone_code) {
          alert("인증에 성공하였습니다!");
          $.ajax({
              url: './forgot_id_pw_check.php',
              type: 'POST',
              data: {
                "find_type": "password",
                "find_password_id": id_value,
                "phone_one": phone_one_value,
                "phone_two": phone_two_value,
                "phone_three": phone_three_value,
              },
              success: function(data) {
                console.log(data);
                if (data === "fail") {
                  alert("입력하신 정보에 일치하는 비밀번호가 없습니다.");
                } else {
                  alert("비밀번호는 " + data + " 입니다.");
                }
              }
            })
            .done(function() {
              console.log("done");
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
        } else if ($("#password_certification").val() !== phone_code){
          alert("인증에 실패하였습니다!")
        } else {
          alert("문자 인증 오류입니다!")
        }
      });

    });
  </script>

</head>
  <body>
    <section>
      <div id="forgot_main_content">
        <div id="title_forgot">
          <h1>아이디 / 비밀번호 찾기</h1>
        </div>
        <div id="forgot_form">
          <form name="forgot_form" action="forgot_id_pw.php" method="post">
            <?php
              if ($page === "id") {
                  ?>
              <p>아이디를 잊어버리셨나요?</p>
              <p>이름과 이메일을 입력해주세요</p>
              <p class="point_p">가입하실때 입력하셨던 정보여야 합니다!</p>
              <input type="text" id="find_id_name" name="find_id_name" placeholder=" 이름 입력 "> <br>
              <input type="text" id="find_id_email"  name="find_id_email" placeholder=" 이메일 입력"> <br>
              <input id="find_id_button" type="button" value="아이디 찾기">
            <?php
              } elseif ($page === "password") {
                  ?>
             <p>비밀번호를 잊어버리셨나요?</p>
             <p>아이디와 휴대폰번호를 입력해주세요</p>
             <p class="point_p">가입하실때 입력하셨던 정보여야 합니다!</p>
             <input type="text" id="find_password_id" name="find_password_id" placeholder=" 아이디 입력 "> <br>
             <div id="phone_input">
               <select name="phone_one" id="phone_one">
                 <option value="010" selected> 010 </option>
                 <option value="011" > 011 </option>
               </select> -
               <input type="number" name="phone_two" id="phone_two" placeholder=" 0000 "> -
               <input type="number" name="phone_three" id="phone_three" placeholder=" 0000 ">
             </div>
             <input id="find_password_button" type="button" name="" value=" 인증번호 발송 "> <br>
             <input type="text" id="password_certification" name="password_certification" placeholder=" 인증번호 입력 "> <br>
             <input id="password_certification_button" type="button" name="" value="확인"> <br>
             <?php
              } else {
                  alert("아이디 / 비밀번호 찾기 페이지 오류입니다.");
              }
              ?>

          </form>
        </div>
      </div>
    </section>
  </body>
</html>
