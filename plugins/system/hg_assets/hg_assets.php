<?php
/**
 * @version		$Id$
 * @author		Hogas Marius (hogash.themeforest@gmail.com)
 * @package		Joomla.Site
 * @subpakage	Hogash.HGAssets
 * @copyright	Copyright (c) 2012 Hogash Templates (http://www.hogash.com). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.event.plugin');
jimport('joomla.plugin.plugin');
jimport('zauan.shortcodes.shortcodes');

/**
 * System - HG Assets
 *
 * @package		Joomla.Plugin
 * @subpakage	Hogash.HGAssets
 */
class plgSystemHG_Assets extends JPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
	}

	//onAfterRoute hook.
	public function onAfterRoute() {
		$app	= JFactory::getApplication();

		if ($app->isAdmin()) {
			if($this->params->get('hidemenu',1)) {
				// check to see if the user is admin
				$user = JFactory::getUser();
				if(!$user->authorise('manage', 'com_banners'))
					return;	
			}
			$option = JRequest::getWord('option');
       		$layout = JRequest::getWord('layout');
			
			if ((($option == 'com_content' || $option == 'com_modules' || $option == 'com_templates' || $option == 'com_menus') && $layout == 'edit')) {
				JFactory::getDocument()->addStyleSheet(JURI::root(true) . '/plugins/system/hg_assets/assets/css/hgassets.css');
			}
		}
	}
	public function onAfterDispatch() {
		if($this->params->get('hidemenu',1))
	        JRequest::setVar('hidemainmenu', 0);

		$app = JFactory::getApplication();
        if (!$app->isAdmin()) return;
		$option = JRequest::getWord('option');
        $layout = JRequest::getWord('layout');
		
		if (($option == 'com_content' || $option == 'com_modules' || $option == 'com_menus') && $layout == 'edit'){
			JFactory::getDocument()->addScript(JURI::root(true) . '/plugins/system/hg_assets/assets/js/hgassets.js');
        }
		
		if (JRequest::getCmd('insertshortcode','')) {
			global $mainframe;
			$mainframe = JFactory::getApplication();

			JHtml::_('behavior.framework', true);
			
		}
    }

	//Add the forms from the template path
	public function onContentPrepareForm($form, $data) {
		
		$app = JFactory::getApplication();
        if (!$app->isAdmin()) return;

        $option = JRequest::getWord('option');
        $layout = JRequest::getWord('layout');
		$view = JRequest::getWord('view');
		
		if ($option == 'com_content' && $layout == 'edit'){
			$form->loadFile(JPATH_SITE.'/plugins/system/hg_assets/assets/form/article.xml', true);
        }
		if ($option == 'com_modules' && ($layout == 'edit' || $layout == 'modal')){
			$form->loadFile(JPATH_SITE.'/plugins/system/hg_assets/assets/form/module.xml', true);
        }
		if ($option == 'com_menus' && $layout == 'edit'){
			$form->loadFile(JPATH_SITE.'/plugins/system/hg_assets/assets/form/pageheader_menus.xml', true);
        }
	}

	// Do BBCode replacements on the whole page
	public function onContentPrepare($context, &$article, &$params, $limitstart)
    {
		if($this->params->get('shortcodes',1)) {
			error_reporting (E_ALL ^ E_NOTICE); 
			$article->text = wpautop($article->text);
			$article->text = shortcode_unautop($article->text);
			$article->text = do_shortcode($article->text);
		}
    }
	
	function onAfterRender()
    {
	
		if (JRequest::getCmd('insertshortcode','')) {
			
			$tmpl = JPATH_PLUGINS.DS.'system'.DS.'hg_assets'.DS.'tmpl'.DS.'default.php';
			
			$html = $this->loadTemplate ($tmpl);			
			echo $html;
			exit;			
		}
		
    }
	
	
	function loadTemplate($template)
    {
        if (!is_file($template))
            return '';
        ob_start();
        include ($template);
        $content = ob_get_clean();
        return $content;
    }

}