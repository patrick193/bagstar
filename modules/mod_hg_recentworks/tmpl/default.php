<?php

// no direct access
defined('_JEXEC') or die;

$items = $params->get('items');
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
$show_desc = $params->get('show_desc');
$style = $params->get('modstyle',1) == 1 ? 'default-style' : 'style2';
$ptfSize = ($show_desc ? $parentGrid - 3 : $parentGrid );
$mid = $module->id;
$document = JFactory::getDocument(); 

$controls ='
<div class="controls">
	<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
	'.($params->get('portfolio_link') ? '<a href="'.$params->get('portfolio_link').'" class="complete"><span class="icon-th"></span></a>' : '').'
	<a href="#" class="next"><span class="icon-chevron-right"></span></a>
</div>
';

?>
<div class="row recentwork_carousel <?php echo $style.' '.$moduleclass_sfx.''.($show_desc ? '' : ' noDesc'); ?> recentwork_carousel<?php echo $mid; ?>">
	
	
	<?php if ($show_desc) : ?>
	<div class="span3">
		<?php if ($params->get('mod_title')) echo '<h3 class="m_title">'.$params->get('mod_title').'</h3>'; ?>
		<?php if ($params->get('mod_desc')) echo '<p>'.$params->get('mod_desc').'</p>'; ?>
		<?php if($params->get('controls')) echo $controls; ?>
	</div>
	<?php endif; ?>
	
	<div class="span<?php echo $ptfSize; ?>">
		
		<?php if (!$show_desc) : ?>
			<?php if ($params->get('mod_title')) echo '<h3 class="m_title">'.$params->get('mod_title').'</h3>'; ?>
			<?php if($params->get('controls')) echo $controls; ?>
		<?php endif; ?>
		
		<ul id="recent_works<?php echo $mid; ?>" class="fixclear">
<?php
if($items) {
	foreach($items->vals as $k => $v) {
	
		$img = $items->img[$k];
		$title = $items->title[$k];
		$desc = $items->desc[$k];
		$url = $items->linkurl->link[$k];
		$target = $items->linkurl->target[$k];
		
		$output = '<li>';
			
		if($style == 'default-style') {
			
			if($url) $output .= '<a href="'.$url.'" target="'.$target.'">';
				if($img) $output .= '
				<span class="hover">
					<img src="'.$img.'" alt="'.$title.'">
					<span class="hov"></span>
				</span>';
				if($title or $desc) $output .= '<div class="details">
					<span class="bg"></span>';
					if($title) $output .= '<h4>'.$title.'</h4>';
					if($desc) $output .= '<span>'.$desc.'</span>';
				if($title or $desc) $output .= '</div>';
			if($url) $output .= '</a>';
			
		} else if($style == 'style2') {
			
			if($url) $output .= '<a href="'.$url.'" target="'.$target.'">';
				if($img) $output .= '<img src="'.$img.'" alt="'.$title.'">';
				if($title or $desc) $output .= '<div class="details">
					<span class="plus">+</span>';
					if($title) $output .= '<h4>'.$title.'</h4>';
					if($desc) $output .= '<span>'.$desc.'</span>';
				if($title or $desc) $output .= '</div>';
			if($url) $output .= '</a>';

		}
		$output .= '</li>';
	
		echo $output;
	
	}
} else {
	echo 'Load some Portfolio items first!';	
}

?>
		</ul>
	</div>
</div>
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
$document->addScript('modules/mod_hg_recentworks/assets/jquery.carouFredSel.js');

$js = '
<script type="text/javascript">
;(function($) {
	$(window).load(function(){
		$("#recent_works'.$mid.'").carouFredSel({
			responsive: true,
			scroll: '.$params->get('items_scroll',1).',
			auto: '.($params->get('autoplay',0) ? 'true':'false').',
			items: {
				width: '.$params->get('items_width',300).',
				visible: {
					min: '.$params->get('items_min',2).',
					max: '.$params->get('items_max',10).'
				}
			},
			prev	: {	
				button	: ".recentwork_carousel'.$mid.' .prev",
				key		: "left"
			},
			next	: { 
				button	: ".recentwork_carousel'.$mid.' .next",
				key		: "right"
			}
		});
	});
})(jQuery);
</script>';
//$document->addScriptDeclaration($js);
echo $js;
?>