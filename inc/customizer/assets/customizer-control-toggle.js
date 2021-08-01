;(function () {
	/**
	 * Run function when customizer is ready.
	 */
	wp.customize.bind('ready', function () {
		wp.customize.control('home_h1_type_control', function (control) {
			/**
			 * Run function on setting change of control.
			 */
			control.setting.bind(function (value) {
				switch (value) {
					/**
					 * The select was switched to the hide option.
					 */
					case 'sitetitle':
						/**
						 * Deactivate the conditional control.
						 */
						wp.customize.control('custom_home_h1_control').deactivate();
						break;
					/**
					 * The select was switched to »show«.
					 */
					case 'customtitle':
						/**
						 * Activate the conditional control.
						 */
						wp.customize.control('custom_home_h1_control').activate();
						break;
				}
			});
		});
	});
})();