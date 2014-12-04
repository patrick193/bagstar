<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
$doc =& JFactory::getDocument();
$template_path = JURI::base().'templates/'.JFactory::getApplication()->getTemplate();


$checkcarouFredSel = false;
$header = $doc->getHeadData();
foreach($header['scripts'] as $scriptName => $scriptData)
	if(substr_count($scriptName,'/jquery.carouFredSel'))
		$checkcarouFredSel = true;

if(!$checkcarouFredSel) 
$doc->addScript($template_path."/addons/caroufredsel/jquery.carouFredSel.js");

?>
<div class="blog hg-portfolio-carousel <?php echo $this->pageclass_sfx;?>">

	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1 class="title">
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
	<h2>
		<?php echo $this->escape($this->params->get('page_subheading')); ?>
		<?php if ($this->params->get('show_category_title')) : ?>
			<span class="subheading-category"><?php echo $this->category->title;?></span>
		<?php endif; ?>
	</h2>
	<?php endif; ?>

	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
        <div class="category-desc">
        <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
            <img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
        <?php endif; ?>
        <?php if ($this->params->get('show_description') && $this->category->description) : ?>
            <?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
        <?php endif; ?>
        <div class="clr"></div>
        </div>
    <?php endif; ?>



<?php $leadingcount=0 ; ?>
<?php if (!empty($this->lead_items)) : ?>
<div class="items-leading">
	<?php foreach ($this->lead_items as &$item) : ?>
		<div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
			<?php
				$this->item = &$item;
				echo $this->loadTemplate('item');
			?>
		</div>
		<?php
			$leadingcount++;
		?>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<?php
	$introcount=(count($this->intro_items));
	$counter=0;
?>
<?php if (!empty($this->intro_items)) : ?>
	
	<?php
	
	$rowz = count($this->intro_items);
	$sid = '';
	foreach ($this->intro_items as $key => &$item) : ?>
	<?php
		$key= ($key-$leadingcount)+1;
		$this->columns = 1;
		
		$rowcount=( ((int)$key-1) %	(int) $this->columns) +1;
		$row = $counter / $this->columns ;

		if ($rowcount==1) : ?>
	<div class="items-row row clearfix">
	<?php endif; ?>
	<div class="item column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
		<?php
			$this->item = &$item;
			$sid .= (($key == 1) ? '' : ',').'#ptcarousel'.$this->item->id;
			echo $this->loadTemplate('item');
			
		?>
	</div>
	<?php $counter++; ?>
	<?php if (($rowcount == $this->columns) or ($counter ==$introcount)): ?>
				<div class="clear"></div>
				<hr />
                    
				</div>

			<?php endif; ?>
	<?php endforeach;

$js = '
;(function($) {
	$(window).load(function(){
		// ** Portfolio Carousel
		var carousels = $("'.$sid.'");
		carousels.each(function(index, element) {
			$(this).carouFredSel({
				responsive: true,
				items: { width: 570 },
				'.($this->params->get('showControls',1) ? '
				prev	: {	button : $(this).parent().find("a.prev"), key : "left" },
				next	: { button : $(this).parent().find("a.next"), key : "right" },
				':'').'
				auto: '.($this->params->get('autoPlay') ? '{timeoutDuration: '.$this->params->get('showTime',5000).'}':'false').',
				scroll: { fx: "'.$this->params->get('slider_effect','crossfade').'", duration: "'.$this->params->get('effectTime',1500).'" }
			});	
		});
		// *** end Portfolio Carousel
	});
})(jQuery);
';
$doc->addScriptDeclaration($js);
?>


<?php endif; ?>

<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination">
						<?php  if ($this->params->def('show_pagination_results', 1)) : ?>
						<p class="counter">
								<?php echo $this->pagination->getPagesCounter(); ?>
						</p>

				<?php endif; ?>
				<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
<?php  endif; ?>

</div>
