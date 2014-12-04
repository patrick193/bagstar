<?php
/**
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

jimport('joomla.image.image');
jimport('joomla.filesystem.file');

jimport('joomla.application.component.model');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

class ModCircularContentSliderHelper
{
	
	public  function createThumb($path, $width = 100, $height = 100) 
	{
		$myImage = new JImage(); 
		$myImage->loadFile(JPATH_SITE . DS . $path);
		
		if ($myImage->isLoaded()) { 
			$filename = end(explode('/',$path));
			$newfilename = $width.'x'.$height.'_'.JFile::makeSafe($filename);
			$fileExists = JFile::exists(JPATH_CACHE .'/'.$newfilename);
			
			if(!$fileExists) {
				$resizedImage = $myImage->resize($width, $height, true);
				$properties = $myImage->getImageFileProperties($path);
				
				$mime = $properties->mime;
				if ($mime == 'image/jpeg') {
					$type = IMAGETYPE_JPEG;
				} elseif ($mime = 'image/png') {
					$type = IMAGETYPE_PNG;
				} elseif ($mime = 'image/gif') {
					$type = IMAGETYPE_GIF;
				}
				
				$resizedImage->toFile(JPATH_CACHE .'/'.$newfilename, $type);
			}
			return $newfilename;
		} else { 
			return "My file is not loaded"; 
		} 
	}
	
	public  function getProportion($path) 
	{
		$myImage = new JImage();
		$imgPath = JPATH_SITE . DS . $path;
		$myImage->loadFile($imgPath);
		if ($myImage->isLoaded()) { 
			$properties = $myImage->getImageFileProperties($imgPath);
			return ($properties->height/$properties->width)*100;
		} else { 
			return; 
		} 
	}
	public function returnBool($val) {
		return $val ? 'true':'false';
	}
	
	public function prepare($content) {
		JPluginHelper::importPlugin('content');
		return JHtml::_('content.prepare', $content);
	}
	
	static function getArticle($articleId) {
		
		$db =& JFactory::getDBO();
		$sql = "SELECT `title`, `introtext`, `fulltext` FROM #__content WHERE id = ".intval($articleId);
		$db->setQuery($sql);
		$items = $db->loadObjectList();
		if ($db->getErrorNum()) 
			JError::raiseWarning(500, $db->getErrorMsg());
		$values = array();
		if (!empty($items))	{
			foreach ($items as $item) {
				$option = new stdClass();
				$option->title = $item->title;
				$option->text = (!strlen(trim($item->fulltext)) ? $item->introtext : $item->fulltext);
				$values[] = $option;
			}
		}
		//print_r($values);
		return $values;
	}
}
