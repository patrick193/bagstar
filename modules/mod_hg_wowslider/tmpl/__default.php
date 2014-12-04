<?php

// no direct access
defined('_JEXEC') or die;

$slide = $params->get('slides');
$cacheFolder = JURI::base(true).'/cache/';
$modID = $module->id;
$modPath = JURI::base(true).'/modules/mod_wowslider/';
$document = JFactory::getDocument(); 
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$shadows = $params->get('shadows');
$effect = $params->get('effect','fly');
$bullets = $params->get('bullets','true');
?>
<div class="container">

<div id="wowslider-container<?php echo $modID; ?>" class="<?php echo ($shadows ? 'drop-shadow '.$shadows :'' );?>">
	<div class="ws_images">
		<ul>
<?php
if($slide) {
	foreach($slide->vals as $k => $v) {
		
		$img = $slide->img[$k];
		$title = $slide->title[$k];
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		$html = array();
		
		$html[] = '<li >';
		if($url) $html[] = '<a href="'.$url.'" target="'.$target.'" class="link">';
		$html[] = '<img src="'.$img.'" title="'.trim($title).'" alt="" id="wows1_'.$k.'" />';
		if($url) $html[] = '</a>';
		$html[] = '</li>'."\n";
		echo implode("\n",$html);
		
	} // end foreach
?>
		</ul>
	</div><!-- end ws_images -->
	
	<?php if($bullets): ?>
	<div class="ws_bullets">
		<div>
<?php 
	foreach($slide->vals as $k => $v) {
		$thumb = JURI::base(true).'/cache/'.ModWowSliderHelper::createThumb($slide->img[$k], 150, 60);
		echo '<a href="#" title="slide'.$k.'" ><img src="'.$thumb.'" />'.$k.'</a>'."\n";
	} // end foreach
?>
		</div>
	</div><!-- end ws-bullets -->
	<?php endif; ?>
</div><!-- end #wow slider -->
					
<script type="text/javascript">
jQuery(window).load(function(){
	jQuery("#wowslider-container<?php echo $modID; ?>").wowSlider({
		effect:"<?php echo $effect; ?>",
		duration:<?php echo $params->get('duration',900); ?>,
		delay:<?php echo $params->get('delay',2000); ?>,
		width:<?php echo $params->get('width',1170); ?>,
		height:<?php echo $params->get('height',465); ?>,
		cols:<?php echo $params->get('cols',6); ?>,
		autoPlay:<?php echo ModWowSliderHelper::returnBool($params->get('autoPlay',1)); ?>,
		stopOnHover:<?php echo ModWowSliderHelper::returnBool($params->get('stopOnHover',1)); ?>,
		loop:<?php echo ModWowSliderHelper::returnBool($params->get('loop',1)); ?>,
		bullets:<?php echo ModWowSliderHelper::returnBool($params->get('bullets',1)); ?>,
		caption:<?php echo ModWowSliderHelper::returnBool($params->get('caption',1)); ?>,
		controls:<?php echo ModWowSliderHelper::returnBool($params->get('controls',1)); ?>,
		captionEffect:"slide",
		logo:"<?php echo $modPath.'assets/'; ?>image/loading_light.gif",
		images:0
	});
});
</script>
<!-- End WOW Slider code -->
<?php
	// add files
	$document->addStyleSheet($modPath.'assets/css/style.css');
	if($shadows) $document->addStyleSheet($modPath.'assets/css/shadows.css');
	$document->addScript($modPath.'assets/js/wowslider.js');
	$document->addScript($modPath.'assets/js/'.$effect.'.js');
	
} else {
	echo 'Load the slides first!';	
}
?>
</div>