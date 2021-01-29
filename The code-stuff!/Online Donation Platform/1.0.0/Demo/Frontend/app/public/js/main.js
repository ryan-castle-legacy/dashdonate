$(document).ready(function() {


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


});
