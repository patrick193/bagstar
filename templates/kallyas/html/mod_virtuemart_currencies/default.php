<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="vmcurrency">
	<!-- Currency Selector Module -->
	<p><?php echo $text_before ?></p>
	<form action="<?php echo JURI::getInstance()->toString(); ?>" method="post">
		<div class="input-prepend input-append">
		<span class="add-on"><?php
		foreach($currencies as $currency){
			if($currency->virtuemart_currency_id == $virtuemart_currency_id)
				echo end(explode(" ", $currency->currency_txt));
		}
		?></span>
		<?php echo JHTML::_('select.genericlist', $currencies, 'virtuemart_currency_id', 'class="input-medium"', 'virtuemart_currency_id', 'currency_txt', $virtuemart_currency_id) ; ?>
		<input class="btn" type="submit" name="submit" value="<?php echo JText::_('Change') ?>" />
		</div>
	</form>
</div>