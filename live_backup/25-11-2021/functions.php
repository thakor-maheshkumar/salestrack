<?php
$domex_redux_demo = get_option('redux_demo');

//Custom fields:
require_once get_template_directory() . '/framework/wp_bootstrap_navwalker.php';
require_once get_template_directory() . '/framework/widget/recent-post.php';
//Theme Set up:
function domex_theme_setup() {
    /*
     * This theme uses a custom image size for featured images, displayed on
     * "standard" posts and pages.
     */
  add_theme_support( 'post-formats', array( 'image','gallery','video' ) );
    add_theme_support( 'custom-header' ); 
  remove_filter ('the_content', 'wpautop');
    add_theme_support( 'custom-background' );
    $lang = get_template_directory_uri() . '/languages';
  load_theme_textdomain('domex', $lang);
  add_theme_support( 'post-thumbnails' );
  // Adds RSS feed links to <head> for posts and comments.
  add_theme_support( 'automatic-feed-links' );
  // Switches default core markup for search form, comment form, and comments
  // to output valid HTML5.
  add_theme_support( "title-tag" );
  add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
  // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
    'primary_left' =>  esc_html__( 'Primary Left Navigation Menu.', 'domex' ),
    'primary_right' =>  esc_html__( 'Primary Right Navigation Menu.', 'domex' ),
    'primary_left_2' =>  esc_html__( 'Home 2 Primary Left Navigation Menu.', 'domex' ),
    'primary_right_2' =>  esc_html__( 'Home 2  Primary Right Navigation Menu.', 'domex' ),
    'mobile' =>  esc_html__( 'Mobile Menu.', 'domex' ),
    ) );
    // This theme uses its own gallery styles.
}
add_action( 'after_setup_theme', 'domex_theme_setup' );
if ( ! isset( $content_width ) ) $content_width = 900;

function domex_fonts_url() {
    $font_url = '';

    if ( 'off' !== _x( 'on', 'Google font: on or off', 'domex' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Poppins:300,300i,400,400i,500,500i,600,600i,700,800,800i,900&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}

function domex_theme_scripts_styles() {
    $domex_redux_demo = get_option('redux_demo');
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'animate', get_template_directory_uri().'/css/animate.css');
    wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.min.css');
    wp_enqueue_style( 'domex-fonts', get_template_directory_uri().'/css/fonts.css');
    wp_enqueue_style( 'domex-flaticon', get_template_directory_uri().'/css/flaticon.css');
    wp_enqueue_style( 'domex-font-awesome', get_template_directory_uri().'/css/font-awesome.css');
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri().'/css/owl.carousel.css');
    wp_enqueue_style( 'owl-theme-default', get_template_directory_uri().'/css/owl.theme.default.css');
    wp_enqueue_style( 'magnific-popup', get_template_directory_uri().'/css/magnific-popup.css');
    wp_enqueue_style( 'player', get_template_directory_uri().'/css/player.css');
    wp_enqueue_style( 'domex-reset', get_template_directory_uri().'/css/reset.css');
    wp_enqueue_style( 'layers', get_template_directory_uri().'/js/plugin/rs_slider/layers.css');
    wp_enqueue_style( 'navigation', get_template_directory_uri().'/js/plugin/rs_slider/navigation.css');
    wp_enqueue_style( 'settings', get_template_directory_uri().'/js/plugin/rs_slider/settings.css');
    wp_enqueue_style( 'domex-style', get_template_directory_uri().'/css/style.css');
    wp_enqueue_style( 'domex-responsive', get_template_directory_uri().'/css/responsive.css');
    wp_enqueue_style( 'domex-css', get_stylesheet_uri(), array(), '2020-02-27' );

if(isset($domex_redux_demo['chosen-color']) && $domex_redux_demo['chosen-color']==1){
    wp_enqueue_style( 'color', get_template_directory_uri().'/framework/color.php');
    }    
if(isset($domex_redux_demo['support-rtl']) && $domex_redux_demo['support-rtl']==1){
    wp_enqueue_style( 'support-rtl', get_template_directory_uri().'/rtl.css');
    }
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );
  //Javascript
    wp_enqueue_script("domex-jquery", get_template_directory_uri()."/js/jquery-3.3.1.min.js",array(),false,true);
    wp_enqueue_script("bootstrap", get_template_directory_uri()."/js/bootstrap.min.js",array(),false,true);
    wp_enqueue_script("modernizr", get_template_directory_uri()."/js/modernizr.js",array(),false,true);
    
    wp_enqueue_script("domex-menu-aim", get_template_directory_uri()."/js/jquery.menu-aim.js",array(),false,true);
    wp_enqueue_script("imagesloaded-pkgd", get_template_directory_uri()."/js/imagesloaded.pkgd.min.js",array(),false,true);
    wp_enqueue_script("magnific-popup", get_template_directory_uri()."/js/jquery.magnific-popup.js",array(),false,true);
    wp_enqueue_script("domex-countTo", get_template_directory_uri()."/js/jquery.countTo.js",array(),false,true);
    wp_enqueue_script("inview", get_template_directory_uri()."/js/jquery.inview.min.js",array(),false,true);
    wp_enqueue_script("isotope-pkgd", get_template_directory_uri()."/js/isotope.pkgd.min.js",array(),false,true);
    wp_enqueue_script("domex-downCount", get_template_directory_uri()."/js/jquery.downCount.js",array(),false,true);
    wp_enqueue_script("owl-carousel", get_template_directory_uri()."/js/owl.carousel.js",array(),false,true);
    wp_enqueue_script("domex-player", get_template_directory_uri()."/js/player.js",array(),false,true);
    
    
    if(is_singular('event')){
     wp_enqueue_script("domex-multi", get_template_directory_uri()."/js/multi.js",array(),false,true);
    }
    wp_enqueue_script("domex-custom", get_template_directory_uri()."/js/custom.js",array(),false,true);
    wp_enqueue_script("themepunch-revolution", get_template_directory_uri()."/js/plugin/rs_slider/jquery.themepunch.revolution.min.js",array(),false,true);
    wp_enqueue_script("themepunch-tools", get_template_directory_uri()."/js/plugin/rs_slider/jquery.themepunch.tools.min.js",array(),false,true);
    if(is_page_template('page-templates/home-2.php')){
      wp_enqueue_script("addon-snow", get_template_directory_uri()."/js/plugin/rs_slider/revolution.addon.snow.min.js",array(),false,true);
      wp_enqueue_script("domex-slider", get_template_directory_uri()."/js/slider.js",array(),false,true);
    }
    wp_enqueue_script("extension-actions", get_template_directory_uri()."/js/plugin/rs_slider/revolution.extension.actions.min.js",array(),false,true);
    wp_enqueue_script("extension-carousel", get_template_directory_uri()."/js/plugin/rs_slider/revolution.extension.carousel.min.js",array(),false,true);
    wp_enqueue_script("extension-kenburn", get_template_directory_uri()."/js/plugin/rs_slider/revolution.extension.kenburn.min.js",array(),false,true);
    wp_enqueue_script("layeranimation", get_template_directory_uri()."/js/plugin/rs_slider/revolution.extension.layeranimation.min.js",array(),false,true);
    wp_enqueue_script("migration", get_template_directory_uri()."/js/plugin/rs_slider/revolution.extension.migration.min.js",array(),false,true);
    wp_enqueue_script("navigation", get_template_directory_uri()."/js/plugin/rs_slider/revolution.extension.navigation.min.js",array(),false,true);
    wp_enqueue_script("parallax", get_template_directory_uri()."/js/plugin/rs_slider/revolution.extension.parallax.min.js",array(),false,true);
    wp_enqueue_script("slideanims", get_template_directory_uri()."/js/plugin/rs_slider/revolution.extension.slideanims.min.js",array(),false,true);
    wp_enqueue_script("extension-video", get_template_directory_uri()."/js/plugin/rs_slider/revolution.extension.video.min.js",array(),false,true);
    wp_enqueue_script("domex-map", $protocol ."://maps.google.com/maps/api/js?key=AIzaSyDOogBL2cC0dSezucKzQGWxMIMmclqWNts&sensor=false");
}
    
add_action( 'wp_enqueue_scripts', 'domex_theme_scripts_styles' );
add_filter('style_loader_tag', 'myplugin_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'myplugin_remove_type_attr', 10, 2);

function myplugin_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}
//Custom Excerpt Function
function domex_do_shortcode($content) {
    global $shortcode_tags;
    if (empty($shortcode_tags) || !is_array($shortcode_tags))
        return $content;
    $pattern = get_shortcode_regex();
    return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $content );
}  

// Widget Sidebar
function domex_widgets_init() {
    register_sidebar( array(
    'name'          => esc_html__( 'Primary Sidebar', 'domex' ),
    'id'            => 'sidebar-1',        
        'description'   => esc_html__( 'Appears in the sidebar section of the site.', 'domex' ),        
        'before_widget' => '<div id="%1$s" class="widget sidebar_widget dm_cover popular-categories %2$s" >',        
        'after_widget'  => '</div>',        
        'before_title'  => '<div class="widget_heading"><h2>',        
        'after_title'   => '</h2></div>'
    ) );

    register_sidebar( array(
    'name'          => esc_html__( 'Footer One Widget', 'domex' ),
    'id'            => 'footer-area-1',
    'description'   => esc_html__( 'Footer Widget that appears on the Footer.', 'domex' ),
    'before_widget' => ' ',
    'after_widget'  => ' ',
    'before_title'  => ' ',
    'after_title'   => ' ',
  ) );
    register_sidebar( array(
    'name'          => esc_html__( 'Footer Two Widget', 'domex' ),
    'id'            => 'footer-area-2',
    'description'   => esc_html__( 'Footer Widget that appears on the Footer.', 'domex' ),
    'before_widget' => ' ',
    'after_widget'  => ' ',
    'before_title'  => ' ',
    'after_title'   => ' ',
  ) );
    register_sidebar( array(
    'name'          => esc_html__( 'Footer Three Widget', 'domex' ),
    'id'            => 'footer-area-3',
    'description'   => esc_html__( 'Footer Widget that appears on the Footer.', 'domex' ),
    'before_widget' => ' ',
    'after_widget'  => ' ',
    'before_title'  => ' ',
    'after_title'   => ' ',
  ) );
    register_sidebar( array(
    'name'          => esc_html__( 'Footer Four Widget', 'domex' ),
    'id'            => 'footer-area-4',
    'description'   => esc_html__( 'Footer Widget that appears on the Footer.', 'domex' ),
    'before_widget' => ' ',
    'after_widget'  => ' ',
    'before_title'  => ' ',
    'after_title'   => ' ',
  ) );
}
add_action( 'widgets_init', 'domex_widgets_init' );

//function tag widgets
function domex_tag_cloud_widget($args) {
    $args['number'] = 0; //adding a 0 will display all tags
    $args['largest'] = 18; //largest tag
    $args['smallest'] = 11; //smallest tag
    $args['unit'] = 'px'; //tag font unit
    $args['format'] = 'list'; //ul with a class of wp-tag-cloud
    $args['exclude'] = array(20, 80, 92); //exclude tags by ID
    return $args;
}
add_filter( 'widget_tag_cloud_args', 'domex_tag_cloud_widget' );
function domex_excerpt() {
  $domex_redux_demo = get_option('redux_demo');
  if(isset($domex_redux_demo['blog_excerpt'])){
    $limit = $domex_redux_demo['blog_excerpt'];
  }else{
    $limit = 30;
  }
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}
function domex2_excerpt() {
  $domex_redux_demo = get_option('redux_demo');
  if(isset($domex_redux_demo['blog_excerpt_2'])){
    $limit = $domex_redux_demo['blog_excerpt_2'];
  }else{
    $limit = 40;
  }
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

function domex3_excerpt() {
  $domex_redux_demo = get_option('redux_demo');
  if(isset($domex_redux_demo['event_excerpt'])){
    $limit = $domex_redux_demo['event_excerpt'];
  }else{
    $limit = 40;
  }
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}
function domex_pagination($pages='') {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    if($pages==''){
        global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
    }
    $pagination = array(
    'base'      => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
    'format'    => '',
    'current'     => max( 1, get_query_var('paged') ),
    'total'     => $pages,
    'prev_text' => wp_specialchars_decode(esc_html__( '<i class = "fa fa-angle-left"></i>', 'domex' ),ENT_QUOTES),
    'next_text' => wp_specialchars_decode(esc_html__( '<i class = "fa fa-angle-right"></i>', 'domex' ),ENT_QUOTES),
    'type'      => 'list',
    'end_size'    => 3,
    'mid_size'    => 3
);
    $return =  paginate_links( $pagination );
  echo str_replace( "<ul class='page-numbers'>", '<ul class="pagination">', $return );
}

function domex_search_form( $form ) {
    $form = '
  <form  method="get" action="' . esc_url(home_url('/')) . '"> 
            <input type="text"  placeholder="'.esc_attr__('Search', 'domex').'" value="' . get_search_query() . '" name="s" > 
  </form>
    ';
    return $form;
}
add_filter( 'get_search_form', 'domex_search_form' );
//Custom comment List:

 
// Comment Form
function domex_theme_comment($comment, $args, $depth) {
    //echo 's';
   $GLOBALS['comment'] = $comment; ?>
    <?php if(get_avatar($comment,$size='100' )!=''){?>
    <div class="col-lg-12 col-md-12 col-12 col-sm-12">
        <div class="comments_Box">
            <div class="img_wrapper">
                <?php echo get_avatar($comment,$size='100' ); ?>
            </div>
            <div class="text_wrapper">
                <div class="author_detail">
                    <span class="author_name"> <?php printf( get_comment_author_link()) ?> <i class="fa fa-circle"></i> </span>
                    <span class="publish_date"> <?php the_time(get_option( 'date_format' ));?> - <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?> </span>
                </div>
                <div class="author_content">
                    <?php comment_text() ?>
                </div>
            </div>
        </div>
    </div>
    <?php }else{?>
    <div class="col-lg-12 col-md-12 col-12 col-sm-12">
        <div class="comments_Box">
            <div class="text_wrapper">
                <div class="author_detail">
                    <span class="author_name"> <?php printf( get_comment_author_link()) ?> <i class="fa fa-circle"></i> </span>
                    <span class="publish_date"> <?php the_time(get_option( 'date_format' ));?> - <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?> </span>
                </div>
                <div class="author_content">
                    <?php comment_text() ?>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<?php
}

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1
 * @author     Thomas Griffin <thomasgriffinmedia.com>
 * @author     Gary Jones <gamajo.com>
 * @copyright  Copyright (c) 2014, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/framework/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'domex_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
 
 
function domex_theme_register_required_plugins() {
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
      array(
            'name'      => esc_html__( 'Contact Form 7', 'domex' ),
            'slug'      => 'contact-form-7',
            'required'  => true,
        ),
      array(
            'name'      => esc_html__( 'One Click Demo Import', 'domex' ),
            'slug'      => 'one-click-demo-import',
            'required'  => true,
        ), 
      array(
            'name'      => esc_html__( 'Classic Editor', 'domex' ),
            'slug'      => 'classic-editor',
            'required'  => true,
        ), 
      array(
            'name'      => esc_html__( 'Widget Importer & Exporter', 'domex' ),
            'slug'      => 'widget-importer-&-exporter',
            'required'  => true,
        ), 
      array(
            'name'                     => esc_html__( 'Domex Common', 'domex' ),
            'slug'                     => 'domex-common',
            'required'                 => true,
            'source'                   => get_template_directory() . '/framework/plugins/domex-common.zip',
        ),
      array(
            'name'                     => esc_html__( 'Elementor', 'domex' ),
            'slug'                     => 'elementor',
            'required'                 => true,
            'source'                   => get_template_directory() . '/framework/plugins/elementor.zip',
        ),
      array(
            'name'                     => esc_html__( 'Domex Elementor', 'domex' ),
            'slug'                     => 'domex-elementor',
            'required'                 => true,
            'source'                   => get_template_directory() . '/framework/plugins/domex-elementor.zip',
        ),
    );
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'domex' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'domex' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'domex' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'domex' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'domex' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'domex' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'domex' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'domex' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'domex' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'domex' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'domex' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'domex' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'domex' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'domex' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'domex' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'domex' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'domex' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    tgmpa( $plugins, $config );
}


function domex_import_files() {
    return array(
        array(
            'import_file_name'           => 'Demo Import Domex',
            'import_file_url'            => 'http://shtheme.com/import/domex/content.xml',
            'import_notice'              => esc_html__( 'Import data example domex', 'domex' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'domex_import_files' );




function domex_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Primary Left Menu', 'primary_left' );
    $main_menu2 = get_term_by( 'name', 'Primary Right Menu', 'primary_right' );
    $main_menu3 = get_term_by( 'name', 'Home 2 Primary Left Menu', 'primary_left_2' );
    $main_menu4 = get_term_by( 'name', 'Home 2 Primary Right Menu', 'primary_right_2' );
    $main_menu5 = get_term_by( 'name', 'Mobile Menu', 'mobile' );
    

    set_theme_mod( 'nav_menu_locations', array(
            'primary_left' => $main_menu->term_id,
            'primary_right' => $main_menu2->term_id,
            'primary_left_2' => $main_menu3->term_id,
            'primary_right_2' => $main_menu4->term_id,
            'mobile' => $main_menu5->term_id,
            
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Index' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'domex_after_import_setup' );


/*
* Creating a function to create our CPT
*/
 
function appnotification_post_type() {
 
    $labels = array(
        'name'                => _x( 'App Notification', 'Post Type General Name' ),
        'singular_name'       => _x( 'App Notification', 'Post Type Singular Name' ),
        'menu_name'           => __( 'App Notification' ),
        'parent_item_colon'   => __( 'Parent App Notification'),
        'all_items'           => __( 'All App Notifications' ),
        'view_item'           => __( 'View App Notification' ),
        'add_new_item'        => __( 'Add New App Notification' ),
        'add_new'             => __( 'Add New'  ),
        'edit_item'           => __( 'Edit App Notification' ),
        'update_item'         => __( 'Update App Notification' ),
        'search_items'        => __( 'Search App Notification' ),
        'not_found'           => __( 'Not Found' ),
        'not_found_in_trash'  => __( 'Not found in Trash' ),
    );
     
     
    $args = array(
        'label'               => __( 'app-notification'),
        'description'         => __( 'App Notification' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'revisions' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'menu_icon'   => 'dashicons-bell',
        'show_in_rest' => true,
 
    );
     
    register_post_type( 'app-notification', $args );
 
}
 

 
add_action( 'init', 'appnotification_post_type');


function apple_push_notification($details, $ios_token, $ios_message,$title="Vennel") {

  error_reporting(E_ALL ^ E_WARNING);
  $url = "https://fcm.googleapis.com/fcm/send";
  $token = "$ios_token";
  $serverKey = 'AAAA9B5vqZs:APA91bF40rwhvZ1vEjboQh_ETwdXH1QjPSQMB7RgI36ZImcQ_2xyZFX8LiNo5odYlkofBdaJiISEYpjaZuQ_LSW597XhfdyTDtWb6TlPqkE-FSIwwMt3a1XnQQpxf1cvyCNUPVE1lCUY';
  //$title = "Green Button";
  $body = "$ios_message";
  $data['data'] = $details;
  $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '0');
  $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high', 'data' => $data);
  $json = json_encode($arrayToSend);
  $headers = array();
  $headers[] = 'Content-Type: application/json';
  $headers[] = 'Authorization: key=' . $serverKey;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST,
          "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //Send the request
  $response = curl_exec($ch);
  //print_r($response);
  //Close request
  //if ($response === FALSE) {
  //die('FCM Send Error: ' . curl_error($ch));
  //}
  curl_close($ch);
  
  
}
  
function android_push_notification($payload, $tokens) {
  

  $data = json_encode($payload);
  //FCM API end-point
  $url = 'https://fcm.googleapis.com/fcm/send';
  //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
  $server_key = 'AAAA9B5vqZs:APA91bF40rwhvZ1vEjboQh_ETwdXH1QjPSQMB7RgI36ZImcQ_2xyZFX8LiNo5odYlkofBdaJiISEYpjaZuQ_LSW597XhfdyTDtWb6TlPqkE-FSIwwMt3a1XnQQpxf1cvyCNUPVE1lCUY';
  //header with content_type api key
  $headers = array(
      'Content-Type:application/json',
      'Authorization:key='.$server_key
  );
  //CURL request to route notification to FCM connection server (provided by Google)
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $result = curl_exec($ch);
  if ($result === FALSE) {
      die('Oops! FCM Send Error: ' . curl_error($ch));
  }
  curl_close($ch);
  //print_r($tokens);

  // {
  //   "message":{
  //     "token":"bk3RNwTe3H0:CI2k_HHwgIpoDKCIZvvDMExUdFQ3P1...",
  //     "notification":{
  //       "title":"Portugal vs. Denmark",
  //       "body":"great match!"
  //     }
  //   }
  // }
  //$dt['token'] = $tokens;
  // $dt['notification']->title="Portugal vs. Denmark";
  // $dt['notification']->body="great match!";
  //$dt['message']->data->title="great match!";
  //echo json_encode($dt);
  // $data1 = $payload;
  // $target = $tokens;
  
  // $url = 'https://fcm.googleapis.com/fcm/send';
  // $server_key = 'AAAA9B5vqZs:APA91bF40rwhvZ1vEjboQh_ETwdXH1QjPSQMB7RgI36ZImcQ_2xyZFX8LiNo5odYlkofBdaJiISEYpjaZuQ_LSW597XhfdyTDtWb6TlPqkE-FSIwwMt3a1XnQQpxf1cvyCNUPVE1lCUY';
  
  // $fields = array();
  // $fields['data']['data'] = $data1;
  
  
  // if (is_array($target)) {
  //     $fields['registration_ids'] = $target;
  // } else {
  //     $fields['to'] = $target;
  // }
  
  
  // $headers = array(
  //     'Content-Type:application/json',
  //     'Authorization:key=' . $server_key
  // );
  
  
  
  // $ch = curl_init();
  
  // curl_setopt($ch, CURLOPT_URL, $url);
  
  // curl_setopt($ch, CURLOPT_POST, true);
  
  
  // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  
  // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
  // $result = curl_exec($ch);
  // print_r($result);exit;
  // if ($result === FALSE) {
  //   die('FCM Send Error: ' . curl_error($ch));
  //   } 
  // curl_close($ch);
}


add_action( 'transition_post_status', function ( $new_status, $old_status, $post )
{
    if( 'publish' == $new_status &&  $post->post_type == 'app-notification' ) {
      global $wpdb;
      $wpdb_prefix = $wpdb->prefix;
      $wpdb_tablename = $wpdb_prefix.'device_tokens';
      $result = $wpdb->get_results("SELECT * FROM $wpdb_tablename");
    
      if(!empty($result))
      {
        foreach($result as $r)
        {
          //echo '<pre>';print_r($r);echo '</pre>';
          $alert = 'New post added';
          if($r->device_type==1)
          {
            /// Android notifications ////
            $payload = array(
              "to" => $r->device_token,
              "notification"=>array(
                "title" => $post->post_title,
                "body"=> $post->post_content,
                "icon" => "ic_launcher"
              )
            );
            //print_r($payload);exit;
            android_push_notification($payload, $r->device_token);
          }else if($r->device_type==2){
            $details['posts']=1;
            apple_push_notification($details, $r->device_token, $alert);
          }
        }
      }
    }
}, 10, 3 ); 



?>