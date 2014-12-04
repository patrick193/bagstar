<?php

// no direct access
defined('_JEXEC') or die;
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
//$boxSize = round($parentGrid/$params->get('perrow',3), 0, PHP_ROUND_HALF_DOWN);
$boxSize = floor($parentGrid/$params->get('perrow',3));
$boxes = $params->get('boxes');
?>
<div class="row services_box <?php echo $moduleclass_sfx; ?>">
<?php
if($boxes) {
	foreach($boxes->vals as $k => $v) {
	
		$img = $boxes->img[$k];
		$title = $boxes->title[$k];
		$desc = $boxes->desc[$k];
		$services_list = preg_split('/\n|\r/', $desc, -1, PREG_SPLIT_NO_EMPTY);
		
		$output = '
		<div class="span'.$boxSize.'">
			<div class="box fixclear">
			';
			if($img) $output .= '<div class="icon"><img src="'.$img.'" alt="'.$title.'"></div>';
			if($title) $output .= '<h4 class="title">'.$title.'</h4>';
		
			$output .= '<ul class="list-style1">';
				foreach($services_list as $k => $v){
					$output .= '<li>'.$v.'</li>';
				}
			$output .= '</ul>';
		
		$output .= '
			</div><!-- end box -->
		</div>';
	
		echo $output;
	
	}
} else {
	echo 'Load some Service Boxes first!';	
}

?>	
</div>
