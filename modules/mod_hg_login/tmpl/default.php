<?php

// no direct access
defined('_JEXEC') or die;
//JHtml::_('behavior.keepalive');
?>
<?php if (JFactory::getUser()->guest){ ?>

<div id="login_panel">
	<?php if ($type == 'login') : ?>
	<div class="inner-container login-panel">
		<h3 class="m_title"><?php echo $params->get('modlog1'); ?></h3>
		<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login_form" name="login_form" >
			<?php
			if($params->get('registration_enable',1)):
			$usersConfig = JComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) : ?>
				<a href="#" class="create_account" onClick="ppOpen('#register_panel', '280');"><?php echo $params->get('modlog2'); ?></a>
			<?php endif;
			endif;
			?>
			<input type="text" id="username" name="username" class="inputbox" placeholder="<?php echo $params->get('modlog3'); ?>" required="required">
			<input type="password" id="password" name="password" class="inputbox" placeholder="<?php echo $params->get('modlog4'); ?>" required="required">
			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			<div class="remember-field">
				<label id="remember-lbl" for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
				<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes" />
			</div>
			<?php endif; ?>
			<input type="submit" id="loginBtn" name="Submit" value="<?php echo $params->get('modlog5'); ?>">
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.login" />
			<input type="hidden" name="return" value="<?php echo $return; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
		
		<?php if($params->get('forget_enable',1)): ?>
		<div class="links">
			<a href="#" onClick="ppOpen('#forgot_panel', '350');"><?php echo $params->get('modlog7'); ?></a>
		</div>
		<?php endif; ?>
		
	</div>
	<?php endif; ?>
</div><!-- end login panel -->

<?php if($params->get('registration_enable',1)): ?>
<div id="register_panel">
	<div class="inner-container register-panel">
		<h3 class="m_title"><?php echo $params->get('modlog8'); ?></h3>
		
		<form id="register_form" name="register_form" method="post" action="<?php echo JRoute::_('index.php?option=com_users'); ?>">
			<p>
				<input type="text" maxlength="50" id="jform_username" name="jform[username]" class="inputbox required" placeholder="<?php echo $params->get('modlog9'); ?>" required="required"> *
			</p>
			<p>
				<input type="text" maxlength="50" id="jform_name" name="jform[name]" class="inputbox required" placeholder="<?php echo $params->get('modlog10'); ?>" required="required"> *
			</p>
			<p>
				<input type="text" maxlength="100" id="jform_email1" name="jform[email1]" class="inputbox required" placeholder="<?php echo $params->get('modlog11'); ?>" required="required"> *
			</p>
			<p>
				<input type="text" maxlength="100" id="jform_email2" name="jform[email2]" class="inputbox required" placeholder="<?php echo $params->get('modlog16'); ?>" required="required"> *
			</p>
			<p>
				<input type="password" id="jform_password1" name="jform[password1]" class="inputbox required" placeholder="<?php echo $params->get('modlog12'); ?>" required="required"> *
			</p>
			<p>
				<input type="password" id="jform_password2" name="jform[password2]" class="inputbox required" placeholder="<?php echo $params->get('modlog13'); ?>" required="required"> *
			</p>
			<p>
				<input type="submit" id="signup" name="submit" value="<?php echo $params->get('modlog14'); ?>">
			</p>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
			<?php echo JHtml::_('form.token');?>
		</form>
		<div class="links"><a href="#" onClick="ppOpen('#login_panel', '800');"><?php echo $params->get('modlog15'); ?></a></div>
	</div>
</div><!-- end register panel -->
<?php endif; ?>

<?php if($params->get('forget_enable',1)): ?>
<div id="forgot_panel">
	<div class="inner-container forgot-panel">
		<h3 class="m_title"><?php echo $params->get('modlog17'); ?></h3>
		
		<form id="forgot_form" name="forgot_form" method="post" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>">
			<p>
				<input type="text" id="jform_email" name="jform[email]" class="inputbox" placeholder="<?php echo $params->get('modlog18'); ?>" required="required"> *
			</p>
			<p>
				<input type="submit" id="recover" name="submit" value="<?php echo $params->get('modlog19'); ?>">
				<?php echo JHtml::_('form.token'); ?>
			</p>
		</form>
		<div class="links"><a href="#" onClick="ppOpen('#login_panel', '800');"><?php echo $params->get('modlog20'); ?></a></div> 
	</div>
</div><!-- end reset pass panel -->
<?php endif; ?>

<?php } ?>
