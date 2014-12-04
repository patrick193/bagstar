<?php
/*------------------------------------------------------------------------
# author    Marius Hogas
# copyright Copyright © 2013 hogash.com. All rights reserved.
# @license  Commercial License http://themeforest.net/licenses/regular_extended
# Website   http://www.hogash.com
-------------------------------------------------------------------------*/

// No direct access.
defined('_JEXEC') or die;

?>

<ul class="sf-menu clearfix">
<?php
foreach ($list as $i => &$item) :
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (in_array($item->id, $path)) {
		$class .= ' active';
	}
	elseif ($item->type == 'alias') {
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type == 'separator') {
		$class .= ' divider';
	}

	if ($item->deeper) {
		$class .= ' deeper';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}
	
	

		echo '<li'.$class.'>';
	
		// Render the menu item.
		switch ($item->type) :
			case 'separator':
			case 'url':
			case 'component':
			case 'heading':
				require dirname(__FILE__).'/menu_'.$item->type.'.php';
				break;
	
			default:
				//require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
				require dirname(__FILE__).'/menu_url.php';
				break;
		endswitch;
	
		// The next item is deeper.
		if ($item->deeper) {
			echo '<ul class="nav-child unstyled small">';
		}
		// The next item is shallower.
		elseif ($item->shallower) {
			echo '</li>'."\n";
			echo str_repeat('</ul></li>', $item->level_diff);
		}
		// The next item is on the same level.
		else {
			echo '</li>'."\n";
		}

	
endforeach;
?></ul>

<script type="text/javascript"> 
jQuery(document).ready(function(){ 
	/* Activate Superfish Menu */
	jQuery('#main_menu > ul').supersubs({ 
		minWidth:    12,   // minimum width of sub-menus in em units 
		maxWidth:    27,   // maximum width of sub-menus in em units 
		extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
	}).superfish({
		animation: <?php echo $animation; ?>,
		delay:<?php echo $delay; ?>,
		dropShadows:false,
		autoArrows:<?php echo $autoarrows ?> ,
		speed:'<?php echo $speed; ?>'
	})<?php if($mobilemenu && $isresponsive) echo ".mobileMenu({ switchWidth: 960, topOptionText: document.mobileMenuText, indentString: '&nbsp;-&nbsp;'})"; ?>;
});  
</script>