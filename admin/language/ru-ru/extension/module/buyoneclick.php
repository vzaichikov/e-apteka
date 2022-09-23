<?php
// Heading
$_['heading_name']  	   	= 'XD BuyOneClick v.4.0.3';
$_['heading_title']			= '<span style="font-weight:800; color:#0066cc; text-align:left; font-size:1.25em">XD</span>&nbsp;&nbsp;<i class="fa fa-bolt" style="color:#990000; text-align:left; font-size:1.25em" aria-hidden="true"></i>&nbsp;&nbsp;<span style="font-weight:800; text-align:left; font-size:1.25em"><span style="color:#003366;">BuyOneClick</span> v.4.0.3</span>';

// Text
$_['text_module']       	= 'Модули';
$_['text_extension']   		= 'Модули';
$_['text_success']     		= 'Настройки модуля успешно изменены!';
$_['text_edit']         	= 'Настройки модуля';

//Buttons
$_['button_save'] 			= 'Сохранить';
$_['button_cancel'] 		= 'Отменить';

// Settings
$_['settings_main'] 		= 'Основные настройки';
$_['settings_sms']	 		= 'Настройка SMS';
$_['settings_analytics'] 	= 'Настройка аналитики';

// Fields
$_['field1_title'] 			= 'Имя';
$_['field2_title'] 			= 'Телефон';
$_['field3_title'] 			= 'E-mail';
$_['field4_title'] 			= 'Комментарий';
$_['agree_title'] 			= 'Требовать согласие с ';
$_['field_required']   		= 'Обязательное поле';

// Phone validation
$_['entry_validation_type']			= 'Валидация номера телефона';
$_['value_validation_type1']		= '+7(000)000-00-00';
$_['value_validation_type2']		= '+38(000)000-00-00';
$_['text_validation_type1']			= 'Россия: +7(000)000-00-00';
$_['text_validation_type2']			= 'Украина: +38(000)000-00-00';

$_['text_stock_warning']			= 'Показывать предупреждение о нехватке';

// Entry
$_['entry_name'] 					= 'Текст на кнопке';
$_['entry_success_field'] 			= 'Текст во всплывающем окне (успешная отправка)';
$_['success_field_tooltip']			= 'Текст по умолчанию: "<h4>Спасибо за Ваш заказ!<br />Мы свяжемся с Вами в самое ближайшее время.</h4>". Вы можете использовать html-теги.';

// Success
$_['entry_success_type']			= 'После успешной отправки заказа';
$_['success_type0']					= 'Всплывающее окно (без редиректа)';
$_['success_type1']					= 'Переход на стандартную страницу opencart - "index.php?route=checkout/success"';
$_['success_type_tooltip']			= 'По умолчанию - всплывающее окно без редиректа.';

$_['entry_status_product'] 			= 'Быстрый заказ в карточке товара';
$_['entry_status_category'] 		= 'Быстрый заказ в категории, поиске, производителях и акциях';
$_['entry_status_module'] 			= 'Быстрый заказ в стандартных модулях';
$_['entry_style_status'] 			= 'Использовать стили buyoneclick.css';
$_['entry_option_status'] 			= 'Валидация обязательных опций';

// SMS.ru
$_['smsru_form_title'] 					= 'Настройка <strong>SMS</strong>.ru';
$_['smsru_form_subtitle']				= '<a href="http://ocshop.sms.ru/" target="_blank">Регистрация</a> | <a href="http://ocshop.sms.ru/price" target="_blank">Тарифы</a>';
$_['smsru_api_title']					= 'Ваш api_id';
$_['smsru_api_tooltip']					= 'По умолчанию для отправки СМС используется Ваш api_id (такого вида - XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX), посмотреть который можно у себя в личном кабинете SMS.ru. В этом случае заполнять поля Login и пароль не требуется. Если Вы хотите использовать авторизацию через Login и пароль - не заполняйте данное поле, тогда будут использованы поля Login и пароль.';
$_['smsru_login_title']					= 'Ваш login на sms.ru';
$_['smsru_password_title']				= 'Ваш пароль на sms.ru';
$_['smsru_number_title']				= 'Номер телефона администратора';
$_['smsru_number_tooltip']				= 'Обязательно используйте международный формат: +79876543210. Чтобы бесплатно получать СМС-сообщения (до 5 СМС в день) - необходимо чтобы номер совпадал с номером в личном кабинете sms.ru';
$_['smsru_name_title']					= 'Подпись отправителя';
$_['smsru_name_tooltip']				= 'По умолчанию: Ваш номер телефона. Если Вы хотите установить своё имя в имени отправителя - необходимо согласовать данный вопрос с администрацией sms.ru. Подробнее читайте в разделе "Отправители" Вашего личного кабинета sms.ru.';
$_['smsru_admin_sms_title']				= 'Шаблон сообщения администратору';
$_['smsru_admin_sms_tooltip']			= 'Стандартный шаблон СМС администратору: <b><em>Order {order_number}: {product}. Customer: {name} {phone} {email}.</b></em> <br />Если не знаете что вписать - оставьте пустым! Подробнее о шаблонах Вы можете прочитать здесь: <a href="//xdomus.ru/opencart/buyoneclick-opencart-free/" target="_blank">FAQ по модулю</a>';
$_['smsru_client_sms_title']			= 'Шаблон сообщения покупателю';
$_['smsru_client_sms_tooltip']			= 'Стандартный шаблон СМС покупателю: <b><em>Thank you for your order in our online store "{shop_name}"! Your order number: {order_number}. We will contact you to confirm the order!</b></em> <br />Если не знаете что вписать - оставьте пустым! Подробнее о шаблонах Вы можете прочитать здесь: <a href="//xdomus.ru/opencart/buyoneclick-opencart-free/" target="_blank">FAQ по модулю</a>';
$_['smsru_client_status_title']			= 'Отправка СМС покупателю';
$_['smsru_client_status_tooltip']		= 'Обязательно включите проверку номера телефона!';
$_['smsru_admin_status_title']			= 'Отправка СМС администратору';

// SMSC.ua
$_['smscua_form_title'] 				= 'Настройка <strong>SMSC</strong>.ua';
$_['smscua_form_subtitle']				= '<a href="//smsc.ua/reg/?AD572760" target="_blank">Регистрация</a> | <a href="//smsc.ua/tariffs/?AD572760" target="_blank">Тарифы</a>';
$_['smscua_login_title']				= 'Login SMSC.ua';
$_['smscua_password_title']				= 'Пароль SMSC.ua';
$_['smscua_number_title']				= 'Номер телефона администратора';
$_['smscua_number_tooltip']				= 'Обязательно используйте международный формат: +79876543210';
$_['smscua_name_title']					= 'Подпись отправителя';
$_['smscua_name_tooltip']				= 'Имя отправителя, отображаемое в телефоне получателя. Разрешены английские буквы, цифры, пробел и некоторые символы. Длина – 11 символов или 15 цифр. Все имена регистрируются в личном кабинете.';
$_['smscua_admin_sms_title']			= 'Шаблон сообщения администратору';
$_['smscua_admin_sms_tooltip']			= 'Стандартный шаблон СМС администратору: <b><em>Order {order_number}: {product}. Customer: {name} {phone} {email}.</b></em> <br />Если не знаете что вписать - оставьте пустым! Подробнее о шаблонах Вы можете прочитать здесь: <a href="//xdomus.ru/opencart/buyoneclick-opencart-free/" target="_blank">FAQ по модулю</a>';
$_['smscua_client_sms_title']			= 'Шаблон сообщения покупателю';
$_['smscua_client_sms_tooltip']			= 'Стандартный шаблон СМС покупателю: <b><em>Thank you for your order in our online store "{shop_name}"! Your order number: {order_number}. We will contact you to confirm the order!</b></em> <br />Если не знаете что вписать - оставьте пустым! Подробнее о шаблонах Вы можете прочитать здесь: <a href="//xdomus.ru/opencart/buyoneclick-opencart-free/" target="_blank">FAQ по модулю</a>';
$_['smscua_client_status_title']		= 'Отправка СМС покупателю';
$_['smscua_client_status_tooltip']		= 'Обязательно включите проверку номера телефона!';
$_['smscua_admin_status_title']			= 'Отправка СМС администратору';

// Extended analytics
$_['exan_form_title'] 					= 'Настройка <strong><span style="color:green;">Расширенной</span></strong> аналитики';
$_['exan_status_title']					= 'Включить расширенную аналитику';

// Yandex
$_['ya_form_title'] 					= 'Настройка <strong><span style="color:red;">Я</span>ндекс</strong> цели';
$_['ya_counter_title']					= 'Номер Вашего Яндекс счетчика';
$_['ya_identificator_title']			= 'Идентификатор цели для кнопки &laquo;Быстрый заказ&raquo;';
$_['ya_identificator_send_title']		= 'Идентификатор цели для кнопки &laquo;Отправить&raquo; формы быстрого заказа';
$_['ya_identificator_success_title']	= 'Идентификатор цели при успешной отправке формы';
$_['ya_target_status_title']			= 'Включить Яндекс цель';

// Google
$_['google_form_title'] 				= 'Настройка <strong><span style="color:#4285f4;">G</span><span style="color:#ea4335;">o</span><span style="color:#fbbc05;">o</span><span style="color:#4285f4;">g</span><span style="color:#34a853;">l</span><span style="color:#ea4335;">e</span></strong> цели';
$_['google_category_btn_title']			= 'Категория для кнопки &laquo;Быстрый заказ&raquo;';
$_['google_action_btn_title']			= 'Действие для кнопки &laquo;Быстрый заказ&raquo;';
$_['google_category_send_title']		= 'Категория для кнопки &laquo;Отправить" формы быстрого заказа';
$_['google_action_send_title']			= 'Действие для кнопки &laquo;Отправить" формы быстрого заказа';
$_['google_category_success_title']		= 'Категория для успешной отправки формы быстрого заказа';
$_['google_action_success_title']		= 'Действие для успешной отправки формы быстрого заказа';
$_['google_target_status_title']		= 'Включить Google цель';

$_['text_tab_help']						= 'Помощь';
$_['text_tab_help_title']				= 'Нужна помощь?';
$_['text_help']							= '<p><a href="//xdomus.ru/opencart/buyoneclick-opencart-free/" target="_blank">Описание модуля</a></p><p><a href="//xdomus.ru/opencart/ocmod-instruktsiya-dlya-razrabotchika/" target="_blank">OCMOD - инструкция для разработчика</a></p><p><a href="//xdomus.ru/support/" target="_blank">Отправить запрос на установку модуля (от 500 руб)</a></p>';

// Error
$_['error_permission']  				= 'У Вас нет прав для управления данным модулем!';
$_['error_name'] 						= 'Название модуля должно содержать от 3 до 64 символов!';