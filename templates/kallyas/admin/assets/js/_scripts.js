if(jQuery) (function($) {
	
	$(document).ready(function(e) {
		
		
		$('#jform_params_font_body_google_enable input[type=radio]').change(function(){
				var $t = $(this).val(),
					ggselect = $('#jform_params_font_body_google'),
					ggstyles = $('#jform_params_font_body_google_style');
					safefont = $('#jform_params_font_body_websafe');
				if($t==1) {
					// scoate disable la elemente
					ggselect.removeAttr("disabled");
					ggstyles.removeAttr("disabled");
					safefont.attr("disabled", true);
				}
				else if($t== 0) {
					// baga disable la elemente
					ggselect.attr("disabled", true);
					ggstyles.attr("disabled", true);
					safefont.removeAttr("disabled"); 
				}
		});
		
		
		$('#jform_params_font_elems_google_enable input[type=radio]').change(function(){
				var $t = $(this).val(),
					ggselect = $('#jform_params_font_elems_google'),
					ggstyles = $('#jform_params_font_elems_google_style');
					safefont = $('#jform_params_font_elems_websafe');
				if($t==1) {
					// scoate disable la elemente
					ggselect.removeAttr("disabled");
					ggstyles.removeAttr("disabled");
					safefont.attr("disabled", true);
				}
				else if($t== 0) {
					// baga disable la elemente
					ggselect.attr("disabled", true);
					ggstyles.attr("disabled", true);
					safefont.removeAttr("disabled"); 
				}
		});
		
	});
	
})(jQuery);