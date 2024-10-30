WP Content Regions
==================

Ever needed a single paragraph somewhere in your WordPress site? Or maybe you'd like your client to be able to edit that motto in the header? Content Regions plugin allows you to do that by creating standalone contents that can be called anywhere on your templates.

How To Use
----------
1. Download the plugin files
2. Install it in your plugins directories as usual ('wp-content/plugins/'), and make sure the name of the folder is content_regions (with an underscore)
3. Activate the plugin
4. Start creating content regions

Retrieveing your content regions
--------------------------------
You can access your content regions in different ways. The easiest is by using the `content_region( $region, $options )` function.
By default, `content_region( $region )` will echo the content field of the content region. All options are:

- `content_region( $region, [$options] )`: echoes the content field. Accepts, `$options`.
- `content_region_title( $region )`: echoes the title field.
- `content_region_id( $region )`: returns the Content Region's ID.

Example: 
You have created a Content Region titled "My content region", with post-name 'my-content-region':
- Echo the title: `content_region_title( 'my-content-region' )`
- Echo the content: `content_region( 'my-content-region' )`
- Get the title, but not echo it: `content_region( 'my-content-region', array('field' => 'title', 'echo' => false) )`

Of course, you can retrieve regions the good ol' WordPress way, with a `WP_Query`:

```
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
```

Arguments
---------

**$region**

Required (string). The post name.

**$options** 

Optional(array). Choose which field you want returned or echoed.

- 'echo': bool. Whether to echo the return value or just get it. True is default (which means it will be echoed)
- 'title': Returns the Content Region's title
- 'content': Returns the Content Region's content
- 'excerpt': Returns the Content Region's excerpt
- 'id': Returns the Content Region's ID