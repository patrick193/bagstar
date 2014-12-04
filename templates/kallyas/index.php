<?php
/* ------------------------------------------------------------------------
  # author    Marius Hogas
  # copyright Copyright © 2013 hogash.com. All rights reserved.
  # @license  Commercial License http://themeforest.net/licenses/regular_extended
  # Website   http://www.hogash.com
  ------------------------------------------------------------------------- */
defined('_JEXEC') or die;

JLoader::register("TplHelper", dirname(__FILE__) . '/helper.php');
$user_agent = TplHelper::getBrowserAgent();
$site_home = TplHelper::detect_home();
$noTopNav = !($this->countModules('support or hidden_login')) ? 'noTopNav' : '';

// detecting active variables
$option = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');
$layout = JRequest::getCmd('layout', '');
$task = JRequest::getCmd('task', '');
$itemid = JRequest::getCmd('Itemid', '');

// variables
$app = JFactory::getApplication();   // Init App
$doc = JFactory::getDocument();    // Init Document
$params = $app->getParams();    // Get Template Params
$templateparams = &$app->getTemplate(true)->params;
$menu = $app->getMenu();     // Get Menu
$menu_params = $menu->getParams($itemid); // Get current menu item parameters
$pageclass = $params->get('pageclass_sfx') . ' '; // parameter (menu entry)
$tpath = $this->baseurl . '/templates/' . $this->template;

if (JRequest::getCmd('boxed') == 1 || $templateparams->get('boxed_version', 0))
    $pageclass .= 'boxed ';

TplHelper::tplStyles($templateparams);


// page header settings
$ph_customstyle = $menu_params->get('ph_customstyle');
$ph_bgimg = $menu_params->get('ph_bgimg');
$ph_title = $menu_params->get('ph_title');
$ph_subtitle = $menu_params->get('ph_subtitle');
$pageHeaderClass = array();
$pageHeaderClass[] = $menu_params->get('ph_sldcolor_default', 'dark-blue');
$pageHeaderClass[] = $menu_params->get('ph_isgradient', 1) ? 'gradient' : '';
$pageHeaderClass[] = $menu_params->get('ph_hasmargin', 0) ? 'hasMargin' : '';
$pageHeaderClass[] = $menu_params->get('ph_noglare', 0) ? 'noGlare' : '';
$pageHeaderClass[] = $this->countModules('action_box') ? 'hasActionBox' : '';
$phAttr = ' class="' . implode(' ', $pageHeaderClass) . '"';
$phAttr .= $ph_customstyle ? ' style="' . $ph_customstyle . '"' : '';
$css = '#page_header {min-height:' . $menu_params->get('ph_height', 300) . 'px;}';
$css .= '#page_header .bgback {' . ($ph_bgimg ? 'background-image:url("' . JURI::base(true) . '/' . $ph_bgimg . '");' : 'display:none;') . '}';
$doc->addStyleDeclaration($css);

// logic to display component or not
$display_component = !($templateparams->get("component_enabled", 1) == 1 && $view == 'featured' && $site_home == 1);

// determine mainbody col size
if ($this->countModules('sidebar_left or sidebar_right'))
    $mainCols = 9;
elseif ($this->countModules('sidebar_left and sidebar_right'))
    $mainCols = 6;
else
    $mainCols = 12;

// Get the message queue
$errMessages = $app->getMessageQueue();
$hasErrors = (is_array($errMessages) && !empty($errMessages)) ? true : false;

/* responsive settings parameters */
$responsive = (bool) $templateparams->get('responsive', 1);
$gridsize = $templateparams->get('gridsize', 1170);
if (JRequest::getCmd('boxed') == 1 || $templateparams->get('boxed_version', 0))
    $pageclass .= 'boxed ';
$pageclass .= $gridsize == 1170 ? 'res1170 ' : 'res960 ';
$pageclass .= $responsive ? 'isresponsive ' : 'notresponsive ';

$this->setGenerator(null);

/* determine if the page has the slideshow fixed class */
$isSlideshowFixed = strpos($pageclass, 'slider_fixed') !== false;

if (JVERSION >= '3')
    $pageclass .= 'joom3 ';
?><!doctype html>
<!--[if IE 7 ]>    <html lang="<?php echo $this->language; ?>" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="<?php echo $this->language; ?>" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="<?php echo $this->language; ?>" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="<?php echo $this->language; ?>" class="no-js"> <!--<![endif]-->


    <head>
        <meta charset="utf-8">
        <meta name="robots" content="index, follow"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <?php
        $parameter_script = 'metaTags';
        $headerstuff = $doc->getHeadData();
        unset($headerstuff[$parameter_script]['http-equiv']);
        $doc->setHeadData($headerstuff);
        ?>
    <jdoc:include type="head" />

    <?php
// display the favicons
    echo TplHelper::displayFavicons($templateparams);

// load css - below are the stylesheets that are loaded 
    TplHelper::loadCSS(array(
        'css/jsystem.css', // Joomla System generic styles
        'css/bootstrap.css', // Bootstrap Css
        'addons/superfish_responsive/superfish.css', // Superfish CSS
        'css/template.css', // Main stylesheet - most of the template's styles
        ($option == 'com_virtuemart' ? 'css/vmsite_ltr.css' : ''), // virtuemart stylesheet
        ($responsive ? 'css/bootstrap_responsive.css' : ( $gridsize == 1170 ? 'css/bootstrap_1170.css' : '' ) ), // If Responsive, load bootstra-responsive.css, if not & gridsize is 1170 also load bootstrap-1170.css
        ($templateparams->get('theme', 'light') == 'dark' ? 'css/dark-theme.css' : ''),
        'css/updates.css', // I will add updates here in this stylesheet
        'css/custom.css'      // Custom styles added by you
            ), $templateparams);

// load js - below are the js files that are loaded
    TplHelper::loadJS(array(
        ($templateparams->get('modernizr') ? 'js/modernizr-2.6.2.js' : ''), // Modernizr
        'js/plugins.js',
        'addons/superfish_responsive/superfish_menu.js'
            ), $templateparams);

//load google fonts
    TplHelper::googleFonts($templateparams);
    ?>
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!--[if lte IE 8]>
<?php if ($templateparams->get('pie', 1)) : ?>
                <link rel="stylesheet" type="text/css" href="<?php echo $tpath ?>/css/pie.css.php?p=<?php echo urlencode($tpath); ?>" />
<?php endif; ?>
    
            <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
            <script type="text/javascript"> 
            var $buoop = {vs:{i:8,f:6,o:10.6,s:4,n:9}} 
            $buoop.ol = window.onload; 
            window.onload=function(){ 
             try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
             var e = document.createElement("script"); 
             e.setAttribute("type", "text/javascript"); 
             e.setAttribute("src", "http://browser-update.org/update.js"); 
             document.body.appendChild(e); 
            } 
            </script> 
    <![endif]-->

    <!--[if lte IE 9]>
            <link rel="stylesheet" type="text/css" href="<?php echo $tpath ?>/css/fixes.css" /> 
    <![endif]-->

    <?php
// Display Google Analytics
    echo TplHelper::googleAnalytics($templateparams);

// Display the Facebook Open Graph Meta Tags
    echo TplHelper::facebookSDK('ograph', $templateparams);

    $body_class = str_replace('  ', ' ', $pageclass . " " . $option . " " . $view . " " . $layout . " " . $task . " item-" . $itemid . " " . ($site_home ? "homepage" : "") . " " . $user_agent);
    ?>
</head>

<body class="<?php echo $body_class; ?>">
    <?php
// display Facebook's SDK code, load only once
    echo TplHelper::facebookSDK('sdk', $templateparams);
    ?>
<?php if ($this->countModules('support')): ?>
        <div class="support_panel" id="sliding_panel">
            <div class="container">
                <div class="row">
                    <jdoc:include type="modules" name="support" style="default" heading="h4" />
                </div><!-- end row -->
            </div>
        </div><!-- end support panel -->
<?php endif; ?>

    <?php if ($this->countModules('hidden_login')): ?>
        <div class="login_register_stuff hide">
            <jdoc:include type="modules" name="hidden_login" style="none" />
        </div><!-- end login_register_stuff -->
<?php endif; ?>

    <div id="page_wrapper">

        <header id="header" class="style<?php echo $templateparams->get('header_style', 2); ?>">
            <div class="container">

                <!-- logo -->
<?php TplHelper::displayLogo($this->baseurl, $templateparams); ?>
                <div id="infocard" >


                    <div class="custom ">
                        <div class="row-fluid "> <div class="span5">
                                <p>&nbsp;</p>
                                <p style="text-align: center;"><img src="/images/10.png" alt="" border="0"></p>
                            </div>
                            <div class="span7">
                                <div class="custom contact-details">
                                    <p><strong>T (111) 1111111111</strong><br> Email: <a href="#">bagstar@mail.ru</a></p>
                                    <p>BagStar<br> Харьков</p>
                                </div>
                                <div style="height:20px;"></div>
                                <ul class="social-icons normal ">
                                    <li class="title">GET SOCIAL</li>
                                    <li class="social-twitter"><a href="#" target="_blank">twitter</a>
                                    </li><li class="social-dribbble"><a href="#" target="_blank">dribbble</a>
                                    </li><li class="social-facebook"><a href="#" target="_blank">facebook</a>
                                    </li><li class="social-envato"><a href="#" target="_blank">envato</a>
                                    </li></ul>
                            </div>
                        </div>
                    </div>

                </div>
                    <?php if ($this->countModules('support or hidden_login')): ?>
                    <!-- top nav right-->
                    <ul class="topnav navRight">

                        <!-- BEGIN support clickable button -->
                        <?php if ($this->countModules('support')): ?>
                            <li><a href="#" id="open_sliding_panel">
                                    <span class="icon-remove-circle icon-white"></span> <?php echo JText::_('TPL_KALLYAS_SUPPORT'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <!-- END support clickable button -->

                        <!-- BEGIN hidden login/register/remind popups -->
    <?php if ($this->countModules('hidden_login')): ?>
        <?php if (JFactory::getUser()->guest) { ?>
                                <li><a href="#login_panel" data-rel="prettyPhoto[login_panel]"><?php echo JText::_('TPL_KALLYAS_LOGIN'); ?></a></li>
        <?php } else { ?>
                                <li class="logout_btn">
                                    <form action="<?php echo JRoute::_('index.php', true); ?>" method="post">
                                        <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" />
                                        <input type="hidden" name="option" value="com_users" />
                                        <input type="hidden" name="task" value="user.logout" />
                                        <input type="hidden" name="return" value="" />
                                <?php echo JHtml::_('form.token'); ?>
                                    </form>
                                </li>
                            <?php } ?>
                        <?php endif; ?>
                        <!-- END hidden login/register/remind popups -->

                    <?php if ($this->countModules('top_pos')): ?>
                            <li class="toppos"><jdoc:include type="modules" name="top_pos" style="none" /></li>
                    <?php endif; ?>

                    </ul><!-- end topnav // right aligned -->
                    <?php endif; ?>

<?php if ($this->countModules('cart_pos or languages')): ?>
                    <ul class="topnav navLeft">
    <?php if ($this->countModules('cart_pos')): ?>
                            <li class="drop">
                                <a href="#"><?php // echo JText::_('TPL_KALLYAS_MY_CART'); ?> <img class="cart_logo" src="images/cart-logo.png" alt="<?php echo JText::_('TPL_KALLYAS_MY_CART'); ?>" /></a>
                                <div class="pPanel">
                                    <div class="inner">
                                        <jdoc:include type="modules" name="cart_pos" style="none" />
                                    </div>
                                </div>
                            </li>
    <?php endif; ?>

                        <?php if ($this->countModules('languages')): ?>
                            <li class="languages drop">
                                <a href="#"><?php echo JText::_('TPL_KALLYAS_LANGUAGES'); ?></a>
                            <jdoc:include type="modules" name="languages" style="none" />
                            </li>
    <?php endif; ?>

                    </ul><!-- end topnav // left aligned -->
<?php endif; ?>

                <!-- search -->
                    <?php echo TplHelper::displaySearch($noTopNav, $templateparams); ?>

                <!-- Main menu -->
                <nav id="main_menu" class="<?php echo (!$templateparams->get('search', 1) ? 'clearRight' : '') . ' ' . $noTopNav; ?>">
<?php TplHelper::renderMenu($templateparams); ?>
                </nav><!-- end main_menu -->

            </div><!-- end container -->
        </header><!-- end header -->

            <?php if ($this->countModules('slideshow')) { ?>

            <div id="slideshow" <?php echo TplHelper::slideshow_style($itemid); ?>>
            <?php if ($menu_params->get('showanimation', 0)): ?><div id="sparkles"></div><?php endif; ?>
                <jdoc:include type="modules" name="slideshow" style="none" />
    <?php echo TplHelper::slideshow_bottommask($itemid); ?><!-- bottom mask -->
            </div><!-- end slideshow -->

<?php } else { ?>
            <div id="page_header" <?php echo $phAttr; ?>>
                <div class="bgback"></div>
    <?php if ($menu_params->get('ph_showanimation', 0)): ?><div id="sparkles"></div><?php endif; ?>
                <div class="container">
                    <div class="row">
                                <?php if ($this->countModules('breadcrumb')): ?>
                            <div class="span6">
                                <jdoc:include type="modules" name="breadcrumb" style="none" />
                                    <?php if ($menu_params->get('ph_showdate', 1)): ?>
                                    <span id="current-date">
                                    <?php
                                    $time_now = mktime(date('h') + 5, date('i') + 30, date('s'));
                                    print date('l M dS, Y', $time_now);
                                    ?>
                                    </span>
        <?php endif; ?>
                            </div>
                                <?php endif; ?>
                                <?php if ($ph_title or $ph_subtitle): ?>
                            <div class="span6 <?php if (!$this->countModules('breadcrumb')) echo 'offset6'; ?>">
                                <div class="header-titles">
                            <?php if ($ph_title) echo '<h2>' . $ph_title . '</h2>'; ?>
        <?php if ($ph_subtitle) echo '<h4>' . $ph_subtitle . '</h4>'; ?>
                                </div>
                            </div>
            <?php endif; ?>
                    </div><!-- end row -->
                </div>
                <div class="shadowUP"></div>
            </div><!-- end page_header -->
        <?php } ?>

<?php if ($isSlideshowFixed)
    echo '<span class="slideshow_back"></span>
		<div class="inner-page">';
?>

        <jdoc:include type="modules" name="action_box" style="none" />

        <section class="system-messages">
            <div class="container">
                <jdoc:include type="message" />
            </div>
        </section><!-- end system messages -->

        <section id="content" <?php echo ($hasErrors ? 'class="hasMessages"' : '') ?>>

            <?php if ($this->countModules('user1')): ?>
                <div id="user1" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user1" style="default" />
                    </div>
                </div><!-- end #user1 -->
<?php endif; ?>

            <?php if ($this->countModules('user2')): ?>
                <div id="user2" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user2" style="default" />
                    </div>
                </div><!-- end #user2 -->
<?php endif; ?>

            <?php if ($this->countModules('user3')): ?>
                <div id="user3" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user3" style="default" />
                    </div>
                </div><!-- end #user3 -->
<?php endif; ?>

            <?php if ($this->countModules('user4')): ?>
                <div id="user4" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user4" style="default" />
                    </div>
                </div><!-- end #user4 -->
<?php endif; ?>

            <?php if ($this->countModules('user5')): ?>
                <div id="user5" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user5" style="default" />
                    </div>
                </div><!-- end #user5 -->
<?php endif; ?>

            <?php if ($this->countModules('user6')): ?>
                <div id="user6" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user6" style="default" />
                    </div>
                </div><!-- end #user6 -->
<?php endif; ?>

            <?php if ($this->countModules('user7')): ?>
                <div id="user7" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user7" style="default" />
                    </div>
                </div><!-- end #user7 -->
<?php endif; ?>

            <?php if ($this->countModules('user8')): ?>
                <div id="user8" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user8" style="default" />
                    </div>
                </div><!-- end #user8 -->
<?php endif; ?>

            <?php if ($this->countModules('user9')): ?>
                <div id="user9" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user9" style="default" />
                    </div>
                </div><!-- end #user9 -->
<?php endif; ?>

            <?php if ($this->countModules('user10')): ?>
                <div id="user10" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user10" style="default" />
                    </div>
                </div><!-- end #user10 -->
                    <?php endif; ?>


            <div id="mainbody" class="container">
                <div class="row">
                    <?php if ($this->countModules('sidebar_left')): ?>
                        <div class="span3">
                            <div id="sidebar_left" class="sidebar">
                                <jdoc:include type="modules" name="sidebar_left" style="default" />
                            </div><!-- end #sidebar -->
                        </div>
                    <?php endif; ?>

                    <div class="span<?php echo $mainCols; ?>">
                        <jdoc:include type="component" />
                    </div><!-- end main component -->

                    <?php if ($this->countModules('sidebar_right')): ?>
                        <div class="span3">
                            <div id="sidebar_right" class="sidebar">
                                <jdoc:include type="modules" name="sidebar_right" style="default" />
                            </div><!-- end #sidebar -->
                        </div>
            <?php endif; ?>
                </div>
            </div><!-- end #MainBody -->


<?php if ($this->countModules('user11 or user12')): ?>
                <div class="gray-area">
                    <?php if ($this->countModules('user11')): ?>
                        <div id="user11" class="container">
                            <div class="row">
                                <jdoc:include type="modules" name="user11" style="default" />
                            </div>
                        </div><!-- end #user11 -->
    <?php endif; ?>

                    <?php if ($this->countModules('user12')): ?>
                        <div id="user12" class="container">
                            <div class="row ">
                                <jdoc:include type="modules" name="user12" style="default" />
                            </div>
                        </div><!-- end #user12 -->
                <?php endif; ?>
                </div>
<?php endif; ?>


            <?php if ($this->countModules('user13')): ?>
                <div id="user13" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user13" style="default" />
                    </div>
                </div><!-- end #user13 -->
<?php endif; ?>

            <?php if ($this->countModules('user14')): ?>
                <div id="user14" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user14" style="default" />
                    </div>
                </div><!-- end #user14 -->
<?php endif; ?>

            <?php if ($this->countModules('user15')): ?>
                <div id="user15" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user15" style="default" />
                    </div>
                </div><!-- end #user15 -->
<?php endif; ?>

            <?php if ($this->countModules('user16')): ?>
                <div id="user16" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user16" style="default" />
                    </div>
                </div><!-- end #user16 -->
<?php endif; ?>

            <?php if ($this->countModules('user17')): ?>
                <div id="user17" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="user17" style="default" />
                    </div>
                </div><!-- end #user17 -->
<?php endif; ?>


        </section><!-- end #content section -->

        <footer id="footer">

            <?php if ($this->countModules('footer1')): ?>
                <div id="footer1" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="footer1" style="default" heading="h3" />
                    </div>
                </div><!-- end #footer1 -->
<?php endif; ?>

            <?php if ($this->countModules('footer2')): ?>
                <div id="footer2" class="container">
                    <div class="row">
                        <jdoc:include type="modules" name="footer2" style="default" />
                    </div>
                </div><!-- end #footer2 -->
<?php endif; ?>

        <?php
        //load footer
        require_once dirname(__FILE__) . '/footer.php';
        ?>

        </footer>

<?php if ($isSlideshowFixed) echo '</div><!-- end inner-page-->'; ?>

    </div><!-- end page_wrapper -->

<?php if ($templateparams->get('totop', 1)) echo '<a href="#" id="totop">' . JText::_('TPL_KALLYAS_TOTOP') . '</a>'; ?>

<jdoc:include type="modules" name="debug" />



<script type="text/javascript">
    var hasChaser = <?php echo $templateparams->get("has_chaser", 1) ?>,
            template_path = '<?php echo $tpath ?>';
</script>
<script src="<?php echo $tpath ?>/js/kallyas_script.js" type="text/javascript"></script>

<?php if ($templateparams->get('demopanel', 0)) require_once dirname(__FILE__) . '/addons/demo_panel/demo_panel.php'; ?>

<!-- prettyphoto scripts & styles -->
<link rel="stylesheet" href="<?php echo $tpath ?>/addons/prettyphoto/prettyPhoto.css" type="text/css" />
<!--<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js' type='text/javascript'></script>--> 
<script type="text/javascript">
function posMouse(e){
 var mouX = 0, mouY = 0;
 if (!e) e = window.event;
 if (e.pageX || e.pageY) {
  mouX = e.pageX;
  mouY = e.pageY;
 } else if (e.clientX || e.clientY) {
  mouX = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
  mouY = e.clientY + (document.documentElement.scrollTop || document.body.scrollTop) - document.documentElement.clientTop;
 }
 return {"x":mouX, "y":mouY}
}

$(document).ready(function(){
 $('h1#logo').mouseover(function(){
  $(this).next().slideDown('slow');
 })
 .mouseout(function(e){
  var elem = $(this).next(), mou = posMouse(e);
  if ((mou.x < elem.offset().left) || (mou.x > elem.offset().left + elem.width()) || (mou.y < elem.offset().top))
   elem.slideUp('slow');
 });
 $('div#infocard').mouseleave(function(){
  $(this).slideUp('slow');
 });
});
</script>

<script type="text/javascript" src="<?php echo $tpath ?>/addons/prettyphoto/jquery.prettyPhoto.js"></script>
<script type="text/javascript">

    function ppOpen(panel, width) {
        jQuery.prettyPhoto.close();
        setTimeout(function() {
            jQuery.fn.prettyPhoto({social_tools: false, deeplinking: false, show_title: false, default_width: width, theme: 'pp_kalypso'});
            jQuery.prettyPhoto.open(panel);
        }, 300);
    } // function to open different panel within the panel

    jQuery(document).ready(function($) {
        jQuery("a[data-rel^='prettyPhoto'], .prettyphoto_link").prettyPhoto({theme: 'pp_kalypso', social_tools: false, deeplinking: false});
        jQuery("a[rel^='prettyPhoto']").prettyPhoto({theme: 'pp_kalypso'});
        jQuery("a[data-rel^='prettyPhoto[login_panel]']").prettyPhoto({theme: 'pp_kalypso', default_width: 800, social_tools: false, deeplinking: false});
        jQuery(".prettyPhoto_transparent").click(function(e) {
            e.preventDefault();
            jQuery.fn.prettyPhoto({social_tools: false, deeplinking: false, show_title: false, default_width: 980, theme: 'pp_kalypso transparent', opacity: 0.95});
            var tlink = $(this).attr('href'),
                    n = tlink.replace(/tmpl=component/g, "tmpl=component&amp;transparent=1");
            jQuery.prettyPhoto.open(n, '', '');
        });
    });
</script>
<!--end prettyphoto -->
</body>
</html>