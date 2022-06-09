// Img display when adding uploaded img
$(document).ready(function(){
      $('#image').change(function(){
            $("#frames").html('');
            for (var i = 0; i < $(this)[0].files.length; i++) {
                  $("#frames").append('<img src="'+window.URL.createObjectURL(this.files[i])+'"/>');
            }
      });
});