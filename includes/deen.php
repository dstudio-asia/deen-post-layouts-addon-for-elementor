<?php
namespace DeenPostLayoutAddon;

final class DeenPostLayout {
	/**
	 * Addon Version
	 *
	 * @since 1.0.0
	 * @var string The addon version.
	 */
	const VERSION = '1.0.5';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the addon.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the addon.
	 */
	const MINIMUM_PHP_VERSION = '7.3';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var \DeenPostLayoutAddon\DeenPostLayout The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return \DeenPostLayoutAddon\DeenPostLayout An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}

	}

	/**
	 * Compatibility Checks
	 *
	 * Checks whether the site meets the addon requirement.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	 
	public function is_compatible() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'deen-post-layouts-addon' ),
			'<strong>' . esc_html__( 'Deen Post Layouts Addon For Elementor', 'deen-post-layouts-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'deen-post-layouts-addon' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'deen-post-layouts-addon' ),
			'<strong>' . esc_html__( 'Deen Post Layouts Addon For Elementor', 'deen-post-layouts-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'deen-post-layouts-addon' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'deen-post-layouts-addon' ),
			'<strong>' . esc_html__( 'Deen Post Layouts Addon For Elementor', 'deen-post-layouts-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'deen-post-layouts-addon' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Initialize
	 *
	 * Load the addons functionality only after Elementor is initialized.
	 *
	 * Fired by `elementor/init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	
	public function init() {

		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [$this,'add_deen_post_layout_categories']);
	}

	public function frontend_styles() {

	    wp_register_style( 'deen-addon-fontawesome', plugins_url( '../assets/css/fontawesome.css', __FILE__) );
	    wp_register_style( 'deen-addon-rtl-style', plugins_url( '../assets/css/deen-widgets-rtl.css', __FILE__ ), null, self::VERSION , false ); 
		wp_register_style( 'deen-addon-style', plugins_url( '../assets/css/deen-widgets.css', __FILE__ ), null, self::VERSION , false  ); 
		wp_register_style( 'deen-addon-custom-style', plugins_url( '../assets/css/deen-addon.css', __FILE__ ), null, self::VERSION , false); 
		wp_register_style( 'deen-addon-custom-rtl-style', plugins_url( '../assets/css/deen-addon-rtl.css', __FILE__ ), null, self::VERSION , false ); 
	    wp_register_style( 'deen-addon-responsive-rtl-style', plugins_url( '../assets/css/deen-widgets-responsive-rtl.css', __FILE__ ), null, self::VERSION , false ); 
		wp_register_style( 'deen-addon-responsive-style', plugins_url( '../assets/css/deen-widgets-responsive.css', __FILE__ ), null, self::VERSION , false );
		if(is_rtl()){
		 wp_enqueue_style( 'deen-addon-rtl-style' );
		 wp_enqueue_style( 'deen-addon-custom-rtl-style' );
		 wp_enqueue_style( 'deen-addon-responsive-rtl-style' );
		}else{
		 wp_enqueue_style( 'deen-addon-style' );
		 wp_enqueue_style( 'deen-addon-custom-style' );
		 wp_enqueue_style( 'deen-addon-responsive-style' );
		}
		 wp_enqueue_style('deen-addon-fontawesome');
	}

	public function frontend_scripts(){ 
		wp_register_script( 'deen-addon-main-js', plugins_url( '../assets/js/main.js', __FILE__ ), [ 'jquery'], self::VERSION, true );
		wp_enqueue_script('deen-addon-main-js');
		wp_enqueue_script('deen-addon-owl-carousal-js');

	}
	
	function register_widgets( $deen_widgets_manager ) {
		require_once( __DIR__ . '/widgets/deen-posts-widget.php' );
		$deen_widgets_manager->register( new \Deen_Post_Layouts() );
	
	}

	function add_deen_post_layout_categories( $elements_manager ) {

		$elements_manager->add_category(
			'deen_post_layout_category',
			[
				'title' => esc_html__( 'Deen', 'deen-post-layouts-addon' ),
				'icon' => 'fa fa-plug',
			]
		);
	
	}

}
