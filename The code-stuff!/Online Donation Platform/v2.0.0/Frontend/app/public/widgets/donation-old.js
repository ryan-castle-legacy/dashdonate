(function() {

	function DonationForm() {
		this.app_url		= 'http://ec2-0-0-0-0.eu-west-2.compute.amazonaws.com';
		this.minDonation 	= null;
		this.prefilEmail	= '';
		this.stripe 		= null;
		this.stripeElements	= null;
		this.stripe_url		= 'https://js.stripe.com/v3/';
		this.stripe_key		= null;
		this.stripeInitLoop	= null;
		this.stripeCard 	= null;
		this.stripeCardContainer = null;
		this.donationIntentId = null;
		this.setupIntentId = null;
		this.stripeStyles	= {
			base: {
				color: '#000000',
				fontFamily: '"Open Sans", sans-serif',
				fontSmoothing: 'antialiased',
				fontSize: '14px',
				'::placeholder': {
					color: '#aab7c4'
				}
			},
			invalid: {
				color: '#fa755a',
				iconColor: '#fa755a'
			}
		};
		this.form_selector 	= '#dd_donation_form';
		this.canvas			= document.querySelector(this.form_selector);
		this.init			= function() {
			if (this.canvas) { this.getWidget(); }
		};
		this.widget			= null;
		this.widgetError	= false;
		this.widgetHeadHeight = 0;
		this.getWidget		= function() {
			// Check if site ID is set
			if (window.DashDonate.site) {
				// Check if prefil email is set and not empty
				if (window.DashDonate.donor_email && window.DashDonate.donor_email != '') {
					// Set prefit email address
					this.prefilEmail = window.DashDonate.donor_email;
				}
				// Create XML HTTP Request
				var xhr = new XMLHttpRequest();
				xhr.open('GET', this.app_url + '/widget/donation/' + window.DashDonate.site + '/' + this.prefilEmail);
				xhr.send();
				xhr.onreadystatechange = function() {
					if (xhr.readyState === 4) { // Ready status 4 means that the request is done
						if (xhr.status === 200) { // Status 200 is a success status
							window.DashDonate.donationForm.widget = JSON.parse(xhr.responseText); // This is the returned text
							window.DashDonate.donationForm.buildWidget(); // Build widget
						} else {
							window.DashDonate.donationForm.widgetError = {
								status: 	xhr.status,
								message:	xhr.responseText,
							};
						}
					}
				};
			}
		},
		this.buildWidget = function() {
			this.canvas.innerHTML = this.widget.html;
			// Check if widget is disabled
			if (document.querySelector('#dd_donation_form_main').getAttribute('stage') == 'disabled') {
				// Stop loading as widget is disabled
				return;
			}
			this.addEventListeners();
			this.setBillingAnchorOptions();
			this.fee_string	= document.getElementById('dd_fee_calc').value;
			this.minDonation = document.getElementById('dd_min_don').value;
			this.stripe_key	= document.querySelector('#dd_donation_form_main').getAttribute('pk');
			this.donationIntentId	= document.querySelector('#dd_donation_form_main').getAttribute('pi');
			this.stripeCardContainer = document.getElementById('dd_donation_form_card');
		},
		this.addEventListeners = function() {

			// Get all buttons with the class '.dd_next_stage'
			var items = document.querySelectorAll('.dd_next_stage');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', window.DashDonate.donationForm.goToNextStage);
			}


			// Get all buttons with the class '.dd_more_options'
			var items = document.querySelectorAll('.dd_more_options');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', function() {
					// Set checkbox to true
					window.DashDonate.donationForm.setMonthly();
					// Go to next stage
					window.DashDonate.donationForm.goToNextStage();
				});
			}


			// Get all buttons with the class '.dd_amount_suggestion'
			var items = document.querySelectorAll('.dd_amount_suggestion');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', function(e) {
					// Set value of amount input to suggestion
					document.querySelector('[name="donation_amount"]').value = e.target.getAttribute('value');
				});
			}


			// Get the '#dd_make_scheduled' checkbox
			var items = document.getElementById('dd_make_scheduled');
			// Add listener function
			items.addEventListener('click', function(e) {
				// Check whether to checked
				if (e.target.checked) {
					// Set checkbox to true
					window.DashDonate.donationForm.setScheduled();
				} else {
					// Set checkbox to true
					window.DashDonate.donationForm.setNotScheduled();
				}
			});


			// Get the '#dd_make_regular' checkbox
			var items = document.getElementById('dd_make_regular');
			// Add listener function
			items.addEventListener('click', function(e) {
				// Check whether to checked
				if (e.target.checked) {
					// Set checkbox to true
					window.DashDonate.donationForm.setRepeating();
				} else {
					// Set checkbox to true
					window.DashDonate.donationForm.setNotRepeating();
				}
			});


			// Get all buttons with the class '.dd_prev_stage'
			var items = document.querySelectorAll('.dd_prev_stage');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('click', window.DashDonate.donationForm.goToPreviousStage);
			}


			// Get checkbox with id '#dd_turn_off_notifications'
			var items = document.getElementById('dd_turn_off_notifications');
			// Add listener function
			items.addEventListener('click', window.DashDonate.donationForm.toggleDonationNotifications);


			// Get all inputs with validation rules
			var items = document.querySelectorAll('.dd_input_validate');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('input', function(e) {

					// Check if limited length is set and oversized
					if (e.target.getAttribute('maxlength') != undefined && e.target.value.length > parseInt(e.target.getAttribute('maxlength'))) {
						// Trim value
						e.target.value = e.target.value.substring(0, 2);
					}
					// Check if value is under minimum
					if (e.target.getAttribute('minvalue') != undefined && e.target.value < parseInt(e.target.getAttribute('minvalue')) && e.target.value != '' && e.target.value != '0') {
						// Trim value
						// e.target.value = e.target.getAttribute('minvalue');
						e.target.value = e.preventDefault();

					}
					// Check if value is over maximum
					if (e.target.getAttribute('maxvalue') != undefined && e.target.value > parseInt(e.target.getAttribute('maxvalue')) && e.target.value != '' && e.target.value != '0') {
						// Trim value
						// e.target.value = e.target.getAttribute('maxvalue');
						e.target.value = e.preventDefault();
					}
				});
			}


			// Get all inputs in the date collective
			var items = document.querySelectorAll('.date-format[collective]');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('input', function(e) {
					// Get collective name
					var collective = e.target.getAttribute('collective');
					// Holding value
					var collated_values = [];
					// Get all inputs in the collective
					var inputs = document.querySelectorAll('.date-format[collective="' + collective + '"]');
					// Loop through items
					for (var i = 0; i < inputs.length; i++) {
						// Add value to collated values
						collated_values[collated_values.length] = inputs[i].value;
					}
					// Turn collated_values array into string
					var date = window.DashDonate.donationForm.formatDate(new Date(collated_values[2], (collated_values[1] - 1), collated_values[0]));
					// Set value of field to that values are collated into
					document.querySelector('[name="' + collective + '"]').value = date;
				});
				// Add listener function
				items[i].addEventListener('blur', function(e) {
					// Get collective name
					var collective = e.target.getAttribute('collective');
					// Holding value
					var collated_values = [];
					// Get all inputs in the collective
					var inputs = document.querySelectorAll('.date-format[collective="' + collective + '"]');
					// Loop through items
					for (var i = 0; i < inputs.length; i++) {
						// Add value to collated values
						collated_values[collated_values.length] = inputs[i].value;
					}
					// Turn collated_values array into string
					var date = window.DashDonate.donationForm.formatDate(new Date(collated_values[2], (collated_values[1] - 1), collated_values[0]));
					// Set value of field to that values are collated into
					document.querySelector('[name="' + collective + '"]').value = date;
				});
			}


			// Get select box with id '#repeat_anchor'
			var items = document.getElementById('repeat_duration');
			// Add listener function
			items.addEventListener('change', window.DashDonate.donationForm.setBillingAnchorOptions);


			// Force donation inputs to be number only
			var items = document.querySelectorAll('.dd_amount_group input');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('input', function(e) {
					// Remove anything that should not be in the field
					e.target.value = e.target.value.replace(/[^0-9.]/g, '');
					// Check if there are decimal places
					if ((parseFloat(e.target.value) * 1) % 1 != 0) {
						// Check if there is more than 2 decimal places
						if ((e.target.value.substring(e.target.value.indexOf('.') + 1)).length > 2) {
							// Round to 2 dp
							e.target.value = parseFloat(e.target.value.replace(/[^0-9.]/g, '')).toFixed(2);
						}
					}
				});
			}


			// Force date inputs to be number only
			var items = document.querySelectorAll('#dd_donation_form input.date-format');
			// Loop through items
			for (var i = 0; i < items.length; i++) {
				// Add listener function
				items[i].addEventListener('keyup', function(e) {
					// Replace value with numeric only
					e.target.value = e.target.value.replace(/[^0-9]/g, '');
				});
			}


		},
		this.setBillingAnchorOptions = function() {
			// Get value for frequency
			var frequency = document.getElementById('repeat_duration').value;
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
			// Clear values in input
			document.getElementById('repeat_anchor').innerHTML = '';
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
				document.getElementById('repeat_anchor').appendChild(opt);
			}
		},
		this.formatDate = function(date) {
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
		},
		this.isValidEmail = function(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		    return re.test(String(email).toLowerCase());
		},
		this.calculateFeesPage = function() {
			// Holding variable
			var amount;


			// Check whether to display fees for fee_field 'now'
			if (window.DashDonate.donationForm.payToday) {
				// Get amount
				amount = parseFloat(document.querySelector('#dd_donation_form_main [name="donation_amount_now"]').value);
				// Set fees on tickbox in fee stage
				document.querySelector('.dd_fee_pay_option[fee_field="now"] .dd_donation_form_stage_fees_add').innerHTML = window.DashDonate.donationForm.calculateFees(amount);
				// Show input field
				document.querySelector('.dd_fee_pay_option[fee_field="now"]').classList.remove('hidden');
			} else {
				// Hide input field
				document.querySelector('.dd_fee_pay_option[fee_field="now"]').classList.add('hidden');
			}


			// Check whether to display fees for fee_field 'scheduled'
			if (window.DashDonate.donationForm.scheduleFuture) {
				// Get amount
				amount = parseFloat(document.querySelector('#dd_donation_form_main [name="scheduled_donation_amount"]').value);
				// Set fees on tickbox in fee stage
				document.querySelector('.dd_fee_pay_option[fee_field="scheduled"] .dd_donation_form_stage_fees_add').innerHTML = window.DashDonate.donationForm.calculateFees(amount);
				// Show input field
				document.querySelector('.dd_fee_pay_option[fee_field="scheduled"]').classList.remove('hidden');
			} else {
				// Hide input field
				document.querySelector('.dd_fee_pay_option[fee_field="scheduled"]').classList.add('hidden');
			}


			// Check whether to display fees for fee_field 'repeat'
			if (window.DashDonate.donationForm.setRepeat) {
				// Get amount
				amount = parseFloat(document.querySelector('#dd_donation_form_main [name="repeat_donation_amount"]').value);
				// Set fees on tickbox in fee stage
				document.querySelector('.dd_fee_pay_option[fee_field="repeat"] .dd_donation_form_stage_fees_add').innerHTML = window.DashDonate.donationForm.calculateFees(amount);
				// Show input field
				document.querySelector('.dd_fee_pay_option[fee_field="repeat"]').classList.remove('hidden');
			} else {
				// Hide input field
				document.querySelector('.dd_fee_pay_option[fee_field="repeat"]').classList.add('hidden');
			}



			// fee_field='now'
			// fee_field='scheduled'
			// fee_field='repeat'

			// toggleAddFees()

			// // Get checkbox with id '#dd_pay_fees'
			// var toggle = document.getElementById('dd_pay_fees');
			// // Check if toggle is checked
			// if (toggle.checked) {
			// 	// Get fees
			// 	var fees = parseFloat(window.DashDonate.donationForm.calculateFees(amount));
			// 	// Set button total donation
			// 	// document.querySelector('.dd_donation_form_stage_fees_button_num').innerHTML = (parseFloat(amount + fees)).toFixed(2);
			// } else {
			// 	// Set button total donation
			// 	// document.querySelector('.dd_donation_form_stage_fees_button_num').innerHTML = (parseFloat(amount)).toFixed(2);
			// }
			// // Set fees on tickbox in fee stage
			// document.querySelector('.dd_donation_form_stage_fees_add').innerHTML = window.DashDonate.donationForm.calculateFees(amount);

			// Set fees on tickbox in fee stage
			// document.querySelector('.dd_donation_form_stage_fees_add').innerHTML = window.DashDonate.donationForm.calculateFees(amount);

			// // Get amount input's value
			// var amount = parseFloat(document.querySelector('#dd_donation_form_main [name="donation_amount"]').value);
			// // Get checkbox with id '#dd_pay_fees'
			// var toggle = document.getElementById('dd_pay_fees');
			// // Check if toggle is checked
			// if (toggle.checked) {
			// 	// Get fees
			// 	var fees = parseFloat(window.DashDonate.donationForm.calculateFees(amount));
			// 	// Set button total donation
			// 	document.querySelector('.dd_donation_form_stage_pay_confirm_btn_num').innerHTML = (parseFloat(amount + fees)).toFixed(2);
			// } else {
			// 	// Set button total donation
			// 	document.querySelector('.dd_donation_form_stage_pay_confirm_btn_num').innerHTML = (parseFloat(amount)).toFixed(2);
			// }

			// var fees = parseFloat(window.DashDonate.donationForm.calculateFees(amount));

		},
		this.dateMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		this.dateDays = ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th', '13th', '14th', '15th', '16th', '17th', '18th', '19th', '20th', '21st', '22nd', '23rd', '24th', '25th', '26th', '27th', '28th'],
		this.dateDay = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		this.setConfirmPage = function() {
			// Holding variables
			var amount, fees, date, interval, duration, duration_string, anchor, anchor_string;


			// Check whether to display confirmation for fee_field 'now'
			if (window.DashDonate.donationForm.payToday) {
				// Get amount
				amount = parseFloat(document.querySelector('#dd_donation_form_main [name="donation_amount_now"]').value);
				// Check if fees are to pay
				if (document.querySelector('[fee_field="now"] input').checked) {
					// Get fees
					amount += parseFloat(window.DashDonate.donationForm.calculateFees(amount));
				}
				// Set text
				document.querySelector('[summary_field="now"] p').innerHTML = '£' + parseFloat(amount).toFixed(2) + ' to donate now.';
				// Show fee field
				document.querySelector('[summary_field="now"]').classList.remove('hidden');
			} else {
				// Hide input field
				document.querySelector('[summary_field="now"]').classList.add('hidden');
			}


			// Check whether to display confirmation for fee_field 'scheduled'
			if (window.DashDonate.donationForm.scheduleFuture) {
				// Get amount
				amount = parseFloat(document.querySelector('#dd_donation_form_main [name="scheduled_donation_amount"]').value);
				// Check if fees are to pay
				if (document.querySelector('[fee_field="scheduled"] input').checked) {
					// Get fees
					amount += parseFloat(window.DashDonate.donationForm.calculateFees(amount));
				}
				// Get scheduled date and parse as date object
				date = new Date(document.querySelector('#dd_donation_form_main [name="scheduled_donation_date"]').value);
				// Set text
				document.querySelector('[summary_field="scheduled"] p').innerHTML = '£' + parseFloat(amount).toFixed(2) + ' to donate on ' + window.DashDonate.donationForm.dateDay[date.getDay()] + ' ' + window.DashDonate.donationForm.dateDays[date.getDate() - 1] + ' of ' + window.DashDonate.donationForm.dateMonths[date.getMonth()] + ' ' + date.getFullYear() + '.';
				// Show fee field
				document.querySelector('[summary_field="scheduled"]').classList.remove('hidden');
			} else {
				// Hide input field
				document.querySelector('[summary_field="scheduled"]').classList.add('hidden');
			}


			// Check whether to display confirmation for fee_field 'repeat'
			if (window.DashDonate.donationForm.setRepeat) {
				// Get amount
				amount = parseFloat(document.querySelector('#dd_donation_form_main [name="repeat_donation_amount"]').value);
				// Check if fees are to pay
				if (document.querySelector('[fee_field="repeat"] input').checked) {
					// Get fees
					amount += parseFloat(window.DashDonate.donationForm.calculateFees(amount));
				}
				// Get interval value
				interval = parseFloat(document.querySelector('#dd_donation_form_main [name="repeat_interval"]').value);
				// Get duration value
				duration = document.querySelector('#dd_donation_form_main [name="repeat_duration"]').value;
				// Check if pleural
				if (interval == 1) {
					// Check if duration is set to weeks
					if (duration == 'weeks') {
						// Set string to singular
						duration_string = 'week';
					} else {
						// Set string to singular
						duration_string = 'month';
					}
				} else {
					// Check if duration is set to weeks
					if (duration == 'weeks') {
						// Set string to pleural
						duration_string = interval + ' weeks';
					} else {
						// Set string to pleural
						duration_string = interval + ' months';
					}
				}
				// Get anchor value
				anchor = document.querySelector('#dd_donation_form_main [name="repeat_anchor"]').value;
				// Check if duration is set to weeks (rather than months)
				if (duration == 'weeks') {
					// Get day of week
					anchor_string = window.DashDonate.donationForm.dateDay[parseInt(anchor.substring('week-'.length))] + 's';
				} else {
					// Check if anchor is last day of month
					if (anchor == 'month-last') {
						// Get day of month
						anchor_string = 'the last day';
					} else {
						// Get day of month
						anchor_string = 'the ' + window.DashDonate.donationForm.dateDays[parseInt(anchor.substring('month-'.length)) - 1] + ' day';
					}
					// Check if singular
					if (interval === 1) {
						// Add to string
						anchor_string += ' of every month';
					} else {
						// Add to string
						anchor_string += ' of every ' + interval + ' months';
					}
				}
				// Set text
				document.querySelector('[summary_field="repeat"] p').innerHTML = '£' + parseFloat(amount).toFixed(2) + ' to donate every ' + duration_string + '<br><small>(on ' + anchor_string + ')</small>';
				// Show fee field
				document.querySelector('[summary_field="repeat"]').classList.remove('hidden');
			} else {
				// Hide input field
				document.querySelector('[summary_field="repeat"]').classList.add('hidden');
			}


		},
		this.payToday = true;
		this.calculateNextStage = function() {
			// Get existing stage
			var stage = document.querySelector('#dd_donation_form_main').getAttribute('stage');
			// Switch stage
			switch (stage) {
				case 'charity':
					stage = 'amount';
				break;
				case 'amount':
					// Get amount input's value
					var amount = parseFloat(document.querySelector('#dd_donation_form_main [name="donation_amount"]').value);
					// Hide error messages
					document.querySelector('#dd_donation_form_main .dd_err[for="donation_amount"]').classList.remove('show');
					// Do some form validation
					if (amount >= window.DashDonate.donationForm.minDonation) {
						// Check if regular donations is checked
						if (window.DashDonate.donationForm.isRegular) {
							// Set next stage
							stage = 'more_options';
						} else {
							// Set next stage
							stage = 'monthly';
						}
					} else {
						// Check if user wants to setup regular
						if (window.DashDonate.donationForm.isRegular) {
							// Set next stage
							stage = 'more_options';
						} else {
							// Add error message text
							document.querySelector('#dd_donation_form_main .dd_err[for="donation_amount"]').innerHTML = 'Your donation must be at least £' + parseInt(window.DashDonate.donationForm.minDonation).toFixed(2) + '.';
							// Make error message visible
							document.querySelector('#dd_donation_form_main .dd_err[for="donation_amount"]').classList.add('show');
						}
					}
				break;
				case 'monthly':
					// Check if regular donations is checked
					if (window.DashDonate.donationForm.isRegular) {
						// Set next stage
						stage = 'more_options';
					} else {
						// Set next stage
						stage = 'fees';
						// Set value of charge now to original input
						document.querySelector('#dd_donation_form_main [name="donation_amount_now"]').value = document.querySelector('#dd_donation_form_main [name="donation_amount"]').value;
						// Calculate fees
						window.DashDonate.donationForm.calculateFeesPage();
					}
				break;
				case 'more_options':
					// Check if set schedule is checked
					if (window.DashDonate.donationForm.scheduleFuture == true) {
						// Set next stage
						stage = 'more_options_scheduled';
					} else {
						if (window.DashDonate.donationForm.setRepeat == true) {
							// Set next stage
							stage = 'more_options_repeat';
						}
					}
				break;
				case 'more_options_repeat':
					// Validity variable
					var is_valid = true;
					// Hide error messages
					document.querySelector('#dd_donation_form_main .dd_err[for="repeat_donation_amount"]').classList.remove('show');
					document.querySelector('#dd_donation_form_main .dd_err[for="repeat_interval"]').classList.remove('show');
					document.querySelector('#dd_donation_form_main .dd_err[for="repeat_duration"]').classList.remove('show');
					document.querySelector('#dd_donation_form_main .dd_err[for="repeat_anchor"]').classList.remove('show');
					// Get amount input's value
					var amount = parseFloat(document.querySelector('#dd_donation_form_main [name="repeat_donation_amount"]').value);
					// Do some form validation
					if (!(amount >= window.DashDonate.donationForm.minDonation)) {
						// Add error message text
						document.querySelector('#dd_donation_form_main .dd_err[for="repeat_donation_amount"]').innerHTML = 'Your donation must be at least £' + parseInt(window.DashDonate.donationForm.minDonation).toFixed(2) + '.';
						// Make error message visible
						document.querySelector('#dd_donation_form_main .dd_err[for="repeat_donation_amount"]').classList.add('show');
						// Set is valid to false
						is_valid = false;
					}
					// Get interval input's value
					var interval = parseFloat(document.querySelector('#dd_donation_form_main [name="repeat_interval"]').value);
					// Get duration input's value
					var duration = document.querySelector('#dd_donation_form_main [name="repeat_duration"]').value;
					// Get anchor input's value
					var anchor = document.querySelector('#dd_donation_form_main [name="repeat_anchor"]').value;
					// Check interval is 0
					if (interval == 0) {
						// Add error message text
						document.querySelector('#dd_donation_form_main .dd_err[for="repeat_interval"]').innerHTML = 'The donation frequency must be at least 1.';
						// Make error message visible
						document.querySelector('#dd_donation_form_main .dd_err[for="repeat_interval"]').classList.add('show');
						// Set is valid to false
						is_valid = false;
					} else {
						// Switch duration
						switch (duration) {
							case 'weeks':
								// Check if interval is over 52 weeks
								if (interval > 52) {
									// Add error message text
									document.querySelector('#dd_donation_form_main .dd_err[for="repeat_interval"]').innerHTML = 'The donation must be more regular (limit of 52 weeks).';
									// Make error message visible
									document.querySelector('#dd_donation_form_main .dd_err[for="repeat_interval"]').classList.add('show');
									// Set is valid to false
									is_valid = false;
								}
							break;
							case 'months':
								// Check if interval is over 12 months
								if (interval > 12) {
									// Add error message text
									document.querySelector('#dd_donation_form_main .dd_err[for="repeat_interval"]').innerHTML = 'The donation must be more regular (limit of 12 months).';
									// Make error message visible
									document.querySelector('#dd_donation_form_main .dd_err[for="repeat_interval"]').classList.add('show');
									// Set is valid to false
									is_valid = false;
								}
							break;
						}
					}
					if (is_valid) {
						// Set next stage
						stage = 'more_options_contact';
					}
				break;
				case 'more_options_scheduled':
					// Validity variable
					var is_valid = true;
					// Get amount input's value
					var amount = parseFloat(document.querySelector('#dd_donation_form_main [name="scheduled_donation_amount"]').value);
					// Do some form validation
					if (amount >= window.DashDonate.donationForm.minDonation) {
						// Hide error messages
						document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_amount"]').classList.remove('show');
					} else {
						// Add error message text
						document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_amount"]').innerHTML = 'Your donation must be at least £' + parseInt(window.DashDonate.donationForm.minDonation).toFixed(2) + '.';
						// Make error message visible
						document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_amount"]').classList.add('show');
						// Set is_valid to false
						is_valid = false;
					}
					// Get date input's value
					var date = parseFloat(document.querySelector('#dd_donation_form_main [name="scheduled_donation_date"]').value);
					// Holding value
					var collated_values = [];
					// Get all inputs in the collective
					var inputs = document.querySelectorAll('.date-format[collective="scheduled_donation_date"]');
					// Loop through items
					for (var i = 0; i < inputs.length; i++) {
						// Add value to collated values
						collated_values[collated_values.length] = inputs[i].value;
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
						// Add error message text
						document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_date"]').innerHTML = 'You must enter a valid date.';
						// Make error message visible
						document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_date"]').classList.add('show');
						// Set is_valid to false
						is_valid = false;
					} else {
						// Hide error messages
						document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_date"]').classList.remove('show');
						// Check if date is today or in the past
						if (parsed <= new Date(new Date().toDateString())) {
							// Add error message text
							document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_date"]').innerHTML = 'You must enter a date after today.';
							// Make error message visible
							document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_date"]').classList.add('show');
							// Set is_valid to false
							is_valid = false;
						}
						// Check if date is within the next 2 years
						if (parsed > (new Date()).setFullYear(new Date().getFullYear() + 2)) {
							// Add error message text
							document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_date"]').innerHTML = 'Please select a date within the next 2 years.';
							// Make error message visible
							document.querySelector('#dd_donation_form_main .dd_err[for="scheduled_donation_date"]').classList.add('show');
							// Set is_valid to false
							is_valid = false;
						}
					}
					// Check if valid
					if (is_valid) {
						// Check if set repeat is true
						if (window.DashDonate.donationForm.setRepeat == true) {
							// Set next stage
							stage = 'more_options_repeat';
						} else {
							// Set next stage
							stage = 'more_options_contact';
						}
					}
				break;
				case 'more_options_contact':
					// Set next stage
					stage = 'more_option_pay_today';
				break;
				case 'more_option_pay_today':
					// Get amount input's value
					var amount = parseFloat(document.querySelector('#dd_donation_form_main [name="donation_amount_now"]').value);
					// Check if donation amount exists
					if (amount != 0) {
						// Set pay-today as false
						window.DashDonate.donationForm.payToday = true;
						// Do some form validation
						if (amount >= window.DashDonate.donationForm.minDonation) {
							// Set next stage
							stage = 'fees';
							// Calculate fees
							window.DashDonate.donationForm.calculateFeesPage();
							// Hide error messages
							document.querySelector('#dd_donation_form_main .dd_err[for="donation_amount_now"]').classList.remove('show');
						} else {
							// Add error message text
							document.querySelector('#dd_donation_form_main .dd_err[for="donation_amount_now"]').innerHTML = 'Your donation must be at least £' + parseInt(window.DashDonate.donationForm.minDonation).toFixed(2) + '.';
							// Make error message visible
							document.querySelector('#dd_donation_form_main .dd_err[for="donation_amount_now"]').classList.add('show');
						}
					} else {
						// Set next stage
						stage = 'fees';
						// Set pay-today as false
						window.DashDonate.donationForm.payToday = false;
						// Calculate fees
						window.DashDonate.donationForm.calculateFeesPage();
					}
				break;
				case 'fees':
					// Set checkbox values for fees
					window.DashDonate.donationForm.toggleAddFees();
					// Set next stage
					stage = 'giftaid';
				break;
				case 'giftaid':
					// Set next stage
					stage = 'payment_details';
				break;
				case 'payment_details':
					// Check if input exists (doesn't when logged into DD)
					if (document.querySelector('#dd_donation_form_main .dd_err[for="email_address"]')) {
						// Clear existing error
						document.querySelector('#dd_donation_form_main .dd_err[for="email_address"]').classList.remove('show');
					}
					// Clear existing error
					document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').classList.remove('show');
					// Get email that has been inserted '#email_address'
					var email = document.getElementById('email_address');
					// Check if email is invalid
					if (window.DashDonate.donationForm.isValidEmail(email.value) == false) {
						// Add error message text
						document.querySelector('#dd_donation_form_main .dd_err[for="email_address"]').innerHTML = 'This email address is not valid.';
						// Make error message visible
						document.querySelector('#dd_donation_form_main .dd_err[for="email_address"]').classList.add('show');
						// Return current stage (prevent progress until errors fixed)
						return stage;
					}
					// Hide errors for card
					document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').classList.remove('show');
					// Check if Stripe field is empty
					if (document.querySelector('.StripeElement.StripeElement--empty') != null) {
						// Add error message text
						document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').innerHTML = 'You must complete this field.';
						// Make error message visible
						document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').classList.add('show');
						// Return current stage (prevent progress until errors fixed)
						return stage;
					}
					// Check if Stripe generated errors are present
					if (document.querySelector('.StripeElement.StripeElement--invalid') != null) {
						// Make error message visible
						document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').classList.add('show');
						// Return current stage (prevent progress until errors fixed)
						return stage;
					}
					// Check if email is valid
					if (window.DashDonate.donationForm.isValidEmail(email.value) == true) {
						// Set next stage
						stage = 'confirm';
						// Set confirm page's values
						window.DashDonate.donationForm.setConfirmPage();
						// Check if errors can be displayed for email
						if (document.querySelector('#dd_donation_form_main .dd_err[for="email_address"]')) {
							// Hide error messages for the email address
							document.querySelector('#dd_donation_form_main .dd_err[for="email_address"]').classList.remove('show');
						}
						// Hide error messages for card issues
						document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').classList.remove('show');
					}
				break;
				case 'confirm':
					// Send user to next
					document.querySelector('#dd_donation_form_main').setAttribute('stage', 'processing');
					// Submit stripe form
					window.DashDonate.donationForm.submitDonationForm();
				break;
			}
			// Return stage
			return stage;
		},
		this.calculatePreviousStage = function() {
			// Get existing stage
			var stage = document.querySelector('#dd_donation_form_main').getAttribute('stage');
			// Switch stage
			switch (stage) {
				case 'amount':
					stage = 'charity';
				break;
				case 'more_options':
					// Set isRegular to false
					window.DashDonate.donationForm.setNotMonthly();
					// Set next stage
					stage = 'amount';
				break;
				case 'more_options_scheduled':
					stage = 'more_options';
				break;
				case 'more_options_repeat':
					// Check if set scheduled is true
					if (window.DashDonate.donationForm.scheduleFuture == true) {
						// Rewind to schedule
						stage = 'more_options_scheduled';
					} else {
						// Rewind to options
						stage = 'more_options';
					}
				break;
				case 'more_options_contact':
					// Check if set repeat is true
					if (window.DashDonate.donationForm.setRepeat == true) {
						// Rewind to repeat
						stage = 'more_options_repeat';
					} else {
						// Rewind to scheduled
						stage = 'more_options_scheduled';
					}
				break;
				case 'more_option_pay_today':
					// Check if set repeat is true
					if (window.DashDonate.donationForm.setRepeat == true) {
						// Rewind to repeat
						stage = 'more_options_repeat';
					} else {
						// Rewind to scheduled
						stage = 'more_options_scheduled';
					}
				break;
				case 'fees':
					// Check if user has just come from 'more_option_pay_today' page
					if (window.DashDonate.donationForm.scheduleFuture == true || window.DashDonate.donationForm.setRepeat == true) {
						// Rewind to pay-today
						stage = 'more_option_pay_today';
					} else {
						// Rewind to amount
						stage = 'amount';
					}
				break;
				case 'giftaid':
					stage = 'fees';
					// Calculate fees
					window.DashDonate.donationForm.calculateFeesPage();
				break;
				case 'payment_details':
					stage = 'giftaid';
				break;
				case 'confirm':
					stage = 'payment_details';
				break;
				case 'error':
				case 'auth_failed':
				case 'card_auth_failed':
				case 'card_declined':
					stage = 'payment_details';
				break;
			}
			// Return stage
			return stage;
		},
		this.isRegular = false;
		this.setMonthly = function() {
			// Set regular as true
			window.DashDonate.donationForm.isRegular = true;
		},
		this.setNotMonthly = function() {
			// Set regular as false
			window.DashDonate.donationForm.isRegular = false;
		},
		this.scheduleFuture = false;
		this.setScheduled = function() {
			// Set to true
			window.DashDonate.donationForm.scheduleFuture = true;
			// Enable button for moving next
			document.querySelector('.dd_donation_form_stage[stage="more_options"] .dd_next_stage').classList.remove('next_disabled');
		},
		this.setNotScheduled = function() {
			// Set to false
			window.DashDonate.donationForm.scheduleFuture = false;
			// Check if both not-repeating and not-scheduled are false
			if (window.DashDonate.donationForm.setRepeat == false && window.DashDonate.donationForm.scheduleFuture == false) {
				// Disabled button for moving next
				document.querySelector('.dd_donation_form_stage[stage="more_options"] .dd_next_stage').classList.add('next_disabled');
			}
		},
		this.setRepeat = false;
		this.setRepeating = function() {
			// Set to true
			window.DashDonate.donationForm.setRepeat = true;
			// Enable button for moving next
			document.querySelector('.dd_donation_form_stage[stage="more_options"] .dd_next_stage').classList.remove('next_disabled');
		},
		this.setNotRepeating = function() {
			// Set to false
			window.DashDonate.donationForm.setRepeat = false;
			// Check if both not-repeating and not-scheduled are false
			if (window.DashDonate.donationForm.setRepeat == false && window.DashDonate.donationForm.scheduleFuture == false) {
				// Disabled button for moving next
				document.querySelector('.dd_donation_form_stage[stage="more_options"] .dd_next_stage').classList.add('next_disabled');
			}
		},
		this.goToNextStage = function() {
			// Calculate next stage
			var stage = window.DashDonate.donationForm.calculateNextStage();
			// Send user to next stage
			document.querySelector('#dd_donation_form_main').setAttribute('stage', stage);
		},
		this.goToPreviousStage = function() {
			// Calculate previous stage
			var stage = window.DashDonate.donationForm.calculatePreviousStage();
			// Send user to previous stage
			document.querySelector('#dd_donation_form_main').setAttribute('stage', stage);
		},
		this.calculateFees = function(amount) {
			// Parse amount into float
			var fees = parseFloat(amount);
			// Get fee string
			var fee_string = window.DashDonate.donationForm.fee_string;
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
			// Floor sub-pence and divide back down to pence
			fees = (Math.floor(fees) / 100);
			// Calculate minimum fee (take away donation amount from total calculated above)
			fees = (fees - amount);
			// Return fees
			return fees.toFixed(2);
		},
		this.futureNotifications = true;
		this.toggleDonationNotifications = function() {
			// Set if toggle is checked
			window.DashDonate.donationForm.futureNotifications = !(document.getElementById('dd_turn_off_notifications').checked);
		},
		this.payFeeNow = false;
		this.payFeeScheduled = false;
		this.payFeeRepeat = false;
		this.toggleAddFees = function() {
			// Set value
			window.DashDonate.donationForm.payFeeNow = document.getElementById('dd_pay_fees_now').checked;
			window.DashDonate.donationForm.payFeeScheduled = document.getElementById('dd_pay_fees_scheduled').checked;
			window.DashDonate.donationForm.payFeeRepeat = document.getElementById('dd_pay_fees_repeat').checked;
		},
		this.addStripe = function() {
			// Create Stripe script
			var script = document.createElement('script');
			// Set script source
			script.setAttribute('src', window.DashDonate.donationForm.stripe_url);
			// Add script to body
			document.body.appendChild(script);
			// Wait till script is loaded before initialising
			script.addEventListener('load', window.DashDonate.donationForm.initStripe());
		},
		this.stripeLoaded = false;
		this.stripeLoadedDone = false;
		this.initStripe = function() {
			// Check if done already
			if (window.DashDonate.donationForm.stripeLoadedDone == false) {
				// Check if the Stripe object has been created
				if (typeof Stripe != 'undefined' && window.DashDonate.donationForm.stripeLoaded == true) {
					// Clear interval
					clearInterval(window.DashDonate.donationForm.stripeInitLoop);
					// Mark loading as done
					window.DashDonate.donationForm.stripeLoadedDone = true;
					// Create instance of Stripe
					window.DashDonate.donationForm.stripe = Stripe(window.DashDonate.donationForm.stripe_key);
					// Create stripe elements
					window.DashDonate.donationForm.stripeElements = window.DashDonate.donationForm.stripe.elements();
					// Create Stripe card element
					window.DashDonate.donationForm.stripeCard = window.DashDonate.donationForm.stripeElements.create('card', { style: window.DashDonate.donationForm.stripeStyles });
					// Mount card field into form gap
					window.DashDonate.donationForm.stripeCard.mount(window.DashDonate.donationForm.stripeCardContainer);
					// Handle real-time validation errors from the Stripe card element
					window.DashDonate.donationForm.stripeCard.addEventListener('change', function(event) {
						// Check if error was found
						if (event.error) {
							// Add error message text
							document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').innerHTML = event.error.message;
							// Show error message
							document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').classList.add('show');
						} else {
							// Hide error message
							document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').classList.remove('show');
						}
					});
				} else {
					// Set loop to retry initialisation of Stripe
					window.DashDonate.donationForm.stripeInitLoop = setInterval(function() {
						// Check if stripe key is set
						if (window.DashDonate.donationForm.stripe_key != null) {
							// Set loaded to true
							window.DashDonate.donationForm.stripeLoaded = true;
							// Initialise Stripe
							window.DashDonate.donationForm.initStripe();
						}
					}, 250);
				}
			}
		},
		this.paymentToken = null;
		this.handlePaymentToken = function(token) {
			// Save token to object
			window.DashDonate.donationForm.paymentToken = token.id;
			// Submit donation form
			window.DashDonate.donationForm.sendDonationForm();
		},
		this.submitDonationForm = function() {
			// Create Stripe token for the card field
			window.DashDonate.donationForm.stripe.createToken(window.DashDonate.donationForm.stripeCard).then(function(result) {
				// Check if there was an error with creating the card
				if (result.error) {
					// Go back to payment details stage
					document.querySelector('#dd_donation_form_main').setAttribute('stage', 'payment_details');
					// Add error message text
					document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').innerHTML = result.error.message;
					// Show error message
					document.querySelector('#dd_donation_form_main .dd_err[for="dd_card_errors"]').classList.add('show');
				} else {
					// Handle the payment token
					window.DashDonate.donationForm.handlePaymentToken(result.token);
				}
			});
		},
		this.donationFormSent = false;
		this.captureFormDetails = function() {
			// Create object to return
			var data = {
				site_id:					document.querySelector('#dd_donation_form_main').getAttribute('charity_site'),
				stripe_token: 				window.DashDonate.donationForm.paymentToken,
				amount_pounds_now:			parseFloat(document.querySelector('#dd_donation_form_main [name="donation_amount_now"]').value),
				pay_fees_now:				window.DashDonate.donationForm.payFeeNow,
				pay_now:					window.DashDonate.donationForm.payToday,
				amount_pounds_repeat:		parseFloat(document.querySelector('#dd_donation_form_main [name="repeat_donation_amount"]').value),
				pay_fees_repeat:			window.DashDonate.donationForm.payFeeRepeat,
				repeat:						window.DashDonate.donationForm.setRepeat,
				repeat_interval:			parseFloat(document.querySelector('#dd_donation_form_main [name="repeat_interval"]').value),
				repeat_duration:			document.querySelector('#dd_donation_form_main [name="repeat_duration"]').value,
				repeat_anchor:				document.querySelector('#dd_donation_form_main [name="repeat_anchor"]').value,
				amount_pounds_scheduled:	parseFloat(document.querySelector('#dd_donation_form_main [name="scheduled_donation_amount"]').value),
				pay_fees_scheduled:			window.DashDonate.donationForm.payFeeScheduled,
				scheduled:					window.DashDonate.donationForm.scheduleFuture,
				scheduled_date:				document.querySelector('#dd_donation_form_main [name="scheduled_donation_date"]').value,
				giftaid:					document.getElementById('dd_giftaid').checked,
				email_address:				document.querySelector('#dd_donation_form_main [name="email_address"]').value,
				payment_intent:				window.DashDonate.donationForm.donationIntentId,
				setup_intent:				window.DashDonate.donationForm.setupIntentId,
				futureNotifications:		window.DashDonate.donationForm.futureNotifications,
			};
			// Return data
			return data;
		},
		this.sendDonationForm = function() {
			// Check if sent already
			if (window.DashDonate.donationForm.donationFormSent == false) {
				// Set anti-double-submit variable
				window.DashDonate.donationForm.donationFormSent = true;
				// Create XML HTTP Request
				var xhr = new XMLHttpRequest();
				// Open request to widget's donation API route
				xhr.open('POST', this.app_url + '/widget/donation/');
				// Set content type header
				xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
				// Set CSRF token header
				xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementById('dd_csrf_token').value);
				// Collect all information about the donation
				var data = window.DashDonate.donationForm.captureFormDetails();
				// Convert data into form data
				var form_data = new FormData();
				// Loop through data
				for (var key in data) {
					// Add data item into form_data variable
				    form_data.append(key, data[key]);
				}
				// Send form data
				xhr.send(JSON.stringify(data));
				console.clear();
				// Set listener for the request to change status
				xhr.onreadystatechange = function() {
					// Wait until the request is done
					if (xhr.readyState === 4) { // Ready status 4 means that the request is done
						// Check if request was success
						if (xhr.status === 200) { // Status 200 is a success status
							// Parse response test
							var response = JSON.parse(xhr.responseText);



							console.log(response);

							// Errors:
							// 	unauthorised_donation_site
							//	failed_to_create_stripe_customer
							//	failed_to_add_card








							// Check if there is a status item
							if (response.success == true && typeof response.intent != 'undefined' && typeof response.intent.status != 'undefined') {
								// Save intent ID through widget object
								window.DashDonate.donationForm.donationIntentId = response.intent.id;
								// Switch status
								switch (response.intent.status) {
									case 'succeeded':
										// Send user to success page
										document.querySelector('#dd_donation_form_main').setAttribute('stage', 'success');
									break;
									case 'requires_action':
										// Change frame to 3d_secure
										document.getElementById('dd_donation_form_main').setAttribute('stage', '3d_secure');
										// Create iFrame for 3D secure
										var iframe = document.createElement('iframe');
										iframe.src = response.intent.next_action.use_stripe_sdk.stripe_js;
										iframe.width = 250;
										iframe.height = 400;
										// Insert iFrame
										document.getElementById('dd_donation_form_3d_secure').appendChild(iframe);
									break;
									case 'requires_payment_method':
										// Go back and get new payment method

										console.log('Needs payment method');

									break;
								}
							} else {
								// Check if success with SetupIntent to attend to
								if (response.success == true && response.setup_intent != undefined) {
									// Save intent ID to widget object
									window.DashDonate.donationForm.setupIntentId = response.setup_intent.id;



									// Switch status
									switch (response.setup_intent.status) {
										case 'succeeded':
											// Send user to success page
											document.querySelector('#dd_donation_form_main').setAttribute('stage', 'success');
										break;
										case 'requires_action':
											// Change frame to 3d_secure
											document.getElementById('dd_donation_form_main').setAttribute('stage', '3d_secure_card');
											// Create iFrame for 3D secure
											var iframe = document.createElement('iframe');
											iframe.src = response.setup_intent.next_action.use_stripe_sdk.stripe_js;
											iframe.width = 250;
											iframe.height = 400;
											// Insert iFrame
											document.getElementById('dd_donation_form_3d_secure_card').appendChild(iframe);
										break;
										default:

											// Send user to error page
											document.querySelector('#dd_donation_form_main').setAttribute('stage', 'error');
											// Reset anti-double-submit variable
											window.DashDonate.donationForm.donationFormSent = false;

										break;
									}




								} else {
									// Check if success without pay-now
									if (response.success == true && response.intent == false) {
										// Send user to success page
										document.querySelector('#dd_donation_form_main').setAttribute('stage', 'success');
									} else {
										// console.clear();
										console.log('Error:');
										console.log(response);
										// Send user to error page
										document.querySelector('#dd_donation_form_main').setAttribute('stage', 'error');
										// Reset anti-double-submit variable
										window.DashDonate.donationForm.donationFormSent = false;
									}
								}
							}
						} else {
							console.log(xhr.status);
							console.log(xhr.responseText);
							// Send user to error page
							document.querySelector('#dd_donation_form_main').setAttribute('stage', 'error');
							// Reset anti-double-submit variable
							window.DashDonate.donationForm.donationFormSent = false;
						}
					}
				}
			};
		},



		// Submit payment and tasks following SetupIntent success
		this.submitPaymentTasks = function() {
			// Create XML HTTP Request
			var xhr = new XMLHttpRequest();
			// Open request to widget's donation API route
			xhr.open('POST', this.app_url + '/api/widget/donation/submit-next');
			// Set content type header
			xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
			// Set CSRF token header
			xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementById('dd_csrf_token').value);
			// Collect all information about the donation
			var data = window.DashDonate.donationForm.captureFormDetails();
			// Convert data into form data
			var form_data = new FormData();
			// Loop through data
			for (var key in data) {
				// Add data item into form_data variable
			    form_data.append(key, data[key]);
			}
			// Send form data
			xhr.send(JSON.stringify(data));
			// Set listener for the request to change status
			xhr.onreadystatechange = function() {
				// Wait until the request is done
				if (xhr.readyState === 4) { // Ready status 4 means that the request is done
					// Check if request was success
					if (xhr.status === 200) { // Status 200 is a success status
						// Parse response test
						var response = JSON.parse(xhr.responseText);



						console.log(response);


						// Check if intent was returned
						if (response.success == true && response.intent != undefined) {
							// Check if the intent needs action
							if (response.intent != false) {
								// Switch status of intent
								switch (response.intent.status) {
									case 'requires_action':
										// Change frame to 3d_secure
										document.getElementById('dd_donation_form_main').setAttribute('stage', '3d_secure');
										// Create iFrame for 3D secure
										var iframe = document.createElement('iframe');
										iframe.src = response.intent.next_action.use_stripe_sdk.stripe_js;
										iframe.width = 250;
										iframe.height = 400;
										// Insert iFrame
										document.getElementById('dd_donation_form_3d_secure').appendChild(iframe);
									break;
									default:

										console.log('X');
										console.log(response);

										// Send user to error page
										document.querySelector('#dd_donation_form_main').setAttribute('stage', 'error');
										// Reset anti-double-submit variable
										window.DashDonate.donationForm.donationFormSent = false;
									break;
								}
							} else {
								// Send user to success page
								document.querySelector('#dd_donation_form_main').setAttribute('stage', 'success');
							}
						} else {
							// Send user to error page
							document.querySelector('#dd_donation_form_main').setAttribute('stage', 'error');
							// Reset anti-double-submit variable
							window.DashDonate.donationForm.donationFormSent = false;
						}
					} else {
						console.log(xhr.status);
						console.log(xhr.responseText);
					}
				}
			};
		},



		// Authorise tasks to be set for future payments
		this.resubmitTasks = function() {
			// Create XML HTTP Request
			var xhr = new XMLHttpRequest();
			// Open request to widget's donation API route
			xhr.open('POST', this.app_url + '/api/widget/donation/set-tasks');
			// Set content type header
			xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
			// Set CSRF token header
			xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementById('dd_csrf_token').value);
			// Collect all information about the donation
			var data = {
				site_id:					document.querySelector('#dd_donation_form_main').getAttribute('charity_site'),
				amount_pounds_repeat:		parseFloat(document.querySelector('#dd_donation_form_main [name="repeat_donation_amount"]').value),
				pay_fees_repeat:			window.DashDonate.donationForm.payFeeRepeat,
				repeat:						window.DashDonate.donationForm.setRepeat,
				repeat_interval:			parseFloat(document.querySelector('#dd_donation_form_main [name="repeat_interval"]').value),
				repeat_duration:			document.querySelector('#dd_donation_form_main [name="repeat_duration"]').value,
				repeat_anchor:				document.querySelector('#dd_donation_form_main [name="repeat_anchor"]').value,
				amount_pounds_scheduled:	parseFloat(document.querySelector('#dd_donation_form_main [name="scheduled_donation_amount"]').value),
				pay_fees_scheduled:			window.DashDonate.donationForm.payFeeScheduled,
				scheduled:					window.DashDonate.donationForm.scheduleFuture,
				scheduled_date:				document.querySelector('#dd_donation_form_main [name="scheduled_donation_date"]').value,
				giftaid:					document.getElementById('dd_giftaid').checked,
				email_address:				document.querySelector('#dd_donation_form_main [name="email_address"]').value,
				payment_intent:				window.DashDonate.donationForm.donationIntentId,
				futureNotifications:		window.DashDonate.donationForm.futureNotifications,
			};
			// Convert data into form data
			var form_data = new FormData();
			// Loop through data
			for (var key in data) {
				// Add data item into form_data variable
			    form_data.append(key, data[key]);
			}
			// Send form data
			xhr.send(JSON.stringify(data));
			// Set listener for the request to change status
			xhr.onreadystatechange = function() {
				// Wait until the request is done
				if (xhr.readyState === 4) { // Ready status 4 means that the request is done
					// Check if request was success
					if (xhr.status === 200) { // Status 200 is a success status
						// Parse response test
						var response = JSON.parse(xhr.responseText);



						console.log(response);



						// Check for success
						if (response.success == true) {
							// Send user to success page
							document.querySelector('#dd_donation_form_main').setAttribute('stage', 'success');
						} else {
							console.clear();
							console.log('Error:');
							console.log(response);

							document.querySelector('#dd_donation_form_main').setAttribute('stage', 'error');
							// Reset anti-double-submit variable
							window.DashDonate.donationForm.donationFormSent = false;

						}
					} else {
						console.log(xhr.status);
						console.log(xhr.responseText);
					}
				}
			};
		},
		this.complete3DS = function(data) {
			// Check which iframe is to be removed
			if (document.querySelector('#dd_donation_form_3d_secure iframe')) {
				// Remove iFrame
				document.querySelector('#dd_donation_form_3d_secure iframe').remove();
			} else {
				// Remove iFrame
				document.querySelector('#dd_donation_form_3d_secure_card iframe').remove();
			}

			console.log(data);


			// Check if intent was returned
			if (data.message != undefined && data.message.setup_intent != undefined) {
				// Switch status of intent
				switch (data.message.setup_intent.status) {
					case 'succeeded':
						// Submit intent and future tasks
						window.DashDonate.donationForm.submitPaymentTasks();
						// Send user to processing page
						document.getElementById('dd_donation_form_main').setAttribute('stage', 'processing');
					break;
					default:
						// Send user to error page
						document.querySelector('#dd_donation_form_main').setAttribute('stage', 'card_auth_failed');
						// Reset anti-double-submit variable
						window.DashDonate.donationForm.donationFormSent = false;
					break;
				}
			} else {
				// Check if intent was returned
				if (data.message != undefined && data.message.payment_intent != undefined) {
					// Switch status of intent
					switch (data.message.payment_intent.status) {
						case 'succeeded':
							// Authorise tasks to be set for future payments
							window.DashDonate.donationForm.resubmitTasks();
							// Send user to success page
							document.getElementById('dd_donation_form_main').setAttribute('stage', 'success');
						break;
						default:
							// Log to console
							// console.log('Payment Failed - ' + data.message.error.code);
							// Send user to error page
							document.querySelector('#dd_donation_form_main').setAttribute('stage', 'error');
							// Reset anti-double-submit variable
							window.DashDonate.donationForm.donationFormSent = false;
						break;
					}
				} else {
					// Check if error was returned
					if (data.message != undefined && data.message.error != undefined) {
						// Switch status of error
						switch (data.message.error.code) {
							case 'payment_intent_authentication_failure':
								// Send user to error page
								document.querySelector('#dd_donation_form_main').setAttribute('stage', 'auth_failed');
							break;
							case 'setup_intent_authentication_failure':
								// Send user to error page
								document.querySelector('#dd_donation_form_main').setAttribute('stage', 'card_auth_failed');
							break;
							case 'card_declined':
								// Send user to error page
								document.querySelector('#dd_donation_form_main').setAttribute('stage', 'card_declined');
							break;
							default:
								// Send user to error page
								document.querySelector('#dd_donation_form_main').setAttribute('stage', 'error');
							break;
						}
						// Log to console
						// console.log('Payment Failed - ' + data.message.error.code);
						// Reset anti-double-submit variable
						window.DashDonate.donationForm.donationFormSent = false;
					} else {
						// Send user to error page
						document.querySelector('#dd_donation_form_main').setAttribute('stage', 'error');
						// Reset anti-double-submit variable
						window.DashDonate.donationForm.donationFormSent = false;
					}
				}
			}
		},




		this.init();
	}


	// Delay until script loaded
	document.addEventListener('DOMContentLoaded', function() {
		// Create donation form object
		window.DashDonate.donationForm = new DonationForm();
	});


	// Create event listener for all assets being loaded (so that Stripe can be initialised)
	window.addEventListener('load', function() {
		window.DashDonate.donationForm.addStripe();
	});




	// Create event listener if 3DS has been completed
	window.addEventListener('message', function(e) {
		// Check if message is 3DS done
		if (e.data) {
			if (e.data.type != undefined && e.data.type === 'stripe-3ds-result') {
				// Complete 3Ds authentication
				window.DashDonate.donationForm.complete3DS(e.data);
			}
		}
	});




})();
