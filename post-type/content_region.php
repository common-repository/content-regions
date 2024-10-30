<?php
if(!class_exists('Content_Region'))
{
	/**
	 * Content Region Class
	 */
	class Content_Region
	{
		const POST_TYPE	= "content-region";
    private $valid_fields = array(
      'title',
      'content',
      'excerpt',
      'ID'
    );
    public $function;
		
  	/**
  	 * The Constructor
  	 */
  	public function __construct()
  	{
  		add_action('init', array(&$this, 'init'));
      add_shortcode( self::POST_TYPE, array(&$this, 'shortcode') );
  	}

  	/**
  	 * Hook into WP's init action hook
  	 */
  	public function init()
  	{
  		$this->create_post_type();
  	}

  	/**
  	 * Create the post type
  	 */
  	public function create_post_type()
  	{
      $labels = array(
        'name'                  => _x('Content Regions', 'post type general name', 'content-regions'),
        'singular_name'         => _x('Content Region', 'post type singular name', 'content-regions'),
        'add_new'               => _x('Add New', 'Content Region item', 'content-regions'),
        'add_new_item'          => __('Add New Content Region', 'content-regions'),
        'edit_item'             => __('Edit Content Region', 'content-regions'),
        'new_item'              => __('New Content Region', 'content-regions'),
        'view_item'             => __('View Content Region', 'content-regions'),
        'search_items'          => __('Search Content Regions', 'content-regions'),
        'not_found'             => __('Nothing found', 'content-regions'),
        'not_found_in_trash'    => __('Nothing found in Trash', 'content-regions'),
        'parent_item_colon'     => ''
      );
      $args = array(
        'labels'                => $labels,
        'description'           => __("This is blah blah", 'content-regions'),
        'public'                => true,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_nav_menus'     => false,
        'show_in_admin_bar'     => false,
        'query_var'             => true,
        //'menu_icon'             => get_stylesheet_directory_uri() . '/article16.png',
        'capability_type'       => 'post',
        'hierarchical'          => true,
        'menu_position'         => 20, // below Pages
        'supports'              => array('title','editor','excerpt'),
        'has_archive'           => false,
        'rewrite'               => true,
      ); 

      register_post_type(self::POST_TYPE,$args);
  	}

    /**
     * Get Content Region's data
     */
    public function get_content_region( $post_name = null, $options = array() )
    {
      $defaults = array(
        'field' => 'content',
        'echo'  => true,
      );

      $options = array_merge($defaults, $options);

      $query = null;
      $query = new WP_Query(array(
        'name' => $this->_get_post_name($post_name),
        'post_type' => 'content-region',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'ignore_sticky_posts'=> 1
      ));

      if ( ! $this->_is_valid_field($options['field'])) {
        new Exception('You are trying to call an unknow field');
      }
      
      // Set function name dinamically
      $function = $this->function;
      // At least return an error message
      $return = "We found nothing with name: {$post_name}";

      if( $query->have_posts() ) 
      {
        while ($query->have_posts()) : $query->the_post(); $post = $query;
          $return = apply_filters( "the_{$options['field']}", $function() );
        endwhile;
      }

      wp_reset_postdata();  // Restore global post data stomped by the_post().

      if ( $options['echo'] == true ) {
        echo $return;
      } else {
        return $return;
      }
    }

    /**
     * Is Valid Field?
     * Check if the passed field is correct
     */
    public function _is_valid_field($field)
    {
      if ( in_array($field, $this->valid_fields) ) {
        $this->function = 'get_the_' . $field;
        return true;
      }
      return false;
    }

    /**
     * Shortcode
     */
    public function shortcode($atts) {
      extract( shortcode_atts( array(
        'id' => null,
        'field' => 'content',
      ), $atts ) );
      
      $options = array(
        'field' => $field,
        'echo'  => false, // MUST be false or the region will be printed before the rest of the content
      );

      return $this->get_content_region($id, $options);
    }

    /**
     * Get Post Name
     * Checks whether the $id is a number or the post name and returns de post name
     */
     private function _get_post_name($id) {
      if ( is_numeric($id) ) {
        $post = get_post($id);
        return $post->post_name;
      }
      return $id;
     }
	}
}