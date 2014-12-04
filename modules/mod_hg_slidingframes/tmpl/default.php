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
<div class="portfolio-slider-frames">
	<div class="container">
		
		<?php echo $modtitle ? '<h3 class="centered">'.$modtitle.'</h3>':''; ?>
		<div id="carousel-wrapper">
			<div id="slframes<?php echo $mid; ?>" class="slframes<?php echo $mid; ?> slframes_carousel <?php echo $params->get('animating_frames',1) ? 'animating_frames':''; ?>">
			
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
</div>

<script type="text/javascript">
(function($) {
	var left = {
			imgFront	: 365,
			imgBack		: 365,
			imgBack2	: 365
		},
		current = {
			imgFront	: 0,
			imgBack		: 80,
			imgBack2	: 50
		},
		right = {
			imgFront	: 365,
			imgBack		: 365,
			imgBack2	: 365
		},
		cSpeed = <?php echo $params->get('cSpeed',400); ?>,
		cEasing = 'easeOutExpo',
		isScrolling = false;

	$('#slframes<?php echo $mid; ?>').carouFredSel({
		scroll	: {
			duration		: 0,
			timeoutDuration	: <?php echo $params->get('timeoutDuration',3000); ?>
		},
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
				
				data.items.old.find('.img-front').delay(700).animate({top: right.imgFront}, cSpeed, cEasing);
				data.items.old.find('img.img-back').delay(500).animate({top: right.imgBack}, cSpeed, cEasing);
				data.items.old.find('img.img-back2').delay(300).animate({top: right.imgBack2}, cSpeed, cEasing);
			},
			onAfter: function( data ) {
				
				data.items.old.find('.img-front').css({top: current.imgFront});
				data.items.old.find('img.img-back').css({top: current.imgBack});
				data.items.old.find('img.img-back2').css({top: current.imgBack2});
				data.items.visible.find('.img-front').css({top: left.imgFront}).delay(700).animate({top: current.imgFront}, cSpeed, cEasing, function() {
					isScrolling = false;
				});
				data.items.visible.find('img.img-back').css({top: left.imgBack}).delay(500).animate({top: current.imgBack}, cSpeed, cEasing);
				data.items.visible.find('img.img-back2').css({top: left.imgBack2}).delay(300).animate({top: current.imgBack2}, cSpeed, cEasing);
				
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
				data.items.old.find('.img-front').animate({top: left.imgFront}, cSpeed, cEasing);
				data.items.old.find('img.img-back').delay(300).animate({top: left.imgBack}, cSpeed, cEasing);
				data.items.old.find('img.img-back2').delay(500).animate({top: left.imgBack2}, cSpeed, cEasing);
			},
			onAfter: function( data ) {
				data.items.old.find('.img-front').css({top: current.imgFront});
				data.items.old.find('img.img-back').css({top: current.imgBack});
				data.items.old.find('img.img-back2').css({top: current.imgBack2});
				
				data.items.visible.find('.img-front').css({top: right.imgFront}).animate({top: current.imgFront}, cSpeed, cEasing);
				data.items.visible.find('img.img-back').css({top: right.imgBack}).delay(200).animate({top: current.imgBack}, cSpeed, cEasing);
				data.items.visible.find('img.img-back2').css({top: right.imgBack2}).delay(300).animate({top: current.imgBack2}, cSpeed, cEasing, function() {
					isScrolling = false;
				});
			}
		}
		<?php endif; ?>
	});
	
	if($('#slframes<?php echo $mid; ?>').hasClass('animating_frames')) {
		var _tf = $('#slframes<?php echo $mid; ?> .img-front'),
			_tb = $('#slframes<?php echo $mid; ?> img.img-back'),
			_tbl = $('#slframes<?php echo $mid; ?> img.img-back2'),
			_spd = 250, 
			_eas = 'easeOutExpo';
			
		_tb.hover(function(){
			$(this).stop().animate({'margin-top':-40}, _spd, _eas);
			_tf.stop().animate({'margin-left':-90}, _spd, _eas);
			_tbl.stop().animate({'margin-left':-30}, _spd, _eas);
		},function(){
			$(this).stop().animate({'margin-top':0}, _spd, _eas);
			_tf.stop().animate({'margin-left':0}, _spd, _eas);
			_tbl.stop().animate({'margin-left':0}, _spd, _eas);
		});
		_tbl.hover(function(){
			$(this).stop().animate({'margin-top':-20}, _spd, _eas);
			_tf.stop().animate({'margin-left':90}, _spd, _eas);
			_tb.stop().animate({'margin-left':20}, _spd, _eas);
		},function(){
			$(this).stop().animate({'margin-top':0}, _spd, _eas);
			_tf.stop().animate({'margin-left':0}, _spd, _eas);
			_tb.stop().animate({'margin-left':0}, _spd, _eas);
		}); 
	} 

})(jQuery);
</script>