$(document).ready(function() {
	// Stripe API Key
	if (typeof Stripe != 'undefined') {
		var stripe = Stripe(stripe_pk);
		var elements = stripe.elements();
		// Custom Styling
		var style = {
		    base: {
		        color: '#000000',
		        lineHeight: 'normal',
		        fontFamily: '"Open Sans", sans-serif',
		        fontSmoothing: 'antialiased',
		        fontSize: '1em',
		        '::placeholder': {
		            color: '#aab7c4'
		        }
		    },
		    invalid: {
		        color: '#fa755a',
		        iconColor: '#fa755a'
		    }
		};
		// Create an instance of the card Element
		var card = elements.create('card', {style: style});
		// Add an instance of the card Element into the `card-element` <div>
		card.mount('#card-element');
		// Handle real-time validation errors from the card Element.
		card.addEventListener('change', function(event) {
		    var displayError = document.getElementById('card-errors');
		if (event.error) {
		        displayError.textContent = event.error.message;
		    } else {
		        displayError.textContent = '';
		    }
		});
		// Handle form submission
		var form = document.getElementById('payment-form');

		form.addEventListener('submit', function(event) {
		    event.preventDefault();
			stripe.createToken(card).then(function(result) {
		        if (result.error) {
		            // Inform the user if there was an error
		            var errorElement = document.getElementById('card-errors');
		            errorElement.textContent = result.error.message;
		        } else {
		            stripeTokenHandler(result.token);
		        }
		    });
		});

		// Send Stripe Token to Server
		function stripeTokenHandler(token) {
		    // Insert the token ID into the form so it gets submitted to the server
		    var form = document.getElementById('payment-form');
			// Add Stripe Token to hidden input
		    var hiddenInput = document.createElement('input');
		    hiddenInput.setAttribute('type', 'hidden');
		    hiddenInput.setAttribute('name', 'stripeToken');
		    hiddenInput.setAttribute('value', token.id);
		    form.appendChild(hiddenInput);
			// Submit form
		    form.submit();
		}

	}











	$('#mobi_nav_trigger').on('click', function() {
		if ($('#mobi_nav_trigger').hasClass('open')) {
			$('#mobi_nav').hide();
			$('#mobi_nav_trigger').removeClass('open');
		} else {
			$('#mobi_nav').show();
			$('#mobi_nav_trigger').addClass('open');
		}
	});








	$('input[type="text"][required]').on('blur', function(e) {
		// Get target
		var target = $(e.target);
		// Check if value is not empty
		if ($(target).val().trim() == '') {
			// Show error
			$('.form_error_message[for="' + $(target).attr('id') + '"]').addClass('show');
		} else {
			// Hide error
			$('.form_error_message[for="' + $(target).attr('id') + '"]').removeClass('show').removeAttr('style');
		}
		checkForm($('#payment-form'));
	});

	$('input[type="email"][required]').on('blur', function(e) {
		// Get target
		var target = $(e.target);
		// Check if value is not empty
		if ($(target).val().trim() == '' || isEmailValid($(target).val()) == false) {
			// Show error
			$('.form_error_message[for="' + $(target).attr('id') + '"]').addClass('show');
		} else {
			// Hide error
			$('.form_error_message[for="' + $(target).attr('id') + '"]').removeClass('show').removeAttr('style');
		}
		checkForm($('#payment-form'));
	});

	$('[name="donation_amount_not_final"]').on('blur', function(e) {
		// Get target
		if ($(e.target).val() < 2) {
			// Show error
			$('.form_error_message[for="' + $(e.target).attr('id') + '"]').addClass('show');
		} else {
			// Hide error
			$('.form_error_message[for="' + $(e.target).attr('id') + '"]').removeClass('show').removeAttr('style');
		}
		checkForm($('#payment-form'));
	});

	function isEmailValid(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	function checkForm(form) {
		// Get all errors that are visible
		// Check if done
		// if (valid) {
		// 	// Enable the form submit
		// 	$(form).find('[type="submit"]').each(function(e) {
		// 		$(e).removeAttr('disabled');
		// 	});
		// } else {
		// 	// Disabled the form submit
		// 	$(form).find('[type="submit"]').each(function(e) {
		// 		$(e).attr('disabled', 'disabled');
		// 	});
		// }
	}













	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Default code
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Default code


	// Check if donation object exists
	if (typeof donation != 'undefined') {
		// Set totals on page
		setDonationPageTotals();
	}


	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Donation input
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Donation input


	// On change of additional donation input
	$('[name="donation_amount_not_final"]').on('keyup', function(e) {
		// Force value to be monetary format
		forceMonetaryFormat($(e.target));
		// Set donation values on page
		setDonationPageTotals();
	});


	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donations - Calculate fees
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donations - Calculate fees


	// Calculate donation fees
	function calculateDonationFees(fee_string, amount) {
		// Get fees information
		fee_string = fee_string.split('|');
		// Get fees from env string
		var fees_items = {
			stripe_percentage: parseFloat(fee_string[0]),
			stripe_pounds: parseFloat(fee_string[1]),
			dashdonate_pounds: parseFloat(fee_string[2]),
		};
		// Calculate fees and turn into pence
		var fees = (((amount + fees_items.stripe_pounds + fees_items.dashdonate_pounds) / fees_items.stripe_percentage) * 100);
		// Ceil sub-pence and divide back down to pence
		fees = (Math.ceil(fees) / 100);
		// Calculate minimum fee (take away donation amount from total calculated above)
		fees = (fees - amount);
		// Return fees
		return fees;
	}


	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Calculate and set donation values
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Calculate and set donation values


	// Calculate donation page totals
	function calculateDonationPageTotals() {
		// Storage for values of inputs
		donation.input_values = {
			// Get value from amount input
			amount_input: forceMonetaryFormat($('[name="donation_amount_not_final"]')),
			// Get value from additional amount dropdown
			additional_amount: $('[name="additional_donation"]').val(),
			// Get value from additional amount input
			additional_amount_other: forceMonetaryFormat($('[name="additional_donation_other"]')),
		};
		// Storage for calculated values
		donation.calculated_values = {
			minimum_fees: calculateDonationFees(donation_fees, donation.input_values.amount_input),
		};
		// Check whether additional amount was set to 'other'
		if (donation.input_values.additional_amount == 'other') {
			// Set final additional amount value to the value of donation.input_values.additional_amount_other
			donation.calculated_values.final_additional_value = donation.input_values.additional_amount_other;
			// Check whether 'other' amount is lower than minimum fees
			if (donation.calculated_values.final_additional_value < donation.calculated_values.minimum_fees) {
				// Disable donation submit button
				$('[name="donate_submit_button"]').attr('disabled', 'disabled');
				// Set notice's fee value
				$('.additional_too_low_warning strong').text('£' + donation.calculated_values.minimum_fees.toFixed(2));
				// Display notice of fee being too low
				$('.additional_too_low_warning').removeClass('d-none');
			} else {
				// Enable donation submit button
				$('[name="donate_submit_button"]').removeAttr('disabled');
				// Hide notice of fee being too low
				$('.additional_too_low_warning').addClass('d-none');
			}
		} else {
			// Set final additional value as minimum fee
			donation.calculated_values.final_additional_value = donation.calculated_values.minimum_fees;
		}
		// Calculate total amount
		donation.calculated_values.total_donation = parseFloat(parseFloat(donation.input_values.amount_input) + parseFloat(donation.calculated_values.final_additional_value)).toFixed(2);
	}

	// Set donation page totals
	function setDonationPageTotals() {
		// Check if donation object was created
		if (typeof donation != 'undefined') {
			// Calculate totals
			calculateDonationPageTotals();
			// Set additional amount minimum
			$('[name="additional_donation"] option[value="fees_only"]').text('Payment processing fees only (£' + donation.calculated_values.minimum_fees.toFixed(2) + ')');
			// Set additional amount 'other' minimum
			$('[name="additional_donation_other"]').attr('min', donation.calculated_values.minimum_fees.toFixed(2));
			// Check if donation amount is over minimum
			if (donation.input_values.amount_input < donation_minimum) {
				// Show warning
				$('.donation_too_low_warning').removeClass('d-none');
				// Disable donation submit button
				$('[name="donate_submit_button"]').attr('disabled', 'disabled');
			} else {
				// Hide warning
				$('.donation_too_low_warning').addClass('d-none');
				// Enable donation submit button
				$('[name="donate_submit_button"]').removeAttr('disabled');
			}
			// Set pay button total
			$('[name="donate_submit_button"]').val('Pay £' + donation.calculated_values.total_donation);
			// Set hidden field donation amount
			$('[name="donation_amount"]').val(donation.calculated_values.total_donation);
		}
	}


	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Additional donation dropdown
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Additional donation dropdown


	// On change of additional donation dropdown
	$('[name="additional_donation"]').on('change', function(e) {
		// Hide error message for invalid selection
		$('.additional_not_valid_warning').addClass('d-none');
		// Check if value is 'other'
		if ($(e.target).val() == 'other') {
			showAdditionalDonationAmountField();
		} else {
			hideAdditionalDonationAmountField();
		}
		// Set donation values on page
		setDonationPageTotals();
	});

	// Reveals custom additional donation input
	function showAdditionalDonationAmountField() {
		$('.additional_donation_other_dropdown').removeClass('d-none');
	}

	// Hides custom additional donation input
	function hideAdditionalDonationAmountField() {
		$('.additional_donation_other_dropdown').addClass('d-none');
	}


	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Additional donation input
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Donation page - Additional donation input


	// On change of additional donation input
	$('[name="additional_donation_other"]').on('change input propertychange', function(e) {
		// Force value to be monetary format
		forceMonetaryFormat($(e.target));
		// Set donation values on page
		setDonationPageTotals();
	});

	// Check ensure the maximum decimal places is 2
	$('[name="additional_donation_other"], [name="donation_amount_not_final"]').on('blur', function(e) {
		// Force two decimal places
		forceDoubleDecimal($(e.target));
	});


	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Misc functions - Force input to be numeric
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Misc functions - Force input to be numeric


	// Force input to use a monetary format
	function forceMonetaryFormat(input) {
		// Get input
		var input = $(input);
		// Check value is not NaN
		if (input.val() === '') {
			// Return 0.00
			return 0.00;
		} else {
			// Force float value
			input.val(parseFloat(input.val()));
		}
		return parseFloat(input.val());
	}


	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Misc functions - Force two decimal places
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Misc functions - Force two decimal places


	// Force two decimal places with input
	function forceDoubleDecimal(input) {
		// Get input
		var input = $(input);
		// Check value is not NaN
		if (input.val() === '') {
			// Set value to 0.00
			input.val(0.00);
		} else {
			// Force two decimal places
			input.val(parseFloat(input.val()).toFixed(2));
		}
	}








	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Desktop searchbar reveal
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- Desktop searchbar reveal


	// Event listener for search click
	$('#search_btn').on('click', function(e) {
		// Check if item is submit button
		if (!($(e.target) == $('[name="nav_search_query"]') || $(e.target).hasClass('btn-submit'))) {
			// Prevent click from redirecting user to search page (happens so if JS is disabled, the search still works)
			e.preventDefault();
			// Check if search status was not already active
			if (!($('#search_btn').closest('.nav_container').hasClass('search_active'))) {
				// Open nav
				openSearchNav();
			}
		} else {
			// Submit search
			$('#search_site').submit();
		}
	});

	// Submit search on [ENTER] key being pressed
	$(document).on('keydown', '[name="nav_search_query"]', function(e) {
		if (e.which === 13) {
			// Submit search
			$('#search_site').submit();
		}
	});

	// Close search nav on window resize (to prevent overflowing of search bar)
	$(window).on('resize', closeSearchNav);

	// Close search bar when page is clicked outside of search region
	$('html').on('click', 'body', function(e) {
		// Check if click was not the search bar/button
		if (!($(e.target).closest('#search_btn')[0] == $('#search_btn')[0])) {
			// Close nav
			closeSearchNav();
		}
		// Check if click was not part of a dropdown
		if (!($(e.target).closest('.dropdown-container').length > 0)) {
			// Close dropdowns
			closeDropdowns();
		}
		// Check if click was not part of mobile nav
		if (!($(e.target).closest('#mobi_nav').length > 0) && !($(e.target).closest('#mobi_nav_trigger').length > 0)) {
			$('#mobi_nav').hide();
			$('#mobi_nav_trigger').removeClass('open');
		}
	});

	// Function to open search bar
	function openSearchNav() {
		// Remove fresh status of nav
		$('#search_btn').closest('.nav_container').removeClass('nav_fresh');
		// Make search button active
		$('#search_btn').closest('.nav_container').addClass('search_active');
		// Get left offset of button
		var btn_offset = $('#search_btn').position().left;
		var nav_width = $('nav .nav_container').outerWidth();
		// Set original width of button
		$('#search_btn').attr('orig_width', $('#search_btn').outerWidth());
		// Delay to make elements fall into place smoothly
		setTimeout(function() {
			$('#search_btn button').fadeIn(50);
			$('#search_btn').attr('state', 'full');
			$('#search_btn').css('left', (btn_offset + 'px'));
			$('#search_btn').animate({ width: ((nav_width - btn_offset) + 'px') }, 125);
			$('#search_btn input').css('max-width', ((nav_width - btn_offset) - 80 + 'px'));
		}, 125);
	}

	// Function to close search bar
	function closeSearchNav() {
		$('#search_btn').animate({ width: ($('#search_btn').attr('orig_width') + 'px') }, 125);
		$('#search_btn button').fadeOut(50);
		setTimeout(function() {
			// Remove 'full' state from search bar
			$('#search_btn').removeAttr('state');
			$('#search_btn').css('left', 'unset');
			$('#search_btn').css('width', 'auto');
			$('#search_btn').removeAttr('orig_width');
			// Remove class for search bar/button being active
			$('#search_btn').closest('.nav_container').removeClass('search_active');

			$('#search_btn').closest('.nav_container').addClass('nav_fresh');
		}, 125);
	}



	$('.dropdown-trigger').on('click', function(e) {
		// Check if dropdown was open
		if ($(e.target).closest('.dropdown-container').attr('state') == 'closed') {
			// Close dropdowns
			closeDropdowns();
			// Open container
			$(e.target).closest('.dropdown-container').attr('state', 'open');
		} else {
			// Close dropdown
			closeDropdowns();
		}
	});

	// Close all dropdowns
	function closeDropdowns() {
		$('.dropdown-container').each(function() {
			$(this).attr('state', 'closed');
		});
	}

});
