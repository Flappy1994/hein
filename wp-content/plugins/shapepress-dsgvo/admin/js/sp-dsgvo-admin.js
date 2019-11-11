(function($){

	$(document).ready(function(){

	    /************************
		* Settings
		*************************/
		$('.btn-settings').click(function(){
			if($(this).attr('data-state') == 'closed'){
				$('.btn-settings-show').show();
				$(this).attr('data-state', 'open');
				$(this).find('.state').html('Hide');
			}else{
				$('.btn-settings-show').hide();
				$(this).attr('data-state', 'closed');
				$(this).find('.state').html('Show');
			}
		});


		/************************
		* SAR
		*************************/
		$('#process_now').change(function(){
			var checkbox = document.getElementById('process_now');
			if(checkbox){
				if(checkbox.checked){
					$('#display_email').closest('tr').show();
				}else{
					$('#display_email').closest('tr').hide();
				}
			}
		});

		$('.cbChecklist').on('change', function () {
            var input = $(this).next('span');
            if (this.checked) {
                $(input).css('textDecoration', 'line-through');
            } else {
                $(input).css('textDecoration', 'none');
            }
            $('#checklist-form').submit();
        });

		/* i592995 */
		function checkNoticeType($select) {
			var val = $select.val(),
				$popupSettings = $('.policy-popup-settings'),
				$noticeSettings = $('.cookie-notice-settings');

			if(val == 'cookie_notice') {
				$popupSettings.removeClass('active');
				$noticeSettings.addClass('active');
			} else if(val == 'policy_popup') {
				$popupSettings.addClass('active');
				$noticeSettings.removeClass('active');
			} else {
				$popupSettings.removeClass('active');
				$noticeSettings.removeClass('active');
			}
		}

		var $noticeType = $('#cookie_notice_display');
		if($noticeType.length > 0) {
			checkNoticeType($noticeType);

			$noticeType.on('change', function() {
				var $this = $(this);
				checkNoticeType($this);
			});
		}

		$('.unsubscribe-dismiss').on('click tap', function() {
			var $this = $(this),
				id = $this.attr('data-id');

			if(confirm(args.dismiss_confirm)) {
				$this.parent().parent().fadeOut(500);
				$.post( args.ajaxurl, {
	                action: 'admin-dismiss-unsubscribe',
	                id: id
	            },
	            function( data ) {
	            } );
			}
		});
		/* i592995 */

	});
})( jQuery );

/* i592995 */
// THIS PART OF THE SCRIPT ADDS UPLOAD IMAGE Buttons

jQuery( document ).ready( function( $ ) {

	function prepareUpload($upload) {
		// Uploading files
		var file_frame;
		var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
		var set_to_post_id = $upload.find('.image-id').val(); // Set this
		$upload.find('.button').on('click', function( event ){
			event.preventDefault();
			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				// Set the post ID to what we want
				file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
				// Open frame
				file_frame.open();
				return;
			} else {
				// Set the wp.media post id so the uploader grabs the ID we want when initialised
				wp.media.model.settings.post.id = set_to_post_id;
			}
			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				multiple: false	// Set to true to allow multiple files to be selected
			});
			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				// We set multiple to false so only get one image from the uploader
				attachment = file_frame.state().get('selection').first().toJSON();
				// Do something with attachment.id and/or attachment.url here
				$upload.find('.image-preview').attr( 'src', attachment.url );
				$upload.find('.image-id').val( attachment.id );
				// Restore the main post ID
				wp.media.model.settings.post.id = wp_media_post_id;
			});
				// Finally, open the modal
				file_frame.open();
		});
		// Restore the main ID when the add media button is pressed
		jQuery( 'a.add_media' ).on( 'click', function() {
			wp.media.model.settings.post.id = wp_media_post_id;
		});
	}

	$('.dsgvo-image-upload').each(function() {
		var $this = $(this);

		prepareUpload($this);
	});

	$('#own_code').on('change', function() {
		var $this = $(this);
		$this.toggleClass('active');

		if($this.hasClass('active')) {
			$('#ga_code').removeAttr('disabled');
			$('#fb_pixel_code').removeAttr('disabled');
		} else {
			$('#ga_code').attr('disabled', 'disabled');
			$('#fb_pixel_code').attr('disabled', 'disabled');
		}
	});

});
