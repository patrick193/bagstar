<?php
/**
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

class modRapidContactHelper
{
	public function doError($error, $type)
	{
		if (JVERSION>='3') :
			if($type == 'warning'):
				JError::raiseWarning( '', $error );
			elseif($type == 'notice'):
				JError::raiseNotice( '', $error );
			elseif($type == 'message'):
				JFactory::getApplication()->enqueueMessage($error);
			elseif($type == 'error'):
				JError::raiseError( '', $error );
			endif;
		else :
			JFactory::getApplication()->enqueueMessage($error, $type);
		endif;
	}
}