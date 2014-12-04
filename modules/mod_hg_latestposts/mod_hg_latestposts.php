<?php

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$list = modHGLatestPostsHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
//$boxSize = round($parentGrid/$params->get('perrow',3), 0, PHP_ROUND_HALF_DOWN);
$boxSize = floor($parentGrid/$params->get('perrow',3));
$style = $params->get('modstyle',1);

switch($style) {
	case 1:
		$layout = 'default';
	break;
	
	case 2:
		$layout = 'style2';
	break;
	
	case 3:
		$layout = 'style3';
	break;
	
	case 4:
		$layout = 'accordion';
	break;
}

require JModuleHelper::getLayoutPath('mod_hg_latestposts', $layout);
