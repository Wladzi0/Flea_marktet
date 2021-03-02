$(document).ready(function() {
    let searchRequest = null;
    let searchCity=null
    $("#search").keyup(function() {
        let minlength = 1;
        let searchString = $(this).val();
        let entitySelector = $("#searchAdvertisement_result").html('');
        if (searchString.length >= minlength) {
                searchRequest = $.ajax({
                    type: "GET",
                    url: "/search",
                    data: {
                        'search': searchString
                    },
                    dataType: "text",
                    async:true,
                    success: function(msg) {
                            let result = JSON.parse(msg);
                            $.each(result, function(key, arr) {
                                $.each(arr, function(id, searchString) {
                                    if (key === 'posts') {
                                        if (id !== 'error') {
                                            // entitySelector.append('<li ><b>' + searchString[0] +'</li>');
                                            entitySelector.append('<a   href="advertisement/'+id+'">' + searchString[0] +'</a>');
                                        }
                                        else {
                                            // entitySelector.append('<li><b> '+searchString+'</b></li>');
                                        }
                                    }
                                });
                            });

                    }
                });
        }
    });
    $("#place").keyup(function() {
        let minlength = 1;
        let searchCityString = $(this).val();
        let entitySel = $("#searchLocation_result").html('');
        if (searchCityString.length >= minlength) {
            searchCity = $.ajax({
                type: "GET",
                url: "/searchAllMatchesLocation",
                data: {
                    'searchLocation': searchCityString
                },
                dataType: "text",
                async:true,
                success: function(msg) {
                    let result = JSON.parse(msg);
                    $.each(result, function(key, arr) {
                        $.each(arr, function(id, searchCityString) {
                            if (key === 'locations') {
                                if (id !== 'error') {

                                    entitySel.append('<li value="'+searchCityString[0]+'" ><b>  ' + searchCityString[0] +'</b></li>');
                                   $("li").on('click', function(){
                                       let input = document.getElementById('place').value;
                                       if(input !==''){

                                           input=document.querySelector('li').getAttribute('value');
                                           document.getElementById('place').value=input;
                                       }
                                   });
                                }
                                else {
                                    entitySel.append('<li><b> '+searchCityString+'</b></li>');
                                }
                            }
                        });
                    });

                }
            });
        }
    });

});