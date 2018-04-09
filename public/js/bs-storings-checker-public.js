(function( $ ) {
    'use strict';
    $( window ).load(function() {
        var regexpCheckPostcodeNL = /^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i;

        $( document ).on( 'click', '.check-storing', function() {

            $("#sc-error").hide();
            $("#sc-not-found").hide();
            $("#sc-found").hide();

            // Normalize and validate
            var normalizedInput = $('#sc-postcode').val().replace(/ /g,'').toUpperCase();
            
            if(!isValidPostcode(normalizedInput))
            {
                $("#sc-error").show();
                return;
            }
            
            $.ajax({
                url : storings_checker.ajax_url,
                type : 'post',
                data : {
                    action : 'storingscheck',
                    postcode : normalizedInput
                },
                success : function( data )
                {
                    console.log(data);
                    var response = JSON.parse(data);

                    if(response.status === 'not_found')
                    {
                        $("#sc-not-found").show();                        
                        return;
                    }
                    
                    if(response.items.length === 0)
                    {
                        $("#sc-found").show();
                        return;
                    }

                    renderItems(response.items);
                    
                },
                error: function (error)
                {
                    console.log(error);
                }
            });
            
        });

        function renderItems(items)
        {
            for(var i = 0; i < items.length; ++i)
            {
                $("#storingen").append('<h3>' + items[i].title + '</h3>' + '<p>'+items[i].description+'</p>');
            }
        }

        function isValidPostcode(input)
        {
            return regexpCheckPostcodeNL.test(input);
        }
        
    });

})( jQuery );
