<?php

// no direct access
defined('_JEXEC') or die;

$mid = $module->id;
$document = JFactory::getDocument(); 
$modpath = JURI::base(true).'/modules/mod_hg_staticcontent';

$video_type = $params->get('video_type');
$basepath = JURI::base().'images/videos/';
$videobg_image = $params->get('videobg_image') != '-1' ? $basepath.$params->get('videobg_image') :'';
$videobg_mp4 = $params->get('videobg_mp4') != '-1' ? $basepath.$params->get('videobg_mp4') :'';
$videobg_webm = $params->get('videobg_webm') != '-1' ? $basepath.$params->get('videobg_webm') :'';
$videobg_ogg = $params->get('videobg_ogg') != '-1' ? $basepath.$params->get('videobg_ogg') :'';
$videobg_flv = $params->get('videobg_flv') != '-1' ? $basepath.$params->get('videobg_flv') :'';

$container_height = $params->get('videobg_containerheight');
$width = $params->get('videobg_width');
$height = $params->get('videobg_hwight');
$autoplay = $params->get('videobg_autoplay',1);
$controls = $params->get('videobg_controls',1);
$loop = $params->get('videobg_loop',1);

$captions = preg_split('/\n|\r/', $params->get('videobg_captions'), -1, PREG_SPLIT_NO_EMPTY);
$css = '#video-container'.$mid.' {height:'.$container_height.';}';
$css .= '#video-container'.$mid.' #the-video, #video-container'.$mid.' #the-video img {width:'.$width.'; height:'.$height.';}';
$css .= '#video-container'.$mid.' #the-video.extplayer { height: '.$container_height.';}';
$ipad = (strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')) ? true : false;
if($ipad) $css .= '#video-container'.$mid.' #the-video, #video-container'.$mid.' #the-video img { height:'.$container_height.';}';

$document->addStyleDeclaration($css);
?>

<div class="video-container" id="video-container<?php echo $mid ?>">
	
	<?php
	switch($video_type) {

		case"self_hosted": ?>
	
	<!-- "Video For Everybody" http://camendesign.com/code/video_for_everybody -->
	<video <?php echo $autoplay ? 'autoplay':''; ?> <?php echo ($controls or $ipad) ? 'controls':''; ?> <?php echo $loop ? 'loop':''; ?> poster="<?php echo $videobg_image ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" id="the-video" class="video" preload="none">
		<?php echo $videobg_mp4 ? '<source src="'.$videobg_mp4.'" type="video/mp4; codecs=\'avc1.4D401E, mp4a.40.2\'" />':''; ?>
		<?php echo $videobg_webm ? '<source src="'.$videobg_webm.'" type="video/webm; codecs=\'vp8.0, vorbis\'" />':''; ?>
		<?php echo $videobg_ogg ? '<source src="'.$videobg_ogg.'" type="video/ogg; " />':''; ?>
		<object type="application/x-shockwave-flash" data="http://flashfox.googlecode.com/svn/trunk/flashfox.swf" width="<?php echo $width; ?>" height="<?php echo $container_height; ?>">
			<param name="movie" value="http://flashfox.googlecode.com/svn/trunk/flashfox.swf" />
			<param name="allowFullScreen" value="true" />
			<param name="wmode" value="transparent" />
			<param name="flashVars" value="<?php echo ($controls) ? 'controls=true&amp;':''; ?>poster=<?php echo $videobg_image ?>&amp;src=<?php echo $videobg_flv; ?>" />
			<img alt="" src="<?php echo $videobg_image ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" title="No video playback capabilities, please download the video below" />
		</object>
	</video>
	
		<?php break;
	
		case"youtube": ?>
	
	<iframe id="the-video" class="extplayer" width="<?php echo $width; ?>" src="http://www.youtube.com/embed/<?php echo $params->get('youtubeid'); ?>?&amp;autoplay=1&amp;rel=0&amp;fs=0&amp;showinfo=0&amp;controls=0&amp;hd=1&amp;wmode=transparent&amp;version=2" frameborder="0" allowfullscreen></iframe>
	
		<?php break;
	
	
		case"vimeo": ?>
	
	 <iframe id="the-video" class="extplayer" width="<?php echo $width; ?>" src="http://player.vimeo.com/video/<?php echo $params->get('vimeoid'); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=000000" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	
		<?php break;
		
	} ?>
	
	<div class="captions">
		<?php foreach($captions as $caption) {
			echo '<span class="line">'.$caption.'</span>';
			
		} ?>
	</div>					
</div>
