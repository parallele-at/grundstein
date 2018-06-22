<?php
require_once get_template_directory() . '/lib/plugin-activation/class-magic-plugin-activation.php';

add_action( 'tgmpa_register', 'magic_gs_register_required_plugins' );

function magic_gs_register_required_plugins() {

	$plugins = array(
		array(
			'name'               => 'Magic Appointments', // The plugin name.
			'slug'               => 'magic-appointments', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/lib/plugins/magic-appointments.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '0.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Timber',
			'slug'      => 'timber-library',
			'required'  => true,
		),

		array(
			'name'      => 'Advanced Custom Fields',
			'slug'      => 'advanced-custom-fields',
			'required'  => true,
		),

		array(
			'name'      => 'Advanced Custom Fields: Date and Time Picker',
			'slug'      => 'acf-field-date-time-picker',
			'required'  => true,
		),
	);

	$config = array(
		'id'           => 'magic-grundstein',      // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'magic-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                   // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
