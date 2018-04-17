(function( $ ) {
    'use strict';
    $( window ).load(function() {

        var regexpCheckPostcodeNL = /^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i;
        
        $('#sc-postcode').keypress(function (e) {
            if (e.which == 13)
            {
                checkPostcode();
                return false;
            }
            return true;
        });
        
        $( document ).on( 'click', '.check-storing', function() {
            checkPostcode();
                        
        });

        function checkPostcode()
        {
            $("#sc-spinner").show();
            $("#sc-error").hide();
            $("#sc-not-found").hide();
            $("#sc-found").hide();

            // Normalize and validate
            var normalizedInput = $('#sc-postcode').val().replace(/ /g,'').toUpperCase();
            
            if(!isValidPostcode(normalizedInput))
            {
                $("#sc-error").show();
                $("#sc-spinner").hide();
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
                    $("#sc-spinner").hide();
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
                    $("#sc-spinner").hide();
                }
            });

        }

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
