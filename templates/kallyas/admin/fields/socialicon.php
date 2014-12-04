<?php // no direct access
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

class JFormFieldSocialIcon extends JFormField {

    protected $type = 'Socialicon';
	protected static $initialised = false;
	
    public function getInput() {
		$value = $this->value;
		$name = $this->name;
		$fieldID = str_replace(array('[', ']'), '_', $name); 
		if (!self::$initialised) {	
			
$scripts = '
;(function($) {
	$(document).ready( function() {	
		$(".socialiconform select").each(function(){
			$(this).change(function(){
				$t = $(this),
				tval = $t.find("option:selected").text();
				$t.parent().find("input[type=hidden]").attr("value",tval);
			});
		});
	});
})(jQuery);
';
	
			JFactory::getDocument()->addScriptDeclaration($scripts);
			self::$initialised = true;
		}
		$iconlist_json = '[{"value":"twitter","name":"Twitter"}, {"value":"dribbble","name":"Dribbble"}, {"value":"facebook","name":"Facebook"}, {"value":"envato","name":"Envato"}, {"value":"flickr","name":"Flickr"}, {"value":"forrst","name":"Forrst"}, {"value":"gplus","name":"Google Plus 1"}, {"value":"gplus2","name":"Google Plus 2"}, {"value":"icloud","name":"iCloud"}, {"value":"lastfm","name":"LastFM"}, {"value":"linkedin","name":"LinkedIN"}, {"value":"myspace","name":"My Spce"}, {"value":"paypal","name":"Paypal"}, {"value":"piacasa","name":"Piacasa"}, {"value":"pinterest","name":"Pinterest"}, {"value":"reedit","name":"ReEdit"}, {"value":"rss","name":"RSS"}, {"value":"skype","name":"Skype"}, {"value":"stumbleupon","name":"Stumble Upon"}, {"value":"tumblr","name":"Tumblr"}, {"value":"vimeo","name":"Vimeo"}, {"value":"wordpress","name":"Wordpress"}, {"value":"yahoo","name":"Yahoo"}, {"value":"youtube","name":"YouTube"}, {"value":"blogger","name":"Blogger"}, {"value":"deviantart","name":"Deviantart"}, {"value":"digg","name":"Digg"}, {"value":"foursquare","name":"FourSquare"}, {"value":"friendfeed","name":"FriendFeed"}, {"value":"mail","name":"Mail"}, {"value":"html5","name":"HTML5"}, {"value":"technorati","name":"Technorati"}, {"value":"soundcloud","name":"SoundCloud"}, {"value":"quora","name":"Quora"}, {"value":"bebo","name":"Bebo"}, {"value":"aim","name":"Aim"}, {"value":"gosquared","name":"Go Squared"}, {"value":"dropbox","name":"Dropbox"}, {"value":"github","name":"GitHub"}, {"value":"spotify","name":"Spotify"}, {"value":"apple","name":"Apple"} ]';
		
        $icons = (array) json_decode($iconlist_json);
        $options = array();
		
        foreach ($icons as $icon) {
            $option = new stdClass();
            $option->val = $icon->value;
            $option->name = $icon->name;
            $options[] = $option;
        }
		//print_r($options);
		 
			if($value) {
				if(is_array($value)) {
					// if value is array
					$theicon = $this->value['theicon'];
					$url = $this->value['url'];
					$title = self::getTitle($this->value['theicon'], $options);
				}
				// if not array
				else {
					$theicon = '';
					$title = '';
					$url = $this->value;
				}
			} else {
				// default at beginning
				$theicon = '';
				$url = '';
				$title = '';
			}
		
        $default = new stdClass();
        $default->val = '';
        $default->name = JText::_('JOPTION_DO_NOT_USE');
		
		$output = '<div class="socialiconform">';
		$output .= '<label for="'.$this->id.'">'.$this->element['label'].'</label>';
        $output .= JHtml::_('select.genericlist', array_merge(array($default), $options), $name.'[theicon]', array('data-val' => $default->val, 'class' => 'sellist input-large'), 'val', 'name', $this->value, $this->id);
		
		
		$output .= '<input id="'.$fieldID.'_url" name="'.$name.'[url]" type="text" placeholder="Add URL" value="'.$url.'" class="input-large" />'."\n";
		$output .= '<input id="'.$fieldID.'_title" name="'.$name.'[title]" type="hidden" value="'.$title.'" />';
		$output .= '</div>';
//		$output = NULL
		 return $output;
    }
	
	protected function getLabel() {
		return null;
	}
	function getTitle($theicon, $options){
		$name = '';
		foreach($options as $option){
			if($theicon == $option->val)
				$name = $option->name;
		}
		return $name;
	}

}