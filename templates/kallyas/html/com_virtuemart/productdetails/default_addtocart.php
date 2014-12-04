<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_addtocart.php 6433 2012-09-12 15:08:50Z openglobal $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
if (isset($this->product->step_order_level))
	$step=$this->product->step_order_level;
else
	$step=1;
if($step==0)
	$step=1;
$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
?>

<div class="addtocart-area">

	<form method="post" class="product js-recalculate" action="<?php echo JRoute::_ ('index.php'); ?>">
                <input name="quantity" type="hidden" value="<?php echo $step ?>" />
		<?php // Product custom_fields
		if (!empty($this->product->customfieldsCart)) {
			?>
			<div class="product-fields clearfix">
				<?php foreach ($this->product->customfieldsCart as $field) { ?>
				<div class="product-field product-field-type-<?php echo $field->field_type ?>">
					<span class="product-fields-title"  data-rel="tooltip" data-placement="top" data-animation="true" data-original-title="<?php echo $field->custom_field_desc; ?>"><?php echo $field->custom_title ?></span>
					
					<span class="product-field-display dropdown-select"><?php echo $field->display ?></span>
				</div>
				<?php } ?>
			</div>
			<?php 
		}
		/* Product custom Childs
			 * to display a simple link use $field->virtuemart_product_id as link to child product_id
			 * custom_value is relation value to child
			 */

		if (!empty($this->product->customsChilds)) {
			?>
			<div class="product-fields clearfix">
				<?php foreach ($this->product->customsChilds as $field) { ?>
				<div class="product-field product-field-type-<?php echo $field->field->field_type ?>">
					<span class="product-fields-title" data-rel="tooltip" data-placement="top" data-animation="true" data-original-title="<?php echo JText::_ ($field->field->custom_title) ?>"><?php echo JText::_ ($field->field->custom_title) ?></span>
					<span class="product-field-desc"><?php echo JText::_ ($field->field->custom_value) ?></span>
					<span class="product-field-display"><?php echo $field->display ?></span>
				</div>
				<?php } ?>
			</div>
			<?php }

		if (!VmConfig::get('use_as_catalog', 0) and !empty($this->product->prices['salesPrice'])) {
		?>
                <div class="knopki">
</div>

	<div class="addtocart-bar clearfix">

<script type="text/javascript">
		function check(obj) {
 		// use the modulus operator '%' to see if there is a remainder
		remainder=obj.value % <?php echo $step?>;
		quantity=obj.value;
 		if (remainder  != 0) {
 			alert('<?php echo $alert?>!');
 			obj.value = quantity-remainder;
 			return false;
 			}
 		return true;
 		}
</script> 

			<?php // Display the quantity box
		$stockhandle = VmConfig::get ('stockhandle', 'none');
		if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($this->product->product_in_stock - $this->product->product_ordered) < 1) {
			?>
			<a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' . $this->product->virtuemart_product_id); ?>" class="notify"><?php echo JText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?></a>
		<?php } else { ?>
		
		<?php /*?>
		
		
		<span class="quantity-controls js-recalculate">
			<input type="button" class="quantity-controls quantity-plus"/>
			<input type="button" class="quantity-controls quantity-minus"/>
	    </span>
			
		<span class="addtocart-button">
			<?php echo shopFunctionsF::getAddToCartButton ($this->product->orderable); ?>
		</span>
		
		<?php */?>
		
		<div class="input-prepend input-append">
			<span class="add-on"><span class="icon-shopping-cart icon-white"></span></span>
			<span>
				<input type="text" class="quantity-input input-tiny js-recalculate" name="quantity[]" onblur="check(this);" value="<?php if (isset($this->product->step_order_level) && (int)$this->product->step_order_level > 0) {
				echo $this->product->step_order_level;
			} else if(!empty($this->product->min_order_level)){
				echo $this->product->min_order_level;
			}else {
				echo '1';
			} ?>"/>
			</span>
			<span class="js-recalculate">
				<!--<input type="button" class="btn quantity-controls quantity-plus"/>
				<input type="button" class="btn quantity-controls quantity-minus"/>-->
				<a class="btn quantity-controls quantity-plus"><span class="icon-plus"></span></a>
				<a class="btn quantity-controls quantity-minus"><span class="icon-minus"></span></a>
			</span>
				
			<span class="">
				<?php //echo shopFunctionsF::getAddToCartButton ($this->product->orderable); ?>
                            
				<input type="submit" name="addtocart" class="addtocart-button btn btn-danger" value="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO'); ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO'); ?>" />
			<?php
		// Ask a question about this product
		if (VmConfig::get('ask_question', 1) == 1) {
			?>
    		<div class="ask-a-question">
                    <a class="ask-a-question btn btn-info"  href="<?php echo $this->askquestion_url ?>&amp;iframe=true&amp;width=700&amp;height=550" rel="prettyPhoto" > <?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
    		</div>
		<?php }
                        
                ?>
                        </span>
		</div>
	<?php } ?>

			<div class="clear"></div>
		</div>
		<?php }
		 // Display the add to cart button END  ?>
		<input type="hidden" class="pname" value="<?php echo htmlentities($this->product->product_name, ENT_QUOTES, 'utf-8') ?>"/>
		<input type="hidden" name="option" value="com_virtuemart"/>
		<input type="hidden" name="view" value="cart"/>
		<noscript><input type="hidden" name="task" value="add"/></noscript>
		<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $this->product->virtuemart_product_id ?>"/>
	</form>

	<div class="clear"></div>
</div>
