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

require_once dirname(__FILE__).'/shortcodes_helper.php';
require_once dirname(__FILE__).'/shortcodes_grid.php';



/*
* ------------------------------------------------- *
*		Module anywhere		
* ------------------------------------------------- *		
*/

function hg_module( $atts, $content = null ) {
	//[module id="" class="" style="" overrides=""]
	// override format: something=yyy|something_else=xxx
	
	extract(shortcode_atts(array(
    	"id" => '',
    	"class" => '',
		"style" => 'none',
		"overrides" => ''
	), $atts));
	
	$document = &JFactory::getDocument();
	$renderer = $document->loadRenderer('module');
	
	$contents = '';
	
	//get module as an object
	$database = JFactory::getDBO();
	$database->setQuery("SELECT * FROM #__modules WHERE id='$id' ");
	$modules = $database->loadObjectList();
	$module = $modules[0];
	
	//just to get rid of that stupid php warning
	$module->user = '';

	if(!empty($overrides)) {
		$attrs = explode('|',$overrides);
		
		foreach( $attrs as $over ) {
			$attrs2 = explode(':',$over);
			$params[$attrs2[0]] = $attrs2[1];
		}
	}
	
	$params_fin =  array('style' => $style ,'params' => json_encode($params));
	$contents = $renderer->render($module, $params_fin);		
	
	return $contents;
}

add_shortcode('module', 'hg_module');


/*
* ------------------------------------------------- *
*		Google Maps Shortcode
* ------------------------------------------------- *		
*/
function hg_googleMaps($atts, $content = null) {
	// [googlemap width="" height="" src=""]
	
	extract(shortcode_atts(array(
    	"width" => '320',
    	"height" => '230',
		"src" => ''
	), $atts));
	return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'"></iframe>';
}
add_shortcode("googlemap", "hg_googleMaps");

/*
* ------------------------------------------------- *
*		Code		
* ------------------------------------------------- *		
*/
//code
function hg_code( $atts, $content = null ) {
	//[code][/code]
	$hg_code='<code>';
	$content = preg_replace('#^<\/p>|<p>$#', '', trim($content));
	$hg_code .= do_shortcode($content);
	$hg_code .='</code>';
	return $hg_code;
}

add_shortcode('code', 'hg_code');

//pre
function hg_pre( $atts, $content = null ) {
	//[pre][/pre]
	$hg_pre='<pre>';
	$content = preg_replace('#^<\/p>|<p>$#', '', trim($content));
	$hg_pre .= do_shortcode($content);
	$hg_pre .='</pre>';
	return $hg_pre;
}

add_shortcode('pre', 'hg_pre');

 /*
* ------------------------------------------------- *
*		Headings		
* ------------------------------------------------- *		
*/

//H1
function hg_h1( $atts, $content = null ) {
	//[h1 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));
	
	$style = 'style="'.$style.'; text-align:'.$textalign.';"';
	
	$hg_h1='<h1 class="'.$class.'"  '.$style.'>';
	$hg_h1 .= do_shortcode(strip_tags($content));
	$hg_h1.='</h1>';
	return $hg_h1;
}
add_shortcode('h1', 'hg_h1');
//---------------------------------------------------

//H2
function hg_h2( $atts, $content = null ) {
	//[h2 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));
	
	$style = 'style="'.$style.'; text-align:'.$textalign.';"';
	
	$hg_h2='<h2 class="'.$class.'"  '.$style.'>';
	$hg_h2 .= do_shortcode(strip_tags($content));
	$hg_h2.='</h2>';
	return $hg_h2;
}
add_shortcode('h2', 'hg_h2');
//---------------------------------------------------

//H3
function hg_h3( $atts, $content = null ) {
	//[h3 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));
	
	$style = 'style="'.$style.'; text-align:'.$textalign.';"';
	
	$hg_h3='<h3 class="'.$class.'" '.$style.'>';
	$hg_h3 .= do_shortcode(strip_tags($content));
	$hg_h3.='</h3>';
	return $hg_h3;
}

add_shortcode('h3', 'hg_h3');
//---------------------------------------------------

//H4
function hg_h4( $atts, $content = null ) {
	//[h4 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));
	
	$style = 'style="'.$style.'; text-align:'.$textalign.';"';
	
	$hg_h4='<h4 class="'.$class.'"  '.$style.'>';
	$hg_h4 .= do_shortcode(strip_tags($content));
	$hg_h4.='</h4>';
	return $hg_h4;
}
add_shortcode('h4', 'hg_h4');
//---------------------------------------------------

//H5
function hg_h5( $atts, $content = null ) {
	//[h5 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));
	
	$style = 'style="'.$style.'; text-align:'.$textalign.';"';
	
	$hg_h5='<h5 class="'.$class.'"  '.$style.'>';
	$hg_h5 .= do_shortcode(strip_tags($content));
	$hg_h5.='</h5>';
	return $hg_h5;
}
add_shortcode('h5', 'hg_h5');
//---------------------------------------------------

//H6
function hg_h6( $atts, $content = null ) {
	//[h6 class="" style="" textalign=""]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"textalign" => 'left'
	), $atts));
	
	$style = 'style="'.$style.'; text-align:'.$textalign.';"';
	
	$hg_h6='<h6 class="'.$class.'"  '.$style.'>';
	$hg_h6 .= do_shortcode(strip_tags($content));
	$hg_h6.='</h6>';
	return $hg_h6;
}
add_shortcode('h6', 'hg_h6');
//---------------------------------------------------

//MTITLE
function hg_mtitle($atts, $content = null) {
	//[mtitle class="" style="" textalign="" heading=""][/mtitle]
	extract(shortcode_atts(array(
		"class" => '',
		"style" => '',
		"heading" => 'h4',
		"textalign" => 'left'
	), $atts));
	
	$style = 'style="text-align:'.$textalign.'; '.$style.';"';
	
	$html = '<'.$heading.' class="m_title '.$class.'" '.$style.'>';
	$html .= do_shortcode(strip_tags($content));
	$html .= '</'.$heading.'>';
	return $html;
}
add_shortcode('mtitle', 'hg_mtitle');

/*
* ------------------------------------------------- *
*		TYPOGRAPHY	
* ------------------------------------------------- *		
*/
//p
function hg_paragraph( $atts, $content = null ) {
	//[paragraph][/paragraph]
	$hg_paragraph='<p>';
	$hg_paragraph .= do_shortcode(strip_tags($content));
	$hg_paragraph.='</p>';
	return $hg_paragraph;
}
add_shortcode('paragraph', 'hg_paragraph');
//---------------------------------------------------

//blockquote
function hg_blockquote( $atts, $content = null ) {
	//[blockquote][/blockquote]
	$hg_blockquote='<blockquote>';
	$hg_blockquote .= do_shortcode(strip_tags($content));
	$hg_blockquote.='</blockquote>';
	return $hg_blockquote;
}
add_shortcode('blockquote', 'hg_blockquote');
//---------------------------------------------------

//image
function hg_image( $atts, $content = null ) {
	//[image path="" alt="" title="" class="" style=""]
	
	return '<img src="'.$atts['path'].'" alt="'.$atts['alt'].'"  title="'.$atts['title'].'" class="'.$atts['class'].'" style="'.$atts['style'].'" />';
}
add_shortcode('image', 'hg_image');
//---------------------------------------------------


/*
* ------------------------------------------------- *
*		highlights
* ------------------------------------------------- *		
*/
function hg_highlights( $atts, $content = null ) {
	// [hlight warning - success - info - inverse][/hlight]
	
	//class
	if (isset($atts[0]) && trim($atts[0]))
		$class=trim($atts[0]);		
	else
		$class="info";

	//fix shortcode
	$content = fixshortcode($content);  
	$content = '<span class="label label-'.$class.'">'.trim($content).'</span>';
	 
	return $content;
}
add_shortcode('hlight', 'hg_highlights');
//---------------------------------------------------

/*
* ------------------------------------------------- *
*		lists		
* ------------------------------------------------- *		
*/
function hg_lined_list( $atts, $content = null ) {
	// [list 1 - 2 - 3 - 4 - 5 - 6 - 7 - 8 - 9 class="" style="" columns="" ][/list]
	
	$columns = ($atts['columns']) ? 'cols-'.$atts['columns'].' clearfix' : 'cols-1 clearfix';	
	//class
	if (isset($atts[0]) && trim($atts[0])){
		$type=trim($atts[0]);		
	}
  
	//fix shortcode
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$content = preg_replace('#<ul>#', '<ul class="list-style'.$type.' '.$columns.' '.$atts['class'].'" '.(($atts['style'] != '') ? 'style="'.$atts['style'].'"' : '').'>', trim($content));
	 
	return $content;
}
add_shortcode('list', 'hg_lined_list');

/*
* ------------------------------------------------- *
*		BUTTONS
* ------------------------------------------------- *
*/
function hg_btn( $atts, $content = null ) {
/*[btn size="" type="" class="" class="" disabled="" link="" target="" icon="" icontheme=""][/btn]
type: primary / info / success / warning / danger / inverse / link / flat
size: primary / large / small / mini
disabled: yes / no
icon: add the icon type without the " icon- " 
icontheme: white/black
*/
	extract(shortcode_atts(array(
		"disabled" => 'no',
		"size" => 'normal',
		"class" => '',
		"style" => '',
		"type" => 'primary',
		"link" => '#',
		"target" => '_self',
		"icon" => '',
		"icontheme" => 'white'
	), $atts));
	
	$disabled = ($disabled == 'yes') ? 'disabled' : '';
	
	$icon = ($icon ? '<span class="icon-'.$icon.' icon-'.$icontheme.'"></span>':'');

	return '<a href="'.$link.'" class="btn btn-'.$size.' btn-'.$type.' '.$class.' '.$disabled.'" style="'.$style.'" target="'.$target.'">'.$icon.$content.'</a>';
}
add_shortcode('btn', 'hg_btn');

//---------------------------------------------------

/*
* ------------------------------------------------- *
*		show shortcode :)
* ------------------------------------------------- *
*/

function hg_shortcode_show_shortcode( $atts, $content = null ) {
 
	//convert html [] spacial chars  

	//fix shortcode
	$content = fixshortcode($content);
	$content = preg_replace('#<br \/>#', "\n",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	$content = preg_replace('#\[\/braket_close\]#', "[/show_shortcode]",trim($content));

	if($atts['code'] == "html5") {
		//return '<pre xml:lang="html5">' . $content . '</pre>';
		return $content;
	} else {
		return '<code>' . htmlspecialchars($content) . '</code>';
	}
}
add_shortcode('show_shortcode', 'hg_shortcode_show_shortcode');


/*
* ------------------------------------------------- *
*		Accordions
* ------------------------------------------------- *
*/

function hg_shortcode_accordion( $atts, $content = null ) {
    //[accordion style="1" or style="2" width=""][/accordion]

    //class
	$style = '';
	if (isset($atts['style']) && trim($atts['style'])){
		$style .= trim($atts['style']);		
	}
   $width='';
	if($atts['width']) { $width = 'width:'.$atts['width'].'px'; }
	
    //fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    //$content = preg_replace('#<p>#', "",trim($content));
    //$content = preg_replace('#<\/p>#', "",trim($content)); 
    
    return '<div class="accordion-style-'.$style.'" style="'.$width.'">'.$content.'</div>';
}
//---------------------------------------------------

function hg_shortcode_toggle( $atts, $content = null ) {
    //[toggle style="1" or style="2" width=""][/toggle]

    //class
	$style = '';
	if (isset($atts['style']) && trim($atts['style'])){
		$style .= trim($atts['style']);		
	}
	$width='';
	if($atts['width']) { $width = 'width:'.$atts['width'].'px'; }
   
    //fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    //$content = preg_replace('#<p>#', "",trim($content));
    //$content = preg_replace('#<\/p>#', "",trim($content)); 
    
    return '<div class="toggle-style-'.$style.'" style="'.$width.'">'.$content.'</div>';
}
//---------------------------------------------------


function hg_shortcode_accordion_panel( $atts, $content = null ) {
	//[acc_pane title=""][/acc_pane]
    
    $pane_title=$atts['title'];
	
    //fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    //$content = preg_replace('#<p>#', "",trim($content));
    //$content = preg_replace('#<\/p>#', "",trim($content)); 

    return '<div class="acc_wrapper"><a href="#" class="acc_trigger"><span>'.$pane_title.'</span></a><div class="acc_container">' . $content . '<div class="clear"></div></div></div>';
}
//---------------------------------------------------

function hg_shortcode_toggle_panel( $atts, $content = null ) {
	//[tgg_pane title=""][/tgg_pane]
    
    $pane_title=$atts['title'];
	
    //fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
    //$content = preg_replace('#<p>#', "",trim($content));
    //$content = preg_replace('#<\/p>#', "",trim($content)); 

    return '<div class="tgg_wrapper"><a href="#" class="tgg-trigger"><span>'.$pane_title.'</span></a><div class="toggle_container">' . $content . '<div class="clear"></div></div></div>';
}

add_shortcode('accordion', 'hg_shortcode_accordion');
add_shortcode('acc_pane', 'hg_shortcode_accordion_panel');
add_shortcode('toggle', 'hg_shortcode_toggle');
add_shortcode('tgg_pane', 'hg_shortcode_toggle_panel');
//---------------------------------------------------


/* TABS shortcode*/

function hg_tabs( $atts, $content ){
	// [tabs class="" style="" first_tab="" icons_theme=""][/tabs]
	// style = vertical_tabs / tabs_style1 / tabs_style2 / tabs_style3 / tabs_style4
	// icons_theme = white / black
	
	if (isset($GLOBALS['tabs_count'])) $GLOBALS['tabs_count']++;
    else $GLOBALS['tabs_count'] = 0;
	
	extract(shortcode_atts(array(
		'class' => '',
		'style' => 'tabs_style1',
		'first_tab' => 1,
		'icons_theme' => 'white'
	), $atts));
	
	preg_match_all('/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);
	preg_match_all('/icon="([^\"]+)"/', $content, $imatches, PREG_OFFSET_CAPTURE);

	$tab_titles = array();
	$tab_icons = array();
	if (isset($matches[1])) {
		$tab_titles = $matches[1];
		$tab_icons = $imatches[1];
	}
	
	$output = '';
	
	if (count($tab_titles)) {
		$output .= '<div class="tabbable '.$style.' '.$class.'"><ul class="nav fixclear">';
		$i = 1;
		foreach($tab_titles as $t => $tab) {
			if ($i == $first_tab) $output .= '<li class="active">';
			else $output .= '<li>';

			$output .= '<a href="#custom-tab-'.$GLOBALS['tabs_count'].'-'.HgShortcodesHelper::maketabid($tab[0]).'" data-toggle="tab">'.($tab_icons[$t][0] != '' ? '<span><span class="'.$tab_icons[$t][0].' icon-'.$icons_theme.'"></span></span>':'').$tab[0].'</a></li>';
			$i++;
		}
		
		$output .= '</ul>';
		$output .= '<div class="tab-content">';
		$output .= do_shortcode($content);
		$output .= '</div></div>';
	} else {
		$output .= do_shortcode($content);
	}
	
	return $output;

}
add_shortcode( 'tabs', 'hg_tabs' );



function hg_tab( $atts, $content ){
	// [tab title="" icon=""] ... [/tab]
	// for full list of icons go here
	
	if (!isset($GLOBALS['current_tabs'])) {
		$GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
		$state = 'active';
	} else {
		if ($GLOBALS['current_tabs'] == $GLOBALS['tabs_count']) {
			$state = '';
		} else {
			$GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
			$state = 'active';
		}
	}
	
	$defaults = array('title' => 'Tab', 'icon' => '');
	extract(shortcode_atts($defaults, $atts));
	
	return '<div id="custom-tab-'.$GLOBALS['tabs_count'].'-'.HgShortcodesHelper::maketabid($title).'" class="tab-pane '.$state.'">'.do_shortcode($content).'</div>';
	
}
add_shortcode( 'tab', 'hg_tab' );

/*
* ------------------------------------------------- *
*		Info Box
* ------------------------------------------------- *
*/

function hg_shortcode_infobox( $atts, $content = null ) {
    //[infobox title="" class="" url="" url_text="" target=""] .. [/infobox]

    extract(shortcode_atts(array(
		"title" => '',
		"style" => '',
		"class" => '',
		"url" => '',
		"url_text" => '',
		"target" => '_self'
	), $atts));
    
	$class .= ($url ? 'infobox2' :'infobox1');

    //fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content));
    $content = preg_replace('#<\/p>#', "",trim($content)); 
    
    return '<div class="'.$class.'">'.
		($url ? '<a href="'.$url.'" target="'.$target.'" class="btn btn-large btn-inverse">'.$url_text.'</a>':'').
		($title ? '<h3 class="m_title">'.$title.'</h3>':'').
		($content ? '<div>'.$content.'</div>':'').'
	</div>';
} 

add_shortcode('infobox', 'hg_shortcode_infobox'); 
//---------------------------------------------------


/*
* ------------------------------------------------- *
*		VIDEO Embedding
* ------------------------------------------------- *
*/


// vimeo video
function hg_vimeo( $atts, $content = null ) {
 	//[vimeo id="" width="" height="" autoplay="" color="" class="" embed_type=""]
	// embed type = flash / iframe
	extract(shortcode_atts(array(
		"id" => $atts['id'],
		"width" => '475',
		"height" => '350',
		"autoplay" => '0',
		"color" => '00adef',
		"embed_type" => 'iframe',
		"class" => ''
	), $atts));

	$flash = '<object width="'.$width.'" height="'.$height.'"><param name="allowfullscreen" value="true" /><param name="wmode" value="transparent" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color='.$color.'&amp;fullscreen=1&amp;autoplay='.$autoplay.'&amp;loop=0" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color='.$color.'&amp;fullscreen=1&amp;autoplay='.$autoplay.'&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" wmode="transparent" allowscriptaccess="always" width="'.$width.'" height="'.$height.'"></embed></object>';
	
	$iframe = '<iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay='.$autoplay.'" width="'.$width.'" height="'.$height.'" frameborder="0" class="'.$class.'" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	
	if($embed_type == 'flash')
		$video = $flash;
	elseif($embed_type == 'iframe')
		$video = $iframe;
		
	return $video;
}
add_shortcode('vimeo', 'hg_vimeo');
//---------------------------------------------------

// youtube video
function hg_youtube( $atts, $content = null ) {
 	//[youtube id="" width="" height="" autoplay="" playhd="" controls="" wmode="" showinfo="" class="" ]
	extract(shortcode_atts(array(
		"id" => $atts['id'],
		"width" => '475',
		"height" => '350',
		"autoplay" => '0',			// 0 = No, 1 = Yes
		"playhd" => '0',			// 0 = No, 1 = Yes
		"controls" => '1',			// 0 = No, 1 = Yes
		"wmode" => 'transparent',	// opaque / transparent
		"showinfo" => '1',			// 0 = No, 1 = Yes
		"class" => ''
	), $atts));
	
	return '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?&amp;autoplay='.$autoplay.'&amp;rel=0&amp;fs=0&amp;showinfo='.$showinfo.'&amp;controls='.$controls.'&amp;hd='.$playhd.'&amp;wmode='.$wmode.'" frameborder="0" allowfullscreen="" class="'.$class.'"></iframe>';
}
add_shortcode('youtube', 'hg_youtube');
//---------------------------------------------------


function hg_video_button( $atts, $content = null ) {
 	//[video_button type="" video_id="" width="" height="" label=""]
	extract(shortcode_atts(array(
		"type" => '',
		"video_id" => '',
		"width" => '80%',
		"height" => '80%',
		"label" => ''
	), $atts));
	
	if($type == 'youtube') $href = 'http://www.youtube.com/embed/'.$video_id;
	elseif($type == 'vimeo') $href = 'http://vimeo.com/'.$video_id;
	
	$html = '<div class="video_trigger_container">';
	$html .= '<a class="playVideo" data-rel="prettyPhoto" href="'.$href.'?iframe=true&amp;width='.$width.'&amp;height='.$height.'"></a>';
	$html .= $label;
	$html .= '</div>';
	
	return $html;
}
add_shortcode('video_button', 'hg_video_button');
//---------------------------------------------------

/*
* ------------------------------------------------- *
*		MISC
* ------------------------------------------------- *
*/

function hg_separator( $atts, $content = null ) {
 	//[separator class=""]
	return '<div class="separator '.$atts['class'].'"></div>';
}
add_shortcode('separator', 'hg_separator');
//---------------------------------------------------

function hg_space( $atts, $content = null ) {
 	//[space height=""]
	return '<div style="height:'.$atts['height'].'px;"></div>';
}
add_shortcode('space', 'hg_space');
//---------------------------------------------------


function hg_sidegallery($atts, $content = null ) {
	//[sidegallery align="right" thumbwidth="" thumbheight="" style="" class=""] .. [/sidegallery]
	
	$GLOBALS['thumb_count'] = 0;
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
    $content = preg_replace('#<p>#', "",trim($content)); 
    $content = preg_replace('#<\/p>#', "",trim($content));
	
	extract(shortcode_atts(array(
		"align" => 'right',
		"thumbwidth" => '',
		"thumbheight" => '',
		"style" => '',
		"class" => ''
	), $atts));
	
	if( is_array( $GLOBALS['thumb'] ) ){
		foreach( $GLOBALS['thumb'] as $t => $thumb ){
			$the_thumb = JURI::base(true).'/cache/'.HgShortcodesHelper::createThumb($thumb['src'], $thumbwidth, $thumbheight,1);
			$thumbs[] = '<li><a href="'.$thumb['href'].'" '.($thumb['class'] ? 'class="'.$thumb['class'].'"':'').' '.($thumb['style'] ? 'style="'.$thumb['style'].'"':'').' data-rel="prettyPhoto"><img src="'.$the_thumb.'" class="shadow" /></a></li>';
		}
		$return = '<ul class="sidegallery '.$class.'" style="float:'.$align.'; '.$style.'" >'."\n".implode( "\n", $thumbs ).'</ul>'."\n";

	}
	return $return;
	
}
add_shortcode('sidegallery', 'hg_sidegallery'); 
//---------------------------------------------------

function hg_thumb_link($atts, $content = null ) {
	//[thumb_link type="" width="" height="" src="" class="" style="" url=""]
	// type = thumb // gallery
	
	extract(shortcode_atts(array(
		"width" => '100',
		"height" => '75',
		"src" => '',
		"style" => '',
		"class" => '',
		"url" => '',
		"type" => 'thumb'
	), $atts));
	
	$href = $url ? $url : $src;
	if($type=='gallery'){
		$x = $GLOBALS['thumb_count'];
		$GLOBALS['thumb'][$x] = array( 'href' => $href, 'src' => $src, 'style' => $style, 'class' => $class );
		$GLOBALS['thumb_count']++;
	} else {
		$thumb = JURI::base(true).'/cache/'.HgShortcodesHelper::createThumb($src, $width, $height);
		return '<a href="'.$href.'" '.($class ? 'class="'.$class.'"':'').' '.($style ? 'style="'.$style.'"':'').' data-rel="prettyPhoto"><img src="'.$thumb.'" class="shadow" /></a>';
	}
	
}
add_shortcode('thumb_link', 'hg_thumb_link');
//---------------------------------------------------


function hg_icon($atts, $content = null ) {
	//[icon src="" theme=""]
	extract(shortcode_atts(array(
		"src" => 'heart',
		"theme" => 'white' 
	), $atts));
	return '<span class="icon-'.$src.' icon-'.$theme.'"></span>';
}
add_shortcode('icon', 'hg_icon');
//---------------------------------------------------

function hg_small($atts, $content = null ) {
	//[small][/small]
	return '<small>'.$content.'</small>';
}
add_shortcode('small', 'hg_small');
//---------------------------------------------------

function hg_or( $atts, $content = null ) {
 	//[or width="" height="" text=""]
	extract(shortcode_atts(array(
		"width" => '70',
		"height" => '25',
		"text" => 'or'
	), $atts));

	return '<span class="or" style="width:'.$width.'px; height:'.$height.'px;">'.$text.'</span>';
}
add_shortcode('or', 'hg_or');
//---------------------------------------------------

function hg_clear( $atts, $content = null ) {
 	//[clear_float]

	return '<div class="clear"></div>';
}
add_shortcode('clear_float', 'hg_clear');
//---------------------------------------------------

function hg_huge_title($atts, $content = null ) {
//[huge_title fontsize="" color="" class=""] CONTENT HERE [/huge_title]

	extract(shortcode_atts(array(
		"fontsize" => '36',
		"color" => '#595959',
		"class" => ''
	), $atts));
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	
	return '<h2 class="'.$class.' hugetitle" style="font-size:'.$fontsize.'px; color:'.$color.'; ">'.$content.'</h2>';
}
add_shortcode('huge_title', 'hg_huge_title');
//---------------------------------------------------

function hg_quicksteps( $atts, $content = null ) {
 	//[quicksteps style=""]
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	return '<div class="'.$atts['style'].' fixclear">'.$content.'</div>';
}
add_shortcode('quicksteps', 'hg_quicksteps');
//---------------------------------------------------

function hg_quickstep( $atts, $content = null ) {
 	//[quickstep number="" color=""]  [/quickstep]
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	return '<div><span class="number" style="background:'.$atts['color'].'">'.$atts['number'].'</span>'.$content.'</div>';
}
add_shortcode('quickstep', 'hg_quickstep');
//---------------------------------------------------


function hg_infotext( $atts, $content = null ) {
 	// [infotext title="" style=""] ... [/infotext]
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	$html = '<h3 class="m_title" style="'.$atts['style'].'">'.$atts['title'].'</h3>';
	if($content) $html .= '<p>'.$content.'</p>';
	
	return $html;
}
add_shortcode('infotext', 'hg_infotext');
//---------------------------------------------------

function hg_circlebutton( $atts, $content = null ) {
 	// [circlebutton text="" link="" target="" size="" arrow_position="" align="" symbol=""]
	// size - small / medium / empty for normal
	// arrow_position - top-left / top-right / bottm-left / bottom-right / top / right / bottom / left
	// align - left / right (where to float the element)
	// symbol (path to symbol)
	// target - _self / _blank
	
	extract(shortcode_atts(array(
		"text" => 'TEXT HERE',
		"size" => '',
		"arrow_position" => 'top-left',
		"align" => 'right',
		"symbol" => '',
		"link" => '#',
		"target" => '_self'
	), $atts));
	
	$html = '
	<a href="'.$link.'" target="'.$target.'" class="circlehover '.($symbol ? 'with-symbol':'').'" data-size="'.$size.'" data-position="'.$arrow_position.'" data-align="'.$align.'">
		<span class="text">'.$text.'</span>
		'.($symbol ? '<span class="symbol"><img src="'.$symbol.'" alt=""></span>':'').'
	</a>';

	return $html;
}
add_shortcode('circlebutton', 'hg_circlebutton');
//---------------------------------------------------


function hg_acc( $atts, $content = null ) {
 	// [acc title="" style="" start_opened="" tweaked=""] ... [/acc]
	extract(shortcode_atts(array(
		"title" => 'Title here',
		"style" => 'default-style',
		"start_opened" => 'no',
		"tweaked" => 'no'
	), $atts));
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	$random = mt_rand();
	$html = '
	<div class="acc-group '.$style.' '.($tweaked == 'yes' ? 'tweaked':'').'">
		<button data-toggle="collapse" data-target="#acc'.$random.'" class="'.($start_opened == 'yes' ? '':'collapsed').' '.($style == 'style2' ? 'btn-link':'').'">'.$title.'</button>
		<div id="acc'.$random.'" class="collapse '.($start_opened == 'yes' ? 'out':'in').'">
			<div class="content">
				'.$content.'
			</div><!-- end content -->
		</div>
	</div><!-- end acc group -->
	';
	
	return $html;
}
add_shortcode('acc', 'hg_acc');
//---------------------------------------------------




function hg_process_box( $atts, $content = null ) {
 	// [process_box no="" arrow="" last="yes"] ...[/process_box]
	extract(shortcode_atts(array(
		"no" => '01',
		"arrow" => 'left',
		"last" => ''
	), $atts));
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$html = '
<div class="process_box '.($last == 'yes' ? 'last':'').'" data-align="'.$arrow.'">
	<div class="number"><span>'.$no.'</span></div>
	<div class="content">'.$content.'</div>
	<div class="clear"></div>
</div><!-- end process box -->
	';
	
	return $html;
}
add_shortcode('process_box', 'hg_process_box');
//---------------------------------------------------


function hg_keywordbox( $atts, $content = null ) {
 	// [keywordbox] ... [/keywordbox]
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));

	return '<div class="keywordbox">'.$content.'</div>';
}
add_shortcode('keywordbox', 'hg_keywordbox');
//---------------------------------------------------


function hg_map_link( $atts, $content = null ) {
 	// [map_link href="" title=""]
	return '<a href="'.trim($atts['href']).'" target="_blank" class="map-link"><span class="icon-map-marker icon-white"></span> '.$atts['title'].'</a>';
}
add_shortcode('map_link', 'hg_map_link');
//---------------------------------------------------


function hg_gobox( $atts, $content = null ) {
 	// [gobox featured=""] ... [/gobox]
	
	$featured = $atts['featured'];
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));

	$html = '
	<div class="gobox '.($featured == 'yes' ? 'ok': '' ).'">'.$content.'</div>
	';
	
	return $html;
}
add_shortcode('gobox', 'hg_gobox');
//---------------------------------------------------

function hg_features( $atts, $content = null ) {
 	// [features class=""] ... [/features]

	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);

	return '<ul class="features '.$atts['class'].'">'.$content.'</ul>';;
}
add_shortcode('features', 'hg_features');
//---------------------------------------------------

function hg_feature( $atts, $content = null ) {
 	// [feature class="" title=""] ... [/feature]

	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);

	return '<li class="'.$atts['class'].'"><h4>'.$atts['title'].'</h4><span>'.$content.'</span></li>';;
}
add_shortcode('feature', 'hg_feature');
//---------------------------------------------------


function hg_hoverbox( $atts, $content = null ) {
 	// [hoverbox hover="" centered="" link="" target=""] ... [/hoverbox]
	
	extract(shortcode_atts(array(
		"hover" => '#cd2122',
		"centered" => 'no',
		"link" => '#',
		"target" => '_self'
	), $atts));
	
	$random = mt_rand();
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));

	$html = '<a href="'.$link.'" target="'.$target.'" class="hover-box '.($centered == 'yes'?'centered':'').' fixclear" id="hoverbox'.$random.'">'.$content.'</a>';

	if($atts['hover']) JFactory::getDocument()->addStyleDeclaration('#hoverbox'.$random.':hover {background:'.$hover.';} ');
	
	return $html;
}
add_shortcode('hoverbox', 'hg_hoverbox');
//---------------------------------------------------


function hg_icontitle( $atts, $content = null ) {
 	// [icontitle icon="" title=""]

	return '<h3 class="mb_title">'.($atts['icon'] ? '<img src="'.$atts['icon'].'" alt="">':'').' '.$atts['title'].'</h3>';
}
add_shortcode('icontitle', 'hg_icontitle');
//---------------------------------------------------

function hg_statbox( $atts, $content = null ) {
 	// [statbox icon="" title="" number=""]
	extract(shortcode_atts(array(
		"icon" => '',
		"title" => 'Title here',
		"number" => '000'
	), $atts));
	
	return '<div class="statbox">
		'.($icon ? '<img src="'.$icon.'" alt="">':'').'
		<h4>'.$number.'</h4>
		<h6>'.$title.'</h6>
	</div>';
}
add_shortcode('statbox', 'hg_statbox');
//---------------------------------------------------


function hg_baloonbox( $atts, $content = null ) {
 	// [baloonbox fontsize=""] ... [/baloonbox]
	extract(shortcode_atts(array(
		"fontsize" => 28,
		"background" => '#767676'
	), $atts));
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    //$content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	
	return '<div class="info-text" style="font-size:'.$fontsize.'px; background:'.$background.'">'.$content.'</div>';
}
add_shortcode('baloonbox', 'hg_baloonbox');
//---------------------------------------------------


function hg_revslide( $atts, $content = null ) {
 	// [revslide transition="" bg=""] ... [/revslide]
	// boxslide / boxfade / slotzoom-horizontal / slotslide-horizontal / slotfade-horizontal / slotzoom-vertical / slotslide-vertical / slotfade-vertical / curtain-1 / curtain-2 / curtain-3 / slideleft / slideright / slideup / slidedown / fade / random / slidehorizontal / slidevertical / papercut / flyin / cube / 3dcurtain-vertical / 3dcurtain-horizontal
	
	extract(shortcode_atts(array(
		"transition" => 'fade',
		"bg" => ''
	), $atts));
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	$html = array();
	$html[] = '<li data-transition="'.$transition.'">'."";
	if($bg) $html[] = '<img src="'.$bg.'" alt="">';
	$html[] = $content;
	$html[] = '</li>';
	
	return implode("\n",$html);
}
add_shortcode('revslide', 'hg_revslide');


function hg_revobject( $atts, $content = null ) {
 	// [revobject type="" image="" url="" target="" effect="" x="" y="" speed="" start="" easing="" class="" parallax=""] ... [/revobject]
	// type - text, image
	// url
	// target
	// effect - sft - Short from Top /// sfb - Short from Bottom /// sfr - Short from Right /// sfl - Short from Left /// lft - Long from Top /// lfb - Long from Bottom /// lfr - Long from Right /// lfl - Long from Left /// fade - fading /// randomrotate- Fade in, Rotate from a Random position and Degree
	// x
	// y
	// speed
	// start
	// easing
	// class
	// parallax 
	//=> content - path of the image or content that is displayed
	
	extract(shortcode_atts(array(
		"type" => '',
		"url" => '',
		"image" => '',
		"target" => '_self',
		"effect" => 'fade',
		"x" => 0,
		"y" => 0,
		"speed" => 600,
		"start" => 700,
		"easing" => 'easeOutExpo',
		"class" => '',
		"parallax" => ''
	), $atts));
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	//$content = preg_replace('#<br \/>#', "",trim($content));
	//$content = preg_replace('#<p>#', "",trim($content));
	//$content = preg_replace('#<\/p>#', "",trim($content));
	
	$html = array();
	
	$html[] = '<div class="caption '.$effect.' '.$class.' '.($parallax ? 'para'.$parallax : '').'" data-x="'.$x.'" data-y="'.$y.'" data-speed="'.$speed.'" data-start="'.$start.'" data-easing="'.$easing.'">';
	
	if($url) $html[] = '<a href="'.$url.'" target="'.$target.'">';
	
	if($type == "image")
		$html[] = '<img src="'.$image.'" alt="">';
	elseif($type == "text")
		$html[] = $atts['text']; 
	
	if($url) $html[] = '</a>';
	
	$html[] = '</div>';
	
	return implode("\n",$html);
}
add_shortcode('revobject', 'hg_revobject');



function hg_tooltip( $atts, $content = null ) {
 	// [tooltip position="" animated="" class="" text=""] ... [/tooltip]
	// position = top / left / right / bottom
	// animated = true / false
	
	extract(shortcode_atts(array(
		"animated" => 'true',
		"position" => 'top',
		"class" => '',
		"text" => ''
	), $atts));
	
	//fix shortcode
    $content = fixshortcode($content);

	$html = '<span class="'.$class.'" data-rel="tooltip" data-placement="'.$position.'" title="'.$text.'" data-animation="'.$animated.'">'.$content.'</span>';
	
	return $html;
}
add_shortcode('tooltip', 'hg_tooltip');
//---------------------------------------------------


/*
* ------------------------------------------------- *
*		STATIC CONTENT SHORTCODES
* ------------------------------------------------- *
*/

function hg_animated_box( $atts, $content = null ) {
 	// [animated_box arrow_position="" align="" effect="" url="" target="" url_label=""] ... [/animated_box]
	// arrow_position // top / left / right / bottom
	// align // center / left / right
	// effect // fadeBoxIn / none
	
	extract(shortcode_atts(array(
		"arrow_position" => 'top',
		"align" => 'center',
		"effect" => 'fadeBoxIn',
		"url" => '',
		"target" => '_self',
		"url_label" => 'Some text'
	), $atts));
	
	//fix shortcode
    $content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));

	$html = '<div class="info_pop '.($effect != 'none' ? 'animated '.$effect : '').' '.$align.'" data-arrow="'.$arrow_position.'">';
	if($url)
    $html .= '	<a href="'.$url.'" class="buyit" target="'.$target.'">'.$url_label.'</a>';
	$html .= '	<h5 class="text">'.$content.'</h5>';
	$html .= '	<div class="clear"></div>';
	$html .= '</div>';
	
	return $html;
}
add_shortcode('animated_box', 'hg_animated_box');
//---------------------------------------------------


function hg_textpop_line( $atts, $content = null ) {
 	// [textpop_line font_size="" letter_spacing="" word_spacing="" font_weight="" style=""] ... [/textpop_line]

	extract(shortcode_atts(array(
		"font_size" => '20',
		"letter_spacing" => '0',
		"word_spacing" => '0',
		"font_weight" => 'normal',
		"style" => ''
	), $atts));
	
	//fix shortcode
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));

	$html = '<span class="textpop_line" style="font-size:'.$font_size.'px; letter-spacing: '.$letter_spacing.'px; word-spacing: '.$word_spacing.'px; font-weight:'.$font_weight.'; '.$style.'">'.$content.'</span>';
	
	return $html;
}
add_shortcode('textpop_line', 'hg_textpop_line');
//---------------------------------------------------



function hg_countdown( $atts, $content = null ) {
 	// [countdown day="" month="" year=""]
	
	extract(shortcode_atts(array(
		"day" => '1',
		"month" => '1',
		"year" => '2013'
	), $atts));
	
	$asset_path = JURI::base(true).'/templates/'.JFactory::getApplication()->getTemplate().'/addons/countdown';
	$html = array();
	$html[] = '
<div class="ud_counter">
	<ul id="Counter">
		<li>0<span>day</span></li>
		<li>00<span>hours</span></li>
		<li>00<span>min</span></li>
		<li>00<span>sec</span></li>
	</ul>
</div><!-- end counter -->';

	$js = '
	jQuery(document).ready(function(){
	var counter = {
			init: function (d) {
				jQuery("#Counter").countdown({
					until: new Date(d),
					layout: counter.layout(),
					labels: ["years", "months", "weeks", "days", "hours", "min", "sec"],
					labels1: ["year", "month", "week", "day", "hour", "nin", "sec"]
				});'."\n";
	$js .= "},
			layout: function ()	{
				return '<li>{dn}<span>{dl}</span></li>' + 
							'<li>{hnn}<span>{hl}</span></li>' + 
							'<li>{mnn}<span>{ml}</span></li>' + 
							'<li>{snn}<span>{sl}</span></li>' + 
							'<li class=\"till_lauch\"><img src=\"".$asset_path."/rocket.png\"></li>';
			}
		}"."\n";
	$js .= 'counter.init("'.date("F", mktime(0, 0, 0, $month)).' '.date("d", mktime(0, 0, 0, 0, $day)).', '.$year.'");
	});
	';
 
	
	JFactory::getDocument()->addScript($asset_path.'/jquery.countdown.js');
	JFactory::getDocument()->addScriptDeclaration($js);
	
	return implode("\n",$html);
}
add_shortcode('countdown', 'hg_countdown');
//---------------------------------------------------


/* Social Icons shortcode*/
function hg_socialicons( $atts, $content = null ) {
	// [socialicons class="" type="" style="" ][/socialicons]
	// type = normal / colored
	
	extract(shortcode_atts(array(
		"class" => '',
		"type" => 'normal'
	), $atts));
  
	//fix shortcode
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$content = preg_replace('#<ul>#', '', trim($content));
	$content = preg_replace('#<\/ul>#', '', trim($content));
	$content = preg_replace('#<li>#', "",trim($content));
	$content = preg_replace('#<\/li>#', "",trim($content));

	return '<ul class="social-icons '.$type.' '.$class.'" '.(($atts['style'] != '') ? 'style="'.$atts['style'].'"' : '').'>'.$content.'</ul>';
}
add_shortcode('socialicons', 'hg_socialicons');

/* Social Icon */
function hg_socialicon( $atts, $content = null ) {
	// [socialicon network="" url="#"]
	
	extract(shortcode_atts(array(
		"network" => 'twitter',
		"url" => '#'
	), $atts));
  
	return '<li class="social-'.$network.'"><a href="'.$url.'" target="_blank">'.$network.'</a></li>';
}
add_shortcode('socialicon', 'hg_socialicon');


function hg_line( $atts, $content = null ) {
 	// [line]
	return '<span class="line"></span>';
}
add_shortcode('line', 'hg_line');
//---------------------------------------------------

function hg_testimonial( $atts, $content = null ) {
 	// [testimonial name="" position="" style=""][/testimonial]
	
	//fix shortcode
    $content = fixshortcode($content);
    $content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	$html = '';
	if($atts['style']==2) {
	$html .= '<div class="testimonial_box4">';
	$html .= '<blockquote>'.$content.'</blockquote>';
	$html .= '<h5>'.$atts['name'].' '.($atts['position'] ? ' // '.$atts['position']:'').'</h5>';
	$html .= '</div>';
	} else {
	$html .= '<blockquote>';
	$html .= '<p>'.$content.'</p>';
	$html .= '<small>'.$atts['name'].' '.($atts['position'] ? '- <cite>'.$atts['position'].'</cite>':'').'</small>';
	$html .= '</blockquote>';
	}
	return $html;
}
add_shortcode('testimonial', 'hg_testimonial');
//---------------------------------------------------



function hg_timeline( $atts, $content = null ) {
 	// [timeline] .. [/timeline]
	//fix shortcode
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$html = array();
	$html[] = '<div class="row">';
	$html[] = '  <div class="span12 timeline_bar">';
	$html[] = '    <div class="row">'.$content.'</div>';
	$html[] = '  </div>';
	$html[] = '</div>';

	return implode("\n",$html);
}
add_shortcode('timeline', 'hg_timeline');
//---------------------------------------------------


function hg_timeline_box( $atts, $content = null ) {
 	// [timeline_box year="" align="" title=""] ... [/timeline_box]
	//fix shortcode
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	$content = preg_replace('#<br \/>#', "",trim($content));
	$content = preg_replace('#<p>#', "",trim($content));
	$content = preg_replace('#<\/p>#', "",trim($content));
	
	extract(shortcode_atts(array(
		"year" => '',
		"align" => 'left',
		"title" => ''
	), $atts));
	$edge = ($align == 'top' || $align == 'bottom') ? true : false;
	$html = array();
	$html[] = '<div class="span'.($edge ? '12 end_timeline':'6').' '.($align == 'right' ? 'offset6" data-align="right"':'"').'>';
	if($edge) {
		$html[] = '  <span>'.$year.($year ? ' &rsaquo; ':'').$title.'</span>';
	} else {
		$html[] = '  <div class="timeline_box">';
		$html[] = '    <div class="date">'.$year.'</div>';
		$html[] = '    <h4 class="htitle">'.$title.'</h4>';
		$html[] = '    <p>'.$content.'</p>';
		$html[] = '  </div>';
	}
	$html[] = '</div>';

	return implode("\n",$html);
}
add_shortcode('timeline_box', 'hg_timeline_box');
//---------------------------------------------------


function hg_error( $atts, $content = null ) {
 	// [error code=""]...[/error]
	//fix shortcode
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	
	$html = array();
	$html[] = '<div class="row">';
	$html[] = '  <div class="span12">';
	$html[] = '    <div class="error404">';
	$html[] = '    <h2><span>'.$atts['code'].'</span></h2>';
	$html[] = '    <h3>'.$content.'</h3>';
	$html[] = '    </div>';
	$html[] = '  </div>';
	$html[] = '</div>';

	return implode("\n",$html);
}
add_shortcode('error', 'hg_error');
//---------------------------------------------------


function hg_alert( $atts, $content = null ) {
 	// [alert type=""]...[/alert]
	// info, success, danger, error
	
	$content = wpautop(do_shortcode($content));	
    $content = fixshortcode($content);
	
	extract(shortcode_atts(array("type" => 'info'), $atts));
	return '<div class="alert alert-'.$atts['type'].'">'.$content.'</div>';
}
add_shortcode('alert', 'hg_alert');
//---------------------------------------------------

function hg_prettyprint_script( $atts, $content = null ) {
 	// [prettyprint_script]
	$tpath = JURI::base(true).'/templates/'.JFactory::getApplication()->getTemplate();
	$doc = JFactory::getDocument();
	$doc->addStyleSheet($tpath.'/addons/prettify-code/prettify.css');
	$doc->addScript($tpath.'/addons/prettify-code/prettify.js');
	$doc->addScriptDeclaration(' jQuery(window).load(function(){ prettyPrint(); });	');
}
add_shortcode('prettyprint_script', 'hg_prettyprint_script');
//---------------------------------------------------


function hg_loadstyle( $atts, $content = null ) {
 	// [loadstyle styles=""]
	$doc = JFactory::getDocument();
	$doc->addStyleDeclaration($atts['styles']);
}
add_shortcode('loadstyle', 'hg_loadstyle');
//---------------------------------------------------
