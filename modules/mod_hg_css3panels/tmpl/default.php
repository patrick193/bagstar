<?php

// no direct access
defined('_JEXEC') or die;

$slide = $params->get('slides');
$cacheFolder = JURI::base(true).'/cache/';
$modID = $module->id;
$modPath = JURI::base(true).'/modules/mod_hg_css3panels/';
$document = JFactory::getDocument(); 
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

?>

<div id="css3panels" class="cols-<?php echo count($slide->vals); ?>">
	<div id="loading"></div>

<?php
if($slide) {
	foreach($slide->vals as $k => $v) {
		
		$img = $slide->img[$k];
		$title = $slide->title[$k];
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		$capt_pos = $slide->capt_pos[$k]; 
		$html = array();
		
		
		$html[] = '<div class="panel panel'.($k+1).' '.(($k == 0) ? 'first':'').' '.(($k == (count($slide->vals)-1)) ? 'last':'').'">';
		$html[] = '  <div class="inner-panel">';
		$html[] = '    <img src="'.$img.'" alt="" class="main_image">';
		if($title):
		$html[] = '    <div class="caption '.$capt_pos.'">';
		$html[] = '      <h3 class="title">'.$title.'</h3>';
		$html[] = '    </div>';
		endif;
		$html[] = '  </div>';
		$html[] = '</div>'."\n";
		
		echo implode("\n",$html);
	} // end foreach

	// add files
	$document->addStyleSheet($modPath.'assets/css/css3panels.css');
	$document->addStyleDeclaration('#css3panels {height: '.$params->get('container_height',600).'px;}');
	
	$document->addScript($modPath.'assets/js/css3panels.js');
	
} else {
	echo 'Load the slides first!';	
}
?>
</div><!-- end panels -->
<div class="clear"></div>
