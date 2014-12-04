<?php

// no direct access
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

class JFormFieldTemplateAsset extends JFormField {

    protected $type = 'Templateasset';

    protected function getInput() {	
		$document	= JFactory::getDocument();
		$path = (string) $this->element['path'];
		if (!is_dir($path)) {
			$path = JURI::root() . $path;
		}
		
		if (!version_compare(JVERSION, '3.0', 'ge')) {
			$checkJqueryLoaded = false;
			$header = $document->getHeadData();
			foreach($header['scripts'] as $scriptName => $scriptData)
			{
				if(substr_count($scriptName,'/jquery')){
					$checkJqueryLoaded = true;
				}
			}	
			//Add js
			if(!$checkJqueryLoaded) 
			$document->addScript(JURI::root().$this->element['path'].'assets/js/jquery.min.js');
			$document->addScript(JURI::root().$this->element['path'].'assets/js/jquery.noconflict.js');
		}
		
		$document->addStyleSheet($path.'assets/css/styles.css');       
		
		//add bootstrap
		$document->addScript($path.'assets/js/scripts.js');
		
		//add colorpicker
		$document->addStyleSheet($path.'assets/css/jquery.miniColors.css');
		$document->addScript($path.'assets/js/jquery.miniColors.js');
		
		
		return null;
    }

}