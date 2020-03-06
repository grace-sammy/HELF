function check_message(){
  if(!document.message_form.rv_id.value){
    alert('수신 아이디를 입력하세요!');
    document.message_form.rv_id.focus();
    return;
  }
  if(!document.message_form.subject.value){
    alert('제목을 입력하세요!');
    document.message_form.subject.focus();
    return;
  }
  if(!document.message_form.content.value){
    alert('내용을 입력하세요!');
    document.message_form.content.focus();
    return;
  }
  document.message_form.submit();
}

function check_back(){
  
    var con_val = confirm('페이지를 나가시겠습니까? 지금까지 작성된 내용은 저장되지 않습니다!');
if(con_val === true){
  history.go(-1);
}
else if(con_val === false){
return;
}
}

// autocomplet : this function will be executed every time we change the text
function complete_id() {
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#id_input').val();
	if (keyword.length > min_length) {
		$.ajax({
			url: './id_auto_complete.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#receive_id_list').show();
				$('#receive_id_list').html(data);
			}
		});
	} else {
		$('#receive_id_list').hide();
  }
}

function set_item(item) {
	// change input value
	$('#id_input').val(item);
	// hide proposition list
	$('#receive_id_list').hide();
}