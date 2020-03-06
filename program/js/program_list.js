function pick_insert(o_key){

  var mode = "insert";
  var sokey = String(o_key);
  var div = "#div_"+sokey;

  $.ajax({
    url:'pick_db.php',
    type:'get',
    data:{'mode':mode , 'o_key':o_key},
    success:function(data){
      document.getElementById(sokey).parentNode.removeChild(document.getElementById(sokey));
      var html = "<button type='button' id='"+o_key+"' class='cancel_pick' onclick=\"pick_delete('"+o_key+"')\">이미찜</button>";
      $(div).append(html);

      alert('찜했어요!');

      // document.getElementById(sokey).style.background = "lightgray";
      // document.getElementById(sokey).style.color = "black";
      // document.getElementById(sokey).style.border = "1px solid lightgray";
      // document.getElementById(sokey).style.borderRadius = "2px";
      // document.getElementById(sokey).innerHTML = "이미찜";

    },
    error:function(){
      alert("error");
    }
  });
}


function pick_delete(o_key){
  var mode = "delete";
  var sokey = String(o_key);
  var div = "#div_"+sokey;
  $.ajax({

    url:'pick_db.php',
    type:'get',
    data:{'mode':mode , 'o_key':o_key},
    success:function(data){
      document.getElementById(sokey).parentNode.removeChild(document.getElementById(sokey));
      var html = "<button type='button' id='"+o_key+"' class=btn_pick onclick=\"pick_insert('"+o_key+"');\">찜하기</button>";
      $(div).append(html);

      alert('찜 취소!');

      // document.getElementById(sokey).style.background = "#F23005";
      // document.getElementById(sokey).style.color = "white";
      // document.getElementById(sokey).style.border = "1px solid #F23005";
      // document.getElementById(sokey).style.borderRadius = "2px";
      // document.getElementById(sokey).innerHTML = "찜하기";
    },
    error:function(){
      alert("error");
    }
  });
}
