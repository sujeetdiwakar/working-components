        var ajaxurl = $( '.js-location' ).data( 'url' );
		$(document).on('click','#js-search',function (e) {
			e.preventDefault();
			var $postcode = $('#postcode').val();
			if($postcode){
                var data = {
                    'action': 'load_posts_by_ajax',
                    'postcode': $postcode,
                };
                alert($postcode);
                $.post( ajaxurl, data,
                    function( response ) {

                        if ( response ) {
                            $( '.js-content' ).html( response );

                        }
                    }
                );
			}else{
				alert('Wrong post or blank');
			}
        });
		$( document ).on( 'change', '.js-cat', function() {
			var $cat = $( this ).val();


			var data = {
				'action': 'load_posts_by_ajax',
				'cat': $cat,
			};

			$.post( ajaxurl, data,
				function( response ) {

					if ( response ) {
						$( '.js-content' ).html( response );

					}
				}
			);

		} );

        $( document ).on( 'change', '.js-cat-location', function() {
            var $cat = $( this ).val();
            var data = {
                'action': 'load_posts_by_ajax',
                'cat': $cat,
            };

            var data_cat = {
                'action': 'load_filter_by_ajax_check',
                'cat': $cat,
            };

            $.when(
                $.post( ajaxurl, data,
                    function( response ) {
                        if ( response ) {

                            $( '.js-content' ).html( response );
                        }
                    }
                ),
                $.post( ajaxurl, data_cat,
                    function( data ) {
                        if ( data ) {
                            $( '.js-cat-desc' ).html( data );
                        }
                    }
                )
            ).then( function() {
                var data_val = {
                    'action': 'load_filter_by_ajax_list',
                    'cat': $cat,
                };
                $.post( ajaxurl, data_val,
                    function( data ) {
                        if ( data ) {
                            $( '.js-list' ).html( data );
                        }
                    }
                );
            } );
        } );