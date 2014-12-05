	<?php defined('_JEXEC') or die('Restricted access');
/**
 *
 * Layout for the shopping cart
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 * @author Patrick Kohl
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */
JHTML::stylesheet ( 'plugins/system/onepage/onepage.css');
// Check to ensure this file is included in Joomla!
$plugin=JPluginHelper::getPlugin('system','onepage');
$params=new JRegistry($plugin->params);
$this->params=$params;
?>
<?php 
if($this->params->get('address_position',0)==0) {
	echo $this->loadTemplate('address'); 
}
?>
<fieldset id="cart-contents" class="checkpage">
	<table class="cart-summary" border="0" width="100%">
  	<thead>
		<tr>
			<th><?php echo JText::_('COM_VIRTUEMART_CART_NAME') ?></th>
			<th><?php echo JText::_('COM_VIRTUEMART_CART_SKU') ?></th>
			<th><?php echo JText::_('COM_VIRTUEMART_CART_PRICE') ?></th>
			<th><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY') ?> / <?php echo JText::_('COM_VIRTUEMART_CART_ACTION') ?></th>
      <?php if ( VmConfig::get('show_tax')) { ?>
      <th><?php  echo "<span class='priceColor2'>".JText::_('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT')."</span>" ?></th>
				<?php } ?>
      <th><?php echo "<span class='priceColor2'>".JText::_('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT')."</span>" ?></th>
			<th><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?></th>
			</tr>
        	</thead>
					<tbody>


		<?php
		$i=1;
		foreach( $this->cart->products as $pkey =>$prow ) {
			?>
			<tr class="sectiontableentry<?php echo $i ?>" id="product_row_<?php echo $pkey; ?>">
				<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_NAME') ?>">
					<?php if ( $prow->virtuemart_media_id) {  ?>
						<span class="cart-images">
						 <?php
						 if(!empty($prow->image)) echo $prow->image->displayMediaThumb('',false);
						 ?>
						</span>
					<?php } ?>
					<?php echo JHTML::link($prow->url, $prow->product_name).$prow->customfields; ?>

				</td>
				<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SKU') ?>"><?php  echo $prow->product_sku ?></td>
				<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_PRICE') ?>">
				<?php
					echo $this->currencyDisplay->createPriceDiv('basePrice','', $this->cart->pricesUnformatted[$pkey],false);
					?>
				</td>
				<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY') ?> / <?php echo JText::_('COM_VIRTUEMART_CART_ACTION') ?>">
				<input type="text" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="inputbox" size="3" maxlength="4" value="<?php echo $prow->quantity ?>" id='quantity_<?php echo $pkey; ?>'/>
				<input type="button" class="vmicon vm2-add_quantity_cart" name="update" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" align="middle" onclick="update_form('update_product','<?php echo $pkey; ?>');"/>
				<a class="vmicon vm2-remove_from_cart" title="<?php echo JText::_('COM_VIRTUEMART_CART_DELETE') ?>" align="middle" href="javascript:void(0)" onclick="update_form('remove_product','<?php echo $pkey; ?>')"> </a>
				</td>
         <td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?>">
				<?php if ( VmConfig::get('show_tax')) { ?>
				<?php echo "<span class='priceColor2' id='subtotal_tax_amount_".$pkey."'>".$this->currencyDisplay->createPriceDiv('taxAmount','', $this->cart->pricesUnformatted[$pkey],false,false,$prow->quantity)."</span>" ?></td>
                                <?php } ?>
				<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') ?>"><?php echo "<span class='priceColor2' id='subtotal_discount_".$pkey."'>".$this->currencyDisplay->createPriceDiv('discountAmount','', $this->cart->pricesUnformatted[$pkey],false,false,$prow->quantity)."</span>" ?></td>
				<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?>" id="subtotal_with_tax_<?php echo $pkey; ?>">
				<?php 
				if (VmConfig::get('checkout_show_origprice',1) && !empty($this->cart->pricesUnformatted[$pkey]['basePriceWithTax']) && $this->cart->pricesUnformatted[$pkey]['basePriceWithTax'] != $this->cart->pricesUnformatted[$pkey]['salesPrice'] ) {
	                            echo '<span class="line-through">'.$this->currencyDisplay->createPriceDiv('basePriceWithTax','', $this->cart->pricesUnformatted[$pkey],true,false,$prow->quantity) .'</span><br />' ;
    		                }
				echo $this->currencyDisplay->createPriceDiv('salesPrice','', $this->cart->pricesUnformatted[$pkey],false,false,$prow->quantity);
				?>
				</td>
			</tr>
		<?php
		//echo "<pre>";print_r($this->cart->pricesUnformatted['salesPrice']);echo "</pre>";
			$i = 1 ? 2 : 1;
		} ?>
		<!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
                  <?php if ( VmConfig::get('show_tax')) { $colspan=3; } else { $colspan=2; } ?>
		  <tr class="sectiontableentry1">
			<td colspan="4"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?></td>
                        <?php if ( VmConfig::get('show_tax')) { ?>
			<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?>"><?php echo "<span  class='priceColor2' id='tax_amount'>".$this->currencyDisplay->createPriceDiv('taxAmount','', $this->cart->pricesUnformatted,false)."</span>" ?></td>
                        <?php } ?>
			<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') ?>"><?php echo "<span  class='priceColor2' id='discount_amount'>".$this->currencyDisplay->createPriceDiv('discountAmount','', $this->cart->pricesUnformatted,false)."</span>" ?></td>
			<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?>" id="sales_price"><?php echo $this->currencyDisplay->createPriceDiv('salesPrice','', $this->cart->pricesUnformatted,false) ?></td>
		  </tr>

			<?php
		if (VmConfig::get('coupons_enable')) {
		?>
			<tr class="sectiontableentry2">
			<td data-title="<?php echo JText::_('COM_VIRTUEMART_COUPON_CODE_ENTER') ?>" colspan="4">
				    <?php if(!empty($this->layoutName) && $this->layoutName=='default') {
					    echo $this->loadTemplate('coupon');
				    }
				?>

					 <?php
						echo "<span id='coupon_code_txt'>".@$this->cart->cartData['couponCode']."</span>";
						echo @$this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')' ): '';
						?>

				</td>
					 <?php if ( VmConfig::get('show_tax')) { ?>
					<td id="coupon_tax"><?php echo $this->currencyDisplay->createPriceDiv('couponTax','', @$this->cart->pricesUnformatted['couponTax'],false); ?> </td>
					 <?php } ?>
					<td>&nbsp;</td>
					<td id="coupon_price"><?php echo $this->currencyDisplay->createPriceDiv('salesPriceCoupon','', @$this->cart->pricesUnformatted['salesPriceCoupon'],false); ?> </td>
			</tr>
		<?php } ?>


		<?php
		foreach($this->cart->cartData['DBTaxRulesBill'] as $rule){ ?>
			<tr class="sectiontableentry<?php $i ?>  DBTaxRulesBill_tr">
				<td colspan="4"><?php echo $rule['calc_name'] ?> </td>
                                   <?php if ( VmConfig::get('show_tax')) { ?>
				<td>&nbsp;</td>
                                <?php } ?>
				<td><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);  ?></td>
				<td><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);   ?></td>
			</tr>
			<?php
			if($i) $i=1; else $i=0;
		} ?>

		<?php

		foreach($this->cart->cartData['taxRulesBill'] as $rule){ ?>
			<tr class="sectiontableentry<?php $i ?> taxRulesBill_tr">
				<td colspan="4"><?php echo $rule['calc_name'] ?> </td>
				<?php if ( VmConfig::get('show_tax')) { ?>
				<td><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false); ?> </td>
				 <?php } ?>
				<td><?php ?></td>
				<td><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);   ?> </td>
			</tr>
			<?php
			if($i) $i=1; else $i=0;
		}

		foreach($this->cart->cartData['DATaxRulesBill'] as $rule){ ?>
			<tr class="sectiontableentry<?php $i ?> DATaxRulesBill_tr">
				<td colspan="4"><?php echo   $rule['calc_name'] ?> </td>
                                     <?php if ( VmConfig::get('show_tax')) { ?>
				<td>&nbsp;</td>

                                <?php } ?>
				<td><?php  echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);   ?>  </td>
				<td><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);   ?> </td>
			</tr>
			<?php
			if($i) $i=1; else $i=0;
		} ?>


	<tr class="sectiontableentry1" id="shipment_tr">
			<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SELECTSHIPMENT');?>" colspan="4">
				<?php // echo $this->cart->cartData['shipmentName']; ?>
				<?php
				echo JText::_('COM_VIRTUEMART_CART_SELECTSHIPMENT');
				if(!empty($this->layoutName) && $this->layoutName=='default') {
					echo "<fieldset id='shipments' class='radio-check'>";					
						foreach($this->helper->shipments_shipment_rates as $rates) {
								echo str_replace("input",'input onclick="update_form();"',$rates)."<br />";
						}
					echo "</fieldset>";
				} else {
				    JText::_('COM_VIRTUEMART_CART_SHIPPING');
				}
                if ( VmConfig::get('show_tax')) { ?>
				</td>
        <td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?>"><?php echo "<span  class='priceColor2' id='shipment_tax'>".$this->currencyDisplay->createPriceDiv('shipmentTax','', $this->cart->pricesUnformatted['shipmentTax'],false)."</span>"; ?> </td>
                <?php } ?>
			<td>&nbsp;</td>
				<td class="radio-check" id="shipment"><?php echo $this->currencyDisplay->createPriceDiv('salesPriceShipment','', $this->cart->pricesUnformatted['salesPriceShipment'],false); ?> </td>
		</tr>

		<tr class="sectiontableentry1">
			<td colspan="4">
				<?php 
				echo JText::_('COM_VIRTUEMART_CART_SELECTPAYMENT');
				if(!empty($this->layoutName) && $this->layoutName=='default') { 
					echo "<fieldset id='payments' class='radio-check'>";
						foreach($this->helper->paymentplugins_payments as $payments) {
							echo str_replace('type="radio"','type="radio" onclick="update_form();"',$payments)."<br />";
						}
					echo "</fieldset>";
				} else {
					JText::_('COM_VIRTUEMART_CART_PAYMENT'); 
				}
				?> </td>
                <?php if ( VmConfig::get('show_tax')) { ?>
				<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?>"><?php echo "<span  class='priceColor2' id='payment_tax'>".$this->currencyDisplay->createPriceDiv('paymentTax','', $this->cart->pricesUnformatted['paymentTax'],false)."</span>"; ?> </td>
                <?php } ?>
				<td>&nbsp;</td>
				<td class="radio-check" id="payment"><?php  echo $this->currencyDisplay->createPriceDiv('salesPricePayment','', $this->cart->pricesUnformatted['salesPricePayment'],false); ?> </td>
			</tr>
		  <tr class="sectiontableentry2">
			<td colspan="4"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?>: </td>
                        <?php if ( VmConfig::get('show_tax')) { ?>
			<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?>"> <?php echo "<span  class='priceColor2' id='total_tax'>".$this->currencyDisplay->createPriceDiv('billTaxAmount','', $this->cart->pricesUnformatted['billTaxAmount'],false)."</span>" ?> </td>
                        <?php } ?>
			<td data-title="<?php echo JText::_('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') ?>"> <?php echo "<span  class='priceColor2' id='total_amount'>".$this->currencyDisplay->createPriceDiv('billDiscountAmount','', $this->cart->pricesUnformatted['billDiscountAmount'],false)."</span>" ?> </td>
			<td><strong id="bill_total"><?php echo $this->currencyDisplay->createPriceDiv('billTotal','', $this->cart->pricesUnformatted['billTotal'],false) ?></strong></td>
		  </tr>
		    <?php
		    if ( $this->totalInPaymentCurrency) {
			?>

		       <tr class="sectiontableentry2">
					    <td colspan="4"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>: </td>
				    <?php if ( VmConfig::get('show_tax')) { ?>
					    <td>&nbsp;</td>
					    <?php } ?>
					    <td>&nbsp;</td>
					    <td><strong><?php echo $this->currencyDisplay->createPriceDiv('totalInPaymentCurrency','', $this->totalInPaymentCurrency,false); ?></strong></td>
				      </tr>
				      <?php
		    }
		    ?>
      </tbody>
	</table>
    <input type="text" name="coupon_code" id="coupon_code" size="20" maxlength="50" class="coupon" alt="<?php echo $this->coupon_text ?>" value="<?php echo $this->coupon_text; ?>" onblur="if(this.value=='') this.value='<?php echo $this->coupon_text; ?>';" onfocus="if(this.value=='<?php echo $this->coupon_text; ?>') this.value='';" />
<span class="details-button">
<input class="details-button" type="button" title="<?php echo JText::_('COM_VIRTUEMART_SAVE'); ?>" value="<?php echo JText::_('COM_VIRTUEMART_SAVE'); ?>" onclick="set_coupon();"/>
</span>
</fieldset>
<?php 
if($this->params->get('address_position',0)==1) {
	echo $this->loadTemplate('address'); 
}
?>
