<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once dirname(__FILE__).'/helper.php';

$limit = $params->get('limit');
$flickrid = $params->get('flickrid');
$follow_text = $params->get('follow_text');
$follow_link = $params->get('follow_link');
$width = $params->get('width',60);

$mid = $module->id;
$doc =& JFactory::getDocument();

$doc->addStyleDeclaration('.flickr_feeds li a {width: '.$width.'px}');

?>
<div class="flickrfeed">
	<ul class="flickr_feeds fixclear">
<?php

// usage example:
echo modFlickrFeedHelper::parseFlickrFeed($flickrid, $limit, $width);
// you have to use css to customize it

?>
</ul>
<?php
if($follow_text != '')
	echo '<a href="'.$follow_link.'" target="_blank" title="'.$follow_text.'" class="followUs">'.$follow_text.'</a>';
?>
</div><!-- end // flickrfeed -->