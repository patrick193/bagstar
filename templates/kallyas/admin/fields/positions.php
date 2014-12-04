<?php

// no direct access
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

class JFormFieldPositions extends JFormField {

    protected $type = 'Positions';

    public function getInput() {
		$document	= JFactory::getDocument();
		$position = (string) $this->element['position'];
		
		jimport( 'joomla.application.module.helper' );
		
		$module = JModuleHelper::getModules( '' );

		echo '<pre>';
			var_dump( $module);
		echo '</pre>';

		
    }

}