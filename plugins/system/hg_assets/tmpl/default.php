<?php
/**
 * $JA#COPYRIGHT$
 */
defined('_JEXEC') or die('Restricted access');

	$base_url = JURI::base();
	
	$app = & JFactory::getApplication();	
	if($app->isAdmin()) {
		$base_url = dirname ($base_url);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo $base_url;?>/plugins/system/hg_assets/assets/zntypo/css/zntypo.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $base_url;?>/templates/kallyas/css/editor.css" type="text/css" />
<script type="text/javascript" src="<?php echo $base_url;?>/media/system/js/mootools-core.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>/plugins/system/hg_assets/assets/zntypo/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">jQuery.noConflict();</script>
<title>Untitled Document</title>
</head>
<body>
<?php

		
// De facut in asa fel incat sa caute in template-ul temei 

	$file = dirname (__FILE__).DS.'typo'.DS.'index.html';
	$html = file_get_contents ($file);
	if (preg_match ('/<body[^>]*>(.*)<\/body>/s', $html, $matches)) $html = $matches[1];
	//add typo css
	$typocss = $base_url.'/plugins/system/hg_assets/tmpl/typo/typo.css';
	
?>

<div id="znwrapper">
<?php echo $html?>
</div>	
<script type="text/javascript">
window.addEvent('domready', function() {

jQuery('.zn_show_t1').show();

jQuery('.zn_menu_item').each(function() {
	var a = jQuery(this);
	var b = a.attr('rel');
	a.click(function() {
		jQuery('.zntab').hide();
		jQuery('.zn_menu_item').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.zn_show_'+b).show();
	});
}); 

jQuery('.typo').each(function() {
	var a = jQuery('.sample',this);
	a.click(function() {
		var sample = jQuery(this);
		var html = sample.html();
		window.parent.insertHTML(html);
		window.parent.SqueezeBox.close();	
	});

}); 

});
//window.parent.LoadJSEditor();
</script>
</body>
</html>