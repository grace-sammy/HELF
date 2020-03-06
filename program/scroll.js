$(document).ready(function() {
    var count=5;

    $("#btn_search").click(function(){

     document.temp.aaa.value = document.frm.s_type.value;
     document.temp.bbb.value = document.frm.s_area1.value;
     document.temp.ccc.value = document.frm.s_area2.value;
     document.temp.ddd.value = document.frm.s_min_price.value;
     document.temp.eee.value = document.frm.s_max_price.value;

    });

    $(window).bind("scroll", function(){
        var documentHeight  = $(document).height();
        var scrollHeight = $(window).scrollTop()+$(window).height();

        if(scrollHeight > documentHeight*0.95) {
              $.ajax({
                url:'program_db.php',
                type:'POST',
                data:{'list':count},
                success:function(data){
                  var data = JSON.parse(data);
                  console.log(data[0].o_key+","+data[0].shop+","+data[0].type+","+data[0].subject+","+data[0].phone_number
                  +","+data[0].end_day+","+data[0].choose+","+data[0].price+","+data[0].location+","+data[0].file_copied+","+data[0].pick);
                  console.log(data[1].o_key+","+data[1].shop+","+data[1].type+","+data[1].subject+","+data[1].phone_number
                  +","+data[1].end_day+","+data[1].choose+","+data[1].price+","+data[1].location+","+data[1].file_copied+","+data[1].pick);
                  // console.log(data[0].shop+","+data[0].type+","+data[0].subject+","+data[0].phone_number
                  // +","+data[0].end_day+","+data[0].choose+","+data[0].price+","+data[0].location+","+data[0].file_copied);
                  // console.log(data[0].shop+","+data[0].type+","+data[0].subject+","+data[0].phone_number
                  // +","+data[0].end_day+","+data[0].choose+","+data[0].price+","+data[0].location+","+data[0].file_copied);
                  // console.log(data[0].shop+","+data[0].type+","+data[0].subject+","+data[0].phone_number
                  // +","+data[0].end_day+","+data[0].choose+","+data[0].price+","+data[0].location+","+data[0].file_copied);

                  for(var i=0; i<5; i++){

                    if(data[i].pick == null){
                      var btn = "<button type='button' id='cart_btn' onclick=\"location.href='pick_db.php?o_key="+data[i].o_key+"&shop="+data[i].shop+"';\">찜하기</button><br>";
                    }else{
                      var btn = "<button type='button' id='cart_bt' disabled>이미찜</button><br>";
                    }

                    var html = `<li><div class="program_li"><div class="program_image">`;
                    html += `<a href='../program/program_detail.php?o_key=`+data[i].o_key+`'>`;
                    html += `<img src='../admin/data/`+data[i].file_copied+`'>`;
                    html += `</a></div><div class="program_detail">`;
                    html += `<a href="../program/program_detail.php?o_key=`+data[i].o_key+`">`;
                    html += `<div class="info_1">`+data[i].shop+" | "+data[i].type+" | "+data[i].location+`</div>`;
                    html += `<div class="info_2">`+data[i].subject+`</div>`;
                    html += `<div class="info_3">모집기간 : `+data[i].end_day+` 까지</div></a></div>`;
                    html += `<div class="program_price"><p>`+data[i].price+`<span> 원~</span>`;
                    html += `<div class="buttons">`;
                    html += btn;
                    html += `</div></div></div></li>`;
                    $("#board_list").append(html);
                  }

                },
                error:function(){
                  alert("error")
                }
              });
              count+=5;
        }
    });


});
