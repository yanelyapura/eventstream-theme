<?php
/**
 * Template Principal (Fallback)
 * 
 * Este es el template más importante de WordPress.
 * Se usa cuando no hay un template más específico disponible.
 * Es el "fallback" de la jerarquía de templates de WordPress.
 * 
 * @package EventStream
 * @version 1.0.0
 */

get_header(); // Incluye header.php
?>

<div class="site-content">
    <div class="container">
        <div class="content-area">
            
            <?php if ( have_posts() ) : ?>
                
                <!-- Si estamos en una página de archivo, mostrar el título -->
                <?php if ( is_home() && ! is_front_page() ) : ?>
                    <header class="page-header">
                        <h1 class="page-title"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>
                
                <?php if ( is_archive() ) : ?>
                    <header class="page-header">
                        <?php
                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                        the_archive_description( '<div class="archive-description">', '</div>' );
                        ?>
                    </header>
                <?php endif; ?>
                
                <!-- Grid de posts/eventos -->
                <div class="posts-grid">
                    
                    <?php
                    // The Loop: Ciclo principal de WordPress
                    // Itera sobre todos los posts disponibles
                    while ( have_posts() ) :
                        the_post();
                        ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                            
                            <!-- Imagen destacada -->
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'event-thumbnail', array( 'class' => 'post-card-image' ) ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-card-content">
                                
                                <!-- Categorías -->
                                <?php if ( has_category() ) : ?>
                                    <div class="post-categories">
                                        <?php the_category( ', ' ); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Título -->
                                <h2 class="post-card-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <!-- Meta información: fecha y autor -->
                                <div class="post-meta">
                                    <span class="post-meta-item">
                                        <i class="far fa-calendar"></i>
                                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </span>
                                    <span class="post-meta-item">
                                        <i class="far fa-user"></i>
                                        <?php the_author(); ?>
                                    </span>
                                </div>
                                
                                <!-- Excerpt (resumen) -->
                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <!-- Botón leer más -->
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                                    <?php _e( 'Leer más', 'eventstream' ); ?>
                                </a>
                                
                            </div>
                            
                        </article>
                        
                    <?php endwhile; ?>
                    
                </div>
                
                <!-- Paginación -->
                <div class="pagination">
                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => __( '← Anterior', 'eventstream' ),
                        'next_text' => __( 'Siguiente →', 'eventstream' ),
                    ) );
                    ?>
                </div>
                
            <?php else : ?>
                
                <!-- Si no hay posts -->
                <div class="no-results">
                    <h2><?php _e( 'No se encontraron resultados', 'eventstream' ); ?></h2>
                    <p><?php _e( 'Lo sentimos, no hay contenido disponible en este momento.', 'eventstream' ); ?></p>
                    
                    <?php get_search_form(); ?>
                </div>
                
            <?php endif; ?>
            
        </div>
    </div>
</div>

<?php
get_footer(); // Incluye footer.php

