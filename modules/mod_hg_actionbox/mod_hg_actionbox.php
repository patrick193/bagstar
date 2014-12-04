<?php
// no direct access
defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$mid = $module->id;;

JFactory::getDocument()->addStyleDeclaration('#action_box'.$mid.'{background-color:'.$params->get('box_color', '#CD2122').'}');  
?>
<div id="action_box<?php echo $mid; ?>" data-arrowpos="<?php echo $params->get('arrpos','center'); ?>" class="action_box <?php echo $moduleclass_sfx; ?>">
	<div class="container">
		<div class="row">
			<div class="span8">
				<h4 class="text"><?php echo $params->get('text'); ?></h4>
			</div>
			<div class="span4 align-center">
				<!--<a href="<?php // echo $params->get('button_url'); ?>" target="<?php echo $params->get('button_target', '_self'); ?>" class="btn"><?php echo $params->get('button_text'); ?></a>-->
			</div>
		</div>
	</div>
</div><!-- end action box -->