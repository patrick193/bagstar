<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2011-2014 Ext-Joom.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2.
# Author: Ext-Joom.com
# Websites:  http://www.ext-joom.com 
# Date modified: 06/05/2014 - 13:00
# ------------------------------------------------------------------------
*/

// No direct access.
defined('_JEXEC') or die;

class plgSystemExtcsstooltip extends JPlugin {
	function onBeforeCompileHead() {
		$document = JFactory::getDocument();
		$document->addCustomTag('<style type="text/css">
		.ext-tooltip{
   			display: inline;
    		position: relative;
			cursor: help;
		}		
		.ext-tooltip:hover:after{
    		background: #333;
    		background: rgba(0,0,0,.8);
    		border-radius: 3px;
    		bottom: 26px;
    		color: #fff;
    		content: attr(data-title);
    		left: 20%;
    		padding: 5px 15px;
    		position: absolute;
    		z-index: 98;
    		min-width: 150px;
		}		
		.ext-tooltip:hover:before{
    		border: solid;
    		border-color: #333 transparent;
    		border-width: 6px 6px 0 6px;
    		bottom: 20px;
    		content: "";
    		left: 50%;
    		position: absolute;
    		z-index: 99;
		}
		</style>');
	}
}