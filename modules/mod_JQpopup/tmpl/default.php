<?php
/*------------------------------------------------------------------------
# mod_JQpopup - Jquery UI Popup Module
# ------------------------------------------------------------------------
# author    Vsmart Extensions
# copyright Copyright (C) 2010 YourAwesomeSite.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.vsmart-extensions.com
# Technical Support:  Forum - http://www.vsmart-extensions.com
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JHTML::_('behavior.mootools');

$theme = $params->get('theme',"smoothness");
$title = $params->get('title',"");
$icon = $params->get('icon',"alert");
$show_effect = $params->get('show_effect',"bounce");
$hide_effect = $params->get('hide_effect',"explode");
$link = $params->get('link',"http://vsmart-extensions.com");
$position = $params->get('position',"[500,300]");


$doc =& JFactory::getDocument();
$doc->addScript(JURI::Root(true)."/modules/mod_JQpopup/tmpl/js/jquery.min.js");
$doc->addScript(JURI::Root(true)."/modules/mod_JQpopup/tmpl/js/jquery-ui.min.js");
$doc->addScript(JURI::Root(true)."/modules/mod_JQpopup/tmpl/js/cookie.js");
$doc->addStyleSheet(JURI::Root(true)."/modules/mod_JQpopup/tmpl/css/".$theme."/jquery-ui.css");

?>
<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function () {
		var showBox;
		if ( Get_Cookie( 'showBox' ) ) showBox = Get_Cookie('showBox');
		else{
			showBox = "false";
		}
		<?php if($time_reopen == 0) echo "showBox='false';\n"; ?>
		if(showBox == "false"){
			jQuery('#vst_dialog').dialog({
				autoOpen: true,
				width:<?php echo $width; ?>,
				height:<?php echo $height; ?>,
				position:<?php echo $position; ?>,
				show:'<?php echo $show_effect; ?>',
				<?php if($type == "link"){ 
					if(substr($link,0,7)!="http://")
					$link = "http://".$link;
				?>
				open: function(event, ui) {
					jQuery('#vst_dialog').html("<iframe src='<?php echo $link; ?>' width='100%' height='100%' frameborder='0' scrolling='auto' />");
				},
				<?php } ?>
				hide:'<?php echo $hide_effect; ?>'
			});
			var t=setTimeout("jQuery('#vst_dialog').dialog('close');",<?php echo $time; ?>);
			<?php if($time_reopen){ ?>
				Set_Cookie( 'showBox', 'true', '<?php echo $time_reopen; ?>', '/', '', '' );
			<?php } ?>
		}
	});
</script>
<style>
	.vstPopupInner{
		/*height:<?php echo ($height - 10); ?>px !important;*/
		padding:10px;
	}
</style>	
<div id="vst_dialog" style="display:none;" title="<span class='ui-icon ui-icon-<?php echo $icon; ?>' style='float:left;margin-right:3px;'></span><?php echo $title; ?>">
	<?php echo $vst_popup; ?>
</div>