<?php
/**
 * Grind Loop functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Grind_Loop
 */

if ( ! function_exists( 'grind_loop_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function grind_loop_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Grind Loop, use a find and replace
     * to change 'grind-loop' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'grind-loop', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary', 'grind-loop' ),
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // Set up the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'grind_loop_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );

    add_theme_support( 'post-formats', ['link'] );

}
endif;
add_action( 'after_setup_theme', 'grind_loop_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function grind_loop_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'grind_loop_content_width', 640 );
}
add_action( 'after_setup_theme', 'grind_loop_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function grind_loop_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'grind-loop' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'grind-loop' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer', 'grind-loop' ),
        'id'            => 'footer',
        'description'   => esc_html__( 'Add widgets here.', 'grind-loop' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'grind_loop_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function grind_loop_scripts() {
    wp_enqueue_style( 'grind-loop-style', get_stylesheet_uri() );

    wp_enqueue_script( 'grind-loop-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script( 'grind-loop-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'grind_loop_scripts' );

function grind_loop_sitename($host) {
    $replacements = [
        'dancingastronaut.com' => 'Dancing Astronaut',
    ];

    return $replacements[$host] ? $replacements[$host] : $host;
}

function grind_loop_get_title_size_class($classes, $post = null) {
    $title = get_the_title($post);
    $title_length = strlen($title);

    $breakpoints = [
        300 => 'small',
        70 => 'medium',
        20 => 'large',
        0 => 'extra-large',
    ];

    foreach ($breakpoints as $size => $class) {
        if ($title_length >= $size) {
            break;
        }
    }

    $classes[] = 'title-size-' . $class;

    return $classes;
}

function grind_loop_customize_css()
{
    ?>
    <style type="text/css">
        h1, h2, h3, h4, h5, h6 { color: <?php echo get_theme_mod('headings_color'); ?>; }
    </style>
    <?php
}
add_action('wp_head', 'grind_loop_customize_css');

add_filter('post_class', 'grind_loop_get_title_size_class');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
