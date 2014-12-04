<?php defined( '_JEXEC' ) or die; 
JLoader::register("TplHelper", dirname(__FILE__).'/helper.php');
// variables

// variables
$app = JFactory::getApplication();			// Init App
$doc = JFactory::getDocument(); 			// Init Document
$params = $app->getParams();				// Get Template Params
$templateparams = &$app->getTemplate(true)->params;
$menu = $app->getMenu();					// Get Menu
$itemid = JRequest::getCmd('Itemid', '');
$menu_params = $menu->getParams($itemid);	// Get current menu item parameters
$pageclass = $params->get('pageclass_sfx'); // parameter (menu entry)
$tpath = $this->baseurl.'/templates/'.$this->template;

$this->setGenerator(null);


TplHelper::tplStyles($templateparams);
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
	'css/responsive-devices.css'			// Responsive CSS

), $templateparams);

?><!doctype html>
<!--[if IE 7 ]>    <html lang="<?php echo $this->language; ?>" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="<?php echo $this->language; ?>" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="<?php echo $this->language; ?>" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="<?php echo $this->language; ?>" class="no-js"> <!--<![endif]-->
<head>
	<jdoc:include type="head" />
	<meta charset="utf-8">
	<meta name="robots" content="index, follow"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<?php
// display the favicons
echo TplHelper::displayFavicons($templateparams);

//load google fonts
TplHelper::googleFonts($templateparams);

// Display Google Analytics
echo TplHelper::googleAnalytics($templateparams);

?>
<style type="text/css">
/* Turn on a 13x13 scrollbar */
::-webkit-scrollbar { width: 6px; height: 13px; }
::-webkit-scrollbar-button:vertical { background-color: red; border:none; }
/* Turn on single button up on top, and down on bottom */
::-webkit-scrollbar-button:start:decrement,
::-webkit-scrollbar-button:end:increment { display: block; }
/* Turn off the down area up on top, and up area on bottom */
::-webkit-scrollbar-button:vertical:start:increment,
::-webkit-scrollbar-button:vertical:end:decrement {display: none;}
/* Place The scroll down button at the bottom */
::-webkit-scrollbar-button:vertical:increment {background-color: transparent;border:none;}
/* Place The scroll up button at the up */
::-webkit-scrollbar-button:vertical:decrement { background-color: transparent; border:none; }
::-webkit-scrollbar-track:vertical { background-color:transparent; border:none; }
/* Top area above thumb and below up button */
::-webkit-scrollbar-track-piece:vertical:start { border:none; }
/* Bottom area below thumb and down button */
::-webkit-scrollbar-track-piece:vertical:end { background-color:transparent; }
/* Track below and above */
::-webkit-scrollbar-track-piece { background-color:transparent;}
/* The thumb itself */
::-webkit-scrollbar-thumb:vertical { height: 50px; background-color: #333; background-color: rgba(255,255,255,0.1); -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px; border-color:transparent; }
/* Corner */
::-webkit-scrollbar-corner:vertical { background-color: transparent; }
/* Resizer */
::-webkit-scrollbar-resizer:vertical { background-color: transparent; }
</style>
</head>

<body class="component <?php if(JRequest::getCmd('transparent')==1) echo 'transparent';?>">
  <div id="overall">
    <jdoc:include type="message" />
    <jdoc:include type="component" />
  </div>
  <?php if (isset($_GET['print']) && $_GET['print'] == '1') echo '<script type="text/javascript">window.print();</script>'; ?>
</body>

</html>
