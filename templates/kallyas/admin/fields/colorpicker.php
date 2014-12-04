<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldColorpicker extends JFormField {
        protected $type = 'Colorpicker';
		protected static $initialised = false;
	
        protected function getInput() {
		
		$value = $this->value;
		$name = $this->name;
		$fieldID = str_replace(array('[', ']'), '', $name);
			
		if (!self::$initialised) {	
			
$scripts = '
;(function($) {
	$(document).ready( function() {	
		$("input.minicolors").minicolors({
			opacity: true,
			show: function() {
				$(this).closest(".panelform").css("overflow","visible");
				$(this).closest(".pane-slider").css("overflow","visible");
			},
			hide: function() {
        		$(this).closest(".panelform").css("overflow","hidden");
				$(this).closest(".pane-slider").css("overflow","hidden");
			},
			change: function(hex, opacity) {
				$("#'.$fieldID.'_opacity").attr("value",opacity);
			}
		});
	});
})(jQuery);
';
	
			JFactory::getDocument()->addScriptDeclaration($scripts);
			self::$initialised = true;
		}

			if($value) {
				if(is_array($value)) {
					// if value is array
					$opacity = $this->value['opacity'];
					$color = $this->value['color'];
				}
				// if not array set opacity to 1
				else {
					$opacity = 1;
					$color = $this->value;
				}
			} else {
				// default at beginning
				$opacity = ($this->element['opacity'] ? $this->element['opacity'] : 1);
				$color = $this->element['default'];
			}
			
			$output = '
			<div class="colorpickerField">
				<input id="'.$name.'" name="'.$name.'[color]" type="text" class="minicolors" data-opacity="'.$opacity.'" data-default-value="'.$color.'" value="'.$color.'" />
				<input name="'.$name.'[opacity]" id="'.$fieldID.'_opacity" type="hidden" value="'.$opacity.'" />
				
			</div>
			';
			return $output;
        }
}

?>