<?php
/**
 * Plugins JLcomments Pro
 * @version 2.7
 * @author Zhukov Artem (artem@joomline.ru)
 * @copyright (C) 2011-2013 by Zhukov Artem and Kunitsyn Vadim (http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die;
error_reporting(E_ERROR);

if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'lib'.DS.'k2plugin.php')) {
	JLoader::register('K2Plugin', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'lib'.DS.'k2plugin.php');
}
if (file_exists(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php')) {
	JLoader::register('ROUTEK2', JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
}
if (file_exists(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'route.php')) {
	JLoader::register('ROUTEVM', JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'route.php');
}
global $ps_product ;
if (file_exists(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php')) {
	JLoader::register('VIRTUEMART_PARCER', JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php');
}



jimport('joomla.plugin.plugin');

class plgContentJlcommentsPro extends JPlugin
{

	public function onContentPrepare($context, &$article, &$params, $page = 0){

		if (strpos($article->text, '{jlcommentspro-off}') !== false) {
			$article->text = str_replace("{jlcommentspro-off}","",$article->text);
			return false;
		}

		if (strpos($article->text, '{jlcomments}') == false && !$this->params->def('autoAdd')) {
			//return true;
		}
		if (!isset($article->catid)) {
			$article->catid='';
		}		
		
		
		$option			= JRequest::getCmd('option');
		$print			= JRequest::getCmd('print');
		$view			= JRequest::getCmd('view');
		
		switch ($option){
			case 'com_virtuemart':
			if ($view=='productdetails'){
				if($context == 'com_virtuemart.productdetails'){
				$VirtueShow= $this->params->def('virtcontent');
				IF ($VirtueShow == 1 ) {
						$product->text	= $this->prepareContentVirtue($context, $article, $params, $limitstart=0);						
						$metkavm = $this->params->def('metkavm');$metkavmon = $this->params->def('metkavmon');
						if ($metkavmon){
						$script = 'var jqaddsc = jQuery.noConflict();jqaddsc(document).ready(function(){var kk = jqaddsc("div#jlcomvirt").html(); if (kk.length>1){jqaddsc("'.$metkavm.'").html(kk);}jqaddsc("div#jlcomvirt").html(" ");});';
						$doc = &JFactory::getDocument();$doc->addScriptDeclaration($script);}
						/* $script="jqaddsc.post('".JURI::base()."plugins/content/jlcommentspro/js/ajax.php',{load:1},function(data){alert('Data Loaded: ' + data);});";
							$doc->addScriptDeclaration($script);if ($_GET['load']=='00'){$doc->addScriptDeclaration(print_r($_POST,true));}*/
						}}} break;
			case 'com_content':
				if($context == 'com_content.article'){
				If (!$print) {
				$exceptcat = is_array($this->params->def('categories')) ? $this->params->def('categories') : array($this->params->def('categories'));
				  if (in_array($article->catid,$exceptcat)) {
						$view = JRequest::getCmd('view');
						if ($view == 'article') {
						 $VirtueFinalHtml = $this -> prepareContentHTML($context, $article, $params, $page = 0);
							if ($this->params->def('autoAdd') == 1) {$article->text .=  $VirtueFinalHtml;
							} else {if (($this->params->def('autoAdd') == 0)&&(strpos($article->text, '{jlcommentspro}') == true)) {
								$article->text = str_replace("{jlcommentspro}",$VirtueFinalHtml,$article->text);
								/*$article->text .=  $VirtueFinalHtml;*/}}
						 }
					}else {$article->text = str_replace("{jlcommentspro}","",$article->text);}
				}}break;
		default:break;
	}
}

	function countcom($cntcom,$cntname){
		$commentsAPI = JPATH_SITE . '/components/com_jcomments/jcomments.php';
	 	if (is_file($commentsAPI)) {
	 		require_once($commentsAPI);
			$count = JComments::getCommentsCount($cntcom, $cntname);				
		}
		return $count;
	}

	function addtabtitle($showjcomments,$showvkontakte,$showfacebook,$orders,$cntcom,$cntname,$enabledshow,$lablename) {
	    $titlefc = $lablename->def('labelfc');
		$titlevk = $lablename->def('labelvk');
		$titlejc = $lablename->def('labeljc');
		$scriptPage='';
		
		$countercom = $enabledshow==1 ? '&nbsp;('.$this->countcom($cntcom,$cntname).')' : '';
		foreach ($orders as $order) {
			switch($order) {
				case 1:	if ($showjcomments) { $scriptPage .= <<<HTML
					<li class="tab">$lablename->def('labeljc') $countercom</li>
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
			/*JPlugin::loadLanguage( 'plg_content_jlcommentspro' );
			$titlefc = JText::_( 'PLG_JLCOMMENTSPRO_FB' );
			$titlevk = JText::_( 'PLG_JLCOMMENTSPRO_VK' );
			$titlejc = JText::_( 'PLG_JLCOMMENTSPRO_COMMENTS' );*/
			$titlefc = $lablename->def('labelfc');
			$titlevk = $lablename->def('labelvk');
			$titlejc = $lablename->def('labeljc');
		$j=1;
        $scriptPage='';
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
	
	
	//VIRTUE MART > 2.0.2
	function prepareContentVirtue($context, & $product, & $params, $limitstart) {
		$view = JRequest::getCmd('view');	
		$VirtueShow= $this->params->def('virtcontent');
		IF ($VirtueShow == 1 ) {
			IF ($view=='productdetails') {
				$doc = &JFactory::getDocument();
				
				$uri = JURI::getInstance();
				$base = $uri->toString(array('scheme', 'host', 'port'));
				$product_url = $base.urldecode(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id));
				$url_base = $product_url;
				$itmid = JRequest::getVar( 'Itemid' );
				
				
				$apiId = $this->params->def('apiId');
				$width = $this->params->def('width');
				$comLimit = $this->params->def('comLimit');
				$attach = $this->params->def('attach');
				$autoPublish = $this->params->def('autoPublish');
				$norealtime = $this->params->def('norealtime');
				$fbId = $this->params->def('fbId');
				$fbadmin = $this->params->def('fbadmin');
				$fb_lang = $this->params->def('fb_lang');
				$typeviewer = $this->params->def('typeviewer');
				
				$doc->addCustomTag('<meta property="fb:admins" content="'.$fbadmin.'"/>');
				$doc->addCustomTag('<meta property="fb:app_id" content="'.$fbId.'"/>');
								
				$doc->addCustomTag('<meta property="og:title" content="'.$product->product_name.'"/>');
				$doc->addCustomTag('<meta property="og:url" content="'.$url_base.'"/>');
				$doc->addCustomTag('<meta property="og:site_name" content="'.JFactory::getApplication()->getCfg('sitename').'"/>');
				
				if ($this->params->def('ogtagvm')=='0') {	
					$regular = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/";
					preg_match($regular, $product->text, $matches);
					if(isset($matches[1])&&($matches[1]!='')){
						$doc->addCustomTag('<meta property="og:image" content="'.$base.'/'.$matches[1].'"/>');
					}
				} else {
					$db = & JFactory::getDBO();
					$query = "SELECT media.file_url as medianame "
							 ."FROM `#__virtuemart_product_medias` prodmd "
							 ."LEFT JOIN `#__virtuemart_medias` media ON ( prodmd.virtuemart_media_id = media.virtuemart_media_id ) "
							 ." WHERE prodmd.virtuemart_product_id =".$product->virtuemart_product_id;
					$db->setQuery( $query );
					$rows = $db->loadObjectList();
					foreach ($rows as $row) {$imgname=$row->medianame;}
					if($imgname!=''){$doc->addCustomTag('<meta property="og:image" content="'.$base.'/'.$imgname.'"/>');}					
				}

				If ($typeviewer==0) {
					//if jquery
					if ($this->params->def('jqload')=='1') {
						$doc->addCustomTag('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>');
					}
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/jquery.cookie.js"></script>');
					$doc->addCustomTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/jqueryui.custom.css");
					$doc->addCustomTag('<script type="text/javascript">var jqjlpro = jQuery.noConflict();</script>');
					//$doc->addScriptDeclaration($script);
                   	if ($this->params->def('unic')==0) {$pagehash = $itmid.$product->virtuemart_product_id;}
                        else {$pagehash = '20000'.$product->virtuemart_product_id;}
					$orders = explode(",",$this->params->def('orders'));

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
							 <br clear="all"><div id="jlcomvirt">		<div id="tabs"><ul class="tabs">
HTML;
								
			$scriptPage .= $this->addtabtitlejq($this->params->def('showjcomments'),$this->params->def('showvkontakte'),$this->params->def('showfacebook'),$orders,$product->virtuemart_product_id, 'com_virtuemart',$this->params->def('showcounter'),$this->params);
				
			$scriptPage .= <<<HTML
                    </ul><div class="tabs-container">
HTML;
$j=1;
foreach ($orders as $order) {		
			switch($order) {		
					case 1:
						$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
						   require_once($comments);
							$jcomments = JComments::showComments($product->virtuemart_product_id, 'com_virtuemart', htmlspecialchars($product->product_name));
                        }
					if ($this->params->def('showjcomments')) { $scriptPage .= <<<HTML
								<div id="tabs-$j">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($this->params->def('showvkontakte')) { $scriptPage .= <<<HTML
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
					case 3: if ($this->params->def('showfacebook')) { $scriptPage .= <<<HTML
                                <div id="tabs-$j">
									<script>(function(d){
										var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
										js = d.createElement('script'); js.id = id; js.async = true;
										js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
										d.getElementsByTagName('head')[0].appendChild(js);
									}(document));</script>
									<div class="fb-comments" data-href="$product_url" data-num-posts="$comLimit" data-width="$width"></div>
								</div>
					  					    


HTML;
					} else {$scriptPage .='';} break;

}
++$j;
}
$scriptPage .= <<<HTML
                    </div></div>   </div>
					
					
HTML;
							
	
				} else {
					//if standart
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/tabPane.js" type="text/javascript"></script>');
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/demo.js" type="text/javascript"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/styles.css");
					$doc->addScriptDeclaration($script);
                   	if ($this->params->def('unic')==0) {$pagehash = $itmid.$product->virtuemart_product_id;}
                        else {$pagehash = '20000'.$product->virtuemart_product_id;}
					$orders = explode(",",$this->params->def('orders'));
										
					$scriptPage = <<<HTML
                    <br clear="all"><div id="jlcomvirt">
                    <span id="demo_small">
                    <ul class="tabs">
HTML;
			$scriptPage .= $this->addtabtitle($this->params->def('showjcomments'),$this->params->def('showvkontakte'),$this->params->def('showfacebook'),$orders,$product->virtuemart_product_id, 'com_virtuemart',$this->params->def('showcounter'),$this->params);
					
			$scriptPage .= <<<HTML
                    </ul>
HTML;
			foreach ($orders as $order) {		
			switch($order) {		
					case 1: 
						$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
							require_once($comments);
							$jcomments = JComments::showComments($product->virtuemart_product_id, 'com_virtuemart', htmlspecialchars($product->product_name));
						}					
					if ($this->params->def('showjcomments')) { $scriptPage .= <<<HTML
								<div class="content">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($this->params->def('showvkontakte')) { $scriptPage .= <<<HTML
								<div class="content">
									<div id='jlcomments'></div>
									<script type='text/javascript'>
									  VK.init({apiId: $apiId, onlyWidgets: true});	
									  VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime},$pagehash);
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($this->params->def('showfacebook')) { $scriptPage .= <<<HTML
                    <div class="content">
                   		<script>(function(d){
						var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
						js = d.createElement('script'); js.id = id; js.async = true;
						js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
						d.getElementsByTagName('head')[0].appendChild(js);
						}(document));</script>
					<div class="fb-comments" data-href="$product_url" data-num-posts="$comLimit" data-width="$width"></div>
					</div>
					  					    


HTML;
					} else {$scriptPage .='';} break;

}

}
					
$scriptPage .= <<<HTML
                    </div> </div>
HTML;
					
				}
		if ($this->params->def('autoAddvm') == 1) {
           $product->text = $product->text . $scriptPage;
		} else {if (($this->params->def('autoAddvm') == 0)&&(strpos($product->text, '{jlcommentspro}') == true)) {
			$product->text = str_replace("{jlcommentspro}","",$product->text);$product->text .= $scriptPage;
		}}

		}
	  }	
	}
	//END VIRTUE MART > 2.0.2
	
	
	function prepareContentHTML($context, &$article, &$params, $page = 0) {

			if (!isset($article->catid)) {
				$article->catid='';
			}
				$option_view			= JRequest::getCmd('option');
				if ($option_view=='com_content') {$jcomtype='com_content';} else {$jcomtype='com_virtuemart';}
				$doc = &JFactory::getDocument();
				$uri = JURI::getInstance();
				$base = $uri->toString(array('scheme', 'host', 'port'));
				$article_url = $base.urldecode(JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->catslug)));
				$url_base = $article_url;
				$itmid = JRequest::getVar( 'Itemid' );
			
				

				$apiId = $this->params->def('apiId');
				$width = $this->params->def('width');
				$comLimit = $this->params->def('comLimit');
				$attach = $this->params->def('attach');
				$autoPublish = $this->params->def('autoPublish');
				$norealtime = $this->params->def('norealtime');
				$fbId = $this->params->def('fbId');
				$fbadmin = $this->params->def('fbadmin');
				$fb_lang = $this->params->def('fb_lang');
				$typeviewer = $this->params->def('typeviewer');
				
				$doc->addCustomTag('<meta property="fb:admins" content="'.$fbadmin.'"/>');
				$doc->addCustomTag('<meta property="fb:app_id" content="'.$fbId.'"/>');
				
				$doc->addCustomTag('<meta property="og:title" content="'.$article->title.'"/>');
				$doc->addCustomTag('<meta property="og:url" content="'.$url_base.'"/>');
				$doc->addCustomTag('<meta property="og:site_name" content="'.JFactory::getApplication()->getCfg('sitename').'"/>');
				$regular = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/";
				preg_match($regular, $article->text, $matches);
				if(isset($matches[1])&&($matches[1]!='')){
					$doc->addCustomTag('<meta property="og:image" content="'.$base.'/'.$matches[1].'"/>');
				}
				
				//$doc->addScript("//vk.com/js/api/openapi.js?96");
				
				If ($typeviewer==0) {
					//if jquery
					if ($this->params->def('jqload')=='1') {
						$doc->addCustomTag('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>');
					}
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/jquery.cookie.js"></script>');
					$doc->addCustomTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/jqueryui.custom.css");
					$doc->addCustomTag('<script type="text/javascript">var jqjlpro = jQuery.noConflict();</script>');
					$doc->addScriptDeclaration($script);
                   	if ($this->params->def('unic')==0) {$pagehash = $itmid.$article->id;}
                        else {$pagehash = $article->id;}
					$orders = explode(",",$this->params->def('orders'));
						
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
									<br clear="all"><div id="tabs"><ul class="tabs">
HTML;
			$scriptPage .= $this->addtabtitlejq($this->params->def('showjcomments'),$this->params->def('showvkontakte'),$this->params->def('showfacebook'),$orders,$article->id,$jcomtype,$this->params->def('showcounter'),$this->params);
							
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
							$jcomments = JComments::showComments($article->id, $jcomtype, htmlspecialchars($article->title));
						}					
					if ($this->params->def('showjcomments')) { $scriptPage .= <<<HTML
								<div id="tabs-$j">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					
					case 2: if ($this->params->def('showvkontakte')) { $scriptPage .= <<<HTML
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
					case 3: if ($this->params->def('showfacebook')) { $scriptPage .= <<<HTML
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
                    </div>
HTML;
		
								
	
				} else {
					//if standart
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/tabPane.js" type="text/javascript"></script>');
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/demo.js" type="text/javascript"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/styles.css");
					$doc->addScriptDeclaration($script);
                   	if ($this->params->def('unic')==0) {$pagehash = $itmid.$article->id;}
                        else {$pagehash = $article->id;}
					$orders = explode(",",$this->params->def('orders'));
					$scriptPage = <<<HTML

                    <br clear="all"><span id="demo_small">
                    <ul class="tabs">
HTML;
			$scriptPage .= $this->addtabtitle($this->params->def('showjcomments'),$this->params->def('showvkontakte'),$this->params->def('showfacebook'),$orders,$article->id,$jcomtype,$this->params->def('showcounter'),$this->params);
				
			$scriptPage .= <<<HTML
                    </ul>
HTML;
			foreach ($orders as $order) {		
			switch($order) {		
					case 1: $comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
							require_once($comments);
							$jcomments = JComments::showComments($article->id, $jcomtype, htmlspecialchars($article->title));
						}					
					if ($this->params->def('showjcomments')) { $scriptPage .= <<<HTML
								<div class="content">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($this->params->def('showvkontakte')) { $scriptPage .= <<<HTML
								<div class="content">
									<div id='jlcomments'></div>
									<script type='text/javascript'>
									  VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime},$pagehash);
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($this->params->def('showfacebook')) { $scriptPage .= <<<HTML
                    <div class="content">
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

}
					
$scriptPage .= <<<HTML
                    </div>
HTML;
					
				}
				
		return $scriptPage;
	
	}
	

	
	
	

	function ShowInK2( & $item, & $params, $limitstart) {
	global $mainframe;
	$doc = &JFactory::getDocument();
				
				$category = &JTable::getInstance('K2Category', 'Table');
				$category->load($item->catid);
				
				$uri = JURI::getInstance();
				$base = $uri->toString(array('scheme', 'host', 'port'));
   			    $item_url = $base.urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($category->alias))));
				$url_base = $item_url;
				$itmid = JRequest::getVar( 'Itemid' );
				
				$apiId = $this->params->def('apiId');
				$width = $this->params->def('width');
				$comLimit = $this->params->def('comLimit');
				$attach = $this->params->def('attach');
				$autoPublish = $this->params->def('autoPublish');
				$norealtime = $this->params->def('norealtime');
				$fbId = $this->params->def('fbId');
				$fbadmin = $this->params->def('fbadmin');
				$fb_lang = $this->params->def('fb_lang');
				$typeviewer = $this->params->def('typeviewer');
				
				$doc->addCustomTag('<meta property="fb:admins" content="'.$fbadmin.'"/>');
				$doc->addCustomTag('<meta property="fb:app_id" content="'.$fbId.'"/>');

                $text  = strip_tags( $item->metadesc );
                //$regular = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/";
				//$text= preg_replace($regular, '', $text);

				$doc->addCustomTag('<meta property="og:title" content="'.$item->title.'"/>');
				$doc->addCustomTag('<meta property="og:description" content="'.$text.'"/>');
				$doc->addCustomTag('<meta property="og:type" content="blog"/>');
				$doc->addCustomTag('<meta property="og:url" content="'.$url_base.'"/>');
				$doc->addCustomTag('<meta property="og:site_name" content="'.JFactory::getApplication()->getCfg('sitename').'"/>');
				
				if ($this->params->def('ogtagk2')=='0') {
					$regular = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/";
					preg_match($regular, $item->text, $matches);
					if(isset($matches[1])&&($matches[1]!='')){
						$doc->addCustomTag('<meta property="og:image" content="'.$base.'/'.$matches[1].'"/>');
					}
				} else {
					if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_L.jpg')){
						$imgname = /*JURI::root()*/$base.'/media/k2/items/cache/'.md5("Image".$item->id).'_L.jpg';}else{$imgname='';}
					if($imgname!=''){$doc->addCustomTag('<meta property="og:image" content="'.$imgname.'"/>');}					
				}
				
				If ($typeviewer==0) {
					//if jquery
					if ($this->params->def('jqload')=='1') {
						$doc->addCustomTag('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>');
					}
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/jquery.cookie.js"></script>');
					$doc->addCustomTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/jqueryui.custom.css");
					$doc->addCustomTag('<script type="text/javascript">var jqjlpro = jQuery.noConflict();</script>');
					$doc->addScriptDeclaration($script);
                   	if ($this->params->def('unic')==0) {$pagehash = $itmid.$item->id;}
                        else {$pagehash = '10000'.$item->id;}
					$orders = explode(",",$this->params->def('orders'));
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
									<br clear="all"><div id="jlcomk2"><div id="tabs"><ul class="tabs">

HTML;
								
			$scriptPage .= $this->addtabtitlejq($this->params->def('showjcomments'),$this->params->def('showvkontakte'),$this->params->def('showfacebook'),$orders,$item->id, 'com_k2',$this->params->def('showcounter'),$this->params);
				
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
							$jcomments = JComments::showComments($item->id, 'com_k2', htmlspecialchars($item->title));
						}
					
					if ($this->params->def('showjcomments')) { $scriptPage .= <<<HTML
								<div id="tabs-$j">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($this->params->def('showvkontakte')) { $scriptPage .= <<<HTML
								<script type="text/javascript" src="//vk.com/js/api/openapi.js?96"></script>
								<script type="text/javascript">
									VK.init({apiId: $apiId, onlyWidgets: true});
								</script>
								<div id="tabs-$j"><div id='jlcomments'></div>
									<script type='text/javascript'>
										if(window.VK) {VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime,pageUrl:'$url_base'},$pagehash);}
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($this->params->def('showfacebook')) { $scriptPage .= <<<HTML
							<div id="tabs-$j">
									<script>(function(d){
										var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
										js = d.createElement('script'); js.id = id; js.async = true;
										js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
										d.getElementsByTagName('head')[0].appendChild(js);
									}(document));</script>
									<div class="fb-comments" data-href="$item_url" data-num-posts="$comLimit" data-width="$width"></div>
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
                   	if ($this->params->def('unic')==0) {$pagehash = $itmid.$item->id;}
                        else {$pagehash = '10000'.$item->id;}
					$orders = explode(",",$this->params->def('orders'));
					$scriptPage = <<<HTML
<br clear="all"><div id="jlcomk2">
                    <span id="demo_small">
                    <ul class="tabs">
HTML;
			$scriptPage .= $this->addtabtitle($this->params->def('showjcomments'),$this->params->def('showvkontakte'),$this->params->def('showfacebook'),$orders,$item->id,'com_k2',$this->params->def('showcounter'),$this->params);
				
			$scriptPage .= <<<HTML
                    </ul>
HTML;
			foreach ($orders as $order) {		
			switch($order) {		
					case 1: 
						$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
							require_once($comments);
							$jcomments = JComments::showComments($item->id, 'com_k2', htmlspecialchars($item->title));
						}
					
					if ($this->params->def('showjcomments')) { $scriptPage .= <<<HTML
								<div class="content">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($this->params->def('showvkontakte')) { $scriptPage .= <<<HTML
								<div class="content">
									<div id='jlcomments'></div>
									<script type='text/javascript'>
										if(window.VK) {VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime,pageUrl:'$url_base'},$pagehash);}
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($this->params->def('showfacebook')) { $scriptPage .= <<<HTML
                    <div class="content">
                   		<script>(function(d){
						var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
						js = d.createElement('script'); js.id = id; js.async = true;
						js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
						d.getElementsByTagName('head')[0].appendChild(js);
						}(document));</script>
					<div class="fb-comments" data-href="$item_url" data-num-posts="$comLimit" data-width="$width"></div>
					</div>
					  					    


HTML;
					} else {$scriptPage .='';} break;

}

}
					
$scriptPage .= <<<HTML
                    </div></div>
HTML;
					
				}

			return $scriptPage;
			
	}
	
	//====================================================================
	function onK2PrepareContent( & $item, & $params, $limitstart) {

	}
	
	
	//====================================================================
	function onK2AfterDisplay( & $item, & $params, $limitstart) {
	  if ($params->def('sh404SefModK2ContentFeedAlias')!=''){
	$view = JRequest::getCmd('view');
	$k2After= $this->params->def('k2After');
	IF (($k2After == 1 ) &&($this->params->def('k2showself')==0)) {
	  IF ($view=='item') {
		$exceptcat = is_array($this->params->def('k2categories')) ? $this->params->def('k2categories') : ($this->params->def('k2categories'));
	
		if (in_array($item->catid,$exceptcat)) {
			$k2vidj = $this->ShowInK2( $item, $params, $limitstart);
			
			$metkak2 = $this->params->def('metkak2');
			$metkavmon = $this->params->def('metkak2on');
			if ($metkavmon){
			$script = 'var jqaddsc = jQuery.noConflict();jqaddsc(document).ready(function(){var kk = jqaddsc("div#jlcomk2").html(); if (kk.length>1){jqaddsc("'.$metkak2.'").html(kk);}jqaddsc("div#jlcomk2").html(" ");});';
			$doc = &JFactory::getDocument();
			$doc->addScriptDeclaration($script);    }
			
			return $k2vidj;
			}
		} 
		}
        }

	}
	
	
	//====================================================================
	function onK2AfterDisplayContent(& $item, & $params, $limitstart) {

       //echo '<pre>'.print_r($item['itemImageXS'],true).'</pre>';

     //echo '<pre>'.print_r($params,true).'</pre>';

       if ($params->def('sh404SefModK2ContentFeedAlias')!=''){
    	$view = JRequest::getCmd('view');
    	$k2After= $this->params->def('k2After');
    	IF (($k2After == 2 ) &&($this->params->def('k2showself')==0)) {
    	  IF ($view=='item') {
    		$exceptcat = is_array($this->params->def('k2categories')) ? $this->params->def('k2categories') : array($this->params->def('k2categories'));
    		if (in_array($item->catid,$exceptcat)) {
    			$k2vidj = $this->ShowInK2( $item, $params, $limitstart);
    			return $k2vidj;
    			$metkak2 = $this->params->def('metkak2');
    			$metkavmon = $this->params->def('metkak2on');
    			if ($metkavmon){
    			$script = 'var jqaddsc = jQuery.noConflict();jqaddsc(document).ready(function(){var kk = jqaddsc("div#jlcomk2").html(); if (kk.length>1){jqaddsc("'.$metkak2.'").html(kk);}jqaddsc("div#jlcomk2").html(" ");});';
    			$doc = &JFactory::getDocument();
    			$doc->addScriptDeclaration($script);    }


    			}
    		}
    	  }
          }

	}
	
	
	
	//====================================================================================
	
	 function PrepareContent(& $product, & $params, $limitstart){
		$view = JRequest::getCmd('view');	
		$VirtueShow= $this->params->def('virtcontent');
		IF ($VirtueShow == 1 ) {
			IF ($view=='productdetails') {
				$doc = &JFactory::getDocument();
				
				$uri = JURI::getInstance();
				$base = $uri->toString(array('scheme', 'host', 'port'));
				$product_url = $base.urldecode(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id));
				$url_base = $product_url;
				$itmid = JRequest::getVar( 'Itemid' );
				
				
				$apiId = $this->params->def('apiId');
				$width = $this->params->def('width');
				$comLimit = $this->params->def('comLimit');
				$attach = $this->params->def('attach');
				$autoPublish = $this->params->def('autoPublish');
				$norealtime = $this->params->def('norealtime');
				$fbId = $this->params->def('fbId');
				$fbadmin = $this->params->def('fbadmin');
				$fb_lang = $this->params->def('fb_lang');
				$typeviewer = $this->params->def('typeviewer');
				
				$doc->addCustomTag('<meta property="fb:admins" content="'.$fbadmin.'"/>');
				$doc->addCustomTag('<meta property="fb:app_id" content="'.$fbId.'"/>');
				
				$doc->addCustomTag('<meta property="og:title" content="'.$product->product_name.'"/>');
				$doc->addCustomTag('<meta property="og:url" content="'.$url_base.'"/>');
				$doc->addCustomTag('<meta property="og:site_name" content="'.JFactory::getApplication()->getCfg('sitename').'"/>');
				
				if ($this->params->def('ogtagvm')=='0') {	
					$regular = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/";
					preg_match($regular, $product->text, $matches);
					if(isset($matches[1])&&($matches[1]!='')){
						$doc->addCustomTag('<meta property="og:image" content="'.$base.'/'.$matches[1].'"/>');
					}
				} else {
					$db = & JFactory::getDBO();
					$query = "SELECT media.file_url as medianame "
							 ."FROM `#__virtuemart_product_medias` prodmd "
							 ."LEFT JOIN `#__virtuemart_medias` media ON ( prodmd.virtuemart_media_id = media.virtuemart_media_id ) "
							 ." WHERE prodmd.virtuemart_product_id =".$product->virtuemart_product_id;
					$db->setQuery( $query );
					$rows = $db->loadObjectList();
					foreach ($rows as $row) {$imgname=$row->medianame;}
					if($imgname!=''){$doc->addCustomTag('<meta property="og:image" content="'.$base.'/'.$imgname.'"/>');}					
				}
				
				If ($typeviewer==0) {
					//if jquery
					if ($this->params->def('jqload')=='1') {
						$doc->addCustomTag('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>');
					}
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/jquery.cookie.js"></script>');
					$doc->addCustomTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/jqueryui.custom.css");
					$doc->addCustomTag('<script type="text/javascript">var jqjlpro = jQuery.noConflict();</script>');
					//$doc->addScriptDeclaration($script);
                   	if ($this->params->def('unic')==0) {$pagehash = $itmid.$product->virtuemart_product_id;}
                        else {$pagehash = '20000'.$product->virtuemart_product_id;}
					$orders = explode(",",$this->params->def('orders'));

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
						 <br clear="all"><div id="jlcomvirt">			<div id="tabs"><ul class="tabs">
HTML;
								
			$scriptPage .= $this->addtabtitlejq($this->params->def('showjcomments'),$this->params->def('showvkontakte'),$this->params->def('showfacebook'),$orders,$product->virtuemart_product_id, 'com_virtuemart',$this->params->def('showcounter'),$this->params);
				
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
							$jcomments = JComments::showComments($product->virtuemart_product_id, 'com_virtuemart', htmlspecialchars($product->product_name));
						}					
					if ($this->params->def('showjcomments')) { $scriptPage .= <<<HTML
								<div id="tabs-$j">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($this->params->def('showvkontakte')) { $scriptPage .= <<<HTML
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
					case 3: if ($this->params->def('showfacebook')) { $scriptPage .= <<<HTML
                    <div id="tabs-$j">
									<script>(function(d){
										var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
										js = d.createElement('script'); js.id = id; js.async = true;
										js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
										d.getElementsByTagName('head')[0].appendChild(js);
									}(document));</script>
									<div class="fb-comments" data-href="$product_url" data-num-posts="$comLimit" data-width="$width"></div>
								</div>
					  					    


HTML;
					} else {$scriptPage .='';} break;

}
++$j;
}
$scriptPage .= <<<HTML
                    </div> </div>
					
					
HTML;
							
	
				} else {
					//if standart
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/tabPane.js" type="text/javascript"></script>');
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/demo.js" type="text/javascript"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/styles.css");
					$doc->addScriptDeclaration($script);
                   	if ($this->params->def('unic')==0) {$pagehash = $itmid.$product->virtuemart_product_id;}
                        else {$pagehash = '20000'.$product->virtuemart_product_id;}
					$orders = explode(",",$this->params->def('orders'));
										
					$scriptPage = <<<HTML
                     <br clear="all"> <div id="jlcomvirt">
                    <span id="demo_small">
                    <ul class="tabs">
HTML;
			$scriptPage .= $this->addtabtitle($this->params->def('showjcomments'),$this->params->def('showvkontakte'),$this->params->def('showfacebook'),$orders,$product->virtuemart_product_id, 'com_virtuemart',$this->params->def('showcounter'),$this->params);
					
			$scriptPage .= <<<HTML
                    </ul>
HTML;
			foreach ($orders as $order) {		
			switch($order) {		
					case 1: 
						$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
							require_once($comments);
							$jcomments = JComments::showComments($product->virtuemart_product_id, 'com_virtuemart', htmlspecialchars($product->product_name));
						}					
					if ($this->params->def('showjcomments')) { $scriptPage .= <<<HTML
								<div class="content">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($this->params->def('showvkontakte')) { $scriptPage .= <<<HTML
								<div class="content">
									<div id='jlcomments'></div>
									<script type='text/javascript'>
									  VK.init({apiId: $apiId, onlyWidgets: true});	
									  VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime},$pagehash);
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($this->params->def('showfacebook')) { $scriptPage .= <<<HTML
                    <div class="content">
                   		<script>(function(d){
						var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
						js = d.createElement('script'); js.id = id; js.async = true;
						js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
						d.getElementsByTagName('head')[0].appendChild(js);
						}(document));</script>
					<div class="fb-comments" data-href="$product_url" data-num-posts="$comLimit" data-width="$width"></div>
                    </div>
					  					    


HTML;
					} else {$scriptPage .='';} break;

}

}
					
$scriptPage .= <<<HTML
                    </div>  </div>
HTML;
					
				}
		
	if ($this->params->def('autoAddvm') == 1) {
		$product->text = $product->text . $scriptPage;

		$metkavm = $this->params->def('metkavm');
        $metkavmon = $this->params->def('metkavmon');
        if ($metkavmon){
        $script = 'var jqaddsc = jQuery.noConflict();jqaddsc(document).ready(function(){var kk = jqaddsc("div#jlcomvirt").html(); if (kk.length>1){jqaddsc("'.$metkavm.'").html(kk);}jqaddsc("div#jlcomvirt").html(" ");});';
        $doc = &JFactory::getDocument();
        $doc->addScriptDeclaration($script);    }
    /* $script = 'var jqaddsc = jQuery.noConflict();jqaddsc(document).ready(function(){var kk = jqaddsc("div#jlcomvirt").html(); if (kk.length>1){jqaddsc("'.$metkavm.'").html(kk);}jqaddsc("div#jlcomvirt").html(" ");});';
     $doc->addScriptDeclaration($script);*/
	 } else {if (($this->params->def('autoAddvm') == 0)&&(strpos($product->text, '{jlcommentspro}') == true)) {
			$product->text = str_replace("{jlcommentspro}","",$product->text);$product->text .= $scriptPage;
		}}
		
		}
	  }
	 }

	
	
	
	
	
	
	
	

}
