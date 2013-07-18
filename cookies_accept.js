
function InfoCC(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function InfoRC(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

window.onload = InfoChC;

function InfoChC() {
    if(InfoRC('cookies_acceptHH') != 'C') {
        var message_container = document.createElement('div');
        message_container.id = 'cookies-m-c';
        var html_code = '<div id="cookies-m" style="padding: 10px 0px; line-height: 20px; border-bottom: 1px solid #aaaaaa; text-align: left; position: fixed; top: 0px; background-color: #eeeeee; width: 100%; z-index: 999;"><table border=0 cleepading=0 cellspacing=0><tr><td width=10%> </td><td><div style="font-size: 15px;  ">Ta strona używa ciasteczek (cookie), dzięki którym nasz serwis może działać lepiej.<br> Korzystając z tej strony wyrażasz zgodę na używanie ciasteczek w twoim urządzeniu zgodnie z ustawieniami przeglądarki. <br>Jeżeli nie wyrażasz zgody usuń lub wyłącz ciasteczka zgodnie z instrukcją: <a href="http://rattanland.pl/info_pages.php?pages_id=4" target="_self"><b>Dowiedz się więcej</b></a></div></td><td><a href="javascript:InfoCW();" id="accept-c-button" name="accept-cookies" style="background-color: #D97B09; padding: 5px 10px; color: #ffffff; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; display: inline-block; margin-left: 10px; text-decoration: none; cursor: pointer;">Zgadzam się!</a></td></tr></table></div>';
        message_container.innerHTML = html_code;
        document.body.appendChild(message_container);
    }
}

function InfoCW() {
    InfoCC('cookies_acceptHH', 'C', 60);
    document.getElementById('cookies-m-c').removeChild(document.getElementById('cookies-m'));
}