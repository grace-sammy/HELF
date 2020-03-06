$(document).ready(function() {
    $.ajax({
      url:'../statistics_db.php',
      // type:'POST',
      // data:,
      success:function(data){
        var data = JSON.parse(data);
        console.log(data[0].month+","+data[0].sales);

        for(var i = 0; i<5; i++){
          var html = `<li class="li_program_list">`;
          html += `<div class="div_list" style="background:`+back_color[i]+`"><div class="pro1"><div class="main_image"><img src='../admin/data/`+data[i].file_copied+`' class='image_vertical'></div></div>`;
          html += `<div class="pro2"><div class="abc"><div class="info_1">`+data[i].shop+" | "+data[i].type+" | "+data[i].location+`</div>`;
          html += `<div class="info_2">`+data[i].subject+`</div>`;
          html += `<div class="info_3"">모집기간: `+data[i].end_day+` 까지</div></div></div>`;
          html += `<div class="pro3"><em><strong>`+data[i].price+`</strong> 원</em></div></div></li>`;

          $("#board_list").append(html);

        }



      },
      error:function(){
        alert("error")
      }
    });


    });
});
