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

ini_set('arg_separator.output','&amp;');

class mod_JQpopup_Helper{
	function mosGetVstPopup($params){
		jimport( 'joomla.application.module.helper' );
		$type = $params->get('content',"module");
		$image = $params->get('image',"");
		$ispowerby = intval($params->get('ispowerby',1));
		$module_position = $params->get('module_position','');
		$modules = &JModuleHelper::getModules( $module_position );
		ob_start();
		if($type == "module"){
		?>
			<?php if(count($modules) > 0 ){ ?>
					<div class="vstPopupInner">
						<?php
							foreach ($modules as $module) {
								$attribs = array( 'style' => 'none' );
								echo JModuleHelper::renderModule( $module, $attribs );
							}
						?>
						<?php if($ispowerby == 1) echo "<div style='text-align:center;padding-top:10px;'>Powered by <a href='http://vsmart-extensions.com' target='_blank'>Vsmart Extensions</div>"; ?>
					</div>
			<?php } ?>
		<?php
		}elseif($type == "article"){
			$article_id = intval($params->get('article_id',""));
			if($article_id){
				$db 	=& JFactory::getDBO();
				$query = 'SELECT a.*' .
				' FROM #__content AS a' .
				' WHERE a.state = 1 ' .
				' AND a.id = '.$article_id;
				$db->setQuery($query);
				$rows = $db->loadObjectList();
				$row = $rows[0];
				?>
				<div class="vstPopupInner">
					<h3><?php echo $row->title; ?></h3>
					<?php
						echo $row->introtext;				
					?>
					<?php if($showreadmore == 1){ ?>
						<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($row->id, $row->catid, $row->sectionid)); ?>"><?php echo JText::_('More'); ?> </a>...
					<?php } ?>
						<?php if($ispowerby == 1) echo "<div style='text-align:center;padding-top:10px;'>Powered by <a href='http://vsmart-extensions.com' target='_blank'>Vsmart Extensions</div>"; ?>
				</div>
				<?php
				
			}
		}elseif($type == "image"){
				$link = JURI::Root(true)."/images/banners/".$image;
			?>
			<div class="vstPopupInner">
				<img src="<?php echo $link; ?>" />
				<?php if($ispowerby == 1) echo "<div style='text-align:center;padding-top:10px;'>Powered by <a href='http://vsmart-extensions.com' target='_blank'>Vsmart Extensions</div>"; ?>
			</div>
			<?php
		}
		?>
		
		<?php
		$html = ob_get_clean();
		return $html;
	}
}

?>