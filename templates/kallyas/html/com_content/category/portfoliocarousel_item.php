<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Create a shortcut for params.
$params = &$this->item->params;
$images = json_decode($this->item->images);
$canEdit	= $this->item->params->get('access-edit');
$cache_folder = JURI::base(true).'/cache/';
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
//JHtml::core();

require_once dirname(__FILE__).'/../../..'.'/lib/image_helper.php';

$template_path = JURI::base().'templates/'.JFactory::getApplication()->getTemplate();
$cr_width = 570; // carousel width
$cr_height = 356; // carousel height
$ptparams = new JRegistry($this->item->attribs);
$pt_image = $ptparams->get('pt_image');
if($pt_image) $pt_image = kallyasImageHelper::createThumb($pt_image, $cr_width, $cr_height);

$url_type = $ptparams->get('pt_urltype');
$rel = '';
$target = '';

$doc =& JFactory::getDocument();
$css = '.rhinoslider {width:'.$cr_width.'px; height:'.$cr_height.'px;}';
$doc->addStyleDeclaration($css); 


$pt_other = array(
	array($ptparams->get('pt_image_01'), $ptparams->get('pt_media_01')),
	array($ptparams->get('pt_image_02'), $ptparams->get('pt_media_02')),
	array($ptparams->get('pt_image_03'), $ptparams->get('pt_media_03')),
	array($ptparams->get('pt_image_04'), $ptparams->get('pt_media_04')),
	array($ptparams->get('pt_image_05'), $ptparams->get('pt_media_05')),
	array($ptparams->get('pt_image_06'), $ptparams->get('pt_media_06')),
	array($ptparams->get('pt_image_07'), $ptparams->get('pt_media_07')),
	array($ptparams->get('pt_image_08'), $ptparams->get('pt_media_08')),
	array($ptparams->get('pt_image_09'), $ptparams->get('pt_media_09')),
	array($ptparams->get('pt_image_10'), $ptparams->get('pt_media_10')),
);


if ($params->get('access-view')) :
	$itemlink = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
else :
	$menu = JFactory::getApplication()->getMenu();
	$active = $menu->getActive();
	$itemId = $active->id;
	$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
	$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
	$itemlink = new JURI($link1);
	$itemlink->setVar('return', base64_encode($returnURL));
endif;

if ($url_type != 5) :
	// if 0 - Portfolio item page
	if($url_type == 0){
		$link = $itemlink;
	}// if 0 (normal link)
	else if($url_type == 1){
		$link = ($ptparams->get('pt_image_full')) ? $ptparams->get('pt_image_full') : $cache_folder.$pt_image;
		$rel = 'data-rel="prettyPhoto"';
	}//if 1 (lightbox image)
	else if($url_type == 2){
		$link = 'http://www.youtube.com/watch?v='.$ptparams->get('pt_videoid');
		$rel = 'data-rel="prettyPhoto"';
	}//if 2 (youtube)
	else if($url_type == 3){
		$link = 'http://www.vimeo.com/'.$ptparams->get('pt_videoid');
		$rel = 'data-rel="prettyPhoto"';
	}//if 3 (vimeo)
	else if($url_type == 4){
		$link = $ptparams->get('pt_url');
		$target = 'target="_blank"';
	}//if 4 (external)
endif;

?>

<?php if ($this->item->state == 0) : ?>
<div class="system-unpublished">
<?php endif; ?>

<div class="inner-item">

<div class="span6">
<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>

<?php echo $this->item->event->beforeDisplayContent; ?>

<div class="ptcontent">
	<?php if ($params->get('show_title')) : ?>
        <h3 class="title">
            <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
                
                <a href="<?php echo $itemlink; ?>"><?php echo $this->escape($this->item->title); ?></a>
                
            <?php else : ?>
                <?php echo $this->escape($this->item->title); ?>
            <?php endif; ?>
        </h3>
    <?php endif; ?>
    
    <div class="pt-cat-desc">
        <?php echo $this->item->introtext; ?>
    </div>
    <div class="itemLinks">
        <?php
		$pt_livepreview = $ptparams->get('pt_livepreview');
		if($pt_livepreview) echo '<span><a href="'.$pt_livepreview.'" target="_blank" >'.JText::_('TPL_KALLYAS_PORTFOLIO_CAROUSEL_LIVE_PREVIEW').' '.str_replace('http:','',str_replace('/','',$pt_livepreview)).'</a></span>'; ?>
        <span class="seemore"><a href="<?php echo $itemlink; ?>" ><?php echo JText::_('TPL_KALLYAS_PORTFOLIO_CAROUSEL_SEE_MORE') ;?></a></span>
    </div>
</div><!-- end ptcontent -->
</div>
<div class="span6">
	<div class="ptcarousel">
		<div class="controls">
			<a href="#" class="prev"><span class="icon-chevron-left icon-white"></span></a>
			<a href="#" class="next"><span class="icon-chevron-right icon-white"></span></a>
		</div>
		<ul id="ptcarousel<?php echo $this->item->id ?>" class="">
		
		<li>
		<?php if ($params->get('access-view') && $url_type != 5) { ?>
			<a href="<?php echo $link; ?>" <?php echo $rel; ?> <?php echo $target; ?>>
			
			<?php } ?>
				<img src="<?php echo $cache_folder.$pt_image; ?>" alt="<?php echo $this->escape($this->item->title); ?>"/>
			<?php if ($params->get('access-view') && $url_type != 5) { ?>
			</a>
		<?php } ?>
		</li>
		
	<?php
	foreach($pt_other as $other){
		
		if($other[0] || $other[1]) {
			echo '<li>';
			if($other[0]) {
				$ot_image = kallyasImageHelper::createThumb($other[0], $cr_width, $cr_height, 1);
				echo '
				<a href="'.$other[0].'" rel="prettyPhoto">
					<img src="'.$cache_folder.$ot_image.'" alt="'.$this->escape($this->item->title).'" />
				</a>';
			} else if($other[1]) {
				if(is_numeric($other[1])) {
					echo '<iframe src="http://player.vimeo.com/video/'.$other[1].'?title=0&amp;byline=0&amp;portrait=0" width="'.$cr_width.'" height="'.$cr_height.'" frameborder="0" webkitallowfullscreen="" allowfullscreen=""></iframe>';
				} else {
					echo '<iframe src="http://www.youtube.com/embed/'.$other[1].'?wmode=transparent&amp;rel=0" width="'.$cr_width.'" height="'.$cr_height.'" frameborder="0" webkitallowfullscreen="" allowfullscreen=""></iframe>';
				}
			}
			echo '</li>';
		}
	}
	?>
		</ul>
	</div><!-- end ptcarousel -->
</div>
<div class="clear"></div>

</div>

<?php if ($this->item->state == 0) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>
