<?php
/**
 * Customize API: Magic_Customize_Radio_Button class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */

/**
 * Customize Radio Button class.
 *
 * @since 3.4.0
 *
 * @see WP_Customize_Image_Control
 */
class Magic_Customize_Layout_Control extends WP_Customize_Image_Control {
	public $type = 'background';

	/**
	 * Constructor.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Image_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 */
	public function __construct( $manager ) {
		parent::__construct( $manager, 'background_image', array(
			'label'    => __( 'Layout', 'magic-grundstein' ),
			'section'  => 'background_image',
		) );
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 4.1.0
	 */
	public function enqueue() {
		parent::enqueue();

		$custom_background = get_theme_support( 'custom-background' );
		wp_localize_script( 'customize-controls', '_wpCustomizeBackground', array(
			'defaults' => ! empty( $custom_background[0] ) ? $custom_background[0] : array(),
			'nonces' => array(
				'add' => wp_create_nonce( 'background-add' ),
			),
		) );
	}
}
