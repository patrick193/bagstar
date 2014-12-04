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
$doc->addScript($template_path."/js/jquery.isotope.min.js");
$filter = $this->params->get("defaultFilter" ,'all');

$script = '
(function($){ 
	$(window).load(function(){
		if ($("ul#thumbs").length > 0){
			var $container = $("ul#thumbs");
			$container.isotope({
			  itemSelector : ".item",
			  animationEngine : "jquery",
			  animationOptions: {
				  duration: 250,
				  easing: "easeOutExpo",
				  queue: false
			  },
			  '.(($filter != 'all'  ? 'filter: ".'.$filter.'",' : '')).'
			  sortAscending : '.($this->params->get("sortAscending" ,1) ? "true": "false").',
			  getSortData : {
				  name : function ( $elem ) {
					  return $elem.find("span.name").text();
				  },
				  date : function ( $elem ) {
					  return $elem.attr("data-date");
				  }
			  },
			  sortBy: "'.$this->params->get("sortBy" , "date").'"
			});
			
		}
	});
})(jQuery);
';

$doc->addScriptDeclaration($script);

?>
<div class="hg-portfolio-sortable <?php echo $this->pageclass_sfx;?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1 class="title">
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
	<h2 class="title">
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

	
	<?php
	$cat_alias = array ();
	$cat_title = array ();
	foreach ($this->intro_items as $row) {
		$cat_alias[] = $row->category_alias;
		$cat_title[] = $row->category_title;
	}
	$cat_alias = array_unique($cat_alias);
	$cat_title = array_unique($cat_title);

	
	echo '
	<div id="sorting" class="clearfix">
		<span class="sortTitle"> Sort By: </span>
		<ul id="sortBy" class="option-set " data-option-key="sortBy">
			<li><a href="#sortBy=name" data-option-value="name" class="'.($this->params->get('sortBy') == 'name' ? 'selected': '').'">Name</a></li>
			<li><a href="#sortBy=date" data-option-value="date" class="'.($this->params->get('sortBy') == 'date' ? 'selected': '').'">Date</a></li>
		</ul>
		<span class="sortTitle"> Direction: </span>
		<ul id="sort-direction" class="option-set " data-option-key="sortAscending">
		  <li><a href="#sortAscending=true" data-option-value="true" class="'.($this->params->get('sortAscending') == 1 ? 'selected': '').'">ASC</a></li>
		  <li><a href="#sortAscending=false" data-option-value="false" class="'.($this->params->get('sortAscending') == 0 ? 'selected': '').'">DESC</a></li>
		</ul>
	</div>';
    
	echo '<ul id="portfolio-nav" class="clearfix"><li '.($filter == 'all' ? ' class="current"':'').'><a href="#" data-filter="*">All</a></li>';
	
	foreach ($cat_alias as $k=>$datafilter) {
		$datafilter = strtolower($datafilter);
		echo '<li '.($filter == $datafilter ? ' class="current"':'').'><a href="#" data-filter=".'.$datafilter.'">'.$cat_title[$k].'</a></li>';
	}
	echo '</ul>';
	?>
    <div class="clear"></div>
    
<ul id="thumbs" class="clearfix">
<?php
$introcount=(count($this->items));

if (!empty($this->intro_items)) :
	foreach ($this->intro_items as $key => &$item) :
	
	$date = current(explode(' ',$item->created));
	$cat = $item->category_alias;
	?>
	<li class="item <?php echo $item->state == 0 ? ' system-unpublished' : null; ?> <?php echo strtolower($cat); ?> <?php echo ($key%2) ? "odd" : "even"; if(count($this->intro_items)==$key+1) echo ' lastItem'; ?>"  data-date="<?php echo str_replace('-','/',$date); ?>">
		<?php
			$this->item = &$item;
			echo $this->loadTemplate('item');
		?>
	</li>
	<?php
	endforeach;
endif; ?>
</ul>
</div>
