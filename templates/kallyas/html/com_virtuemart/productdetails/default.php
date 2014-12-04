<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6530 2012-10-12 09:40:36Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');

// addon for joomla modal Box

// JHTML::_('behavior.tooltip');
$document = JFactory::getDocument();
/*
$document->addScriptDeclaration("
//<![CDATA[
	jQuery(document).ready(function($) {
		
		$('a.ask-a-question').click( function(){
			$.facebox({
				iframe: '" . $this->askquestion_url . "',
				rev: 'iframe|750|550'
			});
			return false ;
		});
		
		$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});
	});
//]]>
");
*/

/* Let's see if we found the product */
if (empty($this->product)) {
    echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}
?>

<div class="row-fluid product-page">

	<div class="span5">
		<?php echo $this->loadTemplate('images'); ?>
	</div>
	
	<div class="span7">
	
	<div class="main-data">

	<?php
    // PDF - Print - Email Icon
    if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_button_enable')) {
	?>
        <ul class="actions">
	    <?php
	    $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
	    $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';
             echo '{socbuttons}';

//		if (VmConfig::get('pdf_icon', 1) == 1)
//		echo '<li class="pdf-icon"><a rel="prettyPhoto" data-rel="tooltip" data-original-title="'. JText::_('COM_VIRTUEMART_PDF').'" title="'. JText::_('COM_VIRTUEMART_PDF').'" href="'.JRoute::_($link . '&format=pdf').'&amp;iframe=true&amp;width=800&amp;height=550"><span class="icon-file icon-white"></span></a></li>';
//		echo '<li class="print-icon"><a rel="prettyPhoto" data-rel="tooltip" data-original-title="'. JText::_('COM_VIRTUEMART_PRINT').'" title="'. JText::_('COM_VIRTUEMART_PRINT').'" href="'.JRoute::_($link . '&print=1').'&amp;iframe=true&amp;width=800&amp;height=550"><span class="icon-print icon-white"></span></a></li>';
//		echo '<li class="email-icon"><a rel="prettyPhoto" data-rel="tooltip" data-original-title="'. JText::_('COM_VIRTUEMART_EMAIL').'" title="'. JText::_('COM_VIRTUEMART_EMAIL').'" href="'.JRoute::_($MailLink).'&amp;iframe=true&amp;width=800&amp;height=550"><span class="icon-envelope icon-white"></span></a></li>';
	    ?>
        </ul>
    <?php } // PDF - Print - Email Icon END ?>
	
<?php /*?>
	<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id);
		$categoryName = $this->product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME') ;
	}
	?>
	<div class="back-to-category">
    	<a href="<?php echo $catURL ?>" class="btn btn-link" title="<?php echo $categoryName ?>"><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
	</div>
<?php */?>

    <?php // Product Title   ?>
	<h1 class="name"><?php echo $this->product->product_name ?></h1>
    <?php // Product Title END   ?>

	<p class="first-details">
	<?php
	//print_r($this->product);
	$sep = '&nbsp; / &nbsp;';
	if (!empty($this->product->product_sku))
		echo '<strong>'.JText::_('COM_VIRTUEMART_CART_SKU').':</strong> '. $this->product->product_sku.$sep;
	
	if (!($this->product->product_in_stock - $this->product->product_ordered) < 1)
		echo '<strong>'.JText::_('COM_VIRTUEMART_PRODUCT_AVAILABILITY').':</strong> '. JText::_('JYES').$sep ;
	
	if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id))
		echo $this->loadTemplate('manufacturer');

	?>
	</p>

	<?php
		if ($this->showRating) {
		    $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);
			echo '<div class="rating_block">';
		    if (empty($this->rating)) {
			?>
				<span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
			    <?php
			} else {
			    $ratingwidth = $this->rating->rating * 24; //I don't use round as percetntage with works perfect, as for me
			    ?>
				<span class="vote">
					<strong><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . round($this->rating->rating) . '/' . $maxrating; ?></strong>
			    	<span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . round($this->rating->rating) . '/' . $maxrating) ?>" class="ratingbox" style="display:inline-block;">
						<span class="stars-orange" style="width:<?php echo $ratingwidth.'px'; ?>"></span>
			    	</span>
				</span>
			<?php
		    }
			echo '</div>';
		} ?>

    <?php // afterDisplayTitle Event
    echo $this->product->event->afterDisplayTitle ?>

    <?php
    // Product Edit Link
    echo $this->edit_link; ?>

    <?php
    // Product Short Description
    if (!empty($this->product->product_s_desc)) {
	?>
        <p class="small_desc"><?php
	    /** @todo Test if content plugins modify the product description */
	    echo nl2br($this->product->product_s_desc); ?></p>
	<?php
    } // Product Short Description END

    if (!empty($this->product->customfieldsSorted['ontop'])) {
		$this->position = 'ontop';
		echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>
	</div><!-- main data -->
	
	<div class="spacer-buy-area">
				
		<?php
		if (is_array($this->productDisplayShipments)) {
		    foreach ($this->productDisplayShipments as $productDisplayShipment) {
			echo $productDisplayShipment . '<br />';
		    }
		}
		if (is_array($this->productDisplayPayments)) {
		    foreach ($this->productDisplayPayments as $productDisplayPayment) {
			echo $productDisplayPayment . '<br />';
		    }
		}
		
		// Product Price
		echo $this->loadTemplate('showprices');
		
		// Add To Cart Button
		echo $this->loadTemplate('addtocart');

		// Availability Image
		$stockhandle = VmConfig::get('stockhandle', 'none');
		if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
			if ($stockhandle == 'risetime' and VmConfig::get('rised_availability') and empty($this->product->product_availability)) {
			?>	<div class="availability">
			    <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability'))) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability', '7d.gif'), VmConfig::get('rised_availability', '7d.gif'), array('class' => 'availability')) : VmConfig::get('rised_availability'); ?>
			</div>
		    <?php
			} else if (!empty($this->product->product_availability)) {
			?>
			<div class="availability">
			<?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability)) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability, $this->product->product_availability, array('class' => 'availability')) : $this->product->product_availability; ?>
			</div>
			<?php
			}
		}
		?>

		

	</div><!-- spacer-buy-area -->

    </div>
	
</div>

<div class="row-fluid product-page">

	<div class="span12">
	<?php // event onContentBeforeDisplay
	echo $this->product->event->beforeDisplayContent; ?>

<div class="tabbable tabs_style4">
	<ul class="nav fixclear">
		<li class="active"><a href="#shop-desc" data-toggle="tab"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></a></li>
		<li><a href="#shop-rating" data-toggle="tab"><?php echo JText::_('COM_VIRTUEMART_RATING'); ?></a></li>
		<?php if ($this->product->product_box): ?><li><a href="#shop-tab3" data-toggle="tab"><?php echo JText::_('COM_VIRTUEMART_SEARCH_ORDER_PRODUCT_PACKAGING'); ?></a></li><?php endif; ?>
	</ul>
	
	<div class="tab-content">
		<div class="tab-pane active" id="shop-desc">
		<?php
		// Product Description
		if (!empty($this->product->product_desc)) {
			?>
			<div class="product-description">
				<?php echo $this->product->product_desc; ?>
			</div>
		<?php
		} // Product Description END
		?>
		</div>
		<div class="tab-pane specialBehavior" id="shop-rating">
			<?php echo $this->loadTemplate('reviews'); ?>
		</div>
		
		<?php if ($this->product->product_box): ?>
		<div class="tab-pane" id="shop-tab3">
			<?php
			// Product Packaging
			$product_packaging = '';
			if ($this->product->product_box) {
			?>
				<div class="product-box">
					<?php echo JText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box; ?>
				</div>
				
			<?php } // Product Packaging END ?>
		</div>
		<?php endif; ?>
	</div>
</div>

	<?php
    if (!empty($this->product->customfieldsSorted['normal'])) {
		$this->position = 'normal';
		echo $this->loadTemplate('customfields');
    } // Product custom_fields END
	?>

    <?php

    if (!empty($this->product->customfieldsRelatedProducts)) {
	echo $this->loadTemplate('relatedproducts');
    } // Product customfieldsRelatedProducts END

    if (!empty($this->product->customfieldsRelatedCategories)) {
		echo $this->loadTemplate('relatedcategories');
    } // Product customfieldsRelatedCategories END
    // Show child categories
    if (VmConfig::get('showCategory', 1)) {
		echo $this->loadTemplate('showcategory');
    }
    if (!empty($this->product->customfieldsSorted['onbot'])) {
    	$this->position='onbot';
    	echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>

	<?php // onContentAfterDisplay event
	echo $this->product->event->afterDisplayContent; ?>

	</div>

	<?php
	// Product Navigation
	if (VmConfig::get('product_navigation', 1)) {
	?>
</div>

<div class="row-fluid product-page">
	<div class="span12 product-neighbours">
	    <?php

	    if (!empty($this->product->neighbours ['previous'][0])) {
			$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
			echo JHTML::_('link', $prev_link, '<span class="icon-chevron-left"></span>'.$this->product->neighbours ['previous'][0]['product_name'], array('class' => 'previous-page'));
	    }
	    if (!empty($this->product->neighbours ['next'][0])) {
			$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
			echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'].'<span class="icon-chevron-right"></span>', array('class' => 'next-page'));
	    }
		
//			$view = JRequest::getCmd('view');
//			if ($view == 'article') {

//				$doc = &JFactory::getDocument();
//
//				$apiId = '4600019';
//				$width = '800';
//				$comLimit = '10';
//				$attach = '*';
//				$autoPublish = 1;
//				$norealtime = '0';
//				$script = "VK.init({apiId: $apiId, onlyWidgets: true});";
//
//				$doc->addScript("http://vkontakte.ru/js/api/openapi.js?22");
//				$doc->addScriptDeclaration($script);
//
//				$pagehash = 63;
//				$scriptPage = <<<HTML
//								<script type="text/javascript" src="//vk.com/js/api/openapi.js?96"></script>
//								<script type="text/javascript">
//									VK.init({apiId: $apiId, onlyWidgets: true});
//								</script>
//								<div id="tabs-$j"><div id='jlcomments'></div>
//									<script type='text/javascript'>
//										VK.Widgets.Comments('jlcomments', {limit: $comLimit, width: '$width', attach: '$attach', autoPublish: $autoPublish, norealtime: $norealtime,pageUrl:'$url_base'},$pagehash);
//                                    </script>
//								</div>
//					
//HTML;
//                                echo $scriptPage;
                                

//			}
		
                
	
	    ?>   
            
    <div class="clear"></div>
    </div>
    <?php } // Product Navigation END ?>
</div>
