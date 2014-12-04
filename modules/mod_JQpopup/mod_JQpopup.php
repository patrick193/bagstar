<?php
/*------------------------------------------------------------------------
# mod_JQpopup - Jquery UI Popup Module
# ------------------------------------------------------------------------
# author    Vsmart Extensions
# copyright Copyright (C) 2010 YourAwesomeSite.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.vsmart-extensions.com
# Technical Support:  Forum - http://www.vsmart-extensions.com
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$width = $params->get('width', 			480);
$height = $params->get('height', 	180);
$time = $params->get('time',5000);
$time_reopen = $params->get('time_reopen',1);
$modules_postion = $params->get('modules_postion',"");

$type = $params->get('content',"module");


$vst_popup = mod_JQpopup_Helper::mosGetVstPopup($params);


require(JModuleHelper::getLayoutPath('mod_JQpopup'));