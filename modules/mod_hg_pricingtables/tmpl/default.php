<?php

// no direct access
defined('_JEXEC') or die;

$items = $params->get('tables');
$mid = $module->id;
$document = JFactory::getDocument(); 
$hasCaption = $params->get('hasCaptCol',0);
$parentGrid = filter_var($params->get('gridlist',12), FILTER_SANITIZE_NUMBER_INT);
//$cols = round(($hasCaption ? $parentGrid-3 : $parentGrid)/count($items->vals), 0, PHP_ROUND_HALF_DOWN);
$cols = floor(($hasCaption ? $parentGrid-3 : $parentGrid)/count($items->vals));

$mastercolor = $params->get('mastercolor',0);
?>
<div class="row-fluid <?php echo ($params->get('hasSpaces',0) ? '':'no-space '); ?><?php echo ($params->get('roundedCorners',0) ? '':'rounded-corners '); ?>pricing_table <?php echo $moduleclass_sfx; ?>">
<?php
if($hasCaption):
	$captColTitle = $params->get('captColTitle');
	$captColFeatures = $params->get('captColFeatures');
	$ColFeaturesList = preg_split('/\n|\r/', $captColFeatures, -1, PREG_SPLIT_NO_EMPTY);
?>
<div class="span3">
	<div class="pr_table_col caption_column">
		<div class="tb_header">
			<?php echo $captColTitle; ?>
		</div>
		<ul class="tb_content">
		<?php
		foreach($ColFeaturesList as $k => $v)
			echo '<li>'.$v.'</li>';
		?>
		</ul>
	</div>
</div>
<?php
endif;
?>

<?php
if($items) {
	foreach($items->vals as $k => $v):
	
		$color = $items->color[$k];
		$featured = $items->featured[$k];
		$title = $items->title[$k];
		$price = $items->price[$k];
		$per = $items->per[$k];
		$url = $items->linkurl->link[$k];
		$target = $items->linkurl->target[$k];
		$linktext = $items->linktext[$k];
		$features = $items->features[$k];
		$features_list = preg_split('/\n|\r/', $features, -1, PREG_SPLIT_NO_EMPTY);
	
?>
<div class="span<?php echo $cols; ?>">
	<div class="pr_table_col <?php echo ($featured ? 'highlight':''); ?>" data-color="<?php echo $mastercolor ? $mastercolor : $color; ?>">
		<div class="tb_header">
			<h4 class="ttitle"><?php echo $title; ?></h4>
			<div class="price">
				<p><?php echo $price; ?><span><?php echo $per; ?></span></p>
			</div>
		</div>
		<ul class="tb_content">
		<?php
		foreach($features_list as $k => $v)
			echo '<li>'.$v.'</li>';
		?>
		</ul>
		<div class="signin">
			<a class="btn" href="<?php echo $url; ?>" target="<?php echo $target; ?>"><?php echo $linktext; ?></a>
		</div>
	</div><!-- end pricing table column -->
</div>

<?php
	endforeach;
} else {
	echo 'Load some pricing columns first!';	
}
?>
	
</div>