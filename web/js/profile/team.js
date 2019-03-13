
$(document).ready(function(){
	$('.owl-carousel').owlCarousel({
	    center: true,
	    items:2,
	    loop:true,
	    margin:10,
	    autoplay:true,
	    autoplayTimeout:2000,
	    responsive:{
	        600:{
	            items:4
	        }
	    }
	});
});
