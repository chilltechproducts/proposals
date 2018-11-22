 
<body class="header-page  wsite-theme-light  wsite-page-news"><div class="wrapper">
		<div class="header-wrap">
			<div class="nav-wrap">
				<div id="logo"><span class="wsite-logo">

	<a href="/">
	
	<span id="wsite-title">CHILL TECH PRODUCTS</span>
	
	</a>

</span></div>
				<label class="hamburger"><span></span></label>
				<?php include(dirname(__FILE__) . "/welcome_menu.php"); ?>
			</div>

			<div class="banner-wrap">
				<div class="wsite-elements wsite-not-footer wsite-header-elements">
	<div class="wsite-section-wrap">
	<div  class="wsite-section wsite-header-section wsite-section-bg-image" style="background-image: url(&quot;/uploads/1/2/2/7/122787378/background-images/1457216801.jpg&quot;) ;background-repeat: no-repeat ;background-position: 50.00% 37.20% ;background-size: 100% ;background-color: transparent ;background-size: cover;" >
		<div class="wsite-section-content">
			
					<div class="container">
						<div class="banner">
				<div class="wsite-section-elements">
					<h2 class="wsite-content-title">What's The Latest?</h2>
				</div>
			</div>
					</div>
				
		</div>
		<div class=""></div>
	</div>
</div>

</div>

			</div>
		</div><!--/.header-wrap-->

		<div id="main-wrap">
			<div id="wsite-content" class="wsite-elements wsite-not-footer">
	<div class="wsite-section-wrap">
	<div class="wsite-section wsite-body-section wsite-background-16 wsite-custom-background"  >
		<div class="wsite-section-content">
				<div class="container">
			<div class="wsite-section-elements">
				
			</div>
		</div>
			</div>

	</div>
</div>

</div>

		</div>

		<div class="sticky-footer-push"></div>

	</div><!--/.wrapper-->
	<div id="footer-wrap"><div class="container"><div class='wsite-elements wsite-footer'>
<div><div class="wsite-multicol"><div class="wsite-multicol-table-wrap" style="margin:0 -15px;">
	<?php  include(dirname(__FILE__) . "/welcome_footer_table.php"); ?>
</div></div></div>

<div class="wsite-spacer" style="height:17px;"></div>

<div class="paragraph" style="text-align:center;"><strong><font size="3">CHILL TECH PRODUCTS, INC.</font></strong></div>

<div class="paragraph" style="text-align:center;">Copyright &copy; 2018</div></div></div></div>

	<div class="navmobile-wrapper">
		<div id="navmobile" class="nav">
		 <?php  include(dirname(__FILE__) . "/welcome_footer_menu.php"); ?>
</div>
	</div>

  <script type="text/javascript" src="/files/theme/mobile.js?1529356182"></script>
  <script type="text/javascript" src="/files/theme/plugins.js?1529356182"></script>
  <script type="text/javascript" src="/files/theme/custom.js?1529356182"></script>

    <div id="customer-accounts-app"></div>
    <script src="//cdn2.editmysite.com/js/site/main-customer-accounts-site.js?buildTime=1541447432"></script>
<div id="dialog-region"></div>
		<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-7870337-1']);
	_gaq.push(['_setDomainName', 'none']);
	_gaq.push(['_setAllowLinker', true]);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

	_W.Analytics = _W.Analytics || {'trackers': {}};
	_W.Analytics.trackers.wGA = '_gaq';
</script>

<script type="text/javascript" async=1>
	;(function(p,l,o,w,i,n,g){if(!p[i]){p.GlobalSnowplowNamespace=p.GlobalSnowplowNamespace||[];
			p.GlobalSnowplowNamespace.push(i);p[i]=function(){(p[i].q=p[i].q||[]).push(arguments)
			};p[i].q=p[i].q||[];n=l.createElement(o);g=l.getElementsByTagName(o)[0];n.async=1;
			n.src=w;g.parentNode.insertBefore(n,g)}}(window,document,'script','//cdn2.editmysite.com/js/wsnbn/snowday262.js','snowday'));

	var r = [99, 104, 101, 99, 107, 111, 117, 116, 46, 40, 119, 101, 101, 98, 108, 121, 124, 101, 100, 105, 116, 109, 121, 115, 105, 116, 101, 41, 46, 99, 111, 109];
	var snPlObR = function(arr) {
		var s = '';
		for (var i = 0 ; i < arr.length ; i++){
			s = s + String.fromCharCode(arr[i]);
		}
		return s;
	};
	var s = snPlObR(r);

	var regEx = new RegExp(s);

	_W.Analytics = _W.Analytics || {'trackers': {}};
	_W.Analytics.trackers.wSP = 'snowday';
	_W.Analytics.user_id = '122787378';
	_W.Analytics.site_id = '254044572107838451';

	// Setting do not track if the GDPR cookie is not present. This is then checked by the snowday initializer
	// to set tracking decisions. https://github.com/snowplow/snowplow-javascript-tracker/blob/2.6.2/src/js/tracker.js#L1509
	window.doNotTrack = document.cookie.indexOf('gdpr-kb') === -1 ? 'yes' : null;


	(function(app_id, ec_hostname, discover_root_domain) {
		var track = window[_W.Analytics.trackers.wSP];
		if (!track) return;
		track('newTracker', app_id, ec_hostname, {
			appId: app_id,
			post: true,
			platform: 'web',
			discoverRootDomain: discover_root_domain,
			cookieName: '_snow_',
			contexts: {
				webPage: true,
				performanceTiming: true,
				gaCookies: true
			},
			crossDomainLinker: function (linkElement) {
				return regEx.test(linkElement.href);
			},
			respectDoNotTrack: document.cookie.indexOf('gdpr-kb') === -1
		});
		track('trackPageView', _W.Analytics.user_id+':'+_W.Analytics.site_id);
		track('crossDomainLinker', function (linkElement) {
			return regEx.test(linkElement.href);
		});
	})(
		'_wn',
		'ec.editmysite.com',
		true
	);
</script>



<script>
	(function(jQuery) {
		try {
			if (jQuery) {
				jQuery('div.blog-social div.fb-like').attr('class', 'blog-social-item blog-fb-like');
				var $commentFrame = jQuery('#commentArea iframe');
				if ($commentFrame.length > 0) {
					var frameHeight = jQuery($commentFrame[0].contentWindow.document).height() + 50;
					$commentFrame.css('min-height', frameHeight + 'px');
				}
				if (jQuery('.product-button').length > 0){
					jQuery(document).ready(function(){
						jQuery('.product-button').parent().each(function(index, product){
							if(jQuery(product).attr('target') == 'paypal'){
								if (!jQuery(product).find('> [name="bn"]').length){
									jQuery('<input>').attr({
										type: 'hidden',
										name: 'bn',
										value: 'DragAndDropBuil_SP_EC'
									}).appendTo(product);
								}
							}
						});
					});
				}
			}
			else {
				// Prototype
				$$('div.blog-social div.fb-like').each(function(div) {
					div.className = 'blog-social-item blog-fb-like';
				});
				$$('#commentArea iframe').each(function(iframe) {
					iframe.style.minHeight = '410px';
				});
			}
		}
		catch(ex) {}
	})(window._W && _W.jQuery);

	window._W.isEUUser = false;
	window._W.showCookieToAll = "";
</script>


	</body>
</html>
