var id_pass = false,
 pw_pass = false,
 pw_check_pass = false,
 name_pass = false,
 phone_two_pass = false,
 phone_three_pass = false,
 email_one_pass = false,
 email_two_pass = false,
 address_one_pass = false,
 address_three_pass = false,
 phone_code_pass = false,
 email_code_pass = false,

 tou_one_pass = false,
 tou_two_pass = false;

var phone_code="";
var email_code="";


$(document).ready(function() {
  var input_id = $("#input_id"),
    input_password = $("#input_password"),
    input_password_check = $("#input_password_check"),
    input_name = $("#input_name"),

    phone_two = $("#phone_two"),
    phone_three = $("#phone_three"),
    email_one = $("#email_one"),
    email_two = $("#email_two"),
    input_email_certification = $("#input_email_certification"),
    address_one = $("#address_one"),
    address_three = $("#address_three"),

    input_id_confirm = $("#input_id_confirm");
    input_password_confirm = $("#input_password_confirm");
    input_id_confinput_password_check_confirmirm = $("#input_password_check_confirm");
    input_name_confirm = $("#input_name_confirm");
    input_phone_confirm = $("#input_phone_confirm");
    input_email_confirm = $("#input_email_confirm");
    input_email_certification_confirm = $("#input_email_certification_confirm");
    input_address_confirm = $("#input_address_confirm");

  // 정보수정이거나 회원가입이거나 판별
  if(input_id.attr("readonly")) {
    input_id_confirm.html("<span style='color:green'>아이디는 변경할 수 없습니다.</span>");
    // 수정하지 않는 정보가 있을 수 있기때문에 일단 처음에 다 true를 주고 수정하는 칸이 블러되면 다시 거기서
    // false인지 true인지 판별.
    id_pass = true;
    pw_pass = true;
    pw_check_pass = true;
    name_pass = true;
    phone_two_pass = true;
    phone_three_pass = true;
    email_one_pass = true;
    email_two_pass = true;
    address_one_pass = true;
    address_three_pass = true;
    phone_code_pass = true;
    email_code_pass = true;
    tou_one_pass = true;
    tou_two_pass = true;
    isAllPass();
  } else {
    input_id.blur(function() {

      if(input_name.attr("readonly")) {
        name_pass = true;
        email_one_pass = true;
        email_two_pass = true;
        isAllPass();
      }

      var id_value = input_id.val();
      var exp = /^[a-z0-9]{5,20}$/;
      if (id_value === "") {
        input_id_confirm.html("<span style='color:red'>아이디를 입력해주세요.</span>");
        id_pass = false;
        isAllPass();
      } else if (!exp.test(id_value)) {
        input_id_confirm.html("<span style='color:red'>아이디는 5~20자의 영문 소문자와 숫자만 사용할 수 있습니다.</span>");
        id_pass = false;
        isAllPass();
      } else {
        $.ajax({
            url: './member_form_check.php',
            type: 'POST',
            data: {
              "input_id": id_value
            },
            success: function(data) {
              console.log(data);
              if (data === "1") {
                input_id_confirm.html("<span style='color:red'>이미 사용중인 아이디입니다. 다른 아이디를 입력해주세요.</span>");
                id_pass = false;
                isAllPass();
              } else if (data === "0") {
                input_id_confirm.html("<span style='color:green'>사용 가능한 아이디입니다.</span>");
                id_pass = true;
                isAllPass();
              } else {
                input_id_confirm.html("<span style='color:red'>오류입니다. 다시 확인해주세요.</span>");
                id_pass = false;
                isAllPass();
              }
            }
          })
          .done(function() {
            console.log("success");
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
      }
    }); //input_id.blur end
  }

  input_password.blur(function() {
    var password_value = input_password.val();
    var exp = /^[a-z0-9]{5,20}$/;
    if (password_value === "") {
      input_password_confirm.html("<span style='color:red'>비밀번호를 입력해주세요.</span>");
      pw_pass = false;
      isAllPass();
    } else if (!exp.test(password_value)) {
      input_password_confirm.html("<span style='color:red'>비밀번호는 5~20자의 영문 소문자와 숫자만 사용할 수 있습니다.</span>");
      pw_pass = false;
      isAllPass();
    } else {
      input_password_confirm.html("<span style='color:green'>사용 가능한 비밀번호입니다.</span>");
      pw_pass = true;
      isAllPass();
    }
  }); //input_password.blur end

  input_password_check.blur(function() {
    var password_value = input_password.val();
    var password_check_value = input_password_check.val();
    if (password_check_value === "") {
      input_id_confinput_password_check_confirmirm.html("<span style='color:red'>비밀번호를 재입력해주세요.</span>");
      pw_check_pass = false;
      isAllPass();
    } else if (password_check_value !== password_value) {
      input_id_confinput_password_check_confirmirm.html("<span style='color:red'>비밀번호가 일치하지 않습니다.</span>");
      pw_check_pass = false;
      isAllPass();
    } else {
      input_id_confinput_password_check_confirmirm.html("<span style='color:green'>비밀번호와 일치합니다.</span>");
      pw_check_pass = true;
      isAllPass();
    }
  }); //input_password_check.blur end

  input_name.blur(function() {
    var name_value = input_name.val();
    var exp = /^[a-zA-Z가-힣]{2,10}$/;
    if (name_value === "") {
      input_name_confirm.html("<span style='color:red'>이름을 입력해주세요.</span>");
      name_pass = false;
      isAllPass();
    } else if (!exp.test(name_value)) {
      input_name_confirm.html("<span style='color:red'>이름은 2자 이상의 한글과 영문대소문자만 사용 할 수 있습니다.</span>");
      name_pass = false;
      isAllPass();
    } else {
      input_name_confirm.html("");
      name_pass = true;
      isAllPass();
    }
  }); //input_name.blur end

  phone_two.keyup(function() {
    var phone_two_value = phone_two.val();
    var exp = /^[0-9]{3,4}$/;
    if (phone_two_value === "") {
      input_phone_confirm.html("<span style='color:red'>번호를 입력해주세요.</span>");
      phone_two_pass = false;
      isAllPass();
    } else if (!exp.test(phone_two_value)) {
      input_phone_confirm.html("<span style='color:red'>번호는 3~4자의 숫자만 사용 할 수 있습니다.</span>");
      phone_two_pass = false;
      isAllPass();
    } else {
      input_phone_confirm.html("");
      phone_two_pass = true;
      isAllPass();
    }
  }); //phone_two.blur end

  phone_three.keyup(function() {
    var phone_three_value = phone_three.val();
    var exp = /^[0-9]{3,4}$/;
    if (phone_three_value === "") {
      input_phone_confirm.html("<span style='color:red'>번호를 입력해주세요.</span>");
      phone_three_pass = false;
      isAllPass();
    } else if (!exp.test(phone_three_value)) {
      input_phone_confirm.html("<span style='color:red'>번호는 3~4자의 숫자만 사용 할 수 있습니다.</span>");
      phone_three_pass = false;
      isAllPass();
    } else {
      input_phone_confirm.html("");
      phone_three_pass = true;
      isAllPass();
    }
  }); //phone_three.blur end

  email_one.blur(function() {
    var email_one_value = email_one.val();
    var exp = /^[a-z0-9]{2,20}$/;
    if (email_one_value === "") {
      input_email_confirm.html("<span style='color:red'>이메일을 입력해주세요.</span>");
      email_one_pass = false;
      isAllPass();
    } else if (!exp.test(email_one_value)) {
      input_email_confirm.html("<span style='color:red'>이메일은 2자 이상의 영문소문자와 숫자만 사용 할 수 있습니다.</span>");
      email_one_pass = false;
      isAllPass();
    } else {
      input_email_confirm.html("<span style='color:green'></span>");
      email_one_pass = true;
      isAllPass();
    }
  }); //email_one.blur end

  email_two.blur(function() {
    var email_two_value = email_two.val();
    if (email_two_value === "") {
      input_email_confirm.html("<span style='color:red'>이메일 주소를 선택해주세요.</span>");
      email_two_pass = false;
      isAllPass();
    } else if (email_two_value !== "") {
      input_email_confirm.html("");
      email_two_pass = true;
      isAllPass();
    }
  }); //email_two.blur end

  address_one.blur(function() {
    var address_one_value = address_one.val();
    if (address_one_value === "") {
      input_address_confirm.html("<span style='color:red'>우편번호를 입력해주세요.</span>");
      address_one_pass = false;
      isAllPass();
    } else if (address_one_value !== "") {
      input_address_confirm.html("");
      address_one_pass = true;
      isAllPass();
    }
  }); //address_one.blur end


  address_three.blur(function() {
    var address_three_value = address_three.val();
    var exp = /^[a-zA-Z가-힣0-9-\s]{1,30}$/;
    if (address_three_value === "") {
      input_address_confirm.html("<span style='color:red'>상세주소를 입력해주세요.</span>");
      address_three_pass = false;
      isAllPass();
    } else if (!exp.test(address_three_value)) {
      input_address_confirm.html("<span style='color:red'>주소는 영문대소문자와 한글과 숫자와 - 기호만 사용 할 수 있습니다.</span>");
      address_three_pass = false;
      isAllPass();
    } else {
      input_address_confirm.html("");
      address_three_pass = true;
      isAllPass();
    }
  }); //address_three.blur end

  $("#phone_check").click(function() {
    var phone_one_value =  $("#phone_one").val();
    var phone_two_value = $("#phone_two").val();
    var phone_three_value = $("#phone_three").val();
    if(phone_one_value !=="" && phone_two_pass && phone_three_pass) {
      $.ajax({
          url: "./phone_certification.php",
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
    } else {
      alert("휴대폰 번호가 제대로 입력되지 않았습니다!");
    }
  });

  $("#input_phone_certification_check").click(function () {
    if($("#input_phone_certification").val() === "") {
      $("#input_phone_confirm").html("<span style='color:red'>인증번호를 입력해주세요.</span>");
      phone_code_pass = false;
      isAllPass();
    } else if($("#input_phone_certification").val() === phone_code) {
      $("#input_phone_confirm").html("<span style='color:green'>인증에 성공하였습니다.</span>");
      phone_code_pass = true;
      isAllPass();
    } else if ($("#input_phone_certification").val() !== phone_code){
        $("#input_phone_confirm").html("<span style='color:red'>인증에 실패하였습니다.</span>");
        phone_code_pass = false;
        isAllPass();
    } else {
      alert("문자 인증 오류입니다!")
    }
  });

  $("#email_check").click(function() {
    var email_one_value =  $("#email_one").val();
    var email_two_value = $("#email_two").val();
    if(email_one_value !== "" && email_two_value !== "") {
      $.ajax({
          url: "./PHPMailer/PHPMailer/phpmail_test.php",
          type: 'POST',
          data: {
            "email_one": email_one_value,
            "email_two": email_two_value
          },
          success: function(data) {
            email_code=data;
             if (data === "fail") {
              alert("이메일이 전송 실패되었습니다.");
              email_code_pass = false;
              isAllPass();
              } else {
              alert("이메일이 전송 되었습니다.");
            }
          }
        })
    } else {
      alert("이메일 주소가 제대로 입력되지 않았습니다!");
    }
  });

  $("#input_email_certification_check").click(function () {
    if($("#input_email_certification").val() === "") {
        $("#input_email_certification_confirm").html("<span style='color:red'>이메일 인증번호를 입력해주세요.</span>");
        email_code_pass = false;
        isAllPass();
    } else if($("#input_email_certification").val() === email_code) {
        $("#input_email_certification_confirm").html("<span style='color:green'>이메일 인증에 성공하였습니다.</span>");
        email_code_pass = true;
        isAllPass();
    } else if ($("#input_email_certification").val() !== email_code){
        $("#input_email_certification_confirm").html("<span style='color:red'>이메일 인증에 실패하였습니다.</span>");
        email_code_pass = false;
        isAllPass();
    } else {
      alert("이메일 인증 오류입니다!")
    }
  });
  // 전체 선택 체크박스
  $("#all_agree").click(function() {
    if($("#all_agree").prop("checked")) {
      $("input[type=checkbox]").prop("checked",true);
      tou_one_pass = true;
      tou_two_pass = true;
      isAllPass();
    } else {
       $("input[type=checkbox]").prop("checked",false);
       tou_one_pass = false;
       tou_two_pass = false;
       isAllPass();
    }
  });

  $("#tou_one").click(function() {
    if($("#tou_one").prop("checked")) {
      $("#tou_one").prop("checked",true);
      tou_one_pass = true;
      isAllPass();
    } else {
       $("#tou_one").prop("checked",false);
       tou_one_pass = false;
       isAllPass();
    }
    alert(tou_one_pass);
    alert(tou_two_pass);
  });

  $("#tou_two").click(function() {
    if($("#tou_two").prop("checked")) {
      $("#tou_two").prop("checked",true);
      tou_two_pass = true;
      isAllPass();
    } else {
       $("#tou_two").prop("checked",false);
       tou_two_pass = false;
       isAllPass();
    }
  });

  function isAllPass() {
    if (id_pass && pw_pass && pw_check_pass && name_pass && phone_two_pass && phone_three_pass &&
      email_one_pass && email_two_pass && address_one_pass && address_three_pass &&
      phone_code_pass && email_code_pass && tou_one_pass && tou_two_pass) {
      $("#button_submit").attr("disabled", false);
    } else {
      $("#button_submit").attr("disabled", true);
    }
  }

}); //document ready end
