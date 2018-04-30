(function( $ ) {
    'use strict';
    $(window).load(function() {

        var regexpCheckPostcodeNL = /^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i;
        
        $('#sc-postcode').keypress(function (e) {
            if (e.which == 13)
            {
                checkPostcode();
                return false;
            }
            return true;
        });
        
        $(document).on( 'click', '.check-storing', function() {
            checkPostcode();
                        
        });

        function checkPostcode()
        {
            $("#sc-spinner").show();
            $("#sc-not-valid").hide();
            $("#sc-not-error").hide();
            $("#sc-not-found").hide();
            $("#sc-found").hide();
            $("#sc-error").hide();

            // Normalize and validate
            var normalizedInput = $('#sc-postcode').val().replace(/ /g,'').toUpperCase();

            // Validate postcode using Regular Expression
            if(!regexpCheckPostcodeNL.test(normalizedInput))
            {
                $("#sc-not-valid").show();
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

                    //NOTE: Postcode niet gevonden in Warmtenet
                    if(response.status === 'not_found')
                    {
                        $("#sc-not-found").show();                        
                        return;
                    }
                    
                    //NOTE: Postcode gevonden, geen storingen
                    if(response.items_werkzaamheden.length === 0 && response.items_storingen.length === 0)
                    {
                        $("#sc-found").show();
                        return;
                    }

                    //NOTE: Storingen gevonden                    
                    if(response.items_storingen.length > 0)
                    {
                        $("#sc-storingen-intro").show();                        
                        $("#sc-storingen").show();
                        for(var i = 0; i < response.items_storingen.length; ++i)
                        {
                            $("#sc-storingen").append('<p><span class="uk-text-bold">' + response.items_storingen[i].title + '</span><br />' + response.items_storingen[i].description +'</p>');
                        }
                    }

                    //NOTE: Werkzaamheden gevonden
                    if(response.items_werkzaamheden.length > 0)
                    {
                        $("#sc-storingen-intro").show();                        
                        $("#sc-storingen").show();
                        for(var i = 0; i < response.items_werkzaamheden.length; ++i)
                        {
                            $("#sc-storingen").append('<p><span class="uk-text-bold">' + response.items_werkzaamheden[i].title + '</span><br />' + response.items_werkzaamheden[i].description +'</p>');
                        }
                    }
                },
                error: function (error)
                {
                    $("#sc-spinner").hide();
                    $("#sc-error").show();
                }
            });

        }
        
    });

})( jQuery );
