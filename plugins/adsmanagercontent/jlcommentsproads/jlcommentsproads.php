<?php
/**
 * Plugins JLcomments Pro
 * @version 2.7
 * @author Zhukov Artem (artem@joomline.ru)
 * @copyright (C) 2012-2013 by Zhukov Artem and Kunitsyn Vadim (http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die;
error_reporting(E_ERROR);
jimport('joomla.plugin.plugin');
jimport ('joomla.html.parameter');

class plgAdsmanagercontentJlcommentsProAds extends JPlugin {

	function countcom($cntcom,$cntname){
		$commentsAPI = JPATH_SITE . '/components/com_jcomments/jcomments.php';
	 	if (is_file($commentsAPI)) {
	 		require_once($commentsAPI);
			$count = JComments::getCommentsCount($cntcom, $cntname);				
		}
		return $count;
	}

	function addtabtitle($showjcomments,$showvkontakte,$showfacebook,$orders,$cntcom,$cntname,$enabledshow,$lablename) {
		$titlefc = $lablename->get('labelfc');
		$titlevk = $lablename->get('labelvk');
		$titlejc = $lablename->get('labeljc');
		$scriptPage = '';
		$countercom = $enabledshow==1 ? '&nbsp;('.$this->countcom($cntcom,$cntname).')' : '';
		foreach ($orders as $order) {
			switch($order) {
				case 1:	if ($showjcomments) { $scriptPage .= <<<HTML
					<li class="tab">$titlejc $countercom</li>
HTML;
						} else {$scriptPage .='';} break;
				case 2:	if ($showvkontakte) { $scriptPage .= <<<HTML
					<li class="tab">$titlevk</li>
HTML;
						} else {$scriptPage .='';} break;
				case 3:	if ($showfacebook) { $scriptPage .= <<<HTML
					<li class="tab">$titlefc</li>
HTML;
						} else {$scriptPage .='';} break;
			}
		}
		return $scriptPage;
		
	}
	
	
		function addtabtitlejq($showjcomments,$showvkontakte,$showfacebook,$orders,$cntcom,$cntname,$enabledshow,$lablename) {
		$j=1;
		$titlefc = $lablename->get('labelfc');
		$titlevk = $lablename->get('labelvk');
		$titlejc = $lablename->get('labeljc');
		$scriptPage = '';
		$countercom = $enabledshow==1 ? '&nbsp;('.$this->countcom($cntcom,$cntname).')' : '';
		foreach ($orders as $order) {
			switch($order) {
				case 1:	if ($showjcomments) { $scriptPage .= <<<HTML
					<li><a href="#tabs-$j">$titlejc $countercom</a></li>
HTML;
						} else {$scriptPage .='';} break;
				case 2:	if ($showvkontakte) { $scriptPage .= <<<HTML
					<li><a href="#tabs-$j">$titlevk</a></li>
HTML;
						} else {$scriptPage .='';} break;
				case 3:	if ($showfacebook) { $scriptPage .= <<<HTML
					<li><a href="#tabs-$j">$titlefc</a></li>
HTML;
						} else {$scriptPage .='';} break;
			}
			++$j;
		}
		return $scriptPage;
	}

	 public function onContentAfterDisplay($content){
		$plugin = & JPluginHelper::getPlugin('content', 'jlcommentspro');
		$plgParams = new JRegistry;
		$plgParams->loadString($plugin->params);
		
		$view = JRequest::getCmd('view');	
		$ADSShow= $plgParams->get('adscontent');
		$html='';
		IF ($ADSShow == 1 ) {
			IF ($view=='details') {
				$doc = &JFactory::getDocument();
				
				$uri = JURI::getInstance();
				$base = $uri->toString(array('scheme', 'host', 'port'));
				$article_url = JRoute::_('index.php?option=com_adsmanager&view=details&id='.$content->id.'&catid='.$content->catid.'&Itemid='.JRequest::getInt('Itemid', 0));

				$url_base = $article_url;
				$itmid = JRequest::getVar( 'Itemid' );
				
				
				$apiId = $plgParams->get('apiId');
				$width = $plgParams->get('width');
				$comLimit = $plgParams->get('comLimit');
				$attach = $plgParams->get('attach');
				$autoPublish = $plgParams->get('autoPublish');
				$norealtime = $plgParams->get('norealtime');
				$fbId = $plgParams->get('fbId');
				$fbadmin = $plgParams->get('fbadmin');
				$fb_lang = $plgParams->get('fb_lang');
				$typeviewer = $plgParams->get('typeviewer');
				
				$doc->addCustomTag('<meta property="fb:admins" content="'.$fbadmin.'"/>');
				$doc->addCustomTag('<meta property="fb:app_id" content="'.$fbId.'"/>');
				
				$doc->addCustomTag('<meta property="og:title" content="'.$content->product_name.'"/>');
				$doc->addCustomTag('<meta property="og:url" content="'.$url_base.'"/>');
				$doc->addCustomTag('<meta property="og:site_name" content="'.JFactory::getApplication()->getCfg('sitename').'"/>');
				$regular = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/";
				preg_match($regular, $product->text, $matches);
				if(isset($matches[1])&&($matches[1]!='')){
					$doc->addCustomTag('<meta property="og:image" content="'.$base.'/'.$matches[1].'"/>');
				}
				
				If ($typeviewer==0) {
					//if jquery
					if ($plgParams->get('jqload')=='1') {
						$doc->addCustomTag('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>');
					}
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/jquery.cookie.js"></script>');
					$doc->addCustomTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/jqueryui.custom.css");
					$doc->addCustomTag('<script type="text/javascript">var jqjlpro = jQuery.noConflict();</script>');
					$doc->addScriptDeclaration($script);
                   	if ($plgParams->get('unic')=='0') {$pagehash = $itmid.$content->id;}
                        else {$pagehash = '30000'.$content->id;}
					$orders = explode(",",$plgParams->get('orders'));

					$scriptPage = <<<HTML
						<script type="text/javascript">						
						var _current= jqjlpro.cookie('jltabactive');
						if (_current==null) _current = 0;
							jqjlpro(function($){
							  $("#tabs").tabs({
								event: "mousedown",
								selected: _current
							  });
							 $('ul.tabs li a').click(function(){
								var _tabs = $("#tabs").tabs();
								var selected = _tabs.tabs('option', 'selected');
								$.cookie('jltabactive', selected,{duration: 30});
								return false;
								})
							})(jQuery);
						</script>
									<div id="jlcomads"><div id="tabs"><ul class="tabs">
HTML;
								
			$scriptPage .= $this->addtabtitlejq($plgParams->get('showjcomments'),$plgParams->get('showvkontakte'),$plgParams->get('showfacebook'),$orders,$content->id, 'com_adsmanager',$plgParams->get('showcounter'),$plgParams);
				
			$scriptPage .= <<<HTML
                    </ul>
HTML;
$j=1;
foreach ($orders as $order) {		
			switch($order) {		
					case 1:
						$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
							require_once($comments);
							$jcomments = JComments::showComments($content->id, 'com_adsmanager', htmlspecialchars($content->ad_headline));
						}					
					if ($plgParams->get('showjcomments')) { $scriptPage .= <<<HTML
								<div id="tabs-$j">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($plgParams->get('showvkontakte')) { $scriptPage .= <<<HTML
								<script type="text/javascript" src="//vk.com/js/api/openapi.js?96"></script>
								<script type="text/javascript">
									VK.init({apiId: $apiId, onlyWidgets: true});
								</script>
								<div id="tabs-$j"><div id='jlcomments'></div>
									<script type='text/javascript'>
										VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime,pageUrl:'$url_base'},$pagehash);
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($plgParams->get('showfacebook')) { $scriptPage .= <<<HTML
                    <div id="tabs-$j">
									<script>(function(d){
										var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
										js = d.createElement('script'); js.id = id; js.async = true;
										js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
										d.getElementsByTagName('head')[0].appendChild(js);
									}(document));</script>
									<div class="fb-comments" data-href="$article_url" data-num-posts="$comLimit" data-width="$width"></div>
								</div>
					  					    


HTML;
					} else {$scriptPage .='';} break;

}
++$j;
}
$scriptPage .= <<<HTML
                    </div></div>
					
					
HTML;
							
	
				} else {
					//if standart
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/tabPane.js" type="text/javascript"></script>');
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/demo.js" type="text/javascript"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/styles.css");
					$doc->addScriptDeclaration($script);
                   	if ($plgParams->get('unic')=='0') {$pagehash = $itmid.$content->id;}
                        else {$pagehash = '30000'.$content->id;}
					$orders = explode(",",$plgParams->get('orders'));
										
					$scriptPage = <<<HTML
<div id="jlcomads">
                    <span id="demo_small">
                    <ul class="tabs">
HTML;
			$scriptPage .= $this->addtabtitle($plgParams->get('showjcomments'),$plgParams->get('showvkontakte'),$plgParams->get('showfacebook'),$orders,$content->id, 'com_adsmanager',$plgParams->get('showcounter'),$plgParams);
					
			$scriptPage .= <<<HTML
                    </ul>
HTML;
			foreach ($orders as $order) {		
			switch($order) {		
					case 1: 
						$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
							require_once($comments);
							$jcomments = JComments::showComments($content->id, 'com_adsmanager', htmlspecialchars($content->ad_headline));
						}					
					if ($plgParams->get('showjcomments')) { $scriptPage .= <<<HTML
								<div class="content">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($plgParams->get('showvkontakte')) { $scriptPage .= <<<HTML
								<div class="content">
									<div id='jlcomments'></div>
									<script type='text/javascript'>
									  VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime},$pagehash);
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($plgParams->get('showfacebook')) { $scriptPage .= <<<HTML
                    <div class="content">
                   		<script>(function(d){
						var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
						js = d.createElement('script'); js.id = id; js.async = true;
						js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
						d.getElementsByTagName('head')[0].appendChild(js);
						}(document));</script>
					<div class="fb-comments" data-href="$article_url" data-num-posts="$comLimit" data-width="$width"></div>
					
					  					    


HTML;
					} else {$scriptPage .='';} break;

}

}
					
$scriptPage .= <<<HTML
                    </div></div>
HTML;
					
				}
	 
		$html .= $scriptPage;
		}
		
	  }
		
		
		
		$metkaads = $this->params->def('metkaads');
        $metkaadson = $this->params->def('metkaadson');
        if ($metkaadson){
        $script = 'var jqaddsc = jQuery.noConflict();jqaddsc(document).ready(function(){var kk = jqaddsc("div#jlcomads").html(); if (kk.length>1){jqaddsc("'.$metkaads.'").html(kk);}jqaddsc("div#jlcomads").html(" ");});';
        $doc = &JFactory::getDocument();
        $doc->addScriptDeclaration($script);    }
		return $html;

	} //end function
	
	
	
	
public function ADSonContentAfterDisplay($content){
		$plugin = & JPluginHelper::getPlugin('content', 'jlcommentspro');
		$plgParams = new JRegistry;
		$plgParams->loadString($plugin->params);
		
		$view = JRequest::getCmd('view');	
		$ADSShow= $plgParams->get('adscontent');
		$html='';
		IF ($ADSShow == 1 ) {
			IF ($view=='details') {
				$doc = &JFactory::getDocument();
				
				$uri = JURI::getInstance();
				$base = $uri->toString(array('scheme', 'host', 'port'));
				$article_url = JRoute::_('index.php?option=com_adsmanager&view=details&id='.$content->id.'&catid='.$content->catid.'&Itemid='.JRequest::getInt('Itemid', 0));

				$url_base = $article_url;
				$itmid = JRequest::getVar( 'Itemid' );
				
				
				$apiId = $plgParams->get('apiId');
				$width = $plgParams->get('width');
				$comLimit = $plgParams->get('comLimit');
				$attach = $plgParams->get('attach');
				$autoPublish = $plgParams->get('autoPublish');
				$norealtime = $plgParams->get('norealtime');
				$fbId = $plgParams->get('fbId');
				$fbadmin = $plgParams->get('fbadmin');
				$fb_lang = $plgParams->get('fb_lang');
				$typeviewer = $plgParams->get('typeviewer');
				
				$doc->addCustomTag('<meta property="fb:admins" content="'.$fbadmin.'"/>');
				$doc->addCustomTag('<meta property="fb:app_id" content="'.$fbId.'"/>');
				
				$doc->addCustomTag('<meta property="og:title" content="'.$content->product_name.'"/>');
				$doc->addCustomTag('<meta property="og:url" content="'.$url_base.'"/>');
				$doc->addCustomTag('<meta property="og:site_name" content="'.JFactory::getApplication()->getCfg('sitename').'"/>');
				$regular = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/";
				preg_match($regular, $product->text, $matches);
				if(isset($matches[1])&&($matches[1]!='')){
					$doc->addCustomTag('<meta property="og:image" content="'.$base.'/'.$matches[1].'"/>');
				}
				
				If ($typeviewer==0) {
					//if jquery
					if ($plgParams->get('jqload')=='1') {
						$doc->addCustomTag('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>');
					}
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/jquery.cookie.js"></script>');
					$doc->addCustomTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/jqueryui.custom.css");
					$doc->addCustomTag('<script type="text/javascript">var jqjlpro = jQuery.noConflict();</script>');
					$doc->addScriptDeclaration($script);
                   	if ($plgParams->get('unic')=='0') {$pagehash = $itmid.$content->id;}
                        else {$pagehash = '30000'.$content->id;}
					$orders = explode(",",$plgParams->get('orders'));

					$scriptPage = <<<HTML
						<script type="text/javascript">						
						var _current= jqjlpro.cookie('jltabactive');
						if (_current==null) _current = 0;
							jqjlpro(function($){
							  $("#tabs").tabs({
								event: "mousedown",
								selected: _current
							  });
							 $('ul.tabs li a').click(function(){
								var _tabs = $("#tabs").tabs();
								var selected = _tabs.tabs('option', 'selected');
								$.cookie('jltabactive', selected,{duration: 30});
								return false;
								})
							})(jQuery);
						</script>
									<div id="jlcomads"><div id="tabs"><ul class="tabs">
HTML;
								
			$scriptPage .= $this->addtabtitlejq($plgParams->get('showjcomments'),$plgParams->get('showvkontakte'),$plgParams->get('showfacebook'),$orders,$content->id, 'com_adsmanager',$plgParams->get('showcounter'),$plgParams);
				
			$scriptPage .= <<<HTML
                    </ul>
HTML;
$j=1;
foreach ($orders as $order) {		
			switch($order) {		
					case 1:
						$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
							require_once($comments);
							$jcomments = JComments::showComments($content->id, 'com_adsmanager', htmlspecialchars($content->ad_headline));
						}					
					if ($plgParams->get('showjcomments')) { $scriptPage .= <<<HTML
								<div id="tabs-$j">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($plgParams->get('showvkontakte')) { $scriptPage .= <<<HTML
								<script type="text/javascript" src="//vk.com/js/api/openapi.js?96"></script>
								<script type="text/javascript">
									VK.init({apiId: $apiId, onlyWidgets: true});
								</script>
								<div id="tabs-$j"><div id='jlcomments'></div>
									<script type='text/javascript'>
										VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime,pageUrl:'$url_base'},$pagehash);
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($plgParams->get('showfacebook')) { $scriptPage .= <<<HTML
                    <div id="tabs-$j">
									<script>(function(d){
										var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
										js = d.createElement('script'); js.id = id; js.async = true;
										js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
										d.getElementsByTagName('head')[0].appendChild(js);
									}(document));</script>
									<div class="fb-comments" data-href="$article_url" data-num-posts="$comLimit" data-width="$width"></div>
								</div>
					  					    


HTML;
					} else {$scriptPage .='';} break;

}
++$j;
}
$scriptPage .= <<<HTML
                    </div></div>
					
					
HTML;
							
	
				} else {
					//if standart
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/tabPane.js" type="text/javascript"></script>');
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/demo.js" type="text/javascript"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/styles.css");
					$doc->addScriptDeclaration($script);
                   	if ($plgParams->get('unic')=='0') {$pagehash = $itmid.$content->id;}
                        else {$pagehash = '30000'.$content->id;}
					$orders = explode(",",$plgParams->get('orders'));
										
					$scriptPage = <<<HTML
<div id="jlcomads">
                    <span id="demo_small">
                    <ul class="tabs">
HTML;
			$scriptPage .= $this->addtabtitle($plgParams->get('showjcomments'),$plgParams->get('showvkontakte'),$plgParams->get('showfacebook'),$orders,$content->id, 'com_adsmanager',$plgParams->get('showcounter'),$plgParams);
					
			$scriptPage .= <<<HTML
                    </ul>
HTML;
			foreach ($orders as $order) {		
			switch($order) {		
					case 1: 
						$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
							require_once($comments);
							$jcomments = JComments::showComments($content->id, 'com_adsmanager', htmlspecialchars($content->ad_headline));
						}					
					if ($plgParams->get('showjcomments')) { $scriptPage .= <<<HTML
								<div class="content">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($plgParams->get('showvkontakte')) { $scriptPage .= <<<HTML
								<div class="content">
									<div id='jlcomments'></div>
									<script type='text/javascript'>
									  VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime},$pagehash);
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($plgParams->get('showfacebook')) { $scriptPage .= <<<HTML
                    <div class="content">
                   		<script>(function(d){
						var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
						js = d.createElement('script'); js.id = id; js.async = true;
						js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
						d.getElementsByTagName('head')[0].appendChild(js);
						}(document));</script>
					<div class="fb-comments" data-href="$article_url" data-num-posts="$comLimit" data-width="$width"></div>
					
					  					    


HTML;
					} else {$scriptPage .='';} break;

}

}
					
$scriptPage .= <<<HTML
                    </div></div>
HTML;
					
				}
	 
		$html .= $scriptPage;
		}
		
	  }
		
		
		
		$metkaads = $this->params->def('metkaads');
        $metkaadson = $this->params->def('metkaadson');
        if ($metkaadson){
        $script = 'var jqaddsc = jQuery.noConflict();jqaddsc(document).ready(function(){var kk = jqaddsc("div#jlcomads").html(); if (kk.length>1){jqaddsc("'.$metkaads.'").html(kk);}jqaddsc("div#jlcomads").html(" ");});';
        $doc = &JFactory::getDocument();
        $doc->addScriptDeclaration($script);    }
		return $html;

	} //end function
	
}//end class
