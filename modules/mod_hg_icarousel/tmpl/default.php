<?php

// no direct access
defined('_JEXEC') or die;

$slide = $params->get('slides');
$cacheFolder = JURI::base(true).'/cache/';
$modID = $module->id;
$modPath = JURI::base(true).'/modules/mod_hg_icarousel/';
$document = JFactory::getDocument(); 
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

?>

<div class="carousel-container">
	<div id="icarousel<?php echo $modID ?>" class="icarousel">

<?php
if($slide) {
	foreach($slide->vals as $k => $v) {
		
		$img = $slide->img[$k];
		if($params->get('resize_images',0))
		$img = JURI::base(true).'/cache/'.ModIcCarouselHelper::createThumb($img, 480, 360);
		$title = $slide->title[$k];
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		$pausetime = $slide->pausetime[$k];
		$html = array();
		
		$html[] = '<div class="slide" data-pausetime="'.$pausetime.'">';
		if($url) $html[] = '<a href="'.$url.'" target="'.$target.'">';
		$html[] = '  <img src="'.$img.'" width="480" height="360" />';
		if($title) $html[] = '  <h5><span>'.$title.'</span></h5>';
		if($url) $html[] = '</a>';
		$html[] = '</div>'."\n";
		
		echo implode("\n",$html);
	} // end foreach

	// add files
	$document->addStyleSheet($modPath.'assets/css/icarousel.css');
	$document->addStyleSheet($modPath.'assets/css/demo3.css');
	$document->addStyleDeclaration('.carousel-container {min-height:'.$params->get('container_height',440).'px;}');
	
	//$document->addScript($modPath.'assets/js/jquery.flexslider-min.js');
	
} else {
	echo 'Load the slides first!';	
}
?>
	</div>
</div>
<script type="text/javascript" src="<?php echo $modPath; ?>assets/js/raphael-min.js"></script>
<script type="text/javascript" src="<?php echo $modPath; ?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo $modPath; ?>assets/js/icarousel.packed.js"></script>
<script type="text/javascript">
(function($){
    jQuery(document).ready(function(){
		jQuery('#icarousel<?php echo $modID ?>').iCarousel({
			easing: '<?php echo $params->get('easing','easeInOutQuint'); ?>',
			slides: <?php echo (int)$params->get('slidesnr',7); ?>,
			animationSpeed: <?php echo (int)$params->get('animationSpeed',700); ?>,
			pauseTime: <?php echo (int)$params->get('pauseTime',5000); ?>,
			perspective: <?php echo (int)$params->get('perspective',75); ?>,
			slidesSpace: <?php echo (int)$params->get('slidesSpace',300); ?>,
			pauseOnHover: <?php echo ModIcCarouselHelper::returnBool($params->get('pauseOnHover','true')); ?>,
			direction: "ltr",
			timer: "<?php echo $params->get('timer','Bar'); ?>",
			timerOpacity: 0.4,
			timerDiameter: 220,
			keyboardNav: <?php echo ModIcCarouselHelper::returnBool($params->get('keyboardNav','true')); ?>,
			mouseWheel: <?php echo ModIcCarouselHelper::returnBool($params->get('mouseWheel','true')); ?>,
			touchNav: <?php echo ModIcCarouselHelper::returnBool($params->get('touchNav','true')); ?>,
			timerPadding: 3,
			timerStroke: 4,
			timerBarStroke: 0,
			timerColor: "#FFF",
			timerPosition: "<?php echo $params->get('timerPosition','bottom-center'); ?>",
			timerX: 15,
			timerY: 30,
			make3D: <?php echo ModIcCarouselHelper::returnBool($params->get('make3D','true')); ?>,
			directionNav: <?php echo ModIcCarouselHelper::returnBool($params->get('directionNav','true')); ?>,
			autoPlay: <?php echo ModIcCarouselHelper::returnBool($params->get('autoPlay','true')); ?>,
			randomStart: <?php echo ModIcCarouselHelper::returnBool($params->get('randomStart','false')); ?>,
			startSlide: <?php echo (int)$params->get('startSlide',0); ?>
		});
	});
})(jQuery);
</script>
<!-- End Flex Slider code -->

