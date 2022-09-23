<?php 
	require_once(DIR_SYSTEM . 'soconfig/classes/soconfig.php');
	if(isset($registry)){$this->soconfig = new Soconfig($registry);}
?>
<?php 
	//Select Type Of Footer
	if(isset($typefooter)){
		$footer_alert = '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Pleases Create Position Footer</div>';
		switch ($typefooter) {
			case "1":
			$footer1 = DIR_TEMPLATE.$theme.'/template/footer/footer1.tpl';
			if (file_exists($footer1)) include($footer1);
			else echo $footer_alert;
			break;
			include(DIR_TEMPLATE.$theme.'/template/footer/footer1.tpl');break;
			case "2":
			$footer2 = DIR_TEMPLATE.$theme.'/template/footer/footer2.tpl';
			if (file_exists($footer2)) include($footer2);
			else echo $footer_alert;
			break;
			case "3":
			$footer3 = DIR_TEMPLATE.$theme.'/template/footer/footer3.tpl';
			if (file_exists($footer3)) include($footer3);
			else echo $footer_alert;
			break;
			
		}
		}else{
		include(DIR_TEMPLATE.$theme.'/template/footer/footer1.tpl');
	}
?>

<?php if(isset($backtop) && $backtop== 1):?>
<!-- MENU OPNE TOP CUSTOM -->
<div class="back-to-top"><i class="fa fa-angle-up"></i></div>
<!-- END-->
<?php endif; ?>

<!-- OneSignal integration -->
<? if ($push_customer_info) { ?>
	<? foreach ($push_customer_info as $field_name => $field_value) { ?>
		<input class="sp_push_custom_data" type="hidden" name="<? echo $field_name; ?>" value="<? echo $field_value; ?>" />
	<? } ?>
<? } ?>
<!-- END-->
<link rel="manifest" href="/manifest.json" />
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async="async"></script>
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
		appId: "2167c7bb-af41-47e7-aefd-1a957b3b4a4e",
		safari_web_id: "web.onesignal.auto.198dbf7d-9488-4e23-8cbd-0647f3be427c",
		requiresUserPrivacyConsent: false,
		autoRegister: false,	
		welcomeNotification: {
			"title": "<? echo $welcome_title; ?>",
			"message": "<? echo $welcome_message; ?>",        
		},		
		promptOptions: {     
			actionMessage: "<? echo $actionMessage; ?>",        
			acceptButtonText: "<? echo $acceptButtonText; ?>",       
			cancelButtonText: "<? echo $cancelButtonText; ?>"
		},
		notifyButton: {
			enable: true, /* Required to use the Subscription Bell */
			/* SUBSCRIPTION BELL CUSTOMIZATIONS START HERE */
			size: 'medium', /* One of 'small', 'medium', or 'large' */
			theme: 'default', /* One of 'default' (red-white) or 'inverse" (white-red) */
			position: 'bottom-left', /* Either 'bottom-left' or 'bottom-right' */
			offset: {
				bottom: '20px',
				left: '20px', /* Only applied if bottom-left */
				right: '0px' /* Only applied if bottom-right */
			},
			prenotify: true, /* Show an icon with 1 unread message for first-time site visitors */
			showCredit: true, /* Hide the OneSignal logo */
			text: {
				'tip.state.unsubscribed': '<? echo $tip_state_unsubscribed; ?>',
				'tip.state.subscribed': "<? echo $tip_state_subscribed; ?>",
				'tip.state.blocked': "<? echo $tip_state_blocked; ?>",
				'message.prenotify': '<? echo $message_prenotify; ?>',
				'message.action.subscribed': "<? echo $message_action_subscribed; ?>",
				'message.action.resubscribed': "<? echo $message_action_resubscribed; ?>",
				'message.action.unsubscribed': "<? echo $message_action_unsubscribed; ?>",
				'dialog.main.title': '<? echo $dialog_main_title; ?>',
				'dialog.main.button.subscribe': '<? echo $dialog_main_button_subscribe; ?>',
				'dialog.main.button.unsubscribe': '<? echo $dialog_main_button_unsubscribe; ?>',
				'dialog.blocked.title': '<? echo $dialog_blocked_title; ?>',
				'dialog.blocked.message': "<? echo $dialog_blocked_message; ?>"
			},
			colors: { // Customize the colors of the main button and dialog popup button
				'circle.background': '#02a8f3',
				'circle.foreground': 'white',
				'badge.background': '#02a8f3',
				'badge.foreground': 'white',
				'badge.bordercolor': 'white',
				'pulse.color': 'white',
				'dialog.button.background.hovering': '#02a8f3',
				'dialog.button.background.active': '#02a8f3',
				'dialog.button.background': '#02a8f3',
				'dialog.button.foreground': 'white'
			},
			/* HIDE SUBSCRIPTION BELL WHEN USER SUBSCRIBED */
			displayPredicate: function() {
				return OneSignal.isPushNotificationsEnabled()
                .then(function(isPushEnabled) {
                    return !isPushEnabled;
				});
			}
		}
	}]);
	OneSignal.push(function() {
		OneSignal.showHttpPrompt();
	});
</script>

<?php if ( $social_fb_status || $social_twitter_status || $social_custom_status ) : ?>
<!-- Social widgets -->
<section class="social-widgets visible-lg">
	<ul class="items">
		<?php if (isset($social_fb_status) && $social_fb_status) : ?>
		<li class="item item-01 facebook">
			<a href="catalog/view/theme/<?php echo $theme ?>/template/social/facebook.php?account=<?php echo $facebook; ?>" class="tab-icon"><span class="fa fa-facebook"></span></a>
			<div class="tab-content">
				<div class="title"><h5>FACEBOOK</h5></div>
				<div class="loading">
					<img src="catalog/view/theme/<?php echo $theme ?>/images/ajax-loader.gif" class="ajaxloader" alt="loader">
				</div>
			</div>
		</li>
		<?php endif; ?>
		
		<?php if (isset($social_twitter_status) && $social_twitter_status ) : ?>
		<li class="item item-02 twitter">
			<a href="catalog/view/theme/<?php echo $theme ?>/template/social/twitter.php?account_twitter=<?php echo $twitter; ?>" class="tab-icon"><span class="fa fa-twitter"></span></a>
			<div class="tab-content">
				<div class="title"><h5>TWITTER FEEDS</h5></div>
				<div class="loading">
					<img src="catalog/view/theme/<?php echo $theme ?>/images/ajax-loader.gif" class="ajaxloader" alt="loader">
				</div>
			</div>
		</li>
		<?php endif; ?>
		
		<?php if (isset($social_custom_status) && $social_custom_status) : ?>
		<li class="item item-03 youtube">
			<div class="tab-icon"><span class="fa fa-youtube"></span></div>
			<div class="tab-content">
				<div class="loading">
					<?php
						if (isset($video_code) && is_string($video_code)) {
							echo html_entity_decode($video_code , ENT_QUOTES, 'UTF-8');
						} else {echo 'Pleases Add Custom Wickget';}
					?>
					
				</div>
			</div>
		</li>
		<?php endif; ?>
	</ul>
</section>
<!-- //end Social widgets -->
<?php endif; ?>
<script type='text/javascript'>
	$(document).ready(function(){ setTimeout(
		(function(){ var widget_id = 'XdK6Tx6O0Y';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})(), 200)});
</script>
<?php
if (!isset($preloader) || $preloader != 0) : ?>
<div class="loader-content">
	<div id="loader">
		<?php if (isset($imgpreloader) && !empty($imgpreloader)) :?>
		<img src="image/<?php echo $imgpreloader ?>"  alt="imgpreloader">
		<?php else : ?>
		<div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
</div>
</body>
</html>