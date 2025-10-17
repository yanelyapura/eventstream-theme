<?php
/**
 * Template para Archivo de Eventos
 * 
 * Muestra la lista de todos los eventos
 * URL: sitio.com/eventos/
 * 
 * @package EventStream
 * @version 1.0.0
 */

get_header();
?>

<div class="site-content">
    <div class="container">
        
        <!-- Header del archivo -->
        <header class="page-header text-center">
            <h1 class="page-title">
                <i class="fas fa-calendar-alt"></i>
                <?php _e( 'Eventos', 'eventstream' ); ?>
            </h1>
            <?php
            $description = get_the_archive_description();
            if ( $description ) :
                ?>
                <div class="archive-description">
                    <?php echo wp_kses_post( $description ); ?>
                </div>
            <?php endif; ?>
        </header>
        
        <!-- Filtros de categorías de eventos -->
        <?php
        $event_categories = get_terms( array(
            'taxonomy'   => 'event_category',
            'hide_empty' => true,
        ) );
        
        if ( ! empty( $event_categories ) && ! is_wp_error( $event_categories ) ) :
            ?>
            <div class="event-filters">
                <div class="filter-label">
                    <i class="fas fa-filter"></i>
                    <?php _e( 'Filtrar por categoría:', 'eventstream' ); ?>
                </div>
                <div class="filter-buttons">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="filter-btn <?php echo ! is_tax() ? 'active' : ''; ?>">
                        <?php _e( 'Todos', 'eventstream' ); ?>
                    </a>
                    <?php foreach ( $event_categories as $category ) : ?>
                        <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="filter-btn <?php echo is_tax( 'event_category', $category->term_id ) ? 'active' : ''; ?>">
                            <?php echo esc_html( $category->name ); ?>
                            <span class="count">(<?php echo $category->count; ?>)</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ( have_posts() ) : ?>
            
            <!-- Grid de eventos -->
            <div class="events-grid">
                
                <?php
                while ( have_posts() ) :
                    the_post();
                    
                    // Obtener meta data del evento
                    $event_date = get_post_meta( get_the_ID(), '_event_date', true );
                    $event_time = get_post_meta( get_the_ID(), '_event_time', true );
                    $event_location = get_post_meta( get_the_ID(), '_event_location', true );
                    $event_speaker = get_post_meta( get_the_ID(), '_event_speaker', true );
                    ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'event-card' ); ?>>
                        
                        <!-- Imagen del evento -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="event-card-image-wrapper">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'event-thumbnail', array( 'class' => 'event-card-image' ) ); ?>
                                </a>
                                
                                <!-- Fecha en badge sobre la imagen -->
                                <?php if ( $event_date ) : ?>
                                    <div class="event-date-badge">
                                        <span class="day"><?php echo date_i18n( 'd', strtotime( $event_date ) ); ?></span>
                                        <span class="month"><?php echo date_i18n( 'M', strtotime( $event_date ) ); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="event-card-content">
                            
                            <!-- Categorías -->
                            <?php
                            $categories = get_the_terms( get_the_ID(), 'event_category' );
                            if ( $categories && ! is_wp_error( $categories ) ) :
                                ?>
                                <div class="event-categories">
                                    <?php foreach ( $categories as $category ) : ?>
                                        <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="event-category-tag">
                                            <?php echo esc_html( $category->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Título -->
                            <h2 class="event-card-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <!-- Meta información del evento -->
                            <div class="event-meta">
                                <?php if ( $event_date ) : ?>
                                    <span class="event-meta-item">
                                        <i class="far fa-calendar"></i>
                                        <?php echo date_i18n( 'j \d\e F, Y', strtotime( $event_date ) ); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ( $event_time ) : ?>
                                    <span class="event-meta-item">
                                        <i class="far fa-clock"></i>
                                        <?php echo esc_html( $event_time ); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ( $event_location ) : ?>
                                    <span class="event-meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php echo esc_html( $event_location ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Ponente -->
                            <?php if ( $event_speaker ) : ?>
                                <div class="event-speaker">
                                    <i class="fas fa-user-tie"></i>
                                    <strong><?php _e( 'Ponente:', 'eventstream' ); ?></strong>
                                    <?php echo esc_html( $event_speaker ); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Excerpt -->
                            <div class="event-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <!-- Botón ver más -->
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                <?php _e( 'Ver Detalles', 'eventstream' ); ?>
                                <i class="fas fa-arrow-right"></i>
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
            
            <!-- Si no hay eventos -->
            <div class="no-results">
                <i class="fas fa-calendar-times" style="font-size: 4rem; color: var(--text-light); margin-bottom: 1rem;"></i>
                <h2><?php _e( 'No hay eventos disponibles', 'eventstream' ); ?></h2>
                <p><?php _e( 'Actualmente no hay eventos programados. Vuelve pronto para ver las próximas actividades.', 'eventstream' ); ?></p>
            </div>
            
        <?php endif; ?>
        
    </div>
</div>

<style>
/* Estilos específicos para archivo de eventos */
.event-filters {
    margin: 2rem 0;
    padding: 1.5rem;
    background-color: var(--bg-light);
    border-radius: var(--border-radius-lg);
}

.filter-label {
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.5rem 1rem;
    background-color: var(--white);
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius);
    text-decoration: none;
    color: var(--text-color);
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.filter-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    text-decoration: none;
}

.filter-btn.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: var(--white);
}

.filter-btn .count {
    font-size: 0.85em;
    opacity: 0.8;
}

.event-date-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background-color: var(--primary-color);
    color: var(--white);
    padding: 0.75rem;
    border-radius: var(--border-radius);
    text-align: center;
    box-shadow: var(--shadow-md);
}

.event-date-badge .day {
    display: block;
    font-size: 1.5rem;
    font-weight: bold;
    line-height: 1;
}

.event-date-badge .month {
    display: block;
    font-size: 0.75rem;
    text-transform: uppercase;
    margin-top: 0.25rem;
}

.event-card-image-wrapper {
    position: relative;
    overflow: hidden;
}

.event-categories {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 0.75rem;
}

.event-category-tag {
    font-size: 0.75rem;
    background-color: var(--bg-light);
    color: var(--primary-color);
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 600;
}

.event-category-tag:hover {
    background-color: var(--primary-color);
    color: var(--white);
    text-decoration: none;
}

.event-speaker {
    font-size: 0.9rem;
    color: var(--text-light);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .filter-buttons {
        flex-direction: column;
    }
    
    .filter-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<?php
get_footer();

