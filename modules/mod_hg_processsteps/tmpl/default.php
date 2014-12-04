<?php

// no direct access
defined('_JEXEC') or die;
$doc =& JFactory::getDocument();
$cssBg ='';
$showIntro = $params->get('show_intro',1);
$steps = $params->get('steps');
$introBg = $params->get('intro_bg', '#444');
?>
<div class="process_steps fixclear <?php echo $moduleclass_sfx; ?>">
<?php
if($showIntro) {
	echo '<div class="step intro">'.$params->get('intro_content').'</div>';
	$cssBg .= '.process_steps .step.intro {background:'.$introBg.';}.process_steps .step.intro:after {border-left-color:'.$introBg.'; }';
}

if($steps) {
	foreach($steps->vals as $k => $v) {
	
		$img = $steps->img[$k];
		$url = $steps->linkurl->link[$k];
		$target = $steps->linkurl->target[$k];
		$title = $steps->title[$k];
		$intro = $steps->desc[$k];
		$id = $k+1;
		
		$output = '<div class="step step'.$id.' '.(count($steps->vals) == $id ? 'last_step':'').'">';

		if($img) {
			$output .= '<div class="icon" data-animation="'.$steps->animation[$k].'">';
			if($url) $output .= '<a href="'.$url.'" target="'.$target.'">';
			$output .= '<img src="'.$img.'" alt="'.$title.'">';
			if($url) $output .= '</a>';
			$output .= '</div>';
		}
		if($title) $output .= '<h3>'.$title.'</h3>';
		if($intro) $output .= '<p>'.$intro.'</p>';
		
		$output .= '</div><!-- end step -->';

		$cssBg .= '.process_steps .step.step'.$id.' {background:'.$steps->color[$k].';} .process_steps .step.step'.$id.':after {border-left-color:'.$steps->color[$k].'; }';
		
		echo $output;
	
	}
}

$doc->addStyleDeclaration($cssBg);

?>	
</div>