window.addEvent('domready', function(){
	var hash=window.location.hash;
	if(hash!='') hash=hash.substr(1);
	//new Ajax (url,{
	new Request.HTML ({
		url: url,
		method: 'get',
		data: hash,
		evalScripts:true,
		update: $('clayout')
	}).send();
	
	$$('.ui-main-nav').addEvent('click',function(){
		var param=this.getAttribute('data-url'),
			status=$('cstatus');
		window.location.hash=param;
		//new Ajax (url,{
		new Request.HTML ({
			url: url,
			method:'get',
			data: param,
			evalScripts:true,
			onRequest: function(){
				status.removeClass('hid');
			},
			onComplete: function(){
				status.addClass('hid');
			},
			update: $('clayout')
		}).send();
	});
	
	$('hideTop').addEvent('click',function(){
		var body=$$('body')[0],
			top=this.getTop() - body.getStyle('margin-top').toInt() - 5;
		if (body.hasClass('top-hidden')) {
			body.setStyle('margin-top', 0);
		} else {
			body.setStyle('margin-top', - top);
		}
		body.toggleClass('top-hidden');
	});
	
});

var popMenuHandler=new Class({
	initialize:function(){
		this.boundHandler=this.menuAutoRemove.bind(this);
		this.clickedButton=null;
		this.activeButton=null;
		this.menuType=null;
		
	},
	// @param type: for diff types of buttons: 1,2--Glass btn, 3,4--Plain btn. 1,3--position menu relative to right corner, 2,4--left
	showmenu:function(btn,type,event){
		//this.stopEventPropagation(event);
		stopEventPropagation(event);
		this.clickedButton=btn;
		this.menuType=type;
		
		if (this.activeButton==this.clickedButton) {
			//console.log('same button');
			this.removemenu();
			document.removeEvent('click',this.boundHandler);
		} else if (this.activeButton) {
			//console.log('change button');
			this.removemenu();
			this.drawmenu();
			this.activeButton=this.clickedButton;
		} else {
			//console.log('create event to remove', this.clickedButton);
			this.activeButton=this.clickedButton;
			this.drawmenu();
			document.addEvent('click',this.boundHandler);
		}
	},
	drawmenu:function(){
		var menu=$(this.clickedButton.getAttribute('data'));
		if(this.menuType==1 || this.menuType==2){$(this.clickedButton).addClass('glass-btn-active');}
		else if(this.menuType==3 || this.menuType==4){$(this.clickedButton).addClass('prodparam-btn-active');}
		else{$(this.clickedButton).addClass('tabletop-btn-active');}
		menu.removeClass('hid');
		var butpos=$(this.clickedButton).getPosition();
		var butsize=$(this.clickedButton).getSize();
		var winsize=menu.getSize();
		
		if(this.menuType==1){
			var left=butpos.x+butsize.x-winsize.x;
		}else if(this.menuType==3){
			var left=butpos.x+butsize.x/2-winsize.x/2;
			if(left<0) left=10;
		}else{
			var left=butpos.x;
		}
		if(this.menuType==5){
			var top=butpos.y+butsize.y-1;
		}else{
			var top=butpos.y+butsize.y+1;
		}
		
		menu.setStyles({top:top,left:left});
	},
	removemenu:function(){
		$(this.activeButton.getAttribute('data')).addClass('hid');
		if($(this.activeButton).hasClass('glass-btn')){$(this.activeButton).removeClass('glass-btn-active');}
		else if($(this.activeButton).hasClass('prodparam-btn')){$(this.activeButton).removeClass('prodparam-btn-active');}
		else if($(this.activeButton).hasClass('ui-tabletop-btn')){$(this.activeButton).removeClass('tabletop-btn-active');}
		this.activeButton=null;
	},
	removeBoundEvent:function(){
		document.removeEvent('click',this.boundHandler);
	},
	menuAutoRemove:function(event){
		var menu=$(this.activeButton.getAttribute('data'));
		var left=menu.offsetLeft;
		var top=menu.offsetTop;
		var bottom=top+menu.offsetHeight-1;
		var right=left+menu.offsetWidth-1;
		var clickedonmenu=false;
		var marginX=event.page.x || event.x;
		var marginY=event.page.y || event.y;
		if(marginX>=left && marginX<=right && marginY>=top && marginY<=bottom) clickedonmenu=true;
		
		//console.log(event, marginX, marginY, left, right, top, bottom, menu);
		//if(clickedonmenu) console.log('On menu');
		
		if(!clickedonmenu){
			this.removemenu();
			document.removeEvent('click',this.boundHandler);
		}
	}
});

function stopEventPropagation(e){
	var event = e || window.event;
	//if(!event.cancelBubble){
	if(event.cancelBubble){
		event.cancelBubble=true;
		return;
	}
	event.stopPropagation();
}

function squeeze(str,maxlength){
	var len=str.length;
	var dots='<b class="threedots">..</b>';
	return (len<=maxlength)? str : (str.substr(0,maxlength)+dots); 
}

var simplePopup=new popMenuHandler();
var activeParamButton=null;

// LTrim(string) : Returns a copy of a string without leading spaces.
// borrowed from J1.5
function ltrim(str) {
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(0)) != -1) {
      var j=0, i = s.length;
      while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
         j++;
      s = s.substring(j, i);
   }
   return s;
}

//RTrim(string) : Returns a copy of a string without trailing spaces.
function rtrim(str) {
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
      var i = s.length - 1;       // Get length of string
      while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
         i--;
      s = s.substring(0, i+1);
   }
   return s;
}

function trim(str) {
   return rtrim(ltrim(str));
}