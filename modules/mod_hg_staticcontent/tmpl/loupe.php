<?php

// no direct access
defined('_JEXEC') or die;

$mid = $module->id;
$document = JFactory::getDocument(); 
$modpath = JURI::base(true).'/modules/mod_hg_staticcontent';

$css = '.productzoom-style .screenshotMagnifier {background-image:url('.$modpath.'/assets/loupe/screenshot-framed.png);}';
$css .= '.loupe { cursor:url('.$modpath.'/assets/loupe/blank.png), url('.$modpath.'/assets/loupe/blank.cur), none; ';
$document->addStyleDeclaration($css);

$image = $params->get('loupe_image');

if($image)
$thumb = JURI::base(true).'/cache/'.modStaticContentHelper::createThumb($image, 620, 390);
?>

<div class="container">
	<div class="static-content productzoom-style">
		<div class="row">
			<div class="span<?php echo ($image ? 5:12);?>">
				<?php echo modStaticContentHelper::prepare($params->get('loupe_content')); ?>
			</div>
			<?php if($image): ?>
			<div class="span7">
				<div id="screenshot<?php echo $mid; ?>" class="screenshotMagnifier screenshot">
					<div class="image">
						<img src="<?php echo $thumb; ?>" data-full="<?php echo $image; ?>" alt="">
						<div class="loupe"></div>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div><!-- end row -->
	</div>
</div>
<!-- start loupe script -->
<script type="text/javascript" src="<?php echo $modpath; ?>/assets/loupe/loupe.min.js"></script>
<script type="text/javascript">
(function($){
	$('#screenshot<?php echo $mid; ?>').ImageLoupeMagnify({
		loupeWidth: 150,		// Loupe width
		loupeHeight: 150,		// Loupe height
		imageWidth:620,			// Image's width
		imageHeight:390,		// Image's height
		horizontalFactor: 1.65,	// Horizontal bg position factor
		verticalFactor: 1.65	// Vertical bg position factor
	});
})(jQuery);
</script>
<!-- end loupe script -->