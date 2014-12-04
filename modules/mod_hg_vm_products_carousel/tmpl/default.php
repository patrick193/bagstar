<?php // no direct access
defined ('_JEXEC') or die('Restricted access');

JLoader::register('JHtmlString', JPATH_LIBRARIES.'/joomla/html/html/string.php');
$document = JFactory::getDocument(); 

$col = 1;
$last = count ($products) - 1;
$customitemid = $params->get('customitemid','');
$itemid = $customitemid ? '&amp;Itemid='.$customitemid : '';
?>
<div class="row shop-latest-products <?php echo $params->get ('moduleclass_sfx') ?>">

		<?php foreach ($products as $product) :
	$days = 10;
	$created = $product->created_on;
	$date = JFactory::getDate (time () - (60 * 60 * 24 * $days));
	$newprod = ($created > $date) ? 'promo-new':'';

		?>
		<div class="span3">
			<div class="product-list-item <?php if($product->prices['discountAmount']) echo 'promo-sale'; ?> <?php echo $newprod; ?>">
				<span class="hover"></span>
				<?php

				$image = (!empty($product->images[0])) ? $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE):'';

				echo '<div class="image">'.JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id.$itemid), $image, array('title' => $product->product_name)).'</div>';
				
				$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id.$itemid);
				?>
				<div class="prod-details fixclear">
					<h3><a href="<?php echo $url ?>"><?php echo $product->product_name ?></a></h3>
					<p class="desc"><?php echo JHtmlString::truncate($product->product_desc, 80, true, false); ?></p>
					<div class="actions">
						<a href="<?php echo $url ?>" class="product-details actionBtn"><?php echo JText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ) ?></a>
						<div class="clear"></div>
						<?php
							if ($show_addtocart) echo mod_virtuemart_product_hgcarousel::addtocart ($product, $params);
						?>
					</div>
					<div class="price">
					<?php
					if ($show_price and  isset($product->prices)) {
						echo '<span>'.$currency->createPriceDiv ('salesPrice', '', $product->prices, true, FALSE, 1.0, TRUE).'</span>';
						if ($product->prices['discountAmount'] > 0) {
							echo '<small>'.$currency->createPriceDiv ('basePrice', '', $product->prices, true, FALSE, 1.0, TRUE).'</small>';
						}
					}
					//print_r($product->prices);
					?>
					</div>
				</div>
			</div><!-- end prod item -->
		</div>
	<?php endforeach; ?>
	<div class="clear"></div>
</div>