<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$col= 1 ;
?>
<div class="vmmanufacturermod vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if ($headerText) : ?>
	<p class="vmheader"><?php echo $headerText ?></p>
<?php endif;

	$last = count($manufacturers)-1;
?>

<ul class="vmmanufacturer clearfix <?php echo $params->get('moduleclass_sfx'); ?>">
<?php
foreach ($manufacturers as $manufacturer) {
	$link = JROUTE::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);
	?>
	<li>
		<a href="<?php echo $link; ?>" data-rel="tooltip" data-placement="top" data-animation="true" data-original-title="<?php echo $manufacturer->mf_name; ?>">
		<?php
		if ($manufacturer->images && ($show == 'image' or $show == 'all' )) {
			echo $manufacturer->images[0]->displayMediaThumb('',false);
		}
		?>
			<span class="theHoverBorder"></span>
		</a>
	</li>
	<?php
	$col++;
	$last--;
} ?>
</ul>

<?php 
	if ($footerText) : ?>
	<p class="vmfooter<?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</p>
<?php endif; ?>
</div>
