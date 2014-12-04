<?php
/**
 * Style 3
 */

// no direct access
defined('_JEXEC') or die;
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
//print_r($list);

JLoader::register('JHtmlString', JPATH_LIBRARIES.'/joomla/html/html/string.php');

$document =& JFactory::getDocument();
if($module->showtitle != 0 )
	$document->addStyleDeclaration('.latest_posts.style3 .viewall {top:-25px;}');
?>

<div class="row latest_posts style3 <?php echo $moduleclass_sfx; ?>">
<div class="span<?php echo $parentGrid; ?>">
<?php if($params->get('mod_title')): ?>
	<h3 class="m_title"><?php echo $params->get('mod_title'); ?></h3>
<?php endif; ?>

<?php if($params->get('link_label')):
	echo '<a href="'.JRoute::_('index.php?Itemid='.$params->get('link')).'" class="viewall">'.$params->get('link_label').'</a>';
endif; ?>
	<ul class="posts">
	<?php foreach ($list as $item) : ?>
	<?php
	$images = json_decode($item->images);
	$thumb = JURI::base(true).'/cache/'.modHGLatestPostsHelper::createThumb($images->image_intro, 54, 54, 3, true);
	?>
		<li class="post">
			<a href="#" class="hoverBorder pull-left"><img src="<?php echo $thumb; ?>" alt="<?php echo $item->title; ?>"></a>
			<h4 class="title"><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h4>
			<div class="text"><?php echo JHtmlString::truncate($item->introtext, $params->get('introtext_limit',200), true, false); ?></div>
		</li>

	<?php endforeach; ?>
	</ul>
</div>
</div><!-- end // latest posts style 2 -->