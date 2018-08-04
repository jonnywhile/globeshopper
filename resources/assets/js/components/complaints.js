/* global
 Mustache
*/

;(function(window, undefined) {


	var Complaints = function() {

	    $('.make-complaint').click(function() {
	        $('#complaint').removeClass('hidden');
	    });

	    $('.save-comment').click(function() {
	        var requestId = $(this).data('request-id'),
	            complaintId = $(this).data('complaint-id'),
	            $form = $('#complaint-form');

            if (requestId !== undefined) {
                $.post('/complaints/create-complaint/' + requestId, $form.serialize(), function(complaint) {
                    createComment(complaint.id);
                });
            } else if (complaintId !== undefined) {
                createComment(complaintId);
            }
	    });

        var createComment = function(complaintId) {
            var $form = $('#complaint-form');

            $.post('/complaints/create-comment/' + complaintId, $form.serialize(), function(comment) {
                comment = JSON.parse(comment);
                $.get('../../templates/complaints/comment.mst', function(template) {

                    var rendered = Mustache.render(template, {
                        comment: comment
                    });

                    $('.complaint-comments').append(rendered);
                    $('#comment').html('');
                });
            });
        };

        $('.resolve-complaint').click(function() {
            var complaintId = $(this).data('complaint-id'),
                userType = $(this).data('user-type');

            $.post('/complaints/resolve/' + complaintId + '/' + userType, {_token: $('input[name="_token"]').val()}, function() {
//                location.reload();
            });
        });
    };

	window.Complaints = Complaints();
})(window);
