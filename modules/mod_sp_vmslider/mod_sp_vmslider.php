<?php
    /**
    * @package SP VirtueMart Product Slider
    * @author JoomShaper http://www.joomshaper.com
    * @copyright Copyright (c) 2010 - 2014 JoomShaper
    * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
    */

    // no direct access
    defined('_JEXEC') or die('Restricted access');

    require('helper.php');

    if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . '/components/com_virtuemart/helpers/config.php');

    VmConfig::loadConfig();
    vmJsApi::jPrice();
    vmJsApi::cssSite();

    /* Basic Settings */
    $category_id = $params->get('category_id', 0);                    // get all categories ***
    $product_group =    $params->get( 'product_group', 'featured'); // Display group   ***
    $max_items = $params->get('max_items',10);  // max product display ***

    /* Advanced Settings */
    $moduleclass_sfx = $params->get('moduleclass_sfx','');   // module class
    $load_jquery = $params->get('loadjquery','1');  // Load JQuery

    $module_id = $module->id;  // module id
    $vendor_id = '1';
    $module_name   = basename(dirname(__FILE__));

    $productModel = VmModel::getModel('Product');


    $products = $productModel->getProductListing($product_group, $max_items, true, true, false, true, $category_id);
    $productModel->addImages($products);
    $currency = CurrencyDisplay::getInstance();

    if(empty($products)){
        JFactory::getApplication()->enqueueMessage('Sorry No Product Found!!.', 'warning');
        return false;
    }

    $modSPVMSliderHelper = new modSPVMSliderHelper();


    $doc      = JFactory::getDocument();
    $cssFile  = JPATH_THEMES. '/'.$doc->template.'/css/'.$module_name.'.css';

    if( $load_jquery=='1' ){
        $doc->addScript(JURI::base(true) . '/modules/'.$module_name.'/assets/js/jquery-1.9.1.min.js');
    }

    $doc->addScript(JURI::base(true) . '/modules/'.$module_name.'/assets/js/spsimple.slider.js');
    $doc->addScript(JURI::base(true) . '/modules/'.$module_name.'/assets/js/jquery.countdown.min.js');

    if(file_exists($cssFile)) {
        $doc->addStylesheet(JURI::base(true) . '/templates/'.$doc->template.'/css/'. $module_name . '.css');
    } else {
        $doc->addStylesheet(JURI::base(true) . '/modules/'.$module_name.'/assets/css/style.css');
    }

    require JModuleHelper::getLayoutPath($module_name, $params->get('layout', 'default'));