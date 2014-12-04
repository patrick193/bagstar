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

$controlNav = $params->get('controlNav','true');
if($controlNav == 'thumbnails') $controlNavVal = "'thumbnails'"; else $controlNavVal = $controlNav;
?>
<div class="container">
<div class="flexslider <?php echo ($shadows ? 'drop-shadow '.$shadows :'' ).$showOnMouseover;?>" id="flexslider<?php echo $modID; ?>">
	<ul class="slides">
<?php
if($slide) {
	foreach($slide->vals as $k => $v) {
		
		$thumb = JURI::base(true).'/cache/'.ModFlexSliderHelper::createThumb($slide->img[$k], 150, 60);
		$img = $slide->img[$k];
		$title = $slide->title[$k];
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		$html = array();
		
		$html[] = '<li '.($controlNav == 'thumbnails' ? 'data-thumb="'.$thumb.'"':'').'>';
		if($url) $html[] = '<a href="'.$url.'" target="'.$target.'" class="link">';
		$html[] = '<img src="'.$img.'" alt="'.trim($title).'" />';
		if($url) $html[] = '</a>';
		if($title) $html[] = '<h2 class="flex-caption">'.$title.'</h2>';
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
        $("#flexslider<?php echo $modID; ?>").flexslider({
            animation: "<?php echo $params->get('animation','fade'); ?>",
            slideDirection: "<?php echo $params->get('slideDirection','horizontal'); ?>",
            slideshow: <?php echo ModFlexSliderHelper::returnBool($params->get('slideshow',1)); ?>,
            slideshowSpeed: <?php echo $params->get('slideshowSpeed',7000); ?>,
            animationDuration: <?php echo $params->get('animationDuration',600); ?>,
            directionNav: <?php echo ModFlexSliderHelper::returnBool($params->get('directionNav',1)); ?>,
            controlNav: <?php echo $controlNavVal; ?>,
            keyboardNav: <?php echo ModFlexSliderHelper::returnBool($params->get('keyboardNav',1)); ?>,
            mousewheel: <?php echo ModFlexSliderHelper::returnBool($params->get('mousewheel',0)); ?>,
			smoothHeight: true,
            randomize: <?php echo ModFlexSliderHelper::returnBool($params->get('randomize',0)); ?>,
            slideToStart: <?php echo $params->get('slideToStart',0); ?>,
            animationLoop: <?php echo ModFlexSliderHelper::returnBool($params->get('animationLoop',1)); ?>,
            pauseOnAction: true,
            pauseOnHover: <?php echo ModFlexSliderHelper::returnBool($params->get('pauseOnHover',0)); ?>,
			start: slideComplete,
			after: slideComplete
        });
		function slideComplete(args) {
			var caption = $(args.container).find('.flex-caption').attr('style', ''),
				thisCaption = $('.flexslider .slides > li.flex-active-slide').find('.flex-caption');
			thisCaption.animate({left:20, opacity:1}, 500, 'easeOutQuint');
		}
    })
})(jQuery);
</script>
<!-- End Flex Slider code -->
<?php
// add files
	$document->addStyleSheet($modPath.'assets/css/flexslider.css');
	if($shadows) $document->addStyleSheet($modPath.'assets/css/shadows.css');
	$document->addScript($modPath.'assets/js/jquery.flexslider-min.js');
	
} else {
	echo 'Load the slides first!';	
}
?>

