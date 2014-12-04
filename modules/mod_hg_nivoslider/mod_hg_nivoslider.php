<?php
// no direct access
defined('_JEXEC') or die;

// Include the helper.
require_once dirname(__FILE__) . '/helper.php';

$app = JFactory::getApplication();

require JModuleHelper::getLayoutPath('mod_hg_nivoslider', $params->get('layout', 'default'));
