<?php

// no direct access
defined('_JEXEC') or die;

$items = $params->get('images');
$mid = $module->id;
$document = JFactory::getDocument(); 
$modpath = 'modules/mod_hg_screenshotbox';
?>

<div class="screenshot-box fixclear <?php echo $moduleclass_sfx; ?>">
	
	<div class="thescreenshot">
		<div class="controls"><a href="#" class="prev"></a><a href="#" class="next"></a></div>
		
		<ul id="screenshot-carousel<?php echo $mid; ?>" class="screenshot-carousel fixclear">
<?php
if($items) {
	foreach($items->vals as $k => $v)
		echo '<li><img src="'.$items->image[$k].'" alt="" ></li>'."\n";
} else {
	echo 'Load some images first!';	
}
?>
		</ul>
	</div>
	
	<div class="left-side"><?php echo $leftside; ?></div>
</div><!-- end screenshot-box -->

<?php

$checkcarouFredSel = false;
$header = $document->getHeadData();
foreach($header['scripts'] as $scriptName => $scriptData)
{
	if(substr_count($scriptName,'/jquery.carouFredSel')){
		$checkcarouFredSel = true;
	}
}	
//Add js
if(!$checkcarouFredSel) 
$document->addScript($modpath.'/assets/jquery.carouFredSel.js');

$js = '
<script type="text/javascript">
;(function($) {
	$(window).load(function(){
		$("#screenshot-carousel'.$mid.'").carouFredSel({
			responsive: true,
			scroll: { fx: "crossfade", duration: "'.$params->get('duration',1500).'" },
			items: {
				width: 580
			},
			auto: {timeoutDuration: '.$params->get('timeoutDuration',5000).'},
			prev	: {	
				button	: ".thescreenshot .prev",
				key		: "left"
			},
			next	: { 
				button	: ".thescreenshot .next",
				key		: "right"
			}
		});
	});
})(jQuery);
</script>';
//$document->addScriptDeclaration($js);

$document->addStyleDeclaration('.thescreenshot { background:url('.$modpath.'/assets/screenshotbox-bg.png) no-repeat left top;}');
echo $js;
?>