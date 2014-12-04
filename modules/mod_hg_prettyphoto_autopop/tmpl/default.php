<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$mid = $module->id;
$doc =& JFactory::getDocument();
$mod_path = "modules/mod_hg_prettyphoto_autopop/";
$script = '(function($){ $(window).load(function(){if($.fn.prettyPhoto != "undefined") { ';
switch($params->get('popup_type', 0)) {
	
	case"0":
		$script .= '$.prettyPhoto.open("'.$params->get('popup_url').'","'.$params->get('popup_title').'","'.$params->get('popup_description').'"); ';
	break;
	
	case"1":
	case"2":
	case"3":
	case"4":
		$script .= '$.prettyPhoto.open("'.$params->get('popup_url').'?iframe=true&amp;width='.$params->get('popup_width').'&amp;height='.$params->get('popup_height').'","'.$params->get('popup_title').'","'.$params->get('popup_description').'"); ';
	break;
	
	case"6":
		$script .= '$.prettyPhoto.open("'.$params->get('popup_url').'?width='.$params->get('popup_width').'&amp;height='.$params->get('popup_height').'","'.$params->get('popup_title').'","'.$params->get('popup_description').'"); ';
	break;
	
	case"5":
		$script .= '$.prettyPhoto.open("#'.$params->get('inline_content_id').'","'.$params->get('popup_title').'","'.$params->get('popup_description').'"); ';
		
		echo '<div id="'.$params->get('inline_content_id').'" class="hidePopup">'.$params->get('inline_content_value').'</div></div>';
	break;
	
}
if($params->get('popup_autohide')) {
	$script .= 'setTimeout(function() {$.prettyPhoto.close();}, '.$params->get('popup_timeout').');';	
}

$script .= '} else {console.log("PrettyPhoto is not defined.")} }); })(jQuery);';

$doc->addScriptDeclaration($script);

