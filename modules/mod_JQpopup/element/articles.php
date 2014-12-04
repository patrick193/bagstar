<?php
/*------------------------------------------------------------------------
# mod_JQpopup - Jquery UI Popup Module
# ------------------------------------------------------------------------
# author    Vsmart Extensions
# copyright Copyright (C) 2010 YourAwesomeSite.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.vsmart-extensions.com
# Technical Support:  Forum - http://www.vsmart-extensions.com
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.html.html');
jimport('joomla.form.formfield');//import the necessary class definition for formfield

	class JFormFieldArticles extends JFormField {

		protected $type = 'articles';
		
		protected function getInput()
		{
			$db = &JFactory::getDBO();
			
			$query = 'SELECT c.id, c.title AS title' .
			' FROM #__content AS c' .
			' WHERE c.state = 1' .
			' ORDER BY c.title';

			$db->setQuery($query);
			$options = $db->loadObjectList();
			return JHtml::_('select.genericlist',  $options, $this->name,'', 'id', 'title', $this->value);
		}
	}

?>