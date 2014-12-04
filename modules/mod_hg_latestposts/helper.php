<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_latest
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.image.image');
jimport('joomla.filesystem.file');

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

abstract class modHGLatestPostsHelper
{
	public static function getList(&$params)
	{
		// Get the dbo
		$db = JFactory::getDbo();

		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$model->setState('params', $appParams);

		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', ($params->get('modstyle') == 4 ? 3 : (int) $params->get('count', 5)));
		$model->setState('filter.published', 1);

		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);

		// Category filter
		$model->setState('filter.category_id', $params->get('catid', array()));

		// User filter
		$userId = JFactory::getUser()->get('id');
		switch ($params->get('user_id'))
		{
			case 'by_me':
				$model->setState('filter.author_id', (int) $userId);
				break;
			case 'not_me':
				$model->setState('filter.author_id', $userId);
				$model->setState('filter.author_id.include', false);
				break;

			case '0':
				break;

			default:
				$model->setState('filter.author_id', (int) $params->get('user_id'));
				break;
		}

		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());

		//  Featured switch
		switch ($params->get('show_featured'))
		{
			case '1':
				$model->setState('filter.featured', 'only');
				break;
			case '0':
				$model->setState('filter.featured', 'hide');
				break;
			default:
				$model->setState('filter.featured', 'show');
				break;
		}

		// Set ordering
		$order_map = array(
			'm_dsc' => 'a.modified DESC, a.created',
			'mc_dsc' => 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END',
			'c_dsc' => 'a.created',
			'p_dsc' => 'a.publish_up',
		);
		$ordering = JArrayHelper::getValue($order_map, $params->get('ordering'), 'a.publish_up');
		$dir = 'DESC';

		$model->setState('list.ordering', $ordering);
		$model->setState('list.direction', $dir);

		$items = $model->getItems();

		foreach ($items as &$item) {
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid.':'.$item->category_alias;

			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			} else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
			}
		}

		return $items;
	}
	
	public  function createThumb($path, $width = 100, $height = 100, $scale = 2, $crop = false)
	{
		$myImage = new JImage(); 
		$myImage->loadFile(JPATH_SITE . DS . $path);
		
		if ($myImage->isLoaded()) { 
			$filename = end(explode('/',$path));
			$newfilename = $width.'x'.$height.'_'.JFile::makeSafe($filename);
			$fileExists = JFile::exists(JPATH_CACHE .'/'.$newfilename);
			
			if(!$fileExists) {
				$resizedImage = $myImage->resize($width, $height, true, $scale);
				$properties = $myImage->getImageFileProperties($path);
				if($crop)
					$croppedImage = $resizedImage->crop($width, $height, 15, 0);
				
				$mime = $properties->mime;
				if ($mime == 'image/jpeg') {
					$type = IMAGETYPE_JPEG;
				} elseif ($mime = 'image/png') {
					$type = IMAGETYPE_PNG;
				} elseif ($mime = 'image/gif') {
					$type = IMAGETYPE_GIF;
				}
				
				$croppedImage->toFile(JPATH_CACHE .'/'.$newfilename, $type);
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
}
