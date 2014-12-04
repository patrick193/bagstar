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
jimport('joomla.plugin.plugin');
jimport ('joomla.html.parameter');
jimport( 'joomla.environment.response' );


class plgK2JlcommentsProK2 extends JPlugin {
	public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }
	
	function countcom($cntcom,$cntname){
		$commentsAPI = JPATH_SITE . '/components/com_jcomments/jcomments.php';
	 	if (is_file($commentsAPI)) {
	 		require_once($commentsAPI);
			$count = JComments::getCommentsCount($cntcom, $cntname);				
		}
		return $count;
	}
	
	function getlangvar(){
		JPlugin::loadLanguage( 'plg_content_jlcommentspro' );
		$title['fc'] = JText::_( 'PLG_JLCOMMENTSPRO_TITLE_FC' );
		$title['vk'] = JText::_( 'PLG_JLCOMMENTSPRO_TITLE_VK' );
		$title['jc'] = JText::_( 'PLG_JLCOMMENTSPRO_TITLE_JC' );
		$title['k2'] = JText::_( 'PLG_JLCOMMENTSPRO_TITLE_K2' );
		return $title;
	
	}
	
	function addtabtitle($showjcomments,$showvkontakte,$showfacebook,$orders,$cntcom,$cntname,$enabledshow,$jcomtok2,$lablename) {
		$scriptPage = '';
		$countercom = $enabledshow==1 ? '&nbsp;('.$this->countcom($cntcom,$cntname).')' : '';
		JPlugin::loadLanguage( 'plg_content_jlcommentspro' );
		$titlefc = $lablename->get('labelfc');
		$titlevk = $lablename->get('labelvk');
		$titlejc = $lablename->get('labeljc');
		$titlek2 = $lablename->get('labelk2');
		//$varlang = getlangvar();
		foreach ($orders as $order) {
			switch($order) {
				case 1:	if ($jcomtok2) {$scriptPage .= <<<HTML
					<li class="tab">K2</li>
HTML;
				} elseif ($showjcomments) { $scriptPage .= <<<HTML
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
						
				case 4:	if ($showk2) { $scriptPage .= <<<HTML
					<li class="tab">$titlek2</li>
HTML;
						} else {$scriptPage .='';} break;		
			}
		}
		return $scriptPage;
		
	}
	
	
		function addtabtitlejq($showjcomments,$showvkontakte,$showfacebook,$orders,$cntcom,$cntname,$enabledshow,$jcomtok2,$lablename) {
//		function addtabtitlejq($showjcomments,$showvkontakte,$showfacebook,$orders) {
		$j=1;
		$scriptPage = '';
		$countercom = $enabledshow==1 ? '&nbsp;('.$this->countcom($cntcom,$cntname).')' : '';
		$titlefc = $lablename->get('labelfc');
		$titlevk = $lablename->get('labelvk');
		$titlejc = $lablename->get('labeljc');
		$titlek2 = $lablename->get('labelk2');
        foreach ($orders as $order) {
			switch($order) {
				case 1:	if ($jcomtok2) {$scriptPage .= <<<HTML
					<li><a href="#tabs-$j">$titlek2</a></li>
HTML;
				} elseif ($showjcomments) { $scriptPage .= <<<HTML
					<li><a href="#tabs-$j">$titlejc $countercom</a></li>
HTML;
						} else {$scriptPage .='';} break;
				case 2:	if ($showvkontakte==1) { $scriptPage .= <<<HTML
					<li><a href="#tabs-$j">$titlevk</a></li>
HTML;
						} else {$scriptPage .='';} break;
				case 3:	if ($showfacebook==1) { $scriptPage .= <<<HTML
					<li><a href="#tabs-$j">$titlefc</a></li>
HTML;
						} else {$scriptPage .='';} break;
			}
			++$j;
		}
		return $scriptPage;
	}

	
	public function onK2CommentsBlock(&$item, &$params, $limitstart){
		//echo '<pre>'.print_r($item,true).'</pre>';
		$plugin = & JPluginHelper::getPlugin('content', 'jlcommentspro');
		$plgParams = new JRegistry;
		$plgParams->loadString($plugin->params);
		$k2showself = $plgParams->get('k2showself');
		//echo 'KK'.$k2showself;
	IF ($k2showself == 1 ) {
		global $mainframe;
		$doc = &JFactory::getDocument();
				
				$category = &JTable::getInstance('K2Category', 'Table');
				$category->load($item->catid);
				
				$uri = JURI::getInstance();
				$base = $uri->toString(array('scheme', 'host', 'port'));
   			    $item_url = $base.urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($category->alias))));
				$url_base = $item_url;
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

                $text  = strip_tags( $item->metadesc );
                //$regular = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/";
				//$text= preg_replace($regular, '', $text);

				$doc->addCustomTag('<meta property="og:title" content="'.$item->title.'"/>');
				$doc->addCustomTag('<meta property="og:description" content="'.$text.'"/>');
				$doc->addCustomTag('<meta property="og:type" content="blog"/>');
				$doc->addCustomTag('<meta property="og:url" content="'.$url_base.'"/>');
				$doc->addCustomTag('<meta property="og:site_name" content="'.JFactory::getApplication()->getCfg('sitename').'"/>');
				
				if ($plgParams->get('ogtagk2')=='0') {
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
					if ($plgParams->get('jqload')=='1') {
						$doc->addCustomTag('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>');
					}
					$doc->addCustomTag('<script src="'.JURI::base().'plugins/content/jlcommentspro/js/jquery.cookie.js"></script>');
					$doc->addCustomTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>');
					$doc->addStyleSheet(JURI::base()."plugins/content/jlcommentspro/css/jqueryui.custom.css");
					$doc->addCustomTag('<script type="text/javascript">var jqjlpro = jQuery.noConflict();</script>');
					$doc->addScriptDeclaration($script);
                   	if ($plgParams->get('unic')==0) {$pagehash = $itmid.$item->id;}
                        else {$pagehash = '10000'.$item->id;}
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
									<br clear="all"><div id="jlcomk2"><div id="tabs"><ul class="tabs">

HTML;
								
			$scriptPage .= $this->addtabtitlejq($plgParams->get('showjcomments'),$plgParams->get('showvkontakte'),$plgParams->get('showfacebook'),$orders,$item->id,'com_k2',$plgParams->get('showcounter'),$plgParams->get('replacejcommentsk2'),$plgParams);
				
			$scriptPage .= <<<HTML
                    </ul>
HTML;
$j=1;
foreach ($orders as $order) {		
			switch($order) {		
					case 1: 
						if ($plgParams->get('replacejcommentsk2')){
							$scriptPage .= "<div id=\"tabs-$j\">";
								 JLoader::register('K2HelperPermissions', JPATH_SITE.'/components/com_k2/helpers/permissions.php');
								require_once dirname(__FILE__).'/helper.php'; 
								$scriptPage .= plgJLCommentsProHelperK2::get_comments_form($item);
								$scriptPage .= "</div>";						
						} elseif ($plgParams->get('showjcomments')) {
							$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
							if (is_file($comments)) {
								require_once($comments);
								$jcomments = JComments::showComments($item->id, 'com_k2', htmlspecialchars($item->title));
							}							
							$scriptPage .= "<div id=\"tabs-$j\">$jcomments</div>";
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($plgParams->get('showvkontakte')) { $scriptPage .= <<<HTML
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
					case 3: if ($plgParams->get('showfacebook')) { $scriptPage .= <<<HTML
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
                   	if ($plgParams->get('unic')==0) {$pagehash = $itmid.$item->id;}
                        else {$pagehash = '10000'.$item->id;}
					$orders = explode(",",$plgParams->get('orders'));
					$scriptPage = <<<HTML
<br clear="all"><div id="jlcomk2">
                    <span id="demo_small">
                    <ul class="tabs">
HTML;
			$scriptPage .= $this->addtabtitle($plgParams->get('showjcomments'),$plgParams->get('showvkontakte'),$plgParams->get('showfacebook'),$orders,$item->id,'com_k2',$plgParams->get('showcounter'),$plgParams);
				
			$scriptPage .= <<<HTML
                    </ul>
HTML;
			foreach ($orders as $order) {		
			switch($order) {		
					case 1: 
						if ($plgParams->get('replacejcommentsk2')){
							$scriptPage .= "<div id=\"tabs-$j\">";
								JLoader::register('K2HelperPermissions', JPATH_SITE.'/components/com_k2/helpers/permissions.php');
								require_once dirname(__FILE__).'/helper.php'; 
								$scriptPage .= plgJLCommentsProHelperK2::get_comments_form($item);
								$scriptPage .= "</div>";						
						} elseif ($plgParams->get('showjcomments')) {
							$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
							if (is_file($comments)) {
								require_once($comments);
								$jcomments = JComments::showComments($item->id, 'com_k2', htmlspecialchars($item->title));
							}
					
						$scriptPage .= <<<HTML
								<div class="content">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($plgParams->get('showvkontakte')) { $scriptPage .= <<<HTML
								<div class="content">
									<div id='jlcomments'></div>
									<script type='text/javascript'>
										if(window.VK) {VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime,pageUrl:'$url_base'},$pagehash);}
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
}//if

	}


	
}//end class
