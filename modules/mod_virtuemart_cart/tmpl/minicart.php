<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>
<script type="text/javascript">
jQuery(document).ready(function(e) {
	function minicart_button(a) {
		var b = jQuery("#minicart");
		b.removeClass("off on");
		if (a == "on") { b.addClass("on") } else { b.addClass("off") }
	}
	window.setInterval(function () {
		var b = jQuery(this).scrollTop();
		var c = jQuery(this).height();
		if (b > 0) { var d = b + c / 2 } else { var d = 1 }
		if (d < 1e3) { minicart_button("off") } else { minicart_button("on") }
	}, 300);
	
	jQuery("#minicart").click(function (e) {
		window.location = '<?php echo  $cart_link; ?>';
	});
});
</script>
<div id="minicart">
	<div class="vmCartModule" id="vmCartModule<?php echo $module->id; ?>">
            <img src="images/cart-mini.jpeg" />
		<span class="total_products"><?php echo  $data->totalProductTxt ?></span>
		<span class="total"><?php if ($data->totalProduct and $show_price) echo  $data->billTotal; ?></span>
	</div><!-- end vmcartmodule -->
</div>