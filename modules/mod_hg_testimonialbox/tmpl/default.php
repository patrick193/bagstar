<?php

// no direct access
defined('_JEXEC') or die;
?>

<div class="testimonial_box <?php echo $moduleclass_sfx; ?>" data-align="<?php echo $params->get('align','left'); ?>" data-size="full" data-theme="<?php echo $params->get('theme','light'); ?>">
	<div class="details">
		<img src="<?php echo $params->get('test_image');?>" alt="">
		<h6><strong><?php echo $params->get('test_name');?></strong> <?php echo $params->get('test_function');?></h6>
	</div>
	<blockquote><?php echo $params->get('test_text');?></blockquote>
</div><!-- end testimonial box -->

