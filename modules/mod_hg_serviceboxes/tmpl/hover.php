<?php

// no direct access
defined('_JEXEC') or die;
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
//$boxSize = round($parentGrid/$params->get('perrow',3), 0, PHP_ROUND_HALF_DOWN);
$boxSize = floor($parentGrid/$params->get('perrow',3));
$boxes = $params->get('boxes');
?>
<div class="row-fluid no-space services_box services_box<?php echo $module->id;?> style2 <?php echo $moduleclass_sfx; ?>">
<?php
if($boxes) {
	foreach($boxes->vals as $k => $v) {
	
		$img = $boxes->img[$k];
		$title = $boxes->title[$k];
		$desc = $boxes->desc[$k];
		$text = $boxes->text[$k];
		$services_list = preg_split('/\n|\r/', $desc, -1, PREG_SPLIT_NO_EMPTY);
		
		$output = '
		<div class="span'.$boxSize.'">
			<div class="box fixclear">
			';
			if($img) $output .= '<div class="icon"><img src="'.$img.'" alt="'.$title.'"></div>';
			if($title) $output .= '<h4 class="title">'.$title.'</h4>';
		
			$output .= '<ul class="list">';
				foreach($services_list as $k => $v){
					$output .= '<li>'.$v.'</li>';
				}
			$output .= '</ul>';
			$output .= '<div class="text">'.$text.'</div>';
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

<script type="text/javascript">
	(function($){
		$(".services_box<?php echo $module->id;?> .box").hover(function() {
			var _t = $(this),
				lis = _t.find('li');
			_t.find('.text').stop().hide();
			lis.stop().css({ opacity: 0, marginTop:10});
			_t.find('.list').stop().show();
			lis.each(function(i) {
				duration = i * 50 + 250;
				delay = i * 250;
				$(this).delay(delay).stop().animate({opacity: 1, marginTop:0}, {queue: false, duration:duration, easing:"easeOutExpo"});
			});
		},function() {
			var _t = $(this);
			_t.find('.text').stop().show();
			_t.find('.list').stop().hide();
		});	
	})(jQuery);
</script>
