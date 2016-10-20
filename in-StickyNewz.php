<?php
/*
    Plugin Name: Insanen Sticky News Wordpress Plugin
    Description: WordPress Sticky Newz with Style for your blog.
    Author: Insanen Team - http://insanen.com
    Version: 1.0.0
*/

/**
 *  @version	1.0.0
 */

if (!defined('WPINC')) {
    die('No script kiddies please!');
}

function inStickyNewZ_register_scripts()
{
    if (!is_admin()) {
    } else {      
    }
}

function inStickyNewZ_register_styles()
{
    wp_register_style('snz_css', plugins_url('includes/css/style.min.css', __FILE__));
    wp_enqueue_style('snz_css');
}

function inStickyNewZ_function($type = 'inStickyNewZ_function')
{
    $args = array(
      'post_type' => 'sticky-news',
      'posts_per_page' => 6,
    );

    $result .= '<div class="col-md-12">';
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
    $the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);
    $result .= '<div class="col-md-4">';
    $result .= '<div class="snz_title">';
    $result .= '<a href="'. get_permalink() .'">'.get_the_title().'</a>';
    $result .= '</div>';
    $result .= '<div class="entry-content">';
    $result .= '<div class="snz_img">';
    $result .= '<a href="'. get_permalink() .'"><img title="'.get_the_title().'" src="'.$the_url[0].'" data-thumb="'.$the_url[0].'" alt=""/></a>';
    $result .= '</div>';
    $result .= '</div>';
    $result .= '';
    $result .= '</div>';
    endwhile;
    wp_reset_postdata();
    $result .= '</div>';
    return $result;
}

function inStickyNewZ_init()
{
      $labels = array(
      'name' => _x('StickyNewZ', 'sticky_newz'),
      'singular_name' => _x('StickyNewZ', 'sticky_newz'),
      'add_new' => _x('Add New StickyNewZ', 'sticky_newz'),
      'add_new_item' => _x('Add New StickyNewZ', 'sticky_newz'),
      'edit_item' => _x('Edit StickyNewZ', 'sticky_newz'),
      'new_item' => _x('New StickyNewZ', 'sticky_newz'),
      'view_item' => _x('View StickyNewZ', 'sticky_newz'),
      'search_items' => _x('Search StickyNewZ', 'sticky_newz'),
      'not_found' => _x('No StickyNewZ found', 'sticky_newz'),
      'not_found_in_trash' => _x('No StickyNewZ found in Trash', 'sticky_newz'),
      'parent_item_colon' => _x('Parent StickyNewZ:', 'sticky_newz'),
      'menu_name' => _x('StickyNewZ', 'sticky_newz'),
  );

    add_shortcode('stickynewz', 'inStickyNewZ_function');
    add_image_size('inStickyNewZ_widget', 180, 100, true);
    add_image_size('inStickyNewZ_function', 600, 200, true);

    $args = array(
    'public' => true,
    'labels' => $labels,
    'supports' => array(
      'title',
      'thumbnail',
      'editor',
      'revisions',
    ),
    'hierarchical' => true,
    'taxonomies' => array('categories'),
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 6,
    'menu_icon' => 'dashicons-format-gallery',
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capability_type' => 'post',
);
    register_post_type('sticky-news', $args);
}

function inStickyNewZ_cat_taxonomy()
{
    register_taxonomy(
        'categories',
        'sticky_newz',
        array(
            'hierarchical' => true,
            'label' => 'Categories',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'categories',
                'with_front' => false,
            ),
        )
    );
}

function inStickyNewZ_mb_add()
{
    add_meta_box('my-meta-box-id2', 'Insanen.com Classifieds:', 'inStickyNewZ_mb2', 'sticky-news', 'side', 'high');
    add_meta_box('my-meta-box-id', 'Plugin Information :', 'inStickyNewZ_mb', 'sticky-news', 'normal', 'high');
}

function inStickyNewZ_mb()
{
    echo '<a href="http://insanen.com/learn" target="_blank" title="Insanen Solutions - Media Agency"><img class="WSimg" src="http://insanen.com/images/insanen-728x90-web.png" style="width: 100%;"></a>';
    echo '<br />';
    echo '<h1>How to use: </h1>';
    echo '<li>Start by adding your New StickyNewZ Post by Clicking, "Add New StickyNewZ"';
    echo '<li>In this page, Your going to add the title, the content and a featured image, <br />&nbsp;&nbsp;&nbsp;&nbsp;which later on will become the image used by WetSlider.</li>';
    echo '<li>After Adding the NewZ Post, Go ahead and Click Publish.</li>';
    echo '<li>This action has now created a sticky post, that can be found on StickyNewZ -> StickyNewZ Section</li>';
    echo '<li>With the post already created with data and a featured image, your now ready to use your plugin, <br />&nbsp;&nbsp;&nbsp;&nbsp;in any page.</li>';
    echo '<li>Add Shortcode to see the StickyNewZ Code take over your Index Page <code>[stickynewz]</code>.</li>';
    echo '<br /><br />We are able to continue to produce FREE plugins, because of you guys, and all the donations made by the community, Thank you so much! <br /><a href="http://insanen.com/press/product/plugin-donation/" target="_blank">Buy us a coffee!</a>';
}

function inStickyNewZ_mb2()
{
    echo '';
    echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><div class="adsbyinsanen-stickynews"><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6091911878727341" data-ad-slot="6177899313" data-ad-format="auto"></ins></div><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
    echo '';
}

add_theme_support('post-thumbnails');

add_action('init', 'inStickyNewZ_cat_taxonomy');
add_action('init', 'inStickyNewZ_init');
add_action('wp_print_scripts', 'inStickyNewZ_register_scripts');
add_action('wp_print_styles', 'inStickyNewZ_register_styles');
add_action('add_meta_boxes', 'inStickyNewZ_mb_add');
