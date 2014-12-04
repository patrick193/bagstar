<?php // no direct access
defined ('_JEXEC') or die('Restricted access');

JLoader::register('JHtmlString', JPATH_LIBRARIES.'/joomla/html/html/string.php');
$document = JFactory::getDocument(); 

$last = count ($products) - 1;

$customitemid = $params->get('customitemid','');
$itemid = $customitemid ? '&amp;Itemid='.$customitemid : '';

$checkcarouFredSel = false;
$header = $document->getHeadData();
foreach($header['scripts'] as $scriptName => $scriptData)
	if(substr_count($scriptName,'/jquery.carouFredSel'))
		$checkcarouFredSel = true;

if(!$checkcarouFredSel) 
$document->addScript('modules/mod_hg_vm_products_carousel/assets/jquery.carouFredSel.js');

$js = '
;(function($) {
	$(window).load(function(){
		var _t = $("#limited_offers'.$module->id.'");
		_t.carouFredSel({
			responsive: true,
			scroll: 1,
			width: "92%",
			auto: true,
			items: {width:158, visible: { min: 2, max: 4 } },
			prev	: {	button : _t.parent().find("a.prev"), key : "left" },
			next	: { button : _t.parent().find("a.next"), key : "right" }
		});
	});
})(jQuery);';
$document->addScriptDeclaration($js);

?>
<div class="limited-offers-carousel fixclear <?php echo $params->get ('moduleclass_sfx') ?>">
		
	<ul id="limited_offers<?php echo $module->id; ?>" class="limited_offers">
		<?php foreach ($products as $product) :
		$days = 10;
		$created = $product->created_on;
		$date = JFactory::getDate (time () - (60 * 60 * 24 * $days));
		$newprod = ($created > $date) ? 'promo-new':'';
		
		?>
		<li <?php echo ($product->prices['discountAmount'] > 0) ? 'class="has_discount" data-discount="'.$currency->createPriceDiv ('basePrice', '', $product->prices, true, FALSE, 1.0, TRUE).'"':''; ?>>
			<?php
			$image = (!empty($product->images[0])) ? $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE):'';
			echo '<div class="image">'.JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id.$itemid), $image, array('title' => $product->product_name)).'</div>';
			?>
			<h5><a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id.$itemid); ?>"><?php echo $product->product_name ?></a></h5>
			<h6><?php echo $currency->createPriceDiv ('salesPrice', '', $product->prices, true, FALSE, 1.0, TRUE); ?></h6>
		</li>
	<?php endforeach; ?>
	</ul>
	<div class="controls">
		<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
		<a href="#" class="next"><span class="icon-chevron-right"></span></a>
	</div>
	<div class="clear"></div>

</div>