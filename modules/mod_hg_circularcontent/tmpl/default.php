<?php

// no direct access
defined('_JEXEC') or die;

$slide = $params->get('slides');
$modID = $module->id;
$modPath = JURI::base(true).'/modules/mod_hg_circularcontent/';
$document = JFactory::getDocument(); 
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$mouseWheel = $params->get('enablemouse',1);
?>
<div class="container">
	<div id="ca-container<?php echo $modID; ?>" class="ca-container">
		<div class="ca-wrapper">

<?php

if($slide) {
	foreach($slide->vals as $k => $v) {
		
		$img = $slide->img[$k];
		$title = $slide->title[$k];
		$price = $slide->price[$k];
		$article = $slide->article[$k];
		$color = $slide->color[$k];
		$arrow = $slide->arrow[$k];
		$position = $slide->position[$k];
		$size = $slide->size[$k];
		$desc = $slide->desc[$k];

		$html = array();
		$tab = '  ';
		$html[] = '<div class="ca-item ca-item-'.($k+1).'">';
		$html[] = '  <div class="ca-item-main">';
		$html[] = '     <div class="background" style="background-color:'.$params->get('bgcolor','#ffffff').';"></div>';
		$html[] = '     <div class="ca-icon">';
        $html[] = '     	<img src="'.$img.'" alt="'.$title.'">';
		$html[] = '     </div>';
		$html[] = '     <h3>'.$title.'</h3>';
		$html[] = '     <h4>'.$desc.'</h4>';
		if($article)
		$html[] = '     <a href="#" class="ca-more">'.$params->get('morelabel').' <span class="icon-chevron-right icon-white"></span></a>';
		if($price)
		$html[] = '     <span class="ca-starting">'.$price.'</span>';
		$html[] = '  </div>';
		if($article) {
		$html[] = '  <div class="ca-content-wrapper">';
		$html[] = '    <div class="ca-content">';
		$html[] = '      <a href="#" class="ca-close"><span class="icon-remove"></span></a>';
		$articleContent = ModCircularContentSliderHelper::getArticle($article);
		$html[] = '      <h6>'.$articleContent[0]->title.'</h6>';
		$html[] = '      <div class="ca-content-text">'.ModCircularContentSliderHelper::prepare($articleContent[0]->text).'</div>';
		$html[] = '    </div>';
		$html[] = '  </div>';
		}
		$html[] = '</div>'."\n";
		
		$document->addStyleDeclaration('.ca-item-'.($k+1).' .title_circle:before {background: '.$color.';}');
		
		echo implode("\n",$html);
	} // end foreach
?>
		</div><!-- end ca-wrapper -->
	</div><!-- end circular content carousel -->
</div>

<!-- Start Circular Content Carousel code -->
<?php if($mouseWheel):?><script type="text/javascript" src="<?php echo $modPath; ?>assets/js/jquery.mousewheel.js"></script><?php endif; ?>
<script type="text/javascript" src="<?php echo $modPath; ?>assets/js/jquery.swipe.js"></script>
<script type="text/javascript" src="<?php echo $modPath; ?>assets/js/jquery.contentcarousel.js"></script>
<script type="text/javascript">
	jQuery('#ca-container<?php echo $modID; ?>').contentcarousel({mouseWheel:<?php echo ($mouseWheel ? 'true':'false'); ?>});
	jQuery(window).load(function(){
		setTimeout(function() {
			jQuery('#ca-container<?php echo $modID; ?> .ca-icon').css('backgroundImage', 'none');
		}, 1000);
	});
</script>
<!-- End Circular Content Carousel code -->
<?php
	// add files
	$document->addStyleSheet($modPath.'assets/css/circular_content_carousel.css');
	if($arrows) $document->addStyleDeclaration('.ca-container .ca-nav {display:none;}');
} else {
	echo 'Load the slides first!';	
}

