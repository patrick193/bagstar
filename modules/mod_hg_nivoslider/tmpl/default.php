<?php

// no direct access
defined('_JEXEC') or die;

$slide = $params->get('slides');
$cacheFolder = JURI::base(true).'/cache/';
$modID = $module->id;
$modPath = JURI::base(true).'/modules/mod_hg_nivoslider/';
$document = JFactory::getDocument(); 
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$shadows = $params->get('shadows');
?>
<div class="container">

<div id="nivoslider<?php echo $modID; ?>" class="nivoContainer <?php echo ($shadows ? 'drop-shadow '.$shadows :'' );?>">
	<div class="nivoSlider">
<?php
if($slide) {
	foreach($slide->vals as $k => $v) {
		
		$thumb = $controlNavThumbs ? JURI::base(true).'/cache/'.ModNivoSliderHelper::createThumb($slide->img[$k], 150, 60):'';
		$img = $slide->img[$k];
		$title = $slide->title[$k];
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		$html = array();
		
		//$html[] = '<li >';
		if($url) $html[] = '<a href="'.$url.'" target="'.$target.'" class="link">';
		$html[] = '<img src="'.$img.'" title="'.trim($title).'" '.($controlNavThumbs ? 'data-thumb="'.$thumb.'"':'').' />';
		if($url) $html[] = '</a>';
		//$html[] = '</li>'."\n";
		echo implode("\n",$html);
	} // end foreach
?>
	</div><!-- end #nivoslider -->
</div>
<script type="text/javascript">
(function($){
    $(window).load(function(){
		var slider = $('#nivoslider<?php echo $modID; ?> .nivoSlider');

		slider.nivoSlider({
			effect:'random',
			boxCols: <?php echo $params->get('boxCols',8); ?>,
			boxRows: <?php echo $params->get('boxRows',4); ?>,
			slices:<?php echo $params->get('slices',15); ?>,
			animSpeed:<?php echo $params->get('animSpeed',500); ?>,
			pauseTime:<?php echo $params->get('pauseTime',3000); ?>,
			startSlide:<?php echo $params->get('startSlide',0); ?>,
			directionNav:<?php echo ModNivoSliderHelper::returnBool($params->get('directionNav',1)); ?>,
			controlNav:<?php echo ModNivoSliderHelper::returnBool($params->get('controlNav',1)); ?>,
			controlNavThumbs:<?php echo ModNivoSliderHelper::returnBool($params->get('controlNavThumbs',0)); ?>,
			pauseOnHover:<?php echo ModNivoSliderHelper::returnBool($params->get('pauseOnHover',1)); ?>,
			manualAdvance:<?php echo ModNivoSliderHelper::returnBool($params->get('manualAdvance',1)); ?>,
			afterLoad: slideFirst,
			beforeChange: slideOut,
			afterChange: slideIn
		});
		function slideFirst() {
			var caption = slider.find('.nivo-caption');
			setTimeout(function(){
				caption.css('min-width',400).animate({left:20, opacity:1}, 500, 'easeOutQuint');
			}, 1000);
		}
		function slideIn() {
			slider.find('.nivo-caption').css('min-width','').animate({left:20, opacity:1}, 500, 'easeOutQuint');
		}
		function slideOut() {
			slider.find('.nivo-caption').css('min-width','').animate({left:120, opacity:0}, 500, 'easeOutQuint');
		}
    })
})(jQuery);
</script>
<!-- End Flex Slider code -->
<?php
	// add files
	$document->addStyleSheet($modPath.'assets/css/nivo-slider.css');
	if($shadows) $document->addStyleSheet($modPath.'assets/css/shadows.css');
	$document->addScript($modPath.'assets/js/jquery.nivo.slider.pack.js');
	
} else {
	echo 'Load the slides first!';	
}
?>
</div>