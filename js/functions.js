jQuery(document).ready(function ($) {

	// toTop button
	$(window).scroll(function () {
		if ( $(this).scrollTop() !== 0 ) $('#toTop').fadeIn();
		else $('#toTop').fadeOut();
	});
	$('#toTop').click(function () {
		$('body,html').animate({scrollTop: 0}, 500);
	});

    $.fn.extend({
        toggleText: function(a, b){
            return this.text(this.text() == b ? a : b);
        }
    });

	// responsive menu
	var $window = $(window),
		$nav = $('.topnav nav'),
		$button = $('#mobile-menu');

	$button.on('click', function () {
		$nav.slideToggle();
        $button.toggleText("☰", "X");
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


    // Keyboard Arrow Navigation for Menu Items
	$('.top-menu li a').keydown(function(e){
        // Listen for the tab, esc, up, down, left and right arrow keys, otherwise, end here
        if ([9,27,37,38,39,40].indexOf(e.keyCode) == -1) {
            return;
        }
        var link = $(this);

        switch(e.keyCode) {
            case 37: // left arrow
                e.preventDefault();
                e.stopPropagation();
                // This is the first item in the top level mega menu list
                if(link.parent('li').prevAll('li').first().length == 0) {
                    // Focus on the last item in the top level
                    link.parent('li').nextAll('li').last().find('a').first().focus();
                } else {
                    // Focus on the previous item in the top level
                    link.parent('li').prevAll('li').first().find('a').first().focus();
                }
                break;
            case 38: /// up arrow
                // Find the nested element that acts as the menu
                var dropdown = link.closest('.sub-menu').parent('li');

                // If there is a UL available, place focus on the first focusable element within
                if(dropdown.length > 0){
                    e.preventDefault();
                    e.stopPropagation();
                    dropdown.find('a').first().focus();
                }

                // find and close mobile sub menus
                var mob_dropdown = link.next('.open-submenu');
                if(mob_dropdown.length > 0){
                    e.preventDefault();
                    e.stopPropagation();
                    mob_dropdown.parent().removeClass('submenu-opened');
                    mob_dropdown.siblings('.sub-menu').addClass('closed');
                }

                break;
            case 39: // right arrow
                e.preventDefault();
                e.stopPropagation();

                // This is the last item
                if(link.parent('li').nextAll('li').first().length == 0) {
                    // Focus on the first item in the top level
                    link.parent('li').prevAll('li').last().find('a').first().focus();
                } else {
                    // Focus on the next item in the top level
                    link.parent('li').nextAll('li').first().find('a').first().focus();
                }
                break;
            case 40: // down arrow
                // find and open mobile sub menus
                var mob_dropdown = link.next('.open-submenu');
                if(mob_dropdown.length > 0){
                    e.preventDefault();
                    e.stopPropagation();
                    mob_dropdown.parent().addClass('submenu-opened');
                    mob_dropdown.siblings('.sub-menu').removeClass('closed');
                }

                // Find the nested element that acts as the menu
                var dropdown = link.parent('li').find('ul li');

                // If there is a UL available, place focus on the first focusable element within
                if(dropdown.length > 0){
                    e.preventDefault();
                    e.stopPropagation();
                    dropdown.find('a').first().focus();
                }

                break;
            case 27: // esc
                var mob_menu = $('#mobile-menu');
                if ( mob_menu.length > 0 && $window.width() < 1024 ) {
                    e.preventDefault();
                    e.stopPropagation();
                    mob_menu.click();
                }
                break;
            case 9: // tab
                var mob_menu = $('#mobile-menu');
                if ( mob_menu.length > 0 && $window.width() < 1024 ) {
                    e.preventDefault();
                    e.stopPropagation();

                    if(e.shiftKey) {
                        // This is the first item in the top level mega menu list
                        if(link.parent('li').prevAll('li').first().length == 0) {
                            $('#mobile-menu').focus();
                        } else {
                            // Focus on the previous item in the top level
                            link.parent('li').prevAll('li').first().find('a').first().focus();
                        }
                    } else {
                        // This is the last item
                        if(link.parent('li').nextAll('li').first().length == 0) {
                            $('#mobile-menu').focus();
                        } else {
                        // Focus on the next item in the top level
                            link.parent('li').nextAll('li').first().find('a').first().focus();
                        }
                    }
                }
                break;
        }
    });

    $('#mobile-menu').keydown(function(e){
        var key = e.keyCode;
        // tab
        if ( key == 9 ) {
            e.preventDefault();
            e.stopPropagation();
            $('.topnav nav').slideDown();
            $('#mobile-menu').text("X");
            if(e.shiftKey) {
                $(this).next('nav').find('ul > li:last > a')[0].focus();
            } else {
                $(this).next('nav').find('ul > li > a')[0].focus();
            }
        }
        // enter, space, down
        if ( key == 13 || key == 32 || key == 40) {
            e.preventDefault();
            e.stopPropagation();
            $(this).click();
            $(this).next('nav').find('ul > li > a')[0].focus();
        }
    });


});

