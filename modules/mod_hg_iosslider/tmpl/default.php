<?php

// no direct access
defined('_JEXEC') or die;

$slide = $params->get('slides');
$cacheFolder = JURI::base().'cache/';
$modID = $module->id;
$modPath = JURI::base().'modules/mod_hg_iosslider/';
$document = JFactory::getDocument(); 
$firstSlide = (int)$params->get('startAtSlide',1);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$bulletsType = $params->get('bulletsType','bullets');
$fixedWidth = $params->get('fixedWidth', 0);
$startFaded = $params->get('startFaded', 0);

if($slide) {
	
	$sliderClasses = array();
	$sliderClasses[] = $moduleclass_sfx;
	$sliderClasses[] = $startFaded ? 'faded':'';
	$sliderClasses[] = $fixedWidth ? 'fixed':'';
?>

<?php if($fixedWidth): ?>
	<div class="fluidHeight">
	<div class="sliderContainer ">
<?php endif; ?>

<div class="iosSlider <?php echo implode(' ',$sliderClasses); ?>" id="iosslider<?php echo $modID; ?>">
	<div class="slider">
<?php

	foreach($slide->vals as $k => $v) {
		
		//$thumb = ModIosSlider::useJImage($slide->img[$k], 60, 60);
		$img = $slide->img[$k];
		$maintitle = $slide->title[$k];
		$bigtitle = $slide->bigtitle[$k];
		$smalltitle = $slide->smalltitle[$k];
		//print_r($slide->url[$k]);
		
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		
		$style = $slide->captionstyle[$k];
?>
<div class="item">
	<?php if($img): ?>
		<img src="<?php echo $img; ?>" alt="<?php echo $maintitle; ?>" />
	<?php endif; ?>
	
	<?php if($maintitle or $bigtitle or $smalltitle): ?>
	<div class="caption <?php echo $style; ?> <?php echo $slide->captionposition[$k]; ?>">
		<?php if($maintitle): ?>
			<h2 class="main_title"><?php echo $maintitle; ?></h2>
		<?php endif; ?>
		<?php if($style == 'style3') {
			// style3
			?>
			<?php if($smalltitle): ?>
				<h4 class="title_small"><?php echo $smalltitle; ?></h4>
			<?php endif; ?>
			<?php if($bigtitle): ?>
				<h3 class="title_big"><?php echo $bigtitle; ?></h3>
			<?php endif; ?>
		<?php } else {
			// normal template
			?>
			<?php if($bigtitle): ?>
				<h3 class="title_big"><?php echo $bigtitle; ?></h3>
			<?php endif; ?>
			<?php if($url): ?>
				<a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="more">
					<img src="<?php echo $modPath; ?>assets/images/arr01.png" alt="<?php echo htmlspecialchars($bigtitle, ENT_COMPAT, 'UTF-8'); ?>">
				</a>
			<?php endif; ?>
			<?php if($smalltitle): ?>
				<h4 class="title_small"><?php echo $smalltitle; ?></h4>
			<?php endif; ?>
		<?php } ?>
	</div>
	<?php endif; ?>
</div><!-- end item -->
<?php
	} // end foreach
?>

	</div><!-- end slider -->

	<div class="prev">
		<div class="btn-label"><?php echo $params->get('prevlabel','PREV'); ?></div>
	</div>
	<div class="next">
		<div class="btn-label"><?php echo $params->get('nextlabel','NEXT'); ?></div>
	</div>
	
	<?php if($params->get('hideBullets','false') == 'false'): ?>
	<div class="selectorsBlock <?php echo $bulletsType; ?>">
		<?php echo ($bulletsType == 'thumbs'? '<a href="#" class="thumbTrayButton"><span class="icon-minus icon-white"></span></a>':''); ?>
		<div class="selectors">
	<?php
	foreach($slide->vals as $k => $v) {
		echo '<div class="item '.(($k+1) == $firstSlide ? ' first selected':'').'">'.($bulletsType == 'thumbs'? '<img src="'.JURI::base(true).'/cache/'.ModIosSlider::createThumb($slide->img[$k], 150, 60).'">' : '').'</div>';
	}
	?>
		</div>
	</div>
	<?php endif; ?>
	
</div><!-- end iosSlider -->
<div class="scrollbarContainer"></div>
<?php if($fixedWidth): ?>
	</div>
	</div>
<?php endif; ?>
<script type="text/javascript">
;(function($){
	$(document).ready(function() {

		$('#iosslider<?php echo $modID; ?>').iosSlider({
			desktopClickDrag: <?php echo $params->get('desktopClickDrag', 'true')."\n";?>
			, keyboardControls: <?php echo $params->get('keyboardControls', 'true')."\n";?>
			, navNextSelector: $('.next')
			, navPrevSelector: $('.prev')
			, navSlideSelector: $('.selectors .item')
			, scrollbar: <?php echo $params->get('scrollbar', 'true')."\n";?>
			, scrollbarContainer: '#slideshow .scrollbarContainer'
			, scrollbarMargin: '0'
			, scrollbarBorderRadius: '4px'
			, onSlideComplete: slideComplete
			, onSliderLoaded: function(args){
				var otherSettings = {
					hideControls : <?php echo $params->get('hideControls', 'true')."\n";?>
					, hideCaptions : <?php echo $params->get('hideCaptions', 'false')."\n";?>
				}
				sliderLoaded(args, otherSettings);
			}
			, startAtSlide: <?php echo $firstSlide."\n";?>
			, onSlideChange: slideChange
			, infiniteSlider: <?php echo $params->get('infiniteSlider', 'true')."\n";?>
			, autoSlide: <?php echo $params->get('autoSlide', 'true')."\n";?>
			, autoSlideTimer: <?php echo $params->get('autoSlideTimer', 5000)."\n";?>
			, autoSlideTransTimer: <?php echo $params->get('autoSlideTransTimer', 750)."\n";?>
			, snapToChildren: <?php echo $params->get('snapToChildren', 'true')."\n";?>
			, snapSlideCenter: <?php echo $params->get('snapSlideCenter', 'false')."\n";?>
			, elasticPullResistance: <?php echo $params->get('elasticPullResistance', 0.6)."\n";?>
			, frictionCoefficient: <?php echo $params->get('frictionCoefficient', 0.92)."\n";?>
			, elasticFrictionCoefficient: <?php echo $params->get('elasticFrictionCoefficient', 0.6)."\n";?>
			, snapFrictionCoefficient: <?php echo $params->get('snapFrictionCoefficient', 0.92)."\n";?>
		});
		
	}); // end doc ready
})(jQuery);
</script>
<?php
// add files
	$document->addStyleSheet($modPath.'assets/css/style.css');  
	$document->addScript($modPath.'assets/js/jquery.iosslider.min.js');
	$document->addScript($modPath.'assets/js/jquery.iosslider.kalypso.js');
	
	$proportion = ModIosSlider::getProportion($slide->img[$firstSlide-1]);
	$css = '';
	if(!$fixedWidth) 
		$css .= '#slideshow {padding-bottom: '.$proportion.'%;}';
	else
		$css .= '#slideshow {padding-bottom: 0; height:auto;}';	
	$css .= 'iosslider'.$modID.' .iosSlider {height: '.(int)$params->get('maxheight',800).'px; }';
	
	$css .= '#slideshow + .slideshow_back {padding-bottom: '.$proportion.'%;}';
	
	$document->addStyleDeclaration($css);
	
} else {
	echo 'Load the slides first!';	
}
?>

