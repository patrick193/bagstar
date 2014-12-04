<?php
/**
* @package SP VirtueMart Product Slider
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2014 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
?>
<div class="sp-vmslider-wrapper <?php echo $moduleclass_sfx; ?>" id="sp-vmslider-<?php echo $module_id ?>">
    <div class="sp-vmslider">
        <?php $ic = 0; foreach ($products as $product) {  $ic++; ?>
        <div class="slider-item">
            <div class="sp-vmslider-container  pull-left">

                <div class="sp-vmslider-title">

                    <h1><a href="<?php echo $modSPVMSliderHelper->url($product) ?>"><?php echo $product->product_name ?></a></h1>
                    <h2><?php echo $currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE); ?></h2>
                    <h3><?php echo $currency->createPriceDiv ('costPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE); ?></h3>
                    <h4><?php  echo round((($product->prices['discountAmount']*100)/$product->product_price)); ?>% <?php echo jText::_('SP_VM_SLIDER_OFF'); ?></h4>
                </div>

                <div class="sp-vmslider-details">
                    <div class="cart-details">
                        <a class="btn btn-large slider-btn" href="<?php echo $modSPVMSliderHelper->url($product) ?>"><?php echo jText::_('SP_VM_SLIDER_DETAILS'); ?></a>
                    </div>

                    <div class="cart-show">
                        <?php echo $modSPVMSliderHelper->addtocart($product) ?>
                    </div>
                </div>

                <div class="sp-vmslider-counter">
                    <div id="sp-deal-countdown-<?php echo $ic ?>"></div>
                </div>
                <script type="text/javascript">
                jQuery(function($){
                    $('#sp-deal-countdown-<?php echo $ic ?>').countdown({ 
                        until: new Date(<?php
                            $m = JHtml::date($product->product_available_date , 'm', true)-1; 
                            $y = JHtml::date($product->product_available_date , 'Y', true); 
                            $d = JHtml::date($product->product_available_date , 'd', true); 
                            echo "$y,$m,$d"; ?>),
                        format: 'dHMS',
                        layout: '<ul class="sp-countdown-list">\
                        <li>\
                        <p class="sp-countdown-number">{dl}</p>\
                        <p class="sp-countdown-names">{dn}</p> \
                        </li>\
                        <li>\
                        <p class="sp-countdown-number">{hl}</p>\
                        <p class="sp-countdown-names">{hn}</p> \
                        </li>\
                        <li>\
                        <p class="sp-countdown-number">{ml}</p>\
                        <p class="sp-countdown-names">{mn}</p> \
                        </li>\
                        <li>\
                        <p class="sp-countdown-number">{sl}</p>\
                        <p class="sp-countdown-names">{sn}</p>\
                        </li>\
                        </ul>',
                        expiryText: "<div class='label label-important sp-countdown-over'><?php echo jText::_('SP_VM_SLIDER_DEAL_OVER'); ?></div>",
                        alwaysExpire:true
                    });
});
</script>
</div>
<div class="sp-vmslider-image pull-right">
    <?php echo $modSPVMSliderHelper->image($product)  ?>
</div>
<div class="clearfix"></div>
</div>
<?php }  ?>
</div>


<div class="sp-vmslider-controller">  
    <?php if(JFactory::getDocument()->direction=='rtl'){ ?>
    <a class="sp-vmslider-next"><i class="icon-chevron-right"></i></a><a class="sp-vmslider-prev"><i class="icon-chevron-left"></i></a> 
    <?php
} else { ?>
<a class="sp-vmslider-prev"><i class="icon-chevron-left"></i></a><a class="sp-vmslider-next"><i class="icon-chevron-right"></i></a>
<?php } ?>
</div>
</div>
<?php
ob_start();
?>
jQuery(function($){
    $('#sp-vmslider-<?php echo $module->id?> .sp-vmslider').SPSimpleSlider({
        autoplay  : true,
        interval  : 5000,
        fullWidth : false,
        rWidth : 135,
        rHeight : 58,
        preloadImages:[<?php
        foreach($products as $prod) $images[] = "'".JURI::root().'/'.$modSPVMSliderHelper->imageURL($prod)."'";
        echo implode(',',$images);
        ?>],
    });


    $('#sp-vmslider-<?php echo $module->id?> .sp-vmslider-controller .sp-vmslider-prev').click(function(event){
        event.stopPropagation();
        $('#sp-vmslider-<?php echo $module->id?> .sp-vmslider').SPSimpleSlider('prev');
    });


    $('#sp-vmslider-<?php echo $module->id?> .sp-vmslider-controller .sp-vmslider-next').click(function(event){
        event.stopPropagation();
        $('#sp-vmslider-<?php echo $module->id?> .sp-vmslider').SPSimpleSlider('next');
    });

});
<?php
$script = ob_get_clean();
$doc->addScriptDeclaration($script);
