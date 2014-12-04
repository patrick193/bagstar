/*
Title:   Main JS Scripts file dedicated to this template
Author:  http://themeforest.net/user/hogash // Marius Hogas
*/

;(function($){
	
	if(hasChaser == 1) {
		$(window).load(function(){
			var doc = $(document), 
				win = $(window), chaser, forch,
				forchBottom, visible;
			function shown() { visible = true; }
			function hidden() { visible = false; }
			chaser = $('#main_menu ul.sf-menu').clone().hide()
				.appendTo(document.body)
				.wrap("<div class='chaser'><div class='container'><div class='row'><div class='span12'></div></div></div></div>");
			forch = $('#content').first();
			forchBottom = forch.offset().top + 2;
			hidden();
			win.on('scroll', function () {
				var top = doc.scrollTop();
				if (!visible && top > forchBottom) {
					//chaser.slideDown(300, shown);
					chaser.fadeIn(300, shown);
				} else if (visible && top < forchBottom) {
					//chaser.slideUp(200, hidden);
					chaser.fadeOut(200, hidden);
				}
			});
			/* Activate Superfish Menu for Chaser */
			$('.chaser ul.sf-menu').supersubs({ minWidth: 12, maxWidth: 27, extraWidth: 1}).superfish({delay:250, dropShadows:false, autoArrows:true, speed:300});
		});
	}

	$(document).ready(function(e) {
		
		// activate placeholders for older browsers
        $('input, textarea').placeholder();

		// --- search panel
		var searchBtn = $('#search').children('.searchBtn'),
			searchPanel = searchBtn.next(),
			searchP = searchBtn.parent();
		searchBtn.click(function(e){
			e.preventDefault();
			var _t = $(this);
			if(!_t.hasClass('active')) {
				_t.addClass('active')
				.find('span')
				.removeClass('icon-search icon-white')
				.addClass('icon-remove');
				searchPanel.show();
			} else {
				_t.removeClass('active')
				.find('span')
				.addClass('icon-search icon-white')
				.removeClass('icon-remove');
				searchPanel.hide();
			}
		}); // searchBtn.click //
		$(document).click(function(){
			searchBtn.removeClass('active')
				.find('span')
				.addClass('icon-search icon-white')
				.removeClass('icon-remove');
			searchPanel.hide(0);
		});
		searchP.click(function(event){
			event.stopPropagation();
		});
		// --- end search panel

		/* sliding panel toggle (support panel) */
		var sliding_panel = $('#sliding_panel');
		$('#open_sliding_panel').toggle(function(e){
			e.preventDefault();
			sliding_panel.animate({  height:130 }, {duration:100, queue:false, easing:'easeOutQuint'});
			$(this).addClass('active');
		}, function(){
			sliding_panel.animate({  height:0 }, {duration:100, queue:false, easing:'easeOutQuint'});
			$(this).removeClass('active');
		});
		// --- end sliding panel
		
		/* scroll to top */
        function totop_button(a) {
            var b = $("#totop");
            b.removeClass("off on");
            if (a == "on") { b.addClass("on") } else { b.addClass("off") }
        }
        window.setInterval(function () {
            var b = $(this).scrollTop();
            var c = $(this).height();
            if (b > 0) { var d = b + c / 2 } else { var d = 1 }
            if (d < 1e3) { totop_button("off") } else { totop_button("on") }
        }, 300);
		
        $("#totop").click(function (e) {
            e.preventDefault();
            $('body,html').animate({scrollTop:0},800, 'easeOutExpo');
        });
		// --- end scroll to top
		
		// activate tooltips
		$('*[data-rel="tooltip"], *[rel="tooltip"]').tooltip();
		
		//activate collapsible accordions
		$(".collapse").collapse();

		
	});	// doc.ready end //
	
	$(window).load(function(){
		
		var pageLoading = $("#page-loading");
		if(pageLoading.length > 0){
			setTimeout(function() {
				pageLoading.fadeOut();
			}, 1000);
		}
		
		$('.hoverBorder, .hoverborder').each(function(index, element) {
            $(this).find('img').wrap('<span class="hoverBorderWrapper"/>').after('<span class="theHoverBorder"></span>');
        });
		
		// hover effect
		$('.hover_effect').each(function(){
			var hoverLink = $(this),
				hoverLinkImg = hoverLink.find('img'),
				hoverLinkTitle = hoverLink.attr('title');
			hoverLink.css({'width':hoverLinkImg.width(), 'height':hoverLinkImg.height()}).append("<span class=\"title\">"+hoverLinkTitle+"</span>");
		});
		
		//hoverlink
		$("a.hoverLink").each(function(index, element) {
            var $t = $(this),
				dtype = $t.data('type'),
				img = $t.find('img'),
				sp = 'fast',
				app = '<span class="icon_wrap"><span class="icon '+dtype+'"></span></span>';
			$t.append(app);
			
			$t.hover(function(){
				img.animate({'opacity': 0.5}, sp);
				$t.find('.icon_wrap').animate({'opacity': 1}, sp);
			}, function(){
				img.animate({'opacity': 1}, sp);
				$t.find('.icon_wrap').animate({'opacity': 0}, sp);
			});
        });
		
	});
	
})(jQuery);

var sP = jQuery.noConflict(),
	sparkles_container = sP(document.getElementById("sparkles"));
var Spark=function(){var a=this;this.b=template_path+"/images/sparkles/";this.s=["spark.png","spark2.png","spark3.png","spark4.png","spark5.png","spark6.png"];this.i=this.s[this.random(this.s.length)];this.f=this.b+this.i;this.n=document.createElement("img");this.newSpeed().newPoint().display().newPoint().fly()};Spark.prototype.display=function(){sP(this.n).attr("src",this.f).css("position","absolute").css("z-index",this.random(-3)).css("top",this.pointY).css("left",this.pointX);sparkles_container.append(this.n);return this};Spark.prototype.fly=function(){var a=this;sP(this.n).animate({top:this.pointY,left:this.pointX},this.speed,"linear",function(){a.newSpeed().newPoint().fly()})};Spark.prototype.newSpeed=function(){this.speed=(this.random(10)+5)*1100;return this};Spark.prototype.newPoint=function(){this.pointX=this.random(sparkles_container.width());this.pointY=this.random(sparkles_container.height());return this};Spark.prototype.random=function(a){return Math.ceil(Math.random()*a)-1};sP(function(){if(sP.browser.msie&&sP.browser.version<9){return}var a=40;var b=[];for(i=0;i<a;i++){b[i]=new Spark()}});
 
