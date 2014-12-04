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
$ptparams = new JRegistry($this->item->attribs);
$pt_image = $ptparams->get('pt_image');
if($pt_image) $ptThumb = kallyasImageHelper::createThumb($pt_image, 260, '');

$url_type = $ptparams->get('pt_urltype');
$rel = '';
$target = '';

$doc =& JFactory::getDocument();

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
		$datatype = 'data-type="link"';
	}// if 0 (normal link)
	else if($url_type == 1){
		$link = ($ptparams->get('pt_image_full')) ? $ptparams->get('pt_image_full') : $pt_image;
		$rel = 'data-rel="prettyPhoto"';
		$datatype = 'data-type="image"';
	}//if 1 (lightbox image)
	else if($url_type == 2){
		$link = 'http://www.youtube.com/watch?v='.$ptparams->get('pt_videoid');
		$rel = 'data-rel="prettyPhoto"';
		$datatype = 'data-type="video"';
	}//if 2 (youtube)
	else if($url_type == 3){
		$link = 'http://www.vimeo.com/'.$ptparams->get('pt_videoid');
		$rel = 'data-rel="prettyPhoto"';
		$datatype = 'data-type="video"';
	}//if 3 (vimeo)
	else if($url_type == 4){
		$link = $ptparams->get('pt_url');
		$target = 'target="_blank"';
		$datatype = 'data-type="extlink"';
	}//if 4 (external)
endif;

?>

<?php if ($this->item->state == 0) : ?>
<div class="system-unpublished">
<?php endif; ?>

<div class="inner-item">

<?php if ($params->get('access-view') && $url_type != 5) { ?>
    <a href="<?php echo $link; ?>" <?php echo $rel; ?> <?php echo $target; ?> <?php echo $datatype; ?> class="hoverLink" >
    <?php } ?>
        <img src="<?php echo $cache_folder.$ptThumb; ?>" alt="<?php echo $this->escape($this->item->title); ?>"/>
    <?php if ($params->get('access-view') && $url_type != 5) { ?>
    </a>
<?php } ?>
    
<?php if ($params->get('show_title')) : ?>
	<h4 class="title">
		<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
			
			<a href="<?php echo $link; ?>"><span class="name"><?php echo $this->escape($this->item->title); ?></span></a>
			
		<?php else : ?>
			<?php echo '<span class="name">'.$this->escape($this->item->title).'</span>'; ?>
		<?php endif; ?>
	</h4>
<?php endif;

    if($this->item->introtext) { ?>
    <span class="moduleDesc">
        <?php echo $this->item->introtext; ?>
    </span>
	<?php } ?>
	<div class="clear"></div>

</div>

<?php if ($this->item->state == 0) : ?>
</div>
<?php endif; ?>