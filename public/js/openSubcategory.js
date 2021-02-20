$(document).ready(function(){
    let searchByCategory=null;
 $('.subcategory-list').mouseenter(function(){
    let category= $(this).data('value');
    let fieldSubcategories=$('#searchByCategory').html('');
    if(fieldSubcategories)
    searchByCategory= $.ajax({
        type:'GET',
        url:"/searchByCategory",
        data:{
            'searchByCategory': category
        },
        dataType:"text",
        async:true,
        success: function(msg){
        let result=JSON.parse(msg);
        $.each(result,function(key,arr){
           $.each(arr,function(id,category){
              if(key === 'subcategories'){
                  if(id!== 'error'){


                       fieldSubcategories.append('<a  href="/advertisementsInSub/'+id+'">' + category[0] +'</a>');

                  }
              }
           });
        });
        }
    });
});

});
