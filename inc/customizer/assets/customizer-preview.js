jQuery(document).ready(function ($) {

	// live style update
	var aperitto_style = $('#aperitto-customizer-css'),
	 	aperitto_custom_style = $('#aperitto-custom-css');

	window.aperitto_style = aperitto_style;
	window.aperitto_custom_style = aperitto_custom_style;


	if ( !$(aperitto_style).length ) {
		aperitto_style = $('head')
			.append('<style type="text/css" id="aperitto-customizer-css">')
			.find('#aperitto-customizer-css');
	}

	if ( !$(aperitto_custom_style).length ) {
		aperitto_custom_style = $('head')
			.append('<style type="text/css" id="aperitto-custom-css">')
			.find('#aperitto-custom-css');
	}


	/*----------  H E A D E R  ----------*/

	var $logo = $('#logo'),
		$description = $('.sitedescription');

	// title position
	wp.customize( 'display_logo_and_title', function (value) {
		value.bind(function (to) {

			if ( '' == wp.customize.instance('custom_logo').get() ){
				return false;
			}

			var $custom_logo = $('.custom-logo'),
				classes = 'custom-logo-left custom-logo-right custom-logo-top custom-logo-bottom';

			$custom_logo.removeClass(classes);

			if ( 'image' == to ){
				$custom_logo.prependTo(".logo");
				$('#logo').hide();
			} else {

				$('#logo').show();
				$custom_logo.addClass( 'custom-logo-' + to );

				if ( 'bottom' == to ) {
					$custom_logo.appendTo("#logo");
				} else {
					$custom_logo.prependTo("#logo");
				}
			}

		});
	});



	// site title
	wp.customize( 'blogname', function (value) {
		value.bind(function (to) {
			$logo.attr('title', to).html(to);
		});
	});


	// site title COLOR
	wp.customize( 'header_textcolor', function (value) {
		value.bind(function (to) {
			//$logo.css('title', to).html(to);
			aperitto_update_style( '#logo{color:', to, '}' );
		});
	});


	// title position
	wp.customize( optname+'[title_position]', function (value) {
		value.bind(function (to) {
			var $sitetitle = $('.sitetitle');
			$sitetitle.removeClass('left center right');
			$sitetitle.addClass(to);
		});
	});

	// site descripton
	wp.customize( 'blogdescription', function (value) {
		value.bind(function (to) {
			if (!$description.length) {
				$logo.append('<p class="sitedescription"></p>');
			}
			$description.html(to);
		});
	});


	// hide/show descripton
	if ( ! wp.customize.instance(optname + '[showsitedesc]').get() ) {
		$description.hide();
	}
	wp.customize( optname + '[showsitedesc]', function (value) {
		value.bind(function (to) {
			if (!$description.length) {
				$logo.append('<p class="sitedescription"></p>');
			}
			false === to
				? $description.hide()
				: $description.show();
		});
	});


	// fit header height as background image
	wp.customize( optname+'[fix_header_height]', function (value) {
		value.bind(function (to) {
			if ( false === to ) {
				aperitto_update_style( '@media screen and (min-width:1024px){.header-top-wrap{min-height:', 'auto', '}}' );
			} else {
				var h = wp.customize._value.header_image_data().height;
				aperitto_update_style( '@media screen and (min-width:1024px){.header-top-wrap{min-height:', h + 'px', '}}' );
			}
		});
	});

	// main color change
	wp.customize( optname + '[maincolor]', function (value) {
		value.bind(function (to) {
			console.log( to );
			aperitto_update_style( 'a#logo{color:', to, '}' );
			aperitto_update_style( 'a:hover,#logo,.bx-controls a:hover .fa{color:', to, '}' );
			aperitto_update_style( 'a:hover{color:', to, '}' );
			aperitto_update_style( 'blockquote,q,input:focus,textarea:focus,select:focus{border-color:', to, '}' );
			aperitto_update_style( 'input[type=submit],input[type=button],button,.submit,.button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,#mobile-menu,.top-menu,.top-menu .sub-menu,.top-menu .children,.more-link,.nav-links a:hover,.nav-links .current,#footer{background-color:', to, '}' );
			aperitto_update_style( '@media screen and (max-width:1023px){.topnav{background-color:', to, '}}' );
		});
	});

	// show_mobile_thumb
	wp.customize( 'show_mobile_thumb', function (value) {
		value.bind(function (to) {
			var $images = $('.post .anons-thumbnail');
			false === to
				? $images.removeClass('show')
				: $images.addClass('show');
		});
	});

	// show_sidebar
	var $sidebar = $('#sidebar');
	wp.customize( optname + '[show_sidebar]', function (value) {
		value.bind(function (to) {
			false === to
				? $sidebar.removeClass('block')
				: $sidebar.addClass('block');
		});
	});

	// layout_home
	wp.customize( optname + '[layout_home]', function (value) {
		value.bind(function (to) {
			$('body').removeClass('layout-rightbar layout-leftbar layout-full layout-center')
				.addClass( 'layout-' + to );
		});
	});

	// layout_post
	wp.customize( optname + '[layout_post]', function (value) {
		value.bind(function (to) {
			$('body').removeClass('layout-rightbar layout-leftbar layout-full layout-center')
				.addClass( 'layout-' + to );
		});
	});

	// layout_page
	wp.customize( optname + '[layout_page]', function (value) {
		value.bind(function (to) {
			$('body').removeClass('layout-rightbar layout-leftbar layout-full layout-center')
				.addClass( 'layout-' + to );
		});
	});

	// layout_default
	wp.customize( optname + '[layout_default]', function (value) {
		value.bind(function (to) {
			// console.log(to);
			$('body').removeClass('layout-rightbar layout-leftbar layout-full layout-center')
				.addClass( 'layout-' + to );
		});
	});


	// layout_shop
	wp.customize( 'layout_shop', function (value) {
		value.bind(function (to) {
			// console.log(to);
			$('body.woocommerce.post-type-archive-product').removeClass('layout-rightbar layout-leftbar layout-full layout-center')
				.addClass( 'layout-' + to );
		});
	});

	// layout_product
	wp.customize( 'layout_product', function (value) {
		value.bind(function (to) {
			$('body.woocommerce.single-product').removeClass('layout-rightbar layout-leftbar layout-full layout-center')
				.addClass( 'layout-' + to );
		});
	});

	// layout_product_cat
	wp.customize( 'layout_product_cat', function (value) {
		value.bind(function (to) {
			$('body.woocommerce.tax-product_cat').removeClass('layout-rightbar layout-leftbar layout-full layout-center')
				.addClass( 'layout-' + to );
		});
	});


	// layout_page
	wp.customize( 'layout_search', function (value) {
		value.bind(function (to) {
			$('body.search').removeClass('layout-rightbar layout-leftbar layout-full layout-center')
				.addClass( 'layout-' + to );
		});
	});

	// postmeta_list
	wp.customize( 'postmeta_list', function (value) {
		value.bind(function (to) {
			$('.meta').find('span').addClass('hide');

			var arr = to.split('_');
			arr.forEach(function( item, i, arr ) {
				$('.meta').find( '.'+item ).removeClass('hide');
			});
		});
	});

	// copyright_year
	wp.customize( optname + '[copyright_year]', function (value) {
        value.bind(function (to) {
			console.log(to);
			var $copyright_year = $('.copyrights .copyright-year');
			false === to
				? $copyright_year.addClass('hide')
				: $copyright_year.removeClass('hide');
        });
    });

	// powered_by
	wp.customize( optname + '[powered_by]', function (value) {
        value.bind(function (to) {
			console.log(to);
			var $powered_by = $('.copyrights #designedby');
			false === to
				? $powered_by.addClass('hide')
				: $powered_by.removeClass('hide');
        });
    });

	// copyright_text
	wp.customize( optname + '[copyright_text]', function (value) {
		value.bind(function (to) {
			$('.copyright-text').text( to );
		});
	});



	// -----------------------------------------------------------------------
	function aperitto_update_style( before, new_value, after ){
		var style_now = $( window.aperitto_style ).text();
		var pos = style_now.search( before );
		if ( pos == -1 )
			$(window.aperitto_style).append( before + new_value + after );
		else{
			var before_reg = before,
				after_reg = after;
			before_reg.replace('}', '\}')
				.replace('@', '\@')
				.replace('.', '\.')
				.replace('(', '\(')
				.replace(')', '\)')
				.replace('>', '\>');
			after_reg.replace('}', '\}')
				.replace('@', '\@')
				.replace('.', '\.')
				.replace('(', '\(')
				.replace(')', '\)');
			var reg_str = new RegExp( before_reg + '(.*?)' + after_reg );
			$( window.aperitto_style ).text( style_now.replace( reg_str, before + new_value + after ) );

		}
	}
	window.aperitto_update_style = aperitto_update_style;

	// -----------------------------------------------------------------------

});
