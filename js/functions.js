jQuery(document).ready(function ($) {

// toTop button 
	$(window).scroll(function () {
		if ( $(this).scrollTop() !== 0 ) $('#toTop').fadeIn();
		else $('#toTop').fadeOut();
	});
	$('#toTop').click(function () {
		$('body,html').animate({scrollTop: 0}, 500);
	});


// responsive menu
	var $window = $(window),
		$nav = $('.topnav nav'),
		$button = $('#mobile-menu');

	$button.on('click', function () {
		$nav.slideToggle();
	});

	$window.on('resize', function () {
		if ($window.width() >= 1024) {
			$nav.show();
		}
	});

// mobile sub-menus
	var $sub_menus = $nav.find('.sub-menu');
	$nav.find('.open-submenu').on( 'click', function () {
		$(this).parent().toggleClass('submenu-opened');
		$(this).siblings('.sub-menu').toggleClass('closed');
	});
	set_sub_menu_classes( $window.width() );
	$window.on('resize', function () {
		set_sub_menu_classes( $window.width() );
	});
	function set_sub_menu_classes( w ){
		if ( w < 1024 ) {
			$sub_menus.addClass('closed');
		} else {
			$sub_menus.removeClass('closed');
			$nav.find('.submenu-opened').removeClass('submenu-opened');
		}
	}


// social buttons
	$('.psb').click(function () {
		window.open($(this).attr("href"), 'displayWindow', 'width=700,height=400,left=200,top=100,location=no, directories=no,status=no,toolbar=no,menubar=no');
		return false;
	});

});
