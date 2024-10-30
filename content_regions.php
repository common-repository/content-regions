<?php
/*
Plugin Name: Content Regions
Plugin URI: http://wordpress.org/plugins/content-regions/
Description: Create, Edit and Print independent content
Version: 0.4
Author: Carles Jove i Buxeda
Author URI: http://joanielena.cat
Text Domain: content-regions
License: GPLv3
*/
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if(!class_exists('Content_Regions'))
{
	class Content_Regions
	{
		/**
		 * The plugin object
		 */
		public $cr;
		public $langs_dir;
		public $text_domain = 'content-regions';

		/**
		 * 
		 */
		public function __construct()
		{        	
    	$this->langs_dir = basename(dirname(__FILE__)) . '/languages';
    	// Register custom post types
      require_once(sprintf("%s/post-type/content_region.php", dirname(__FILE__)));
      add_action( 'plugins_loaded', array($this, 'init') );
      $this->cr = new Content_Region();
		}

		/**
		 * Init
		 * Actions to do when plugin is initialized
		 */
		public function init() 
		{
			load_plugin_textdomain( $this->text_domain, false, $this->langs_dir );
		}
	    
		/**
		 * Activate
		 */
		public static function activate()
		{
			// Do nothing
		}
	
		/**
		 * Deactivate
		 */		
		public static function deactivate()
		{
			// Do nothing
		}
	}
}

if(class_exists('Content_Regions'))
{
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Content_Regions', 'activate'));
	register_deactivation_hook(__FILE__, array('Content_Regions', 'deactivate'));

	$crs = new Content_Regions();

	/**
	 * Returns a Content Region's content
	 */
	function content_region( $post_name = null, $args = array() )
	{
		global $crs;
		return $crs->cr->get_content_region($post_name, $args);
	}

	/**
	 * Returns a Content Region's title
	 */
	function content_region_title( $post_name = null )
	{
		global $crs;
		return $crs->cr->get_content_region($post_name, array( 'field' => 'title' ));
	}

	/**
	 * Returns a Content Region's ID
	 */
	function content_region_id( $post_name = null )
	{
		global $crs;
		return $crs->cr->get_content_region($post_name, array( 'field' => 'ID', 'echo' => false ));
	}
}