if(jQuery) (function($) {
	
	$(document).ready(function(e) {
		// font settings
		var selectors = new Array("body","elems");
		$.each(selectors, function(i, val) {
			
			var radioInputs = $('#jform_params_font_'+ val +'_google_enable input[type=radio]'),
				checkedRadioInput = $('#jform_params_font_'+ val +'_google_enable input[type=radio]:checked').val(),
				ggselect = $('#jform_params_font_'+ val +'_google'),
				ggstyles = $('#jform_params_font_'+ val +'_google_style');
				safefont = $('#jform_params_font_'+ val +'_websafe');
			
			if(checkedRadioInput == 0) {
				ggselect.attr("disabled", true);
				ggstyles.attr("disabled", true);
				safefont.removeAttr("disabled");
			}
			
			radioInputs.change(function(){
				var $t = $(this).val(),
					ggselect = $('#jform_params_font_'+ val +'_google'),
					ggstyles = $('#jform_params_font_'+ val +'_google_style');
					safefont = $('#jform_params_font_'+ val +'_websafe');
					
				if($t==1) {
					ggselect.removeAttr("disabled");
					ggstyles.removeAttr("disabled");
					safefont.attr("disabled", true);
				}
				else if($t== 0) {
					ggselect.attr("disabled", true);
					ggstyles.attr("disabled", true);
					safefont.removeAttr("disabled");  
				}
			});
    	});
		
		// logo disable height and width on autosize enabled
		var logoRadioInput = $('#jform_params_logo_autosize input[type=radio]'),
			checkedLogoRadioInput = $('#jform_params_logo_autosize input[type=radio]:checked').val();
		if(checkedLogoRadioInput == 1) {
			$('#jform_params_logo_width').attr("disabled", true);
			$('#jform_params_logo_height').attr("disabled", true);
		}
		logoRadioInput.change(function(){
			var $t = $(this).val(),
				logoWidth = $('#jform_params_logo_width'),
				logoHeight = $('#jform_params_logo_height');
			if($t==0) {
				logoWidth.removeAttr("disabled");
				logoHeight.removeAttr("disabled");
			}
			else if($t==1) {
				logoWidth.attr("disabled", true);
				logoHeight.attr("disabled", true);
			}
		});

	});
	
})(jQuery);