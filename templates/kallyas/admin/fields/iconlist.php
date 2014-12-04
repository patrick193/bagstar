<?php

// no direct access
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

class JFormFieldIconlist extends JFormField {

    protected $type = 'Iconlist';

    public function getInput() {
        $fonts = (array) json_decode(file_get_contents(dirname(__FILE__) . '/icons.json'));
        $options = array();
        foreach ($fonts as $font) {
            $option = new stdClass();
            $option->val = $font;
            $option->name = ucwords(str_replace('+', ' ', $font));
            $options[] = $option;
        }
        $default = new stdClass();
        $default->val = '-1';
        $default->name = JText::_('JOPTION_DO_NOT_USE');
        return JHtml::_('select.genericlist', array_merge(array($default), $options), $this->name, $default->val, 'val', 'name', $this->value, $this->id);
    }

}