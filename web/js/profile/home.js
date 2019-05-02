$(document).ready(function () {
	    $('#tour-pj').on('pjax:success', function(e) {
			e.target.scrollIntoView();	    	
    	});
});