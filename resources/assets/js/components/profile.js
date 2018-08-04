/* global
*/

;(function(window, undefined) {


	var Profile = function() {

	    $('.make-globshopper').change(function() {
	        var $check = $(this);
	        if ($check.is(':checked')) {
	            $('.globshopper-data').removeClass('hidden');
	        } else {
	            $('.globshopper-data').addClass('hidden');
	        }
	    });

	    $('.save-profile').click(function() {
	        var address = null,
	            input = $('#profile-form').serializeArray(),
	            isGlobshopper = $('.make-globshopper').is(':checked') ? 1 : 0;

            input.push({
                name: 'is_globshopper',
                value: isGlobshopper
            });

	        if (isGlobshopper) {
	            var position = marker.getPosition(),
	                geocoder = new google.maps.Geocoder;

                geocoder.geocode({'location': position}, function(results, status) {
                    if (status === 'OK') {
                        input.push({
                            name: 'location',
                            value: JSON.stringify(results)
                        });
                    }

                    $.post('/profile', input, function() {
                        $.notify('Profile Updated', 'success');
                    });
                });
	        } else {
                $.post('/profile', input, function() {
                   $.notify('Profile Updated', 'success');
                });
	        }
	    });

        $('#editor').summernote({
            placeholder: 'Enter text that will be shown on your page as your portfolio',
            height: 200
        });

        $('.save-portfolio').click(function() {
            var globshopperId = $(this).data('globshopper-id');

            $.post('/globshoppers/save-portfolio/' + globshopperId, {html: $('#editor').summernote('code')}, function() {
            });
        });
	};

	window.Profile = Profile();
})(window);
