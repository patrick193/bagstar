<?php

// no direct access
defined('_JEXEC') or die;
$doc =& JFactory::getDocument();
$boxes = $params->get('boxes');
$mod_title = $params->get('mod_title');
$doc->addStyleDeclaration('.shop-features .shop-feature:hover {background:'.$params->get('hover_color', '#cd2122').';}');


?>
<div class="row shop-features <?php echo $style; ?> <?php echo $moduleclass_sfx; ?>">
<?php
if($mod_title) echo '
<div class="span3">
	<h3 class="title">'.$mod_title.'</h3>
</div>';

if($boxes) {

	foreach($boxes->vals as $k => $v) {
	
		$img = $boxes->img[$k];
		$url = $boxes->linkurl->link[$k];
		$target = $boxes->linkurl->target[$k];
		$title = $boxes->title[$k];
		$subtitle = $boxes->subtitle[$k];
		$output = array();
		
		$output[] = '<div class="span3">';
			$output[] = '<div class="shop-feature">';
			if($url) $output[] = '<a href="'.$url.'" target="'.$target.'">';
			if($img) $output[] = '<img src="'.$img.'" alt="">';
			if($title) $output[] = '<h4>'.$title.'</h4>';
			if($subtitle) $output[] = '<h5>'.$subtitle.'</h5>';
			if($url) $output[] = '</a>';
			$output[] = '</div>';
		$output[] = '</div>';
		echo implode("\n", $output);
	}
} else {
	echo 'Load some boxes first!';	
}
?>	
</div>
