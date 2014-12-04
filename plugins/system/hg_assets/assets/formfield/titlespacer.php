<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldTitleSpacer extends JFormField {
        protected $type = 'Titlespacer';

		protected function getLabel()
		{
			return ' ';
		}
		
        protected function getInput() {
			
			return '<strong style="color:#000; display:block; margin-bottom:5px; line-height:1.7;">'.$this->element['label'].'</strong>';
		
        }

}

?>