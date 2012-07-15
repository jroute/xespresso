sdtab={
	tabClass:'sdtab', 
	listClass:'sdtabs', 
	activeClass:'active', 
	contentElements:'div', 
	backToLinks:/#top/, 
	printID:'sdtabprintview', 
	showAllLinkText:'show all content', 
	prevNextIndicator:'doprevnext', 
	prevNextClass:'prevnext', 
	prevLabel:'previous', 
	nextLabel:'next', 
	prevClass:'prev', 
	nextClass:'next', 
	init:function(){
		var temp;
		if(!document.getElementById || !document.createTextNode){return;}
		var tempelm=document.getElementsByTagName('div');		
		for(var i=0;i<tempelm.length;i++){
			if(!sdtab.cssjs('check',tempelm[i],sdtab.tabClass)){continue;}
			sdtab.initTabMenu(tempelm[i]);
			sdtab.removeBackLinks(tempelm[i]);
			if(sdtab.cssjs('check',tempelm[i],sdtab.prevNextIndicator)){
				sdtab.addPrevNext(tempelm[i]);
			}
			sdtab.checkURL();
		}
		if(document.getElementById(sdtab.printID) 
		   && !document.getElementById(sdtab.printID).getElementsByTagName('a')[0]){
			var newlink=document.createElement('a');
			newlink.setAttribute('href','#');
			sdtab.addEvent(newlink,'click',sdtab.showAll,false);
			newlink.onclick=function(){return false;} // safari hack
			newlink.appendChild(document.createTextNode(sdtab.showAllLinkText));
			document.getElementById(sdtab.printID).appendChild(newlink);
		}
	},
	checkURL:function(){
		var id;
		var loc=window.location.toString();
		loc=/#/.test(loc)?loc.match(/#(\w.+)/)[1]:'';
		if(loc==''){return;}
		var elm=document.getElementById(loc);
		if(!elm){return;}
		var parentMenu=elm.parentNode.parentNode.parentNode;
		parentMenu.currentSection=loc;
		parentMenu.getElementsByTagName(sdtab.contentElements)[0].style.display='none';
		sdtab.cssjs('remove',parentMenu.getElementsByTagName('a')[0].parentNode,sdtab.activeClass);
		var links=parentMenu.getElementsByTagName('a');
		for(i=0;i<links.length;i++){
			if(!links[i].getAttribute('href')){continue;}
			if(!/#/.test(links[i].getAttribute('href').toString())){continue;}
			id=links[i].href.match(/#(\w.+)/)[1];
			if(id==loc){
				var cur=links[i].parentNode.parentNode;
				sdtab.cssjs('add',links[i].parentNode,sdtab.activeClass);
				break;
			}
		}
		sdtab.changeTab(elm,1);
		elm.focus();
		cur.currentLink=links[i];
		cur.currentSection=loc;
	},
	showAll:function(e){
		document.getElementById(sdtab.printID).parentNode.removeChild(document.getElementById(sdtab.printID));
		var tempelm=document.getElementsByTagName('div');		
		for(var i=0;i<tempelm.length;i++){
			if(!sdtab.cssjs('check',tempelm[i],sdtab.tabClass)){continue;}
			var sec=tempelm[i].getElementsByTagName(sdtab.contentElements);
			for(var j=0;j<sec.length;j++){
				sec[j].style.display='block';
			}
		}
		var tempelm=document.getElementsByTagName('ul');		
		for(i=0;i<tempelm.length;i++){
			if(!sdtab.cssjs('check',tempelm[i],sdtab.prevNextClass)){continue;}
			tempelm[i].parentNode.removeChild(tempelm[i]);
			i--;
		}
		sdtab.cancelClick(e);
	},
	addPrevNext:function(menu){
		var temp;
		var sections=menu.getElementsByTagName(sdtab.contentElements);
		for(var i=0;i<sections.length;i++){
			temp=sdtab.createPrevNext();
			if(i==0){
				temp.removeChild(temp.getElementsByTagName('li')[0]);
			}
			if(i==sections.length-1){
				temp.removeChild(temp.getElementsByTagName('li')[1]);
			}
			temp.i=i; // h4xx0r!
			temp.menu=menu;
			sections[i].appendChild(temp);
		}
	},
	removeBackLinks:function(menu){
		var links=menu.getElementsByTagName('a');
		for(var i=0;i<links.length;i++){
			if(!sdtab.backToLinks.test(links[i].href)){continue;}
			links[i].parentNode.removeChild(links[i]);
			i--;
		}
	},
	initTabMenu:function(menu){
		var id;
		var lists=menu.getElementsByTagName('ul');
		for(var i=0;i<lists.length;i++){
			if(sdtab.cssjs('check',lists[i],sdtab.listClass)){
				var thismenu=lists[i];
				break;
			}
		}
		if(!thismenu){return;}
		thismenu.currentSection='';
		thismenu.currentLink='';
		var links=thismenu.getElementsByTagName('a');
		for(i=0;i<links.length;i++){
			if(!/#/.test(links[i].getAttribute('href').toString())){continue;}
			id=links[i].href.match(/#(\w.+)/)[1];
			if(document.getElementById(id)){
				sdtab.addEvent(links[i],'click',sdtab.showTab,false);
				links[i].onclick=function(){return false;} // safari hack
				sdtab.changeTab(document.getElementById(id),0);
			}
		}
		id=links[0].href.match(/#(\w.+)/)[1];
		if(document.getElementById(id)){
			sdtab.changeTab(document.getElementById(id),1);
			thismenu.currentSection=id;
			thismenu.currentLink=links[0];
			sdtab.cssjs('add',links[0].parentNode,sdtab.activeClass);
		}
	},
	createPrevNext:function(){
		var temp=document.createElement('ul');
		temp.className=sdtab.prevNextClass;
		temp.appendChild(document.createElement('li'));
		temp.getElementsByTagName('li')[0].appendChild(document.createElement('a'));
		temp.getElementsByTagName('a')[0].setAttribute('href','#');
		temp.getElementsByTagName('a')[0].innerHTML=sdtab.prevLabel;
		temp.getElementsByTagName('li')[0].className=sdtab.prevClass;
		temp.appendChild(document.createElement('li'));
		temp.getElementsByTagName('li')[1].appendChild(document.createElement('a'));
		temp.getElementsByTagName('a')[1].setAttribute('href','#');
		temp.getElementsByTagName('a')[1].innerHTML=sdtab.nextLabel;
		temp.getElementsByTagName('li')[1].className=sdtab.nextClass;
		sdtab.addEvent(temp.getElementsByTagName('a')[0],'click',sdtab.navTabs,false);
		sdtab.addEvent(temp.getElementsByTagName('a')[1],'click',sdtab.navTabs,false);
		// safari fix
		temp.getElementsByTagName('a')[0].onclick=function(){return false;}
		temp.getElementsByTagName('a')[1].onclick=function(){return false;}
		return temp;
	},
	navTabs:function(e){
		var li=sdtab.getTarget(e);
		var menu=li.parentNode.parentNode.menu;
		var count=li.parentNode.parentNode.i;
		var section=menu.getElementsByTagName(sdtab.contentElements);
		var links=menu.getElementsByTagName('a');
		var othercount=(li.parentNode.className==sdtab.prevClass)?count-1:count+1;
		section[count].style.display='none';
		sdtab.cssjs('remove',links[count].parentNode,sdtab.activeClass);
		section[othercount].style.display='block';
		sdtab.cssjs('add',links[othercount].parentNode,sdtab.activeClass);
		var parent=links[count].parentNode.parentNode;
		parent.currentLink=links[othercount];
		parent.currentSection=links[othercount].href.match(/#(\w.+)/)[1];
		sdtab.cancelClick(e);
	},
	changeTab:function(elm,state){
		do{
			elm=elm.parentNode;
		} while(elm.nodeName.toLowerCase()!=sdtab.contentElements)
		elm.style.display=state==0?'none':'block';
	},
	showTab:function(e){
		var o=sdtab.getTarget(e);
		if(o.parentNode.parentNode.currentSection!=''){
			sdtab.changeTab(document.getElementById(o.parentNode.parentNode.currentSection),0);
			sdtab.cssjs('remove',o.parentNode.parentNode.currentLink.parentNode,sdtab.activeClass);
		}
		var id=o.href.match(/#(\w.+)/)[1];
		o.parentNode.parentNode.currentSection=id;
		o.parentNode.parentNode.currentLink=o;
		sdtab.cssjs('add',o.parentNode,sdtab.activeClass);
		sdtab.changeTab(document.getElementById(id),1);
		document.getElementById(id).focus();
		sdtab.cancelClick(e);
	},
/* helper methods */
	getTarget:function(e){
		var target = window.event ? window.event.srcElement : e ? e.target : null;
		if (!target){return false;}
		if (target.nodeName.toLowerCase() != 'a'){target = target.parentNode;}
		return target;
	},
	cancelClick:function(e){
		if (window.event){
			window.event.cancelBubble = true;
			window.event.returnValue = false;
			return;
		}
		if (e){
			e.stopPropagation();
			e.preventDefault();
		}
	},
	addEvent: function(elm, evType, fn, useCapture){
		if (elm.addEventListener) 
		{
			elm.addEventListener(evType, fn, useCapture);
			return true;
		} else if (elm.attachEvent) {
			var r = elm.attachEvent('on' + evType, fn);
			return r;
		} else {
			elm['on' + evType] = fn;
		}
	},
	cssjs:function(a,o,c1,c2){
		switch (a){
			case 'swap':
				o.className=!sdtab.cssjs('check',o,c1)?o.className.replace(c2,c1):o.className.replace(c1,c2);
			break;
			case 'add':
				if(!sdtab.cssjs('check',o,c1)){o.className+=o.className?' '+c1:c1;}
			break;
			case 'remove':
				var rep=o.className.match(' '+c1)?' '+c1:c1;
				o.className=o.className.replace(rep,'');
			break;
			case 'check':
				var found=false;
				var temparray=o.className.split(' ');
				for(var i=0;i<temparray.length;i++){
					if(temparray[i]==c1){found=true;}
				}
				return found;
			break;
		}
	}
}
sdtab.addEvent(window, 'load', sdtab.init, false);
	
