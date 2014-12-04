<?php

// no direct access
defined('_JEXEC') or die;

$items = $params->get('items');
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
$mid = $module->id;
$document = JFactory::getDocument(); 

$title = $params->get('mod_title');
$subtitle = $params->get('mod_subtitle');
$carSize = $parentGrid-(($controls or $title) ? 3 : 0);
?>
<div class="testimonials-carousel testimonials-carousel<?php echo $mid; ?> <?php echo $moduleclass_sfx; ?>">
	
	<?php if($title): ?>
		<h3 class="m_title"><?php echo $title; ?></h3>
	<?php endif; ?>
	<div class="controls">
		<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
		<a href="#" class="next"><span class="icon-chevron-right"></span></a>
	</div>
		

	<ul id="testimonials_carousel<?php echo $mid; ?>" class="fixclear">

<?php
if($items) {
	foreach($items->vals as $k => $v):
	
		$name = $items->name[$k];
		$position = $items->position[$k];
		$testimonial = $items->testimonial[$k];
		
		$output = '<li>';
	
		if($testimonial)
		$output .= '<blockquote>'.$testimonial.'</blockquote>';
		
		if($name or $position)
		$output .= '<h5>'.$name.($position ? ' // '.$position : '').'</h5>';
		
		$output .= '</li>'."\n";

		echo $output;
	
	endforeach;
} else {
	echo 'Load some testimonials first!';	
}

?>
	</ul>
</div><!-- testimonials carousel -->

<?php

$checkcarouFredSel = false;
$header = $document->getHeadData();
foreach($header['scripts'] as $scriptName => $scriptData)
{
	if(substr_count($scriptName,'/jquery.carouFredSel')){
		$checkcarouFredSel = true;
	}
}	
//Add js
if(!$checkcarouFredSel) 
$document->addScript('modules/mod_hg_testimonials_fader/assets/jquery.carouFredSel.js');

$js = '
<script type="text/javascript">
;(function($) {
	$(window).load(function(){
		
		$("#testimonials_carousel'.$mid.'").carouFredSel({
			responsive: true,
			items: {
				width: 300
			},
			scroll: { duration: "'.$params->get('duration',1500).'" },
			auto: {timeoutDuration: '.$params->get('timeoutDuration',5000).'},
			prev	: {	
				button	: ".testimonials-carousel'.$mid.' .prev",
				key		: "left"
			},
			next	: { 
				button	: ".testimonials-carousel'.$mid.' .next",
				key		: "right"
			}
		});
	});
})(jQuery);
</script>';
//$document->addScriptDeclaration($js);
echo $js;
?>
