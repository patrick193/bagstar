<?php
/**
 * @package Sj MiniCart Pro
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */

defined('_JEXEC') or die; ?>

<script type="text/javascript">
	//<![CDATA[		
	$jsmart(document).ready(function($){
		$minicart = $('#sj_minicart_pro_<?php echo $uniqued;?>');
		
			/*
			 * Set display jscrollpanel
			 */
			var jscrollDisplay = function(){
				var $h0 =0;
				for(var $i=0; $i < $('.mc-product',$minicart).length ;$i++){
					$h0 = $h0 + $($('.mc-product',$minicart)[$i]).height();
				}
				var element = $('.mc-list-inner',$minicart).jScrollPane({
					showArrows: true
					
				});
				var api = element.data('jsp');
				if( $h0 > $('.mc-list',$minicart).height()){
					element;
				}else{
					api.destroy(); 
				}		
			}
			
			/*
			 * MouseOver - MouseOut
			 */
			$('.mc-wrap' ,$minicart).hover(function(){
				var $this = $(this);
				if ($this.data('timeout')){
					clearTimeout($this.data('timeout'));
				}
				if($this.hasClass('over')){
					return ;
				}
				$this.addClass('over');
				$('.mc-content', $this).slideDown(250);
				jscrollDisplay(); 
			}, function(){
				var $this = $(this);
				var timeout = setTimeout(function(){            
					$('.mc-content', $this).not(':animated').slideUp(250);
					$this.removeClass('over');
	        	 }, 250);
				$this.data('timeout', timeout);
			});		
			
			/*
			 *  Ajax url
			 */
			var ajax_url = '<?php echo (string)JURI::getInstance(); ?>';
		
			/*
			 * Refresh
			 */ 
			var productsRefresh = function(cart){
				var $cart = cart ? $(cart) : $minicart;
				$.ajax({
					type: 'POST',
					url: ajax_url,
					data: {
						minicart_ajax:1,
						option: 'com_virtuemart',
						minicart_task: 'refresh',
						minicart_modid:'<?php echo $module->id; ?>',
						view: 'cart'
					},	
					success: function(list){
						var $mpEmpty = $cart.find('.mc-product-zero');					
						$('.mc-product-wrap',$cart).html($.trim(list.list_html));
						$('.mc-totalprice ,.mc-totalprice-footer',$cart).html(list.billTotal);
						$('.mc-totalproduct',$cart).html(list.length);
						deleteProduct();
						if(list.length>1){
							$cart.find('.mc-status').html('<?php echo JText::_('ITEMS') ?>');	
						}else{
							$cart.find('.mc-status').html('<?php echo JText::_('ITEM') ?>');	
						}
						
						if(list.length>0){
							$cart.find('.mc-empty').hide();
							$cart.find('.mc-content-inner').show();
							$cart.find('.mc-totalprice').show();
							$cart.find('.mc-checkout-top').show();
					 		$mpEmpty.remove();
						}else{
							$cart.find('.mc-totalprice').hide()	;
							$cart.find('.mc-content-inner').hide();
							$cart.find('.mc-empty').show();
							$cart.find('.mc-checkout-top').hide();
						}
						jscrollDisplay(); 
					},
					dataType: 'json'
				});
				return;
			}
			
			/*
			 * Event Addtocart Button - no load page
			 */
			$('input[name="addtocart"]').bind('click.mini',function(){
					if ($minicart.data('timeout')){
							clearTimeout($minicart.data('timeout'));
						}
					var timeout = setTimeout(function(){
						productsRefresh();
					},500);
					$minicart.data('timeout',timeout);
			});
		
			/*
			 *  Set coupon
			 */
			$('.coupon-button-add',$minicart).click(function(){
					$('.preloader',$minicart).show();
					$('.coupon-message',$minicart).hide(); 
					$('.coupon-input',$minicart).hide();
					$('.coupon-title',$minicart).hide();	
					$.ajax({
						type: 'POST',
						url : ajax_url,
						data: {					
							minicart_ajax: 1,
							option: 'com_virtuemart',
							view:'cart',
							minicart_task: 'setcoupon',
							coupon_code: $('.coupon-code', $minicart).val(),
							tmpl: 'component'					
						},
						success: function($json){
							console.log($json);
								$('.preloader',$minicart).hide();
							if($json.status && $json.status==1)	{
								$('.coupon-message',$minicart).hide();
								$('.coupon-input',$minicart).hide();					
								$('.coupon-label',$minicart).show();
								$('.coupon-title',$minicart).show();
								$('.coupon-text',$minicart).html($json.message);
								 productsRefresh(); 
							}else{
								$('.coupon-title',$minicart).show();
								$('.coupon-input',$minicart).show();
								$('.coupon-message',$minicart).show();
							}
																	 
						},
						dataType: 'json'
					});
			});
		
			/*
			 * Close coupon
			 */
			$('.coupon-close',$minicart).click(function(){			
				$('.preloader',$minicart).show();
				$('.coupon-label',$minicart).hide();
				$('.coupon-title',$minicart).hide();	
				$.ajax({
					type: 'POST',
					url : ajax_url,
					data: {					
						minicart_ajax: 1,
						view:'cart',
						option: 'com_virtuemart',
						minicart_task: 'setcoupon',
						coupon_code: null,
						tmpl: 'component'	
					},
					success: function($json){							
						$('.preloader',$minicart).hide();
						$('.coupon-title',$minicart).show();
						$('.coupon-input',$minicart).show();					
						$('.coupon-code', $minicart).val('Enter your Coupon code');
					 	productsRefresh();				 
					},
					dataType: 'json'
				});
				
			});

			/*
			 * Update Products
			 */ 
			$('.mc-update-btn',$minicart).click(function(){
				var product_update = $('.mc-product', $minicart), array_id = [], array_qty = [];
				product_update.each(function(){
					var $this = $(this);
					var product_id = $('.product-id', $this).text();
					var	qty = $( $this.find('.mc-quantity')).val();
						array_id.push(product_id);
						array_qty.push(qty);
						if(qty==0){
							$this.addClass('mc-product-zero');
						}
				});
				
				$.ajax({
					type: 'POST',
					url : ajax_url,
					data: {
						minicart_ajax:1,
						tmpl: 'component',
						option: 'com_virtuemart',
						view: 'cart',
						minicart_task: 'update',
						cart_virtuemart_product_id: array_id, 
						quantity: array_qty 
					},
					success: function($json){
						if($json.status && $json.status==1){
							productsRefresh();
						}
					},
					dataType: 'json'
				});
			});
			
			/*
			 * Delete product
			 */
			var deleteProduct = function(){	
			var product_delete= $('.mc-product', $minicart);
				product_delete.each(function(){
					var $this = $(this);
					var product_id = $('.product-id', $this).text();
					$('.mc-remove', $this).click(function(){
						$this.addClass('mc-product-zero');	
						$.ajax({
							type: 'POST',
							url : ajax_url,
							data: {
								minicart_ajax:1,
								tmpl: 'component',
								option: 'com_virtuemart',
								view: 'cart',
								minicart_task: 'delete',
								cart_virtuemart_product_id: product_id // important
							},
							success: function($json){
								console.log($json);
								if($json.status && $json.status==1){
									productsRefresh();
								}
							},
							dataType: 'json'
						});
						});
					});
			}
			deleteProduct();
	});
	//]]>
	</script>