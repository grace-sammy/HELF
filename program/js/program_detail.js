$(document).ready(function() {
    $('#reviwe_content').on('keyup', function() {
        if($(this).val().length > 120) {
          alert("글자수는 120자로 이내로 제한됩니다.");
          $(this).val($(this).val().substring(0, 120));
        }
    });
});
