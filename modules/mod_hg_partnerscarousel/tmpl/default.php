<?php

// no direct access
defined('_JEXEC') or die;

$items = $params->get('items');
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
$mid = $module->id;
$document = JFactory::getDocument(); 

$title = $params->get('mod_title');
$controls = $params->get('controls');
$carSize = $parentGrid-(($controls or $title) ? 2 : 0);
?>
<div class="row partners_carousel <?php echo $moduleclass_sfx; ?> partners_carousel<?php echo $mid; ?>">

	<?php if($controls or $title): ?>
	<div class="span2">
		<?php echo (($title) ? '<h5 class="title"><span>'.$title.'</span></h5>':''); ?>
		<?php if($controls): ?>
		<div class="controls">
			<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
			<a href="#" class="next"><span class="icon-chevron-right"></span></a>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	
	<div class="span<?php echo $carSize; ?>">
		<ul id="partners_carousel<?php echo $mid; ?>" class="fixclear">
<?php
if($items) {
	foreach($items->vals as $k => $v):
	
		$img = $items->img[$k];
		$url = $items->linkurl->link[$k];
		$target = $items->linkurl->target[$k];
		
		$output = '<li>';
		if($url) $output .= '<a href="'.$url.'" target="'.$target.'">';
		else $output .= '<span>';
		$output .= '<img src="'.$img.'" alt="" />';
		if($url) $output .= '</a>';
		else $output .= '</span>';
		$output .= '</li>'."\n";

		echo $output;
	
	endforeach;
} else {
	echo 'Load some Portfolio items first!';	
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
$document->addScript('modules/mod_hg_partnerscarousel/assets/jquery.carouFredSel.js');

$js = '
<script type="text/javascript">
;(function($) {
	$(window).load(function(){
		$("#partners_carousel'.$mid.'").carouFredSel({
			responsive: true,
			scroll: '.$params->get('items_scroll',1).',
			auto: '.($params->get('autoplay',0) ? 'true':'false').',
			items: {
				width: '.$params->get('items_width',250).',
				visible: {
					min: '.$params->get('items_min',3).',
					max: '.$params->get('items_max',10).'
				}
			},
			prev	: {	
				button	: ".partners_carousel'.$mid.' .prev",
				key		: "left"
			},
			next	: { 
				button	: ".partners_carousel'.$mid.' .next",
				key		: "right"
			}
		});
	});
})(jQuery);
</script>';
//$document->addScriptDeclaration($js);
echo $js;
?>