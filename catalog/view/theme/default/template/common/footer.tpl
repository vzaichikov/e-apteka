</div>  <!-- /.site__content -->
<footer class="site__footer footer">

<?php if (!$customer_is_logged && $social_auth_google_app_id) { ?>
    <script>
        var google_auth_script = document.createElement('script');
        google_auth_script.onload = function () {
            var handleCredentialResponse = function(CredentialResponse){
             $.ajax({
                url: "<?php echo $google_auth_callback; ?>",
                method: "POST",
                dataType: "json",
                data: {
                    credential: CredentialResponse.credential
                },
                success: function(json) {
                    console.log("[GAUTH]: Success got response, parsing");
                    if (json.status == true){
                        console.log("[GAUTH] " + json.message);
                        window.location.reload();
                    } else {
                        console.log("[GAUTH] Error, status: " + json.status);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("[GAUTH] Error, possibly 401");
                }
            });
         }

           google.accounts.id.initialize({
            client_id: '<?php echo $social_auth_google_app_id; ?>',
            context: "signin",
            auto_select: "true",
            itp_support: "true",
            nonce: "<?php echo $google_auth_nonce; ?>",
            callback: handleCredentialResponse
        });
           google.accounts.id.prompt();
       };
       google_auth_script.src = 'https://accounts.google.com/gsi/client';

       document.head.appendChild(google_auth_script);
   </script>
<?php } ?>
	
	<div id="boc_order" class="modal fade">
	</div>
	<div id="boc_success" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="text-center"><?php echo $buyoneclick_success_field; ?></div>
					<button type="button" class="btn_close"><?php echo $btn_close_field; ?></button>
				</div>
			</div>
		</div>
	</div>

	<?php include(DIR_TEMPLATEINCLUDE . 'structured/qrcode.tpl'); ?>

<script type="text/javascript"><!--

$(document).ready(function() {

	$('body').on('focus','#boc_form input', function(){
		$(this).parent().removeClass('has-error');
	});
	$('body').on('focus','#boc_form .checkbox label', function(){
		$(this).parent().removeClass('has-error');
	});	
	$('#boc_success .btn_close').on('click', function(){
		$('#boc_success, #boc_order').removeClass('in');
		$('#boc_success, #boc_order').hide();
	})

	$('body').on('submit','#boc_form', function(event) {
		event.preventDefault ? event.preventDefault() : (event.returnValue = false);
		if(!formValidation(event.target)){return false;}
		var sendingForm = $(this);
		var submit_btn = $(this).find('button[type=submit]');
		var value_text = $(submit_btn).text();
		var waiting_text = '<?php echo $text_button_loading; ?>';
		$.ajax({
			url: 'index.php?route=eapteka/buyoneclick/submit',
			type: 'post',
			data: $('#boc_form input[type=\'hidden\'], #boc_form input[type=\'text\'], #boc_form input[type=\'tel\'], #boc_form input[type=\'email\'], #boc_form textarea'),
			dataType: 'json',
			beforeSend: function() {
				$(submit_btn).button('<?php echo $text_button_loading; ?>');
				$(submit_btn).prop( 'disabled', true );
				$(submit_btn).addClass('waiting').text(waiting_text);
			},
			complete: function() {
				$(submit_btn).button('reset');
			},
			success: function(json) {
				console.log('Fastorder success, from footer happened!');
				if (json['success']) {
					var success = true;
					$(sendingForm).trigger('reset');
					$(submit_btn).removeClass('waiting');
					$(submit_btn).text(value_text);
					$(submit_btn).prop( 'disabled', false );
					$('#boc_order').modal('hide');
					$('#boc_order').on('hidden.bs.modal', function (e) {
						if (success) {
							$('#boc_success').modal('show');
							setTimeout(function(){
								$('#boc_success').modal('hide');
							}, 4000);
							success = false;
						}
					});

					$('#ecommerce-result').load('index.php?route=checkout/success&ecommerce=true');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				$(submit_btn).prop( 'disabled', false );
				$(submit_btn).removeClass('waiting').text("ERROR");
				setTimeout(function(){
					$(submit_btn).delay( 3000 ).text(value_text);
				}, 3000);
			}
		});
		event.preventDefault();
	});
});
function formValidation(formElem){
	var elements = $(formElem).find('.required');
	var errorCounter = 0;
	$(elements).each(function(indx,elem){
		var placeholder = $(elem).attr('placeholder');
		if($.trim($(elem).val()) == '' || $(elem).val() == placeholder){
			$(elem).parent().addClass('has-error');
			errorCounter++;
		} else {
			$(elem).parent().removeClass('has-error');
		}
	});

	if ($(formElem).find('#boc_agree').length) {
		if ($(formElem).find('#boc_agree').is(':checked')) {
			$(formElem).find('#boc_agree').parent().parent().removeClass('has-error');
		} else {
			$(formElem).find('#boc_agree').parent().parent().addClass('has-error');
			errorCounter++;
		}
	}

	$(formElem).find('input[name="boc_phone"]').each(function() {
				// console.log('phone testing');
				var pattern = new RegExp(/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$/);
				var data_pattern = $(this).attr('data-pattern');
				var data_placeholder = $(this).attr('placeholder');
				// console.log(pattern.test($(this).val()));
				if(!pattern.test($(this).val()) || $.trim($(this).val()) == '' ){
					console.log('NON valid phone!');
					$('input[name="boc_phone"]').parent().addClass('has-error');
					errorCounter++;
				} else if (data_pattern == 'true') {
					console.log('data-pattern = true');
					if ($(this).val().length < data_placeholder.length) {
						console.log('Phone too short!!!');
						$('input[name="boc_phone"]').parent().addClass('has-error');
						errorCounter++;
					}
				} else {
					$(this).parent().removeClass('has-error');
				}
			});
	if (errorCounter > 0) {
		return false;
	} else {
		return true;
	}
}

function callFastOrderPopup(btnClicked){

	$.ajax({
		url: 'index.php?route=common/buyoneclick/info',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$(btnClicked).button('Секунду');
			$('#boc_order').empty();
			$('#boc_order').append('<div class="lds-rolling"><div></div></div>');
		},
		complete: function() {
			$(btnClicked).button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));
						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

						// Highlight any found errors
						$('.text-danger').parent().addClass('has-error');
					} else {
						$("#boc_order").modal('show');
						$('#boc_order').empty();
						$('#boc_order').html(json['success']);
						
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(thrownError + " | " + xhr.statusText + " | " + xhr.responseText);
				}
			});




}

$(document).ready(function() {	
	$('body').on('click', '.boc_order_category_btn', function(event) {
		var for_post = {};
		for_post.product_id = $(this).attr('data-product_id');
		$.ajax({
			url: 'index.php?route=common/buyoneclick/info',
			type: 'post',
			data: for_post,
			dataType: 'json',
			beforeSend: function() {
				$(event.target).button('loading');
			},
			complete: function() {
				$(event.target).button('reset');
			},
			success: function(json) {
				$('.alert, .text-danger').remove();
				$('.form-group').removeClass('has-error');
				if (json['redirect']) {
					location = json['redirect'];
				} else {
							// console.log(json);
							$("#boc_order").modal('show');
							$('#boc_order').empty();
							$('#boc_order').html(json['success']);
							
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						console.log(thrownError + " | " + xhr.statusText + " | " + xhr.responseText);
					}
				});
	});
});
//--></script>

<div class="subscribe">
	<div class="container">
		<div class="row">
			<div id="footer_app" class="app_wrap col-lg-8 col-md-6 " style="display: none;">
				<div class=" col-lg-5 col-md-12  subscribe__title-wrap">
					<h3 class="subscribe__title"><?php echo $text_pwa_1; ?></h3>
					<p><?php echo $text_pwa_2; ?></p>
				</div>

				<div class="col-lg-offset-1 col-lg-6 col-md-6 subscribe__form">
					<button id="download_app" class="app_btn">
						<i class="fa fa-cloud-download" aria-hidden="true"></i>
						<?php echo $text_pwa_btn_install; ?>
					</button>
				</div>
			</div>


			<div class="col-xlg-3 col-lg-4 col-md-6 subscribe__social">
				<ul class="list-inline social">
					<li class="social__item"><noindex><a class="social__link" href="https://www.facebook.com/agp.kyiv/" rel="nofollow">
						<svg class="icon social__icon">
							<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#facebook-logo"></use>
						</svg></a></noindex></li>
						<li class="social__item"><noindex><a class="social__link" href="https://instagram.com/agp.kyiv/" rel="nofollow">
							<svg class="icon social__icon">
								<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#instagram-logo"></use>
							</svg>
						</a></noindex></li>
					</ul>					
				</div>
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-xlg-10 col-lg-12 col-xlg-offset-1 smlkuvannia-image">
				<span>Самолікування може бути шкідливим для вашого здоров'я</span>
				<p>Перед застосуванням препарату проконсультуйтесь з лікарем</p>										
			</div>
		</div>
	</div>
	
	<div class="hr"></div>
	
	<div class="footer__info">
		<div class="container">

			<?php if ($hb_snippets_local_enable) { ?>
				<?php echo $hb_snippets_local_snippet; ?>
			<?php } ?>

			<script type="application/ld+json">
				{
					"@context": "http://schema.org",
					"@type": "Organization",
					"url": "https://e-apteka.com.ua","logo": "https://e-apteka.com.ua/image/data/logo_02.png",
					"potentialAction": {
						"@type": "SearchAction",
						"target": "<?php echo $search_link; ?>",
						"query-input": "required name=search_term_string"
					},
					"contactPoint" : [
						{
							"@type" : "ContactPoint",
							"telephone" : "+380445200333",
							"contactType" : "Customer Service"
						},
						{
							"@type" : "ContactPoint",
							"telephone" : "+380683450131",
							"contactType" : "Customer Service"
						}],
					"sameAs" : ["https://www.instagram.com/agp.kyiv/","https://www.facebook.com/agp.kyiv/"]}
			</script>									 									 									 									 

			<div class="row">
				
				<div class="col-sm-3">
					
					<div class="footer-info">
						<div class="footer-info__title">
							<?php echo $text_contact_title; ?>
						</div>
						<ul class="footer-info__list">
							<li><a href="<?php echo $contact; ?>" title="<?php echo $text_contact_footer; ?>"><?php echo $text_contact_footer; ?></a></li>							
							<li><?php echo nl2br($address); ?></li>
							<li><a href="tel:<?php echo $phone; ?>" title="<?php echo $phone; ?>"><?php echo $phone; ?></a></li>
							<li><?php echo $email; ?></li>
							<li><i class="fa fa-map-marker" aria-hidden="true"></i> <a href="<?php echo $drugstores; ?>" title="<?php echo $text_drugstores; ?>"><?php echo $text_drugstores; ?></a></li>
						</ul>

						<div class="row">		
							<div class="col-xs-9">	
								<div class="google-revies-wrap">
									<style type="text/css">
										#ratingBadgeContainer {
											position: unset !important;
											margin-top: 10px !important;
											z-index: 0 !important;
										}
										#ratingBadgeContainer iframe{
											max-width: 100% !important;
										}
									</style>

									<script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></script>
									<div id="ratingBadgeContainer" class="footer__ratingbadgecontainer"></div>

									<script>
										window.renderBadge = function() {
											var ratingBadgeContainer = document.getElementById('ratingBadgeContainer');								
											if (typeof(window.gapi) != 'undefined'){

												window.gapi.load('ratingbadge', function() {
													window.gapi.ratingbadge.render(ratingBadgeContainer, {"merchant_id": 258362434});
												});
											}
										}

										$(document).ready(function(){
											renderBadge();
										});
									</script>
								</div>						
							</div>
						</div>
					</div>					
				</div>
				<div class="col-sm-3">
					<div class="footer-info">
						<div class="footer-info__title">
							<?php echo $text_account; ?>
						</div>
						<ul class="footer-info__list">
							<li><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>"><?php echo $text_account; ?></a></li>
							<li><a href="<?php echo $wishlist; ?>" title="<?php echo $text_wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
							<li><a href="<?php echo $loyality; ?>" title="<?php echo $text_loyality; ?>"><?php echo $text_loyality; ?></a></li>
						</ul>

						<div class="footer-info__title margined-top">
							<?php echo $text_extra; ?>
						</div>
						<ul class="footer-info__list">								
							<li><a href="<?php echo $special; ?>" title="<?php echo $text_special; ?>"><?php echo $text_special; ?></a></li>
							<li><a href="<?php echo $promotions; ?>" title="<?php echo $text_promotions; ?>"><?php echo $text_promotions; ?></a></li>
							<li><a href="<?php echo $collections; ?>" title="<?php echo $text_collections; ?>"><?php echo $text_collections; ?></a></li>
							<? /*	<li><a href="<?php echo $manufacturer; ?>" title="<?php echo $text_manufacturers; ?>"><?php echo $text_manufacturers; ?></a></li> */ ?>
							<li><a href="<?php echo $alphabet_drugs; ?>" title="<?php echo $text_alphabet_drugs; ?>"><?php echo $text_alphabet_drugs; ?></a></li>
							<li><a href="<?php echo $newsfeed; ?>" title="<?php echo $text_newsfeed; ?>"><?php echo $text_newsfeed; ?></a></li>
							<li><a href="<?php echo $useful; ?>" title="<?php echo $text_useful; ?>"><?php echo $text_useful; ?></a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="footer-info">
						<div class="footer-info__title">
							<?php echo $text_information; ?>
						</div>
						<ul class="footer-info__list">							
							<?php foreach ($informations as $information) { ?>
								<li><a href="<?php echo $information['href']; ?>" title="<?php echo $information['title']; ?>"><?php echo $information['title']; ?></a></li>
							<?php } ?>
							<li><a href="<?php echo $vacancies; ?>" title="<?php echo $text_vacancies; ?>"><?php echo $text_vacancies; ?></a></li>
						</ul>
					</div>
				</div>
				
				<div class="col-sm-3">	
					<div class="footer-info">
					<div class="footer-info__title">
						<?php echo $text_applications; ?>
					</div>				
					<div class="footer-info__list">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-xs-6" style="margin-bottom:10px;" id="footer_app_google_play">
								<a href="https://play.google.com/store/apps/details?id=ua.com.eapteka.twa" target="_blank" noindex nofollow rel="nofollow" title="Google Play Store">
									<img src="/catalog/view/image/store-play.svg" width="100%" />
								</a>
							</div>

							<div class="col-lg-8 col-md-8 col-xs-6" id="footer_app_button" style="margin-bottom:10px; display: none; cursor: pointer;">
								<img src="/catalog/view/image/pwa_ua.svg" width="100%" />
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="footer__bottom">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center" style="line-height:12px;"><small><?php echo $text_4; ?></small></div>
		</div>
		<div class="row">
			<div class="col-sm-12 text-center"><?php echo $text_2; ?></div>
		</div>
	</div>
</div>

<div class="modal-msg">
	<div class="modal-msg__close">
		<svg class="modal-msg__close-icon">
			<use xlink:href="/catalog/view/theme/default/img/sprite/symbol/sprite.svg#close"></use>
		</svg>
	</div>
	<div class="modal-msg__text"></div>
</div>

</footer>  <!-- /.site__footer -->
</div>  <!-- /.site -->
<div class="main-overlay-popup"></div>


<script src="/catalog/view/javascript/nprogress/nprogress.js" async="async" defer></script>
<script type="text/javascript">
	window.addEventListener('beforeunload', function(event) {
		console.log('beforeunload fired');			
		if (NProgress instanceof Object){				
			NProgress.configure({ showSpinner: false });
			NProgress.start();
			NProgress.inc(0.1);
			setTimeout(function () {
				NProgress.inc(0.5);
			}, 100);
			setTimeout(function () {
				NProgress.done();
				$(".fade").removeClass("out");
			}, 1000);			
		}
	});
</script>

<script>
	function showModalMsg(msg, autoClose = true){
		$('.modal-msg__text').html(msg);
		$('.modal-msg').show(300);
		
		if ( autoClose ) {
			setTimeout(function(){
				$('.modal-msg').hide(300);
			}, 3000);
		}
	}
	
	$('.modal-msg__close').on('click', function(){
		$('.modal-msg').hide(300);
	});
	
	$('.alert__close').on('click', function(){
		$(this).closest('.alert').remove();
	});
	
	$('.js-universalform').on('submit', function(e) {
		e.preventDefault();
		
		var form = $(this);
		
		$.ajax({
			url: '/index.php?route=account/universalform',
			type: 'post',
			data: $(this).serialize(),
			dataType: 'json',
			beforeSend: function() {},
			complete: function() {},
			success: function(json) {
				if(json['success']){
					form[0].reset();
					showModalMsg('<div class="alert-success">' + json['success'] + '</div>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
		
	
	function passwordToggle(elem){
		let passwdInput = elem.prev('input');
		let eye = elem.children('i');
		
		if (passwdInput.attr('type') === "password") {
			passwdInput.attr('type', 'text');
			eye.removeClass('fa-eye, fa-eye-slash').addClass('fa-eye-slash');
		} else {
			passwdInput.attr('type', 'password');
			eye.removeClass('fa-eye, fa-eye-slash').addClass('fa-eye');
		}
	}
	
	$(document).ready(function() {
		$('input[type=password]').after('<span class="password-toggle" onclick="passwordToggle($(this));"><i class="fa fa-eye"></i></span>');
	});
	
</script>

<?php if ($tawkto) { ?>
	<?php echo $tawkto; ?>
<?php } ?>


<?php if($_SERVER['REQUEST_URI'] == "/index.php?route=common/home" || $_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/ru/") { ?>
	<?php if ($is_mobile) { ?>
		<script>
			document.body.onload = addBtnCatalog;

			function addBtnCatalog() {
				var btnCatalog   = document.createElement('button'),
				home_baner   = document.querySelector('.home-banner'),
				mob_catalog_wrap = document.getElementById('mob_catalog'),
				catalog_list = document.querySelector('#catalog .catalog__list-wrap'),
				catalog_list_clone = catalog_list.cloneNode(true);

				btnCatalog.classList.add('btn_mob_catalog');
				btnCatalog.innerHTML = 'Каталог товаров';
				btnCatalog.onclick = function(){
					mob_catalog_wrap.style.display = 'block';
					return false;
				};
				mob_catalog_wrap.querySelector('.close').onclick = function(){
					mob_catalog_wrap.style.display = 'none';
					mob_catalog_wrap.querySelectorAll('.catalog__list-item').forEach(function(e){
						e.classList.remove('is-open')
					});				  		 
					return false;
				}
				home_baner.after(btnCatalog);
				mob_catalog_wrap.append(catalog_list_clone);
			}  	
		</script>
	<?php } ?>
	<div id="mob_catalog" style="display:none;">
		<button type="button" class="close" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php } ?>

<style type="text/css">
    @-webkit-keyframes voice-modal__preview--outer{
	0%{box-shadow:0 0 0 0 rgb(35 173 218 / 60%)}
	30%{box-shadow:0 0 0 12px rgb(35 173 218 / 60%)}
	to{box-shadow:0 0 0 0 #1cacdc}
    }
    @keyframes voice-modal__preview--outer{
	0%{box-shadow:0 0 0 0 rgb(35 173 218 / 60%)}
	30%{box-shadow:0 0 0 12px rgb(35 173 218 / 60%)}
	to{box-shadow:0 0 0 0 rgb(35 173 218 / 60%)}
    }
    #voice_modal{
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	position: fixed;
	overflow: auto;
	margin: 0!important;
	background-color: rgba(0,0,0,.5);
	display: flex;
	align-items: center;
	overflow: hidden!important;
	z-index: 3001!important;
    }
    #voice_modal .wrap-modal{
	width: 288px;
	top: 50%;
	max-height: 100vh;
	overflow-y: auto;
	overflow-x: hidden;
	position: absolute;
	left: 50%;
	transform: translate(-50%, -50%);
	background: #fff;
	border-radius: 4px;
	box-shadow: 0 1px 3px rgb(0 0 0 / 30%);
	min-height: 150px;
	text-align: center;
	transition: padding-top .5s ease-out;
    }
    #voice_modal .wrap-modal .body .content{
	padding: 88px 24px 64px;       
	transition: padding-top .5s ease-out;
	height: 288px;
    }
    #voice_modal .wrap-modal .body.error_voice .voice-modal__icon{
	-webkit-animation: none;
	animation: none;
	border: 2px solid #f30;
	background-color: transparent;
	color:  #f30;
    }
    #voice_modal .wrap-modal .body.error_voice .content{
	padding: 51px 24px;
    }
    #voice_modal .wrap-modal .body .voice-modal__error p{
	line-height: 1.5;
	color: rgba(0,0,0,.87);
	text-align: center;
	max-width: 181px;
	margin: 0 auto 10px;
    }
    #voice_modal .wrap-modal .body .voice-modal__error button{
	line-height: normal;
	font-size: 14px;
	color:#1cacdc;
	cursor: pointer;
	background: 0 0;
	margin: 0 auto;
	border: none;
    font-weight: 600;
    }
    #voice_modal .wrap-modal p{
	font-size: 14px;
	margin-bottom: 0;
    }
    
    #voice_modal .voice-modal__icon{
	width: 64px;
	height: 64px;
	margin: 0 auto 25px;
	background:#1cacdc;
	-webkit-animation: voice-modal__preview--outer 1s ease-out infinite alternate;
	animation: voice-modal__preview--outer 1s ease-out infinite alternate;
	border-radius: 32px;
	position: relative;
	display: flex;
	align-items: center;
	box-shadow: 0 0 0 0 rgb(35 173 218 / 60%);
	justify-content: center;
	color: #fff;
	font-size: 21px;
    }
    #voice_modal .close_modals{
	position: absolute;
	right: 10px;
	width: 25px;
	height: 25px;
	line-height: 25px;
	top: 10px;
	font-size: 15px;
	color: #2121217d;
	cursor: pointer;
	background-image: url(/catalog/view/theme/default/images/close-modal.svg);
	background-size: 11px 11px;
	background-repeat: no-repeat;
	border: 1px solid #000;
	border-radius: 50px;
	text-align: center;
	background-position: center;
	opacity: .5;
	z-index: 10;
	background-color: #fff;
    }
</style>
<div id="voice_modal" class="overlay_modal" style="display: none;">
    <div class="wrap-modal">
        <div class="body">
            <div class="content">
                <button class="close_modals"></button>
                <div class="voice-modal__icon">
                    <i class="fa fa-microphone"></i>
				</div>
                <p class="voice-modal__say">Скажіть що-небудь</p>
                <p class="voice-modal__text-recognize"></p>
                <div class="voice-modal__error">
                    <p class="voice-modal__error-text">
                        Нічого не знайдено, спробуйте ще раз
					</p> 
                    <button class="voice-modal__repeat">
                        Повторити
					</button>
				</div>
			</div>            
		</div>  
	</div>
</div>

<? /* /VOICE SEARCH */ ?>
<style>
	
	.imcallask-btn-mini .imcallask-btn-mini-phone.active:before{
		background-image: url("image/error.png");
		color:white ;
	}
	a.imcallask-btn-mini.hidden-xs {
		/*display: block!important;*/
		display: none;
	}
	
	.footer__bottom_custom .fa{
		font-size: 45px;
	}
	.footer__bottom_custom{
		position: fixed;
		bottom: 140px;
		right: 65px;
		cursor: pointer;
		z-index: 99999;
	}
	.footer__bottom_custom.active{
		display: block;
	}
	.footer__bottom_custom.disactive{
		display: none;
	}
	
	.custom_call{
		cursor: pointer;
		color: #fcfcff;
		background-color: #6fbddbbf;
		border-radius: 50px;
		width: 50px;
		height: 50px;
		padding: 3px;
		margin: 5px;
		text-align: center;
	}
	.smlkuvannia-image{
		text-align: center;
	}
	.smlkuvannia-image span{
		text-transform: uppercase;
		color: #a2a2a2;
		width: 100%;
		text-align: center;
		font-size: 24px;
		letter-spacing: 8px;
	}
	.smlkuvannia-image i{
		font-style: normal;
	}
	.smlkuvannia-image p{
		text-transform: uppercase;
		color: #a2a2a2;
		font-size: 20px;
		letter-spacing: 6px;
	}
	@media screen and (max-width: 1500px){
		.smlkuvannia-image span {
			font-size: 20px;
			letter-spacing: 7px;
		}
		.smlkuvannia-image p {
			font-size: 16px;
			letter-spacing: 7px;
		}

	}
	@media screen and (max-width: 1200px){
		.smlkuvannia-image span {
			font-size: 18px;
			letter-spacing: 3px;
		}
		.smlkuvannia-image p {
			font-size: 14px;
			letter-spacing: 2px;
		}
	}
	@media screen and (max-width: 1000px){
		.smlkuvannia-image span {
			font-size: 16px;
			letter-spacing: 3px;
		}
		.smlkuvannia-image p {
			font-size: 14px;
			letter-spacing: 2px;
		}
	}
	@media screen and (max-width: 767px){
		.smlkuvannia-image span {
			font-size: 16px;
			letter-spacing: 4px;
		}
		.smlkuvannia-image p {
			font-size: 12px;
			letter-spacing: 2px;
		}
	}
	@media screen and (max-width: 650px){
		.smlkuvannia-image span {
			font-size: 12px;
			letter-spacing: 3px;
		}
		.smlkuvannia-image p {
			font-size: 10px;
			letter-spacing: 2px;
		}
	}
	@media screen and (max-width: 500px){
		.smlkuvannia-image span {
			font-size: 12px;
			letter-spacing: 2px;
			margin-bottom: 6px;
			display: block;
		}
		.smlkuvannia-image span i {
			display: block;
			font-size: 33px;
		}
		.smlkuvannia-image p {
			font-size: 10px;
			letter-spacing: 2px;
			line-height: 1.1;
		}
		.smlkuvannia-image p i {
			display: block;
			font-size: 52px;

		}
	}
	@media screen and (max-width: 400px){
		.smlkuvannia-image span {
			font-size: 12px;
		}
		.smlkuvannia-image span i {
			display: block;
			font-size: 24px;
		}
		.smlkuvannia-image p {
			font-size: 10px;
		}
		.smlkuvannia-image p i {
			display: block;
			font-size: 38px;

		}
	}
</style>

<link href="<?php echo $general_minified_css_uri; ?>" rel="stylesheet" type="text/css" />

<?php if (!empty($general_minified_js_uri)) { ?>
					<script src="<?php echo $general_minified_js_uri; ?>" type="text/javascript"></script>
				<?php } ?>

<? /* VOICE SEARCH */ ?>
<script>
	
	$('document').ready(function(){

		window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
		
		if (window.SpeechRecognition) {
			console.log('Voice search supported, triggering');
			var current_input = $('#main-search').val();
			$('#main-search').after('<button class="voice_search_btn" id="voice-search-btn"><i class="fa fa-microphone"></i></button>');
						
			var recognition = new SpeechRecognition();
			recognition.interimResults = true;
			recognition.lang = 'ru-RU';
			recognition.addEventListener('result', _recognitionResultHandler);
			recognition.addEventListener('end', _recognitionEndHandler);
			recognition.addEventListener('error', _recognitionErrorHandler);
			recognition.addEventListener('nomatch', _recognitionNoMatchHandler);
			recognition.addEventListener('onnomatch', _recognitionNoMatchHandler);
			
			$('#voice-search-btn, #voice_modal .voice-modal__repeat').on('click touch', listenStart);
			
			$('.close_modals').on('click touch', function(){
				$('#voice_modal').hide(); 
				_recognitionEndHandler();        
			});
			
			function listenStart(e){
				e.preventDefault();
				$('#voice_modal').show();
				
				$('#voice_modal .voice-modal__say').html("<?php echo $text_retranslate_29; ?>");
				$('#voice_modal .voice-modal__say').show();               
				$('#voice_modal .body').removeClass('error_voice');
				$('#voice_modal .voice-modal__error').hide();
				
				
				$('#main-search').val('').attr("placeholder", "<?php echo $text_retranslate_29; ?>");
				$('#main-search').addClass('voice_input_active');
				$('#voice-search-btn').addClass('active');    
				recognition.start();
			}
			
			function _recognitionErrorHandler(e){
				console.log('_recognitionErrorHandler fired');
				
				$('#voice_modal .body').addClass('error_voice');
				$('#voice_modal .voice-modal__error').show();
				$('#voice_modal .voice-modal__say').hide();  
				
				$('#main-search').val(current_input);
				$('#voice-search-btn').removeClass('active');
				$('#main-search').removeClass('voice_input_active');
			}
			
			function _recognitionEndHandler(e){
				console.log('_recognitionEndHandler fired');
				$('#voice-search-btn').removeClass('active');
				$('#main-search').removeClass('voice_input_active').attr("placeholder", "<?php echo $text_retranslate_35; ?>");
				
			}
			
			function _recognitionNoMatchHandler(e){         
				console.log('_recognitionNoMatchHandler fired');
				$('#main-search').val(current_input); 
				
				$('#voice_modal .body').addClass('error_voice');
				$('#voice_modal .voice-modal__error').show();
				$('#voice_modal .voice-modal__say').hide();              
			}
			
			
			function _recognitionResultHandler(e) {		
				console.log('_recognitionResultHandler fired');
				if (e.results.length){
					
					speechOutput = Array.from(e.results).map(function (result) { return result[0] }).map(function (result) { return result.transcript }).join('')
					
					$('#main-search').val(speechOutput);
					$('#voice_modal .voice-modal__text-recognize').html(speechOutput);   
					$('#voice_modal .voice-modal__say').hide();  
					if (e.results[0].isFinal) {
						$('#submit_search1').trigger('click');
					} 
					
					} else {
					_recognitionNoMatchHandler(e);
				}
			}
			
			
			} else {
			console.log('Voice search not supported');
		}
		
	});
</script>
<? /* END VOICE SEARCH */ ?>
<script>
	function reloadAjaxReloadableGroupWithOutParameters(group, modules){		
		if (modules.length > 0){
			
			let uri = 'index.php?route=eapteka/ajax&modpath=' + modules.join(';') + '&group=' + group;
			
			$.ajax({
				url: uri,
				type: 'GET',
				async: true,
				dataType: 'json',
				success: function(json){					
					$.each(json, function(i, item) {
						$('.ajax-module-reloadable[data-modpath="'+ item.path +'"]').html(item.html);
					});
				},
				error: function(error){
					console.log(error);
				}
			});
			
		}
		
	}
	
	function reloadAjaxReloadableElement(elem){
		let uri = 'index.php?route=eapteka/ajax&modpath=' + elem.attr('data-modpath');
		if (elem.attr('data-x')){
			uri += '&x=' + elem.attr('data-x');
		}
		if (elem.attr('data-y')){
			uri += '&y=' + elem.attr('data-y');
		}
		
		if (elem.attr('data-afterload') && typeof window[elem.attr('data-afterload')] == 'function'){
			elem.load(uri, function(returnData){ window[elem.attr('data-afterload')](returnData); });
		} else {
			elem.load(uri);
		}
	}
	
	$(document).ready(function(){
		var reloadableGroups = [];
		
		$('.ajax-module-reloadable').each(function(index, elem){
			if ($(this).attr('data-reloadable-group')){
				let newReloadableGroup = $(this).attr('data-reloadable-group');
				if (reloadableGroups.indexOf(newReloadableGroup) < 0){
					reloadableGroups.push(newReloadableGroup);
				}
				//	reloadAjaxReloadableElement($(this));
			} else {
				reloadAjaxReloadableElement($(this));
			}
		});
		
		reloadableGroups.forEach(function(group){
			let reloadableGroupModules = [];
			
			$('*[data-reloadable-group="'+ group +'"]').each(function(index, elem){
				let reloadableItemModPath = $(this).attr('data-modpath');
				
				if (reloadableGroupModules.indexOf(reloadableItemModPath) < 0){
					reloadableGroupModules.push(reloadableItemModPath);
				}				
			});
			
			reloadAjaxReloadableGroupWithOutParameters(group, reloadableGroupModules);
			
		});
		
		$('.ajax-module-reloadable').each(async function(index, elem){
			//	reloadAjaxReloadableElement($(this));
		});
	});
	
	function updateActiveCouponInBlock(productBlock, active_coupon){
		let html = '';
		html += '<div class="product__line__promocode">';
		html += '<span>'+ active_coupon.coupon_price +'</span>'
		html += '<span class="product__line__promocode__text"><?php echo $text_promocode_price;?></span>';
		html +=	'<span class="product__line__promocode__code">'+ active_coupon.code +'</span>';
		html +=	'</div>';
		
		productBlock.find('.product__delivery').before(html);
	}
	
	function updateActiveActionsInBlock(productBlock, active_actions){
		let html = '';
		active_actions.forEach(async function(active_action){
			html += '<div class="product__label-hit" style="color:#'+active_action.label_color+'; --tooltip-color:#' + active_action.label_background + '; background-color:#' + active_action.label_background + '; --tooltip-color-txt:#' + active_action.label_color + '"'; 
			if (active_action.label_text){
				html += 'data-tooltip="' + active_action.label_text + '"';
			}
			html += '>';
			html += active_action.label;
			html += '</div>';			
		});
		if( $(html).length == 0) {
			productBlock.find('.product__label').prepend(html);
		} 
		
	}
	
	function updatePriceInBlock(productBlock, price){
		
	}
	
	function updateProductBlock(productBlock, item){
		//Активные промокоды
		if (item.active_coupon){
			updateActiveCouponInBlock(productBlock, item.active_coupon);
		}
		
		if (item.active_actions){
			updateActiveActionsInBlock(productBlock, item.active_actions);
		}
	}
	
	function updateProductBlocks(json){
		json.forEach(async function(item){
			let productBlocks = $('.product__item__reloadable[data-product-id=\''+ item.product_id +'\']');
			if (productBlocks.length > 0){
				productBlocks.each(function( index ){ updateProductBlock($(this), item); });
			}
		});
	}
	
	$(document).ready(function(){
		var productsOnPage = [];
		$('.product__item__reloadable').each(function(index, elem){
			let productBlock = $(this);
			
			if (productBlock.attr('data-product-id') !== null){
				productsOnPage.push(productBlock.attr('data-product-id'));
			}						
		});
		
		<? if (!CRAWLER_SESSION_DETECTED) { ?>	
			if (productsOnPage.length > 0){
				$.ajax({
					url: "index.php?route=product/product/getProductsArrayDataJSON",
					type: 'POST',
					async: true,
					data: {
						x: productsOnPage
					},
					dataType: 'json',
					success: function(json){					
						updateProductBlocks(json);
					},
					error: function(error){
						console.log(error);
					}
				});
			}
		<? } ?>
	});
	
</script>

<script>
	$(document).ready(function(){
		setTimeout(function(){ $.get('index.php?route=common/footer/online') }, 1500);
	});
</script>

</body></html>