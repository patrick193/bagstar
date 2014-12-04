<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JLoader::register('JHtmlString', JPATH_LIBRARIES.'/joomla/html/html/string.php');
?>
<div class="vmgroup <?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if ($headerText) { ?>
	<p class="vmheader"><?php echo $headerText ?></p>
<?php } ?>

<div class="vmproduct<?php echo $params->get('moduleclass_sfx'); ?>">
<?php foreach ($products as $product) { ?>
	<div class="product-list-item">
		<span class="hover"></span>
<?php
if (!empty($product->images[0]) )
$image = $product->images[0]->displayMediaThumb('class="featuredProductImage" border="0"',false) ;
else $image = '';
echo '<div class="image">'.JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id),$image,array('title' => $product->product_name) ).'</div>';

$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.
$product->virtuemart_category_id); ?>
		<div class="prod-details fixclear">
			<h3><a href="<?php echo $url ?>"><?php echo $product->product_name ?></a></h3>
			<p class="desc"><?php echo JHtmlString::truncate($product->product_desc, 100, true, false); ?></p>
			<div class="actions">
				<a href="<?php echo $url ?>" class="product-details actionBtn"><?php echo JText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ) ?></a>
				<div class="clear"></div>
				<?php
					if ($show_addtocart) echo mod_virtuemart_product::addtocart($product);
				?>
			</div>
			<div class="price">
			<?php
			if ($show_price and  isset($product->prices)) {
				
				echo '<span>'.$currency->createPriceDiv ('salesPrice', '', $product->prices, true, FALSE, 1.0, TRUE).'</span>';
				if ($product->prices['discountAmount'] > 0) {
					echo '<small>'.$currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, true, FALSE, 1.0, TRUE).'</small>';
				}
			}
			?>
			</div>
					
		</div><!-- end prod-details -->
	</div><!-- end product-list-item -->

	<?php } ?>
<?php if ($footerText) { ?>
	<p class="vmheader"><?php echo $footerText ?></p>
<?php } ?>
</div>
</div>