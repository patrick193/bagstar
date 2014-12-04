<?php defined( '_JEXEC' ) or die;

// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$tpath = $this->baseurl.'/templates/'.$this->template;
$templateparams = &$app->getTemplate(true)->params;

if ($this->error->getCode() == '404') {
	header('Location: '.JURI::base(true).'/index.php?option=com_content&view=article&id='.$templateparams->get('art404',1));
	exit;
} 

?><!doctype html>
<!--[if IEMobile]><html class="iemobile" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang="<?php echo $this->language; ?>"> <!--<![endif]-->

<head>
  <title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /> <!-- mobile viewport optimized -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700&amp;v1&mp;subset=latin,latin-ext" type="text/css" media="screen"  id="google_font" />
  <link rel="stylesheet" href="<?php echo $tpath; ?>/css/error.css?v=1">
</head>

<body>
    <div id="error">
		<div>
			<h1>
			<?php echo htmlspecialchars($app->getCfg('sitename')); ?>
			</h1>
			<div class="alert">
				<h2><span><?php echo $this->error->getCode(); ?></span></h2>
				<h3><?php echo $this->error->getMessage(); ?></h3>
			</div>
			<?php 
			  if (($this->error->getCode()) == '404') {
				echo '<p><br />';
				echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND');
				echo '</p>';
			  }
			?>
			<p>
			<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>:  
			<a href="<?php echo $this->baseurl; ?>/"><?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a>.
			</p>
		</div>
	</div>
</body>

</html>
