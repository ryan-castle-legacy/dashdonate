(function() {

	function DonationWidget() {
		this.appURL 					= 'http://ec2-0-0-0-0.eu-west-2.compute.amazonaws.com';
		this.canvasSelector 			= '#dd_widget';
		this.canvas 					= document.querySelector(this.canvasSelector);
		this.init 						= function() {
			// Check if wrapper object was create
			if (typeof window.DashDonate !== 'undefined') {
				// Check if API key is set
				if (typeof window.DashDonate.key !== 'undefined') {
					// Chech if canvas element exists
					if (this.canvas) {
						// Start widget session tracking
						this.startSession();
						// Fetch widget from DashDonate.org servers
						return this.fetchWidget();
					}
					// Print error
					return console.error(this.integrationErrors.noCanvasElement);
				}
				// Print error
				return console.error(this.integrationErrors.unsetAPIKey);
			}
			// Print error
			return console.error(this.integrationErrors.incorrectCode);
		};
		this.widget 					= null;
		this.openRequest 				= null;
		this.fetchWidget 				= function() {
			// Create the request
			this.request('/widget/donate', { session: this.session }, this.buildWidget);
		};
		this.request 					= function(target, data, callback) {
			// Create XML HTTP Request
			var request = new XMLHttpRequest();
			// Switch type of request
			switch (target) {
				case '/widget/donate':
					// Open PUT request
					request.open('PUT', this.appURL + target + '/' + window.DashDonate.key);
				break;
				case '/widget/donate/process-payment':
					// Open POST request
					request.open('POST', this.appURL + target);
				break;
			}
			// Log the active request
			this.openRequest = target;
			// Send CSRF token
			request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('[name="_token"]').value);
			// Set request header for sending data
			request.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
			// Send request to target
			request.send(this.encodeRequestBody(data));
			// Listen for response
			request.onreadystatechange = function() {
				// Check if readyState is 4 (done - finished processing)
				if (request.readyState === 4) {
					// Check if the request was successful
					if (request.status === 200) {
						// console.log((request.responseText));
						// Check if response data is a JSON object
						if (JSON.parse(request.responseText)) {
							// Parse response text through callback
							return callback(JSON.parse(request.responseText));
						}
						// Print error
						return console.error(window.DashDonate.DonationWidget.integrationErrors.unknownResponse);
					}
					// Print error
					return console.error(window.DashDonate.DonationWidget.integrationErrors.connectionError);
				}
			}
		};
		this.encodeRequestBody			= function(body) {
			// Encode for data
			return JSON.stringify(body);
		};
		this.buildWidget 				= function(data) {
			// Add session data to session storage object
			window.DashDonate.DonationWidget.session.session = data.session;
			// Fill the canvas with the fetched DOM
			window.DashDonate.DonationWidget.canvas.innerHTML = data.widget;
			// Check if widget is enabled
			if (window.DashDonate.DonationWidget.session.session.enabled === true) {
				// Create event listeners for interactive items
				window.DashDonate.DonationWidget.addEventListeners();
				// Add Stripe script for card element
				window.DashDonate.DonationWidget.addStripeCode();
				// Display fees for donation inputs
				window.DashDonate.DonationWidget.displayCalculatedFees();
				// Set default billing anchor options
				window.DashDonate.DonationWidget.setBillingAnchorOptions();
				// Close function (so error does not get returned)
				return;
			}
			// Print error
			return console.error(window.DashDonate.DonationWidget.integrationErrors.widgetDisabled);
		};
		this.session 					= {};
		this.startSession				= function() {
			// Set start time
			this.session.startDate 			= new Date();
			// Set start time date stamp
			this.session.startDateStamp 	= this.session.startDate.toUTCString();
			// Get referer page (will be blank if direct open)
			this.session.referer 			= document.referrer;
			// Get page title
			this.session.pageTitle 			= document.title;
		};
		this.getDuration				= function(start, end) {
			// Return milliseconds between Date objects
			return end.getTime() - start.getTime();
		};
		this.addEventListeners			= function() {

			// Holding variables
			var items, i;

			// Get all amount suggestion buttons
			items = document.querySelectorAll('.dd_input_group .dd_amount_suggestions .dd_suggestion');
			// Loop through items
			for (i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', function(e) {
					// Remove all existing error notices
					window.DashDonate.DonationWidget.removeErrorNotices();
					// Set value of input
					e.target.closest('.dd_input_group').querySelector('input').value = e.target.getAttribute('value');
					// Update fees for donation inputs
					window.DashDonate.DonationWidget.displayCalculatedFees();
				});
			}


			// Get all amount inputs
			items = document.querySelectorAll('.dd_amount');
			// Loop through items
			for (i = 0; i < items.length; i++) {
				// Add listener functions
				items[i].addEventListener('keydown', window.DashDonate.DonationWidget.amountInputKeydown);
				items[i].addEventListener('input', window.DashDonate.DonationWidget.amountInputHandle);
				items[i].addEventListener('change', window.DashDonate.DonationWidget.displayCalculatedFees);
				items[i].addEventListener('keydown', window.DashDonate.DonationWidget.displayCalculatedFees);
				items[i].addEventListener('input', window.DashDonate.DonationWidget.displayCalculatedFees);
			}


			// Get all buttons
			items = document.querySelectorAll('.dd_btn');
			// Loop through items
			for (i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', window.DashDonate.DonationWidget.handleClick);
			}


			// Get all multi-option inputs
			items = document.querySelectorAll('.dd_multi');
			// Loop through items
			for (i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', window.DashDonate.DonationWidget.handleMultiOption);
			}


			// Get all multi-option (with multi-select available) inputs
			items = document.querySelectorAll('.dd_multi_select');
			// Loop through items
			for (i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', window.DashDonate.DonationWidget.handleMultiOptionMultiple);
			}


			// Get all social share buttons
			items = document.querySelectorAll('.dd_share');
			// Loop through items
			for (i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', window.DashDonate.DonationWidget.handleSocialShare);
			}


			// Get all togglers
			items = document.querySelectorAll('.dd_toggler');
			// Loop through items
			for (i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', window.DashDonate.DonationWidget.handleToggleGroup);
			}


			// Get all togglers
			items = document.querySelectorAll('.dd_replace_saved_card, .dd_use_saved_card');
			// Loop through items
			for (i = 0; i < items.length; i++) {
				// Check if exists
				if (typeof items[i] != 'undefined' && items[i].length != false) {
					// Add listener function
					items[i].addEventListener('click', window.DashDonate.DonationWidget.handleReplaceSavedCardInputs);
				}
			}


			// Get select box with id '#dd_repeat_duration'
			var items = document.getElementById('dd_repeat_duration');
			// Add listener function
			items.addEventListener('change', window.DashDonate.DonationWidget.setBillingAnchorOptions);


			// Get all inputs in the date collective
			var items = document.querySelectorAll('.dd_date[collective]');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listeners function
				items[i].addEventListener('input', window.DashDonate.DonationWidget.handleScheduledDateInput);
				items[i].addEventListener('change', window.DashDonate.DonationWidget.handleScheduledDateInput);
				items[i].addEventListener('blur', window.DashDonate.DonationWidget.handleScheduledDateInput);
			}


			// Get all refresh buttons
			var items = document.querySelectorAll('.dd_refresh_page');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listener to refresh page
				items[i].addEventListener('click', function() {
					// Refresh page
					window.location.reload();
				});
			}


		};
		this.handleScheduledDateInput				= function(e) {
			// Check if limited length is set and oversized
			if (e.target.getAttribute('maxlength') != undefined && e.target.value.length > parseInt(e.target.getAttribute('maxlength'))) {
				// Trim value
				e.target.value = e.target.value.substring(0, 2);
			}
			// Check if value is under minimum
			if (e.target.getAttribute('minvalue') != undefined && e.target.value < parseInt(e.target.getAttribute('minvalue')) && e.target.value != '' && e.target.value != '0') {
				// Trim value
				e.target.value = e.preventDefault();
			}
			// Check if value is over maximum
			if (e.target.getAttribute('maxvalue') != undefined && e.target.value > parseInt(e.target.getAttribute('maxvalue')) && e.target.value != '' && e.target.value != '0') {
				// Trim value
				e.target.value = e.preventDefault();
			}
			// Get collective name
			var collective = e.target.getAttribute('collective');
			// Holding value
			var collated_values = [];
			// Get all inputs in the collective
			var inputs = document.querySelectorAll('.dd_date[collective="' + collective + '"]');
			// Loop through items
			for (var i = 0; i < inputs.length; i++) {
				// Add value to collated values
				collated_values[collated_values.length] = inputs[i].value;
			}
			// Turn collated_values array into string
			var date = window.DashDonate.DonationWidget.formatDate(new Date(collated_values[2], (collated_values[1] - 1), collated_values[0]));
			// Set value of field to that values are collated into
			document.querySelector('[name="' + collective + '"]').value = date;
			// Check if date is 29th Feb
			if (parseInt(collated_values[0]) == '29' && parseInt(collated_values[1]) == '2') {
				// Uncheck the toggle
				document.getElementById('dd_annual').setAttribute('toggled', false);
				// Disable toggle switch
				document.getElementById('dd_annual').classList.add('disabled');
			} else {
				// Enable toggle switch
				document.getElementById('dd_annual').classList.remove('disabled');
			}
		};
		this.formatDate						= function(date) {
			var date = new Date(date);
			var month = '' + (date.getMonth() + 1);
			var day = '' + date.getDate();
			var year = date.getFullYear();
			if (month.length < 2) {
				month = '0' + month;
			}
			if (day.length < 2) {
				day = '0' + day;
			}
			return [year, month, day].join('-');
		};
		this.handleReplaceSavedCardInputs	= function(e) {
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
		};
		this.displayCalculatedFees			= function(e) {
			// Capture amount from input
			var amount = parseFloat(document.querySelector('#dd_amount_now').value);
			// Convert amount to pence
			var amount_pence = parseInt(amount * 100);
			// Calculate minimum fees
			var fees_pence = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'normal').totalFees;
			// Check if fees_pence is a valid number
			if (!isNaN(fees_pence)) {
				// Set fee text in GBP
				document.querySelector('.dd_pay_fees_now_amount').innerHTML = (fees_pence / 100).toFixed(2);
			} else {
				// Set fee and empty
				document.querySelector('.dd_pay_fees_now_amount').innerHTML = '0.00';
			}


			// Capture amount from input
			var amount = parseFloat(document.querySelector('#dd_amount_schedule').value);
			// Convert amount to pence
			var amount_pence = parseInt(amount * 100);
			// Calculate minimum fees
			var fees_pence = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'normal').totalFees;
			// Check if fees_pence is a valid number
			if (!isNaN(fees_pence)) {
				// Set fee text in GBP
				document.querySelector('.dd_pay_fees_scheduled_amount').innerHTML = (fees_pence / 100).toFixed(2);
			} else {
				// Set fee and empty
				document.querySelector('.dd_pay_fees_scheduled_amount').innerHTML = '0.00';
			}


			// Capture amount from input
			var amount = parseFloat(document.querySelector('#dd_amount_repeating').value);
			// Convert amount to pence
			var amount_pence = parseInt(amount * 100);
			// Calculate minimum fees
			var fees_pence = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'normal').totalFees;
			// Check if fees_pence is a valid number
			if (!isNaN(fees_pence)) {
				// Set fee text in GBP
				document.querySelector('.dd_pay_fees_repeating_amount').innerHTML = (fees_pence / 100).toFixed(2);
			} else {
				// Set fee and empty
				document.querySelector('.dd_pay_fees_repeating_amount').innerHTML = '0.00';
			}


			// Capture amount from input
			var amount = parseFloat(document.querySelector('#dd_amount_now_personalised').value);
			// Convert amount to pence
			var amount_pence = parseInt(amount * 100);
			// Calculate minimum fees
			var fees_pence = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'normal').totalFees;
			// Check if fees_pence is a valid number
			if (!isNaN(fees_pence)) {
				// Set fee text in GBP
				document.querySelector('.dd_pay_fees_personalise_now_amount').innerHTML = (fees_pence / 100).toFixed(2);
			} else {
				// Set fee and empty
				document.querySelector('.dd_pay_fees_personalise_now_amount').innerHTML = '0.00';
			}
		};
		this.handleToggleGroup			= function(e) {
			// Get group
			var group = e.target.closest('.dd_toggle_group');
			// Check if toggled
			if (group.getAttribute('toggled') == 'true') {
				// Toggle
				group.setAttribute('toggled', false);
			} else {
				// Toggle
				group.setAttribute('toggled', true);
			}
		};
		this.handleSocialShare			= function(e) {
			// Switch which social network to share on
			switch (e.target.closest('.dd_share').getAttribute('site')) {
				case 'facebook':
					// Open Facebook share window
					window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.DashDonate.DonationWidget.session.session.sharingLink) + '&quote=' + encodeURIComponent(window.DashDonate.DonationWidget.session.session.sharingPrewritten), 'Share to Facebook', 'height=420,width=600');
				break;
				case 'twitter':
					// Open Twitter share window
					window.open('https://twitter.com/share?url=' + encodeURIComponent(window.DashDonate.DonationWidget.session.session.sharingLink) + '&text=' + encodeURIComponent(window.DashDonate.DonationWidget.session.session.sharingPrewritten), 'Share to Twitter', 'height=420,width=600');
				break;
				case 'linkedin':
					// Open LinkedIn share window
					window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(window.DashDonate.DonationWidget.session.session.sharingLink), 'Share to LinkedIn', 'height=420,width=600');
				break;
				case 'email':
					// Open email client for user
					window.open('mailto:?subject=' + encodeURIComponent(window.DashDonate.DonationWidget.session.session.sharingSubject) + '&body=' + encodeURIComponent(window.DashDonate.DonationWidget.session.session.sharingBody), '_blank');
				break;
			}
		},
		this.amountInputKeydown			= function(e) {
			// Check if non-numeric or non-functional
			if (e.which != 8 &&
				e.key != '0' &&
				e.key != '1' &&
				e.key != '2' &&
				e.key != '3' &&
				e.key != '4' &&
				e.key != '5' &&
				e.key != '6' &&
				e.key != '7' &&
				e.key != '8' &&
				e.key != '9' &&
				e.key != '.' &&
				e.key != 'ArrowUp' &&
				e.key != 'ArrowDown' &&
				e.key != 'ArrowLeft' &&
				e.key != 'ArrowRight') {
				// Stop insert
				e.preventDefault();
			}
			// Check if trying to add more than one decimal point
			if (e.key == '.' && e.target.value.indexOf('.') != -1) {
				// Stop insert
				e.preventDefault();
			}
		};
		this.amountInputHandle			= function(e) {
			// Check if there are decimal places
			if ((parseFloat(e.target.value) * 1) % 1 != 0) {
				// Check if there is more than 2 decimal places
				if ((e.target.value.substring(e.target.value.indexOf('.') + 1)).length > 2) {
					// Round to 2 dp
					e.target.value = parseFloat(e.target.value.replace(/[^0-9.]/g, '')).toFixed(2);
				}
			}
		};
		this.handleClick				= function(e) {
			// Check if button is '.dd_next' (moves to the next stage)
			if (e.target.classList.contains('dd_next')) {
				// Progress to the next stage
				window.DashDonate.DonationWidget.progressToNextStage();
			}

			// Check if button is '.dd_back' (moves to the previous stage)
			if (e.target.classList.contains('dd_back')) {
				// Go back to the previous stage
				window.DashDonate.DonationWidget.returnToPreviousStage();
			}

			// Check if button is '.dd_personalise' (moves to the personalisation options stage)
			if (e.target.classList.contains('dd_personalise')) {
				// Go to the personalisation options stage
				window.DashDonate.DonationWidget.goToPersonaliseStage();
			}
		};
		this.handleMultiOption				= function(e) {
			// Check if not selected already
			if (!e.target.closest('.dd_multi_option').classList.contains('dd_selected')) {
				// Remove currently selected item
				e.target.closest('.dd_multi').querySelector('.dd_selected').classList.remove('dd_selected');
				// Set as selected
				e.target.closest('.dd_multi_option').classList.add('dd_selected');
			}
		};
		this.handleMultiOptionMultiple		= function(e) {
			// Check if user clicked option
			if (document.body.contains(e.target.closest('.dd_multi_option'))) {
				// Check if not selected already
				if (!e.target.closest('.dd_multi_option').classList.contains('dd_selected')) {
					// Set as selected
					e.target.closest('.dd_multi_option').classList.add('dd_selected');
				} else {
					// Set as not selected
					e.target.closest('.dd_multi_option').classList.remove('dd_selected');
				}
				// Check if the stage is the personalisation options stage
				if (document.getElementById('dd_main').getAttribute('stage') == 'personalise') {
					// Count the number of selected options
					var selected_options = document.querySelectorAll('.dd_body_stage[stage="personalise"] .dd_multi_option.dd_selected').length;
					// Check if options are selected
					if (selected_options > 0) {
						// Enable button
						document.getElementById('dd_personalise').classList.remove('disabled');
					} else {
						// Disable button
						document.getElementById('dd_personalise').classList.add('disabled');
					}
				}
			}
		};
		this.toggleContributionOptions	= function(toggle) {
			// Get options
			var options = document.querySelectorAll('.dd_contribution');
			// Loop through options
			for (var i = 0; i < options.length; i++) {
				// Check if toggle is true (show)
				if (toggle === true) {
					// Show the contribution options
					options[i].classList.add('show');
				} else {
					// Hide the contribution options
					options[i].classList.remove('show');
				}
			}
		},
		this.getBillingAnchorOptions 	= function(frequency) {
			// Holding var
			var options = [];
			// Switch frequency
			switch (frequency) {
				case 'weeks':
					options[options.length] = { name: 'week-0', 		label: 'Sundays' };
					options[options.length] = { name: 'week-1', 		label: 'Mondays' };
					options[options.length] = { name: 'week-2', 		label: 'Tuesdays' };
					options[options.length] = { name: 'week-3', 		label: 'Wednesdays' };
					options[options.length] = { name: 'week-4', 		label: 'Thursdays' };
					options[options.length] = { name: 'week-5', 		label: 'Fridays' };
					options[options.length] = { name: 'week-6', 		label: 'Saturdays' };
				break;
				case 'months':
					options[options.length] = { name: 'month-1', 		label: 'the 1st of the month' };
					options[options.length] = { name: 'month-2', 		label: 'the 2nd of the month' };
					options[options.length] = { name: 'month-3', 		label: 'the 3rd of the month' };
					options[options.length] = { name: 'month-4', 		label: 'the 4th of the month' };
					options[options.length] = { name: 'month-5', 		label: 'the 5th of the month' };
					options[options.length] = { name: 'month-6', 		label: 'the 6th of the month' };
					options[options.length] = { name: 'month-7', 		label: 'the 7th of the month' };
					options[options.length] = { name: 'month-8', 		label: 'the 8th of the month' };
					options[options.length] = { name: 'month-9', 		label: 'the 9th of the month' };
					options[options.length] = { name: 'month-10', 		label: 'the 10th of the month' };
					options[options.length] = { name: 'month-11', 		label: 'the 11th of the month' };
					options[options.length] = { name: 'month-12', 		label: 'the 12th of the month' };
					options[options.length] = { name: 'month-13', 		label: 'the 13th of the month' };
					options[options.length] = { name: 'month-14', 		label: 'the 14th of the month' };
					options[options.length] = { name: 'month-15', 		label: 'the 15th of the month' };
					options[options.length] = { name: 'month-16', 		label: 'the 16th of the month' };
					options[options.length] = { name: 'month-17', 		label: 'the 17th of the month' };
					options[options.length] = { name: 'month-18', 		label: 'the 18th of the month' };
					options[options.length] = { name: 'month-19', 		label: 'the 19th of the month' };
					options[options.length] = { name: 'month-20', 		label: 'the 20th of the month' };
					options[options.length] = { name: 'month-21', 		label: 'the 21st of the month' };
					options[options.length] = { name: 'month-22', 		label: 'the 22nd of the month' };
					options[options.length] = { name: 'month-23', 		label: 'the 23rd of the month' };
					options[options.length] = { name: 'month-24', 		label: 'the 24th of the month' };
					options[options.length] = { name: 'month-25', 		label: 'the 25th of the month' };
					options[options.length] = { name: 'month-26', 		label: 'the 26th of the month' };
					options[options.length] = { name: 'month-27', 		label: 'the 27th of the month' };
					options[options.length] = { name: 'month-28', 		label: 'the 28th of the month' };
					options[options.length] = { name: 'month-last', 	label: 'the last day of the month' };
				break;
			}
			// Return options
			return options;
		},
		this.getBillingAnchorLabel 		= function(name, frequency) {
			// Get options
			var options = window.DashDonate.DonationWidget.getBillingAnchorOptions(frequency);
			// Loop through options
			for (var i = 0; i < options.length; i++) {
				// Check if option's name matches with param
				if (options[i].name == name) {
					// Return label
					return options[i].label;
				}
			}
		},
		this.setBillingAnchorOptions 	= function() {
			// Get value for frequency
			var frequency = document.getElementById('dd_repeat_duration').value;
			// Get options
			var options = window.DashDonate.DonationWidget.getBillingAnchorOptions(frequency);
			// Clear values in input
			document.getElementById('dd_repeat_anchor').innerHTML = '';
			// Filler variable
			var opt = null;
			// Loop through options
			for (var i = 0; i < options.length; i++) {
				// Insert new values
				opt = document.createElement('option');
				// Add select value
				opt.value = options[i].name;
				// Add select text
				opt.innerHTML = options[i].label;
				// Append to options list
				document.getElementById('dd_repeat_anchor').appendChild(opt);
			}
		},
		this.goToPersonaliseStage		= function() {
			// Remove all existing error notices
			window.DashDonate.DonationWidget.removeErrorNotices();
			// Set the stage to move to
			document.getElementById('dd_main').setAttribute('stage', 'personalise');
		};
		this.progressToNextStage		= function() {
			// Set current stage as default
			var stage = document.getElementById('dd_main').getAttribute('stage');
			// Remove all existing error notices
			window.DashDonate.DonationWidget.removeErrorNotices();
			// // Switch action for the current stage
			switch (stage) {
				case 'cover':
					// Capture amount from input
					var amount = parseFloat(document.querySelector('#dd_amount_now').value);
					// Check if amount input is filled and is not too low
					if (amount >= window.DashDonate.DonationWidget.session.session.minimumDonation) {
						// Set next stage
						stage = 'upsell';
					} else {
						// Show error
						window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_amount_now').closest('.dd_input_group'), 'Your donation must be at least £' + window.DashDonate.DonationWidget.session.session.minimumDonation.toFixed(2) + '.', 'dd_amount_now');
					}
				break;
				case 'upsell':
					// Set next stage
					stage = 'giftaid';
				break;
				case 'giftaid':
					// Set next stage
					stage = 'payment';
				break;
				case 'personalise':
					// Count the number of selected options
					var selected_options = document.querySelectorAll('.dd_body_stage[stage="personalise"] .dd_multi_option.dd_selected').length;
					// Check if options are selected
					if (selected_options > 0) {
						// Check if scheduled is selected
						if (document.querySelectorAll('.dd_multi_option[value="schedule"].dd_selected').length > 0) {
							// Set next stage as scheduling of donation
							stage = 'personalise_schedule';
						} else {
							// Set next stage as setup of repeating donation
							stage = 'personalise_repeat';
						}
						// Enable button
						document.getElementById('dd_personalise').classList.remove('disabled');
					}
				break;
				case 'personalise_schedule':
					// Holding variables
					var valid = true;
					// Remove errors
					window.DashDonate.DonationWidget.removeErrorNotices();


					// Capture amount from input
					var amount = parseFloat(document.querySelector('#dd_amount_schedule').value);
					// Check if amount input is filled and is not too low
					if (amount < window.DashDonate.DonationWidget.session.session.minimumDonation) {
						// Invalidate form
						valid = false;
						// Show error
						window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_amount_schedule').closest('.dd_input_group'), 'Your donation must be at least £' + window.DashDonate.DonationWidget.session.session.minimumDonation.toFixed(2) + '.', 'dd_amount_schedule');
					}


					// Get date input
					var date = document.querySelector('#dd_date_schedule').value;
					// Check if input is not blank
					if (date != '') {
						// Holding value for date values
						var collated_values = [];
						// Get all inputs in the collective
						var inputs = document.querySelectorAll('.dd_date[collective="dd_date_schedule"]');
						// Loop through items
						for (var i = 0; i < inputs.length; i++) {
							// Add value to collated values
							collated_values[collated_values.length] = inputs[i].value;
						}
						// Check if date is 29th Feb
						if (parseInt(collated_values[0]) == '29' && parseInt(collated_values[1]) == '2') {
							// Uncheck the toggle
							document.getElementById('dd_annual').setAttribute('toggled', false);
							// Disable toggle switch
							document.getElementById('dd_annual').classList.add('disabled');
						} else {
							// Enable toggle switch
							document.getElementById('dd_annual').classList.remove('disabled');
						}
						// Parse date
						var parsed = new Date(collated_values[2] + '-' + collated_values[1] + '-' + collated_values[0]);
						// Check if not valid
						if (isNaN(parsed.getTime())) {
							// Parse with params
							parsed = new Date(collated_values[2], collated_values[1] - 1, collated_values[0]);
						}
						// Check if day, month and year are not matching
						if (!(parseInt(parsed.getDate()) 	== parseInt(collated_values[0]) &&
						parseInt(parsed.getMonth() + 1) 	== parseInt(collated_values[1]) &&
						parseInt(parsed.getFullYear()) 		== parseInt(collated_values[2]))) {
							// Show error
							window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_date_schedule').closest('.dd_input_group'), 'You must enter a valid date.', 'dd_date_schedule-day');
							// Set is valid to false
							valid = false;
						} else {
							// Check if date is today or in the past
							if (parsed <= new Date(new Date().toDateString())) {
								// Show error
								window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_date_schedule').closest('.dd_input_group'), 'You must enter a valid date in the future.', 'dd_date_schedule-day');
								// Set is valid to false
								valid = false;
							}
							// Check if date is within the next 2 years
							if (parsed > (new Date()).setFullYear(new Date().getFullYear() + 2)) {
								// Show error
								window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_date_schedule').closest('.dd_input_group'), 'Please enter a date within the next 2 years.', 'dd_date_schedule-day');
								// Set is valid to false
								valid = false;
							}
						}
					} else {
						// Invalidate form
						valid = false;
						// Show error
						window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_date_schedule').closest('.dd_input_group'), 'You must enter a valid date.', 'dd_date_schedule-day');
					}
					// Check if valid
					if (valid) {
						// Check if repeat option is selected
						if (document.querySelectorAll('.dd_multi_option[value="repeating"].dd_selected').length > 0) {
							// Set next stage as setup of repeating donation
							stage = 'personalise_repeat';
						} else {
							// Set next stage as setup of repeating donation
							stage = 'personalise_now';
						}
					}
				break;
				case 'personalise_repeat':
					// Holding variables
					var valid = true;
					// Remove errors
					window.DashDonate.DonationWidget.removeErrorNotices();


					// Capture amount from input
					var amount = parseFloat(document.querySelector('#dd_amount_repeating').value);
					// Check if amount input is filled and is not too low
					if (amount < window.DashDonate.DonationWidget.session.session.minimumDonation) {
						// Invalidate form
						valid = false;
						// Show error
						window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_amount_repeating').closest('.dd_input_group'), 'Your donation must be at least £' + window.DashDonate.DonationWidget.session.session.minimumDonation.toFixed(2) + '.', 'dd_amount_repeating');
					}


					// Get interval input's value
					var interval = parseInt(document.getElementById('dd_repeat_interval').value);
					// Get duration input's value
					var duration = document.getElementById('dd_repeat_duration').value;
					// Get anchor input's value
					var anchor = document.getElementById('dd_repeat_anchor').value;
					// Check interval is 0
					if (interval == 0) {
						// Show error
						window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_repeat_interval').closest('.dd_input_group'), 'The donation frequency must be at least 1.', 'dd_repeat_interval');
						// Set is valid to false
						valid = false;
					} else {
						// Switch duration
						switch (duration) {
							case 'weeks':
								// Check if interval is over 52 weeks
								if (interval > 52) {
									// Show error
									window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_repeat_interval').closest('.dd_input_group'), 'The donation must be more regular (limit of 52 weeks).');
									// Set is valid to false
									valid = false;
								}
							break;
							case 'months':
								// Check if interval is over 12 months
								if (interval > 12) {
									// Show error
									window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_repeat_interval').closest('.dd_input_group'), 'The donation must be more regular (limit of 12 months).');
									// Set is valid to false
									valid = false;
								}
							break;
						}
					}
					// Check if valid
					if (valid) {
						// Set next stage as setup of repeating donation
						stage = 'personalise_now';
					}
				break;
				case 'personalise_now':
					// Capture amount from input
					var amount = parseFloat(document.querySelector('#dd_amount_now_personalised').value);
					// Check if amount input is empty or is not too low
					if (amount === 0.00 || amount >= window.DashDonate.DonationWidget.session.session.minimumDonation) {
						// Set next stage
						stage = 'giftaid';
					} else {
						// Show error
						window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_amount_now_personalised').closest('.dd_input_group'), 'Your donation must be at least £' + window.DashDonate.DonationWidget.session.session.minimumDonation.toFixed(2) + '.', 'dd_amount_now_personalised');
					}
				break;
				case 'payment':
					// Holding variables
					var valid = true;


					// Get email address input
					var emailInput = document.querySelector('#dd_email[type="email"]');
					// Check if email input needs checked
					if (document.body.contains(emailInput)) {
						// Check if email is not valid
						if (window.DashDonate.DonationWidget.isValidEmailAddress(emailInput.value) == false) {
							// Invalidate form
							valid = false;
							// Show error
							window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_email').closest('.dd_input_group'), 'You must enter a valid email address.', 'dd_email');
						}
					}


					// Check if valid
					if (valid) {
						// Get data from the widget inputs
						window.DashDonate.DonationWidget.getWidgetData();
						// Set data on confirm page
						window.DashDonate.DonationWidget.setConfirmPage();
						// Set next stage
						stage = 'confirm';
					}
				break;
				case 'confirm':
					// Set next stage
					stage = 'processing';
					// Submit for processing
					window.DashDonate.DonationWidget.submitDonation();
				break;
			}
			// Set the stage to move to
			document.getElementById('dd_main').setAttribute('stage', stage);
		};
		this.returnToPreviousStage		= function() {
			// Set current stage as default
			var stage = document.getElementById('dd_main').getAttribute('stage');
			// // Switch action for the current stage
			switch (stage) {
				case 'upsell':
				case 'personalise':
					// Set previous stage
					stage = 'cover';
				break;
				case 'giftaid':
					// Check if personalised options are selected
					if (document.querySelectorAll('.dd_multi_option[value="repeating"].dd_selected').length > 0 || document.querySelectorAll('.dd_multi_option[value="schedule"].dd_selected').length > 0) {
						// Set previous stage
						stage = 'personalise_now';
					} else {
						// Set previous stage
						stage = 'cover';
					}
				break;
				case 'payment':
					// Set previous stage
					stage = 'giftaid';
				break;
				case 'personalise_schedule':
					// Set previous stage
					stage = 'personalise';
				break;
				case 'personalise_repeat':
					// Check if scheduled option is selected
					if (document.querySelectorAll('.dd_multi_option[value="schedule"].dd_selected').length > 0) {
						// Set previous stage
						stage = 'personalise_schedule';
					} else {
						// Set previous stage
						stage = 'personalise';
					}
				break;
				case 'personalise_now':
					// Check if repeat option is selected
					if (document.querySelectorAll('.dd_multi_option[value="repeating"].dd_selected').length > 0) {
						// Set previous stage
						stage = 'personalise_repeat';
					} else {
						// Set previous stage
						stage = 'personalise_schedule';
					}
				break;
				case 'confirm':
					// Set previous stage
					stage = 'payment';
				break;
				case 'error_general':
				case 'error_card':
				case 'error_payment':
					// Set previous stage
					stage = 'confirm';
				break;
			}
			// Set the stage to move to
			document.getElementById('dd_main').setAttribute('stage', stage);
		};
		this.isValidEmailAddress		= function(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(email).toLowerCase());
		};
		this.setConfirmPage				= function() {
			// Counter for how many items are on this stage
			var counter = 0;
			// Holding variables
			var amount_pence, fees, keypoint_string, keypoint_date;
			// Remove visibility of details keypoints
			document.querySelector('.dd_confirm_keypoint[keypoint="pay_now"]').classList.remove('dd_show');
			document.querySelector('.dd_confirm_keypoint[keypoint="scheduled"]').classList.remove('dd_show');
			document.querySelector('.dd_confirm_keypoint[keypoint="repeating"]').classList.remove('dd_show');
			// Check if scheduled or repeat donations are set
			if (window.DashDonate.DonationWidget.widgetData.personaliseScheduled == true ||
			window.DashDonate.DonationWidget.widgetData.personaliseRepeating == true) {

				// Set confirm details for donation now
				if (window.DashDonate.DonationWidget.widgetData.personaliseNow == true) {
					// Add to counter
					counter += 1;
					// Get amount now and convert amount to pence
					amount_pence = parseInt(parseFloat(window.DashDonate.DonationWidget.widgetData.personaliseNowAmount) * 100);

					// Check if fees are paid by donor or not
					if (window.DashDonate.DonationWidget.widgetData.personaliseNowPayFees == true) {
						// Calculate fees
						fees = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'normal');
					} else {
						// Calculate fees
						fees = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'none');
					}

					// Set text for pay now details
					document.querySelector('.dd_confirm_keypoint[keypoint="pay_now"] span.dd_confirm_item').innerHTML = '£' + (fees.totalCharge / 100).toFixed(2) + ' to pay now';

					// Check if fees are paid by donor or not
					if (window.DashDonate.DonationWidget.widgetData.personaliseNowPayFees == true) {
						// Set text for pay now breakdown
						document.querySelector('.dd_confirm_keypoint[keypoint="pay_now"] span:not(.dd_confirm_item)').innerHTML = '£' + (fees.originalAmount / 100).toFixed(2) + ' donation + £' + (fees.totalFees / 100).toFixed(2) + ' to cover fees';
					} else {
						// Set text for pay now breakdown
						document.querySelector('.dd_confirm_keypoint[keypoint="pay_now"] span:not(.dd_confirm_item)').innerHTML = '£' + (fees.originalAmount / 100).toFixed(2) + ' donation (fees paid by charity)';
					}

					// Display keypoint
					document.querySelector('.dd_confirm_keypoint[keypoint="pay_now"]').classList.add('dd_show');
				}


				// Set confirm details for scheduled donation
				if (window.DashDonate.DonationWidget.widgetData.personaliseScheduled == true) {
					// Add to counter
					counter += 1;
					// Get amount now and convert amount to pence
					amount_pence = parseInt(parseFloat(window.DashDonate.DonationWidget.widgetData.scheduledAmount) * 100);

					// Check if fees are paid by donor or not
					if (window.DashDonate.DonationWidget.widgetData.scheduledPayFees == true) {
						// Calculate fees
						fees = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'normal');
					} else {
						// Calculate fees
						fees = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'none');
					}

					// Create amount string
					keypoint_string = '£' + (fees.totalCharge / 100).toFixed(2) + ' to pay on the ';
					// Parse scheduled date string to Date object
					keypoint_date = new Date(window.DashDonate.DonationWidget.widgetData.scheduledDate);
					// Check if set for every year
					if (window.DashDonate.DonationWidget.widgetData.scheduledAnnual == true) {
						// Create date string
						keypoint_string += window.DashDonate.DonationWidget.dateSuffix(keypoint_date.getDate()) + ' ' + keypoint_date.toLocaleString('default', { month: 'short' }) + ' every year';
					} else {
						// Create date string
						keypoint_string += window.DashDonate.DonationWidget.dateSuffix(keypoint_date.getDate()) + ' ' + keypoint_date.toLocaleString('default', { month: 'short' }) + ' ' + keypoint_date.getFullYear();
					}
					// Set text for scheduled details
					document.querySelector('.dd_confirm_keypoint[keypoint="scheduled"] span.dd_confirm_item').innerHTML = keypoint_string;

					// Check if fees are paid by donor or not
					if (window.DashDonate.DonationWidget.widgetData.scheduledPayFees == true) {
						// Set text for pay now breakdown
						document.querySelector('.dd_confirm_keypoint[keypoint="scheduled"] span:not(.dd_confirm_item)').innerHTML = '£' + (fees.originalAmount / 100).toFixed(2) + ' donation + £' + (fees.totalFees / 100).toFixed(2) + ' to cover fees';
					} else {
						// Set text for pay now breakdown
						document.querySelector('.dd_confirm_keypoint[keypoint="scheduled"] span:not(.dd_confirm_item)').innerHTML = '£' + (fees.originalAmount / 100).toFixed(2) + ' donation (fees paid by charity)';
					}

					// Display keypoint
					document.querySelector('.dd_confirm_keypoint[keypoint="scheduled"]').classList.add('dd_show');
				}


				// Set confirm details for repeating donation
				if (window.DashDonate.DonationWidget.widgetData.personaliseRepeating == true) {
					// Add to counter
					counter += 1;
					// Get amount now and convert amount to pence
					amount_pence = parseInt(parseFloat(window.DashDonate.DonationWidget.widgetData.repeatingAmount) * 100);

					// Check if fees are paid by donor or not
					if (window.DashDonate.DonationWidget.widgetData.repeatingPayFees == true) {
						// Calculate fees
						fees = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'normal');
					} else {
						// Calculate fees
						fees = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'none');
					}

					// Create amount string
					keypoint_string = '£' + (fees.totalCharge / 100).toFixed(2) + ' to pay every ';
					// Check if interval is multiple
					if (parseInt(window.DashDonate.DonationWidget.widgetData.repeatingInterval) === 1) {
						// Create singular duration string
						keypoint_string += window.DashDonate.DonationWidget.widgetData.repeatingDuration.substring(0, window.DashDonate.DonationWidget.widgetData.repeatingDuration.length - 1);
					} else {
						// Create multiple duration string
						keypoint_string += window.DashDonate.DonationWidget.widgetData.repeatingInterval + ' ' + window.DashDonate.DonationWidget.widgetData.repeatingDuration
					}
					// Add anchor to string
					keypoint_string += ' on ' + window.DashDonate.DonationWidget.getBillingAnchorLabel(window.DashDonate.DonationWidget.widgetData.repeatingAnchor, window.DashDonate.DonationWidget.widgetData.repeatingDuration);
					// Set text for pay now details
					document.querySelector('.dd_confirm_keypoint[keypoint="repeating"] span.dd_confirm_item').innerHTML = keypoint_string;

					// Check if fees are paid by donor or not
					if (window.DashDonate.DonationWidget.widgetData.repeatingPayFees == true) {
						// Set text for repeating breakdown
						document.querySelector('.dd_confirm_keypoint[keypoint="repeating"] span:not(.dd_confirm_item)').innerHTML = '£' + (fees.originalAmount / 100).toFixed(2) + ' donation + £' + (fees.totalFees / 100).toFixed(2) + ' to cover fees';
					} else {
						// Set text for repeating breakdown
						document.querySelector('.dd_confirm_keypoint[keypoint="repeating"] span:not(.dd_confirm_item)').innerHTML = '£' + (fees.originalAmount / 100).toFixed(2) + ' donation (fees paid by charity)';
					}

					// Display keypoint
					document.querySelector('.dd_confirm_keypoint[keypoint="repeating"]').classList.add('dd_show');
				}

			} else {
				// Add to counter
				counter += 1;
				// Get amount now and convert amount to pence
				amount_pence = parseInt(parseFloat(window.DashDonate.DonationWidget.widgetData.coverAmount) * 100);

				// Check if fees are paid by donor or not
				if (window.DashDonate.DonationWidget.widgetData.coverPayFees == true) {
					// Calculate fees
					fees = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'normal');
				} else {
					// Calculate fees
					fees = window.DashDonate.DonationWidget.calculateFeesPence(amount_pence, 'none');
				}

				// Set text for pay now details
				document.querySelector('.dd_confirm_keypoint[keypoint="pay_now"] span.dd_confirm_item').innerHTML = '£' + (fees.totalCharge / 100).toFixed(2) + ' to pay now';

				// Check if fees are paid by donor or not
				if (window.DashDonate.DonationWidget.widgetData.coverPayFees == true) {
					// Set text for pay now breakdown
					document.querySelector('.dd_confirm_keypoint[keypoint="pay_now"] span:not(.dd_confirm_item)').innerHTML = '£' + (fees.originalAmount / 100).toFixed(2) + ' donation + £' + (fees.totalFees / 100).toFixed(2) + ' to cover fees';
				} else {
					// Set text for pay now breakdown
					document.querySelector('.dd_confirm_keypoint[keypoint="pay_now"] span:not(.dd_confirm_item)').innerHTML = '£' + (fees.originalAmount / 100).toFixed(2) + ' donation (fees paid by charity)';
				}

				// Display keypoint
				document.querySelector('.dd_confirm_keypoint[keypoint="pay_now"]').classList.add('dd_show');
			}


			// Check if counter is just 1 item
			if (counter === 1) {
				// Set singular text
				document.querySelector('.dd_body_stage[stage="confirm"] h1 span').innerHTML = '';
			} else {
				// Set pleural text
				document.querySelector('.dd_body_stage[stage="confirm"] h1 span').innerHTML = 's';
			}
		};
		this.dateSuffix					= function(i) {
			var j = i % 10, k = i % 100;
			if (j == 1 && k != 11) {
		        return i + "st";
		    }
		    if (j == 2 && k != 12) {
		        return i + "nd";
		    }
		    if (j == 3 && k != 13) {
		        return i + "rd";
		    }
		    return i + "th";
		};
		this.sendToDonateSuccess		= function() {
			// Set stage
			document.getElementById('dd_main').setAttribute('stage', 'complete');
		};
		this.sendToDonateError			= function(type) {
			// Set stage
			document.getElementById('dd_main').setAttribute('stage', 'error_' + type);
		};
		this.getWidgetData				= function() {
			// Data storage object
			var data = {
				// Get session data
				session: 		window.DashDonate.DonationWidget.session,

				// Get amount from cover stage
				coverAmount:				document.getElementById('dd_amount_now').value,
				// Check whether the donor wants to add fees onto their donation
				coverPayFees:				(document.getElementById('dd_pay_fees_now').getAttribute('toggled') == 'true'),


				// Check if scheduled donation is selected
				personaliseScheduled:		(document.querySelector('.dd_multi_option[value="schedule"]').classList.contains('dd_selected') == true),
				// Get scheduled amount
				scheduledAmount:			document.getElementById('dd_amount_schedule').value,
				// Get scheduled date
				scheduledDate:				document.getElementById('dd_date_schedule').value,
				// Check whether to make the donation every year
				scheduledAnnual:			(document.getElementById('dd_annual').getAttribute('toggled') == 'true'),
				// Check whether the donor wants to add fees onto their donation
				scheduledPayFees:			(document.getElementById('dd_pay_fees_scheduled').getAttribute('toggled') == 'true'),
				// Check whether the donor wants a reminder email
				scheduledNotify:			(document.getElementById('dd_notif_scheduled').getAttribute('toggled') == 'true'),


				// Check if repeating donation is selected
				personaliseRepeating:		(document.querySelector('.dd_multi_option[value="repeating"]').classList.contains('dd_selected') == true),
				// Get repeating amount
				repeatingAmount:			document.getElementById('dd_amount_repeating').value,
				// Get repeat interval
				repeatingInterval:			document.getElementById('dd_repeat_interval').value,
				// Get repeat duration
				repeatingDuration:			document.getElementById('dd_repeat_duration').value,
				// Get repeat anchor
				repeatingAnchor:			document.getElementById('dd_repeat_anchor').value,
				// Check whether the donor wants to add fees onto their donation
				repeatingPayFees:			(document.getElementById('dd_pay_fees_repeating').getAttribute('toggled') == 'true'),
				// Check whether the donor wants a reminder email
				repeatingNotify:			(document.getElementById('dd_notif_repeating').getAttribute('toggled') == 'true'),


				// Check whether the donor wants to give now
				personaliseNow:				(parseFloat(document.getElementById('dd_amount_now_personalised').value) >= window.DashDonate.DonationWidget.session.session.minimumDonation),
				// Get amount from personalise_now stage
				personaliseNowAmount:		document.getElementById('dd_amount_now_personalised').value,
				// Check whether the donor wants to add fees onto their donation
				personaliseNowPayFees:		(document.getElementById('dd_pay_fees_personalise_now').getAttribute('toggled') == 'true'),


				// Check if Gift Aid will be claimed
				giftAid:					document.body.contains(document.querySelector('#dd_giftaid_toggle .dd_multi_option[value="claim"].dd_selected')),


				// Check if user wants to use the saved payment method
				usingSavedPaymentMethod:	document.body.contains(document.querySelector('.dd_body_stage[stage="payment"] .dd_card_field_hidden')),


				// Get user email address value
				emailAddress:				document.getElementById('dd_email').value,


				// Get SetupIntent data
				SetupIntent:				window.DashDonate.DonationWidget.SetupIntent,
				// Get PaymentIntent data
				PaymentIntent:				window.DashDonate.DonationWidget.PaymentIntent,
			};
			// Set data object
			window.DashDonate.DonationWidget.widgetData = data;
		};
		this.PaymentIntent 				= false;
		this.SetupIntent 				= false;
		this.widgetData 				= null;
		this.submitDonation				= function() {
			// Check if card token needs processed
			if (window.DashDonate.DonationWidget.widgetData.usingSavedPaymentMethod == false) {
				// Process card details
				window.DashDonate.DonationWidget.createCardToken();
			} else {
				// Submit data to AJAX handler
				window.DashDonate.DonationWidget.sendDonation();
			}
		};
		this.createCardToken			= function() {
			// Create token for card details
			window.DashDonate.DonationWidget.stripe.createToken(window.DashDonate.DonationWidget.stripeCardNumberInput).then(function(result) {
				// Check if there was an error
				if (result.error) {
					// Go back to payment stage
					document.getElementById('dd_main').setAttribute('stage', 'payment');
					// Show error
					window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_card').closest('.dd_input_group'), result.error.message, 'dd_card');
				} else {
					// Save token to data
					window.DashDonate.DonationWidget.widgetData.newPaymentMethodToken = result.token.id;
					// Save card to data
					window.DashDonate.DonationWidget.widgetData.newPaymentMethodCard = result.token.card.id;
					// Submit data to AJAX handler
					window.DashDonate.DonationWidget.sendDonation();
				}
			});
		};
		this.sendDonation				= function() {
			// Send the request to process payment
			this.request('/widget/donate/process-payment', window.DashDonate.DonationWidget.widgetData, window.DashDonate.DonationWidget.handlePaymentProcessing);
		};
		this.handlePaymentProcessing	= function(request) {


			// Check if the donation was a success
			if (request.success && request.success == true) {
				// Send to success
				return window.DashDonate.DonationWidget.sendToDonateSuccess();
			}


			// Check if there was an error
			if (request.error) {
				// Switch errors
				switch (request.error) {
					case 'invalid_session':
						// Send to error
						window.DashDonate.DonationWidget.sendToDonateError('expired');
					break;
					case 'unauthorised_card':
						// Send to error
						window.DashDonate.DonationWidget.sendToDonateError('card');
					break;
					case 'failed_to_create_customer':
					default:
						// Send to error
						window.DashDonate.DonationWidget.sendToDonateError('general');
					break;
				}
			}


			// Check if there was an intent
			if (request.intent) {
				// Switch intent
				switch (request.intent.type) {
					case 'SetupIntent':
						// Create iFrame for authorisation
						var iframe = document.createElement('iframe');
						// Set iFrame attributes
						iframe.src = request.intent.data.next_action.use_stripe_sdk.stripe_js;
						// Insert iFrame
						document.querySelector('#dd_widget .dd_body_stage[stage="3dsecure_card"] .dd_3dsecure_iframe').appendChild(iframe);
						// Change widget stage
						document.getElementById('dd_main').setAttribute('stage', '3dsecure_card');
					break;
					case 'PaymentIntent':
						// Create iFrame for authorisation
						var iframe = document.createElement('iframe');
						// Set iFrame attributes
						iframe.src = request.intent.data.intent.next_action.use_stripe_sdk.stripe_js;
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
			window.DashDonate.DonationWidget.sendToDonateError('general');
		};
		this.process3DSecureResult		= function(data) {
			// Send to processing stage
			document.getElementById('dd_main').setAttribute('stage', 'processing');
			// Get iFrame
			var iFrame = document.querySelector('#dd_widget .dd_body_stage .dd_3dsecure_iframe iframe');
			// Delete iFrame from 3D Secure stage
			iFrame.parentNode.removeChild(iFrame);


			// Check if SetupIntent has been the trigger for 3D Secure
			if (typeof data.message.setup_intent == 'object') {
				// Add SetupIntent object to widget data
				window.DashDonate.DonationWidget.SetupIntent = data.message.setup_intent;
				// Get data from the widget inputs
				window.DashDonate.DonationWidget.getWidgetData();
				// Send widget data back
				return this.sendDonation();
			}


			// Check if PaymentIntent has been the trigger for 3D Secure
			if (typeof data.message.payment_intent == 'object') {
				// Add PaymentIntent object to widget data
				window.DashDonate.DonationWidget.PaymentIntent = data.message.payment_intent;
				// Get data from the widget inputs
				window.DashDonate.DonationWidget.getWidgetData();
				// Send widget data back
				return this.sendDonation();
			}


			// Check if there was an error
			if (typeof data.message.error == 'object') {
				// Switch type of error
				switch (data.message.error.code) {
					case 'setup_intent_authentication_failure':
						// Send to error
						window.DashDonate.DonationWidget.sendToDonateError('card');
					break;
					case 'payment_intent_authentication_failure':
						// Send to error
						window.DashDonate.DonationWidget.sendToDonateError('payment');
					break;
					default:
						// As no processable error was received, send to general error stage
						window.DashDonate.DonationWidget.sendToDonateError('general');
					break;
				}
			}
		};
		this.calculateFeesPence			= function(amount, type) {
			// Get fee formula object (to trim the following code)
			var feeFormula = window.DashDonate.DonationWidget.session.session.feeFormula;
			// Ensure fee formula items are not parsed as strings
			feeFormula.percentageStripe = parseFloat(feeFormula.percentageStripe);
			feeFormula.percentageDD 	= parseFloat(feeFormula.percentageDD);
			feeFormula.penceStripe 		= parseInt(feeFormula.penceStripe);
			feeFormula.penceDD 			= parseInt(feeFormula.penceDD);
			// Empty object for amounts data
			var data = {
				originalAmount:		parseInt(amount),
				totalCharge:		0,
				totalFees:			0,
				totalToCharity:		0,
				totalToStripe:		0,
				totalToDD:			0,
			};
			// Switch type of calculation
			switch (type) {
				case 'none':
					data.totalToStripe 	= Math.ceil((data.originalAmount + (data.originalAmount * feeFormula.percentageStripe) + feeFormula.penceStripe) - data.originalAmount);
					data.totalToDD 		= Math.ceil((data.originalAmount + (data.originalAmount * feeFormula.percentageDD) + feeFormula.penceDD) - data.originalAmount);
					data.totalToCharity = (data.originalAmount - (data.totalToStripe + data.totalToDD));
					data.totalCharge 	= data.totalToCharity + data.totalToStripe + data.totalToDD;
					data.totalFees 		= 0;
				break;
				case 'normal':
					data.totalToStripe 	= Math.ceil((data.originalAmount + feeFormula.penceStripe) / (1 - feeFormula.percentageStripe)) - data.originalAmount;
					data.totalToDD 		= Math.ceil((data.originalAmount + feeFormula.penceDD) / (1 - feeFormula.percentageDD)) - data.originalAmount;
					data.totalToCharity = data.originalAmount;
					data.totalCharge 	= data.totalToCharity + data.totalToStripe + data.totalToDD;
					data.totalFees 		= data.totalCharge - data.originalAmount;
				break;
			}
			// Return amounts data
			return data;
		};
		this.displayErrorNotice			= function(group, message, input_for) {
			// Set group as error
			group.classList.add('dd_error');
			// Check if label exists
			if (document.body.contains(group.querySelector('label[for="' + input_for + '"][label_value]'))) {
				// Change label text to error message
				group.querySelector('label[for="' + input_for + '"][label_value]').innerHTML = message;
			}
		};
		this.removeErrorNotice			= function(group, input_for) {
			// Set group as not error
			group.classList.remove('dd_error');
			// Change error message to label text
			group.querySelector('label[for="' + input_for + '"][label_value]').innerHTML = group.querySelector('label[for="' + input_for + '"][label_value]').getAttribute('label_value');
		};
		this.removeErrorNotices			= function() {
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
		this.isStripeLoaded				= false;
		this.addStripeCode				= function() {
			// Create script
			var script = document.createElement('script');
			// Set script source
			script.setAttribute('src', window.DashDonate.DonationWidget.session.session.stripeSDK);
			// Add script to body
			document.body.appendChild(script);
			// Set listener for the script being loaded
			script.addEventListener('load', window.DashDonate.DonationWidget.initialiseStripe());
		};
		this.stripe 					= null;
		this.stripeElements				= null;
		this.stripeCardNumberInput		= null;
		this.stripeCVCInput				= null;
		this.stripeExpiryInput			= null;
		this.initialiseStripeTimeout 	= null;
		this.initialiseStripe 			= function() {
			// Check that Stripe has not already been loaded
			if (window.DashDonate.DonationWidget.isStripeLoaded == false) {
				// Check if the Stripe object has been created
				if (typeof Stripe != 'undefined') {
					// Create instance of Stripe
					window.DashDonate.DonationWidget.stripe = Stripe(window.DashDonate.DonationWidget.session.session.stripePublicKey);
					// Create instance of Stripe Elements
					window.DashDonate.DonationWidget.stripeElements = window.DashDonate.DonationWidget.stripe.elements();
					// Create Stripe card element for card number
					window.DashDonate.DonationWidget.stripeCardNumberInput = window.DashDonate.DonationWidget.stripeElements.create('cardNumber', { showIcon: false, style: window.DashDonate.DonationWidget.session.session.stripeStyles });
					// Mount card number field into the card container
					window.DashDonate.DonationWidget.stripeCardNumberInput.mount(document.getElementById('dd_card'));
					// Create event listener for the card input
					window.DashDonate.DonationWidget.stripeCardNumberInput.addEventListener('change', window.DashDonate.DonationWidget.handleCardNumberInput);
					// Create Stripe card element for expiry
					window.DashDonate.DonationWidget.stripeExpiryInput = window.DashDonate.DonationWidget.stripeElements.create('cardExpiry', { placeholder: 'MM / YY', style: window.DashDonate.DonationWidget.session.session.stripeStylesCVCExpiry });
					// Mount expiry field into the card container
					window.DashDonate.DonationWidget.stripeExpiryInput.mount(document.getElementById('dd_expiry'));
					// Create event listener for the expiry input
					window.DashDonate.DonationWidget.stripeExpiryInput.addEventListener('change', window.DashDonate.DonationWidget.handleCardExpiryInput);
					// Create Stripe card element for CVC
					window.DashDonate.DonationWidget.stripeCVCInput = window.DashDonate.DonationWidget.stripeElements.create('cardCvc', { placeholder: '123', style: window.DashDonate.DonationWidget.session.session.stripeStylesCVCExpiry });
					// Mount CVC field into the card container
					window.DashDonate.DonationWidget.stripeCVCInput.mount(document.getElementById('dd_cvc'));
					// Create event listener for the CVC input
					window.DashDonate.DonationWidget.stripeCVCInput.addEventListener('change', window.DashDonate.DonationWidget.handleCardCVCInput);
					// Set Stripe as loaded
					window.DashDonate.DonationWidget.isStripeLoaded = true;
				} else {
					// Set a timeout to allow Stripe to load
					window.DashDonate.DonationWidget.initialiseStripeTimeout = setTimeout(function() {
						// Retry initialisation
						window.DashDonate.DonationWidget.initialiseStripe();
					}, 250);
				}
			}
		};
		this.handleCardNumberInput 		= function(e) {
			// Check if there was an error
			if (e.error) {
				// Display error notice
				window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_card').closest('.dd_input_group'), e.error.message, 'dd_card');
			} else {
				// Hide error message
				window.DashDonate.DonationWidget.removeErrorNotice(document.querySelector('#dd_card').closest('.dd_input_group'), 'dd_card');
			}
			// Check if complete
			if (e.complete) {
				// Focus on next input
				document.querySelector('#dd_expiry .__PrivateStripeElement-input').focus();
			}
		};
		this.handleCardExpiryInput 		= function(e) {
			// Check if there was an error
			if (e.error) {
				// Display error notice
				window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_expiry').closest('.dd_input_group'), e.error.message, 'dd_expiry');
			} else {
				// Hide error message
				window.DashDonate.DonationWidget.removeErrorNotice(document.querySelector('#dd_expiry').closest('.dd_input_group'), 'dd_expiry');
			}
			// Check if complete
			if (e.complete) {
				// Focus on next input
				document.querySelector('#dd_cvc .__PrivateStripeElement-input').focus();
			}
		};
		this.handleCardCVCInput 		= function(e) {
			// Check if there was an error
			if (e.error) {
				// Display error message
				window.DashDonate.DonationWidget.displayErrorNotice(document.querySelector('#dd_cvc').closest('.dd_input_group'), e.error.message, 'dd_cvc');
			} else {
				// Hide error message
				window.DashDonate.DonationWidget.removeErrorNotice(document.querySelector('#dd_cvc').closest('.dd_input_group'), 'dd_cvc');
			}
		};
		// Object that contains all errors that the developer can encounter when integrating the widget
		this.integrationErrors 			= {
			incorrectCode: 		'You have not inserted the correct code for this integration. Please see the documentation for guidance - https://dashdonate.org/docs/donation-widget#getting-started',
			unsetAPIKey: 		'You have not set an API key. Please see the documentation for guidance - https://dashdonate.org/docs/donation-widget#getting-started',
			noCanvasElement: 	'You have not inserted the appropriate DOM element for this integration. Please see the documentation for guidance - https://dashdonate.org/docs/donation-widget#getting-started',
			connectionError: 	'Your integration is having trouble connecting to our servers. Please see the documentation for guidance - https://dashdonate.org/docs/donation-widget#connection-errors',
			unknownResponse: 	'Your integration is having trouble receiving data from our servers. Please see the documentation for guidance - https://dashdonate.org/docs/donation-widget#connection-errors',
			widgetDisabled: 	'Your integration is not enabled. Please see the documentation for guidance - https://dashdonate.org/docs/donation-widget#activate-your-integration',
		};
		// Initialise object
		this.init();
	}


	// Delay until script loaded
	document.addEventListener('DOMContentLoaded', function() {
		// Create donation form object
		window.DashDonate.DonationWidget = new DonationWidget();
	});


	// Create event listener if 3D Secure has been completed
	window.addEventListener('message', function(e) {
		// Check if message has data
		if (e.data) {
			// Check if message is completion of 3D Secure
			if (e.data.type != undefined && e.data.type === 'stripe-3ds-result') {
				// Complete 3D Secure authorisation
				window.DashDonate.DonationWidget.process3DSecureResult(e.data);
			}
		}
	});


})();
