

if( (document.URL.substring(0,7).toLowerCase() == "http://" || document.URL.substring(0,8).toLowerCase() == "https://") && typeof(xcounter_duplicate) != "string" ) {

	var xuri;
	var xref;
	var xscr;
	var xjs;
	var xck;
	var xos;
	var xbrw;
	var xbrv;
	var xsrc;
	var op1;
	var op2;
	var xtime;
	var xvisit;
	var xcounter_duplicate = "_tmp";

	if( typeof(document) != "unknown") {
		xuri = document.URL.replace(document.location.protocol+'//'+document.location.host,'');
	}
	else {
		xuri = "none";
	}

	if( document.referrer == xuri) {
		xref = "";
	}
	else {
		xref = document.referrer;
		if( xref.indexOf("&") ) {
			xref = xref.replace(/&/g,":,:");
		}
	}

	if( typeof(window.screen) == "object" ) {
		xscr = window.screen.width + "*" + window.screen.height;	
	}
	else {
		xscr = "etc";
	}

	xjs = (navigator.javaEnabled()==true) ? "1":"0";
	xck = (navigator.cookieEnabled==true) ? "1":"0";

	if( (op1 = navigator.userAgent.toLowerCase().indexOf("msie")) > 0 ) {
		op2 = navigator.userAgent.indexOf(";",op1);
		xbrw = navigator.userAgent.substring(op1,op2);
	}
	else if( (op1 = navigator.userAgent.toLowerCase().indexOf("firefox")) > 0 ) {
		op2 = navigator.userAgent.indexOf(" ",op1);
		if( op2 == -1 ){
			xbrw = navigator.userAgent.substring(op1);
		}else{
			xbrw = navigator.userAgent.substring(op1,op2);
		}
	}
	else if( (op1 = navigator.userAgent.toLowerCase().indexOf("opera")) > -1 ) {
		op2 = navigator.userAgent.indexOf(" ",op1);
		if( op2 == -1 ){
			xbrw = navigator.userAgent.substring(op1);
		}else{
			xbrw = navigator.userAgent.substring(op1,op2);
		}
	}
	else if( navigator.userAgent && navigator.userAgent.length > 3 ) {
		xbrw = navigator.userAgent;
	}
	else {
		xbrw = "etc";
	}

	if( navigator.platform.substring(0,3).toLowerCase() == "win" ) {
		try{
			if( navigator.oscpu )
				xver = "tmp-" + navigator.oscpu;
			else
				xver = "tmp-" + navigator.appVersion;

		}catch(e){
			xver = "tmp-" + navigator.appVersion;
		}
		if( xver.indexOf("98") > 0) xos = "Windows 98";
		else if( xver.indexOf("Windows NT 5.0") > 0 ) xos = "Windows 2000";
		else if( xver.indexOf("Windows NT 5.1") > 0 ) xos = "Windows XP";
		else if( xver.indexOf("Windows NT 5.2") > 0 ) xos = "Windows 2003";
		else if( xver.indexOf("Windows NT 6.0") > 0 ) xos = "Windows Vista";
		else if( xver.indexOf("Windows NT 6.1") > 0 ) xos = "Windows 7";
		else if( xver.indexOf("Windows NT") > 0 ) xos = "Windows NT";
		else if( xver.indexOf("95") > 0 ) xos = "Windows 95";
		else if( xver.indexOf("Me") > 0 ) xos = "Windows Me";
		else if( xver.indexOf("5.0") > 0 ) xos = "Windows 2000";
		else xos = navigator.platform+" "+navigator.appVersion;
	}
	else if( navigator.platform == "MacIntel"){

		if( navigator.oscpu.indexOf("Mac OS X 10.5") > 0 ){		
		 xos = "Mac OS X Leopard";								
		}else if( navigator.oscpu.indexOf("Mac OS X 10.6") > 0 ){
		 xos = "Mac OS X Snow Leopard";					
		}else if( navigator.oscpu.indexOf("Mac OS X 10.7") > 0 ){
			xos = "Mac OS X Lion";					
		}else{
		 xos = "Mac OS X";
		}

				
	}
	else if( navigator.platform ) {
	
		xos = navigator.platform+" "+navigator.appVersion;
	}
	else {
		xos = "etc";
	}

	op1 = new Date();
	op2 = Math.round(op1.getTime()/1000);
	if( !(xtime = $.cookie("xtime")) ) {
		op1.setTime(op1.getTime() + (3600*24*367*1000));
		$.cookie("xtime", op2, {'expires':op1});
		xtime = 0;
	}
	else if( !isNaN(xtime) ) {
		xtime = op2 - xtime;
	}
	else {
		xtime = 0;
	}

	op1 = new Date();
	if( !(xvisit = $.cookie("xvisit")) ) {
		op1.setTime(op1.getTime() + (3600*12*1000));
		$.cookie("xvisit", "v", {'expires':op1});
		xvisit = "k";
	}
	else {
		xvisit = "v";
	}


	if( xvisit == "k" && $.cookie("xvisit") != "v" ) { xck = "0"; }
	
	xsrc ="/logs/counter/url=1";
	xsrc +="&page="+xuri+"&referral="+xref+"&screen="+xscr;
	xsrc +="&browser="+xbrw+"&os="+xos;
	xsrc +="&javascript="+xjs+"&cookie="+xck+"&xtime="+xtime+"&xvisit="+xvisit;

	if(1) {
		$('body').append($('<img>').attr({'src':xsrc,'height':0,'width':0,'border':0,'alt':''}));
	}
	else if(0) {
		var counterImg = new Image();
		counterImg.src = xsrc;
	}
}