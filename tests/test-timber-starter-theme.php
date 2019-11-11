<?php
/**
 * Test various parts of this theme, including setup, tear down after deactivation.
 *
 * @package grundstein
 * @since 0.0.1
 */

/**
 * Extent WP_UnitTestCase
 *
 * @since 0.0.1
 */
class TestTimberStarterTheme extends WP_UnitTestCase {
	/**
	 * Activate theme
	 *
	 * @since 0.0.1
	 */
	public function setUp() {
		self::setupStarterTheme();
		switch_theme( basename( dirname( dirname( __FILE__ ) ) ) );
		require_once __DIR__ . '/../functions.php';
	}

	/**
	 * Deactivate theme
	 *
	 * @since 0.0.1
	 */
	public function tearDown() {
		switch_theme( 'twentythirteen' );
	}

	/**
	 * Test if Timber is installed
	 *
	 * @since 0.0.1
	 */
	public function testTimberExists() {
		$context = Timber::context();
		$this->assertTrue( is_array( $context ) );
	}

	/**
	 * Set up theme
	 *
	 * @since 0.0.1
	 */
	public function testFunctionsPHP() {
		$context = Timber::context();
		$this->assertEquals( 'MagicGrundstein', get_class( $context['site'] ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
	}

	/**
	 * Test loading one of the template files
	 *
	 * @since 0.0.1
	 */
	public function testLoading() {
		$str = Timber::compile( 'tease.twig' );
		$this->assertStringStartsWith( '<article class="tease tease-" id="tease-">', $str );
		$this->assertStringEndsWith( '</article>', $str );
	}

	/**
	 * Test loading one of the template files
	 *
	 * @since 0.0.1
	 */
	public function testTwigFilter() {
		$str = Timber::compile_string( '{{ "foo" | myfoo }}' );
		$this->assertEquals( 'foo bar!', $str );
	}

	/**
	 * Run a dirty setup of this theme.
	 *
	 * @since 0.0.1
	 */
	public static function setupStarterTheme() {
		$dest = WP_CONTENT_DIR . '/themes/' . basename( dirname( dirname( __FILE__ ) ) );
		$src  = realpath( __DIR__ . '/../../' . basename( dirname( dirname( __FILE__ ) ) ) );
		if ( is_dir( $src ) && ! file_exists( $dest ) ) {
			symlink( $src, $dest );
		}
	}
}
