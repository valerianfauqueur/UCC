// SCROLLING EFFECT WITH JQUERY
$(document).ready(function() {

		$('.scrollTo').click( function() {
			var page = $(this).attr('href'); 
			var speed = 600; // Animation duration
			$('html, body').animate( { scrollTop: $(page).offset().top }, speed );
			return false;
		});
	});

// ZOOM EFFECT ON CLICK
$(".test").click(function(){
	$(this).toggleClass('zoom');
});