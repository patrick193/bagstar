<?php

// no direct access
defined('_JEXEC') or die;

$slide = $params->get('slides');
$cacheFolder = JURI::base(true).'/cache/';
$modID = $module->id;
$modPath = JURI::base(true).'/modules/mod_hg_flexslider/';
$document = JFactory::getDocument(); 
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$shadows = $params->get('shadows');
$showOnMouseover = $params->get('showOnMouseover') ? ' showOnMouseover':'';

?>
<div class="container">
<div class="flexslider <?php echo $showOnMouseover;?>" id="flexslider<?php echo $modID; ?>">
	<ul class="slides">
<?php
if($slide) {
	foreach($slide->vals as $k => $v) {
		
		//$thumb = JURI::base(true).'/cache/'.ModFlexSliderHelper::createThumb($slide->img[$k], 150, 60);
		$img = $slide->img[$k];
		$title = $slide->title[$k];
		$color = $slide->color[$k];
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		$html = array();
		
		$html[] = '<li data-color="'.$color.'">';
		if($url) $html[] = '<a href="'.$url.'" target="'.$target.'" class="link">';
		$html[] = '<img src="'.$img.'" alt="'.trim($title).'" />';
		if($url) $html[] = '</a>';
		$html[] = '</li>'."\n";
		echo implode("\n",$html);
	} // end foreach
?>
	</ul>
</div><!-- end #flexslider -->
</div>
<script type="text/javascript">
(function($){
    $(window).load(function(){
		
		function slideComplete(args) {
			//console.log(args);
			var _arg = $(args),
				slideshow =  _arg.closest('#slideshow'),
				color = $(args.slides).eq(args.animatingTo).attr('data-color');
			if( _arg.css('background-image') != 'none')  _arg.css('background-image', 'none');
			
			slideshow.animate({backgroundColor: color}, 400);
			//slideshow.css({'background-color': color});
		}
		
        $("#flexslider<?php echo $modID; ?>").flexslider({
            animation: "<?php echo $params->get('animation','slide'); ?>",
            slideDirection: "<?php echo $params->get('slideDirection','vertical'); ?>",
            slideshow: <?php echo ModFlexSliderHelper::returnBool($params->get('slideshow',1)); ?>,
            slideshowSpeed: <?php echo $params->get('slideshowSpeed',7000); ?>,
            animationDuration: <?php echo $params->get('animationDuration',600); ?>,
            directionNav: <?php echo ModFlexSliderHelper::returnBool($params->get('directionNav',1)); ?>,
            controlNav: false,
            keyboardNav: <?php echo ModFlexSliderHelper::returnBool($params->get('keyboardNav',1)); ?>,
            mousewheel: <?php echo ModFlexSliderHelper::returnBool($params->get('mousewheel',0)); ?>,
			smoothHeight: true,
            randomize: <?php echo ModFlexSliderHelper::returnBool($params->get('randomize',0)); ?>,
            slideToStart: <?php echo $params->get('slideToStart',0); ?>,
            animationLoop: <?php echo ModFlexSliderHelper::returnBool($params->get('animationLoop',1)); ?>,
            pauseOnAction: true,
            pauseOnHover: <?php echo ModFlexSliderHelper::returnBool($params->get('pauseOnHover',0)); ?>,
			start: slideComplete,
			before: slideComplete
        });
		
    })
})(jQuery);
</script>
<!-- End Flex Slider code -->
<?php
// add files
	$document->addStyleSheet($modPath.'assets/css/flexslider.css');
	$document->addStyleSheet($modPath.'assets/css/flexslider-fancy.css');
	$document->addScript($modPath.'assets/js/jquery.flexslider-min.js');
	$document->addScript($modPath.'assets/js/jquery.animate-colors-min.js');
	//$document->addScript($modPath.'assets/js/jquery.animate-colors.js');
	$document->addStyleDeclaration('#page_wrapper #slideshow {background-color:'.$slide->color[0].'}');
	
} else {
	echo 'Load the slides first!';	
}
?>

