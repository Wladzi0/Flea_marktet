$(document).ready(function () 	{
    // let previewImage = document.getElementById('selectedImage');
    $('#advertisement_image').change(function(){
       imagePreview(this);

    });
    function imagePreview(input){

        if(input.files.length && input.files[0]){
            for (let i=0; i<input.files.length; i++){


            let reader = new FileReader();
            reader.onload=function(e){
            $('#selectedImage').after('<img style="margin-right:20px; margin-bottom: 10px;margin-top: 30px;" src="'+e.target.result+'"width="280px;" height="280px;">');
            };
            reader.readAsDataURL(input.files[i]);
            }
        }}
});


