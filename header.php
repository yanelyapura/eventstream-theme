<?php
/**
 * Header Template
 * 
 * Contiene el <head> y el header del sitio (logo, menú, etc.)
 * Se incluye al inicio de cada página con get_header()
 * 
 * @package EventStream
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); // Hook crítico de WordPress - carga estilos, scripts, etc. ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); // Hook de WordPress 5.2+ ?>

<div id="page" class="site-container">
    
    <!-- Skip to content para accesibilidad -->
    <a class="skip-link screen-reader-text" href="#content">
        <?php _e( 'Saltar al contenido', 'eventstream' ); ?>
    </a>
    
    <!-- HEADER DEL SITIO -->
    <header class="site-header" role="banner">
        <div class="container">
            <div class="header-content">
                
                <!-- LOGO Y NOMBRE DEL SITIO -->
                <div class="site-branding">
                    <?php
                    // Si hay un logo personalizado, mostrarlo
                    if ( has_custom_logo() ) :
                        the_custom_logo();
                    else :
                        ?>
                        <div class="site-identity">
                            <h1 class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </h1>
                            <?php
                            $description = get_bloginfo( 'description', 'display' );
                            if ( $description || is_customize_preview() ) :
                                ?>
                                <p class="site-description"><?php echo esc_html( $description ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- BOTÓN MENÚ MÓVIL -->
                <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                    <span class="screen-reader-text"><?php _e( 'Menú', 'eventstream' ); ?></span>
                </button>
                
                <!-- NAVEGACIÓN PRINCIPAL -->
                <nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Menú Principal', 'eventstream' ); ?>">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'eventstream_default_menu',
                    ) );
                    ?>
                </nav>
                
            </div>
        </div>
    </header>
    
    <!-- Banner de evento en vivo (si está configurado) -->
    <?php
    $live_video_url = get_theme_mod( 'eventstream_live_video_url' );
    $show_live_badge = get_theme_mod( 'eventstream_show_live_badge', true );
    
    if ( $live_video_url && $show_live_badge && is_front_page() ) :
        ?>
        <div class="live-event-banner">
            <div class="container">
                <div class="live-banner-content">
                    <span class="live-badge">
                        <?php _e( '● EN VIVO', 'eventstream' ); ?>
                    </span>
                    <span class="live-banner-text">
                        <?php _e( 'Transmisión en vivo disponible ahora', 'eventstream' ); ?>
                    </span>
                    <a href="<?php echo esc_url( home_url( '/en-vivo/' ) ); ?>" class="btn btn-secondary">
                        <?php _e( 'Ver Transmisión', 'eventstream' ); ?>
                    </a>
                </div>
            </div>
        </div>
        <style>
            .live-event-banner {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 1rem 0;
                text-align: center;
            }
            .live-banner-content {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 1rem;
                flex-wrap: wrap;
            }
            .live-banner-text {
                color: white;
                font-weight: 600;
            }
            @media (max-width: 768px) {
                .live-banner-content {
                    flex-direction: column;
                    gap: 0.5rem;
                }
            }
        </style>
    <?php endif; ?>
    
    <div id="content" class="site-content">
        <!-- El contenido de la página se insertará aquí -->
<?php
/**
 * Función fallback para el menú
 * Se ejecuta si no hay un menú asignado
 */
function eventstream_default_menu() {
    echo '<ul id="primary-menu">';
    wp_list_pages( array(
        'title_li' => '',
        'depth'    => 1,
    ) );
    echo '</ul>';
}

