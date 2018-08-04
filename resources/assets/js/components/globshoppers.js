/* global
 Mustache
*/

;(function(window, undefined) {

	var Globshoppers = function() {

        $('.search-globshoppers').click(function() {
            $.post('/globshoppers/search', $('#search-form').serialize(), function(globshoppers) {
                $.get('templates/globshoppers/card.mst', function(template) {
                    var rendered = Mustache.render(template, {
                        globshoppers: globshoppers
                    });

                    $('.globshoppers-cards').html(rendered);
                });
            });
        });
	};

	window.Globshoppers = Globshoppers();
})(window);
