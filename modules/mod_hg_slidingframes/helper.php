<?php

// no direct access
defined('_JEXEC') or die;

jimport('joomla.image.image');
jimport('joomla.filesystem.file');

class modSlidingFramesHelper
{
	public function createThumb($path, $width = 100, $height = 100, $crop = 2)
	{
		$myImage = new JImage(); 
		$myImage->loadFile(JPATH_SITE . DS . $path);
		
		if ($myImage->isLoaded()) { 
			$filename = end(explode('/',$path));
			
			$filefolder = substr(md5(self::getFolderPath($path)),1,10);
			
			$newfilename = $width.'x'.$height.'_'.$filefolder.'_'.JFile::makeSafe($filename);
			$fileExists = JFile::exists(JPATH_CACHE .'/'.$newfilename);
			
			if(!$fileExists) {
				$resizedImage = $myImage->resize($width, $height, true, $crop);
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
	
	public function getFolderPath($path) {
		$rootPath = $_SERVER['DOCUMENT_ROOT'];
		$thisPath = dirname($path);
		$onlyPath = str_replace($rootPath, '', $thisPath);
		return $onlyPath;	
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
}
