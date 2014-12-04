<?php

// no direct access
defined('_JEXEC') or die;
$doc =& JFactory::getDocument();
$skills = $params->get('skills');
$modpath = JURI::base(true)."/modules/mod_hg_skillsdiagram";
$align = $params->get('align', 'none');
$doc->addScript("//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js");
$doc->addScript($modpath."/assets/init.js");
?>
<div id="skills_diagram" style="float:<?php echo $align; ?>">
	<div class="legend" <?php if(!$params->get('show_legend',1)) echo 'style="display:none"'; ?>>
		<?php if($params->get('legend_title')) echo '<h4>'.$params->get('legend_title').'</h4>'; ?>
		<ul class="skills">
<?php
if($skills) {
	foreach($skills->vals as $k => $v) {
		echo '<li data-percent="'.$skills->percentage[$k].'" style="background-color:'.$skills->color[$k].';">'.$skills->title[$k].'</li>';
	}
} else {
	echo 'Load some skills first!';	
}

?>	
		</ul><!-- end the skills -->
	</div>
	<div id="thediagram" data-width="<?php echo $params->get('width',600); ?>" data-height="<?php echo $params->get('height',600); ?>" data-maincolor="<?php echo $params->get('maincolor','#193340'); ?>" data-maintext="<?php echo $params->get('maintext','Skills'); ?>" data-fontsize="<?php echo $params->get('mainfont','20px Arial'); ?>" data-textcolor="<?php echo $params->get('textcolor','#ffffff'); ?>"></div>
</div><!-- end skills diagram -->
