<?php
/**
 * Plugins JLcomments Pro
 * @version 2.7
 * @author Zhukov Artem (artem@joomline.ru)
 * @copyright (C) 2012-2013 by Zhukov Artem and Kunitsyn Vadim (http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
**/


class ElementJlCommentsProZooEl extends Element implements iSubmittable {

	public function hasValue($params = array()) {
		return (bool) $this->get('value', $this->config->get('default'));
	}


	public function render($params = array()) {
		
		if ($this->get('value', $this->config->get('default'))) {
		
			$html = array();	
			$item_route = JRoute::_($this->app->route->item($this->_item, false), true, -1);
			$item_id = $this->_item->id;
			
			$apiId = $this->config->get('apiId');
			$width = $this->config->get('width');
			$comLimit = $this->config->get('comLimit');
			$attach = $this->config->get('attach');
			$autoPublish = $this->config->get('autoPublish');
			$norealtime = $this->config->get('norealtime');
			$fbId = $this->config->get('fbId');
			$fbadmin = $this->config->get('fbadmin');
			$fb_lang = $this->config->get('fb_lang');
			$typeviewer = $this->config->get('typeviewer');
				
			$this->app->system->document->addCustomTag('<meta property="fb:admins" content="'.$fbadmin.'"/>');
			$this->app->system->document->addCustomTag('<meta property="fb:app_id" content="'.$fbId.'"/>');
			
			$this->app->system->document->addCustomTag('<meta property="og:title" content="'.$this->_item->name.'"/>');
			$this->app->system->document->addCustomTag('<meta property="og:url" content="'.$item_route.'"/>');
			$this->app->system->document->addCustomTag('<meta property="og:site_name" content="'.JFactory::getApplication()->getCfg('sitename').'"/>');
			
			
		If ($typeviewer==0) {
				//if jquery
				if ($this->config->get('jqload')=='1') {
					$this->app->system->document->addCustomTag('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>');
				}
					$this->app->system->document->addCustomTag('<script src="'.JURI::base().'media/zoo/elements/jlcommentsprozooel/assets/js/jquery.cookie.js"></script>');
					$this->app->system->document->addCustomTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>');
					$this->app->system->document->addStylesheet(JURI::base()."media/zoo/elements/jlcommentsprozooel/assets/css/jqueryui.custom.css");
					$this->app->system->document->addCustomTag('<script type="text/javascript">var jqjlpro = jQuery.noConflict();</script>');
					if ($this->config->get('unic')=='0') {$pagehash = $itmid.$item_id;}
                        else {$pagehash = '80000'.$item_id;}
					$orders = explode(",",$this->config->get('orders'));

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
								
			$scriptPage .= self::addtabtitlejq($this->config->get('showjcomments'),$this->config->get('showvkontakte'),$this->config->get('showfacebook'),$orders,$item_id,'com_zoo',$this->config->get('showcounter'),$this->config);

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
							$jcomments = JComments::showComments($item_id, 'com_zoo', htmlspecialchars($this->_item->name));
						}					
					if ($this->config->get('showjcomments')) { $scriptPage .= <<<HTML
								<div id="tabs-$j">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($this->config->get('showvkontakte')) { $scriptPage .= <<<HTML
								<script type="text/javascript" src="//vk.com/js/api/openapi.js?96"></script>
								<script type="text/javascript">
									VK.init({apiId: $apiId, onlyWidgets: true});
								</script>
								<div id="tabs-$j"><div id='jlcomments'></div>
									<script type='text/javascript'>
										VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime,pageUrl:'$item_route'},$pagehash);
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($this->config->get('showfacebook')) { $scriptPage .= <<<HTML
                    <div id="tabs-$j">
									<script>(function(d){
										var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
										js = d.createElement('script'); js.id = id; js.async = true;
										js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
										d.getElementsByTagName('head')[0].appendChild(js);
									}(document));</script>
									<div class="fb-comments" data-href="$item_route" data-num-posts="$comLimit" data-width="$width"></div>
								</div>
					  					    


HTML;
					} else {$scriptPage .='';} break;

}
++$j;
}
$scriptPage .= <<<HTML
                    </div></div>
					
					
HTML;
							
	
				} else {//if standart					
					$this->app->system->document->addCustomTag('<script src="'.JURI::base().'media/zoo/elements/jlcommentsprozooel/assets/js/tabPane.js" type="text/javascript"></script>');
					$this->app->system->document->addCustomTag('<script src="'.JURI::base().'media/zoo/elements/jlcommentsprozooel/assets/js/demo.js" type="text/javascript"></script>');
					$this->app->system->document->addStyleSheet(JURI::base()."media/zoo/elements/jlcommentsprozooel/assets/css/styles.css");
					if ($this->config->get('unic')=='0') {$pagehash = $itmid.$item_id;}
                        else {$pagehash = '80000'.$item_id;}
					$orders = explode(",",$this->config->get('orders'));
										
					$scriptPage = <<<HTML
<div id="jlcomads">
                    <span id="demo_small">
                    <ul class="tabs">
HTML;
			$scriptPage .= self::addtabtitle($this->config->get('showjcomments'),$this->config->get('showvkontakte'),$this->config->get('showfacebook'),$orders,$item_id, 'com_zoo',$this->config->get('showcounter'),$this->config);
					
			$scriptPage .= <<<HTML
                    </ul>
HTML;
			foreach ($orders as $order) {		
			switch($order) {		
					case 1: 
						$comments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
						if (is_file($comments)) {
							require_once($comments);
							$jcomments = JComments::showComments($item_id, 'com_zoo', htmlspecialchars($this->_item->name));
						}					
					if ($this->config->get('showjcomments')) { $scriptPage .= <<<HTML
								<div class="content">
									$jcomments
								</div>
HTML;
						} else {$scriptPage .='';$showjcomments='-1';} break;
					case 2: if ($this->config->get('showvkontakte')) { $scriptPage .= <<<HTML
								<div class="content">
									<div id='jlcomments'></div>
									<script type='text/javascript'>
									  VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime,pageUrl:'$item_route'},$pagehash);
									</script>
								</div>
HTML;
						} else {$scriptPage .='';} break;					  
					case 3: if ($this->config->get('showfacebook')) { $scriptPage .= <<<HTML
                    <div class="content">
                   		<script>(function(d){
						var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
						js = d.createElement('script'); js.id = id; js.async = true;
						js.src = "//connect.facebook.net/$fb_lang/all.js#xfbml=1";
						d.getElementsByTagName('head')[0].appendChild(js);
						}(document));</script>
					<div class="fb-comments" data-href="$item_route" data-num-posts="$comLimit" data-width="$width"></div>
					
					  					    


HTML;
					} else {$scriptPage .='';} break;

}

}
					
$scriptPage .= <<<HTML
                    </div></div>
HTML;
					
				}//end of standart			
			return $scriptPage;
		}

		return null;
	}


	public function edit() {
		return $this->app->html->_('select.booleanlist', $this->getControlName('value'), '', $this->get('value', $this->config->get('default')));
	}


	public function renderSubmission($params = array()) {
        return $this->edit();
	}


	public function validateSubmission($value, $params) {
		return array('value' => (bool) $value->get('value'));
	}
	
	/*public function bindData($data = array()) {
		$this->_item->name = @$data['value'];
	}*/
	
	
	
	public static function countcom($cntcom,$cntname){
		$commentsAPI = JPATH_SITE . '/components/com_jcomments/jcomments.php';
	 	if (is_file($commentsAPI)) {
	 		require_once($commentsAPI);
			$count = JComments::getCommentsCount($cntcom, $cntname);				
		}
		return $count;
	}

	public static function addtabtitle($showjcomments,$showvkontakte,$showfacebook,$orders,$cntcom,$cntname,$enabledshow,$lablename) {
		$scriptPage = '';
		$titlefc = $lablename->get('labelfc');
		$titlevk = $lablename->get('labelvk');
		$titlejc = $lablename->get('labeljc');
		$countercom = $enabledshow==1 ? '&nbsp;('.self::countcom($cntcom,$cntname).')' : '';
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
	
	
	public static function addtabtitlejq($showjcomments,$showvkontakte,$showfacebook,$orders,$cntcom,$cntname,$enabledshow,$lablename) {
		$j=1;$scriptPage = '';
		$titlefc = $lablename->get('labelfc');
		$titlevk = $lablename->get('labelvk');
		$titlejc = $lablename->get('labeljc');
		$countercom = $enabledshow==1 ? '&nbsp;('.self::countcom($cntcom,$cntname).')' : '';
        foreach ($orders as $order) {
			switch($order) {
				case 1:	if ($showjcomments) { $scriptPage .= <<<HTML
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


	

}