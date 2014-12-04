<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_breadcrumbs
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<ul class="breadcrumbs fixclear">
  
  <?php
  
  for ($i = 0; $i < $count; $i ++) :
  
  	// If not the last item in the breadcrumbs add the separator
  	if ($i < $count -1) {
  		if (!empty($list[$i]->link)) {
			
			//if($removeFirstTwo) {
				if($count > 5 && (($i == 1) || ($i == 2) || ($i == 3))) {
					echo '<li><a href="'.$list[$i]->link.'" data-rel="tooltip" data-placement="top" title="'.$list[$i]->name.'" data-animation="true">...</a></li>';
				} else {
					echo '<li><a href="'.$list[$i]->link.'" class="pathway">'.$list[$i]->name.'</a></li>';
				}
			
			
  		} else {
			
				echo '<li><span>';
			
					echo $list[$i]->name;
				
				echo '</span></li>';
			
  		}

  	}  elseif ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true

  		 echo '<li><span>';
  		echo $list[$i]->name;
  		  echo '</span></li>';
  	}
  endfor; ?>
  
</ul>
