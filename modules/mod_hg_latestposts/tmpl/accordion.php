<?php
/**
 * Style 4
 */

// no direct access
defined('_JEXEC') or die;
JLoader::register('JHtmlString', JPATH_LIBRARIES.'/joomla/html/html/string.php');

$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
$countRows = count($list);
?>
<div class="row latest_posts acc-style <?php echo $moduleclass_sfx; ?>">
<div class="span<?php echo $parentGrid; ?>">
<?php if($params->get('mod_title')): ?>
	<h3 class="m_title"><?php echo $params->get('mod_title'); ?></h3>
<?php endif; ?>

<?php if($params->get('link_label')):
	echo '<a href="'.JRoute::_('index.php?Itemid='.$params->get('link')).'" class="viewall">'.$params->get('link_label').'</a>';
endif; ?>
	<div class="css3accordion ">
		<ul>
	<?php foreach ($list as $k => $item) :
		$images = json_decode($item->images);
		?>
		
			<li <?php echo (count($list) == $k+1) ? 'class="last"':''; ?>>
				<div class="inner-acc">
					<a href="<?php echo $item->link; ?>" class="thumb hoverBorder plus">
						<img src="<?php echo $images->image_intro; ?>" alt="<?php echo $item->title; ?>">
					</a>
					<div class="content">
						<em><?php
						echo JHtml::_('date', $item->publish_up, JText::_('TPL_KALLYAS_MOD_LPOSTS_DATE_FORMAT_LP')).' '.
						JText::sprintf('TPL_KALLYAS_MOD_LPOSTS_WRITTEN_BY', $item->author). ', ' .
						JText::sprintf('TPL_KALLYAS_MOD_LPOSTS_CONTENT_PARENT', $item->category_title); 
						?></em>
						<h5 class="m_title"><?php echo $item->title; ?></h5>
						<div class="text"><?php echo JHtmlString::truncate($item->introtext, $params->get('introtext_limit',100), true, false); ?></div>
						<a href="<?php echo $item->link; ?>"><?php echo JText::_('TPL_KALLYAS_MOD_LPOSTS_READMORE'); ?></a>
					</div>
				</div>
			</li>

	<?php endforeach; ?>
		</ul>
	</div><!-- end CSS3 Accordion -->
</div>
</div>