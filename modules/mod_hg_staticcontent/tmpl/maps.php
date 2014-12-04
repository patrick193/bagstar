<?php

// no direct access
defined('_JEXEC') or die;

$mid = $module->id;
$document = JFactory::getDocument(); 
$modpath = JURI::base(true).'/modules/mod_hg_staticcontent';

?>

<div class="static-content maps-style">
	<div id="google_map<?php echo $mid; ?>" style="width:100%; height:<?php echo $params->get('maps_height',550); ?>px;"></div><!-- map container -->
	<?php if($params->get('maps_controls',1)): ?>
	<ul id="map_controls">
		<li><a id="zoom_in"><span class="icon-plus icon-white"></span></a></li>
		<li><a id="zoom_out"><span class="icon-minus icon-white"></span></a></li>
		<li><a id="reset"><span class="icon-refresh icon-white"></span></a></li>
	</ul>
	<?php endif; ?>
	<?php echo modStaticContentHelper::prepare($params->get('maps_content')); ?>
</div>
<div class="shadowUP"></div>
<?php
$document->addScript('//maps.google.com/maps/api/js?sensor=false');
$document->addScript($modpath.'/assets/maps/mapmarker.js');
//$document->addScriptDeclaration('mapmarker.js');
?>
<!-- Start Google Maps code -->
<script type="text/javascript">
(function($){
	$(document).ready(function() {
		var myMarkers = {
			"markers": [
			<?php
				$maps_coordinates = preg_split('/\n|\r/', $params->get('maps_coordinates'), -1, PREG_SPLIT_NO_EMPTY);
				foreach ($maps_coordinates as $mpc) {
					$coordinates = explode(',',$mpc);
					
					echo (count($maps_coordinates) > 1 ? ',':'' ).'{ "latitude": "'.$coordinates[0].'", "longitude":"'.$coordinates[1].'", "icon": "'.$params->get('maps_pin').'" }';
				}
			?>
			]
		};
		$("#google_map<?php echo $mid; ?>").mapmarker({
			zoom : <?php echo $params->get('maps_zoom'); ?>,
			center: "<?php echo $params->get('maps_center'); ?>",
			type: "<?php echo $params->get('maps_type'); ?>",
			controls: "<?php echo $params->get('maps_controlsType'); ?>",
			dragging:<?php echo $params->get('maps_dragging'); ?>,
			mousewheel:<?php echo $params->get('maps_mousewheel'); ?>,
			markers: myMarkers,
			styling: 0,							// Bool - do you want to style the map?
			featureType:"all",
			visibility: "on",
			elementType:"geometry",
			hue:"#00AAFF",
			saturation:-100,
			lightness:0,
			gamma:1,
			navigation_control:0
		});
	});
})(jQuery);
</script>
<!-- END Google Maps code -->