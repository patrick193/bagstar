<?php

// no direct access
defined('_JEXEC') or die;

$slide = $params->get('slides');
$cacheFolder = JURI::base(true).'/cache/';
$modID = $module->id;
$modPath = JURI::base(true).'/modules/mod_hg_cute3dslider/';
$document = JFactory::getDocument(); 
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
?>
<div class="container">
	<div id="slide-wrapper" class="slide-wrapper" >
		<div id="my-cute-slider<?php echo $modID; ?>" class="cute-slider" data-width="<?php echo $params->get('width',1170); ?>" data-height="<?php echo $params->get('height',465); ?>" data-usethumb="<?php echo $params->get('thumbs',1) ? 'true':'false'; ?>" data-shuffle="<?php echo $params->get('randomize',0) ? 'true':'false'; ?>" data-overpause="<?php echo $params->get('pauseonhover',1) ? 'true':'false'; ?>">
			<ul data-type="slides">
<?php
if($slide) {
	foreach($slide->vals as $k => $v) {

		$thumb = JURI::base(true).'/cache/'.ModCute3dSliderHelper::createThumb($slide->img[$k], 150, 60);
		$img = $slide->img[$k];
		$title = $slide->title[$k];
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		$trans3d = $slide->trans3d[$k];
		$trans2d = $slide->trans2d[$k];
		$capt_pos = $slide->capt_pos[$k];
		$capt_effect = $slide->capt_effect[$k];
		
		$html = array();
		
		$html[] = '<li data-delay="'.$params->get('delay',4).'" data-trans3d="'.$trans3d.'" data-trans2d="'.$trans2d.'">';
		$html[] = '<img '.($k != 0 ? 'src="'.$modPath.'assets/cute-theme/blank.jpg" data-':'').'src="'.$img.'" data-thumb="'.$thumb.'"/>';
		if($url) $html[] = '<a data-type="link" href="'.$url.'" target="'.$target.'" > </a>';
		if($title) {
			$html[] = '<ul data-type="captions">';
			$html[] = '<li class="caption'.$capt_pos.'" data-effect="'.$capt_effect.'">'.$title.'</li>';
			$html[] = '</ul>';
		}
		$html[] = '</li>'."\n";
		echo implode("\n",$html);
	} // end foreach
?>
			</ul><!-- end slides -->
			<ul data-type="controls">			
				<li data-type="captions"> </li>
				<li data-type="link"> </li>
				<li data-type="video"> </li>
				<li data-type="slideinfo"> </li>
				<?php if($params->get('circletimer',1)): ?>
				<li data-type="circletimer"> </li>
				<?php endif; ?>
				<?php if($params->get('arrows',1)): ?>
				<li data-type="next"> </li>
				<li data-type="previous"> </li>
				<?php endif; ?>
				<?php if($params->get('slidecontrol',1)): ?>
				<li data-type="slidecontrol"> </li>
				<?php endif; ?>
				<?php if($params->get('bartimer',1)): ?>
				<li data-type="bartimer"> </li>
				<?php endif; ?>		
			</ul><!-- end controls -->
		</div><!-- end my cute slider -->
		<?php if($params->get('shadow',1)): ?><div class="br-shadow"><img src="<?php echo $modPath; ?>assets/cute-theme/shadow.png"></div><?php endif; ?>
	</div><!-- end slide wrapper -->
</div>
<script>
	var myslider = new Cute.Slider();
	myslider.setup("my-cute-slider<?php echo $modID; ?>" , "slide-wrapper");
</script>
<?php
// add files
	$document->addStyleSheet($modPath.'assets/css/slider-style.css');
	$document->addScript($modPath.'assets/js/cute/cute.slider.js.php?u='.urlencode(JURI::base().'modules/mod_hg_cute3dslider/assets/js/'));
	$document->addScript($modPath.'assets/js/cute/cute.transitions.all.js');
	$document->addScript($modPath.'assets/js/respond.min.js');
	$document->addStyleDeclaration('.slide-wrapper{	max-width:'.$params->get('width',1170).'px; min-width:300px; }');
} else {
	echo 'Load the slides first!';	
}
?>

