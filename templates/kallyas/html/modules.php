<?php  
/*------------------------------------------------------------------------
# author    Marius Hogas
# copyright Copyright © 2012 hogash.com. All rights reserved.
# @license  Commercial http://themeforest.net/licenses/regular_extended
# Website   http://www.hogash.com
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;


function modChrome_default($module, &$params, &$attribs) {
	//print_r($params);
	$module_class = ' '.htmlspecialchars($params->get('moduleclass_sfx'));
	$heading = (in_array("heading", $attribs)) ? $attribs['heading']:'h4';
	$grid = $params->get('gridlist') ? ' '.$params->get('gridlist') : '';
	$grid_offset = $params->get('grid_offset') ? ' '.$params->get('grid_offset') : '';
	//$first = $params->get('alpha') ? ' alpha' : '';
	//$last = $params->get('omega') ? ' omega' : '';

?>

	<div class="moduletable<?php echo $grid.$grid_offset.$module_class; ?>" id="mod<?php echo $module->id; ?>" data-id="<?php echo $module->id; ?>">
            <div class="bghelper" >
		
		<?php if ($module->showtitle != 0) { 
			$title = $module->title;
			$headClass = $params->get('heading_class');
			
			$splitter = '///';
			if($headClass == 'circle_title' && strpos($title,$splitter ) ) {
				$title = explode($splitter, $title);
				$title = '<span class="first">'.$title[0].'</span> '.$title[1];
			}
			
			echo '<'.$heading.' class="moduletitle '.$headClass.'">'.JText::_( $title ).'</'.$heading.'>';
		} ?>

			<div class="modulecontent">
				<?php echo $module->content; ?>
			</div><!-- end modulecontent-->
		</div><!-- end bghelper -->
	</div><!-- end module -->

	<?php 
	
}

function modChrome_basic($module, &$params, &$attribs) { ?>
    <div class="<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
		<?php echo $module->content; ?>
    </div>
<?php
}