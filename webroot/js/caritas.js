$(document).ready(function(){
	var utimeout = 20*60;
	
	var utimeout_interval = window.setInterval(change_interval, 1000);
	
	function change_interval() {
		utimeout--;
		
		min = parseInt( utimeout / 60 );
		if (min < 10) min = '0' + min;
		sec = utimeout - ( min * 60 );
		if (sec < 10) sec = '0' + sec;
		
		$('#user_timeout').html(min + ':' + sec );
		
		if (utimeout == 0) {
			clearInterval( utimeout_interval );
			location.href = '/atendentes/logout';
		}
		
	}	
	
});