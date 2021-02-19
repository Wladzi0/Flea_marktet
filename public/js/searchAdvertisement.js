$(document).ready(function() {
    let searchRequest = null;
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
                                            entitySelector.append('<li ><b>' + searchString[0] +'</li>');
                                        }
                                    }
                                });
                            });

                    }
                });
        }
    });
});