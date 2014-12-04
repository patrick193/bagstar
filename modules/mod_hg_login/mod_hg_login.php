<?php
// no direct access
defined('_JEXEC') or die;
jimport( 'joomla.application.component.view');

include_once (JPATH_SITE.'/modules/mod_login/helper.php');

$app		= JFactory::getApplication();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$type	= modLoginHelper::getType();
$return	= modLoginHelper::getReturnURL($params, $type);
$user	= JFactory::getUser();

require JModuleHelper::getLayoutPath('mod_hg_login', $params->get('layout', 'default'));