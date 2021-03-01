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
                                            entitySelector.append('<li><b> '+searchString+'</b></li>');
                                        }
                                    }
                                });
                            });

                    }
                });
        }
    });
    $("#searchlocation").keyup(function() {
        let minlength = 1;
        let searchString = $(this).val();
        let entitySelector = $("#searchLocation_result").html('');
        if (searchString.length >= minlength) {
            searchRequest = $.ajax({
                type: "GET",
                url: "/searchLocation",
                data: {
                    'searchLocation': searchCity
                },
                dataType: "text",
                async:true,
                success: function(msg) {
                    let result = JSON.parse(msg);
                    $.each(result, function(key, arr) {
                        $.each(arr, function(id, searchString) {
                            if (key === 'location') {
                                if (id !== 'error') {
                                    // entitySelector.append('<li ><b>' + searchString[0] +'</li>');
                                    entitySelector.append('<a   href="advertisement/'+id+'">' + searchString[0] +'</a>');
                                }
                                else {
                                    entitySelector.append('<li><b> '+searchString+'</b></li>');
                                }
                            }
                        });
                    });

                }
            });
        }
    });
});