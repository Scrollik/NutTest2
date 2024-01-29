$(function() {
    $('#name_artist').change(function(){
        var value = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '/artistfindapi',
            method: "GET",
            data:{value:value, _token:_token},
            success:function(data){
                $('#image').val(data.image);
                $('#image-preview').attr('src', data.image);
            }
        });
    })
});
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