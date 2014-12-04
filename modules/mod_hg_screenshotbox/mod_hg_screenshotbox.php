<?php
// no direct access
defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

if ($params->def('prepare_content', 1))
{
	JPluginHelper::importPlugin('content');
	$leftside = JHtml::_('content.prepare', $params->get('leftside'), '');
} else {
	$leftside = $params->get('leftside');
}

require JModuleHelper::getLayoutPath('mod_hg_screenshotbox', $params->get('layout', 'default'));
