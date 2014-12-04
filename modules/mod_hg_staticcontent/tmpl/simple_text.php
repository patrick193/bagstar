<?php

// no direct access
defined('_JEXEC') or die;

$mid = $module->id;
$document = JFactory::getDocument(); 
$modpath = JURI::base(true).'/modules/mod_hg_staticcontent';

?>

<div class="container">
	<div class="static-content simple" style="min-height:<?php echo $params->get('simple_text_minheight',400); ?>px;">
		
		<div class="row">
			<div class="span12">
				<?php echo modStaticContentHelper::prepare($params->get('simple_text_content')); ?>
			</div>
		</div><!-- end row -->
	</div><!-- end static content -->
</div>