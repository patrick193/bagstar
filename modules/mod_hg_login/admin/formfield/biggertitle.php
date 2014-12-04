<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldBiggerTitle extends JFormField {
        protected $type = 'Biggertitle';

		protected function getLabel()
		{
			return ' ';
		}
		
        protected function getInput() {
			
			return '<strong style="color:#111; font-size:18px; display:block; margin-bottom:5px; line-height:1.7;">'.$this->element['label'].'</strong>';
		
        }

}

?>