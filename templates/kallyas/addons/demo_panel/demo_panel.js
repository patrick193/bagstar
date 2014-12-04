(function($){ 
	$(document).ready(function(){
		var style = $('<style type="text/css" id="theme_color" />').appendTo('head');
		
		var $op = $('#options_panel'),
			$op_btn = $('#options_panel h3');
			
		$op_btn.click(function(){
			if($op.hasClass('opened')) {
				$op.removeClass('opened').animate({'left':'-'+180+'px', opacity:.7}, 500,'easeOutExpo');
				$(this).find('span').removeClass('icon-remove').addClass('icon-wrench');
				
			} else {
				$op.addClass('opened').animate({'left':0, opacity:1}, 500,'easeOutBounce');
				$(this).find('span').removeClass('icon-wrench').addClass('icon-remove');
			}
		});
		
		$('#header_style').change(function(){
			$('#header').attr('class','');
			$('#header').addClass('style'+$(this).val());
		});
		
		$('#theme_switcher').change(function(){
			if($(this).val() == 1)
				var style = $('<link rel="stylesheet" href="templates/kallyas/css/dark-theme.css" type="text/css" id="theme_style" />').appendTo('head');
			else if($(this).val() == 0)
				$('#theme_style').remove();
		});
		
		function changeColor(hex) {
			style.html(
				'a:hover, .info_pop .buyit, .m_title, .smallm_title, .circle_title, .feature_box .title , .services_box .title, .latest_posts.default-style .hoverBorder:hover h6, .latest_posts.style2 ul.posts .title, .latest_posts.style3 ul.posts .title, .recentwork_carousel li .details h4, .acc-group.default-style > button, .acc-group.style3 > button:after, .acc-group.style3 > button:hover, .acc-group.style3 > button:hover:after, .screenshot-box .left-side h3.title, .vertical_tabs.tabbable .nav>li>a:hover, .vertical_tabs.tabbable .nav>li.active>a, .vertical_tabs.tabbable .nav>li.active>a>span, .vertical_tabs.tabbable .nav>li>a:hover>span, .statbox h4, .services_box.style2 .box .list li, body.component.transparent a, .shop.tabbable .nav li.active a, .product-list-item:hover .prod-details h3, .product-page .mainprice .PricesalesPrice > span, .cart_details .checkout, .vmCartModule .carttotal .total, .oldie .latest_posts.default-style .hoverBorder:hover h6 {color:' + hex + ';}'+
				'.acc-group.style3 > button:hover, .acc-group.style3 > button:hover:after { color:' + hex + ' !important;}'+
				'header.style1, header.style2 #logo a, header.style2 a#logo, header.style3 #logo a, header.style3 a#logo, .tabs_style1 > ul.nav > li.active > a {border-top: 3px solid ' + hex + ';}'+
				'nav#main_menu > ul > li.active > a, nav#main_menu > ul > li > a:hover, nav#main_menu > ul > li:hover > a, .social-icons li a:hover, .how_to_shop .number, .action_box, .imgboxes_style1 .hoverBorder h6, .imgboxes_style1 .hoverborder h6, .feature_box.style3 .box:hover, .services_box .box:hover .icon, .latest_posts.default-style .hoverBorder h6, .recentwork_carousel li .details > .bg, .recentwork_carousel.style2 li a .details .plus, .gobox.ok, .hover-box:hover, .circlehover, .circlehover:before, .newsletter-signup input[type=submit], #mainbody .sidebar ul.menu li.active a, #mainbody .sidebar ul.menu li a:hover, #map_controls, .hg-portfolio-sortable #portfolio-nav li a:hover, .hg-portfolio-sortable #portfolio-nav li.current a, .ptcarousel .controls > a:hover, .itemLinks span a:hover, .product-list-item .prod-details .actions a, .product-list-item .prod-details .actions input.addtocart-button, .product-list-item .prod-details .actions input.addtocart-button-disabled, .shop-features .shop-feature:hover, .btn-flat, a.btn.redbtn, .ca-more, ul.links li a, .title_circle , .title_circle:before, .br-next:hover, .br-previous:hover, .flex-direction-nav li a:hover, .iosSlider .item .caption.style1 .more:before, .iosSlider .item .caption.style1 .more:after, .iosSlider .item .caption.style2 .more, .nivo-directionNav a:hover, .portfolio_devices .more_details , #wowslider-container a.ws_next:hover, #wowslider-container a.ws_prev:hover {background-color:' + hex + ';}'+
				'.action_box, .process_steps .step.intro {background-color:' + hex + ' !important;}'+
				'.action_box:before {border-top-color:' + hex + ';}'+
				'.process_steps .step.intro:after {border-left-color:' + hex + '; }'+
				'.theHoverBorder:hover {-webkit-box-shadow:0 0 0 5px ' + hex + ' inset; -moz-box-shadow:0 0 0 5px ' + hex + ' inset; box-shadow:0 0 0 5px ' + hex + ' inset;}'+
				'.offline-page .containerbox {border-bottom:5px solid ' + hex + '; }'+
				'.offline-page .containerbox:after {border-top: 20px solid ' + hex + ';}'+
				'.breadcrumbs li:after { border-left-color:'+hex+'; }'+
				'.iosSlider .item .caption.style2 .title_small, .nivo-caption, #wowslider-container .ws-title, .flex-caption {border-left: 5px solid ' + hex + '; }'+
				'.iosSlider .item .caption.style2.fromright .title_big, .iosSlider .item .caption.style2.fromright .title_small {border-right: 5px solid ' + hex + '; }');
		}
		
		// Attach callbacks
		$('.color-picker').miniColors({
			change: function(hex, rgba) {
				changeColor(hex);
			}
		});

		$('#options_panel .color_suggestions li').click(function(){
			var hex = $(this).css('background-color');
			changeColor(hex);
		});
		
	});
})(jQuery);