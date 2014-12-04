<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_hg_prettyphoto_autopop', $params->get('layout', 'default'));

?>

