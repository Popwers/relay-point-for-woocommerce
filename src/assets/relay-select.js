(function ($) {
	function syncRelaySelect() {
		var $radio = $('.relay_wrapper input').first();

		if (!$radio.length) {
			return;
		}

		if ($radio[0].checked) {
			$('.relay_wrapper select').removeAttr('disabled');
		} else {
			$('.relay_wrapper select').attr('disabled', true);
		}
	}

	$(document.body).on('change', '.relay_wrapper select', function () {
		var option = this.selectedOptions[0];

		$('.relay_wrapper input')
			.attr('name', option.getAttribute('name'))
			.attr('value', option.getAttribute('value'))
			.attr('data-index', option.getAttribute('data-index'))
			.attr('id', option.getAttribute('id'));
		$(document.body).trigger('update_checkout');
	});

	$(document.body).on('updated_checkout updated_cart_totals', syncRelaySelect);
	$(syncRelaySelect);
})(jQuery);
