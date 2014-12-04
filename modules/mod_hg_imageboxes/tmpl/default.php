<?php

// no direct access
defined('_JEXEC') or die;
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
//$boxSize = round($parentGrid/$params->get('perrow',3), 0, PHP_ROUND_HALF_DOWN);
$boxSize = floor($parentGrid/$params->get('perrow',3));
$boxes = $params->get('boxes');
$style = $params->get('modstyle',1);
?>
<div class="row image-boxes imgboxes_style<?php echo $style; ?> <?php echo $moduleclass_sfx; ?>">
<?php
if($boxes) {
	foreach($boxes->vals as $k => $v) {
	
		$img = $boxes->img[$k];
		$url = $boxes->linkurl->link[$k];
		$target = $boxes->linkurl->target[$k];
		$title = $boxes->title[$k];
		$desc = $boxes->desc[$k];

		$output = '<div class="span'.$boxSize.' box">';

		if($style == 1)	{
		
			if($url) $output .= '<a href="'.$url.'" target="'.$target.'" class="hoverBorder">';
			if($img) $output .= '<img src="'.$img.'" alt="'.$title.'">';
			if($url) $output .= '<h6>'.$boxes->linktext[$k].'</h6></a>';
			if($title) $output .= '<h3 class="m_title">'.$title.'</h3>';
			if($desc) $output .= '<p>'.$desc.'</p>';
		
		} else if($style == 2) {
		
			if($url) $output .= '<a href="'.$url.'" target="'.$target.'" class="slidingDetails">';
				if($img) $output .= '<img src="'.$img.'" alt="'.$title.'">';
				if($title or $desc) $output .= '<div class="details">';
					if($title) $output .= '<h4>'.$title.'</h4>';
					if($desc) $output .= '<p>'.$desc.'</p>';
				if($title or $desc) $output .= '</div>';
			if($url) $output .= '</a>';
		
		}
	
		$output .= '</div><!-- end span -->';
	
		echo $output;
	
	}
} else {
	echo 'Load some Image boxes first!';	
}

?>	
</div>
