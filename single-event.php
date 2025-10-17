<?php
/**
 * Template para Evento Individual
 * 
 * Muestra los detalles completos de un evento
 * 
 * @package EventStream
 * @version 1.0.0
 */

get_header();
?>

<div class="site-content">
    
    <?php
    while ( have_posts() ) :
        the_post();
        
        // Obtener meta data del evento
        $event_date = get_post_meta( get_the_ID(), '_event_date', true );
        $event_time = get_post_meta( get_the_ID(), '_event_time', true );
        $event_location = get_post_meta( get_the_ID(), '_event_location', true );
        $event_speaker = get_post_meta( get_the_ID(), '_event_speaker', true );
        $event_video_url = get_post_meta( get_the_ID(), '_event_video_url', true );
        ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-event' ); ?>>
            
            <!-- Header del evento con imagen de fondo -->
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="event-header" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'event-large' ) ); ?>');">
                    <div class="event-header-overlay">
                        <div class="container">
                            <div class="event-header-content">
                                
                                <!-- Categorías -->
                                <?php
                                $categories = get_the_terms( get_the_ID(), 'event_category' );
                                if ( $categories && ! is_wp_error( $categories ) ) :
                                    ?>
                                    <div class="event-categories">
                                        <?php foreach ( $categories as $category ) : ?>
                                            <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="event-category-badge">
                                                <?php echo esc_html( $category->name ); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Título -->
                                <h1 class="event-title"><?php the_title(); ?></h1>
                                
                                <!-- Meta información destacada -->
                                <div class="event-meta-primary">
                                    <?php if ( $event_date ) : ?>
                                        <span class="meta-item">
                                            <i class="far fa-calendar"></i>
                                            <?php echo date_i18n( 'l, j \d\e F \d\e Y', strtotime( $event_date ) ); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ( $event_time ) : ?>
                                        <span class="meta-item">
                                            <i class="far fa-clock"></i>
                                            <?php echo esc_html( $event_time ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Contenido del evento -->
            <div class="container">
                <div class="event-content-wrapper">
                    
                    <!-- Columna principal -->
                    <div class="event-main-content">
                        
                        <!-- Video del evento (si existe) -->
                        <?php if ( $event_video_url ) : ?>
                            <div class="event-video-section">
                                <h2>
                                    <i class="fas fa-play-circle"></i>
                                    <?php _e( 'Ver Evento', 'eventstream' ); ?>
                                </h2>
                                <?php echo eventstream_render_video_embed( $event_video_url ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Descripción del evento -->
                        <div class="event-description">
                            <h2><?php _e( 'Acerca del Evento', 'eventstream' ); ?></h2>
                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- Sidebar con información adicional -->
                    <aside class="event-sidebar">
                        
                        <!-- Card de información del evento -->
                        <div class="event-info-card">
                            <h3><?php _e( 'Información del Evento', 'eventstream' ); ?></h3>
                            
                            <div class="info-items">
                                <?php if ( $event_date ) : ?>
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="far fa-calendar"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong><?php _e( 'Fecha', 'eventstream' ); ?></strong>
                                            <p><?php echo date_i18n( 'l, j \d\e F \d\e Y', strtotime( $event_date ) ); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( $event_time ) : ?>
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="far fa-clock"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong><?php _e( 'Hora', 'eventstream' ); ?></strong>
                                            <p><?php echo esc_html( $event_time ); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( $event_location ) : ?>
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong><?php _e( 'Ubicación', 'eventstream' ); ?></strong>
                                            <p><?php echo esc_html( $event_location ); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( $event_speaker ) : ?>
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <div class="info-content">
                                            <strong><?php _e( 'Ponente', 'eventstream' ); ?></strong>
                                            <p><?php echo esc_html( $event_speaker ); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="event-actions">
                                <button class="btn btn-primary btn-block" onclick="window.print();">
                                    <i class="fas fa-print"></i>
                                    <?php _e( 'Imprimir', 'eventstream' ); ?>
                                </button>
                                
                                <button class="btn btn-outline btn-block" onclick="navigator.share ? navigator.share({title: '<?php echo esc_js( get_the_title() ); ?>', url: '<?php echo esc_js( get_permalink() ); ?>'}) : alert('Comparte esta URL: <?php echo esc_js( get_permalink() ); ?>');">
                                    <i class="fas fa-share-alt"></i>
                                    <?php _e( 'Compartir', 'eventstream' ); ?>
                                </button>
                            </div>
                            
                        </div>
                        
                        <!-- Categorías -->
                        <?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
                            <div class="event-categories-widget">
                                <h3><?php _e( 'Categorías', 'eventstream' ); ?></h3>
                                <div class="category-list">
                                    <?php foreach ( $categories as $category ) : ?>
                                        <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category-link">
                                            <i class="fas fa-tag"></i>
                                            <?php echo esc_html( $category->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    </aside>
                    
                </div>
                
                <!-- Navegación entre eventos -->
                <nav class="post-navigation" aria-label="<?php esc_attr_e( 'Navegación de Eventos', 'eventstream' ); ?>">
                    <div class="nav-links">
                        <?php
                        previous_post_link( '<div class="nav-previous">%link</div>', '<i class="fas fa-arrow-left"></i> %title', true, '', 'event_category' );
                        next_post_link( '<div class="nav-next">%link</div>', '%title <i class="fas fa-arrow-right"></i>', true, '', 'event_category' );
                        ?>
                    </div>
                </nav>
                
            </div>
            
        </article>
        
    <?php endwhile; ?>
    
</div>

<style>
/* Estilos para evento individual */
.single-event {
    margin-bottom: 3rem;
}

.event-header {
    position: relative;
    background-size: cover;
    background-position: center;
    min-height: 400px;
    display: flex;
    align-items: center;
}

.event-header-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
    display: flex;
    align-items: flex-end;
    padding: 3rem 0;
}

.event-header-content {
    color: var(--white);
}

.event-title {
    color: var(--white);
    font-size: 2.5rem;
    margin: 1rem 0;
}

.event-category-badge {
    display: inline-block;
    background-color: var(--primary-color);
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    margin-right: 0.5rem;
}

.event-meta-primary {
    display: flex;
    gap: 2rem;
    font-size: 1.1rem;
    color: var(--white);
}

.event-meta-primary .meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.event-content-wrapper {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
    margin: 3rem 0;
}

.event-main-content {
    min-width: 0;
}

.event-video-section,
.event-description {
    margin-bottom: 3rem;
}

.event-video-section h2,
.event-description h2 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.event-info-card,
.event-categories-widget {
    background-color: var(--bg-light);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius-lg);
    padding: 2rem;
    margin-bottom: 2rem;
}

.event-info-card h3,
.event-categories-widget h3 {
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
}

.info-items {
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.info-item:last-child {
    border-bottom: none;
}

.info-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background-color: var(--primary-color);
    color: var(--white);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-content strong {
    display: block;
    margin-bottom: 0.25rem;
}

.info-content p {
    margin: 0;
    color: var(--text-light);
}

.event-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.btn-block {
    width: 100%;
    text-align: center;
}

.category-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.category-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background-color: var(--white);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    color: var(--text-color);
    text-decoration: none;
    transition: var(--transition);
}

.category-link:hover {
    background-color: var(--primary-color);
    color: var(--white);
    border-color: var(--primary-color);
    text-decoration: none;
}

@media (max-width: 968px) {
    .event-content-wrapper {
        grid-template-columns: 1fr;
    }
    
    .event-sidebar {
        order: -1;
    }
    
    .event-title {
        font-size: 2rem;
    }
    
    .event-meta-primary {
        flex-direction: column;
        gap: 0.5rem;
    }
}

@media (max-width: 768px) {
    .event-header {
        min-height: 300px;
    }
    
    .event-title {
        font-size: 1.75rem;
    }
}
</style>

<?php
get_footer();

