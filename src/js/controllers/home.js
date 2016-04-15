// SMOOTH SCROLLING EFFECT (not working properly with php routing)
/*$(document).ready(function() {

		$('.scrollTo').click( function() {
			var page = $(this).attr('href'); 
			var speed = 600; // Animation duration
			$('html, body').animate( { scrollTop: $(page).offset().top }, speed );
			return false;
		});
	});
*/

// SMOOTH SCROLLING EFFECT FIX
$(".shortcut-1").click(function(){
    $('html, body').animate({
        scrollTop: $(".clear-fix-one").offset().top
    }, 600);
});

$(".shortcut-2").click(function(){
    $('html, body').animate({
        scrollTop: $(".clear-fix-two").offset().top
    }, 600);
});

$(".shortcut-3").click(function(){
    $('html, body').animate({
        scrollTop: $(".clear-fix-three").offset().top
    }, 600);
});

$(".shortcut-4").click(function(){
    $('html, body').animate({
        scrollTop: $(".clear-fix-four").offset().top
    }, 600);
});

$(".bottom-button").click(function(){
    $('html, body').animate({
        scrollTop: $(".clear-fix-two").offset().top
    }, 600);
});