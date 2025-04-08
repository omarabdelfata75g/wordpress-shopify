<?php
/**
 * Custom Theme functions and definitions
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function custom_theme_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(
        array(
            'primary' => esc_html__('Primary Menu', 'custom-theme'),
            'footer' => esc_html__('Footer Menu', 'custom-theme'),
        )
    );

    // Add theme support for Custom Logo.
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'custom_theme_setup');

/**
 * Enqueue scripts and styles.
 */
function custom_theme_scripts() {
    wp_enqueue_style('custom-theme-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_enqueue_script('custom-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts');

/**
 * Register Custom Post Type for Projects
 */
function custom_projects_post_type() {
    $labels = array(
        'name'                  => _x('Projects', 'Post type general name', 'custom-theme'),
        'singular_name'         => _x('Project', 'Post type singular name', 'custom-theme'),
        'menu_name'             => _x('Projects', 'Admin Menu text', 'custom-theme'),
        'name_admin_bar'        => _x('Project', 'Add New on Toolbar', 'custom-theme'),
        'add_new'               => __('Add New', 'custom-theme'),
        'add_new_item'          => __('Add New Project', 'custom-theme'),
        'new_item'              => __('New Project', 'custom-theme'),
        'edit_item'             => __('Edit Project', 'custom-theme'),
        'view_item'             => __('View Project', 'custom-theme'),
        'all_items'             => __('All Projects', 'custom-theme'),
        'search_items'          => __('Search Projects', 'custom-theme'),
        'not_found'             => __('No projects found.', 'custom-theme'),
        'not_found_in_trash'    => __('No projects found in Trash.', 'custom-theme'),
        'featured_image'        => _x('Project Cover Image', 'Overrides the "Featured Image" phrase', 'custom-theme'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the "Set featured image" phrase', 'custom-theme'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase', 'custom-theme'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the "Use as featured image" phrase', 'custom-theme'),
        'archives'              => _x('Project archives', 'The post type archive label used in nav menus', 'custom-theme'),
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'projects'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
        'menu_icon'          => 'dashicons-portfolio',
    );

    register_post_type('project', $args);

    // Register Project Category Taxonomy
    $taxonomy_labels = array(
        'name'              => _x('Project Categories', 'taxonomy general name', 'custom-theme'),
        'singular_name'     => _x('Project Category', 'taxonomy singular name', 'custom-theme'),
        'search_items'      => __('Search Project Categories', 'custom-theme'),
        'all_items'         => __('All Project Categories', 'custom-theme'),
        'parent_item'       => __('Parent Project Category', 'custom-theme'),
        'parent_item_colon' => __('Parent Project Category:', 'custom-theme'),
        'edit_item'         => __('Edit Project Category', 'custom-theme'),
        'update_item'       => __('Update Project Category', 'custom-theme'),
        'add_new_item'      => __('Add New Project Category', 'custom-theme'),
        'new_item_name'     => __('New Project Category Name', 'custom-theme'),
        'menu_name'         => __('Categories', 'custom-theme'),
    );

    $taxonomy_args = array(
        'hierarchical'      => true,
        'labels'            => $taxonomy_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'project-category'),
    );

    register_taxonomy('project_category', array('project'), $taxonomy_args);
}
add_action('init', 'custom_projects_post_type');

/**
 * Register widget area.
 */
function custom_theme_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'custom-theme'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'custom-theme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'custom_theme_widgets_init');