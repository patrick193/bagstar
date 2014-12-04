<?php

// no direct access
defined('_JEXEC') or die;

$mid = $module->id;
$document = JFactory::getDocument(); 
$modpath = JURI::base(true).'/modules/mod_hg_staticcontent';
$items = $params->get('boxes_items');

?>
<div class="bg-wrapper-image" style="background: url(<?php echo $params->get('boxes_bg'); ?>) no-repeat center center; min-height:<?php echo $params->get('boxes_minheight',400); ?>px;">
	<div class="container">
		<div class="static-content boxes-style">
			<?php echo modStaticContentHelper::prepare($params->get('boxes_content')); ?>
			<div class="boxes row">
			
<?php
if($items) {
	foreach($items->vals as $k => $v) {
	
		$img = $items->icon[$k];
		$title = $items->title[$k];
		$desc = $items->boxtext[$k];
		$url = $items->linkurl->link[$k];
		$target = $items->linkurl->target[$k];
		
		$output = '<div class="span'.(12/count($items->vals)).'">';
		$output .= '<div class="info_pop">';
		$output .= '<h4 class="title">';
		if($url) $output .= '<a href="'.$url.'" target="'.$target.'">';
		if($img) $output .= '<img src="'.$img.'" alt="'.$title.'"/>';
		$output .= $title;
		if($url) $output .= '</a>';
		$output .= '</h4>';
		$output .= '<p>'.$desc.'</p>';
		$output .= '</div>';
		$output .= '</div>';
	
		echo $output;
	
	}
} else {
	echo 'Load some Portfolio items first!';	
}

?>
			</div><!-- end boxes -->
		</div>
	</div>
</div>