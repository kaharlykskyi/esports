$(document).ready(function () {

    $('.game' ).on('click',function(){
        $('.game' ).removeClass("actives");
        $(this).addClass("actives");
        $('.erroe-massage').hide();
    });

    $('.formbtn' ).on('click',function(event){
     	if (!$('input[type=radio]').filter(":checked").length) {
			event.preventDefault();
    		$('.erroe-massage').show();
    	} 
    }); 

});