<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

	<div class="vmCartModule" id="vmCartModule<?php echo $module->id; ?>">
		<p class="cart_details">
			<span class="total_products"><?php echo  $data->totalProductTxt ?></span>
			<span class="total"><?php if ($data->totalProduct and $show_price) echo  $data->billTotal; ?></span>
			<?php echo '<a class="checkout" href="'.$cart_link.'"><span class=" icon-shopping-cart"></span> '.$linkName.'</a>'; ?>
		</p>
	</div><!-- end vmcartmodule -->
