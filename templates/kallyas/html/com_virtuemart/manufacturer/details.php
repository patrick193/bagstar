<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage Manufacturer
* @author Kohl Patrick, Eugen Stranz
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 2701 2011-02-11 15:16:49Z impleri $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>

<div class="manufacturer-details-view">
	<h1 class="page-title"><?php echo $this->manufacturer->mf_name; ?></h1>

	<div class="prod-details">

	<?php // Manufacturer Image
	if (!empty($this->manufacturerImage)) { ?>
		<p class="manufacturer-image">
		<?php echo $this->manufacturerImage; ?>
		</p>
	<?php } ?>

	<?php // Manufacturer Email
	if(!empty($this->manufacturer->mf_email)) { ?>
		<p class="manufacturer-email">
		<?php // TO DO Make The Email Visible Within The Lightbox
		echo '<span class="icon-envelope"></span>'.JHtml::_('email.cloak', $this->manufacturer->mf_email,true,JText::_('COM_VIRTUEMART_EMAIL'),false) ?>
		</p>
	<?php } ?>

	<?php // Manufacturer URL
	if(!empty($this->manufacturer->mf_url)) { ?>
		<p class="manufacturer-url">
			<span class="icon-globe"></span>
			<a target="_blank" href="<?php echo $this->manufacturer->mf_url ?>"><?php echo JText::_('COM_VIRTUEMART_MANUFACTURER_PAGE') ?></a>
		</p>
	<?php } ?>

	<?php // Manufacturer Description
	if(!empty($this->manufacturer->mf_desc)) { ?>
		<p class="manufacturer-description">
			<?php echo $this->manufacturer->mf_desc ?>
		</p>
	<?php } ?>

	<?php // Manufacturer Product Link
	$manufacturerProductsURL = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturer_id=' . $this->manufacturer->virtuemart_manufacturer_id);

	if(!empty($this->manufacturer->virtuemart_manufacturer_id)) { ?>
		<p class="manufacturer-product-link">
			<a target="_top" class="btn btn-info" href="<?php echo $manufacturerProductsURL; ?>"><?php echo JText::sprintf('COM_VIRTUEMART_PRODUCT_FROM_MF',$this->manufacturer->mf_name); ?></a>
		</p>
	<?php } ?>

	<div class="clear"></div>
	</div>
</div>