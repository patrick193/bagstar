<?php
/**
 * @version		$Id: k2.php 1206 2011-10-17 21:09:08Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemJquery extends JPlugin {

	function plgSystemJquery(&$subject, $config) {

		parent::__construct($subject, $config);
	}

	function onAfterRoute() {
		JLoader::import( 'joomla.version' );
		$version = new JVersion();
		if (version_compare( $version->RELEASE, '2.5', '<=')) {
			
			$mainframe = &JFactory::getApplication();
			
			if ($mainframe->isAdmin()) {
				return;
			}
			$document = &JFactory::getDocument();
			$version = $this->params->get('version','1.8.2');
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/'.$version.'/jquery.min.js');
			$noconflict = $this->params->get('noconflict','1');
			if($noconflict == 1) {
				$document->addScript(JURI::base().'plugins/system/jquery/jquery.noconflict.js');
			}
			JFactory::getApplication()->set('jquery', true);
		} else if(version_compare( $version->RELEASE, '3.0', '<=')) {
			JHtml::_('jquery.framework');
		}
	}

}
