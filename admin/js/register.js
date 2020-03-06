$(document).ready(function() {
  var child = 2;
  var opeq = 1;

  var input_shop = $("#input_shop"); //상호명 체크
  var input_subject = $("#input_subject");  //제목 체크
  var input_content = $("#input_content");  //내용 체크
  var input_num = $("#input_num");  //전화번호 체크
  var input_end_day  =  $("#input_end_day");  //마감일 체크
  // var input_option = $(".option_choose"); //옵션체크
  // var input_price = $(".price_choose");   //가격체크


  var  input_option = $("#ul_plus li:nth-child("+opeq+") .option_choose"); //옵션체크
  var  input_price = $("#ul_plus  li:nth-child("+opeq+") .price_choose");   //가격체크



  var input_location1 = $("#input_location1");  //지역1 체크
  var input_location2 = $("#input_location2");  //지역2 체크
  var input_location3 = $("#input_location3");  //상세주소 체크
  var input_file = $("#input_file");  //이미지 체크


  var sub_shop = $("#sub_shop");
  var sub_subject = $("#sub_subject");
  var sub_content = $("#sub_content");
  var sub_num = $("#sub_num");
  var sub_end_day = $("#sub_end_day");
  var sub_option = $("#sub_option");
  var sub_location = $("#sub_location");
  var sub_file = $("#sub_file");


  var shop_pass = false,
  subject_pass = false,
  content_pass = false,
  num_pass = false,
  end_day_pass = false,
  option_pass = false,
  price_pass = false,
  location1_pass = false;
  location2_pass = false;
  location3_pass = false;
  file_pass = false;


  $(".btn_regist").click(function(){
    document.program_regist.submit();

  });

  $("#option_plus").click(function(){
    var html = `<li><input type="text" name="choose[]" class="option_choose" value="" placeholder=" 옵션명을 입력하세요. "> &
    <input type="number" name="price[]" class="price_choose" value="" placeholder=" 가격을 입력하세요. "> 원</li>`;
    $("#ul_plus").append(html);
    child++;

    $("#option_plus").attr("disabled", true);
    // $("#ul_plus li:nth-child("+opeq+") .option_choose").attr("disabled", true);
    // $("#ul_plus li:nth-child("+opeq+") .price_choose").attr("disabled", true);
    option_pass = false;
    price_pass = false;
    opeq++;

    $("#ul_plus li:nth-child("+opeq+") .option_choose").blur(function(){

    var optionValue = $("#ul_plus li:nth-child("+opeq+") .option_choose").val();
    var exp = /^[0-9a-zA-Z가-힣\s]{2,15}$/;
    if(optionValue === ""){
      sub_option.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
      option_pass = false;
    }else{
      option_pass = true;
      sub_option.html("");
      opPass();
    }
  });

    $("#ul_plus li:nth-child("+opeq+") .price_choose").blur(function(){
  var priceValue =  $("#ul_plus li:nth-child("+opeq+") .price_choose").val();
  if(priceValue === ""){
    sub_option.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
    price_pass = false;
  }else if(priceValue < 0 || priceValue > 1000000){
    sub_option.html("<span style='margin-left:5px; color:red'>가격 범위를 확인해주세요 (0~100만원)</span>");
    price_pass = false;
  }else{
    price_pass = true;
    sub_option.html("");
    opPass()
  }
});


  });

  $("#option_minus").click(function(){
    if(child != 1){
      var list = document.getElementById("ul_plus");
      list.removeChild(list.childNodes[child]);
      child--;
    }
  });

  //상호명 체크
  input_shop.blur(function(){
    var shopValue = input_shop.val();
    var exp = /^[A-Z가-힣\s]{3,12}$/;
    if(shopValue === ""){
        sub_shop.html("<span style='margin-left:5px; color:red;'>필수 정보입니다</span>");
        shop_pass = false;
      }else if(!exp.test(shopValue)){
        sub_shop.html("<span style='margin-left:5px; color:red;'>한글,영문(대문자) 3~12자 입력가능합니다</span>");
        shop_pass = false;
      }else{
        shop_pass = true;
        sub_shop.html("");
      }
  });
  //제목 체크
  input_subject.blur(function(){
    var subjectValue = input_subject.val();
    var exp = /^[a-zA-Z가-힣\s]{1,50}$/;
    if(subjectValue === ""){
        sub_subject.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
        subject_pass = false;
      }else if(!exp.test(subjectValue)){
        sub_subject.html("<span style='cmargin-left:5px; color:red'>한글,영문 최대 50자 입력 가능합니다</span>");
        subject_pass = false;
      }else{
        subject_pass = true;
        sub_subject.html("");
      }
  });
  //내용 체크
  input_content.blur(function(){
    var contentValue = input_content.val();
    if(contentValue === ""){
        sub_content.html("<span style='margin-left:5px; color:red'>내용을 입력해주세요</span>");
        content_pass = false;
      }else{
        content_pass = true;
        sub_content.html("");
      }
  });

  //전화번호 체크
  input_num.blur(function(){

    var numValue = input_num.val();
    var exp = /^\d{8,15}$/;
    if(numValue === ""){
      sub_num.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
      num_pass = false;
    }else if(!exp.test(numValue)){
      sub_num.html("<span style='margin-left:5px; color:red'>숫자만 입력해 주세요</span>");
      num_pass = false;
    }else{
      num_pass = true;
      sub_num.html("");

    }
  });

  //마감일 체크
  input_end_day.blur(function(){

    var endValue = input_end_day.val();
    if(endValue === ""){
      sub_end_day.html("<span style='margin-left:5px; color:red'>마감일을 선택해주세요</span>");
      end_day_pass = false;
    }else{
      end_day_pass = true;
      sub_num.html("");

    }
  });

  //옵션 체크

    input_option.blur(function(){

    var optionValue = input_option.val();
    var exp = /^[0-9a-zA-Z가-힣\s]{2,15}$/;
    if(optionValue === ""){
      sub_option.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
      option_pass = false;
    }else{
      option_pass = true;
      sub_option.html("");
      opPass();
    }
  });





  //가격 체크


    input_price.blur(function(){
    var priceValue =  input_price.val();
    if(priceValue === ""){
      sub_option.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
      price_pass = false;
    }else if(priceValue < 0 || priceValue > 1000000){
      sub_option.html("<span style='margin-left:5px; color:red'>가격 범위를 확인해주세요 (0~100만원)</span>");
      price_pass = false;
    }else{
      price_pass = true;
      sub_option.html("");
      opPass()
    }
  });


  //지역1 체크
  input_location1.change(function(){
  var location1Value  =  $("#input_location1 option:selected").val();
  if(location1Value == 0){
    sub_location.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
    location1_pass = false;
  }else{
    location1_pass = true;
    sub_location.html("");
  }
});

  //지역1 체크
  input_location2.change(function(){
  var location2Value   =  $("#input_location2 option:selected").val();
  if(location2Value == 0){
    sub_location.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
    location2_pass = false;
  }else{
    location2_pass = true;
    sub_location.html("");
  }
  });

  input_location3.blur(function(){
  var location3Value   =   input_location3.val();
  if(location3Value === ""){
    sub_location.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
    location3_pass = false;
  }else{
    location3_pass = true;
    sub_location.html("");
  }
  });

  input_file.change(function(){
  var fileValue   =   input_file.val();
  if(fileValue === ""){
    file_pass = false;
    sub_file.html("<span style='margin-left:5px; color:red'>필수 정보입니다</span>");
  }else{
    file_pass = true;
    sub_file.html("");
  }
  });




  function opPass() {
    console.log(option_pass+","+price_pass);
    if (option_pass && price_pass) {
      $("#option_plus").attr("disabled", false);

    } else {
      $("#option_plus").attr("disabled", true);
    }
  }


  $("#btn_regist").click(function(){

    if(!shop_pass){
      alert('상호명을 확인해주세요');
      return;
    }
    if(!subject_pass){
      alert('제목을 확인해주세요');
      return
    }
    if(!content_pass){
      alert('내용을 확인해주세요');
      return
    }
    if(!num_pass){
      alert('전화번호를 확인해주세요');
      return
    }
    if(!end_day_pass){
      alert('마감일을 확인해주세요');
      return
    }
    if(!option_pass){
      alert('옵션을 확인해주세요');
      return
    }
    if(!price_pass){
      alert('가격을 확인해주세요');
      return
    }
    if(!location1_pass){
      alert('지역(대분류)를 확인해주세요');
      return
    }
    if(!location2_pass){
      alert('지역(소분류)를 확인해주세요');
      return
    }
    if(!location3_pass){
      alert('상세지역을 확인해주세요');
      return
    }
    if(!file_pass){
      alert('이미지를 등록해주세요');
      return
    }

    document.program_regist.submit();

  });

});
