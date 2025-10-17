<?php
/**
 * Footer Template
 * 
 * Contiene el footer del sitio y cierra los tags HTML
 * Se incluye al final de cada página con get_footer()
 * 
 * @package EventStream
 * @version 1.0.0
 */
?>

    </div><!-- #content -->
    
    <!-- FOOTER DEL SITIO -->
    <footer class="site-footer" role="contentinfo">
        <div class="container">
            
            <!-- Área de widgets del footer -->
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
                <div class="footer-content">
                    
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar( 'footer-1' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar( 'footer-2' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar( 'footer-3' ); ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
            <?php endif; ?>
            
            <!-- Menú del footer -->
            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Menú Footer', 'eventstream' ); ?>">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ) );
                    ?>
                </nav>
            <?php endif; ?>
            
            <!-- Información de copyright -->
            <div class="site-info">
                <p>
                    &copy; <?php echo date( 'Y' ); ?> 
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                    <?php _e( '- Todos los derechos reservados', 'eventstream' ); ?>
                </p>
                <p class="theme-credit">
                    <?php
                    printf(
                        /* translators: %s: Nombre del tema */
                        __( 'Tema: %s', 'eventstream' ),
                        '<a href="https://github.com/yanelyapura" rel="designer">EventStream</a>'
                    );
                    ?>
                    <?php _e( 'por', 'eventstream' ); ?> 
                    <a href="https://github.com/yanelyapura" rel="author">Yanel Yapura</a>
                </p>
            </div>
            
        </div>
    </footer>
    
</div><!-- #page -->

<?php wp_footer(); // Hook crítico de WordPress - carga scripts, etc. ?>

</body>
</html>

