$(function(){
    
  //이미지 총 갯수
  var itemLength = $(".slider li").length;
  var imgPos = 1;

  //페이지네이션에 이미지 갯수만큼 동그라미 요소 추가
  for(var i = 1; i<=itemLength; i++){
    $(".pagination").append('<li><span class="fas fa-circle"></span></li>');
  }

  //오토슬라이더 전역변수선언
  var autoSlider;

  //이미지 가로, 세로
  var imgW, imgH;
  ////////////////////////////////////////////////////////////////////////////

  //모든 이미지 리스트를 숨김
  $(".slider li").hide();
  //첫번째 이미지 요소만 보여줌
  $(".slider li:first").show();
  //페이지네이션 첫번째 요소 색상 입히기
  $(".pagination li:first").css({"color": "#f23005"});

  //이벤트 설정
  $(".pagination li").click(pagination);
  $(".next").click(nextSlider);
  $(".prev").click(prevSlider);

  $(".slider li, .next, .prev").mouseenter(function(){autoSliderStop();});
  $(".slider li, .next, .prev").mouseleave(function(){autoSliderStart();});
  autoSliderStart();

//   $(window).resize(function(){
//     sliderImgResize();
// });

  //이벤트 정의
  function pagination(){
    //클릭한 페이지네이션 요소의 인덱스값을 저장(첫페이지를 1로 하기 위해 1을 더함)
    var paginatonPos = $(this).index()+1;

    //모든 이미지를 숨기고, 클릭한 페이지의 인덱스 값으로 선택된 이미지만 보여줌.
    $(".slider li").hide();
    $(".slider li:nth-child("+paginatonPos+")").fadeIn();

    $(".pagination li").css({"color": "#ffffff"});
    $(this).css({"color": "#f23005"});

  }

  function nextSlider(){
    if(imgPos >= itemLength){
      imgPos = 1;
    }else{
      imgPos++;
    }

    $(".pagination li").css({"color": "#ffffff"});
    $(".pagination li:nth-child("+imgPos+")").css({"color": "#f23005"});

    $(".slider li").hide();
    $(".slider li:nth-child("+imgPos+")").fadeIn();
  }

  function prevSlider(){
    if(imgPos <= 1){
      imgPos = itemLength;
    }else{
      imgPos--;
    }

    $(".pagination li").css({"color": "#ffffff"});
    $(".pagination li:nth-child("+imgPos+")").css({"color": "#f23005"});

    $(".slider li").hide();
    $(".slider li:nth-child("+imgPos+")").fadeIn();
  }

  function autoSliderStart(){
    autoSlider = setInterval(function(){nextSlider();},3000);
  }

  function autoSliderStop(){
    clearInterval(autoSlider);
  }

  function sliderImgResize(){
    imgW = $(".slider li img").width();
    imgH = $(".slider li img").height();

    $(".slider .caption").height(imgH);
  }

});
