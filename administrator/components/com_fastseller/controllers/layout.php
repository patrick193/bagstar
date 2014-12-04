<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class fsLayout{
	function prepare(){
		echo "<script type=\"text/javascript\">
		window.addEvent('domready', function(){
			var toolbar,
				elementbox=$('element-box');
			
			toolbar = $('toolbar-box') || document.getElementsByClassName('toolbar-box')[0];
			if (toolbar) toolbar.destroy();
			if (elementbox) elementbox.getFirst().className='Hello';
		});
		</script>";	
	}
}