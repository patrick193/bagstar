<?php

// no direct access
defined('_JEXEC') or die;
$mid = $module->id;
$doc =& JFactory::getDocument();

$base = JURI::base(true);
$mod_path = $base."/modules/mod_hg_revolutionslider";
$asset_path = $mod_path."/assets";

$enableParallax = $params->get('enableParallax',1);

// load stylesheets
$doc->addStyleSheet($asset_path."/css/settings.css");
$doc->addStyleSheet($asset_path."/css/creative_slider.css");
$css = '
html { overflow-x:hidden; padding: 0 !important; margin:0px !important; }
.fullwidthbanner-container{ width:100% !important; position:relative; padding:0; max-height:'.$params->get('maxheight',600).'px !important; overflow:hidden;	}
';
$doc->addStyleDeclaration($css);

//load js's
$doc->addScript($asset_path."/js/jquery.themepunch.plugins.min.js");
$doc->addScript($asset_path."/js/jquery.themepunch.revolution.min.js");
if($enableParallax) $doc->addScript($asset_path."/js/parallax.js");
 
$list = modRevolutionSliderHelper::getList($params);

if($list==null) {
	JFactory::getApplication()->enqueueMessage(JText::_('No slide-article published in this category!'), 'notice');
	return;
}
?>
<div class="fullwidthbanner-container portfolio_devices">
	<div id="revolutionslider<?php echo $mid; ?>" class="fullwidthbanner">
		<ul>
<?php
foreach ($list as $key=>$item)
	echo modRevolutionSliderHelper::prepare($item->introtext);
?>
		</ul>
		<div class="tp-bannertimer"></div> 
	</div><!-- end revolutionslider -->
</div><!-- end fullwidthbanner-container -->

<script type="text/javascript">
var tpj=jQuery;
tpj.noConflict();

tpj(document).ready(function() {

if (tpj.fn.cssOriginal!=undefined)
	tpj.fn.css = tpj.fn.cssOriginal;

	tpj('#revolutionslider<?php echo $mid; ?>').revolution(
		{
			delay: <?php echo $params->get('delay',9000);?>,
			startwidth:890,
			startheight:700,
			onHoverStop:"<?php echo $params->get('onHoverStop','on');?>",						// Stop Banner Timet at Hover on Slide on/off
			thumbWidth:100,							// Thumb With and Height and Amount (only if navigation Tyope set to thumb !)
			thumbHeight:50,
			thumbAmount:3,
			hideThumbs:200,
			navigationType:"<?php echo $params->get('showBullets','bullet');?>",					//bullet, thumb, none, both	 (No Shadow in Fullwidth Version !)
			navigationArrows:"verticalcentered",	//nexttobullets, verticalcentered, none
			touchenabled:"<?php echo $params->get('touchenabled','on');?>",						// Enable Swipe Function : on/off
			navOffsetHorizontal:0,
			navOffsetVertical:20,
			stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
			stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic
			fullWidth:"on",
			shadow:0								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows -  (No Shadow in Fullwidth Version !)
		});
});
<?php if($enableParallax): ?>
	var parallax = new Parallax({
		container: '#slideshow',
		layers: [
			{ selector: '.para1', ratio: .020 },
			{ selector: '.para2', ratio: .010 },
			{ selector: '.para3', ratio: .008 },
			{ selector: '.para4', ratio: .005 },
			{ selector: '.para5', ratio: .005 },
			{ selector: '.para6', ratio: .011 },
			{ selector: '.para7', ratio: .016 }
		]
	});
<?php endif; ?>
</script>