$(document).ready(function() {




	// Variable to prevent callstack overflowing
	var debounce = false;




	// // Create event listener if 3DS has been completed
	// window.addEventListener('message', function(e) {
	// 	// Check if message is 3DS done
	// 	if (e.data) {
	// 		if (e.data.type != undefined && e.data.type === 'stripe-3ds-result') {
	// 			// Complete 3Ds authentication
	// 			complete3DS(e.data);
	// 		}
	// 	}
	// });
	//
	//
	// function complete3DS(data) {
	// 	// Remove iFrame
	// 	document.querySelector('#iframe_3ds_verify_donation').remove();
	// 	// Check if intent was returned
	// 	if (data.message != undefined && data.message.payment_intent != undefined) {
	// 		// Switch status of intent
	// 		if (data.message.payment_intent.status == 'succeeded') {
	// 			// Send AJAX request to complete task
	// 			$.ajax({
	// 				method:			'POST',
	// 				url:			'/ajax/complete-donation-task/',
	// 				data:			{
	// 					_token:			$('[name="_token"]').val(),
	// 					task_token:		$('[task]').attr('task'),
	// 				},
	// 				crossDomain: 	true,
	// 				dataType:		'json',
	// 				success: 		function(data) {
	// 					console.log(data);
	// 					// Display success message to user
	// 					$('#success').removeClass('d-none');
	// 				},
	//
	// 			});
	// 		}
	// 	} else {
	// 		// Send AJAX request to complete task
	// 		$.ajax({
	// 			method:			'POST',
	// 			url:			'/ajax/fail-donation-task/',
	// 			data:			{
	// 				_token:			$('[name="_token"]').val(),
	// 				task_token:		$('[task]').attr('task'),
	// 			},
	// 			crossDomain: 	true,
	// 			dataType:		'json',
	// 			success: 		function(data) {
	// 				console.log(data);
	// 				// Display error message to user
	// 				$('#error').removeClass('d-none');
	// 			},
	// 		});
	// 	}
	// }





























	$('#mobile_navbar_toggle').on('click', function() {
		if ($('#navbar_mobile').hasClass('open')) {
			$('#navbar_mobile').removeClass('open');
		} else {
			$('#navbar_mobile').addClass('open');
			// Set dropdowns as in-active
			$('[target_dropdown].active').removeClass('active');
			// Show main menu
			$('.navbar-nav.mobile_main').removeClass('active');
		}
	});

	$('[dropdown_target]').on('click', function(e) {
		// Get target
		var target = $('[target_dropdown="' + $(e.target).attr('dropdown_target') + '"]');
		// Hide main menu
		$('.navbar-nav.mobile_main').addClass('active');
		// Set target as active
		$(target).addClass('active');
	});

	$('.nav-link.back_to_mobile_main').on('click', function(e) {
		// Set dropdowns as in-active
		$('[target_dropdown].active').removeClass('active');
		// Show main menu
		$('.navbar-nav.mobile_main').removeClass('active');
	});









	if ($('#auth_widget').length > 0) {

		// Create event listener if 3DS has been completed
		window.addEventListener('message', function(e) {
			// Check if message is 3DS done
			if (e.data) {
				if (e.data.type != undefined && e.data.type === 'stripe-3ds-result') {
					// Complete 3D Secure authentication
					complete3DSecure(e.data);
				}
			}
		});

		var setupIntent = '';
		var paymentIntent = '';

		function complete3DSecure(data) {
			// Send to processing
			$('#auth_widget #dd_main').attr('stage', 'processing');
			// Remove iFrame
			$('.dd_3dsecure_iframe iframe').remove();


			// Check if SetupIntent has been the trigger for 3D Secure
			if (typeof data.message.setup_intent == 'object') {
				// Add SetupIntent object to widget data
				setupIntent = data.message.setup_intent.id;
				// Set setup intent to empty
				newPaymentMethodToken = '';
				// Set card token to empty
				newPaymentMethodCard = '';
				// Send widget data back
				return sendDonation();
			}


			// Check if PaymentIntent has been the trigger for 3D Secure
			if (typeof data.message.payment_intent == 'object') {
				// Add PaymentIntent object to widget data
				paymentIntent = data.message.payment_intent.id;
				// Send widget data back
				return sendDonation();
			}


			// Check if there was an error
			if (typeof data.message.error == 'object') {
				// Switch type of error
				switch (data.message.error.code) {
					case 'setup_intent_authentication_failure':
						// Send to error
						sendToDonateError('card');
					break;
					case 'payment_intent_authentication_failure':
						// Send to error
						sendToDonateError('payment');
					break;
					default:
						// As no processable error was received, send to general error stage
						sendToDonateError('general');
					break;
				}
			}
		}

		var formSent = false;

		var submitAuth					= function() {
			// Check if card token needs processed
			if (document.body.contains(document.querySelector('.dd_card_field_hidden')) == false) {
				// Process card details
				createCardToken();
			} else {
				// Submit data to AJAX handler
				sendDonation();
			}
		};

		var newPaymentMethodToken = '';
		var newPaymentMethodCard = '';

		var createCardToken			= function() {
			// Create token for card details
			window.DashDonate.stripe.createToken(window.DashDonate.authForm.stripeCardNumberInput).then(function(result) {
				// Check if there was an error
				if (result.error) {
					// Go back to payment stage
					document.getElementById('dd_main').setAttribute('stage', 'payment');
					// Show error
					displayErrorNotice(document.querySelector('#dd_card').closest('.dd_input_group'), result.error.message, 'dd_card');
					// Allow form to be re-sent
					formSent = false;
				} else {
					// Save token to data
					newPaymentMethodToken = result.token.id;
					// Save card to data
					newPaymentMethodCard = result.token.card.id;
					// Submit data to AJAX handler
					sendDonation();
				}
			});
		};

		var sendToDonateError 		= function(type) {
			// Set stage
			$('#auth_widget #dd_main').attr('stage', 'error_' + type);
		};

		var sendToDonateSuccess 		= function(request) {
			// Send to complete
			$('#auth_widget #dd_main').attr('stage', 'complete');
		};

		var handleAuth 					= function(request) {

			// Parse request
			request = JSON.parse(request);

			console.log(request);

			// Check if the donation was a success
			if (request.success && request.success == true) {
				// Send to success
				return sendToDonateSuccess();
			}


			// Check if there was an error
			if (request.error) {
				// Switch errors
				switch (request.error) {
					case 'invalid_session':
						// Send to error
						sendToDonateError('expired');
					break;
					case 'unauthorised_card':
						// Send to error
						sendToDonateError('card');
					break;
					case 'failed_to_create_customer':
					default:
						// Send to error
						sendToDonateError('general');
					break;
				}
			}


			// Check if there was an intent
			if (request.intent) {
				// Switch intent
				switch (request.intent.object) {
					case 'setup_intent':
						// Create iFrame for authorisation
						var iframe = document.createElement('iframe');
						// Set iFrame attributes
						iframe.src = request.intent.next_action.use_stripe_sdk.stripe_js;
						// Insert iFrame
						document.querySelector('#dd_widget .dd_body_stage[stage="3dsecure_card"] .dd_3dsecure_iframe').appendChild(iframe);
						// Change widget stage
						document.getElementById('dd_main').setAttribute('stage', '3dsecure_card');
					break;
					case 'payment_intent':
						// Create iFrame for authorisation
						var iframe = document.createElement('iframe');
						// Set iFrame attributes
						iframe.src = request.intent.next_action.use_stripe_sdk.stripe_js;
						// Insert iFrame
						document.querySelector('#dd_widget .dd_body_stage[stage="3dsecure_payment"] .dd_3dsecure_iframe').appendChild(iframe);
						// Change widget stage
						document.getElementById('dd_main').setAttribute('stage', '3dsecure_payment');
					break;
				}
				// Prevent further processing
				return;
			}


			// As no processable data was received, send to error
			sendToDonateError('general');

		};

		var sendDonation				= function() {
			// Send auth request for donation
			$.ajax({
				method:			'POST',
				url:			'/ajax/process-off-session-donation-authorise/',
				data:			{
					_token:					$('[name="_token"]').val(),
					task_token:				$('hero[task]').attr('task'),
					pmToken:				newPaymentMethodToken,
					pmCardId:				newPaymentMethodCard,
					setupIntent:			setupIntent,
					paymentIntent:			paymentIntent,
				},
				crossDomain: 	true,
				dataType:		'json',
				success: 		function(data) {
					handleAuth(data);
				},
				error:			function(err) {
					console.log(err);
				}
			});
		};







		$('#auth_widget .submitAuth').on('click', function(e) {
			// Check if form is sent
			if (formSent == false) {
				// Set debounce for form
				formSent = true;
				// Send to processing
				$('#auth_widget #dd_main').attr('stage', 'processing');
				// Submit auth form
				submitAuth();
			}
		});

		$('#auth_widget .dd_btn.dd_back').on('click', function(e) {
			// Set debounce for form
			formSent = false;
			// Send to processing
			$('#auth_widget #dd_main').attr('stage', 'payment');
		});

		$('#auth_widget .dd_replace_saved_card, #auth_widget .dd_use_saved_card').on('click', function(e) {
			// Get saved card container
			var saved_container = document.querySelector('.dd_saved_card_container');
			// Get add card container
			var add_container = document.querySelector('.dd_new_card_container');
			// Check if shown
			if (saved_container.classList.contains('dd_show') == true) {
				// Toggle
				saved_container.classList.remove('dd_show');
				add_container.classList.remove('dd_card_field_hidden');
			} else {
				// Toggle
				saved_container.classList.add('dd_show');
				add_container.classList.add('dd_card_field_hidden');
			}
		});

		var stripeStylesCardNumber = {
			base: {
				color:				'#000000',
				textTransform:		'uppercase',
				fontFamily:			'sans-serif',
				fontSmoothing:		'antialiased',
				fontSize:			'22px',
				'::placeholder':	{
					color:				'#aab7c4',
				},
			},
			invalid: {
				color:				'#fa755a',
				iconColor:			'#fa755a',
			},
		};

		var stripeStylesCVCExpiry = {
			base: {
				color:				'#000000',
				textTransform:		'uppercase',
				textAlign:			'left',
				fontFamily:			'sans-serif',
				fontSmoothing:		'antialiased',
				fontSize:			'14px',
				'::placeholder':	{
					color:				'#aab7c4',
				},
			},
			invalid: {
				color:				'#fa755a',
				iconColor:			'#fa755a',
			},
		};

		var displayErrorNotice			= function(group, message, input_for) {
			// Set group as error
			group.classList.add('dd_error');
			// Check if label exists
			if (document.body.contains(group.querySelector('label[for="' + input_for + '"][label_value]'))) {
				// Change label text to error message
				group.querySelector('label[for="' + input_for + '"][label_value]').innerHTML = message;
			}
		};
		var removeErrorNotice			= function(group, input_for) {
			// Set group as not error
			group.classList.remove('dd_error');
			// Change error message to label text
			group.querySelector('label[for="' + input_for + '"][label_value]').innerHTML = group.querySelector('label[for="' + input_for + '"][label_value]').getAttribute('label_value');
		};
		var removeErrorNotices			= function() {
			// Get all groups
			errors = document.querySelectorAll('.dd_input_group.dd_error');
			// Loop through groups
			for (i = 0; i < errors.length; i++) {
				// Remove '.dd_error' class
				errors[i].classList.remove('dd_error');
				// Check if label exists
				if (document.body.contains(errors[i].querySelector('label[label_value]'))) {
					// Change label text to label text
					errors[i].querySelector('label[label_value]').innerHTML = errors[i].querySelector('label[label_value]').getAttribute('label_value');
				}
			}
		};


		var handleCardNumberInput 		= function(e) {
			// Check if there was an error
			if (e.error) {
				// Display error notice
				displayErrorNotice(document.querySelector('#dd_card').closest('.dd_input_group'), e.error.message, 'dd_card');
			} else {
				// Hide error message
				removeErrorNotice(document.querySelector('#dd_card').closest('.dd_input_group'), 'dd_card');
			}
			// Check if complete
			if (e.complete) {
				// Focus on next input
				document.querySelector('#dd_expiry .__PrivateStripeElement-input').focus();
			}
		};

		var handleCardExpiryInput 		= function(e) {
			// Check if there was an error
			if (e.error) {
				// Display error notice
				displayErrorNotice(document.querySelector('#dd_expiry').closest('.dd_input_group'), e.error.message, 'dd_expiry');
			} else {
				// Hide error message
				removeErrorNotice(document.querySelector('#dd_expiry').closest('.dd_input_group'), 'dd_expiry');
			}
			// Check if complete
			if (e.complete) {
				// Focus on next input
				document.querySelector('#dd_cvc .__PrivateStripeElement-input').focus();
			}
		};

		var handleCardCVCInput 		= function(e) {
			// Check if there was an error
			if (e.error) {
				// Display error message
				displayErrorNotice(document.querySelector('#dd_cvc').closest('.dd_input_group'), e.error.message, 'dd_cvc');
			} else {
				// Hide error message
				removeErrorNotice(document.querySelector('#dd_cvc').closest('.dd_input_group'), 'dd_cvc');
			}
		};

		var handleSocialShare 		= function(e) {
			// Switch which social network to share on
			switch (e.target.closest('.dd_share').getAttribute('site')) {
				case 'facebook':
					// Open Facebook share window
					window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.DashDonate.sharingLink) + '&quote=' + encodeURIComponent(window.DashDonate.sharingPrewritten), 'Share to Facebook', 'height=420,width=600');
				break;
				case 'twitter':
					// Open Twitter share window
					window.open('https://twitter.com/share?url=' + encodeURIComponent(window.DashDonate.sharingLink) + '&text=' + encodeURIComponent(window.DashDonate.sharingPrewritten), 'Share to Twitter', 'height=420,width=600');
				break;
				case 'linkedin':
					// Open LinkedIn share window
					window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(window.DashDonate.sharingLink), 'Share to LinkedIn', 'height=420,width=600');
				break;
				case 'email':
					// Open email client for user
					window.open('mailto:?subject=' + encodeURIComponent(window.DashDonate.sharingSubject) + '&body=' + encodeURIComponent(window.DashDonate.sharingBody), '_blank');
				break;
			}
		};

		$('.dd_share').on('click', handleSocialShare);

		var initStripeForAuth = function() {
			// Create instance of Stripe
			window.DashDonate.stripe = Stripe(window.DashDonate.pk);
			// Create auth form object
			window.DashDonate.authForm = {};
			// Create instance of Stripe Elements
			window.DashDonate.authForm.stripeElements = window.DashDonate.stripe.elements();
			// Create Stripe card element for card number
			window.DashDonate.authForm.stripeCardNumberInput = window.DashDonate.authForm.stripeElements.create('cardNumber', { showIcon: false, style: stripeStylesCardNumber });
			// Mount card number field into the card container
			window.DashDonate.authForm.stripeCardNumberInput.mount(document.getElementById('dd_card'));
			// Create event listener for the card input
			window.DashDonate.authForm.stripeCardNumberInput.addEventListener('change', handleCardNumberInput);
			// Create Stripe card element for expiry
			window.DashDonate.authForm.stripeExpiryInput = window.DashDonate.authForm.stripeElements.create('cardExpiry', { placeholder: 'MM / YY', style: stripeStylesCVCExpiry });
			// Mount expiry field into the card container
			window.DashDonate.authForm.stripeExpiryInput.mount(document.getElementById('dd_expiry'));
			// Create event listener for the expiry input
			window.DashDonate.authForm.stripeExpiryInput.addEventListener('change', handleCardExpiryInput);
			// Create Stripe card element for CVC
			window.DashDonate.authForm.stripeCVCInput = window.DashDonate.authForm.stripeElements.create('cardCvc', { placeholder: '123', style: stripeStylesCVCExpiry });
			// Mount CVC field into the card container
			window.DashDonate.authForm.stripeCVCInput.mount(document.getElementById('dd_cvc'));
			// Create event listener for the CVC input
			window.DashDonate.authForm.stripeCVCInput.addEventListener('change', handleCardCVCInput);
		}

		initStripeForAuth();

	}
























































	// Event listener for deleting scheduled/repeat donations
	$('.cancel_donation_task').on('click', function(e) {
		// Confirm that the user wants to delete the task
		if (confirm('Are you sure you wish to cancel this?')) {
			// Get task token
			var token = $(e.target).attr('task');
			// Get card item
			var card_item = $(e.target).closest('.donation');
			// Prevent re-submission
			$(e.target).attr('disabled', 'disabled');
			// Send AJAX request
			$.ajax({
				method:			'POST',
				url:			'/ajax/cancel-donation-task/',
				data:			{
					_token:			$('[name="_token"]').val(),
					task_token:		token,
				},
				crossDomain: 	true,
				dataType:		'json',
				success: 		function(data) {
					// Check if response was true
					if (data === true) {
						// Delete card item
						$(card_item).remove();
						// Notify user that their task has been deleted
						alert('This has been cancelled successfully.');
					} else {
						console.log(data);
						// Alert that something went wrong
						alert('Something went wrong, please try again.')
						// Enable button for retry
						$(e.target).removeAttr('disabled');
					}
				},
				error:			function(err) {
					console.log(err);
				}
			});
		}
	});




	// Set event listener for clicking on collective inputs (such as multiple choice inputs - compiling all selected values to a single string)
	$('.form_collective').on('click', function(e) {
		// Get collective name
		var collective = $(e.target).attr('collective');
		// Holding value
		var collated_values = [];
		// Get all inputs in the collective
		var items = $('.form_collective[collective="' + collective + '"]');
		// Loop through items
		for (var i = 0; i < items.length; i++) {
			// Check if value has been selected
			if ($(items[i]).is(':checked')) {
				// Add value of item to collated_values array
				collated_values[collated_values.length] = $(items[i]).attr('id').substr(collective.length + 1);
			}
		}
		// Turn collated_values array into string
		collated_values = collated_values.join(', ');
		// Set value of field to that values are collated into
		$('[name="' + collective + '"]').val(collated_values);
	});




	// Set event listener for input on collective inputs (such as date sets - compiling all selected values to a single string)
	$('.form_collective.date-format').on('input, blur', function(e) {
		// Get collective name
		var collective = $(e.target).attr('collective');
		// Holding value
		var collated_values = [];
		// Get all inputs in the collective
		var items = $('.form_collective[collective="' + collective + '"]');
		// Loop through items
		for (var i = 0; i < items.length; i++) {
			// Add value to collated values
			collated_values[collated_values.length] = $(items[i]).val();
		}
		// Turn collated_values array into string
		var date = formatDate(new Date(collated_values[2], (collated_values[1] - 1), collated_values[0]));
		// Set value of field to that values are collated into
		$('[name="' + collective + '"]').val(date);
	});




	// Event listener for charity goals list
	$('.auto_validate_forms').on('submit', function(e) {
		// Check debounce is not set
		if (!debounce) {
			// Set debounce
			debounce = true;
			// Storage variable for form data
			var form_data = {
				form_id:		$(e.target).attr('id'),
				is_valid:		true,
				errors:			[],
			};
			// Get all inputs in the form
			var inputs = $('#' + form_data.form_id).find('[name]');
			// Loop through inputs
			for (var i = 0; i < inputs.length; i++) {
				// Check if not token input
				if ($(inputs[i]).attr('name') != '_token') {
					// Check form validation
					form_data = checkIsValid($(inputs[i]).attr('name'), form_data);
				}
			}
			// Display errors for form
			displayFormErrors(form_data);
			// Check if form is valid
			if (form_data.is_valid === true) {
				// Submit valid form
				return $('#' + form_data.form_id).submit();
			} else {
				// Set debounce
				debounce = false;
			}
		}
		// Prevent form submission
		return e.preventDefault();
	});




	// Delete all form errors
	function resetFormErrors() {
		// Delete all form error messages
		$('.form_error_container p').remove();
	}




	// Display errors for forms
	function displayFormErrors(form_data) {
		// Reset form errors
		resetFormErrors();
		// Check if there are any errors
		if (form_data.errors.length > 0) {
			// Loop through errors
			for (var i = 0; i < form_data.errors.length; i++) {
				// Get error container
				var error_container = $('.form_error_container[field="' + $(form_data.errors[i].input).attr('name') + '"]');
				// Empty error container
				error_container.empty();
				// Add error message
				$(error_container).append('<p>' + form_data.errors[i].error_message + '</p>');
			}
		}
	}




	// Check if input is valid
	function checkIsValid(input, form_data) {
		// Get input
		input = $('[id="' + form_data.form_id + '"] [name="' + input + '"]');
		// Log if input has failed yet
		var failed = false;
		// Capture input requirements
		var requirements = {
			required:		(input.attr('required') == 'required'),
			minlength:		input.attr('minlength'),
			maxlength:		input.attr('maxlength'),
			is_email:		(input.attr('type') == 'email'),
			is_password:	(input.attr('type') == 'password'),
			must_match:		input.attr('must_match'),
			valid_date:		input.attr('valid_date'),
		};


		// Check 'required' requirement
		if (failed === false && requirements.required === true) {
			// Check if the input is empty
			if ($(input).val().trim().length === 0) {
				// Mark field as invalid
				form_data.is_valid = false;
				// Set field as failed
				failed = true;
				// Add error to array
				form_data.errors[form_data.errors.length] = {
					'input':			input,
					'error':			'required',
					'error_message':	'This input cannot be empty.',
				};
			}
		}


		// Check 'maxlength' requirement
		if (failed === false && requirements.must_match != undefined) {
			// Check if the input does not match
			if ($(input).val() != $('#' + form_data.form_id).find('[name="' + requirements.must_match + '"]').val()) {
				// Mark field as invalid
				form_data.is_valid = false;
				// Set field as failed
				failed = true;
				// Add error to array
				form_data.errors[form_data.errors.length] = {
					'input':			input,
					'error':			'must_match',
				};
				// Check if the field is a password field
				if (requirements.is_password === true) {
					// Add error message to array
					form_data.errors[form_data.errors.length - 1].error_message = 'The password you entered does not match.';
				} else {
					// Add error message to array
					form_data.errors[form_data.errors.length - 1].error_message = 'This does not match.';
				}
			}
		}


		// Check 'minlength' requirement
		if (failed === false && requirements.minlength != undefined) {
			// Check if the input is has less than the minimum characters
			if ($(input).val().trim().length < parseInt(requirements.minlength)) {
				// Mark field as invalid
				form_data.is_valid = false;
				// Set field as failed
				failed = true;
				// Add error to array
				form_data.errors[form_data.errors.length] = {
					'input':			input,
					'error':			'minlength',
					'error_message':	'You must enter at least ' + requirements.minlength + ' characters.',
				};
			}
		}


		// Check 'maxlength' requirement
		if (failed === false && requirements.maxlength != undefined) {
			// Check if the input is has more than the maximum characters
			if ($(input).val().trim().length > parseInt(requirements.maxlength)) {
				// Mark field as invalid
				form_data.is_valid = false;
				// Set field as failed
				failed = true;
				// Add error to array
				form_data.errors[form_data.errors.length] = {
					'input':			input,
					'error':			'maxlength',
					'error_message':	'You must enter less than ' + (parseInt(requirements.maxlength) + 1) + ' characters.',
				};
			}
		}


		// Check 'valid_date' requirement
		if (failed === false && requirements.valid_date != undefined) {
			// Holding value
			var collated_values = [];
			// Get all inputs in the collective
			var items = $('.form_collective[collective="' + $(input).attr('name') + '"]');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add value to collated values
				collated_values[collated_values.length] = $(items[i]).val();
			}
			var parsed = new Date(collated_values[2] + '-' + collated_values[1] + '-' + collated_values[0]);
			// Check if day, month and year are not matching
			if (!(parseInt(parsed.getDate()) 	== parseInt(collated_values[0]) &&
			parseInt(parsed.getMonth() + 1) 	== parseInt(collated_values[1]) &&
			parseInt(parsed.getFullYear()) 		== parseInt(collated_values[2]))) {
				// Mark field as invalid
				form_data.is_valid = false;
				// Set field as failed
				failed = true;
				// Add error to array
				form_data.errors[form_data.errors.length] = {
					'input':			input,
					'error':			'valid_date',
					'error_message':	'You must enter a valid date.',
				};
			}
		}


		// Check 'is_email' requirement
		if (failed === false && requirements.is_email === true) {
			// Check if the value is not a valid email address
			if (isValidEmail($(input).val().trim()) === false) {
				// Mark field as invalid
				form_data.is_valid = false;
				// Set field as failed
				failed = true;
				// Add error to array
				form_data.errors[form_data.errors.length] = {
					'input':			input,
					'error':			'is_email',
					'error_message':	'You must enter a valid email address.',
				};
			}
		}


		// Check 'is_password' requirement
		if (failed === false && requirements.is_password === true) {
			// Check if the password is has less than the minimum characters
			if ($(input).val().trim().length < getValidPasswordLength()) {
				// Mark field as invalid
				form_data.is_valid = false;
				// Set field as failed
				failed = true;
				// Add error to array
				form_data.errors[form_data.errors.length] = {
					'input':			input,
					'error':			'is_password',
					'error_message':	'Your password must be at least ' + getValidPasswordLength() + ' characters in length.',
				};
			}
			// Check if the value is not a valid/secure password
			if (failed === false && isValidPassword($(input).val().trim()) === false) {
				// Mark field as invalid
				form_data.is_valid = false;
				// Set field as failed
				failed = true;
				// Add error to array
				form_data.errors[form_data.errors.length] = {
					'input':			input,
					'error':			'is_password',
					'error_message':	'Your password must contain at least one letter and one number.',
				};
			}
		}


		// Return validity of input
		return form_data;
	}




	// Phone number input styling (adding a space)
	$('[type="tel"]').on('input', function(e) {
		// Add space after 4 characters
		e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/, '$1 ').trim();
	});




	// Slug input block non-slug characters
	$('input.slug-input').on('input', function(e) {
		// Remove non-slug characters
		e.target.value = e.target.value.replace(/[^A-Za-z0-9_-]/g, '').toLowerCase();
		console.log(e.target.value);
	});




	// Sort code input styling (adding a dash after every 2)
	$('[name="sort_code"]').on('input', function(e) {
		// Add dash after 2 characters
		e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{2})/g, '$1 ').trim();
	});




	// Limiting values and lengths of inputs
	$('input').on('input', function(e) {
		// Check if limited length is set and oversized
		if ($(e.target).attr('maxlength') != undefined && (e.target.value.length > parseInt($(e.target).attr('maxlength')))) {
			// Trim value
			e.target.value = e.target.value.substring(0, 2);
		}
		// Check if value is under minimum
		if ($(e.target).attr('minvalue') != undefined && (e.target.value < parseInt($(e.target).attr('minvalue'))) && e.target.value != '' && e.target.value != '0') {
			// Trim value
			e.target.value = $(e.target).attr('minvalue');
		}
		// Check if value is over maximum
		if ($(e.target).attr('maxvalue') != undefined && (e.target.value > parseInt($(e.target).attr('maxvalue'))) && e.target.value != '' && e.target.value != '0') {
			// Trim value
			e.target.value = $(e.target).attr('maxvalue');
		}
	});




	// File uploader - on file changed (gets name of file for frontend, doesn't upload)
	$('[type="file"]').on('input', function(e) {
		// Get name
		var file_name = $(e.target).val().replace(/C:\\fakepath\\/i, '');
		// Get error container
		var error_container = $('.form_error_container[field="' + $(e.target).attr('id') + '"]');
		// Empty error container
		error_container.empty();
		// Check if file name was not blank
		if (file_name != '') {
			// Set 'Choose file' to selected file's name
			$(e.target).closest('.custom-file').find('.custom-file-label').text(file_name);
		} else {
			// Set to placeholder
			$(e.target).closest('.custom-file').find('.custom-file-label').text('Choose file');
		}
	});




	// On click of the file uploader submit button
	$('.custom-file .file-submit').on('click', function(e) {
		// Get form container
		var container = $(e.target).closest('.custom-file');
		// Disable file input and submit while processing
		$(container).find('[type="file"]').attr('disabled', 'disabled');
		$(container).find('.file-submit').addClass('disabled');
		// Check if file has been added
		if ($(container).find('[type="file"]').get(0).files == false || $(container).find('[type="file"]').get(0).files.length == 0) {
			// Cancel file upload
			return cancelFileUpload(container, 'You need to select a file to upload.');
		}
		// Get file
		var file_size = $(container).find('[type="file"]')[0].files[0].size;
		// Check file isn't too large (10MB)
		if (file_size > 0 && file_size <= 10000000) {
			// Submit form
			$(container).find('form').submit();
		}
		// Cancel file upload as file is too large
		return processingFileUpload(container, 'Processing upload, please wait...');
	});




	// On form submitting
	$('form.file_upload_form').on('submit', function(e) {
		// Prevent default
		e.preventDefault();
		// Get container
		var container = $(e.target).closest('.custom-file');
		// Perform upload
		sendFileToUploader(this, container, function(container, data) {
			// Collapse uploader
			$(container).closest('.collapsable_file_container').find('.collapsable_file').addClass('collapsed');
			// Show success banner
			$(container).closest('.collapsable_file_container').find('.collapsable_file_removable').removeClass('d-none');
			// Check if this upload is being made on the charity about page - File uploading for the logo
			if ($(container).closest('.collapsable_file_container').hasClass('charity_about_logo_upload')) {
				// Update image on preview page
				updateImageFromUpload(container, data.image, data.path);
			}
			// Refresh file upload check
			checkIfAllFilesUploaded();
		});
	});




	// Function to replace an image with a newly uploaded item
	function updateImageFromUpload(container, file_id, file_path) {
		// Update hidden input with new file ID
		$('[name="charity_logo_id"]').val(file_id);
		// Update preview
		$('.charity_logo_fillable .logo').addClass('filled').css('background-image', 'url("' + s3URL + file_path + '")');
	}




	// Function to send a file via AJAX
	function sendFileToUploader(form, container, callback) {
		// Perform AJAX request
		$.ajax({
			url: 			'/api/file-upload',
			type: 			'POST',
			data: 			new FormData(form),
			contentType: 	false,
			cache: 			false,
			dataType: 		'json',
			processData: 	false,
			success:		function(data) {

				console.log(data);

				if (data.success == true) {

					// Trigger callback
					callback(container, data);

				} else {
					// Return error
					// cancelFileUpload(container, data.error);
				}

			},
			error:	function(err) {
				console.log(err);

				// Return error
				cancelFileUpload(container, JSON.parse(err.responseText));
			}
		});
	}




	// Un-collapse file uploading
	$('.collapsable_file_replace').on('click', function(e) {
		// Uncollapse collapsable file uploader
		$(e.target).closest('.collapsable_file_container').find('.collapsable_file.collapsed').removeClass('collapsed');
		// Remove collapsed "uploaded already" message
		$(e.target).closest('.collapsable_file_container').find('.collapsable_file_removable').addClass('d-none');
		// Empty error container
		$(e.target).closest('.collapsable_file_container').find('.form_error_container').empty();
		// Refresh file upload check
		checkIfAllFilesUploaded();
	});




	// Set event listeners for ID doc inputs
	function checkIfAllFilesUploaded() {
		// Count files that have been added
		var uploaded_files = 0;
		// Get all collapsable input containers
		var containers = $('.collapsable_file_container');
		// Check if containers were found
		if (containers.length > 0) {
			// Loop through containers
			for (var i = 0; i < containers.length; i++) {
				// Check if removable item exists
				if ($(containers[i]).find('.collapsable_file_removable:not(.d-none)').length > 0) {
					// Increment uploaded files
					uploaded_files++;
				}
			}
			// Default form
			var form = $('[type="submit"][form="charities-administration-representative_identity"]');
			// Check which form is being used
			if (form.length == 0) {
				// Set other form
				form = $('[type="submit"][form="charities-administration-collect_registered_address"]');
			}
			// Check if all files have been added
			if (containers.length == uploaded_files) {
				// Enable submit button
				form.removeAttr('disabled');
				// Remove hidden-ness of button
				$('.id_submit_btn').removeClass('d-none');
			} else {
				// Disable submit button
				form.attr('disabled', 'disabled');
				// Hide button
				$('.id_submit_btn').addClass('d-none');
			}
		}
	}
	// Check by default
	checkIfAllFilesUploaded();




	// Cancel file upload method
	function cancelFileUpload(container, reason) {
		// Disable file input and submit while processing
		$(container).find('[type="file"]').removeAttr('disabled');
		$(container).find('.file-submit').removeClass('disabled');
		// Get error container
		var error_container = $('.form_error_container[field="' + $(container).find('[name="file_upload"]').attr('id') + '"]');
		// Empty error container
		error_container.empty();
		// Get success container
		var success_container = $('.form_success_container[field="' + $(container).find('[name="file_upload"]').attr('id') + '"]');
		// Empty success container
		success_container.empty();
		// Check if reason is not empty
		if (reason.length > 0) {
			// Add error message
			$(error_container).append('<p>' + reason + '</p>');
		}
	}




	// Send message that file upload is processing
	function processingFileUpload(container, reason) {
		// Disable file input and submit while processing
		$(container).find('[type="file"]').removeAttr('disabled');
		$(container).find('.file-submit').removeClass('disabled');
		// Get error container
		var error_container = $('.form_error_container[field="' + $(container).find('[name="file_upload"]').attr('id') + '"]');
		// Empty error container
		error_container.empty();
		// Get success container
		var success_container = $('.form_success_container[field="' + $(container).find('[name="file_upload"]').attr('id') + '"]');
		// Empty success container
		success_container.empty();
		// Check if reason is not empty
		if (reason.length > 0) {
			// Add success message
			$(success_container).append('<p>' + reason + '</p>');
		}
	}




	// Format JS Date object into datestamp
	function formatDate(date) {
		var d = new Date(date);
		var month = '' + (d.getMonth() + 1);
		var day = '' + d.getDate();
		var year = d.getFullYear();
		if (month.length < 2) {
			month = '0' + month;
		}
		if (day.length < 2) {
			day = '0' + day;
		}
		return [year, month, day].join('-');
	}




	// Check if value is a valid email address
	function isValidEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}




	// Check if value is a valid and secure password
	function isValidPassword(password) {
		// Minimum eight characters, at least one letter and one number
		var re = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
		return re.test(password);
	}




	// Return the minimum password length for password validation
	function getValidPasswordLength() {
		return 8;
	}




	if ($('.dd_graph_main_data') != null) {
		// Loop through charts
		$('.dd_graph_main_data').each(function() {
			// Get chart
			$(this).graphiq({
				data: chartData[$(this).attr('id')],
				subSet: chartData[$(this).attr('dd_graph_subset')],
				fluidParent: ".dd_graph_main",
				yLines: false,
				xLines: false,
				dots: true,
				dotRadius: 2,
				colorLine: "#1db87f",
				colorDot: "#1db87f",
				colorLabels: "#000000",
				colorUnits: "#000000",
				colorRange: "#000000",
				fill: false,
				height: 100,
			});
		});

		// }, function(e) {
		//    // Check if not the label itself
		//    if ($(e.target).closest('svg').length === 0) {
		// 	   $('.graphiq__value-dialog').remove();
		//    }
		// });

	   $('.dd_dashboard *').hover(function(e) {
		   // console.log($(e.target).closest('.dd_graph').length);
		   // Check if graph
		   if ($(e.target).closest('.dd_graph').length === 0) {
			   $('.graphiq__value-dialog').remove();
		   }
		   // console.log($(e.target).closest('.dd_graph').length);
		   // console.log($(e.target).closest('.dd_graph'));
		   // console.log('x');
	   });
	}




});
