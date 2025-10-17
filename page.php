<?php
/**
 * Template para Páginas Estáticas
 * 
 * Se usa para mostrar páginas (no posts)
 * Ejemplo: Página "Acerca de", "Contacto", etc.
 * 
 * @package EventStream
 * @version 1.0.0
 */

get_header();
?>

<div class="site-content">
    <div class="container">
        
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <!-- Imagen destacada -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="page-featured-image">
                        <?php the_post_thumbnail( 'event-large' ); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Título de la página -->
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
                
                <!-- Contenido de la página -->
                <div class="entry-content">
                    <?php
                    the_content();
                    
                    // Paginación para contenido largo con <!--nextpage-->
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Páginas:', 'eventstream' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>
                
                <!-- Footer de la entrada -->
                <?php if ( get_edit_post_link() ) : ?>
                    <footer class="entry-footer">
                        <?php
                        edit_post_link(
                            sprintf(
                                /* translators: %s: Título de la página */
                                __( 'Editar %s', 'eventstream' ),
                                '<span class="screen-reader-text">' . get_the_title() . '</span>'
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                        ?>
                    </footer>
                <?php endif; ?>
                
            </article>
            
            <?php
            // Si los comentarios están abiertos o hay al menos un comentario
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
            
        <?php endwhile; ?>
        
    </div>
</div>

<?php
get_footer();

