$(function (){
    $("#image-upload").change(function (){
        $("#image").val("");
        var $input = $(this),
            reader = new FileReader();
        reader.onload = function(){
            $("#image-preview").attr("src", reader.result);
        };
        reader.readAsDataURL($input[0].files[0]);
    })
});