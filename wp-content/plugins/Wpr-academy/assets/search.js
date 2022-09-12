(function($){
    function delay(callback, ms) {
		var timer = 0;
		return function() {
			var context = this, args = arguments;
			clearTimeout( timer );
			timer = setTimeout(
				function () {
					callback.apply( context, args );
				},
				ms || 0
                );
            };
        }


    $( '#wpr-filter select' ).on( 'change', WprDoAjax );

	$( '#wpr-filter input#keyword' ).keyup( delay( WprDoAjax, 500 ) );

	function WprDoAjax(){

		var level = $( '#wpr-filter select' ).val();
		var search  = $( '#wpr-filter input#keyword' ).val();
		data        = {
			action: 'search',
			level: level,
			keyword: search,
		}
				$.ajax({  
                        url: WPR.ajax_url, 
                        type: 'GET', 
                        data: data,
                        success: function(response){
                        console.log(response);
                            $( '#archive-engineers' ).empty();
                                var content = '';
                                    jQuery.each(
                                        response,
                                            function(i, t){
                                                content += '<div class="wpr-post">';
                                                content += '<h1 class="wpr-title">';
                                                content += '<a href="' + t.link + '">' + t.title + '</a>';
                                                content += '</h1>';
                                                content += '</div>';
                                                }
                                            );   
                                    jQuery( "#archive-engineers" ).html( content );
                                }
                            }
                    )
    }
})( jQuery );
