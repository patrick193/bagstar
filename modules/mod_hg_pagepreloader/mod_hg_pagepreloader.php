<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
$doc->addStyleDeclaration('#page-loading {position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: url('.JURI::base(true).'/modules/mod_hg_pagepreloader/assets/loader_'.$params->get('theme','light').'.gif) no-repeat center center #'.$params->get('bg','111111').'; z-index: 999999;}');

$doc->addScriptDeclaration('jQuery(window).load(function(){ var pageLoading = jQuery("#page-loading"); setTimeout(function() { pageLoading.fadeOut();}, 1000); });');

echo '<div id="page-loading"></div>';