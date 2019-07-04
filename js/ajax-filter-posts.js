jQuery(document).ready(function($) {
	$('.tax-filter').click( function(event) {

		// Prevent defualt action - opening tag page
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}

		// Get tag slug from title attirbute
		var selecetd_taxonomy = $(this).attr('title');

		$('.tagged-posts').fadeOut();

		data = {
			action: 'filter_posts',
			afp_nonce: afp_vars.afp_nonce,
			taxonomy: selecetd_taxonomy,
		};

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: afp_vars.afp_ajax_url,
			data: data,
			success: function( data, textStatus, XMLHttpRequest ) {
				$('.tagged-posts').html( data );
				$('.tagged-posts').fadeIn();
				console.log( textStatus );
				console.log( XMLHttpRequest );
			},
			error: function( MLHttpRequest, textStatus, errorThrown ) {
				console.log( MLHttpRequest );
				console.log( textStatus );
				console.log( errorThrown );
				$('.tagged-posts').html( 'No posts found' );
				$('.tagged-posts').fadeIn();
			}
		})

	});
});
