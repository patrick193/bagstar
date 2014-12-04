<?php

// no direct access
defined('_JEXEC') or die;

$mid = $module->id;
$document = JFactory::getDocument(); 
$modpath = JURI::base(true).'/modules/mod_hg_staticcontent';

?>
<div class="bg-wrapper-image" style="background: url(<?php echo $params->get('text_login_bg'); ?>) no-repeat center center; min-height:<?php echo $params->get('text_login_minheight',400); ?>px;">
	<div class="container">
		<div class="static-content default-style with-login">
			<div class="row">
				<div class="span7">
					<?php echo modStaticContentHelper::prepare($params->get('text_login_content')); ?>
				</div>
				<div class="span5">
					<div class="fancy_register_form">
						<h4 style="text-align:center"><?php echo $params->get('text_login_form_title'); ?></h4>

						<form id="register_form<?php echo $mid; ?>" name="register_form" method="post" action="<?php echo JRoute::_('index.php?option=com_users'); ?>">
							<div>
								<label for="jform_username"><?php echo $params->get('text_login_9'); ?></label>
								<input type="text" maxlength="50" id="jform_username" name="jform[username]" class="required" required="required" tabindex="1">
							</div>
							<div>
								<label for="jform_name"><?php echo $params->get('text_login_10'); ?></label>
								<input type="text" maxlength="50" id="jform_name" name="jform[name]" class="required" required="required" tabindex="2">
							</div>
							<div>
								<label for="jform_email1"><?php echo $params->get('text_login_11'); ?></label>
								<input type="text" maxlength="100" id="jform_email1" name="jform[email1]" class="required" required="required" tabindex="3">
							</div>
							<div>
								<label for="jform_email2"><?php echo $params->get('text_login_16'); ?></label>
								<input type="text" maxlength="100" id="jform_email2" name="jform[email2]" class="required" required="required" tabindex="4">
							</div>
							<div>
								<label for="jform_password1"><?php echo $params->get('text_login_12'); ?></label>
								<input type="password" id="jform_password1" name="jform[password1]" class="required" required="required" tabindex="5">
							</div>
							<div>
								<label for="jform_password2"><?php echo $params->get('text_login_13'); ?></label>
								<input type="password" id="jform_password2" name="jform[password2]" class="required" required="required" tabindex="6">
							</div>
							<div style="margin-bottom:0;">
								<input type="submit" id="signup" name="submit" value="<?php echo $params->get('text_login_14'); ?>" class="btn btn-danger" tabindex="7">
							</div>
							<input type="hidden" name="option" value="com_users" />
							<input type="hidden" name="task" value="registration.register" />
							<?php echo JHtml::_('form.token');?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>