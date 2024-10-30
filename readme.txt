=== Content Regions ===
Contributors: carlesjove
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5MG5LA5SM6UM4
Tags: content region, text block, idependent content
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: 0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Content Regions lets you create independent pieces of content that can be called anywhere on your templates.

== Description ==

Ever needed a single paragraph somewhere in your WordPress site? Or maybe you'd like your client to be able to edit that motto in the header? Content Regions plugin lets you to do that by creating standalone contents that can be called anywhere on your templates.


== Installation ==

This section describes how to install the plugin and get it working.

1. Download the plugin files
2. Upload `content-regions` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Start creating content regions ;-)

== Screenshots ==

1. You can access Content Regions in the main menu, just like any other post
2. Editing Content Regions has nothing special. No worries! 


== Changelog ==

= 0.4 =
* Added shortcode
* Allow numeric post ids to be passed as argument

= 0.3.2 =
* Added domain to i18n
* Tested up to 3.8

= 0.3 =
* Minor changes

= 0.2 =
* Return values are filtered, so shortcodes work
* Returns error message if the field is invalid


== Usage ==
You can access your content regions in different ways, either adding template tags to your templates or using the `content-region` shortcode in the editor. 

= Shortcode =
In the text editor, add the shortcode as follows:

`[content-region id="the-region-name-here"] // id can either be the post name or its id`

By default, this will return the content of the Content Region. You can specify which field you want returned by adding a `field` argument. Options are `content` and `title`:

`[content-region id="3" field="title"] // Will return the title of Content Region with id 3`


= Template tag =
The easiest is by using the `content_region( $region, $options )` function. By default, `content_region( $region )` will echo the content field of the region. Other options are:

`content_region( $region, [$options] ) // echoes the content field. Accepts, $options`
`content_region_title( $region ) // echoes the title field`
`content_region_id( $region ) // returns the Content Region's ID`

**Example:**

You have created a Content Region titled *My content region*, with post-name `'my-content-region':

`content_region_title( 'my-content-region' ) // echo the title`
`content_region( 'my-content-region' ) // echo the content`
`content_region( 'my-content-region', array('field' => 'title', 'echo' => false) ) // Get the title, but do not echo it`

	// Get all Content Region's attachments
	$attachments = get_posts( array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_parent' => content_region_id( 'my-content-region' ),
	) );

Of course, you can retrieve regions the good ol' WordPress way, with a `WP_Query`:

	$loop = new WP_Query(array(
	  'name' => 'my-content-region',
	  'post_type' => 'content-region',
	  'post_status' => 'publish',
	  'posts_per_page' => 1,
	));

	if( $loop->have_posts() ) 
	{
	  while ($loop->have_posts()) : $loop->the_post();
	    the_title();
	    the_content();
	  endwhile;
	}
