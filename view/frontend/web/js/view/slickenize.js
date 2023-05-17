define([
	'jquery',
	'domReady',
	'slick'
], function ($, domReady) {
	'use strict'

	return function (config, element) {
		$(element).find('ul').slick(JSON.parse(config.props));

		$(element).find('.item').show();

		$(element).find('.close').click(function () {
			$(element).hide('fast', function () {
				$(element).remove();
			});
		});
	};
});
