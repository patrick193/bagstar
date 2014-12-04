<?php
/**
 * Zauan Shortcodes 
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
 
$shortcode_tags = array();

function add_shortcode($tag, $func) {
        global $shortcode_tags;
        if ( is_callable($func) )
                $shortcode_tags[$tag] = $func;
}

function remove_shortcode($tag) {
        global $shortcode_tags;
        unset($shortcode_tags[$tag]);
}

function remove_all_shortcodes() {
        global $shortcode_tags;
        $shortcode_tags = array();
}

function do_shortcode($content) {
        global $shortcode_tags;
        if (empty($shortcode_tags) || !is_array($shortcode_tags))
                return $content;
        $pattern = get_shortcode_regex();
        return preg_replace_callback('/'.$pattern.'/s', 'do_shortcode_tag', $content);
}

function get_shortcode_regex() {
        global $shortcode_tags;
        $tagnames = array_keys($shortcode_tags);
        $tagregexp = join( '|', array_map('preg_quote', $tagnames) );
        return '(.?)\[('.$tagregexp.')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
}

function do_shortcode_tag( $m ) {
        global $shortcode_tags;
        // allow [[foo]] syntax for escaping a tag
        if ( $m[1] == '[' && $m[6] == ']' ) {
                return substr($m[0], 1, -1);
        }
        $tag = $m[2];
        $attr = shortcode_parse_atts( $m[3] );
        if ( isset( $m[5] ) ) {
                // enclosing tag - extra parameter
                return $m[1] . call_user_func( $shortcode_tags[$tag], $attr, $m[5], $tag ) . $m[6];
        } else {
                // self-closing tag
                return $m[1] . call_user_func( $shortcode_tags[$tag], $attr, NULL,  $tag ) . $m[6];
        }
}

function shortcode_parse_atts($text) {
        $atts = array();
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
        if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
                foreach ($match as $m) {
                        if (!empty($m[1]))
                                $atts[strtolower($m[1])] = stripcslashes($m[2]);
                        elseif (!empty($m[3]))
                                $atts[strtolower($m[3])] = stripcslashes($m[4]);
                        elseif (!empty($m[5]))
                                $atts[strtolower($m[5])] = stripcslashes($m[6]);
                        elseif (isset($m[7]) and strlen($m[7]))
                                $atts[] = stripcslashes($m[7]);
                        elseif (isset($m[8]))
                                $atts[] = stripcslashes($m[8]);
                }
        } else {
                $atts = ltrim($text);
        }
        return $atts;
}

function shortcode_atts($pairs, $atts) {
        $atts = (array)$atts;
        $out = array();
        foreach($pairs as $name => $default) {
                if ( array_key_exists($name, $atts) )
                        $out[$name] = $atts[$name];
                else
                        $out[$name] = $default;
        }
        return $out;
}

function strip_shortcodes( $content ) {
        global $shortcode_tags;
        if (empty($shortcode_tags) || !is_array($shortcode_tags))
                return $content;
        $pattern = get_shortcode_regex();
        return preg_replace('/'.$pattern.'/s', '$1$6', $content);
}

/*
* ------------------------------------------------- *
*		Fix shortcodes
* ------------------------------------------------- *
*/

function fixshortcode($content){

     //fix

	//remove invalid p
	$content = preg_replace('#^<\/p>|<p>$#', '', trim($content));
	
	//fix line shortcode
     $content = preg_replace('#<p>\n<div class="line top #', '<div class="line top ', trim($content));


    $content = preg_replace('#<p>\n<div class="line"><span class="top">[top]</span></div>\n</p>#', '<div class="line"><span class="top">[top]</span></div>', trim($content)); 
    $content = preg_replace('#<p>\n<div class="line"></div>\n</p>#', '<div class="line"></div>', trim($content)); 
    $content = preg_replace('#<p>\n<div class="line">#', '<div class="line">', trim($content));
    $content = preg_replace('#<p>\n<div class="line">#', '<div class="line">', trim($content));
   
	return $content;
}


function shortcode_unautop($pee) {
	global $shortcode_tags;

	if ( !empty($shortcode_tags) && is_array($shortcode_tags) ) {
		$tagnames = array_keys($shortcode_tags);
		$tagregexp = join( '|', array_map('preg_quote', $tagnames) );
		$pee = preg_replace('/<p>\\s*?(\\[(' . $tagregexp . ')\\b.*?\\/?\\](?:.+?\\[\\/\\2\\])?)\\s*<\\/p>/s', '$1', $pee);
	}

	return $pee;
}



function clean_pre($matches) {
        if ( is_array($matches) )
                $text = $matches[1] . $matches[2] . "</pre>";
        else
                $text = $matches;
        $text = str_replace('<br />', '', $text);
        $text = str_replace('<p>', "\n", $text);
        $text = str_replace('</p>', '', $text);
        return $text;
}

function wpautop($pee) {
        if ( trim($pee) === '' )
                return '';
        $pee = $pee . "\n"; // just to make things a little easier, pad the end
        $pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
        // Space things out a little
        $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
        $pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
        $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
        $pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
        if ( strpos($pee, '<object') !== false ) {
                $pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
                $pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
        }
        $pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
        // make paragraphs, including one at the end
        $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
        $pee = '';
        foreach ( $pees as $tinkle )
                //$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
				$pee .= trim($tinkle, "\n")."\n";
        $pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
        $pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
        $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
        $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
        $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
        $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
        if (strpos($pee, '<pre') !== false)
                $pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee );
        $pee = preg_replace( "|\n</p>$|", '</p>', $pee );
		
		$vals = array ('<p>[' => '[', ']</p>' => ']', ']<br />' => ']');
		$pee = strtr($pee, $vals);
		
        return $pee;
}


// Import the shortcodes in the current theme if the file exists
$shortcode_template = JPATH_THEMES.DS.JFactory::getApplication()->getTemplate().DS.'custom/shortcodes.php';

if (file_exists($shortcode_template)) {
    require_once($shortcode_template);
} 



?>
