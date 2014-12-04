<?php

defined( '_JEXEC' ) or die;

JLoader::register("TplHelper", dirname(__FILE__).'/helper.php');
JPluginHelper::importPlugin('content');

// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$tpath = $this->baseurl.'/templates/'.$this->template;
$templateparams = &$app->getTemplate(true)->params;
$date = $templateparams->get('off_data');

$this->setGenerator(null);

// Get the message queue
$errMessages = $app->getMessageQueue();
$hasErrors = (is_array($errMessages) && !empty($errMessages)) ? true : false;

// load css - below are the stylesheets that are loaded 
TplHelper::loadCSS(array(
	'css/jsystem.css',						// Joomla System generic styles
	'css/bootstrap.css',					// Bootstrap Css
	'css/template.css',						// Main stylesheet - most of the template's styles
	'css/updates.css',						// I will add updates here in this stylesheet
	'css/custom.css',						// Custom styles added by you
	'css/responsive-devices.css',			// Responsive CSS
	'css/offline.css' 						// Offline CSS
), $templateparams);

?><!doctype html>
<!--[if IE 7 ]>    <html lang="<?php echo $this->language; ?>" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="<?php echo $this->language; ?>" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="<?php echo $this->language; ?>" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="<?php echo $this->language; ?>" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="robots" content="index, follow"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<jdoc:include type="head" />
<?php
// display the favicons
echo TplHelper::displayFavicons($templateparams);

//load google fonts
TplHelper::googleFonts($templateparams);

// Display Google Analytics
echo TplHelper::googleAnalytics($templateparams);
?>
</head>

<body class="offline-page">
	<div id="background"></div>
	<jdoc:include type="message" />

	<div id="frame" <?php echo ($hasErrors ? 'class="hasMessages"':'')?>>
		<form action="<?php echo JRoute::_('index.php', true); ?>" method="post" name="login" id="form-login">
			
			<input type="text" id="username" name="username" class="inputbox" placeholder="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" alt="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" required>
			<input type="password" id="password" name="password" class="inputbox" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" alt="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" required>
			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			<div class="remember-field">
				<label id="remember-lbl" for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
				<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"  alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" />
			</div>
			<?php endif; ?>
			<input type="submit" id="loginBtn" class="btn" name="Submit" value="<?php echo JText::_('JLOGIN'); ?>">
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.login" />
			<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()); ?>" />
			<?php echo JHTML::_( 'form.token' ); ?>

		</form>
	
  		<div class="containerbox">
			<h1 id="logo"><a href="<?php echo JURI::base(); ?>"><img src="<?php echo $templateparams->get('off_logo'); ?>" alt="<?php echo htmlspecialchars($app->getCfg('sitename')); ?>"></a></h1>
			<div class="content">
				
				<?php echo JHtml::_('content.prepare', $templateparams->get('off_content')); ?>
				<div class="clear"></div>
			</div><!-- end content -->
			<div class="clear"></div>
		</div>
        
    </div>
	
<!--////////////////// Load JS Files -->



</body>

</html>