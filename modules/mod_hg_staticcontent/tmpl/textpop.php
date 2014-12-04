<?php

// no direct access
defined('_JEXEC') or die;

$mid = $module->id;
$document = JFactory::getDocument(); 
$modpath = JURI::base(true).'/modules/mod_hg_staticcontent';

?>
<div class="bg-wrapper-image" style="background: url(<?php echo $params->get('textpop_bg'); ?>) no-repeat center center; min-height:<?php echo $params->get('textpop_minheight',400); ?>px;">
	<div class="container">
		<div class="static-content textpop-style">
			<?php echo modStaticContentHelper::prepare($params->get('textpop_content')); ?>
		</div>
	</div>
</div>