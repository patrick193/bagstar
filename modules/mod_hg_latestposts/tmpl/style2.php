<?php
/**
 * Style 2
 */

// no direct access
defined('_JEXEC') or die;
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
//print_r($list);

JLoader::register('JHtmlString', JPATH_LIBRARIES.'/joomla/html/html/string.php');
$document =& JFactory::getDocument();
if($module->showtitle != 0 )
	$document->addStyleDeclaration('.latest_posts.style2 .viewall {top:-25px;}');
?>

<div class="row latest_posts style2 <?php echo $moduleclass_sfx; ?>">
<div class="span<?php echo $parentGrid; ?>">
<?php if($params->get('mod_title')): ?>
	<h3 class="m_title"><?php echo $params->get('mod_title'); ?></h3>
<?php endif; ?>

<?php if($params->get('link_label')):
	echo '<a href="'.JRoute::_('index.php?Itemid='.$params->get('link')).'" class="viewall">'.$params->get('link_label').'</a>';
endif; ?>
	<ul class="posts">
	<?php foreach ($list as $item) : ?>
	
		<li class="post">
			<div class="details">
				<span class="date"><?php echo JHtml::_('date', $item->publish_up, JText::_('TPL_KALLYAS_MOD_LPOSTS_DATE_FORMAT_LP2')); ?></span>
				<span class="cat"><?php echo JText::sprintf('TPL_KALLYAS_MOD_LPOSTS_CONTENT_PARENT', $item->category_title); ?></span>
			</div>
			<h4 class="title"><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h4>
			<div class="text"><?php echo JHtmlString::truncate($item->introtext, $params->get('introtext_limit',200), true, false); ?></div>
		</li>

	<?php endforeach; ?>
	</ul>
</div>
</div><!-- end // latest posts style 2 -->