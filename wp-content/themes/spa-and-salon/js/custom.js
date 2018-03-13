jQuery(document).ready(function($){	
// The slider being synced must be initialized first
	$('#carousel').flexslider({
		    animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    itemWidth: 160,
		    itemMargin: 40,
		    asNavFor: '#slider'
		}); 
	$('#slider').flexslider({
		    animation: "fade",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    sync: "#carousel"
	  	});


	$('header nav').meanmenu({
	    meanScreenWidth: "991",
	    meanRevealPosition: "center"
	});

	/* Equal Height */
    $('.promotional-block .col .text-holder').matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });

    /* Custom Scroll Bar */
    $(".promotional-block .col .text-holder").mCustomScrollbar({
     theme:"minimal"
    });

    $(".testimonial #slider .holder .text-holder .holder").mCustomScrollbar({
     theme:"minimal"
    });
});

		