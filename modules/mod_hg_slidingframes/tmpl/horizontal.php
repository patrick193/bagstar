<?php

// no direct access
defined('_JEXEC') or die;
$mid = $module->id;
$doc =& JFactory::getDocument();

$slide = $params->get('slides');
$base = JURI::base(true);
$document = JFactory::getDocument(); 
$mod_path = $base."/modules/mod_hg_slidingframes";

$modtitle = $params->get('modtitle');
$arrows = $params->get('arrows',1);
$arrows = $params->get('animating_frames',1);

?>
<div class="portfolio-slider-frames horizontal-mode">
		
		<?php echo $modtitle ? '<h3 class="centered">'.$modtitle.'</h3>':''; ?>
		<div id="carousel-wrapper">
			<div id="slframes<?php echo $mid; ?>" class="slframes<?php echo $mid; ?> slframes_carousel">
			
<?php
if($slide) {
	
	foreach($slide->vals as $k => $v) {
		
		$img1 = $slide->image1[$k];
		$img2 = $slide->image2[$k];
		$img3 = $slide->image3[$k];
		if($params->get('resize_images',0)):
			$img1 = JURI::base(true).'/cache/'.modSlidingFramesHelper::createThumb($img1, 460, 320);
			$img2 = JURI::base(true).'/cache/'.modSlidingFramesHelper::createThumb($img2, 460, 320);
			$img3 = JURI::base(true).'/cache/'.modSlidingFramesHelper::createThumb($img3, 460, 320);
		endif;
		$title = $slide->title[$k];
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		$html = array();
		
		$html[] = '<div>';
		$html[] = '  <div class="img-front">';
		if($title) $html[] = '    <span class="project_title">'.$title.'</span>';
		if($url) $html[] = '    <a href="'.$url.'" class="project_url" target="'.$target.'">'.$url.'</a>';
		$html[] = '    <img src="'.$img1.'" alt="" width="460" height="320" />';
		$html[] = '  </div>';
		$html[] = '  <img class="img-back" src="'.$img2.'" alt="" width="460" height="320" />';
		$html[] = '  <img class="img-back2" src="'.$img3.'" alt="" width="460" height="320" />';
		$html[] = '</div>'."\n";
		
		echo implode("\n",$html);
	} // end foreach

	$document->addStyleSheet($mod_path.'/assets/css/caroufredsel.css');
	
	//Add js
	$checkcarouFredSel = false;
	$header = $document->getHeadData();
	foreach($header['scripts'] as $scriptName => $scriptData){
		if(substr_count($scriptName,'/jquery.carouFredSel'))
			$checkcarouFredSel = true;
	}	
	if(!$checkcarouFredSel) 
	$document->addScript($mod_path.'/assets/js/jquery.carouFredSel-6.0.4-packed.js');
	
} else {
	echo 'Load the slides first!';	
}
?>
</div>
			<?php if($arrows): ?>
			<a id="slfcarousel_prev" href="#"><span class="icon-chevron-left icon-white"></span></a>
			<a id="slfcarousel_next" href="#"><span class="icon-chevron-right icon-white"></span></a>
			<?php endif; ?>
		</div><!-- end Carousel wrapper -->
</div>

<script type="text/javascript">
(function($) {
	var left = {
		imgFront	: -1200,
		imgBack		: -1200,
		imgBack2	: -1200
	}
	var current = {
		imgFront	: 261,
		imgBack		: 470,
		imgBack2	: 60
	}
	var right = {
		imgFront	: 2200,
		imgBack		: 2200,
		imgBack2	: 2200
	}
			
	var isScrolling = false;

	$('#slframes<?php echo $mid; ?>').carouFredSel({
		scroll	: {
			duration		: 0,
			timeoutDuration	: <?php echo $params->get('timeoutDuration',3000); ?>
		},
		width: '100%',
		auto	: <?php echo $params->get('autoplay',0) ? 'true':'false';?>
		<?php if($arrows): ?>
		, prev	: {
			button		: '#slfcarousel_prev',
			conditions	: function() {
				return (!isScrolling);
			},
			onBefore	: function( data ) {
				isScrolling = true;
		
				$(this).delay(900);
		
				data.items.old.find('.img-front').delay(400).animate({left: right.imgFront});
				data.items.old.find('img.img-back').delay(300).animate({left: right.imgBack});
				data.items.old.find('img.img-back2').delay(200).animate({left: right.imgBack2});
			},
			onAfter: function( data ) {
				data.items.old.find('.img-front').css({left: current.imgFront});
				data.items.old.find('img.img-back').css({left: current.imgBack});
				data.items.old.find('img.img-back2').css({left: current.imgBack2});
				data.items.visible.find('.img-front').css({left: left.imgFront}).delay(400).animate({left: current.imgFront}, function() {
						isScrolling = false;
					});
				data.items.visible.find('img.img-back').css({left: left.imgBack}).delay(300).animate({left: current.imgBack});
				data.items.visible.find('img.img-back2').css({left: left.imgBack2}).delay(200).animate({left: current.imgBack2});
		
			}
		},
		next	: {
			button		: '#slfcarousel_next',
			conditions	: function() {
				return (!isScrolling);
			},
			onBefore	: function( data ) {
				isScrolling = true;
		
				$(this).delay(900);	//	delay the onafter
				data.items.old.find('.img-front').animate({left: left.imgFront});
				data.items.old.find('img.img-back').delay(100).animate({left: left.imgBack});
				data.items.old.find('img.img-back2').delay(200).animate({left: left.imgBack2});
			},
			onAfter: function( data ) {
				data.items.old.find('.img-front').css({left: current.imgFront});
				data.items.old.find('img.img-back').css({left: current.imgBack});
				data.items.old.find('img.img-back2').css({left: current.imgBack2});
				
				data.items.visible.find('.img-front').css({left: right.imgFront}).animate({left: current.imgFront});
				data.items.visible.find('img.img-back').css({left: right.imgBack}).delay(100).animate({left: current.imgBack});
				data.items.visible.find('img.img-back2').css({left: right.imgBack2}).delay(200).animate({left: current.imgBack2}, function() {
					isScrolling = false;
				}); 
			}
		}
		<?php endif; ?>
	});
})(jQuery);
</script>