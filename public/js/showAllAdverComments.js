$(document).ready(function(){
    let advertisement=$('#advertisementID').val();
    let displayComment=$("#displayComment").html('');
        $.ajax({
            url:'/advertisement/'+advertisement+'/comment',
            method:'POST',
            async: true,
            success:function(data){
                let result= JSON.parse(data);
                $.each(result,function(key,arr){
                    $.each(arr,function(id,data){
                        displayComment.append('<div class="fieldComment"><h3><b> '+data[0]+'</b></h3><small>'+data[1]+'</small> <p>'+data[2]+'</p></div>');


                    });
                });

            }
        });
    $('#submit').click(function() {
        let formData = $("#commentContent").val();

        if(formData===''){
            formData.val('');
        }
        else {
            $.ajax({
                url:'/advertisement/'+advertisement+'/comment',
                method:'POST',
                data: {
                    'comment':formData
                },
                async: true,
                success:function(data){

                    document.getElementById('commentContent').value="";

                    let result= JSON.parse(data);

                    $.each(result,function(key,arr){
                        $.each(arr,function(id,data){
                            displayComment.append('<div class="fieldComment"><h3><b> '+data[0]+'</b></h3><small>'+data[1]+'</small> <p>'+data[2]+'</p></div>');
                        });
                    });

                }
            });

        }

    });
});