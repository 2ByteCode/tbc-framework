<?php
/**
 * Fired during plugin activation
 *
 * @link  https://2bytecode.com
 * @since 1.0.0
 *
 * @package    Client_Site_Manager
 * @subpackage Client_Site_Manager/includes
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'TBCFM_Admin_Menu_Pages' ) ) {

	/**
	 * Class TBC_Admin_Menu_Page .
	 *
	 * This class is responsible for creating admin menu pages with a specified configuration.
	 *
	 * @since      1.0.0
	 * @package    Client_Site_Manager
	 * @subpackage Client_Site_Manager/includes
	 * @author     2ByteCode <support@2bytecode.com>
	 */
	class TBCFM_Admin_Menu_Pages {

		/**
		 * Array of admin menu items.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var array The arguments for the menu pages.
		 */
		private array $menu_pages;

		/**
		 * TBC_Admin_Menu_Page constructor.
		 *
		 * @param array $menu_pages The menu pages configuration array.
		 */
		public function __construct( array $menu_pages = array() ) {

			$this->menu_pages = $menu_pages;
			add_action( 'admin_menu', array( $this, 'tbc_register_menu_pages' ) );
		}

		/**
		 * Register the menu pages.
		 *
		 * Loops through the menu pages array and registers each menu or sub-menu page.
		 */
		public function tbc_register_menu_pages(): void {

			/**
			 * Filters the menu pages.
			 *
			 * @since 1.0.0
			 *
			 * @param array $this->menu_pages The arguments for the menu pages.
			 */
			$this->menu_pages = apply_filters( 'tbcfm_admin_menu_pages', $this->menu_pages );

			foreach ( $this->menu_pages as $page ) {

				// Add sub-menu page.
				if ( isset( $page['parent_slug'] ) ) {
					add_submenu_page(
						$page['parent_slug'],
						$page['page_title'],
						$page['menu_title'],
						$page['capability'],
						$page['menu_slug'],
						array( $page['class_instance'], $page['callback'] )
					);
				} else {
					// Add top-level menu page.
					add_menu_page(
						$page['page_title'],
						$page['menu_title'],
						$page['capability'],
						$page['menu_slug'],
						array( $page['class_instance'], $page['callback'] ),
						$page['icon_url'] ?? '',
						$page['position'] ?? null
					);
				}
			}
		}
	}

	new TBCFM_Admin_Menu_Pages();

}
