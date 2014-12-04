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
<div class="row testimonials_fader <?php echo $moduleclass_sfx; ?>">

	<?php if($subtitle or $title): ?>
	<div class="span3">
	<?php if($title): ?>
		<h3 class="m_title"><?php echo $title; ?></h3>
	<?php endif; ?>
	
	<?php if($subtitle): ?>
		<p><?php echo $subtitle; ?></p>
	<?php endif; ?>
	</div>
	<?php endif; ?>
	
	
	
	<div class="span<?php echo $carSize; ?>">
		<ul id="testimonials_fader<?php echo $mid; ?>" class="fixclear">
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
		$output .= '<h6>'.$name.($position ? ' // '.$position : '').'</h6>';
		
		$output .= '</li>'."\n";

		echo $output;
	
	endforeach;
} else {
	echo 'Load some Testimonials first!';	
}

?>
		</ul>
	</div>
</div><!-- end row // partners carousel -->

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
		$("#testimonials_fader'.$mid.'").carouFredSel({
			responsive:true,
			auto: {timeoutDuration: '.$params->get('timeoutDuration',5000).'},
			scroll: { fx: "fade", duration: "'.$params->get('duration',1500).'" }
		});
	});
})(jQuery);
</script>';
//$document->addScriptDeclaration($js);
echo $js;
?>
