<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
* Cherry's Breadcrumb Module
*
* @package VM Breadz 2.0 - 2012 Febrary
* @copyright Copyright © 2009-2012 Maksym Stefanchuk All rights reserved.
* @license http://www.gnu.org/licenses/gpl.html GNU/GPL
*
* http://www.galt.md
*/

defined('VMLANG') or define('VMLANG', 'en_gb');

require('controller.php');
require('config.php');

$options = array();
$options['add_label'] = $params->get('add_label', null);
$pretext = $params->get('pretext', null);
$pretext_url = $params->get('pretext_url', null);
$options['showx'] = $params->get('showx', null);
$options['currency_sign'] = $params->get('currency_sign', null);
$options['startfrom'] = $params->get('startfrom', null);
breadzConf::setOptions($options);

$breadz = new chpBreadzController();

$categories = $breadz->getCategoryList();
$prices = $breadz->getPrices();
$filters = $breadz->getFilterList();
$product = $breadz->getProductData();

$elements = array_merge((array)$categories, (array)$prices, (array)$filters, (array)$product);

if ($elements) {
	// prepend pre-text to elements
	if ($pretext) {
		$data = array();
		$data['name'] = $pretext;
		$data['url'] = $pretext_url;
		$data['xurl'] = null;
		
		array_unshift($elements, $data);
	}

	require('writer.php');
	chpBreadzWriter::printBreadcrumbs($elements);
	
	$doc =& JFactory::getDocument();
	$doc->addStyleSheet( JURI::base() .'/modules/mod_vm_breadz/static/style.css' );
}


//var_dump($elements);

?>