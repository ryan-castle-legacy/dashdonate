(function() {

	function DonationForm() {
		this.api_url		= 'http://ec2-0-0-0-0.eu-west-2.compute.amazonaws.com';
		this.stripe 		= null;
		this.stripeElements	= null;
		this.stripe_url		= 'https://js.stripe.com/v3/';
		this.stripe_key		= null;
		this.stripeCard 	= null;
		this.stripeCardContainer = null;
		this.stripeStyles	= {
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
				// Create XML HTTP Request
				var xhr = new XMLHttpRequest();
				xhr.open('GET', this.api_url + '/widget/donation/' + window.DashDonate.site);
				xhr.send();
				xhr.onreadystatechange = function() {
					if (xhr.readyState === 4) { // Ready status 4 means that the request is done
						if (xhr.status === 200) { // Status 200 is a success status
							window.DashDonate.donationForm.widget = JSON.parse(xhr.responseText); // 'This is the returned text.'
							window.DashDonate.donationForm.buildWidget(); // Build widget
						} else {
							window.DashDonate.donationForm.widgetError = {
								status: 	xhr.status,
								message:	xhr.responseText,
							};
							window.DashDonate.donationForm.displayObject(); // Console error
						}
					}
				};
			}
		},
		this.buildWidget = function() {
			this.canvas.innerHTML = this.widget.html;
			this.addEventListeners();
			this.stripe_key	= document.querySelector('#dd_donation_form_main').getAttribute('pk');
			this.widgetHeight = document.querySelector('#dd_donation_form_main').offsetHeight;
			this.stripeCardContainer = document.getElementById('dd_donation_form_card');
			this.setStageMinHeight();
		},
		this.addEventListeners = function() {
			// Donation frequency selector listener
			var donation_frequency_selectors = document.querySelectorAll('.dd_donation_form_group_amount_frequency_item');
			// Loop through frequency selector options
			for (var i = 0; i < donation_frequency_selectors.length; i++) {
				// Add event listners
				donation_frequency_selectors[i].addEventListener('click', function(e) {
					// Loop through frequency selector options
					for (var j = 0; j < donation_frequency_selectors.length; j++) {
						// Check if clicked listener is the current option
						if (donation_frequency_selectors[j] == e.target) {
							// Select item by adding selected class
							e.target.classList.add('selected');
						} else {
							// As the current option isn't the one that was clicked, remove selected class
							donation_frequency_selectors[j].classList.remove('selected');
						}
					}
				});
			}


			// Donation suggestions listener
			var donation_suggestions = document.querySelectorAll('.dd_donation_form_group_amount_suggestions_suggestion');
			// Loop through suggestions options
			for (var i = 0; i < donation_suggestions.length; i++) {
				// Add event listners
				donation_suggestions[i].addEventListener('click', function(e) {
					// Loop through suggestions options
					for (var j = 0; j < donation_suggestions.length; j++) {
						// Check if clicked listener is the current option
						if (donation_suggestions[j] == e.target) {
							// Select item by adding selected class
							e.target.classList.add('selected');
							// Set donation value to suggested value
							document.getElementById('dd_donation_form_amount').value = (e.target.getAttribute('value') / 100).toFixed(2);
						} else {
							// As the current option isn't the one that was clicked, remove selected class
							donation_suggestions[j].classList.remove('selected');
						}
					}
				});
			}


			// Event listener for donation value change
			document.getElementById('dd_donation_form_amount').addEventListener('keyup', function() {
				// Donation suggestions listener
				var donation_suggestions = document.querySelectorAll('.dd_donation_form_group_amount_suggestions_suggestion');
				// Loop through suggestions options
				for (var i = 0; i < donation_suggestions.length; i++) {
					// Remove selected class
					donation_suggestions[i].classList.remove('selected');
				}
			});


			// Next stage buttons
			var next_stage_buttons = document.querySelectorAll('.dd_donation_form_group_next');
			// Loop through buttons
			for (var i = 0; i < next_stage_buttons.length; i++) {
				// Add event listners
				next_stage_buttons[i].addEventListener('click', function(e) {
					window.DashDonate.donationForm.goToNextStage();
				});
			}


			// Previous stage buttons
			var previous_stage_buttons = document.querySelectorAll('.dd_donation_form_group_go_back');
			// Loop through buttons
			for (var i = 0; i < previous_stage_buttons.length; i++) {
				// Add event listners
				previous_stage_buttons[i].addEventListener('click', function(e) {
					window.DashDonate.donationForm.goToPreviousStage();
				});
			}

		},
		this.calculateNextStage = function() {
			// Get current stage
			var stage = document.getElementById('dd_donation_form_main').getAttribute('stage');
			// Switch the stage
			switch (stage) {
				case 'amount':
					var donation_frequency = document.querySelector('.dd_donation_form_group_amount_frequency_item.selected').getAttribute('value');
					// Check frequency
					if (donation_frequency == 'one-off') {
						return 'payment_method';
					} else {
						return 'customise';
					}
				break;
				case 'customise':
					return 'payment_method';
				break;
				case 'payment_method':
					return 'confirm';
				break;
				case 'confirm':
					// Submit stripe form
					this.submitDonationForm();
				break;
			}
			return stage;
		},
		this.calculatePreviousStage = function() {
			// Get current stage
			var stage = document.getElementById('dd_donation_form_main').getAttribute('stage');
			// Switch the stage
			switch (stage) {
				case 'payment_method':
					var donation_frequency = document.querySelector('.dd_donation_form_group_amount_frequency_item.selected').getAttribute('value');
					// Check frequency
					if (donation_frequency == 'one-off') {
						return 'amount';
					} else {
						return 'customise';
					}
				break;
				case 'customise':
					return 'amount';
				break;
			}
			return stage;
		},
		this.goToNextStage = function() {
			var stage = this.calculateNextStage();
			// Set new stage
			document.getElementById('dd_donation_form_main').setAttribute('stage', stage);
		},
		this.goToPreviousStage = function() {
			var stage = this.calculatePreviousStage();
			// Set new stage
			document.getElementById('dd_donation_form_main').setAttribute('stage', stage);
		},
		this.setStageMinHeight = function() {
			// Set widget height
			document.getElementById('dd_donation_form_main').style.minHeight = (this.widgetHeight + 'px');
			// Get all stages
			var stages = document.querySelectorAll('#dd_donation_form_main .dd_donation_form_stage');
			// Holding variable
			var max_height = 0;
			// Loop through stages
			for (var i = 0; i < stages.length; i++) {
				// Get stage height
				stage_height = stages[i].offsetHeight;
				// Check if stage is amount
				if (stages[i].getAttribute('stage') != 'amount') {
					stage_height = stage_height + 60;
				}
				// Check if stage height is larger than stored max height
				if (stage_height > max_height) {
					// Add new max height to holding variable
					max_height = stage_height;
				}
			}
			// Loop through stages
			for (var i = 0; i < stages.length; i++) {
				// Set min height of all stages
				stages[i].style.height = max_height + 'px';
			}
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
		this.initStripe = function() {
			// Check if the Stripe object has been created
			if (typeof Stripe != 'undefined') {
				// Create instance of Stripe
				window.DashDonate.donationForm.stripe = Stripe(window.DashDonate.donationForm.stripe_key);
				// Create stripe elements
				window.DashDonate.donationForm.stripeElements = window.DashDonate.donationForm.stripe.elements();
				// Create Stripe card element
				window.DashDonate.donationForm.stripeCard = window.DashDonate.donationForm.stripeElements.create('card', window.DashDonate.donationForm.stripeStyles);
				// Mount card field into form gap
				window.DashDonate.donationForm.stripeCard.mount(window.DashDonate.donationForm.stripeCardContainer);


				// 	// Handle real-time validation errors from the card Element.
				// 	card.addEventListener('change', function(event) {
				// 		var displayError = document.getElementById('card-errors');
				// 	if (event.error) {
				// 			displayError.textContent = event.error.message;
				// 		} else {
				// 			displayError.textContent = '';
				// 		}
				// 	});


			} else {
				// Set timeout to retry initialisation of Stripe
				setTimeout(window.DashDonate.donationForm.initStripe, 250);
			}
		}
		this.handlePaymentToken = function(token) {
			// Create form input to store the

			// 	function stripeTokenHandler(token) {
			// 		// Insert the token ID into the form so it gets submitted to the server
			// 		var form = document.getElementById('payment-form');
			// 		// Add Stripe Token to hidden input
			// 		var hiddenInput = document.createElement('input');
			// 		hiddenInput.setAttribute('type', 'hidden');
			// 		hiddenInput.setAttribute('name', 'stripeToken');
			// 		hiddenInput.setAttribute('value', token.id);
			// 		form.appendChild(hiddenInput);
			// 		// Submit form
			// 		form.submit();
			// 	}
			//
			// }

			// Submit donation form
			window.DashDonate.donationForm.sendDonationForm(token.id);
		}
		this.submitDonationForm = function() {
			// Create Stripe token for the card field
			window.DashDonate.donationForm.stripe.createToken(window.DashDonate.donationForm.stripeCard).then(function(result) {
				// Check if there was an error with creating the card
				if (result.error) {
					// Inform the user if there was an error
					// 				var errorElement = document.getElementById('card-errors');
					// 				errorElement.textContent = result.error.message;
				} else {
					// Handle the payment token
					window.DashDonate.donationForm.handlePaymentToken(result.token);
				}
			});
		}
		this.donationIntentId = null;
		this.sendDonationForm = function(token_id) {


			// Create XML HTTP Request
			var xhr = new XMLHttpRequest();
			xhr.open('POST', this.api_url + '/widget/donation/');

			xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
			xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementById('dd_csrf_token').value);


			var data = {
				stripe_token: token_id,
			};


			// Convert data into form data
			var formData = new FormData();
			// Loop through data
			for (var key in data) {
				// Add data item into formData variable
			    formData.append(key, data[key]);
			}
			// Send form data
			xhr.send(JSON.stringify(data));
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4) { // Ready status 4 means that the request is done
					if (xhr.status === 200) { // Status 200 is a success status


						// Parse response test
						var response = JSON.parse(xhr.responseText);

						console.log(response);


						// Check if there is a status item
						if (typeof response.status != 'undefined') {

							// Save intent ID through widget object
							window.DashDonate.donationForm.donationIntentId = response.id;

							// Switch status
							switch (response.status) {
								case 'succeeded':
									console.log('Payment success');
								break;
								case 'requires_action':

									// Change frame to 3d_secure
									document.getElementById('dd_donation_form_main').setAttribute('stage', '3d_secure');

									console.log(response.next_action);

									var iframe = document.createElement('iframe');
									iframe.src = response.next_action.use_stripe_sdk.stripe_js;
									iframe.width = 250;
									iframe.height = 400;

									document.getElementById('dd_donation_form_3d_secure').appendChild(iframe);



									// yourContainer.appendChild(iframe);


								break;
								case 'requires_payment_method':
									// Go back and get new payment method
								break;
							}
						}

					} else {

						console.log(xhr.status);
						console.log(xhr.responseText);

					}
				}
			};
		}
		this.complete3DS = function() {
			console.log('3DS');

			// Remove iFrame
			document.querySelector('#dd_donation_form_3d_secure iframe').remove();

			alert();

			// Create XML HTTP Request
			var xhr = new XMLHttpRequest();
			xhr.open('GET', this.api_url + '/widget/get-intent/' + window.DashDonate.donationForm.donationIntentId);
			xhr.send();
			// Get intent object to figure out status
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4) { // Ready status 4 means that the request is done
					if (xhr.status === 200) { // Status 200 is a success status
						var x = JSON.parse(xhr.responseText); // 'This is the returned text.'

						console.log(x);

						document.getElementById('dd_donation_form_main').setAttribute('stage', 'success');


					} else {
						// window.DashDonate.donationForm.widgetError = {
						// 	status: 	xhr.status,
						// 	message:	xhr.responseText,
						// };
						// window.DashDonate.donationForm.displayObject(); // Console error
					}
				}
			};



		}





		this.displayObject = function() {
			console.log(this);
		}
		this.init();
	}




	// Delay until script loaded
	document.addEventListener('DOMContentLoaded', function() {
		// Create donation form object
		window.DashDonate.donationForm = new DonationForm();

		// FOR TESTING
		// FOR TESTING
		// FOR TESTING
		console.log(window.DashDonate);

		setTimeout(function() {
			window.DashDonate.donationForm.goToNextStage();
		}, 500);
		// FOR TESTING
		// FOR TESTING
		// FOR TESTING
	});


	// Create event listener for all assets being loaded (so that Stripe can be initialised)
	window.addEventListener('load', function() {
		window.DashDonate.donationForm.addStripe();
	});


	// Create event listener if 3DS has been completed
	window.addEventListener('message', function(e) {

		// alert('XXX - ' + e.data);

		if (e.data === 'dd_3ds_donateForm_done') {

			// Complete 3Ds authentication
			window.DashDonate.donationForm.complete3DS();
		}
	});


})();
