<style>
.wsite-section-wrap, .alert-success {
    width: 70% !important;
    display: table;
    margin: 10px auto;
    background-color: rgba(99, 176, 235, 0.15) !important;
    border-width: 1px 1px 1px 1px;
    border-color: #c2c2c2;
    border-style: solid;
}
.wsite-form-field div.wsite-form-input-container .wsite-input-width-370px {
 max-width: unset !important;
    border-color: #c2c2c2 !important;
    background-color: #ffffee !important;
    display: block;
    border-radius:5px;
    min-width: 100%;
}
.alert-success {
    text-align: center;
    font-size: 25px;
    padding-top: 20px;
    padding-bottom: 20px;
    font-weight: bold;
}
.wsite-content-title, .alert-success {

    word-wrap: break-word;
    font-family: 'Patua One';
    color: #fff !important;
    font-size: 25px;

}
.wsite-content-title font, .alert-success {
color: #cccfff!important;

text-transform: uppercase;


text-shadow: 2px 2px 2px #666;
}
.wsite-button, .wsite-editor .wsite-button {

    display: block;
    height: auto;
    padding: 0;
    clear: both;
    color: #fff !important;
    background: unset !important;
    background-image: unset;
    background-repeat: unset;
    text-align: center;
    width: 81%;
    margin: 20px auto 20px -5px;

}
</style>
<body class="no-header-page  wsite-page-contact wsite-theme-light"><div class="wrapper">
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

    <div id="main-wrap">
      <div id="wsite-content" class="wsite-elements wsite-not-footer">
       <span class="alert-success" <?php if(!empty($data['msg'])){ ?> style="display:block"><?php echo $data['msg']; ?></div><?php }else{ ?> style="display:none"></div><?php } ?></span>
	<div class="wsite-section-wrap">
	<div class="wsite-section wsite-body-section wsite-section-bg-color wsite-background-15 wsite-custom-background" style="background-image: none;" >
	
		<div class="wsite-section-content">
        <div class="container">
			<div class="wsite-section-elements">
				<div>
	<form enctype="multipart/form-data" action="/welcome/contact" method="POST" id="form-208651797663154240">
		<div id="208651797663154240-form-parent" class="wsite-form-container"
				 style="margin-top:10px;">
				
			<ul class="formlist" id="208651797663154240-form-list">
				<h2 class="wsite-content-title"><font color="#2a2a2a">HAVE some interest?</font></h2>

<label class="wsite-form-label wsite-form-fields-required-label"><span class="form-required">*</span> Indicates required field</label><div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
				<label class="wsite-form-label" for="input-689818486450563240">Name <span class="form-required">*</span></label>
				<div class="wsite-form-input-container">
					<input aria-required="true" id="input-689818486450563240" class="wsite-form-input wsite-input wsite-input-width-370px" type="text" name="_u689818486450563240" />
					<?php echo form_error('_u689818486450563240') ?>
				</div>
				<div id="instructions-689818486450563240" class="wsite-form-instructions" style="display:none;"></div>
			</div></div>

<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
				<label class="wsite-form-label" for="input-299538569683647988">Phone <span class="form-required">*</span></label>
				<div class="wsite-form-input-container">
					<input aria-required="true" id="input-299538569683647988" class="wsite-form-input wsite-input wsite-input-width-370px" type="text" name="_u299538569683647988" />
					<?php echo form_error('_u299538569683647988') ?>
				</div>
				<div id="instructions-299538569683647988" class="wsite-form-instructions" style="display:none;"></div>
			</div></div>

<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
				<label class="wsite-form-label" for="input-974858400987469693">Email <span class="form-required">*</span></label>
				<div class="wsite-form-input-container">
					<input aria-required="true" id="input-974858400987469693" class="wsite-form-input wsite-input wsite-input-width-370px" type="text" name="_u974858400987469693" />
					<?php echo form_error('_u974858400987469693') ?>
				</div>
				<div id="instructions-974858400987469693" class="wsite-form-instructions" style="display:none;"></div>
			</div></div>

<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
				<label class="wsite-form-label" for="input-642942518700304519">Comment <span class="form-required">*</span></label>
				<div class="wsite-form-input-container">
					<textarea aria-required="true" id="input-642942518700304519" class="wsite-form-input wsite-input wsite-input-width-370px" name="_u642942518700304519" style="height: 200px"></textarea>
				</div>
				<div id="instructions-642942518700304519" class="wsite-form-instructions" style="display:none;"></div>
				<?php echo form_error('_u642942518700304519') ?>
			</div></div>
			</ul>
			
		</div>
		<div style="display:none; visibility:hidden;">
			<input type="text" name="wsite_subject" />
		</div>
		<div style="text-align:left; margin-top:10px; margin-bottom:10px;">
			<input type="hidden" name="form_version" value="2" />
			<input type="hidden" name="wsite_approved" id="wsite-approved" value="approved" />
			<input type="hidden" name="ucfid" value="208651797663154240" />
			<input type="hidden" name="recaptcha_token"/>
			<input type="submit" style="position:absolute;top:0;left:-9999px;width:1px;height:1px" />
			<a class="wsite-button">
				<span class="wsite-button-inner">Submit</span>
			</a>
		</div>
	</form>
	<div id="g-recaptcha-208651797663154240" class="recaptcha" data-size="invisible" data-recaptcha="0" data-sitekey="6LeVonoUAAAAAFB13KjOGRJHOOaQdWoi75CpS99m"></div>



</div>

<div><div class="wsite-image wsite-image-border-none " style="padding-top:10px;padding-bottom:10px;margin-left:0;margin-right:0;text-align:center">
<a>
<img src="/uploads/1/2/2/7/122787378/line_3_orig.png" alt="Picture" style="width:auto;max-width:100%" />
</a>
<div style="display:block;font-size:90%"></div>
</div></div>

<div><div class="wsite-multicol"><div class="wsite-multicol-table-wrap" style="margin:0 -15px;">
	<table class="wsite-multicol-table">
		<tbody class="wsite-multicol-tbody">
			<tr class="wsite-multicol-tr">
				<td class="wsite-multicol-col" style="width:50%; padding:0 15px;">
					
						

<h2 class="wsite-content-title"><font size="6" style="" color="#2a2a2a">Location &amp; Hours</font></h2>

<div class="wsite-spacer" style="height:33px;"></div>

<div class="paragraph"><font color="#2a2a2a">&#8203;<strong style="">Chill Tech Products, Inc.</strong><br /><font style="">&#8203;88 Priscilla Lane<br />Unit 4<br />&#8203;Auburn, NH 03032<br /><br />&#8203;<strong style="">MONDAY - FRIDAY</strong><br /><font style="">8am - 5pm<br /><br /><strong style="">&#8203;SATURDAY,&nbsp;</strong><strong style="">SUNDAY</strong><br /><font style="">Closed</font></font></font></font></div>


					
				</td>				<td class="wsite-multicol-col" style="width:50%; padding:0 15px;">
					
						

<div class="wsite-map"><iframe allowtransparency="true" frameborder="0" scrolling="no" style="width: 100%; height: 475px; margin-top: 10px; margin-bottom: 10px;" src="//www.weebly.com/weebly/apps/generateMap.php?map=google&elementid=841427595599753779&ineditor=0&control=3&width=auto&height=475px&overviewmap=0&scalecontrol=0&typecontrol=0&zoom=9&long=-71.35513730000002&lat=42.9568772&domain=www&point=1&align=1&reseller=false"></iframe></div>


					
				</td>			</tr>
		</tbody>
	</table>
</div></div></div>
			</div>
		</div>
      </div>

	</div>
</div>

</div>

    </div>


    <div class="sticky-footer-push"></div>

  </div><!--/.wrapper-->

  <div id="footer-wrap">
    <div class="container"><div class='wsite-elements wsite-footer'>
<div><div class="wsite-multicol"><div class="wsite-multicol-table-wrap" style="margin:0 -15px;">
	<?php  include(dirname(__FILE__) . "/welcome_footer_table.php"); ?>
</div></div></div>

<div class="wsite-spacer" style="height:17px;"></div>

<div class="paragraph" style="text-align:center;"><strong><font size="3">CHILL TECH PRODUCTS, INC.</font></strong></div>

<div class="paragraph" style="text-align:center;">Copyright &copy; 2018</div></div></div>
  </div>

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
 
