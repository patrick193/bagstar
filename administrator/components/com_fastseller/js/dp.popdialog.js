var filterAjax;
function filterSelectDialog(btn){
	var win=$('filter-dialog');
	var inner=$('filter-dialog-inner');
	win.removeClass('hid');
	win.setStyle('opacity',1);
	var blanket=$('blanket2');
	blanket.setStyles({top:0,left:0,height:inner.offsetHeight+7,width:'100%'});
	blanket.removeClass('hid');
	activeParamButton=btn;
	var paramname=btn.getAttribute('data-paramname');
	var btnvalue=btn.getAttribute('data-btnvalue');
	var row=btn.getAttribute('data-row');
	var form=document[row+'-form'];
	var pid=form['pid'].value;
	var ptid=form['thisptid'].value;
	var parameters='i=DP&a=UPF&pid='+pid+'&ptid='+ptid+'&paramname='+paramname+'&f='+btnvalue;
	
	if(highlightedProduct) highlightedProduct.removeClass('underlined');
	highlightedProduct=$$('#'+row+'-tr .ui-namecell-name');
	highlightedProduct.addClass('underlined');
	
	if(filterAjax) filterAjax.cancel();
	//filterAjax=new Ajax (url,{
	filterAjax=new Request.HTML({
		url: url,
		method:'get',
		data: parameters,
		evalScripts:true,
		onComplete: function(){
			blanket.addClass('hid');
			var left=(window.getSize().x-win.offsetWidth)/2;
			if(left<0)left=5;
			win.setStyles({'top':window.getScrollTop()+70, left:left});
		},
		update: inner
	}).send();
}
function ptSelectDialog(btn){
	var win=$('filter-dialog');
	var inner=$('filter-dialog-inner');
	win.removeClass('hid');
	win.setStyle('opacity',1);
	
	activeParamButton=btn;
	var row=btn.getAttribute('data-row');
	
	if(highlightedProduct) highlightedProduct.removeClass('underlined');
	highlightedProduct=$$('#'+row+'-tr .ui-namecell-name');
	highlightedProduct.addClass('underlined');
	
	if(!ptCache){
		var blanket=$('blanket2');
		blanket.setStyles({top:0,left:0,height:inner.offsetHeight+7,width:'100%'});
		blanket.removeClass('hid');
		var parameters='i=DP&a=UPPTD';
		
		if(filterAjax) filterAjax.cancel();
		//filterAjax=new Ajax (url,{
		filterAjax=new Request.HTML({
			url: url,
			method:'get',
			data: parameters,
			evalScripts:true,
			onComplete: function(response){
				ptCache=response;
				blanket.addClass('hid');
				var left=(window.getSize().x-win.offsetWidth)/2;
				if(left<0)left=5;
				win.setStyles({'top':window.getScrollTop()+70, left:left});
			},
			update: inner
		}).send();
	}else{
		inner.innerHTML=ptCache;
		var left=(window.getSize().x-win.offsetWidth)/2;
		if(left<0)left=5;
		win.setStyles({'top':window.getScrollTop()+70, left:left});
	}
}