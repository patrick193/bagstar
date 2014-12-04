<?php
/**
 * Style 1
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="row latest_posts default-style <?php echo $moduleclass_sfx; ?>">

<?php if($params->get('mod_title')): ?>
	<div class="span<?php echo $parentGrid; ?>">
		<h3 class="m_title"><?php echo $params->get('mod_title'); ?></h3>
	</div>
<?php endif; ?>

	<?php foreach ($list as $item) :
		$images = json_decode($item->images);
		?>
		
		<div class="span<?php echo $boxSize; ?> post">
			<a href="<?php echo $item->link; ?>" class="hoverBorder plus">
				<img src="<?php echo $images->image_intro; ?>" alt="<?php echo $item->title; ?>">
				<h6><?php echo JText::_('TPL_KALLYAS_MOD_LPOSTS_READMORE'); ?></h6>
			</a>
			<em><?php
			echo JHtml::_('date', $item->publish_up, JText::_('TPL_KALLYAS_MOD_LPOSTS_DATE_FORMAT_LP')).' '.
			JText::sprintf('TPL_KALLYAS_MOD_LPOSTS_WRITTEN_BY', $item->author). ', ' .
			JText::sprintf('TPL_KALLYAS_MOD_LPOSTS_CONTENT_PARENT', $item->category_title); 
			?></em>
			<h3 class="m_title"><?php echo $item->title; ?></h3>
		</div><!-- end span -->

	<?php endforeach; ?>

</div>