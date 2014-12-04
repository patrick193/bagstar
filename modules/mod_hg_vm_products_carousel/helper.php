<?php
	defined ('_JEXEC') or  die('Direct Access to ' . basename (__FILE__) . ' is not allowed.');
	/*
 * Module Helper
 *
 * @package VirtueMart
 * @copyright (C) 2010 - Patrick Kohl
 * @ Email: cyber__fr|at|hotmail.com
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * VirtueMart is Free Software.
 * VirtueMart comes with absolute no warranty.
 *
 * www.virtuemart.net
 */
	if (!class_exists ('VmConfig')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
	}
	VmConfig::loadConfig ();
	// Load the language file of com_virtuemart.
	JFactory::getLanguage ()->load ('com_virtuemart');
	if (!class_exists ('calculationHelper')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'calculationh.php');
	}
	if (!class_exists ('CurrencyDisplay')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'currencydisplay.php');
	}
	if (!class_exists ('VirtueMartModelVendor')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' . DS . 'vendor.php');
	}
	if (!class_exists ('VmImage')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'image.php');
	}
	if (!class_exists ('shopFunctionsF')) {
		require(JPATH_SITE . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'shopfunctionsf.php');
	}
	if (!class_exists ('calculationHelper')) {
		require(JPATH_COMPONENT_SITE . DS . 'helpers' . DS . 'cart.php');
	}
	if (!class_exists ('VirtueMartModelProduct')) {
		JLoader::import ('product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models');
	}

class mod_virtuemart_product_hgcarousel {

	function addtocart ($product, $params) {

		if (!VmConfig::get ('use_as_catalog', 0)) {
			$stockhandle = VmConfig::get ('stockhandle', 'none');
			if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($product->product_in_stock - $product->product_ordered) < 1) {
				$button_lbl = JText::_ ('COM_VIRTUEMART_CART_NOTIFY');
				$button_cls = 'notify-button';
				$button_name = 'notifycustomer';
				?>
				<div style="display:inline-block;">
			<a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' . $product->virtuemart_product_id); ?>" class="notify"><?php echo JText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?></a>
				</div>
			<?php
			} else {
				?>
			<div class="addtocart-area">

				<form method="post" class="product" action="index.php">
					<?php
					// Product custom_fields
					if (!empty($product->customfieldsCart) && $params->get('show_customfields',1)) {
						?>
						<div class="product-fields">
							<?php foreach ($product->customfieldsCart as $field) { ?>

							<div class="product-field product-field-type-<?php echo $field->field_type ?>">
								<span class="product-fields-title" data-rel="tooltip" data-placement="top" data-animation="true" data-original-title="<?php echo $field->custom_field_desc ?> <?php echo $field->custom_tip; ?>"><?php echo $field->custom_title ?></span>
								<span class="product-field-display dropdown-select"><?php echo $field->display ?></span>
								
							</div>

							<?php } ?>
						</div>
					<?php } ?>

					<div class="addtocart-bar">

                                            <span class="quantity-controls" style="display:none;">
							<input type="button" class="quantity-controls quantity-plus"/>
							<input type="button" class="quantity-controls quantity-minus"/>
						</span>
						
                                            <span class="quantity-box" style="display:none;">
							<input type="text" class="quantity-input" name="quantity[]" value="1"/>
						</span>

						<?php
						// Add the button
						$button_lbl = JText::_ ('COM_VIRTUEMART_CART_ADD_TO');
						$button_cls = ''; //$button_cls = 'addtocart_button';
						?>
						<span class="addtocart-button">
							<?php echo shopFunctionsF::getAddToCartButton($product->orderable); ?>
						</span>

						<div class="clear"></div>
					</div>

					<input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
					<input type="hidden" name="option" value="com_virtuemart"/>
					<input type="hidden" name="view" value="cart"/>
					<noscript><input type="hidden" name="task" value="add"/></noscript>
					<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
					<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>"/>
				</form>
				<div class="clear"></div>
			</div>
			<?php
			}
		}
	}
}