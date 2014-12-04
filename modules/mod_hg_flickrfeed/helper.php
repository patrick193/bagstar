<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class modFlickrFeedHelper {
	
	function attr($s,$attrname) { // return html attribute
		preg_match_all('#\s*('.$attrname.')\s*=\s*["|\']([^"\']*)["|\']\s*#i', $s, $x);
		if (count($x)>=3) return $x[2][0]; else return "";
	}
	
	function url2_get_contents($Url) {
		$output = '';
		if (function_exists('curl_init')){ 
			//die('CURL is not installed!');
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $Url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);
		} else {
			$output = 'cURL is not installed on your server, this module will not work unless you install it.';
		}
		return $output;
	}
	
	// id = id of the feed
	// n = number of thumbs
	function parseFlickrFeed($id,$n,$w) {
		$url = "http://api.flickr.com/services/feeds/photos_public.gne?id={$id}&lang=en-gb&format=rss_200";
		$s = self::url2_get_contents($url);
		preg_match_all('#<item>(.*)</item>#Us', $s, $items);
		$out = "";
		for($i=0;$i<count($items[1]);$i++) {
			if($i>=$n) return $out;
			$item = $items[1][$i];
			preg_match_all('#<link>(.*)</link>#Us', $item, $temp);
			$link = $temp[1][0];
			preg_match_all('#<title>(.*)</title>#Us', $item, $temp);
			$title = $temp[1][0];
			preg_match_all('#<media:content([^>]*)>#Us', $item, $temp);
			$imglink = self::attr($temp[0][0],"url");
			preg_match_all('#<media:thumbnail([^>]*)>#Us', $item, $temp);
			$thumb = self::attr($temp[0][0],"url");
			
			$out.="<li><a href=\"".$imglink."\" target='_blank' rel=\"prettyPhoto[flickr]\" title=\"".str_replace('"','',$title)."\"><img src='$thumb'/><span class=\"theHoverBorder \"></span></a></li>";
		}
		return $out;
	}
}