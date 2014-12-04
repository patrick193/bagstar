<?php
defined('_JEXEC') or 	die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' ) ;
/**
 *
 * @author SM planet - smplanet.net
 * @package VirtueMart
 * @subpackage custom
 * @copyright Copyright (C) 2012-2014 SM planet - smplanet.net. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 **/

if (!class_exists('vmCustomPlugin')) require(JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php');

class plgVmCustomCatproduct extends vmCustomPlugin {


	function __construct(& $subject, $config) {
		parent::__construct($subject, $config);

		$varsToPush = array(	'use_default'=>array(0.0,'bool'),	
								'use_default2'=>array(0.0,'bool'),	
								'sorting_field'=>array('default','string'),
								'layout_field'=>array('default.php','string'),
								'show_image'=>array(0,'bool'),
								'show_id'=>array(0.0,'bool'),
						    	'show_sku'=>array(0.0,'bool'),
						    	'show_name'=>array(0.0,'bool'),
								'show_s_desc'=>array(0.0,'bool'),
								'show_weight'=>array(0.0,'bool'),
								'show_sizes'=>array(0.0,'bool'),
								'show_stock'=>array(0.0,'bool'),
								'show_min_qty'=>array(0.0,'bool'),
								'show_max_qty'=>array(0.0,'bool'),
								'show_step_qty'=>array(0.0,'bool'),
								'show_basePrice'=>array(0.0,'bool'),
								'show_basePriceWithTax'=>array(0.0,'bool'),
								'show_salesPrice'=>array(0.0,'bool'),
								'show_taxAmount'=>array(0.0,'bool'),
								'show_priceWithoutTax'=>array(0.0,'bool'),
								'show_discountAmount'=>array(0.0,'bool'),
								'show_sum_weight'=>array(0.0,'bool'),
								'show_sum_basePrice'=>array(0.0,'bool'),
								'show_sum_basePriceWithTax'=>array(0.0,'bool'),
								'show_sum_salesPrice'=>array(0.0,'bool'),
								'show_sum_taxAmount'=>array(0.0,'bool'),
								'show_sum_priceWithoutTax'=>array(0.0,'bool'),
								'show_sum_discountAmount'=>array(0.0,'bool'),
								'show_total_weight'=>array(0.0,'bool'),
								'show_total_basePrice'=>array(0.0,'bool'),
								'show_total_basePriceWithTax'=>array(0.0,'bool'),
								'show_total_salesPrice'=>array(0.0,'bool'),
								'show_total_taxAmount'=>array(0.0,'bool'),
								'show_total_priceWithoutTax'=>array(0.0,'bool'),
								'show_total_discountAmount'=>array(0.0,'bool'),
								'enable_attached_products'=>array(0.0,'bool'),
								'enable_title_for_attached'=>array(0.0,'bool'),
								'title_for_attached_products'=>array('','string'),
								'id_sku_for_attached_products'=>array('','string'),
								'attached_products'=>array('','string'),
								'enable_attached_products_array'=>array('','array'),
								'enable_title_for_attached_array'=>array('','array'),
								'title_for_attached_products_array'=>array('', 'array'),
								'id_sku_for_attached_products_array'=>array('','array'),
								'attached_products_array'=>array('','array'),
								'use_max_min_quantity'=>array(0,'bool'),
								'use_box_quantity'=>array(0,'bool'),
								'update_prices'=>array(0,'bool'),
								'attached_array'=>array(0,'bool'),
								'add_parent_to_table'=>array(0,'bool'),
								'add_parent_from_original'=>array(0,'bool'),
								'do_not_show_child'=>array(0,'bool'),
								'add_plugin_support'=>array(0,'integer'),
								'enable_cs'=>array(0,'bool'),
								'c_string_1'=>array('','string'),
								'c_string_2'=>array('','string'),
								'c_string_3'=>array('','string'),
								'c_string_4'=>array('','string'),
								'c_string_5'=>array('','string'),
								'hide_original_addtocart'=>array('css','string'),
								'original_addtocart_css'=>array('.addtocart-area','string'),
								'orig_add_area'=>array('.productdetails-view .addtocart-area','string'),
								'override'=>array(0,'bool')
		);

		$this->setConfigParameterable('custom_params',$varsToPush);

	}

	// get product param for this plugin on edit
	function plgVmOnProductEdit($field, $product_id, &$row,&$retValue) {
		if ($field->custom_element != $this->_name) return '';
		$this->parseCustomParams($field);
		/*print_r($field->custom_params);
		echo "<br/>";
		print_r($field->original_addtocart_css);
		echo "<br/>";*/
		$host = JURI::root();
		$document = JFactory::getDocument();
		$document->addScript($host."/plugins/vmcustom/catproduct/catproduct/js/catproduct-admin.js");
		$document->addStyleDeclaration("
.catproduct-button {
-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#000000;
	font-family:arial;
	font-size:13px;
	font-weight:normal;
	padding:5px 20px;
	text-decoration:none;
	text-shadow:1px 1px 0px #ffffff;
}.classname:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.classname:active {
	position:relative;
	top:1px;
}");
	
		$html = '';
		$hide = '';
		// array for sorting
		$sorting = array(
			array("value" => "default", "text" => "Default"),
			array("value" => "sortid", "text" => "Product ID"),
			array("value" => "sortsku", "text" => "Product SKU"),
			array("value" => "sortname", "text" => "Product Name"),
			array("value" => "sortweight", "text" => "Product Weight"),
			array("value" => "sortlength", "text" => "Product Length"),
			array("value" => "sortwidth", "text" => "Product Width"),
			array("value" => "sortheight", "text" => "Product Height"),
			array("value" => "sortprice", "text" => "Product Price")
			);
		// array for attached select
		$field_attached = array(
			array("value" => "id", "text" => "Product ID"),
			array("value" => "sku", "text" => "Product SKU")
			);
		// get layout files
		$layout_f = array ();
		$directory = "../plugins/vmcustom/catproduct/catproduct/tmpl/";
 
		//get all image files with a .jpg extension.
		$layouts = glob($directory . "*.php");
 
		$i = 0;
		foreach($layouts as $layout)
		{
			$layout = str_replace($directory, "", $layout);
			$layout_f[$i]["value"] = $layout;
			$layout_f[$i]["text"] = $layout;
			$i++;
		}
		
		//fill $hideaddtocart
		$hideaddtocart = array(
			array("value" => "css", "text" => "Hide with css (may hide button also on page without catproduct)"),
			array("value" => "js", "text" => "Hide with JavaScript (may not work on some templates)"),
			array("value" => "no", "text" => "Don't hide original addtocart button")
			);
			
			
		$handle_plugins = array(
			array("value" => "0", "text" => "Don't handle plug-ins (Additional custom-fields are not shown)"),
			array("value" => "1", "text" => "Custom-fields for each product (Custom-fields are shown in row, can be different for each product)")
			);
		/*	array("value" => "2", "text" => "Shows Custom-fields at the end of table (Comes only from parent product, same for all products, even attached one! they are added to all products even if they don't have this custom-field!)")
			);*/
			
		$html .='
			<fieldset  class="testiranje">
				<legend>'. JText::_('CATPRODUCT_FIELDSET1_TITLE') .'</legend>';
		
		$html2 = '';
		
		if ($field->use_default2 != 1) {
		 $html2 .=   '<tr><td class="key">'. JText::_('CATPRODUCT_CHOOSE_LAYOUT') .'</td><td>'
					.JHTML::_ ('select.genericlist', $layout_f, 'custom_param['.$row.'][layout_field]', 'aaa', 'value', 'text', $field->layout_field).'</td></tr>
					<tr><td class="key">'. JText::_('CATPRODUCT_HIDE_ADDTOCART') .'</td><td>
					'.JHTML::_ ('select.genericlist', $hideaddtocart, 'custom_param['.$row.'][hide_original_addtocart]', 'aaa', 'value', 'text', $field->hide_original_addtocart).'</td></tr>
					'.VmHTML::row('input',JText::_('CATPRODUCT_ORIGINAL_ADDTOCART_CSS'), 'custom_param['.$row.'][original_addtocart_css]',$field->original_addtocart_css).'
					'.VmHTML::row('input',JText::_('CATPRODUCT_ORIGINALADDTOCARTAREACLASS'), 'custom_param['.$row.'][orig_add_area]',$field->orig_add_area);		
		} else $html .='<p><strong>Use_default is set to yes in plug-in configuration</strong></p>';
		if ($field->use_default == 1) {
		 $hide = "display:none;";
		 $html .='<p><strong>Use_default for product fields is set to yes in plug-in configuration</strong></p>';
		}

		$html .='
					<fieldset>
					<legend>'. JText::_('CATPRODUCT_FIELDSET6_TITLE') .'</legend>
					<table class="admintable"><tr><td class="key">'. JText::_('CATPRODUCT_CHOOSE_SORTING') .'</td><td>
					'.JHTML::_ ('select.genericlist', $sorting, 'custom_param['.$row.'][sorting_field]', '', 'value', 'text', $field->sorting_field).'</td></tr>
					'.$html2.'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_OVERRIDE_CHILD_SETTINGS'), 'custom_param['.$row.'][override]',$field->override).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_UPDATE_PRICES'), 'custom_param['.$row.'][update_prices]',$field->update_prices).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_USE_MAX_MIN'), 'custom_param['.$row.'][use_max_min_quantity]',$field->use_max_min_quantity).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_USE_BOX_QUANTITY'), 'custom_param['.$row.'][use_box_quantity]',$field->use_box_quantity).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_ADDPARENTTOTABLE'), 'custom_param['.$row.'][add_parent_to_table]',$field->add_parent_to_table).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_ADDPARENTFROMORIGINAL'), 'custom_param['.$row.'][add_parent_from_original]',$field->add_parent_from_original).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_DO_NOT_SHOW_CHILD'), 'custom_param['.$row.'][do_not_show_child]',$field->do_not_show_child).'
					<tr><td class="key">'. JText::_('CATPRODUCT_ADD_CUSTOMFIELDS_SUPPORT') .'</td><td>
					'.JHTML::_ ('select.genericlist', $handle_plugins, 'custom_param['.$row.'][add_plugin_support]', 'aaa', 'value', 'text', $field->add_plugin_support).'
					</table>
					</fieldset>';
					
					if (isset($field->enable_cs) && $field->enable_cs == 1) {
					
		$html .='	<fieldset>
					<legend>'. JText::_('CATPRODUCT_FIELDSET7_TITLE') .'</legend>
					<table class="admintable">
					'.VmHTML::row('input',JText::_('CATPRODUCT_CUSTOMSTRING_TITLE_1'), 'custom_param['.$row.'][c_string_1]',$field->c_string_1).'
					'.VmHTML::row('input',JText::_('CATPRODUCT_CUSTOMSTRING_TITLE_2'), 'custom_param['.$row.'][c_string_2]',$field->c_string_2).'
					'.VmHTML::row('input',JText::_('CATPRODUCT_CUSTOMSTRING_TITLE_3'), 'custom_param['.$row.'][c_string_3]',$field->c_string_3).'
					'.VmHTML::row('input',JText::_('CATPRODUCT_CUSTOMSTRING_TITLE_4'), 'custom_param['.$row.'][c_string_4]',$field->c_string_4).'
					'.VmHTML::row('input',JText::_('CATPRODUCT_CUSTOMSTRING_TITLE_5'), 'custom_param['.$row.'][c_string_5]',$field->c_string_5).'
					</table>
					</fieldset>';
					}
					
		$html .='	<fieldset style='.$hide.'>
					<legend>'. JText::_('CATPRODUCT_FIELDSET2_TITLE') .'</legend>
					<table class="admintable">
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SHOWIMAGE'), 'custom_param['.$row.'][show_image]',$field->show_image).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SHOWID'), 'custom_param['.$row.'][show_id]',$field->show_id).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SHOWSKU'), 'custom_param['.$row.'][show_sku]',$field->show_sku).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SHOWNAME'), 'custom_param['.$row.'][show_name]',$field->show_name).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SHOWSDESC'), 'custom_param['.$row.'][show_s_desc]',$field->show_s_desc).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_WEIGHT'), 'custom_param['.$row.'][show_weight]',$field->show_weight).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SIZES'), 'custom_param['.$row.'][show_sizes]',$field->show_sizes).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_STOCK'), 'custom_param['.$row.'][show_stock]',$field->show_stock).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SHOW_MIN_QTY'), 'custom_param['.$row.'][show_min_qty]',$field->show_min_qty).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SHOW_MAX_QTY'), 'custom_param['.$row.'][show_max_qty]',$field->show_max_qty).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SHOW_STEP_QTY'), 'custom_param['.$row.'][show_step_qty]',$field->show_step_qty).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_BASEPRICE'), 'custom_param['.$row.'][show_basePrice]',$field->show_basePrice).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_BASEPRICEWITHTAX'), 'custom_param['.$row.'][show_basePriceWithTax]',$field->show_basePriceWithTax).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_PRICEWITHOUTTAX'), 'custom_param['.$row.'][show_priceWithoutTax]',$field->show_priceWithoutTax).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SALESPRICE'), 'custom_param['.$row.'][show_salesPrice]',$field->show_salesPrice).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_TAXAMOUNT'), 'custom_param['.$row.'][show_taxAmount]',$field->show_taxAmount).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_DISCOUNTAMOUNT'), 'custom_param['.$row.'][show_discountAmount]',$field->show_discountAmount).'
					</table>
					</fieldset>
					<fieldset style='.$hide.'>
					<legend>'. JText::_('CATPRODUCT_FIELDSET3_TITLE') .'</legend>
					<table class="admintable">
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SUM_WEIGHT'), 'custom_param['.$row.'][show_sum_weight]',$field->show_sum_weight).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SUM_BASEPRICE'), 'custom_param['.$row.'][show_sum_basePrice]',$field->show_sum_basePrice).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SUM_BASEPRICEWITHTAX'), 'custom_param['.$row.'][show_sum_basePriceWithTax]',$field->show_sum_basePriceWithTax).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SUM_PRICEWITHOUTTAX'), 'custom_param['.$row.'][show_sum_priceWithoutTax]',$field->show_sum_priceWithoutTax).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SUM_SALESPRICE'), 'custom_param['.$row.'][show_sum_salesPrice]',$field->show_sum_salesPrice).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SUM_TAXAMOUNT'), 'custom_param['.$row.'][show_sum_taxAmount]',$field->show_sum_taxAmount).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_SUM_DISCOUNTAMOUNT'), 'custom_param['.$row.'][show_sum_discountAmount]',$field->show_sum_discountAmount).'
					</table>
					</fieldset>
					<fieldset style='.$hide.'>
					<legend>'. JText::_('CATPRODUCT_FIELDSET4_TITLE') .'</legend>
					<table class="admintable">
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_TOTAL_WEIGHT'), 'custom_param['.$row.'][show_total_weight]',$field->show_total_weight).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_TOTAL_BASEPRICE'), 'custom_param['.$row.'][show_total_basePrice]',$field->show_total_basePrice).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_TOTAL_BASEPRICEWITHTAX'), 'custom_param['.$row.'][show_total_basePriceWithTax]',$field->show_total_basePriceWithTax).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_TOTAL_PRICEWITHOUTTAX'), 'custom_param['.$row.'][show_total_priceWithoutTax]',$field->show_total_priceWithoutTax).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_TOTAL_SALESPRICE'), 'custom_param['.$row.'][show_total_salesPrice]',$field->show_total_salesPrice).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_TOTAL_TAXAMOUNT'), 'custom_param['.$row.'][show_total_taxAmount]',$field->show_total_taxAmount).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_TOTAL_DISCOUNTAMOUNT'), 'custom_param['.$row.'][show_total_discountAmount]',$field->show_total_discountAmount).'
					</table>
					</fieldset>';
					
		if (isset($field->attached_array) && $field->attached_array == 1) {
			$i=0;
			$enable_attached_products_array = (array) $field->enable_attached_products_array;
			$enable_title_for_attached_array = (array) $field->enable_title_for_attached_array;
			$title_for_attached_products_array = (array) $field->title_for_attached_products_array;
			$id_sku_for_attached_products_array = (array) $field->id_sku_for_attached_products_array;
			$attached_products_array = (array) $field->attached_products_array;
			
			foreach($enable_attached_products_array as $blabla) {
					$html .='<fieldset id="catproduct_attach_fieldset'.$i.'">
					<legend>'. JText::_('CATPRODUCT_FIELDSET5_TITLE') .'</legend>
					<table class="admintable">
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_ENABLE_ATTACHED_PRODUCTS'), 'custom_param['.$row.'][enable_attached_products_array]['.$i.']',$blabla).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_ENABLE_ATTACHED_TITLE'), 'custom_param['.$row.'][enable_title_for_attached_array]['.$i.']',current($enable_title_for_attached_array)).'
					'.VmHTML::row('input',JText::_('CATPRODUCT_TITLE_ATTACHED_PRODUCTS'), 'custom_param['.$row.'][title_for_attached_products_array]['.$i.']',current($title_for_attached_products_array)).'
					<tr><td class="key">'.JText::_('CATPRODUCT_ATTACHED_SEARCH').'</td><td>
					'.JHTML::_ ('select.genericlist', $field_attached, 'custom_param['.$row.'][id_sku_for_attached_products_array]['.$i.']', '', 'value', 'text', current($id_sku_for_attached_products_array)).'
					</td></tr>
					'.VmHTML::row('input',JText::_('CATPRODUCT_ATTACHED_PRODUCTS'), 'custom_param['.$row.'][attached_products_array]['.$i.']',current($attached_products_array)).'
					</table>
					<div style="float:right;" class="catproduct-button" onclick="catproduct_remove_attached(\''.$i.'\')" >'.JText::_('CATPRODUCT_ATTACHED_ARRAY_REMOVE').'</div>
					</fieldset>';
					
				next($enable_title_for_attached_array);
				next($title_for_attached_products_array);
				next($id_sku_for_attached_products_array);
				next($attached_products_array);
				$i++;
			}
	
			$javascript = "<script type='text/javascript'>";
			$javascript .= "var attached_fieldset_text = '".JText::_('CATPRODUCT_FIELDSET5_TITLE')."';";
			$javascript .= "var attached_enable_text = '".JText::_('CATPRODUCT_ENABLE_ATTACHED_PRODUCTS')."';";
			$javascript .= "var attached_enable_title_text = '".JText::_('CATPRODUCT_ENABLE_ATTACHED_TITLE')."';";
			$javascript .= "var attached_title_text = '".JText::_('CATPRODUCT_TITLE_ATTACHED_PRODUCTS')."';";
			$javascript .= "var attached_product_text = '".JText::_('CATPRODUCT_ATTACHED_PRODUCTS')."';";
			$javascript .= "var attached_finder_text = '".JText::_('CATPRODUCT_ATTACHED_SEARCH')."';";
			$javascript .= "var attached_remove_text = '".JText::_('CATPRODUCT_ATTACHED_ARRAY_REMOVE')."';";
			$javascript .= "var attached_count=".$i.";";
			$javascript .= "var catproduct_row=".$row.";";
			$javascript .= "</script>";
			
		}
		else {
		$html .='	<fieldset>
					<legend>'. JText::_('CATPRODUCT_FIELDSET5_TITLE') .'</legend>
					<table class="admintable">
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_ENABLE_ATTACHED_PRODUCTS'), 'custom_param['.$row.'][enable_attached_products]',$field->enable_attached_products).'
					'.VmHTML::row('checkbox',JText::_('CATPRODUCT_ENABLE_ATTACHED_TITLE'), 'custom_param['.$row.'][enable_title_for_attached]',$field->enable_title_for_attached).'
					'.VmHTML::row('input',JText::_('CATPRODUCT_TITLE_ATTACHED_PRODUCTS'), 'custom_param['.$row.'][title_for_attached_products]',$field->title_for_attached_products).'
					<tr><td class="key">'.JText::_('CATPRODUCT_ATTACHED_SEARCH').'</td><td>
					'.JHTML::_ ('select.genericlist', $field_attached, 'custom_param['.$row.'][id_sku_for_attached_products]', '', 'value', 'text', $field->id_sku_for_attached_products).'
					</td></tr>
					'.VmHTML::row('input',JText::_('CATPRODUCT_ATTACHED_PRODUCTS'), 'custom_param['.$row.'][attached_products]',$field->attached_products).'
					</table>
					</fieldset>';
			
		}
		$html .='
			</fieldset>
			';
		if (isset($field->attached_array) && $field->attached_array == 1) {
			$html .= $javascript;
			$html .= '<div class="catproduct-button" onClick="catproduct_add_attached()">'.JText::_('CATPRODUCT_ATTACHED_ARRAY_ADD').'</div>';
		}
		$retValue .= $html;
		$row++;
		return true ;
	}

	function plgVmOnDisplayProductVariantFE($field,&$idx,&$group) {
    }
	private static function sortid($a, $b) {
		$a = $a['child']['virtuemart_product_id'];
		$b = $b['child']['virtuemart_product_id'];
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
   }
   private static function sortsku($a, $b) {
		$a = $a['child']['product_sku'];
		$b = $b['child']['product_sku'];
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
   }
   private static function sortname($a, $b) {
		$a = $a['child']['product_name'];
		$b = $b['child']['product_name'];
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
   }
   private static function sortweight($a, $b) {
		$a = $a['child']['product_weight'];
		$b = $b['child']['product_weight'];
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
   }
   private static function sortlength($a, $b) {
		$a = $a['child']['product_length'];
		$b = $b['child']['product_length'];
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
   }
   private static function sortwidth($a, $b) {
		$a = $a['child']['product_width'];
		$b = $b['child']['product_width'];
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
   }
   private static function sortheight($a, $b) {
		$a = $a['child']['product_height'];
		$b = $b['child']['product_height'];
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
   }
   private static function sortprice($a, $b) {
		$a = $a['prices']['salesPrice'];
		$b = $b['prices']['salesPrice'];
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
   }
   function max_min_box_quantity ($product1,$use_min_max,$use_box_quantity) {
		$quantityp = Array ();
		$quantity_param = $product1['product_params'];
		$quantity_param = explode("|",$quantity_param);
		$min_order_level = explode("=",$quantity_param[0]);
		$max_order_level = explode("=",$quantity_param[1]);
		$product_box = explode("=",$quantity_param[2]);
		
		if ($use_min_max <> 0) {
			$quantityp["min"] = $min_order_level[1];
			$quantityp["max"] = $max_order_level[1];
		}
		else {
			$quantityp["min"] = 0;
			$quantityp["max"] = 0;
		}
		if ($use_box_quantity <> 0) {
			$quantityp["box"] = $product_box[1];
		}
		else {
			$quantityp["box"] = 0;
		}
		return $quantityp;
   }
   function plgVmOnDisplayProductFE($product,&$idx,&$group) {
		// if not Catproduct return ''
		if ($group->custom_element != $this->_name) return '';
		
		// Get the global defaults, so we can pass them to and use them in tmpl/default.php
		$global_params = Array();
		foreach(explode('|', $group->custom_params) as $item){
			$item = explode('=',$item);
			$key = $item[0];
			unset($item[0]);
			$item = implode('=',$item);
			if(!empty($item)){
				$global_params[$key] = json_decode($item);
			}
		}
		
		// get parameters
		$parametri = json_decode($group->custom_param, true);
		
		// if default parameters set, fix current one
		if ($global_params['use_default2'] == 1) {
			$parametri['hide_original_addtocart'] = $global_params['hide_original_addtocart'];
			$parametri['original_addtocart_css'] = $global_params['original_addtocart_css'];
			$parametri['orig_add_area'] = $global_params['orig_add_area'];
			$parametri['layout_field'] = $global_params['layout_field'];
		}
	
		// parameter for min max box quantity
		if (isset($parametri['use_max_min_quantity'])) $use_min_max = $parametri['use_max_min_quantity']; else $use_min_max = 0;
		if (isset($parametri['use_box_quantity'])) $use_box_quantity = $parametri['use_box_quantity']; else $use_box_quantity = 0;
		
		// get produc model
		$products = Array();
		$productModel = VmModel::getModel ('product');
		
		// this prevent virtuemart overriding plugins for child products
		if (isset($parametri['override']) && $parametri['override'] == 1) {
			if (isset($product->product_parent_id) && $product->product_parent_id <> 0) {
				$product = $productModel->getProduct($product->product_parent_id, true);
			}
		}
		
		// get childrens
		$uncatChildren = $productModel->getProductChildIds($product->virtuemart_product_id);
		
		// hide original addtocart button if javascript is ussed for hiding
		$document = JFactory::getDocument();
		
		if (isset($parametri["hide_original_addtocart"]) && $parametri["hide_original_addtocart"] == "js") {
			if (isset($parametri["original_addtocart_css"]) && $parametri["original_addtocart_css"] <> '') {
				$document->addScriptDeclaration('jQuery(document).ready(function() {
					jQuery("input[name^=virtuemart_product_id][value='.$product->virtuemart_product_id.']").parent().children(".addtocart-bar").css("display","none");
				});');			
			} else {
				$document->addScriptDeclaration('jQuery(document).ready(function() {
					jQuery("input[name^=virtuemart_product_id][value='.$product->virtuemart_product_id.']").parent().children(".addtocart-bar").css("display","none");
				});');
			}
		}
		
		// check if virtuemart_product_id is in url and if it's the same as the one in Catproduct, else return ''
		// this prevent Catproduct to be loaded in modules or category view because of some issues
		$shown_product_id = JRequest::getInt('virtuemart_product_id');
		if (!in_array($shown_product_id, $uncatChildren) && $shown_product_id != $product->virtuemart_product_id) return '';
		
		
		// hide original addtocart button if javascript is ussed for hiding		
		if (isset($parametri["hide_original_addtocart"]) && $parametri["hide_original_addtocart"] == "js") {
			if (isset($parametri["original_addtocart_css"]) && $parametri["original_addtocart_css"] <> '') {
				$document->addScriptDeclaration('jQuery(document).ready(function() {
					jQuery("input[name^=virtuemart_product_id][value='.$product->virtuemart_product_id.']").closest(".productdetails").find("'.$parametri["original_addtocart_css"].'").css("display","none");
				});');			
			} else {
				$document->addScriptDeclaration('jQuery(document).ready(function() {
					jQuery("input[name^=virtuemart_product_id][value='.$product->virtuemart_product_id.']").closest(".productdetails").find(".addtocart-area").css("display","none");
				});');
			}
		}
		
		// set counter
		$i = 0;
		
		$parent_product = $this->getCatproductProduct($product->virtuemart_product_id, $product, $use_min_max, $use_box_quantity);
		
		// for adding parent to table
		if (isset($parametri["add_parent_to_table"]) && $parametri["add_parent_to_table"] == 1) {
			// get whole product
			$products[$i] = $parent_product;
			$i++;
		}
		
		// get children
		if (!isset($parametri["do_not_show_child"]) || $parametri["do_not_show_child"] <> "1") {
			foreach ($uncatChildren as $child) {
				if($child <> $product->virtuemart_product_id) {
					// get whole product
					$product_temp = $this->getCatproductProduct($child, $product, $use_min_max, $use_box_quantity);
					// check if product has children
					$child_chilren = $productModel->getProductChildIds($child);
					if ($child_chilren) {
						$products[$i]['child']['catproduct_inline_row'] = "groupstart";
						$i++;
						//var_dump($child_chilren);
						foreach ($child_chilren as $child_child) {
							$products[$i] = $this->getCatproductProduct($child_child, $product, $use_min_max, $use_box_quantity);
							if ($products[$i]) {
								$i++;
							} else {
								unset($products[$i]);
							}
						}
						$products[$i]['child']['catproduct_inline_row'] = "groupend";
					}
					else {
						$products[$i] = $product_temp;
					}
					if ($products[$i]) {
						$i++;
					} else {
						unset($products[$i]);
					}
					
					//$products[$i]['child']['catproduct_inline_row'] = $parametri["title_for_attached_products"];
			}
		}
		
			//sort children if sording <> default
			if(isset($parametri["sorting_field"]) && $parametri["sorting_field"] <> 'default') {
				$sortingfield = $parametri["sorting_field"];
				usort($products, Array("plgVmCustomCatproduct",$sortingfield));
			}	
		}
		
		// if enable attache products
		if (isset($parametri["enable_attached_products"]) && $parametri["enable_attached_products"] == 1) {
			$pripeti_artikli_k = array();
			$find_id = 0;
			$no_product = 0;
			if (isset($parametri["id_sku_for_attached_products"])) {
				if ($parametri["id_sku_for_attached_products"] == 'sku') {
					$db =JFactory::getDBO();
					$find_id = 1;
					$ids=0;
				} else if ($parametri["id_sku_for_attached_products"] == 'noprod'){
					$no_product = 1;
				}
			}
			// get ids of attached
			$pripeti_artikli = $parametri["attached_products"];
			if (!empty($pripeti_artikli)) {
				$pripeti_artikli = explode(",",$pripeti_artikli);
				// if custom title is enabled
				if ($parametri["enable_title_for_attached"] == 1) {
					// get title
					$products[$i]['child']['catproduct_inline_row'] = $parametri["title_for_attached_products"];
					$i++;
				}
				if ($no_product <> 1) {
					if ($find_id == 1) {
						foreach ($pripeti_artikli as $pripet_artikel) {
							$q = 'SELECT `virtuemart_product_id` as id FROM `#__virtuemart_products` WHERE `published`=1
							AND `product_sku`= "' . $pripet_artikel . '"';
							$db->setQuery ($q);
							$prodids = $db->loadObjectList();
							foreach ($prodids as $prodid) {
								$pripeti_artikli_k[$ids] = $prodid->id;
								$ids++;
							}
						}
					}
					else {
						$pripeti_artikli_k = $pripeti_artikli;
					}
					// get attached products
					foreach ($pripeti_artikli_k as $pripet_artikel) {
						// get whole product
						$products[$i] = $this->getCatproductProduct($pripet_artikel, $product, $use_min_max, $use_box_quantity);
						if ($products[$i]) {
							$i++;
						} else {
							unset($products[$i]);
						}
					}
				}
				else {
					foreach ($pripeti_artikli as $someadds) {
						$products[$i]['child']['someadds'] = $someadds;
						$i++;
					}
				}
			}
		}
		// now code for attached with array
		else if (isset($global_params["attached_array"]) && $global_params["attached_array"] == 1) {
			if(isset($parametri["enable_attached_products_array"])) {
				$enable_attached_products_array = (array) $parametri["enable_attached_products_array"];
				$enable_title_for_attached_array = (array) $parametri["enable_title_for_attached_array"];
				$title_for_attached_products_array = (array) $parametri["title_for_attached_products_array"];
				$id_sku_for_attached_products_array = (array) $parametri["id_sku_for_attached_products_array"];
				$attached_products_array = (array) $parametri["attached_products_array"];
				foreach ($enable_attached_products_array as $enable_attached) {
					if ($enable_attached == 1) {
						$id_sku = current($id_sku_for_attached_products_array);
						$title_for_attached = current($title_for_attached_products_array);
						$attached_products = current($attached_products_array);
						$enable_title = current($enable_title_for_attached_array);
					
						$pripeti_artikli_k = array();
						$find_id = 0;
						$no_product = 0;
						if (isset($id_sku)) {
							if ($id_sku == 'sku') {
								$db =JFactory::getDBO();
								$find_id = 1;
								$ids=0;
							} else if ($id_sku == 'noprod'){
								$no_product = 1;
							}
						}
						
						// get ids of attached
						$pripeti_artikli = $attached_products;
						if (!empty($pripeti_artikli)) {
							$pripeti_artikli = explode(",",$pripeti_artikli);
							// if custom title is enabled
							if ($enable_title == 1) {
								// get title
								$products[$i]['child']['catproduct_inline_row'] = $title_for_attached;
								$i++;
							}
							if ($no_product <> 1) {
								if ($find_id == 1) {
									foreach ($pripeti_artikli as $pripet_artikel) {
										$q = 'SELECT `virtuemart_product_id` as id FROM `#__virtuemart_products` WHERE `published`=1
										AND `product_sku`= "' . $pripet_artikel . '"';
										$db->setQuery ($q);
										$prodids = $db->loadObjectList();
										foreach ($prodids as $prodid) {
											$pripeti_artikli_k[$ids] = $prodid->id;
											$ids++;
										}
									}
								}
								else {
									$pripeti_artikli_k = $pripeti_artikli;
								}
								// get attached products
								foreach ($pripeti_artikli_k as $pripet_artikel) {
									// get whole product
									$products[$i] = $this->getCatproductProduct($pripet_artikel, $product, $use_min_max, $use_box_quantity);
									if ($products[$i]) {
										$i++;
									} else {
										unset($products[$i]);
									}								
								}
							}
							else {
								foreach ($pripeti_artikli as $someadds) {
									$products[$i]['child']['someadds'] = $someadds;
									$i++;
								}
							}
						}
					}
					next($id_sku_for_attached_products_array);
					next($title_for_attached_products_array);
					next($attached_products_array);
					next($enable_title_for_attached_array);
				}
			}
		}
		
		// if dynamic price update is enabled
		if (isset($parametri["update_prices"]) && $parametri["update_prices"] == '1') {
			$updateprice = 1;
		}
		else {
			$updateprice = 0;
		}
		
		//add some JS
		if (!class_exists ('CurrencyDisplay')) {
			require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');
		}
		$currency = CurrencyDisplay::getInstance ();
		$price_format = $currency->getPositiveFormat();
		if (strpos($price_format,' ') !== false) {
			$price_format_space = ' ';
		}
		else {
			$price_format_space = '';
		}
		$price_format = preg_replace("/{/", "", $price_format);
		$price_format1 = explode("}", $price_format);
	
		if($price_format1[0] == "symbol") {
			$price_format = '0';
		}
		else if ($price_format1[1] == "symbol") {
			$price_format = '1';
		}
		else {
			$price_format = '1';
		}
		
		$addparentfromoriginal = '0';
		if (isset($parametri["add_parent_from_original"]) && $parametri["add_parent_from_original"] <> '') {
			$addparentfromoriginal = $parametri["add_parent_from_original"];
		}
		$orig_add_area = '.productdetails-view .addtocart-area';
		if (isset($parametri["orig_add_area"]) && $parametri["orig_add_area"] <> '') {
			$orig_add_area = $parametri["orig_add_area"];
		}

		$document->addScriptDeclaration('
		jQuery(document).ready(function() {
			if (typeof emptyQuantity == "function") { 
				emptyQuantity();
			}
			jQuery(".cell_customfields input").click(function () {
				row = jQuery(this).parent().parent().attr("id");
				row = row.replace("row_article_","");
				getPrice(row);
			});
			jQuery(".cell_customfields select").change(function () {
				row = jQuery(this).parent().parent().attr("id");
				row = row.replace("row_article_","");
				getPrice(row);
			});
			jQuery(".cell_parent_customfields input").click(function () {
				jQuery(".row_article").each(function() { getPrice(jQuery(this).attr("id").replace("row_article_","")); });
			});
			jQuery(".cell_parent_customfields select").change(function () {
				jQuery(".row_article").each(function() { getPrice(jQuery(this).attr("id").replace("row_article_","")); });
			});
		});
		var symbol_position = '.$price_format.';
		var symbol_space = "'.$price_format_space.'";
		var thousandssep = "'.$currency->getThousandsSeperator().'";
		var decimalsymbol = "'.$currency->getDecimalSymbol().'";
		var updateprice = '.$updateprice.';
		var noproducterror = "'.JText::_('CATPRODUCT_NO_PRODUCT').'";
		var noquantityerror = "'.JText::_('CATPRODUCT_NO_QUANTITY').'";
		var addparentoriginal = '.$addparentfromoriginal.';
		var mainproductname = "'.str_replace('"',"''",$product->product_name).'"; 
		var originaladdtocartareclass = "'.$orig_add_area.'";
		
		jQuery(document).ready(function() {
			if (addparentoriginal == 1) { 
				jQuery(".addtocart-bar").find(".quantity-input.js-recalculate").bind("propertychange keyup input paste", function(event) {
					FindMainProductPrice ();
				});
				jQuery(".addtocart-bar").find(".quantity-plus").click(function() {
					FindMainProductPrice ();
				});
				jQuery(".addtocart-bar").find(".quantity-minus").click(function() {
					FindMainProductPrice ();
				});
				
				FindMainProductPrice ();
			}
		
		jQuery("#catproduct_form a.ask-a-question").unbind();
		jQuery("#catproduct_form a.ask-a-question").click( function(){
				id = jQuery("#product_id_"+jQuery("#catproduct_form a.ask-a-question").parents(".row_article").attr("id").replace("row_article_","")).val();
				jQuery.fancybox({
				href: "/spletna-trgovina2/index.php?option=com_virtuemart&view=productdetails&task=askquestion&tmpl=component&virtuemart_product_id="+id,
				type: "iframe",
				height: "550"
			});
			return false ;
		});
		});
		');
		
		// hide original addtocart button if css is used for hidding
		if (isset($parametri["hide_original_addtocart"]) && $parametri["hide_original_addtocart"] == "css") {
			if (isset($parametri["original_addtocart_css"]) && $parametri["original_addtocart_css"] <> '') {
				$document->addStyleDeclaration($parametri["original_addtocart_css"].' {display:none;}');
			} else {
				$document->addStyleDeclaration('.addtocart-area {display:none;}');
			}
		}

		// get layout page
		if (isset($parametri["layout_field"])) {
			$layout = substr($parametri["layout_field"], 0, -4);
		}
		else {
			$layout = "default";
		}
		if($layout == '') $layout = 'default';
		
		// set everything back to normal
		$virtuemart_product_id = $productModel->setId ($product->virtuemart_product_id);
		$productModel->product = $product;
		
		$group->display .=  $this->renderByLayout($layout,array($products,&$idx,&$group,$global_params, $product, $parent_product) );

		return true;
	}

	function getCatproductProduct ($product_id = 0, $product, $use_min_max, $use_box_quantity) {
		if ($product_id == 0) return;
		
		$products = Array ();
		$productModel = VmModel::getModel ('product');
		$vendorModel = VmModel::getModel ('vendor');
		$mediaModel = VmModel::getModel('media');
		
		$artikel_cel = $this->getProduct($product_id);
		
		if ($artikel_cel->published == 0) return false;
		
		$prices = $productModel->getPrice ($artikel_cel, array(), 1);
		if (isset($artikel_cel->product_parent_id)) {
			$artikel_cel_parent = $this->getProductSingleCP($artikel_cel->product_parent_id);
			// fix customfields here
			foreach ($artikel_cel->customfieldsCart as $display) {
				$display->display = str_replace("custom_drop".$artikel_cel->product_parent_id, "custom_drop".$artikel_cel->virtuemart_product_id, $display->display);
				
				// for easycheckbox				
				$checkbox = json_decode(array_shift(array_values($display->options))->custom_param);
				if (isset($checkbox->custom_checkbox)) {
					$c_settings = explode(',', $checkbox->custom_checkbox);
					$i = 1;
					foreach ($c_settings as $c_settings111) {
						$display->display = str_replace("custom_checkbox".$i."_".$artikel_cel->product_parent_id, "custom_checkbox".$i."_".$artikel_cel->virtuemart_product_id, $display->display);
						$i++;
					}
				}
			}
		}
		// get product image
		$productModel->addImages($artikel_cel);
		if (isset($artikel_cel->virtuemart_media_id)) {
			$media_id = $artikel_cel->virtuemart_media_id;
		} else if (isset($artikel_cel_parent->virtuemart_media_id)) {
			$media_id = $artikel_cel_parent->virtuemart_media_id;
		} else if (isset($product->virtuemart_media_id)) {
			$media_id = $product->virtuemart_media_id;
		}
			else {
		$media_id = 0;
		}
		if($media_id <> 0) {
			$products['images'] = $mediaModel->createMediaByIds($media_id,'','',0);
		}
		$products['qparam'] = $this->max_min_box_quantity((array) $artikel_cel,$use_min_max,$use_box_quantity);
		$products['vendor'] = $vendorModel->getVendor ($product_id);
		$products['child'] = (array) $artikel_cel;
		$products['prices'] = $prices;
		
		return $products;
	}
/*	function plgVmOnViewCartModule( $product,$row,&$html) {
		return $this->plgVmOnViewCart($product,$row,$html);
    }

	function plgVmOnViewCart($product,$row,&$html) {
		return true;
    }

	function plgVmDisplayInOrderBE($item, $row, &$html) {
    }

	function plgVmDisplayInOrderFE($item, $row, &$html) {
    }

	public function plgVmOnStoreInstallPluginTable($psType) {
	}*/

	function plgVmDeclarePluginParamsCustom($psType,$name,$id, &$data){
		return $this->declarePluginParams('custom', $name, $id, $data);
	}

	function plgVmSetOnTablePluginParamsCustom($name, $id, &$table){
		return $this->setOnTablePluginParams($name, $id, $table);
	}

	function plgVmOnDisplayEdit($virtuemart_custom_id,&$customPlugin){
		return $this->onDisplayEditBECustom($virtuemart_custom_id,$customPlugin);
	}

/*	public function plgVmCalculateCustomVariant($product, &$productCustomsPrice,$selected){
	}

	public function plgVmDisplayInOrderCustom(&$html,$item, $param,$productCustom, $row ,$view='FE'){
	}

	public function plgVmCreateOrderLinesCustom(&$html,$item,$productCustom, $row ){
	}*/
	function plgVmOnSelfCallFE($type,$name,&$render) {
		$render->html = '';
	}

	function getProductSingleCP ($virtuemart_product_id = NULL, $front = TRUE, $quantity = 1) {
		$productModel = VmModel::getModel ('product');
		$db = JFactory::getDBO();
		
		//$this->fillVoidProduct($front);
		if (!empty($virtuemart_product_id)) {
			$virtuemart_product_id = $productModel->setId ($virtuemart_product_id);
		}

		//		if(empty($this->_data)){
		if (!empty($productModel->_id)) {

			$joinIds = array('virtuemart_manufacturer_id' => '#__virtuemart_product_manufacturers', 'virtuemart_customfield_id' => '#__virtuemart_product_customfields');

			$product = $productModel->getTable ('products');
			$product->load ($productModel->_id, 0, 0, $joinIds);

			$xrefTable = $productModel->getTable ('product_medias');
			$product->virtuemart_media_id = $xrefTable->load ((int)$productModel->_id);

			// Load the shoppers the product is available to for Custom Shopper Visibility
			
			$shoppergroups = array();
			if ($productModel->_id > 0) {
				$q = 'SELECT `virtuemart_shoppergroup_id` FROM `#__virtuemart_product_shoppergroups` WHERE `virtuemart_product_id` = "' . (int)$productModel->_id . '"';
				$db->setQuery($q);
				$shoppergroups = $db->loadResultArray ();
			}

			$product->shoppergroups = $shoppergroups;; // $productModel->getProductShoppergroups ($productModel->_id);

			$usermodel = VmModel::getModel ('user');
			$currentVMuser = $usermodel->getCurrentUser ();
			if(!is_array($currentVMuser->shopper_groups)){
				$virtuemart_shoppergroup_ids = (array)$currentVMuser->shopper_groups;
			} else {
				$virtuemart_shoppergroup_ids = $currentVMuser->shopper_groups;
			}

			if (!empty($product->shoppergroups) and $front) {
				if (!class_exists ('VirtueMartModelUser')) {
					require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'user.php');
				}
				$commonShpgrps = array_intersect ($virtuemart_shoppergroup_ids, $product->shoppergroups);
				if (empty($commonShpgrps)) {
					vmdebug('getProductSingle creating void product, usergroup does not fit ',$product->shoppergroups);
					return false; //$productModel->fillVoidProduct ($front);
				}
			}

			
			$productModel->_nullDate = $db->getNullDate();
			$jnow = JFactory::getDate();
			$productModel->_now = $jnow->toMySQL();
			$q = 'SELECT * FROM `#__virtuemart_product_prices` WHERE `virtuemart_product_id` = "'.$productModel->_id.'" ';

			if($front){
				if(count($virtuemart_shoppergroup_ids)>0){
					$q .= ' AND (';
					$sqrpss = '';
					foreach($virtuemart_shoppergroup_ids as $sgrpId){
						$sqrpss .= ' `virtuemart_shoppergroup_id` ="'.$sgrpId.'" OR ';
					}
					$q .= substr($sqrpss,0,-4);
					$q .= ' OR `virtuemart_shoppergroup_id` IS NULL OR `virtuemart_shoppergroup_id`="0") ';
				}
				$quantity = (int)$quantity;
				$q .= ' AND ( (`product_price_publish_up` IS NULL OR `product_price_publish_up` = "' . $db->getEscaped($productModel->_nullDate) . '" OR `product_price_publish_up` <= "' .$db->getEscaped($productModel->_now) . '" )
		        AND (`product_price_publish_down` IS NULL OR `product_price_publish_down` = "' .$db->getEscaped($productModel->_nullDate) . '" OR product_price_publish_down >= "' . $db->getEscaped($productModel->_now) . '" ) )';
				$q .= ' AND( (`price_quantity_start` IS NULL OR `price_quantity_start`="0" OR `price_quantity_start` <= '.$quantity.') AND (`price_quantity_end` IS NULL OR `price_quantity_end`="0" OR `price_quantity_end` >= '.$quantity.') )';
			} else {
				$q .= ' ORDER BY `product_price` DESC';
			}

			$db->setQuery($q);
			$product->prices = $db->loadAssocList();
			$err = $db->getErrorMsg();
			if(!empty($err)){
				vmError('getProductSingle '.$err);
			} else {
				//vmdebug('getProductSingle getPrice query',$q);
				//vmdebug('getProductSingle ',$product->prices);
			}

			if(count($product->prices)===0){
				//vmdebug('my prices count 0');
				$prices = array(
					'virtuemart_product_price_id' => 0
					,'virtuemart_product_id' => 0
					,'virtuemart_shoppergroup_id' => null
					,'product_price'         => null
					,'override'             => null
					,'product_override_price' => null
					,'product_tax_id'       => null
					,'product_discount_id'  => null
					,'product_currency'     => null
					,'product_price_vdate'  => null
					,'product_price_edate'  => null
					,'price_quantity_start' => null
					,'price_quantity_end'   => null
				);
				$product = (object)array_merge ((array)$prices, (array)$product);

			} else
			if(count($product->prices)===1){
				//vmdebug('my prices count 1',$prices[0]);
				$product = (object)array_merge ((array)$product->prices[0], (array)$product);
			} else if ( $front and count($product->prices)>1 ) {
				foreach($product->prices as $price){

					if(empty($price['virtuemart_shoppergroup_id'])){
						if(empty($emptySpgrpPrice))$emptySpgrpPrice = $price;
					} else if(in_array($price['virtuemart_shoppergroup_id'],$virtuemart_shoppergroup_ids)){
						$spgrpPrice = $price;
						//$product = (object)array_merge ((array)$price, (array)$product);
						break;
					}
					//$product = (object)array_merge ((array)$price, (array)$product);
				}

				if(!empty($spgrpPrice)){
					$product = (object)array_merge ((array)$spgrpPrice, (array)$product);
				}
				else if(!empty($emptySpgrpPrice)){
					$product = (object)array_merge ((array)$emptySpgrpPrice, (array)$product);
				} else {
					vmWarn('COM_VIRTUEMART_PRICE_AMBIGUOUS');
					$product = (object)array_merge ((array)$product->prices[0], (array)$product);
				}

			}

			if(!isset($product->product_price)) $product->product_price = null;
			if(!isset($product->product_override_price)) $product->product_override_price = null;
			if(!isset($product->override)) $product->override = null;

			if (!empty($product->virtuemart_manufacturer_id)) {
				$mfTable = $productModel->getTable ('manufacturers');
				$mfTable->load ((int)$product->virtuemart_manufacturer_id);
				$product = (object)array_merge ((array)$mfTable, (array)$product);
			}
			else {
				$product->virtuemart_manufacturer_id = array();
				$product->mf_name = '';
				$product->mf_desc = '';
				$product->mf_url = '';
			}

			// Load the categories the product is in
			//$product->categories = $this->getProductCategories ($this->_id, $front);
			$categories = array();
			if ($productModel->_id > 0) {
				$q = 'SELECT pc.`virtuemart_category_id` FROM `#__virtuemart_product_categories` as pc';
				if ($front) {
					$q .= ' LEFT JOIN `#__virtuemart_categories` as c ON c.`virtuemart_category_id` = pc.`virtuemart_category_id`';
				}
				$q .= ' WHERE pc.`virtuemart_product_id` = ' . (int)$virtuemart_product_id;
				if ($front) {
					$q .= ' AND `published`=1';
				}
				$db->setQuery ($q);
				$categories = $db->loadResultArray ();
			}

			$product->categories = $categories; //$this->getProductCategories ($productModel->_id, FALSE); //We need also the unpublished categories, else the calculation rules do not work

			if (!empty($product->categories) and is_array ($product->categories) and !empty($product->categories[0])) {
				$product->virtuemart_category_id = $product->categories[0];
				$q = 'SELECT `ordering`,`id` FROM `#__virtuemart_product_categories`
					WHERE `virtuemart_product_id` = "' . $productModel->_id . '" and `virtuemart_category_id`= "' . $product->virtuemart_category_id . '" ';
				$db->setQuery ($q);
				// change for faster ordering
				$ordering = $db->loadObject ();
				if (!empty($ordering)) {
					$product->ordering = $ordering->ordering;
					//What is this? notice by Max Milbers
					$product->id = $ordering->id;
				}

			}
			if (empty($product->virtuemart_category_id)) {

				if (isset($product->categories[0])) {
					$product->virtuemart_category_id = $product->categories[0];
				}
				else {
					$product->virtuemart_category_id = 0;
				}

			}

			if (!empty($product->categories[0])) {
				$virtuemart_category_id = 0;
				if ($front) {
					if (!class_exists ('shopFunctionsF')) {
						require(JPATH_VM_SITE . DS . 'helpers' . DS . 'shopfunctionsf.php');
					}
					$last_category_id = shopFunctionsF::getLastVisitedCategoryId ();
					if (in_array ($last_category_id, $product->categories)) {
						$virtuemart_category_id = $last_category_id;

					}
					else {
						$virtuemart_category_id = JRequest::getInt ('virtuemart_category_id', 0);
					}
				}
				if ($virtuemart_category_id == 0) {
					if (array_key_exists ('0', $product->categories)) {
						$virtuemart_category_id = $product->categories[0];
					}
				}

				$catTable = $productModel->getTable ('categories');
				$catTable->load ($virtuemart_category_id);
				$product->category_name = $catTable->category_name;
			}
			else {
				$product->category_name = '';
			}

			if (!$front) {
// 				if (!empty($product->virtuemart_customfield_id ) ){
				$customfields = VmModel::getModel ('Customfields');
				$product->customfields = $customfields->getproductCustomslist ($productModel->_id);

				if (empty($product->customfields) and !empty($product->product_parent_id)) {
					//$product->customfields = $this->productCustomsfieldsClone($product->product_parent_id,true) ;
					$product->customfields = $customfields->getproductCustomslist ($product->product_parent_id, $productModel->_id);
					$product->customfields_fromParent = TRUE;
				}

			}
			else {

				// Add the product link  for canonical
				$productCategory = empty($product->categories[0]) ? '' : $product->categories[0];
				$product->canonical = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $productModel->_id . '&virtuemart_category_id=' . $productCategory;
				$product->link = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $productModel->_id . '&virtuemart_category_id=' . $productCategory);

				//only needed in FE productdetails, is now loaded in the view.html.php
				//				Load the neighbours
				//				$product->neighbours = $this->getNeighborProducts($product);

				// Fix the product packaging
				if ($product->product_packaging) {
					$product->packaging = $product->product_packaging & 0xFFFF;
					$product->box = ($product->product_packaging >> 16) & 0xFFFF;
				}
				else {
					$product->packaging = '';
					$product->box = '';
				}

				// Load the vendor details
				//				if(!class_exists('VirtueMartModelVendor')) require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'vendor.php');
				//				$product->vendor_name = VirtueMartModelVendor::getVendorName($product->virtuemart_vendor_id);

				// set the custom variants
				//vmdebug('getProductSingle id '.$product->virtuemart_product_id.' $product->virtuemart_customfield_id '.$product->virtuemart_customfield_id);
				
				// TLELE PAGLEJ TULE KA JE ZA NASLIDN VM!!!
				
				//if (!empty($product->virtuemart_customfield_id)) {

					$customfields = VmModel::getModel ('Customfields');
					// Load the custom product fields
					// THIS MUST BE COMMENT!!!!!
					//$product->customfields = $customfields->getProductCustomsField ($product);
					
					$product->customfieldsRelatedCategories = $customfields->getProductCustomsFieldRelatedCategories ($product);
					$product->customfieldsRelatedProducts = $customfields->getProductCustomsFieldRelatedProducts ($product);
					//  custom product fields for add to cart
					$product->customfieldsCart = $customfields->getProductCustomsFieldCart ($product);
					//$child = $productModel->getProductChilds ($productModel->_id);
					//$product->customsChilds = $customfields->getProductCustomsChilds ($child, $productModel->_id);
				//}
			
// 				vmdebug('my product ',$product);

				// Check the stock level
				if (empty($product->product_in_stock)) {
					$product->product_in_stock = 0;
				}

				//TODO OpenGlobal add here the stock of parent, conditioned by $product->customfields type A
				/*				if (0 == $product->product_parent_id) {
					$q = 'SELECT SUM(IFNULL(children.`product_in_stock`,0)) + p.`product_in_stock` FROM `#__virtuemart_products` p LEFT OUTER JOIN `#__virtuemart_products` children ON p.`virtuemart_product_id` = children.`product_parent_id`
						WHERE p.`virtuemart_product_id` = "'.$this->_id.'"';
					$this->_db->setQuery($q);
					// change for faster ordering
					$product->product_in_stock = $this->_db->loadResult();
				}*/
				// Get stock indicator
				//				$product->stock = $this->getStockIndicator($product);

			}

		}
		else {
			$product = new stdClass();
			return $productModel->fillVoidProduct ($front);
		}
		//		}

		$productModel->product = $product;
		return $product;
	}

function getProduct ($virtuemart_product_id = NULL, $front = TRUE, $withCalc = TRUE, $onlyPublished = TRUE, $quantity = 1,$customfields = TRUE,$virtuemart_shoppergroup_ids=0) {

		if (!isset($virtuemart_product_id)) {
				return FALSE;
		}
		
		if($virtuemart_shoppergroup_ids !=0 and is_array($virtuemart_shoppergroup_ids)){
			$virtuemart_shoppergroup_idsString = implode('',$virtuemart_shoppergroup_ids);
		} else {
			$virtuemart_shoppergroup_idsString = $virtuemart_shoppergroup_ids;
		}


		$front = $front?TRUE:0;
		$withCalc = $withCalc?TRUE:0;
		$onlyPublished = $onlyPublished?TRUE:0;
		$customfields = $customfields?TRUE:0;
		
		$productKey = $virtuemart_product_id.$front.$onlyPublished.$quantity.$virtuemart_shoppergroup_idsString.$withCalc.$customfields;
		
		static $_products = array();
		   // vmdebug('$productKey, not from cache : '.$productKey);
		if (array_key_exists ($productKey, $_products)) {
			//vmdebug('getProduct, take from cache : '.$productKey);
			return $_products[$productKey];
		} else if(!$customfields or !$withCalc){
			$productKeyTmp = $virtuemart_product_id.$front.$onlyPublished.$quantity.$virtuemart_shoppergroup_idsString.TRUE.TRUE.TRUE;
			if (array_key_exists ($productKeyTmp, $_products)) {
				//vmdebug('getProduct, take from cache full product '.$productKeyTmp);
				return $_products[$productKeyTmp];
			}
		}
			
			$child = $this->getProductSingleCP ($virtuemart_product_id, $front,$quantity);
			if (!$child) {
				vmdebug('Catproduct child is not allowed for this shoppergroup');
				return FALSE;
			}
			if (!$child->published && $onlyPublished) {
				vmdebug('getProduct child is not published, returning zero');
				return FALSE;
			}
			if(!isset($child->orderable)){
				$child->orderable = TRUE;
			}
			//store the original parent id
			$pId = $child->virtuemart_product_id;
			$ppId = $child->product_parent_id;
			$published = $child->published;

			//$this->product_parent_id = $child->product_parent_id;

			$i = 0;

			//Check for all attributes to inherited by parent products
			while (!empty($child->product_parent_id)) {

				$parentProduct = $this->getProductSingleCP ($child->product_parent_id, $front,$quantity);
				if ($child->product_parent_id === $parentProduct->product_parent_id) {
					vmError('Error, parent product with virtuemart_product_id = '.$parentProduct->virtuemart_product_id.' has same parent id like the child with virtuemart_product_id '.$child->virtuemart_product_id);
					break;
				}
				$attribs = get_object_vars ($parentProduct);

				foreach ($attribs as $k=> $v) {
					if ('product_in_stock' != $k and 'product_ordered' != $k) {// Do not copy parent stock into child
						if (strpos ($k, '_') !== 0 and empty($child->$k)) {
							$child->$k = $v;
// 							vmdebug($child->product_parent_id.' $child->$k',$child->$k);
						}
					}
				}
				$i++;
				if ($child->product_parent_id != $parentProduct->product_parent_id) {
					$child->product_parent_id = $parentProduct->product_parent_id;
				}
				else {
					$child->product_parent_id = 0;
				}

			}

			//vmdebug('getProduct Time: '.$runtime);
			$child->published = $published;
			$child->virtuemart_product_id = $pId;
			$child->product_parent_id = $ppId;

			/*if ($withCalc) {
				$child->prices = $this->getPrice ($child, array(), 1);
				//vmdebug(' use of $child->prices = $this->getPrice($child,array(),1)');
			}*/

			/*if (empty($child->product_template)) {
				$child->product_template = VmConfig::get ('producttemplate');
			}*/

			if(!empty($child->canonCatLink)) {
				// Add the product link  for canonical
				$child->canonical = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $virtuemart_product_id . '&virtuemart_category_id=' . $child->canonCatLink;
			} else {
				$child->canonical = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $virtuemart_product_id;
			}
				$child->canonical = JRoute::_ ($child->canonical,FALSE);
			if(!empty($child->virtuemart_category_id)) {
				$child->link = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $virtuemart_product_id . '&virtuemart_category_id=' . $child->virtuemart_category_id, FALSE);
			} else {
				$child->link = $child->canonical;
			}
			
			$child->quantity = $quantity;
			
			$app = JFactory::getApplication ();
			if ($app->isSite () and VmConfig::get ('stockhandle', 'none') == 'disableit' and ($child->product_in_stock - $child->product_ordered) <= 0) {
				vmdebug ('STOCK 0', VmConfig::get ('use_as_catalog', 0), VmConfig::get ('stockhandle', 'none'), $child->product_in_stock);
				return FALSE;
			}
		

		return $child;
}

}