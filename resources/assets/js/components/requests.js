/* global
*/

;(function(window, undefined) {


	var Requests = function() {

        $('.selectpicker').selectpicker();

        $('.datepicker').datepicker();

        $('.create-request').click(function() {
            var globshopperId = $(this).data('globshopper-id');
            $('#create-request-form').validate();

            if ($('#create-request-form').valid() === true) {
                var formData = new FormData(document.querySelector('#create-request-form'));

                formData.append("request_image", $('#request-image')[0].files[0]);

                $.ajax({
                        url: '/requests/create/' + globshopperId,
                        type: 'POST',
                        data: formData,
                        cache: false,
                        dataType: 'json',
                        processData: false, // Don't process the files
                        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                        success: function(data, textStatus, jqXHR) {
                            location.assign('/requests/view/' + data.id);
                        }
                });
            }
        });

        $('.save-request').click(function() {
            var requestId = $(this).data('request-id');

            $('#edit-request-form').validate();

            if ($('#edit-request-form').valid() === true) {
                var formData = new FormData(document.querySelector('#edit-request-form'));

                formData.append("request_image", $('#request-image')[0].files[0]);

                $.ajax({
                        url: '/requests/save-request/' + requestId,
                        type: 'POST',
                        data: formData,
                        cache: false,
                        dataType: 'json',
                        processData: false, // Don't process the files
                        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                        success: function(data, textStatus, jqXHR) {
                            $.notify('Request Updated', 'success');
                        }
                });
            }
        });

        $('.accept-request').click(function() {
            var requestId = $(this).data('request-id');

            $.get('/requests/accept-request/' + requestId, {}, function() {
                $('.request-offer-section').removeClass('hidden');
            });
        });

        $('.cancel-request').click(function() {
            var requestId = $(this).data('request-id');

            $.get('/requests/cancel-request/' + requestId, {}, function() {
//                $('.request-offer-section').addClass('hidden');
            });
        });

        $('.set-delivered').click(function() {
            var requestId = $(this).data('request-id');

            $.get('/requests/set-delivered/' + requestId, {}, function() {
                location.reload();
            });
        });

        $('.save-rating').click(function() {
            var requestId = $(this).data('request-id');

            $.post('/requests/create-rating/' + requestId, $('#rating-form').serialize(), function() {
                $.notify('Rating Saved', 'success');
            });
        });

        $('.save-offer').click(function() {
            var requestId = $(this).data('request-id'),
                offerId = $(this).data('offer-id'),
                formData = new FormData(document.querySelector('#offer-form'));

            $('#offer-form').validate();
                if ($('#offer-form').valid() === true) {
                    var url = (offerId !== undefined) ? '/offers/update/' + offerId : '/offers/create/' + requestId;

                    formData.append("offer_image", $('#offer-image')[0].files[0]);

                    $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            cache: false,
                            dataType: 'json',
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function(data, textStatus, jqXHR) {
                                $.notify('Offer Saved', 'success');
                            }
                    });
                }
        });

        $('.accept-offer').click(function() {
            $('.stripe-pay').removeClass('hidden');
            $(this).addClass('hidden');
        });

        if ($('#stripe-pay-form').length > 0) {
            $('#stripe-pay-form').get(0).submit = function() {
                var data = $(this).serializeArray(),
                    requestId = $(this).data('request-id');

                $.post('/charges/create/' + requestId, data, function() {
                    location.reload();
                });

                // Prevent form submit.
                return false;
            }
        }

        $('#rating').rating();
    };

	window.Requests = Requests();
})(window);
