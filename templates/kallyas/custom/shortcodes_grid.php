<?php
/**
 * Shortcodes 
 *
 * @package		Joomla
 * @subpackage	Zauan Schortcodes
 * @copyright Copyright (C) 2011 Zauan. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author Zauan
 * @author url http://themeforest.net/user/zauan
 */
  // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


/*
* ------------------------------------------------- *
*		GRIDS
* ------------------------------------------------- *
*/

function am_grid( $atts, $content = null ) {
 	//[grid 1-2-3-4-5-6-7-8-9-10-11-12]...[/grid]

	//columns
	$col = 1;
	if (isset($atts[0]) && trim($atts[0])){
		$col = trim($atts[0]);		
	}
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);

	$grid  .= '<div class="span'.$col.'">';
	$grid .= $content;
	$grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid', 'am_grid');

function am_grid1( $atts, $content = null ) {
 	//[grid1][/grid1]

	//order
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span1">';
	$grid .= $content;
	$grid .= '</div>';
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid1', 'am_grid1');

function am_grid2( $atts, $content = null ) {
 	//[grid2][/grid2]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';
 
	$grid  .= '<div class="span2">';
	$grid .= $content;
	$grid .= '</div>';
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid2', 'am_grid2');

function am_grid3( $atts, $content = null ) {
 	//[grid3][/grid3]
	//[grid3 first][/grid3]
	//[grid3 last][/grid3]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span3">';
	$grid .= $content;
	$grid .= '</div>';	
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid3', 'am_grid3');

function am_grid4( $atts, $content = null ) {
 	//[grid4][/grid4]
	//[grid4 first][/grid4]
	//[grid4 last][/grid4]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span4">';
	$grid .= $content;
	$grid .= '</div>';	
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid4', 'am_grid4');

function am_grid5( $atts, $content = null ) {
 	//[grid5][/grid5]
	//[grid5 first][/grid5]
	//[grid5 last][/grid5]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span5">';
	$grid .= $content;
	$grid .= '</div>';	
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid5', 'am_grid5');

function am_grid6( $atts, $content = null ) {
 	//[grid6][/grid6]
	//[grid6 first][/grid6]
	//[grid6 last][/grid6]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span6">';
	$grid .= $content;
	$grid .= '</div>';	
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid6', 'am_grid6');

function am_grid7( $atts, $content = null ) {
 	//[grid7][/grid7]
	//[grid7 first][/grid7]
	//[grid7 last][/grid7]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span7">'.$content.'</div>';	
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid7', 'am_grid7');

function am_grid8( $atts, $content = null ) {
 	//[grid8][/grid8]
	//[grid8 first][/grid8]
	//[grid8 last][/grid8]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span8">';
	$grid .= $content;
	$grid .= '</div>';	
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid8', 'am_grid8');

function am_grid9( $atts, $content = null ) {
 	//[grid9][/grid9]
	//[grid9 first][/grid9]
	//[grid9 last][/grid9]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span9">';
	$grid .= $content;
	$grid .= '</div>';	
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid9', 'am_grid9');

function am_grid10( $atts, $content = null ) {
 	//[grid10][/grid10]
	//[grid10 first][/grid10]
	//[grid10 last][/grid10]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span10">';
	$grid .= $content;
	$grid .= '</div>';	
	if($order == "last") $grid .= '</div>';
	
return $grid;
}
add_shortcode('grid10', 'am_grid10');

function am_grid11( $atts, $content = null ) {
 	//[grid11][/grid11]
	//[grid11 first][/grid11]
	//[grid11 last][/grid11]

	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span11">';
	$grid .= $content;
	$grid .= '</div>';	
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('grid11', 'am_grid11');

function am_grid12( $atts, $content = null ) {
 	//[grid12][/grid12]
	
	//class
	$order = '';
	if (isset($atts[0]) && trim($atts[0])){
		$order .= trim($atts[0]);		
	}
	
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row" data-grid="'.$order.'">';

	$grid  .= '<div class="span12">';
	$grid .= $content;
	$grid .= '</div>';	
	
	if (isset($atts[1]) && trim($atts[1])){
		$grid .= '</div>';
	} else if($order == "last") {
		$grid .= '</div>';
	}
	
	return $grid;
}
add_shortcode('grid12', 'am_grid12');

function am_onethird( $atts, $content = null ) {
 	//[onethird][/onethird]
	//[onethird first][/onethird]
	//[onethird last][/onethird]

	//class
	if (isset($atts[0]) && trim($atts[0])){
		$order=trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span4">';
	$grid .= $content;
	$grid .= '</div>';	
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('onethird', 'am_onethird');

function am_twothirds( $atts, $content = null ) {
 	//[twothirds][/twothirds]
	//[twothirds first][/twothirds]
	//[twothirds last][/twothirds]

	//class
	if (isset($atts[0]) && trim($atts[0])){
		$order=trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid  .= '<div class="span8">';
	$grid .= $content;
	$grid .= '</div>';
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('twothirds', 'am_twothirds');

function am_half( $atts, $content = null ) {
 	//[half][/half]
	//[half first][/half]
	//[half last][/half]

	//class
	if (isset($atts[0]) && trim($atts[0])){
		$order=trim($atts[0]);		
	}
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$grid = '';
	if($order == "first") $grid .= '<div class="row">';

	$grid .= '<div class="span6">';
	$grid .= $content;
	$grid .= '</div>';
	
	if($order == "last") $grid .= '</div>';
	
	return $grid;
}
add_shortcode('half', 'am_half');

function am_row( $atts, $content = null ) {
 	//[row class=""][/row]

	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$class = $atts['class'];
	$overlayToggle = '';
	$ovScript = '';
	if(strpos($class, 'show_id')){
		$overlayToggle = '<div class="span12"><a href="#" id="hideOverlayModules" class="btn btn-primary" style="margin-bottom:30px;">Hide the modules overlay with ID</a></div>';
		$ovScript = '
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#hideOverlayModules").toggle(function(e) {
				jQuery(".row.all_modules").removeClass("show_id");
				jQuery(this).text("SHOW the modules overlay with ID.");
				jQuery(this).removeClass("btn-primary");
			}, function() {
				jQuery(".row.all_modules").addClass("show_id");
				jQuery(this).text("HIDE the modules overlay with ID.");
				jQuery(this).addClass("btn-primary");
			});
		});
		</script>
		';
	}
	
	$html = '<div class="row '.$atts['class'].'">'.$overlayToggle.' '.$content.'</div>'.$ovScript;
	
	return $html;
}
add_shortcode('row', 'am_row');
?>
