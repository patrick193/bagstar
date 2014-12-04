<?php
/**
 * @version	     $Id$
 * @copyright			Copyright (C) 2005 - 2009 Joomla! Vargas. All rights reserved.
 * @license	     GNU General Public License version 2 or later; see LICENSE.txt
 * @author	      Guillermo Vargas (guille@vargas.co.cr)
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');

// Create shortcut to parameters.
$params = $this->item->params;

$doc = JFactory::getDocument();
$template_path = JURI::base().'templates/'.JFactory::getApplication()->getTemplate();

// load script
$doc->addScript($template_path."/js/jquery.sitemap.color.js");
$doc->addScript($template_path."/js/jquery.sitemap.js");

// load inline styles
$css = '.notice-wrap {display:none !important;}';
$doc->addStyleDeclaration($css); 

?>
<div id="xmap">

	<h1 class="page-title">
		<?php echo $this->escape($params->get('page_heading')); ?>
	</h1>

<?php if ($params->get('access-edit') || $params->get('show_title') ||  $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
	<ul>
	<?php if (!$this->print) : ?>
		<?php if ($params->get('show_print_icon')) : ?>
		<li>
			<?php echo JHtml::_('icon.print_popup',  $this->item, $params); ?>
		</li>
		<?php endif; ?>

		<?php if ($params->get('show_email_icon')) : ?>
		<li>
			<?php echo JHtml::_('icon.email',  $this->item, $params); ?>
		</li>
		<?php endif; ?>
	<?php else : ?>
		<li>
			<?php echo JHtml::_('icon.print_screen',  $this->item, $params); ?>
		</li>
	<?php endif; ?>
	</ul>
<?php endif; ?>

<?php if ($params->get('showintro', 1) )  : ?>
<?php echo $this->item->introtext; ?>
<?php endif; ?>

<?php echo $this->loadTemplate('items'); ?>

<span class="article_separator">&nbsp;</span>
</div>