<?php
// Heading
$_['heading_name']  	   	= 'XD BuyOneClick v.4.0.3';
$_['heading_title']			= '<span style="font-weight:800; color:#0066cc; text-align:left; font-size:1.25em">XD</span>&nbsp;&nbsp;<i class="fa fa-bolt" style="color:#990000; text-align:left; font-size:1.25em" aria-hidden="true"></i>&nbsp;&nbsp;<span style="font-weight:800; text-align:left; font-size:1.25em"><span style="color:#003366;">BuyOneClick</span> v.4.0.3</span>';

// Text
$_['text_module']   	    = 'Modules';
$_['text_extension']   		= 'Extensions';
$_['text_success']  	    = 'Success: You have modified "XD BuyOneClick" module!';
$_['text_edit']     	    = 'Edit module';

//Buttons
$_['button_save'] 			= 'Save';
$_['button_cancel'] 		= 'Cancel';

// Settings
$_['settings_main'] 		= 'Main settings';
$_['settings_sms']	 		= 'SMS settings';
$_['settings_analytics'] 	= 'Analytics settings';

// Fields
$_['field1_title'] 			= 'Name';
$_['field2_title']		 	= 'Phone';
$_['field3_title'] 			= 'E-mail';
$_['field4_title']	 		= 'Message';
$_['agree_title'] 			= 'Required agree with ';
$_['field_required']  		= 'Required';

// Phone validation
$_['entry_validation_type']			= 'Phone check';
$_['value_validation_type1']		= '+7(000)000-00-00';
$_['value_validation_type2']		= '+38(000)000-00-00';
$_['text_validation_type1']			= 'Russia: +7(000)000-00-00';
$_['text_validation_type2']			= 'Ukraine: +38(000)000-00-00';

$_['text_stock_warning']			= 'Show Out Of Stock Warning';

// Entry
$_['entry_name']        			= 'Text on button';
$_['entry_success_field'] 			= 'Modal window text';
$_['success_field_tooltip']			= 'Using HTML tags is allowed';

// Success
$_['entry_success_type']			= 'After successfully sending the order';
$_['success_type0']					= 'Pop-up window (without redirect)';
$_['success_type1']					= 'Go to the standard opencart success page - "index.php?route=checkout/success"';
$_['success_type_tooltip']			= 'By default - popup without redirect';

$_['entry_status_product']     		= 'Enable in product card';
$_['entry_status_category'] 		= 'Enable in category, search, manufacturer, special';
$_['entry_status_module'] 			= 'Enable in standard modules';
$_['entry_style_status'] 			= 'Enable buyoneclick.css';
$_['entry_option_status'] 			= 'Required options validation';

// SMS.ru
$_['smsru_form_title'] 					= '<strong>SMS</strong>.ru settings';
$_['smsru_form_subtitle']				= '<a href="http://ocshop.sms.ru/" target="_blank">Registration</a> | <a href="http://ocshop.sms.ru/price" target="_blank">Price</a>';
$_['smsru_api_title']					= 'Your api_id';
$_['smsru_api_tooltip']					= 'By default, to send SMS is used your api_id (XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX), which you can see in your private office SMS.ru. In this case, fill in the fields Login and Password is not required. If you want to use authentication through Login and Password - do not fill this field, then the field will be used by the Login and Password.';
$_['smsru_login_title']					= 'Your login on sms.ru';
$_['smsru_password_title']				= 'Your password on sms.ru';
$_['smsru_number_title']				= 'Your phone number';
$_['smsru_number_tooltip']				= 'Use international format: +79876543322';
$_['smsru_name_title']					= 'Sender name';
$_['smsru_name_tooltip']				= 'Default: your phone number. If you want to set your name in the sender\'s name, you need to coordinate this question with the administration of sms.ru. Read more in the section "Senders" of your personal cabinet sms.ru';
$_['smsru_admin_sms_title']				= 'Administrator message template';
$_['smsru_admin_sms_tooltip']			= 'Standard administrator message template: <b><em>Order {order_number}: {product}. Customer: {name} {phone} {email}.</b></em> <br />If you do not know what to enter - leave blank! Read more about the message templates here: <a href="//xdomus.ru/opencart/buyoneclick-opencart-free-english/" target="_blank">FAQ</a><br />';
$_['smsru_client_sms_title']			= 'Customer message template';
$_['smsru_client_sms_tooltip']			= 'Standard customer message template: <b><em>Thank you for your order in our online store "{shop_name}"! Your order number: {order_number}. We will contact you to confirm the order!</b></em> <br />If you do not know what to enter - leave blank! Read more about the message templates here: <a href="//xdomus.ru/opencart/buyoneclick-opencart-free-english/" target="_blank">FAQ</a><br />';
$_['smsru_client_status_title']			= 'Sending SMS for customer';
$_['smsru_client_status_tooltip']		= 'Enable phone verification!';
$_['smsru_admin_status_title']			= 'Sending SMS for admin';

// SMSC.ua
$_['smscua_form_title'] 				= '<strong>SMSC</strong>.ua settings';
$_['smscua_form_subtitle']				= '<a href="//smsc.ua/reg/?AD572760" target="_blank">Регистрация</a> | <a href="//smsc.ua/tariffs/?AD572760" target="_blank">Тарифы</a>';
$_['smscua_login_title']				= 'Login for SMSC.ua';
$_['smscua_password_title']				= 'Password for SMSC.ua';
$_['smscua_number_title']				= 'Admin phone number';
$_['smscua_number_tooltip']				= 'Use international format: +79876543322';
$_['smscua_name_title']					= 'Sender nickname';
$_['smscua_name_tooltip']				= 'Имя отправителя, отображаемое в телефоне получателя. Разрешены английские буквы, цифры, пробел и некоторые символы. Длина – 11 символов или 15 цифр. Все имена регистрируются в личном кабинете.';
$_['smscua_admin_sms_title']			= 'Administrator message template';
$_['smscua_admin_sms_tooltip']			= 'Standard administrator message template: <b><em>Order {order_number}: {product}. Customer: {name} {phone} {email}.</b></em> <br />If you do not know what to enter - leave blank! Read more about the message templates here: <a href="//xdomus.ru/opencart/buyoneclick-opencart-free-english/" target="_blank">FAQ</a><br />';
$_['smscua_client_sms_title']			= 'Customer message template';
$_['smscua_client_sms_tooltip']			= 'Standard customer message template: <b><em>Thank you for your order in our online store "{shop_name}"! Your order number: {order_number}. We will contact you to confirm the order!</b></em> <br />If you do not know what to enter - leave blank! Read more about the message templates here: <a href="//xdomus.ru/opencart/buyoneclick-opencart-free-english/" target="_blank">FAQ</a><br />';
$_['smscua_client_status_title']		= 'Enable sending SMS for customer';
$_['smscua_client_status_tooltip']		= 'Enable phone verification!';
$_['smscua_status_title']				= 'SMSC.ua status';

// Extended analytics
$_['exan_form_title'] 					= '<strong><span style="color:green;">Extended</span></strong> analytics settings';
$_['exan_status_title']					= 'Extended analytics status';

// Yandex
$_['ya_form_title'] 					= '<strong><span style="color:red;">Y</span>andex</strong> Target settings';
$_['ya_counter_title']					= 'Yandex counter number';
$_['ya_identificator_title']			= 'Yandex target identifier on &laquo;BuyOneClick&raquo; button';
$_['ya_identificator_send_title']		= 'Yandex target identifier on form &laquo;Send&raquo; button';
$_['ya_identificator_success_title']	= 'Yandex target identifier on success sending';
$_['ya_target_status_title']			= 'Yandex target status';

// Google
$_['google_form_title'] 				= '<strong><span style="color:#4285f4;">G</span><span style="color:#ea4335;">o</span><span style="color:#fbbc05;">o</span><span style="color:#4285f4;">g</span><span style="color:#34a853;">l</span><span style="color:#ea4335;">e</span></strong> Target settings';
$_['google_category_btn_title']			= 'Category for &laquo;BuyOneClick&raquo; button';
$_['google_action_btn_title']			= 'Action for &laquo;BuyOneClick&raquo; button';
$_['google_category_send_title']		= 'Category for BuyOneClick form &laquo;Send&raquo; button';
$_['google_action_send_title']			= 'Action for BuyOneClick form &laquo;Send&raquo; button';
$_['google_category_success_title']		= 'Category for success BuyOneClick form sending';
$_['google_action_success_title']		= 'Action for success BuyOneClick form sending';
$_['google_target_status_title']		= 'Google target status';

$_['text_tab_help']						= 'HELP';
$_['text_tab_help_title']				= 'NEED HELP?';
$_['text_help']							= '<p><a href="//xdomus.ru/opencart/buyoneclick-opencart-free-english/" target="_blank">Module FAQ</a></p><p><a href="//xdomus.ru/technical-support/" target="_blank">Send request for module installation (25$)</a></p>';

// Error
$_['error_permission'] 					= 'Warning: You do not have permission to modify "XD BuyOneClick" module!';
$_['error_name']        				= 'Module Name must be between 3 and 64 characters!';