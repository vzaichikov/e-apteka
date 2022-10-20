<link rel="manifest" href="/manifest.json?rand=<?php echo mt_rand(0, 1000); ?>">
<script>
	function pushPWAEvent(eventAction){
		window.dataLayer = window.dataLayer || [];	
		
		dataLayer.push({
			event: 'PWA',
			eventCategory: 'PWA',
			eventAction: eventAction
		});
	}

	function pushAppMode(mode){
		window.dataLayer = window.dataLayer || [];	
		
		dataLayer.push({
			event: 'workmode',
			eventCategory: mode,
			eventAction: 'pageview'
		});
	}
	
	if ("Notification" in window) {
		console.log("[PWA] The Notifications API is supported");
	}
	
	if (Notification.permission === "granted") {
		console.log("[PWA] The user already accepted");
	}
	
	/* проверяем, ведроид ли это, чтоб не показывать на айфонах линк на гугл плей*/
	function isIphone(){		
		var ua = navigator.userAgent.toLowerCase();
		return (ua.indexOf("iphone") > -1 || ua.indexOf("ipad") > -1);				
	}
	
	/* Узнаем ширину экрана пользователя */
	function getUserWindowWidth(){
		return window.innerWidth || document.body.clientWidth;
	}
	
	/* проверяем, маленький ли экранчик */
	function isSmallScreen(){
		return (getUserWindowWidth() <= 480);
	}
	
	function sendSimpleXHRWithCallback(uri, done){
		let xhr = new XMLHttpRequest();
		xhr.open('GET', uri);
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		
		xhr.onload = function() {
			console.log(xhr.response);
			done(JSON.parse(xhr.response));
		}
		
		xhr.send();
	}
	
	function sendSimpleXHR(uri){
		let xhr = new XMLHttpRequest();
		xhr.open('GET', uri);
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		
		xhr.onload = function() {
			console.log(xhr.response);
		}
		
		xhr.send();
	}
	
	function sendInstallEvent(){	
		console.log('[PWA] Sending PWA install event to engine');				
		sendSimpleXHR('<?php echo $base;?>index.php?route=eapteka/pwa/spi');			
	}
	
	
	function setPWASession(t){
		console.log('[PWA] Sending PWA session event to engine');				
		sendSimpleXHR('<?php echo $base;?>index.php?route=eapteka/pwa/sps');
	}
	
	if ("serviceWorker" in navigator) {
		console.log("[PWA] ServiceWorker is in navigator, continue");
		if (navigator.serviceWorker.controller) {
			console.log("[PWA] active service worker found, no need to register");
			} else {
			navigator.serviceWorker
			.register("/sw.js?v=105", {scope: "/"})
			.then(function (reg) {
				console.log("[PWA] Service worker has been registered for scope: " + reg.scope);
			});
		}
		}  else {
		console.log("[PWA] ServiceWorker NOT in navigator, bad luck");		
	}
	
	let deferredPrompt = null;
	
	window.addEventListener('beforeinstallprompt', function(e) {			
		e.preventDefault(); 
		window.deferredPrompt = e;		
		pushPWAEvent('beforeinstallprompt');
		console.log('[PWA] EAPTEKA PWA APP beforeinstallprompt fired');			
		
		showInstallFooterBlock();
		showInstallListingBlock();
	});		
	
	function showPrompt(){
		
		let promptEvent = window.deferredPrompt;
		if (promptEvent) {
			
			pushPWAEvent('pwainstallbuttonclicked');
			promptEvent.prompt();
			promptEvent.userChoice.then(function(choiceResult){
				
				if (choiceResult.outcome === 'accepted') {
					pushPWAEvent('pwainstall');
					sendInstallEvent();
					localStorage.setItem('pwaaccepted', 'true');								
					console.log('[PWA] EAPTEKA PWA APP is installed');							
					} else {
					pushPWAEvent('beforeinstallpromptdeclined');
					localStorage.setItem('pwadeclined', 'true');
					console.log('[PWA] EAPTEKA PWA APP is not installed');
				}
				
				promptEvent = null;
				
			});
		}
		
	}
	
	/* Вешаем триггер установки pwa на кнопку  */
	function hangClickInstallEvent(elementID){
		let pwaInstallButton = document.getElementById(elementID);	
		
		if (pwaInstallButton != null){
			pwaInstallButton.addEventListener('click', async () => {
				showPrompt();
			});
		}
	}
	
	/* Проверить существование элемента и показать его, если существует  */
	function validateAndShowBlockByID(elementID){
		let elementBlock = document.getElementById(elementID);	
		
		if (elementBlock != null){
			elementBlock.style.display = 'block';
		}
	}
	
	/* Проверить существование элемента и скрыть его, если существует  */
	function validateAndHideBlockByID(elementID){
		let elementBlock = document.getElementById(elementID);	
		
		if (elementBlock != null){
			elementBlock.style.display = 'none';
		}
	}
	
	/* Триггер отправки в аналитику установки PWA приложения  */
	window.addEventListener('appinstalled', function(e) {
		pushPWAEvent('pwainstall');				
	});			
	
	/* Вешаем триггеры установки и отсылаем инфу о просмотре в аналитику */
	document.addEventListener("DOMContentLoaded", function() {
		
		/* При загрузке покажем блоки, ведущие на play store всем, кроме айфонов*/
		if (!isIphone()){
			validateAndShowBlockByID('footer_app_google_play');

			if (!isStandaloneAPP() && !isTWAApp()){
				validateAndShowBlockByID('top-temprorary-banner-wrap');
			}
		}
		
		hangClickInstallEvent('download_app');
		hangClickInstallEvent('footer_app_button');		
		
		if (!isTWAApp() && !isStandaloneAPP()){
			pushAppMode('browser');
		}

		if (isTWAApp()){
			console.log('[PWA] sending pwapageview event');
			pushPWAEvent('twapageview');
			pushAppMode('twa');
			setPWASession(true);
		}
		
		if (isStandaloneAPP()){
			console.log('[PWA] sending pwapageview event');
			pushPWAEvent('pwapageview');
			pushAppMode('pwa');
			setPWASession(true);
		}
	});
	
	/* Функция проверки запуска в режиме TWA / Android Native */
	function isTWAApp(){
		
		if (document.referrer.includes('android-app://')) {
			console.log('[PWA] display-mode is standalone: android-app/TWA');
			return true;
		}
		
		return false;
		
	}
	
	/* Функция проверки режима запуска приложения */
	function isStandaloneAPP(){
		if (window.matchMedia('(display-mode: standalone)').matches) {
			console.log('[PWA] display-mode is standalone: display-mode');
			return true;
		}
		
		/* Вынесли в отдельную функцию */
		if (document.referrer.includes('android-app://')) {
			console.log('[PWA] display-mode is standalone: android-app/TWA');
			//	return true;
		}
		
		if ('standalone' in navigator && window.navigator.standalone === true) {
			console.log('[PWA] display-mode is standalone:  window.navigator.standalone = true');
			return true;
		}
		
		console.log('[PWA] display-mode is not standalone');
		return false;
	}
	
	/* Отображение блока установки в футере */
	function showInstallFooterBlock(){
		
		/* Прячем блок с ссылкой на play store, только для мобильных */
		if (isSmallScreen()){
		//validateAndHideBlockByID('footer_app_google_play');
		}
		
		/* Показываем блок установки, только для мобильных */
		if (isSmallScreen()){
			validateAndShowBlockByID('footer_app');
		}
		
		/* Показываем кнопку в блоке "наши приложения" */
		validateAndShowBlockByID('footer_app_button');
	}
	
	/* Отображение блока установки в каталоге */
	function showInstallListingBlock(){
		
		/* Прячем блок с ссылкой на play store */
		if (isSmallScreen()){
			validateAndHideBlockByID('listing_app_google_play');
		}
		
		/* Показываем блок установки */
		if (isSmallScreen()){
			validateAndShowBlockByID('listing_app');
		}
	}
	
	/*проверка поддержки localStorage*/
	function localStorageSupported(){
		try {
			localStorage.setItem('lstest', 'lstest');
			localStorage.removeItem('lstest');
			return true;
			} catch(e) {
			return false;
		}
	}
</script>