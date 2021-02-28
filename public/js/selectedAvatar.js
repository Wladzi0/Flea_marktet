$(document).ready(function () 	{
    $('#account_data_avatar').change(function(){
        imagePreview(this);

    });
    function imagePreview(input){

        if(input.files.length && input.files[0]){

            for (let i=0; i<input.files.length; i++){


                let reader = new FileReader();

                reader.onload=function(e){

                    $('#selectedAvatar').after('<img style="margin-right:20px; margin-bottom: 10px;margin-top: 30px;" src="'+e.target.result+'"width="250px;" height="250px;">');
                };
                reader.readAsDataURL(input.files[i]);
            }
        }}
});
