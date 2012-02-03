document.observe('dom:loaded',function(){
	$$('.miniCal').each(function(elm){
		var d = new Date();
		if(window.location.hash && window.location.hash.toString().match(/#_\d{4}-\d+/)){
			var h = window.location.hash.split(/[#\-_]/).without('');
			var y = parseInt(h[0],10);
			var m = parseInt(h[1],10);
		}else{
			var y = d.getFullYear();
			var m = parseInt(d.getMonth()) + 1;
		}
		elm.writeAttribute('data-year',y).writeAttribute('data-month',m);
		new Ajax.Updater(elm,'lib/cal.php',{
			parameters:{
				month:m, 
				year:y
			},
			onComplete: function(){
				if(y == d.getFullYear() && m == (parseInt(d.getMonth()) + 1)){
					elm.select('td').select(function(el){ return el.innerHTML.stripTags() == d.getDate(); }).invoke('addClassName','today');
				}
			}
		});
	});
	document.observe('mouseover',function(evt){
		var elm;
		if(elm = evt.findElement('a[href="multiple-links"]')){
			$$('.tooltip').invoke('remove');
			var options = decodeURIComponent(elm.rel).evalJSON();
			var links = '';
			var item = new Template('<li><a href="#{link}" title="#{title}">#{title}</a></li>');
			options.each(function(opt){
				links += item.evaluate({link:opt[0],title:opt[1]});
			});
			var tip = new Template('<div class="tooltip"><ul>#{list}</ul></div>');
			elm.up('div').insert(tip.evaluate({list:links}));
			var tt = elm.up('div').down('.tooltip');
			tt.setStyle('left:-' + Math.round(-4 + (tt.getWidth() - elm.up('td').getWidth()) / 2) + 'px');
			tt.observe('mouseout',function(evt){ 
				if(evt.relatedTarget && evt.relatedTarget != tt && ! evt.relatedTarget.ancestors().include(tt)) {
					tt.stopObserving(); 
					tt.remove();
				}
			});
		}
	});
	document.observe('click', function(evt){
		var elm;
		$$('.tooltip').invoke('remove');
		if(evt.findElement('a[href="multiple-links"]')) evt.stop();
		if(elm = evt.findElement('th.previous, th.next')){
			var box = evt.element().up('div.miniCal');
			var m = parseInt(box.readAttribute('data-month'),10);
			var y = parseInt(box.readAttribute('data-year'),10);
			if(evt.findElement('th.previous')){
				if(m > 1){
					m = m -1;
				}else{
					m = 12;
					y = y - 1;
				}
			}else if(evt.findElement('th.next')){
				if(m < 12){
					m = m + 1;
				}else{
					m = 1;
					y = y + 1;
				}
			}
			box.writeAttribute('data-month',m);
			box.writeAttribute('data-year',y);
			new Ajax.Updater(box,'lib/cal.php',{
				parameters:{
					month:m, 
					year:y
				},
				onComplete: function(){
					var d = new Date();
					if(y == d.getFullYear() && m == (parseInt(d.getMonth()) + 1)){
						box.select('td').select(function(el){ return el.innerHTML.stripTags() == d.getDate(); }).invoke('addClassName','today');
					}
				}
			});
		}
		if(elm = evt.findElement('a[href*="#"]')){
			$$('.miniCal').each(function(cal){
				var d = new Date();
				if(elm.href.toString().match(/#_\d{4}-\d+/)){
					var h = elm.href.split('#').last().split(/[\-_]/).without('');
					var y = parseInt(h[0],10);
					var m = parseInt(h[1],10);
				}else{
					var y = d.getFullYear();
					var m = parseInt(d.getMonth()) + 1;
				}
				cal.writeAttribute('data-year',y).writeAttribute('data-month',m);
				new Ajax.Updater(cal,'lib/cal.php',{
					parameters:{
						month:m, 
						year:y
					},
					onComplete: function(){
						if(y == d.getFullYear() && m == (parseInt(d.getMonth()) + 1)){
							cal.select('td').select(function(el){ return el.innerHTML.stripTags() == d.getDate(); }).invoke('addClassName','today');
						}
					}
				});
			});
		}
	});
});
