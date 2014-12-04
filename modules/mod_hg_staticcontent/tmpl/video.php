<?php

// no direct access
defined('_JEXEC') or die;

$mid = $module->id;
$document = JFactory::getDocument(); 

?>
<div class="bg-wrapper-image" style="background: url(<?php echo $params->get('video_bg'); ?>) no-repeat center center; min-height:<?php echo $params->get('video_minheight',400); ?>px;">
	<div class="container">
		<div class="static-content video-style">
			<?php echo modStaticContentHelper::prepare($params->get('video_content')); ?>
		</div>
	</div>
</div>