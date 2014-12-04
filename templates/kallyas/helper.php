<?php  
/*------------------------------------------------------------------------
# author    Marius Hogas
# copyright Copyright © 2013 hogash.com. All rights reserved.
# @license  Commercial License http://themeforest.net/licenses/regular_extended
# Website   http://www.hogash.com
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;
jimport( 'joomla.plugin.plugin' );

class TplHelper {
	
	// TO DO --------
	/*
		- 
	*/

	//tplStyles - function to parse the color styles added in template manager	
	public function tplStyles(&$params) {
		$doc = JFactory::getDocument();
		
		$styles = 'body, .inner-page {background-color: '.self::parseColor($params->get("body_bg", '#f5f5f5')).';}';
		$styles .= 'body {color: '.self::parseColor($params->get("body_tcolor", '#535353')).';}';
		$styles .= '#footer {background-color: '.self::parseColor($params->get("footer_bg", '#2F2F2F')).';}';
		$styles .= '#footer {color: '.self::parseColor($params->get("footer_tcolor", '#D5D5D5')).';}';
		
		/*** CONTENT COLOR ELEMENTS */
		$content_color = self::parseColor($params->get("contentcolor", '#cd2122'));
		$styles .= 'a:hover, .info_pop .buyit, .m_title, .smallm_title, .circle_title, .feature_box .title , .services_box .title, .latest_posts.default-style .hoverBorder:hover h6, .latest_posts.style2 ul.posts .title, .latest_posts.style3 ul.posts .title, .recentwork_carousel li .details h4, .acc-group.default-style > button, .acc-group.style3 > button:after, .acc-group.style3 > button:hover, .acc-group.style3 > button:hover:after, .screenshot-box .left-side h3.title, .vertical_tabs.tabbable .nav>li>a:hover, .vertical_tabs.tabbable .nav>li.active>a, .vertical_tabs.tabbable .nav>li.active>a>span, .vertical_tabs.tabbable .nav>li>a:hover>span, .statbox h4, .services_box.style2 .box .list li, body.component.transparent a, .shop.tabbable .nav li.active a, .product-list-item:hover .prod-details h3, .product-page .mainprice .PricesalesPrice > span, .cart_details .checkout, .vmCartModule .carttotal .total, .oldie .latest_posts.default-style .hoverBorder:hover h6  { color: '.$content_color.'; }
header.style1, header.style2 #logo a, header.style2 a#logo, header.style3 #logo a, header.style3 a#logo, .tabs_style1 > ul.nav > li.active > a {border-top: 3px solid '.$content_color.';}
nav#main_menu > ul > li.active > a, nav#main_menu > ul > li > a:hover, nav#main_menu > ul > li:hover > a, .social-icons li a:hover, .how_to_shop .number, .action_box, .imgboxes_style1 .hoverBorder h6, .imgboxes_style1 .hoverborder h6, .feature_box.style3 .box:hover, .services_box .box:hover .icon, .latest_posts.default-style .hoverBorder h6, .recentwork_carousel li .details > .bg, .recentwork_carousel.style2 li a .details .plus, .gobox.ok, .hover-box:hover, .circlehover, .circlehover:before, .newsletter-signup input[type=submit], #mainbody .sidebar ul.menu li.active a, #mainbody .sidebar ul.menu li a:hover, #map_controls, .hg-portfolio-sortable #portfolio-nav li a:hover, .hg-portfolio-sortable #portfolio-nav li.current a, .ptcarousel .controls > a:hover, .itemLinks span a:hover, .product-list-item .prod-details .actions a, .product-list-item .prod-details .actions input.addtocart-button, .product-list-item .prod-details .actions input.addtocart-button-disabled, .shop-features .shop-feature:hover, .btn-flat, .redbtn, .ca-more, ul.links li a, .title_circle , .title_circle:before, .br-next:hover, .br-previous:hover, .flex-direction-nav li a:hover, .iosSlider .item .caption.style1 .more:before, .iosSlider .item .caption.style1 .more:after, .iosSlider .item .caption.style2 .more, .nivo-directionNav a:hover, .portfolio_devices .more_details , #wowslider-container a.ws_next:hover, #wowslider-container a.ws_prev:hover  {background-color:'.$content_color.';}
.iosSlider .item .caption.style2 .title_small, .nivo-caption, #wowslider-container .ws-title, .flex-caption {border-left: 5px solid '.$content_color.';}
.iosSlider .item .caption.style2.fromright .title_big, .iosSlider .item .caption.style2.fromright .title_small {border-right: 5px solid '.$content_color.';}
.action_box:before { border-top-color:'.$content_color.';}
.breadcrumbs li:after { border-left-color:'.$content_color.'; }
.theHoverBorder:hover {-webkit-box-shadow:0 0 0 5px '.$content_color.' inset; -moz-box-shadow:0 0 0 5px '.$content_color.' inset; box-shadow:0 0 0 5px '.$content_color.' inset;}
.offline-page .containerbox {border-bottom:5px solid '.$content_color.'; }
.offline-page .containerbox:after {border-top: 20px solid '.$content_color.';}';
		/**** END CONTENT COLOR ELEMENTS */
		
		$doc->addStyleDeclaration($styles);
	}
	
	public function loadCSS($stylesheets, &$params) {
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$tpath = JURI::base(true)."/templates/" . $app->getTemplate() ;
		
		$stylesheets = array_filter($stylesheets, 'strlen');
		if($params->get('compresscss', 0)) {
			foreach($stylesheets as $stylesheet) {
				$cstylesheets[] = '../'.str_replace('.css','',$stylesheet);
			}
			$doc->addStyleSheet($tpath.'/css/template.css.php?src='.urlencode(implode('-', $cstylesheets)));
			
		} else {
			foreach($stylesheets as $stylesheet) {
				$doc->addStyleSheet($tpath.'/'.$stylesheet);
			}
		}
	}
	
	public function loadJS($scripts, &$params) {
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument(); 
		$tpath = JURI::base(true)."/templates/" . $app->getTemplate() ;
		
		if (JVERSION>='3') :
			JHtml::_('bootstrap.framework');
		else :
			$doc->addScript($tpath.'/js/bootstrap.min.js');
		endif;
		
		$scripts = array_filter($scripts, 'strlen');
		foreach($scripts as $script) {
			$doc->addScript($tpath.'/'.$script);
		}
		// mootools options
		$option = JRequest::getCmd('option', '');
		
		if(!$params->get('load_mootools', 0) && $option != 'com_virtuemart' && $option != 'com_users'){
			// remove mootools if disabled // IT WILL SPEED UP THE WEBSITE IF DISABLED (it's 3-400kb of unused scripts)
			unset($doc->_scripts[$this->baseurl.'/media/system/js/mootools-core.js']);
			unset($doc->_scripts[$this->baseurl.'/media/system/js/core.js']);
			unset($doc->_scripts[$this->baseurl.'/media/system/js/mootools-more.js']);
			unset($doc->_scripts[$this->baseurl.'/media/system/js/caption.js']);
		
			if (isset($this->_script['text/javascript'])) {
				$this->_script['text/javascript'] = preg_replace('%window\.addEvent\(\'load\',\s*function\(\)\s*{\s*new\s*JCaption\(\'img.caption\'\);\s*}\);\s*%', '', $this->_script['text/javascript']);
				if (empty($this->_script['text/javascript']))
					unset($this->_script['text/javascript']);
			}
		}
		
		
	}
	
	public function googleFonts(&$params){
		$doc = JFactory::getDocument();
		// Added to setect whether to use HTTP or HTTPS:
		$mode = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
		$gg_body_selectors = $params->get("font_body_selectors");	
		$gg_elems_selectors = $params->get("font_elems_selectors");	
		
		// body font
		if($params->get("font_body_google_enable", 1) == 1) {
			$gg_body_font = $params->get("font_body_google");
			if($gg_body_font && $gg_body_font != '-1') {
				$doc->addStyleSheet($mode.'://fonts.googleapis.com/css?family='.str_replace(" ","+",$gg_body_font).":".$params->get("font_body_google_style")."&amp;v1&mp;subset=latin,latin-ext", 'text/css', 'screen', array('id'=>"google_font"));
				$doc->addStyleDeclaration($gg_body_selectors." { font-family: '".str_replace("+"," ",$gg_body_font)."', 'Helvetica', Arial, serif; }");
			}
		} else {
			$doc->addStyleDeclaration($gg_body_selectors." { font-family: '".$params->get("font_body_websafe")."'; }");
		}
		
		// elems font
		if($params->get("font_elems_google_enable", 1) == 1) {
			$gg_elems_font = $params->get("font_elems_google");
			if($gg_elems_font && $gg_elems_font != '-1') {
				$doc->addStyleSheet($mode.'://fonts.googleapis.com/css?family='.str_replace(" ","+",$gg_elems_font).":".$params->get("font_elems_google_style")."&amp;v1&mp;subset=latin,latin-ext", 'text/css', 'screen', array('id'=>"google_font_elems"));
				$doc->addStyleDeclaration($gg_elems_selectors." { font-family: '".str_replace("+"," ",$gg_elems_font)."', 'Helvetica', Arial, serif; }");
			}
		} else {
			$doc->addStyleDeclaration($gg_elems_selectors." { font-family: '".$params->get("font_elems_websafe")."'; }");
		}
		
	}
	
	public function displayLogo($home, &$params){
		$doc = JFactory::getDocument();
		$inline_css = '';
		// get proper path based on perstyle hidden param
		// append logo file
		$path = trim($params->get('logo'));
			
		if($params->get("logo_width")){ $logo_width = 'width:'.$params->get("logo_width").'px'; }
		else {	$logo_width = ''; }
		if($params->get("logo_height")){ $logo_height = 'height:'.$params->get("logo_height").'px'; }
		else { $logo_height = '';}
		
		if ($params->get("logo_autosize")) {
			jimport ('joomla.filesystem.file');
			$logocss = 'body h1#logo a, body a#logo';
			// if the logo exists, get it's dimentions and add them inline
			if (JFile::exists($path)) {
				$logosize = getimagesize($path);
				if (isset($logosize[0]) && isset($logosize[1])) {
					$inline_css .= $logocss.' {width:'.$logosize[0].'px;height:'.$logosize[1].'px; '.$params->get("logo_styles").'; }';
				}
			} 
		}
		elseif(!$params->get("logo_autosize") && $params->get("logo_width") && $params->get("logo_height")){
			$inline_css .= $logocss.' {'.$logo_width.'; '.$logo_height.'; '.$params->get("logo_styles").'; }';
		}
		$doc->addStyleDeclaration($inline_css);
		
		$html = '';
		$detect_home = self::detect_home();
		$logotype = $params->get('logo_type','image');
		
		if($detect_home == 1) {
			$html .= '<h1 id="logo">';
		}
		$html .= '<a href="'.$home.'" '.(($detect_home != 1) ? ' id="logo"' : '').' '.($logotype == 'text' ? 'title="'.$params->get('logo_title').'"' : '' ).'>';
		if($params->get('logo_type','image') == 'image') {
			$html .= '<img src="'.$path.'" alt="'.$params->get('logo_alt').'" title="'.$params->get('logo_title').'">';
		} else {
			$html .= $params->get('logo_alt');
		}
		$html .= '</a>';
		if($detect_home == 1) {
			$html .= '</h1>';
		}
		echo $html;
		
	}
	
	public function displaySearch($notopnav, &$params){
		$doc = JFactory::getDocument();
		$lang = JFactory::getLanguage();
		$html = '';
		$text = htmlspecialchars($params->get('search_text', JText::_('TPL_KALLYAS_SEARCHBOX_TEXT')));
		$set_Itemid		= intval($params->get('set_itemid', 0));
		$mitemid = $set_Itemid > 0 ? $set_Itemid : JRequest::getInt('Itemid');

		if($params->get('search', 1)){
			$html .= '<div id="search" class="'.$notopnav.'">';
			$html .= '<a href="#" class="searchBtn"><span class="icon-search icon-white"></span></a>';
			$html .= '<div class="search">';
			$html .= '<form action="'.JRoute::_('index.php').'" method="post">';
			$html .= '<input name="searchword" maxlength="20" class="inputbox" type="text" size="20" value="'.$text.'" onBlur="if (this.value==\'\') this.value=\''.$text.'\';" onFocus="if (this.value==\''.$text.'\') this.value=\'\';" />';
			$html .= '<input type="submit" value="go" class="button icon-search" onclick="this.form.searchword.focus();" />';
			$html .= '<input type="hidden" name="task" value="search" />
				<input type="hidden" name="option" value="com_search" />
				<input type="hidden" name="Itemid" value="'.$mitemid.'" />';
			$html .= '</form>';
			$html .= '</div>';
			$html .= '</div>';
		}
		return $html;
	}
	
	public function displayFavicons(&$params){
		$app = JFactory::getApplication();
		$tpath = JURI::base(true)."/templates/" . $app->getTemplate() ."/images/favicons/";

		$favicon = '	<link rel="shortcut icon" href="'.($params->get("favicon") ? $params->get("favicon") : $tpath.'favicon.png').'">'."\n";
		$favicon .= ($params->get("favicon_appl_touch")) ? '	<link rel="apple-touch-icon" href="'.$params->get("favicon_appl_touch").'">'."\n" : '';
		$favicon .= ($params->get("favicon_appl_touch72")) ? '	<link rel="apple-touch-icon" sizes="72x72" href="'.$params->get("favicon_appl_touch72").'">'."\n" : '';
		$favicon .= ($params->get("favicon_appl_touch114")) ? '	<link rel="apple-touch-icon" sizes="114x114" href="'.$params->get("favicon_appl_touch114").'">'."\n" : '';
		return $favicon;
	}
	
	public static function getBrowserAgent() {
		jimport('joomla.environment.browser');
		$browser = JBrowser::getInstance();
		$agent_string = $browser->getAgentString();
		if(stripos($agent_string,'firefox') !== false) :
			$agent = 'browser_firefox';
		elseif(stripos($agent_string, 'chrome') !== false) :
			$agent = 'browser_chrome';
		elseif(stripos($agent_string, 'msie 10') !== false) :
			$agent = 'browser_ie ie10';
		elseif(stripos($agent_string, 'msie 9') !== false) :
			$agent = 'browser_ie ie9';
		elseif(stripos($agent_string, 'msie 8') !== false) :
			$agent = 'browser_ie ie_oldie ie8';
		elseif(stripos($agent_string, 'msie 7') !== false) :
			$agent = 'browser_ie ie_oldie ie7';
		elseif(stripos($agent_string,'iphone') !== false || stripos($agent_string,'ipod') !== false) :
			$agent = 'browser_iphone';
		elseif(stripos($agent_string,'ipad') !== false) :
			$agent = 'browser_ipad';
		elseif(stripos($agent_string,'blackberry') !== false) :
			$agent = 'browser_blackberry';
		elseif(stripos($agent_string,'palmos') !== false) :
			$agent = 'browser_palm';
		elseif(stripos($agent_string,'android') !== false) :
			$agent = 'browser_android';
		elseif(stripos($agent_string,'safari') !== false) :
			$agent = 'browser_safari';
		elseif(stripos($agent_string, 'opera') !== false) :
			$agent = 'browser_opera';
		else :
			$agent = null;
		endif;
		return $agent;
	}
	
	public static function detect_home() {
		// Detects the home page by comparing current URL with homepage URL
		$app		= JFactory::getApplication();
		$menu		= $app->getMenu();
		if ($menu->getActive() == $menu->getDefault()) {
			$site_home = 1;
		} else {
			$site_home = 0;
		}
		return $site_home;
	}
		
	function getHomeId(){
		// used to hide the Home Button
		$menu = JSite::getMenu();
		$default = $menu->getDefault();
		$default_id = $default->id;
		return $default_id;
	}
	
	function googleAnalytics(&$params) {
		$analyticsID = $params->get('analytics');
		$analytics = "";
		if($analyticsID) {
			$analytics = "
<script type='text/javascript'>
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '".$analyticsID."']);
	_gaq.push(['_trackPageview']);
	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>\n";
		}
		return $analytics;
	}
	
	function facebookSDK($type, &$params) {
		$appid = $params->get("fbAppID");
		
		if($type == 'sdk') {
			$fbsscript = "\n";
			if($params->get('fb_sdk',1)):
			$fbsscript .= '<div id="fb-root"></div>'."\n";
			$fbsscript .= '<script>window.fbAsyncInit = function() {';
			$fbsscript .= 'FB.init({'.($appid != null ? 'appId:'.$appid.',' : '').' status: true, cookie: true, xfbml: true});';
			$fbsscript .= '};'; 
			$fbsscript .= '(function(d, s, id,debug) {'."\n";
			$fbsscript .= '	var js, fjs = d.getElementsByTagName(s)[0];'."\n";
			$fbsscript .= '	if (d.getElementById(id)) return;'."\n";
			$fbsscript .= '	js = d.createElement(s); js.id = id;'."\n";
			$fbsscript .= '	js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";'."\n";
			$fbsscript .= '	fjs.parentNode.insertBefore(js, fjs);'."\n";
			$fbsscript .= '	}(document, "script", "facebook-jssdk", /*debug*/ false));</script>'."\n";
			endif;
			$code = $fbsscript;
			
		} else if($type == 'ograph') {
			$metaog = "\n";
			$metaog .= '<!-- Facebook OpenGraph Tags -->'."\n";
			if(!self::w3c()):
			$metaog .= ($params->get("og_title") != null ? '<meta name="og:title" content="'.$params->get("og_title").'"/>'."\n" : '');
			$metaog .= ($params->get("og_type") != null ? '<meta name="og:type" content="'.$params->get("og_type").'"/>'."\n" : '');
			$metaog .= ($params->get("og_url") != null ? '<meta name="og:url" content="'.$params->get("og_url").'"/>'."\n" : '');
			$metaog .= ($params->get("og_image") != null ? '<meta name="og:image" content="'.JURI::base().$params->get("og_image").'"/>'."\n" : '');
			$metaog .= ($params->get("og_sitename") != null ? '<meta name="og:site_name" content="'.$params->get("og_sitename").'"/>'."\n" : '');
			$metaog .= ($appid != null ? '<meta name="fb:app_id" content="'.$appid.'"/>'."\n" : '');
			$metaog .= ($params->get("og_description") != null ? '<meta name="og:description" content="'.$params->get("og_description").'"/>'."\n" : '');
			$metaog .= '<!-- END Facebook OpenGraph Tags -->'."\n";
			endif;
			$code = $metaog;
		}
		return $code;
	}
	
	function renderMenu(&$params) {
		include_once (JPATH_SITE.'/modules/mod_menu/helper.php'); 
		$app		= JFactory::getApplication();
		$menu		= $app->getMenu();
		$list		= modMenuHelper::getList($params);
		$active 	= $menu->getActive();
		//$active		= modMenuHelper::getActive($params);
		//$active_id 	= $active->id;
		//$path		= $active->tree;
		$active_id 	= isset($active) ? $active->id : $menu->getDefault()->id;
		$path		= isset($active) ? $active->tree : array();
		
		$animation	= $params->get('animation');
		$delay		= $params->get('delay');
		$speed		= $params->get('speed');
		$mobilemenu	= (bool)$params->get('mobilemenu', 1);
		$isresponsive = (bool)$params->get('responsive',1);
		$autoarrows	= 'true';
		
		if(count($list)) {
			require dirname(__FILE__).'/lib/menu.php';
		}
	}
	
	function html2rgba($color, $opacity){
		
		if ($color[0] == '#')
			$color = substr($color, 1);
	
		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0].$color[1],
									 $color[2].$color[3],
									 $color[4].$color[5]);
		elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
			return false;

		if($opacity == 0) {
			$theRGBa = "transparent";
		} elseif ($opacity == 1) {
			$theRGBa = "#$r$g$b";
		} else {
			$r = hexdec($r);
			$g = hexdec($g);
			$b = hexdec($b);
			$theRGBa = "rgba($r, $g, $b, ".$opacity.")";
		}
		return $theRGBa;
	}
	
	function parseColor($color){
		if(is_object($color)) {
			$opacity = $color->opacity;
			$thecolor = $color->color;
			$col = self::html2rgba($thecolor, $opacity);
		}
		else {
			$col = self::html2rgba($color, 1);
		}
		return $col;
	}
	
	function socialIcons(&$params) {
		
		$title = $params->get('sico_title');
		$icons = array($params->get('sico1'), $params->get('sico2'), $params->get('sico3'), $params->get('sico4'), $params->get('sico5'), $params->get('sico6'), $params->get('sico7'), $params->get('sico8'), $params->get('sico9'), $params->get('sico10') );
		
		$iconlist = array();
		$iconlist[] = '<ul class="social-icons fixclear '.$params->get('sico_style').'">';
		if($title) $iconlist[] = '<li class="title">'.$title.'</li>';
		if($icons) { 
			foreach($icons as $icon) {
				$theicon = $icon->theicon;
				$url = $icon->url;
				$ititle = $icon->title;
				$name = '';
				if($theicon) {
					$iconlist[] = '<li class="social-'.$theicon.'"><a href="'.$url.'" target="_blank" title="'.$params->get('follow_us').' '.$ititle.'">'.$ititle.'</a></li>';
				} 
			}
		} 
		$iconlist[] = '</ul>';
		
		return implode("\n", $iconlist);
	}
	function slideshow_style($itemid){
		$style = '';
		$app = JFactory::getApplication();
		$menu = $app->getMenu();					// Get Menu
		$menu_params = $menu->getParams($itemid);	// Get current menu item parameters
		$bgcolor = $menu_params->get('sldcolor_default', 'dark-blue');
		$isgradient = $menu_params->get('isgradient', 1);
		$hasmargin = $menu_params->get('hasmargin', 0);
		$noglare = $menu_params->get('noglare', 0);
		$customstyle = $menu_params->get('customstyle');
		
		$style .= ' class="'.($isgradient ? 'gradient':'').' '.$bgcolor.($hasmargin ? ' hasMargin':'').($noglare ? ' noGlare':'').'"';
		if($customstyle) $style .= ' style="'.$customstyle.'"';
		
		return $style;
	}
	
	function slideshow_bottommask($itemid){
		$html = '';
		$app = JFactory::getApplication();
		$menu = $app->getMenu();					// Get Menu
		$menu_params = $menu->getParams($itemid);	// Get current menu item parameters
		$bottomMask = $menu_params->get('bottommask', 'nomask');
		if($bottomMask == 'mask1') 			$html .= '<div id="bottom_mask" class="mask1"></div>';
		else if($bottomMask == 'mask2') 	$html .= '<div id="bottom_mask" class="mask2"></div>';
		else if($bottomMask == 'shadow')	$html .= '<div class="shadowUP"></div>';
		return $html;
	}
	
	function w3c(){
		if((stristr($_SERVER["HTTP_USER_AGENT"],'w3c') === TRUE))
		return true;
	}
}
