<?php
/**
 * EventStream Theme Functions
 * 
 * Archivo principal de funciones del tema
 * Aquí se configuran todas las características y funcionalidades del tema
 * 
 * @package EventStream
 * @version 1.0.0
 */

// Prevenir acceso directo al archivo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * CONSTANTES DEL TEMA
 * Define rutas útiles para el tema
 */
define( 'EVENTSTREAM_VERSION', '1.0.0' );
define( 'EVENTSTREAM_THEME_DIR', get_template_directory() );
define( 'EVENTSTREAM_THEME_URI', get_template_directory_uri() );

/**
 * CONFIGURACIÓN INICIAL DEL TEMA
 * Esta función se ejecuta después de que WordPress se inicializa
 * Hook: after_setup_theme
 */
function eventstream_setup() {
    
    // Habilitar traducción del tema
    load_theme_textdomain( 'eventstream', get_template_directory() . '/languages' );
    
    // Agregar soporte para título dinámico (WordPress manage el <title>)
    add_theme_support( 'title-tag' );
    
    // Agregar soporte para imágenes destacadas (Featured Images)
    add_theme_support( 'post-thumbnails' );
    
    // Definir tamaños de imagen personalizados
    add_image_size( 'event-thumbnail', 400, 300, true );  // Para tarjetas de eventos
    add_image_size( 'event-large', 1200, 600, true );     // Para headers de eventos
    
    // Registrar menús de navegación
    register_nav_menus( array(
        'primary' => __( 'Menú Principal', 'eventstream' ),
        'footer'  => __( 'Menú Footer', 'eventstream' ),
    ) );
    
    // Agregar soporte para HTML5 en formularios y comentarios
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );
    
    // Agregar soporte para logo personalizado
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    
    // Agregar soporte para refresh selectivo en el Customizer
    add_theme_support( 'customize-selective-refresh-widgets' );
    
    // Agregar soporte para colores de fondo personalizados
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );
    
    // Agregar soporte para editor de bloques de Gutenberg
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    
    // Soporte para oEmbed (embeddings automáticos de YouTube, Vimeo, etc)
    add_theme_support( 'embed' );
}
add_action( 'after_setup_theme', 'eventstream_setup' );

/**
 * REGISTRAR Y ENCOLAR ESTILOS
 * Carga los archivos CSS del tema
 */
function eventstream_enqueue_styles() {
    // Estilo principal del tema (style.css)
    wp_enqueue_style( 
        'eventstream-style', 
        get_stylesheet_uri(), 
        array(), 
        EVENTSTREAM_VERSION 
    );
    
    // Estilos adicionales personalizados
    wp_enqueue_style( 
        'eventstream-main', 
        get_template_directory_uri() . '/assets/css/main.css', 
        array( 'eventstream-style' ), 
        EVENTSTREAM_VERSION 
    );
    
    // Font Awesome para íconos (CDN)
    wp_enqueue_style( 
        'font-awesome', 
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', 
        array(), 
        '6.4.0' 
    );
}
add_action( 'wp_enqueue_scripts', 'eventstream_enqueue_styles' );

/**
 * REGISTRAR Y ENCOLAR SCRIPTS
 * Carga los archivos JavaScript del tema
 */
function eventstream_enqueue_scripts() {
    // jQuery (WordPress ya lo incluye)
    // No es necesario encolarlo, pero aseguramos que está disponible
    
    // Script principal del tema
    wp_enqueue_script( 
        'eventstream-main', 
        get_template_directory_uri() . '/assets/js/main.js', 
        array( 'jquery' ), 
        EVENTSTREAM_VERSION, 
        true // Cargar en el footer
    );
    
    // Script para manejo de video streaming
    wp_enqueue_script( 
        'eventstream-video', 
        get_template_directory_uri() . '/assets/js/video-player.js', 
        array( 'jquery' ), 
        EVENTSTREAM_VERSION, 
        true 
    );
    
    // Video.js para player de video HTML5
    wp_enqueue_style( 
        'videojs-css', 
        'https://vjs.zencdn.net/8.6.1/video-js.css', 
        array(), 
        '8.6.1' 
    );
    
    wp_enqueue_script( 
        'videojs', 
        'https://vjs.zencdn.net/8.6.1/video.min.js', 
        array(), 
        '8.6.1', 
        true 
    );
    
    // Pasar datos de PHP a JavaScript
    wp_localize_script( 'eventstream-main', 'eventstreamData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'eventstream-nonce' ),
        'strings' => array(
            'loading' => __( 'Cargando...', 'eventstream' ),
            'error'   => __( 'Ha ocurrido un error', 'eventstream' ),
        ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'eventstream_enqueue_scripts' );

/**
 * REGISTRAR ÁREAS DE WIDGETS (SIDEBARS)
 * Define áreas donde se pueden agregar widgets
 */
function eventstream_widgets_init() {
    // Sidebar principal
    register_sidebar( array(
        'name'          => __( 'Sidebar Principal', 'eventstream' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Aparece en el lateral de las páginas', 'eventstream' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    // Footer - Columna 1
    register_sidebar( array(
        'name'          => __( 'Footer - Columna 1', 'eventstream' ),
        'id'            => 'footer-1',
        'description'   => __( 'Primera columna del footer', 'eventstream' ),
        'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    // Footer - Columna 2
    register_sidebar( array(
        'name'          => __( 'Footer - Columna 2', 'eventstream' ),
        'id'            => 'footer-2',
        'description'   => __( 'Segunda columna del footer', 'eventstream' ),
        'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    // Footer - Columna 3
    register_sidebar( array(
        'name'          => __( 'Footer - Columna 3', 'eventstream' ),
        'id'            => 'footer-3',
        'description'   => __( 'Tercera columna del footer', 'eventstream' ),
        'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'eventstream_widgets_init' );

/**
 * INCLUIR ARCHIVOS ADICIONALES
 * Carga archivos de funcionalidades específicas
 */
require_once EVENTSTREAM_THEME_DIR . '/inc/custom-post-types.php';  // Custom Post Types
require_once EVENTSTREAM_THEME_DIR . '/inc/widgets.php';             // Widgets personalizados
require_once EVENTSTREAM_THEME_DIR . '/inc/video-integration.php';   // Integración de video

/**
 * PERSONALIZACIÓN DEL EXCERPT (RESUMEN)
 * Cambia la longitud y el texto "Leer más"
 */
function eventstream_excerpt_length( $length ) {
    return 30; // Número de palabras
}
add_filter( 'excerpt_length', 'eventstream_excerpt_length' );

function eventstream_excerpt_more( $more ) {
    return '... <a class="read-more" href="' . get_permalink() . '">' . __( 'Leer más', 'eventstream' ) . '</a>';
}
add_filter( 'excerpt_more', 'eventstream_excerpt_more' );

/**
 * AGREGAR CLASES AL BODY
 * Añade clases CSS útiles al tag <body>
 */
function eventstream_body_classes( $classes ) {
    // Agregar clase si no hay sidebar
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }
    
    // Agregar clase para el tipo de post
    if ( is_singular() ) {
        $classes[] = 'singular';
    }
    
    return $classes;
}
add_filter( 'body_class', 'eventstream_body_classes' );

/**
 * CUSTOMIZER: OPCIONES DE PERSONALIZACIÓN
 * Agrega opciones al WordPress Customizer
 */
function eventstream_customize_register( $wp_customize ) {
    
    // Sección: Opciones de Video Streaming
    $wp_customize->add_section( 'eventstream_video_section', array(
        'title'    => __( 'Opciones de Video Streaming', 'eventstream' ),
        'priority' => 130,
    ) );
    
    // Setting: URL de video en vivo
    $wp_customize->add_setting( 'eventstream_live_video_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'eventstream_live_video_url', array(
        'label'       => __( 'URL del Video en Vivo', 'eventstream' ),
        'description' => __( 'Ingresa la URL de YouTube o Vimeo', 'eventstream' ),
        'section'     => 'eventstream_video_section',
        'type'        => 'url',
    ) );
    
    // Setting: Mostrar badge "EN VIVO"
    $wp_customize->add_setting( 'eventstream_show_live_badge', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    
    $wp_customize->add_control( 'eventstream_show_live_badge', array(
        'label'   => __( 'Mostrar Badge "EN VIVO"', 'eventstream' ),
        'section' => 'eventstream_video_section',
        'type'    => 'checkbox',
    ) );
    
    // Sección: Colores del Tema
    $wp_customize->add_section( 'eventstream_colors_section', array(
        'title'    => __( 'Colores del Tema', 'eventstream' ),
        'priority' => 131,
    ) );
    
    // Setting: Color primario
    $wp_customize->add_setting( 'eventstream_primary_color', array(
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eventstream_primary_color', array(
        'label'   => __( 'Color Primario', 'eventstream' ),
        'section' => 'eventstream_colors_section',
    ) ) );
}
add_action( 'customize_register', 'eventstream_customize_register' );

/**
 * AGREGAR CSS PERSONALIZADO DEL CUSTOMIZER
 */
function eventstream_customizer_css() {
    $primary_color = get_theme_mod( 'eventstream_primary_color', '#2563eb' );
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr( $primary_color ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'eventstream_customizer_css' );

/**
 * FUNCIÓN HELPER: OBTENER URL DE VIDEO EMBEBIDO
 * Convierte URLs de YouTube/Vimeo a URLs de embed
 */
function eventstream_get_embed_url( $url ) {
    // YouTube
    if ( strpos( $url, 'youtube.com' ) !== false || strpos( $url, 'youtu.be' ) !== false ) {
        preg_match( '/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches );
        if ( isset( $matches[1] ) ) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        // Para URLs cortas de youtu.be
        preg_match( '/youtu\\.be\\/([^\\?\\&]+)/', $url, $matches );
        if ( isset( $matches[1] ) ) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
    }
    
    // Vimeo
    if ( strpos( $url, 'vimeo.com' ) !== false ) {
        preg_match( '/vimeo\\.com\\/(\\d+)/', $url, $matches );
        if ( isset( $matches[1] ) ) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }
    }
    
    return $url;
}

/**
 * SEGURIDAD: Limpiar wp_head
 * Remueve información innecesaria del header
 */
remove_action( 'wp_head', 'wp_generator' ); // Remueve versión de WordPress
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );

/**
 * FUNCIÓN HELPER: Verificar si es una página de evento
 */
function eventstream_is_event_page() {
    return is_singular( 'event' ) || is_post_type_archive( 'event' );
}

/**
 * FIN DEL ARCHIVO
 * Punto de entrada para hooks y filtros adicionales
 */

