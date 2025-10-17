<?php
/**
 * Template para Posts Individuales
 * 
 * Se usa para mostrar un post/entrada individual del blog
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
                
                <!-- Header del post -->
                <header class="entry-header">
                    
                    <!-- Categorías -->
                    <?php if ( has_category() ) : ?>
                        <div class="entry-categories">
                            <?php the_category( ', ' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Título -->
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    
                    <!-- Meta información -->
                    <div class="entry-meta">
                        <span class="meta-item posted-on">
                            <i class="far fa-calendar"></i>
                            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </span>
                        
                        <span class="meta-item byline">
                            <i class="far fa-user"></i>
                            <span class="author vcard">
                                <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                    <?php echo esc_html( get_the_author() ); ?>
                                </a>
                            </span>
                        </span>
                        
                        <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                            <span class="meta-item comments-link">
                                <i class="far fa-comments"></i>
                                <?php
                                comments_popup_link(
                                    __( '0 Comentarios', 'eventstream' ),
                                    __( '1 Comentario', 'eventstream' ),
                                    __( '% Comentarios', 'eventstream' )
                                );
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                </header>
                
                <!-- Imagen destacada -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-featured-image">
                        <?php the_post_thumbnail( 'event-large' ); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Contenido del post -->
                <div class="entry-content">
                    <?php
                    the_content();
                    
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Páginas:', 'eventstream' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>
                
                <!-- Footer del post: Tags y enlaces de edición -->
                <footer class="entry-footer">
                    <?php if ( has_tag() ) : ?>
                        <div class="post-tags">
                            <i class="fas fa-tags"></i>
                            <?php the_tags( '', ', ' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php
                    edit_post_link(
                        __( 'Editar', 'eventstream' ),
                        '<span class="edit-link">',
                        '</span>'
                    );
                    ?>
                </footer>
                
            </article>
            
            <!-- Navegación entre posts -->
            <nav class="post-navigation" aria-label="<?php esc_attr_e( 'Navegación de Posts', 'eventstream' ); ?>">
                <div class="nav-links">
                    <?php
                    previous_post_link( '<div class="nav-previous">%link</div>', '<i class="fas fa-arrow-left"></i> %title' );
                    next_post_link( '<div class="nav-next">%link</div>', '%title <i class="fas fa-arrow-right"></i>' );
                    ?>
                </div>
            </nav>
            
            <?php
            // Comentarios
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
            
        <?php endwhile; ?>
        
    </div>
</div>

<?php
get_footer();

