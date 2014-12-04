<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_languages
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
//JHtml::_('stylesheet', 'mod_languages/template.css', array(), true);
?>
<div class="mod-languages <?php echo $moduleclass_sfx ?>">


<?php
/*
if ($params->get('dropdown', 1)) : ?>
	<form name="lang" method="post" action="<?php echo htmlspecialchars(JURI::current()); ?>">
	<select class="inputbox" onchange="document.location.replace(this.value);" >
	<?php foreach($list as $language):?>
		<option dir=<?php echo JLanguage::getInstance($language->lang_code)->isRTL() ? '"rtl"' : '"ltr"'?> value="<?php echo $language->link;?>" <?php echo $language->active ? 'selected="selected"' : ''?>>
		<?php echo $language->title_native;?></option>
	<?php endforeach; ?>
	</select>
	</form>
<?php else :
*/
?>
<div class="pPanel">
	<ul class="<?php echo $params->get('inline', 1) ? 'lang-inline' : 'lang-block';?> inner">
	<?php foreach($list as $language):?>
		<?php if ($params->get('show_active', 0) || !$language->active):?>
			<li class="<?php echo $language->active ? 'active' : '';?>" dir="<?php echo JLanguage::getInstance($language->lang_code)->isRTL() ? 'rtl' : 'ltr' ?>">
			<a href="<?php echo $language->link;?>">
				<?php if ($params->get('image', 1)):?>
					<?php echo JHtml::_('image', 'mod_languages/'.$language->image.'.gif', $language->title_native, array('title'=>$language->title_native), true);?>
				<?php endif; ?>
					<?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef);?>
				
			<?php echo $language->active ? '<span class="icon-ok"></span>' : '';?>
			</a>
			</li>
		<?php endif;?>
	<?php endforeach;?>
	</ul>
<?php
/*
endif;
*/
?>
</div>

</div>
