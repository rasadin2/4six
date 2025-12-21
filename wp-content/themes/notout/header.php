<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package notout
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- Google Translate Script -->
	<script type="text/javascript">
		function googleTranslateElementInit() {
			new google.translate.TranslateElement({
				pageLanguage: 'bn',
				includedLanguages: 'bn,en',
				layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
				autoDisplay: false
			}, 'google_translate_element');
		}
	</script>
	<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

	<style>
		/* Hide Google Translate default widget */
		#google_translate_element {
			display: none;
		}

		/* Hide Google Translate toolbar */
		.goog-te-banner-frame.skiptranslate {
			display: none !important;
		}

		body {
			top: 0px !important;
		}

		.goog-te-gadget {
			display: none !important;
		}

		/* Optional: Style for language links */
		.lang-switcher a {
			cursor: pointer;
			text-decoration: none;
		}

		.lang-switcher a:hover {
			text-decoration: underline;
		}
	</style>

	<?php wp_head(); ?>

	<script type="text/javascript">
		function setCookie(key, value, expiry) {
			var expires = new Date();
			expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
			document.cookie = key + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
		}

		function getCookie(key) {
			var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
			return keyValue ? keyValue[2] : null;
		}

		function translateToEnglish() {
			setCookie('googtrans', '/bn/en', 1);
			setCookie('googtrans', '/bn/en', 1);
			window.location.reload();
		}

		function translateToBangla() {
			setCookie('googtrans', '/bn/bn', 1);
			setCookie('googtrans', '/bn/bn', 1);
			window.location.reload();
		}

		// Wait for Google Translate to load
		function checkGoogleTranslate() {
			if (typeof google !== 'undefined' && google.translate) {
				console.log('Google Translate loaded successfully');
			} else {
				setTimeout(checkGoogleTranslate, 100);
			}
		}

		window.addEventListener('load', function() {
			checkGoogleTranslate();
		});
	</script>
</head>

<body <?php body_class(); ?>>
<?php  
	/**
	 * notout_before_site_container hook
	 */
	do_action( 'notout_before_site_container' );
?>
<div id="page" class="notout-site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'notout' ); ?></a>
	
	<?php  
		/**
		 * notout_before_header_menu hook
		 */
		do_action( 'notout_before_header_menu' );
	?>

	<?php notout_menu(); ?>

	<?php  
		/**
		 * notout_after_header_menu hook
		 * 
		 * notout_page_header - 10
		 */
		do_action( 'notout_after_header_menu' );
	?>

	<div id="content" class="notout-site-content">	