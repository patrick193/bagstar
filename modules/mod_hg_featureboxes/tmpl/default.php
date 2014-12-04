<?php

// no direct access
defined('_JEXEC') or die;
$doc =& JFactory::getDocument();
$cssBg ='';
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
$showDesc = $params->get('show_desc',0);
//$boxSize = round($parentGrid/$params->get('perrow',3), 0, PHP_ROUND_HALF_DOWN);
$boxSize = floor($parentGrid/$params->get('perrow',3));

$boxes = $params->get('boxes');
$style = $params->get('modstyle','default_style');

$mod_title = $params->get('mod_title');
?>
<div class="row  feature_box <?php echo $style; ?> <?php echo $moduleclass_sfx; ?>">
<?php
if($mod_title)
echo '<div class="span'.$parentGrid.'">
	<h4 class="smallm_title '.($params->get('mod_title_pos',1) ? 'centered ':'').$params->get('mod_title_size','bigger').'"><span>'.$mod_title.'</span></h4>
</div>';

if($showDesc && $style != 'style2') {
	echo '<div class="span3">'.$params->get('mod_desc').'</div>';
}

if($boxes) {
	foreach($boxes->vals as $k => $v) {
	
		$img = $boxes->img[$k];
		$url = $boxes->linkurl->link[$k];
		$target = $boxes->linkurl->target[$k];
		$title = $boxes->title[$k];
		$desc = $boxes->desc[$k];

		$output = '<div class="span'.$boxSize.'">';

		if($style == 'default_style')	{
			
			$output .= '<div class="box">';
			if($url) $output .= '<a href="'.$url.'" target="'.$target.'">';
			$output .= '<h4 class="title">'.($img ? '<img src="'.$img.'" alt="'.$title.'">':' ').$title.'</h4>';
			if($url) $output .= '</a>';
			if($desc) $output .= '<p>'.$desc.'</p>';
			$output .= '</div>';
			
		} else if($style == 'style2') {
		
			$output .= '<div class="box">';
			if($url) $output .= '<a href="'.$url.'" target="'.$target.'">';
			if($img) $output .= '<span class="icon"><img src="'.$img.'" alt="'.$title.'"></span>';
			if($title) $output .= '<h4 class="title">'.$title.'</h4>';
			if($url) $output .= '</a>';
			if($desc) $output .= '<p>'.$desc.'</p>';
			$output .= '</div>';
		
		} else if($style == 'style3') {
		
			$output .= '<div class="box">';
			if($url) $output .= '<a href="'.$url.'" target="'.$target.'">';
			if($title) $output .= '<h4 class="title">'.$title.'</h4>';
			if($img) $output .= '<span class="icon ico'.$k.'"></span>';
			if($desc) $output .= '<p>'.$desc.'</p>';
			if($url) $output .= '</a>';
			$output .= '</div>';
			
			$cssBg = '.feature_box.style3 span.icon.ico'.$k.' {background:url('.$img.') no-repeat center top;}';
			
		}
	
		$output .= '</div>';
		
		$doc->addStyleDeclaration($cssBg);
		
		echo $output;
	
	}
} else {
	echo 'Load some Image boxes first!';	
}

?>	
</div>
