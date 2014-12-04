<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 6188 2012-06-29 09:38:30Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument ();

if (!empty($this->product->images)) {
	$image = $this->product->images[0];
	?>
<div class="product-gallery">
	<div class="big-image">
		<?php echo $image->displayMediaFull("",true,"rel='prettyPhoto'"); ?>
	</div>

<?php
	$count_images = count ($this->product->images);
	if ($count_images > 1) {
		?>
    <ul class="thumbs">
		<?php
		//print_r($this->product);
		for ($i = 1; $i < $count_images; $i++) {
			$image = $this->product->images[$i];
			?>
			<li><?php echo $image->displayMediaThumb('', true, "rel='prettyPhoto'",true,false,false, 50,50); ?></li>
			<?php
		}
		?>
    </ul>
	<div class="clear"></div>
	<?php } ?>
	</div>
<?php
} // Showing The Additional Images END ?>