// JavaScript Document

function CheckUIElements() {
	
		var yMenu1From, yMenu1To, yOffset, timeoutNextCheck;
		var wndWidth = parseInt(document.body.clientWidth);

		try{
			var divClient = document.getElementById("skyBtn");
		}catch(e){
			return;
		}

		yMenu1From   = parseInt (divClient.style.top, 10);
		yMenu1To     = document.documentElement.scrollTop + 250; // 위쪽 위치
		timeoutNextCheck = 500;

		if ( yMenu1From != yMenu1To ) {
			yOffset = Math.ceil( Math.abs( yMenu1To - yMenu1From ) / 20 );
			if ( yMenu1To < yMenu1From )
				yOffset = -yOffset;

				divClient.style.top = (parseInt (divClient.style.top, 10) + yOffset) +'px';

				timeoutNextCheck = 10;
			}
			
		setTimeout ("CheckUIElements()", timeoutNextCheck);
	}

	function fl_MenuPosition() {

		var wndWidth = parseInt(document.body.clientWidth);

		// 페이지 로딩시 포지션
		divClient.style.top = (document.body.scrollTop + 316) + 'px';
		divClient.style.left = parseInt(1000) + 'px';
		divClient.style.visibility = "visible";

		// initializing UI update timer
		CheckUIElements();

		return true;
	}

	setTimeout ("CheckUIElements()", 1500)