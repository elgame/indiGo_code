<?php 
		// Include required library files.
		require_once(APPPATH.'libraries/paypal/config.php');
		require_once(APPPATH.'libraries/paypal/paypal.class.php');

		$returnurl = base_url('paquete/payment');

		$cancelurl = base_url('paquete/cancel');

		$PayPalConfig = array('Sandbox' => $sandbox, 'APIUsername' => $api_username, 'APIPassword' => $api_password, 'APISignature' => $api_signature);
		$PayPal = new PayPal($PayPalConfig);

		$SECFields = array(
							'token' => '', 								// A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
							'maxamt' => '30000.00', 						// The expected maximum total amount the order will be, including S&H and sales tax.
							'returnurl' => $returnurl, 							// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
							'cancelurl' => $cancelurl, 							// Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
							'callback' => '', 							// URL to which the callback request from PayPal is sent.  Must start with https:// for production.
							'callbacktimeout' => '', 					// An override for you to request more or less time to be able to process the callback request and response.  Acceptable range for override is 1-6 seconds.  If you specify greater than 6 PayPal will use default value of 3 seconds.
							'callbackversion' => '', 					// The version of the Instant Update API you're using.  The default is the current version.
							'reqconfirmshipping' => '', 				// The value 1 indicates that you require that the customer's shipping address is Confirmed with PayPal.  This overrides anything in the account profile.  Possible values are 1 or 0.
							'noshipping' => '', 						// The value 1 indiciates that on the PayPal pages, no shipping address fields should be displayed.  Maybe 1 or 0.
							'allownote' => '1', 							// The value 1 indiciates that the customer may enter a note to the merchant on the PayPal page during checkout.  The note is returned in the GetExpresscheckoutDetails response and the DoExpressCheckoutPayment response.  Must be 1 or 0.
							'addroverride' => '', 						// The value 1 indiciates that the PayPal pages should display the shipping address set by you in the SetExpressCheckout request, not the shipping address on file with PayPal.  This does not allow the customer to edit the address here.  Must be 1 or 0.
							'localecode' => '', 						// Locale of pages displayed by PayPal during checkout.  Should be a 2 character country code.  You can retrive the country code by passing the country name into the class' GetCountryCode() function.
							'pagestyle' => '', 							// Sets the Custom Payment Page Style for payment pages associated with this button/link.
							'hdrimg' => base_url('application/images/logo.png'), 							// URL for the image displayed as the header during checkout.  Max size of 750x90.  Should be stored on an https:// server or you'll get a warning message in the browser.
							'hdrbordercolor' => '', 					// Sets the border color around the header of the payment page.  The border is a 2-pixel permiter around the header space.  Default is black.
							'hdrbackcolor' => '', 						// Sets the background color for the header of the payment page.  Default is white.
							'payflowcolor' => '', 						// Sets the background color for the payment page.  Default is white.
							'skipdetails' => '1', 						// This is a custom field not included in the PayPal documentation.  It's used to specify whether you want to skip the GetExpressCheckoutDetails part of checkout or not.  See PayPal docs for more info.
							'email' => '', 								// Email address of the buyer as entered during checkout.  PayPal uses this value to pre-fill the PayPal sign-in page.  127 char max.
							'solutiontype' => 'Sole', 						// Type of checkout flow.  Must be Sole (express checkout for auctions) or Mark (normal express checkout)
							'landingpage' => 'Billing', 						// Type of PayPal page to display.  Can be Billing or Login.  If billing it shows a full credit card form.  If Login it just shows the login screen.
							'channeltype' => '', 						// Type of channel.  Must be Merchant (non-auction seller) or eBayItem (eBay auction)
							'giropaysuccessurl' => '', 					// The URL on the merchant site to redirect to after a successful giropay payment.  Only use this field if you are using giropay or bank transfer payment methods in Germany.
							'giropaycancelurl' => '', 					// The URL on the merchant site to redirect to after a canceled giropay payment.  Only use this field if you are using giropay or bank transfer methods in Germany.
							'banktxnpendingurl' => '',  				// The URL on the merchant site to transfer to after a bank transfter payment.  Use this field only if you are using giropay or bank transfer methods in Germany.
							'brandname' => 'Tienda de conocimiento Capp', 							// A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
							'customerservicenumber' => '(312) 312 4311', 				// Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
							'giftmessageenable' => '0', 					// Enable gift message widget on the PayPal Review page. Allowable values are 0 and 1
							'giftreceiptenable' => '0', 					// Enable gift receipt widget on the PayPal Review page. Allowable values are 0 and 1
							'giftwrapenable' => '0', 					// Enable gift wrap widget on the PayPal Review page.  Allowable values are 0 and 1.
							'giftwrapname' => 'Box with Ribbon', 						// Label for the gift wrap option such as "Box with ribbon".  25 char max.
							'giftwrapamount' => '0.00', 					// Amount charged for gift-wrap service.
							'buyeremailoptionenable' => '1', 			// Enable buyer email opt-in on the PayPal Review page. Allowable values are 0 and 1
							'surveyquestion' => 'Did you like this checkout?', 					// Text for the survey question on the PayPal Review page. If the survey question is present, at least 2 survey answer options need to be present.  50 char max.
							'surveyenable' => '1', 						// Enable survey functionality. Allowable values are 0 and 1
							'buyerid' => '', 							// The unique identifier provided by eBay for this buyer. The value may or may not be the same as the username. In the case of eBay, it is different. 255 char max.
							'buyerusername' => '', 						// The user name of the user at the marketplaces site.
							'buyerregistrationdate' => '',  			// Date when the user registered with the marketplace.
							'allowpushfunding' => ''					// Whether the merchant can accept push funding.  0 = Merchant can accept push funding : 1 = Merchant cannot accept push funding.
						);

		// Basic array of survey choices.  Nothing but the values should go in here.
		$SurveyChoices = array('Yes', 'No');

		$Payments = array();
		$Payment = array(
						'amt' => '0.00', 							// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
						'currencycode' => 'MXN', 					// A three-character currency code.  Default is USD.
						'itemamt' => '0.00', 						// Required if you specify itemized L_AMT fields. Sum of cost of all items in this order.
						'shippingamt' => '00.00', 					// Total shipping costs for this order.  If you specify SHIPPINGAMT you mut also specify a value for ITEMAMT.
						'insuranceoptionoffered' => '', 		// If true, the insurance drop-down on the PayPal review page displays the string 'Yes' and the insurance amount.  If true, the total shipping insurance for this order must be a positive number.
						'handlingamt' => '', 					// Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
						'taxamt' => '0.00', 						// Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order.
						'desc' => 'This is a test order.', 							// Description of items on the order.  127 char max.
						'custom' => '', 						// Free-form field for your own use.  256 char max.
						'invnum' => '', 						// Your own invoice or tracking number.  127 char max.
						'notifyurl' => '',  						// URL for receiving Instant Payment Notifications
						'shiptoname' => '', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
						'shiptostreet' => '', 					// Required if shipping is included.  First street address.  100 char max.
						'shiptostreet2' => '', 					// Second street address.  100 char max.
						'shiptocity' => '', 					// Required if shipping is included.  Name of city.  40 char max.
						'shiptostate' => '', 					// Required if shipping is included.  Name of state or province.  40 char max.
						'shiptozip' => '', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
						'shiptocountry' => '', 					// Required if shipping is included.  Country code of shipping address.  2 char max.
						'shiptophonenum' => '',  				// Phone number for shipping address.  20 char max.
						'notetext' => 'This is a test note before ever having left the web site.', 						// Note to the merchant.  255 char max.
						'allowedpaymentmethod' => '', 			// The payment method type.  Specify the value InstantPaymentOnly.
						'paymentaction' => 'Sale', 					// How you want to obtain the payment.  When implementing parallel payments, this field is required and must be set to Order.
						'paymentrequestid' => '',  				// A unique identifier of the specific payment request, which is required for parallel payments.
						'sellerpaypalaccountid' => ''			// A unique identifier for the merchant.  For parallel payments, this field is required and must contain the Payer ID or the email address of the merchant.
						);

		//*************  Se asignan los productos  **********************//
		$PaymentOrderItems = array();
		foreach ($datapa as $key => $value) {
			$Item = array(
					'name' => $value['titulo'], 							// Item name. 127 char max.
					'desc' => '', 							// Item description. 127 char max.
					'amt' => String::float($value['precio']), 								// Cost of item.
					'number' => '', 							// Item number.  127 char max.
					'qty' => '1', 								// Item qty on order.  Any positive integer.
					'taxamt' => '', 							// Item sales tax
					'itemurl' => '', 							// URL for the item.
					'itemweightvalue' => '', 					// The weight value of the item.
					'itemweightunit' => '', 					// The weight unit of the item.
					'itemheightvalue' => '', 					// The height value of the item.
					'itemheightunit' => '', 					// The height unit of the item.
					'itemwidthvalue' => '', 					// The width value of the item.
					'itemwidthunit' => '', 					// The width unit of the item.
					'itemlengthvalue' => '', 					// The length value of the item.
					'itemlengthunit' => '',  					// The length unit of the item.
					'ebayitemnumber' => '', 					// Auction item number.
					'ebayitemauctiontxnid' => '', 			// Auction transaction ID number.
					'ebayitemorderid' => '',  				// Auction order ID number.
					'ebayitemcartid' => ''					// The unique identifier provided by eBay for this order from the buyer. These parameters must be ordered sequentially beginning with 0 (for example L_EBAYITEMCARTID0, L_EBAYITEMCARTID1). Character length: 255 single-byte characters
					);
			$total += $Item['amt'];
			array_push($PaymentOrderItems, $Item);
		}

		$Payment['amt']         = $total;
		$Payment['itemamt']     = $total;

		$Payment['order_items'] = $PaymentOrderItems;
		array_push($Payments, $Payment);

		$PayPalRequest = array(
							   'SECFields' => $SECFields,
							   'SurveyChoices' => $SurveyChoices,
							   'Payments' => $Payments
							   );

		$payresult = $PayPal->SetExpressCheckout($PayPalRequest);
		redirect($payresult['REDIRECTURL']);