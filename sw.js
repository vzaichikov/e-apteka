importScripts('https://storage.googleapis.com/workbox-cdn/releases/7.0.0/workbox-sw.js');

const OFFLINE_HTML = '/pwa/offline.html';
const JQUERY_LIB = '/catalog/view/javascript/jquery/jquery-2.1.1.min.js';
const JQUERY_UI_LIB = '/catalog/view/theme/default/js/lib/jquery-ui-1.12.1.custom/jquery-ui.min.js';
const BOOTSTRAP_LIB = '/catalog/view/javascript/bootstrap/js/bootstrap.min.js';
const BOOTSTRAP_CSS = '/catalog/view/theme/default/stylesheet/bootstrap.min.css';
const FAVICON = '/favicon.ico';


const PRECACHE = [
{url: OFFLINE_HTML, revision: '1001'}, 
{url: JQUERY_LIB, revision: '211'}, 
{url: JQUERY_UI_LIB, revision: '1211'}, 
{url: BOOTSTRAP_LIB, revision: '30'},
{url: BOOTSTRAP_CSS, revision: '30'},
{url: FAVICON, revision: '10'}];


workbox.precaching.precacheAndRoute(PRECACHE);
workbox.navigationPreload.enable();
workbox.googleAnalytics.initialize();

workbox.routing.registerRoute(
	/\.(?:css)$/,
	new workbox.strategies.StaleWhileRevalidate({
		cacheName: 'css',
		plugins: [
		new workbox.expiration.ExpirationPlugin({                
			maxEntries: 100,
			purgeOnQuotaError: true,
		}),
		],
	})
	);

workbox.routing.registerRoute(
	/\.(?:js)$/,
	new workbox.strategies.StaleWhileRevalidate({
		cacheName: 'js',
		plugins: [
		new workbox.expiration.ExpirationPlugin({                
			maxEntries: 100,
			purgeOnQuotaError: true,
		}),
		],
	})
	);

workbox.routing.registerRoute(
	/\.(?:woff|woff2|ttf|otf|eot)$/,
	new workbox.strategies.StaleWhileRevalidate({
		cacheName: 'fonts',
		plugins: [
		new workbox.expiration.ExpirationPlugin({                
			maxEntries: 20,
			purgeOnQuotaError: true,
		}),
		],
	})
	);

workbox.routing.registerRoute(
	({url}) => url.origin === 'https://fonts.googleapis.com' ||
	url.origin === 'https://fonts.gstatic.com',
	new workbox.strategies.StaleWhileRevalidate({
		cacheName: 'google-fonts',
		plugins: [
		new workbox.expiration.ExpirationPlugin({maxEntries: 20}),
		],
	}),
	);

workbox.routing.registerRoute(
	/\.(?:png|gif|jpg|jpeg|svg|webp|avif)$/,
	new workbox.strategies.StaleWhileRevalidate({
		cacheName: 'images',
		plugins: [
		new workbox.expiration.ExpirationPlugin({                
			maxEntries: 200,
			purgeOnQuotaError: true,
		}),
		],
	})
	);


const htmlHandler = new workbox.strategies.NetworkOnly();
const navigationRoute = new workbox.routing.NavigationRoute(({ event }) => {
	const request = event.request;
	return htmlHandler
	.handle({
		event,
		request,
	})
	.catch(() =>
		caches.match(OFFLINE_HTML, {
			ignoreSearch: true,
		})
		);
});
workbox.routing.registerRoute(navigationRoute);