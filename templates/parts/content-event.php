<?php
/**
 * Template Part: Event Content
 * 
 * Muestra el contenido de un evento individual
 * Se puede incluir con: get_template_part( 'templates/parts/content', 'event' );
 * 
 * @package EventStream
 * @version 1.0.0
 */

// Obtener meta data del evento
$event_date = get_post_meta( get_the_ID(), '_event_date', true );
$event_time = get_post_meta( get_the_ID(), '_event_time', true );
$event_location = get_post_meta( get_the_ID(), '_event_location', true );
$event_speaker = get_post_meta( get_the_ID(), '_event_speaker', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'event-item' ); ?>>
    
    <!-- Thumbnail -->
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="event-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'event-thumbnail' ); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="event-content">
        
        <!-- Título -->
        <h3 class="event-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>
        
        <!-- Meta información -->
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
        </div>
        
        <!-- Excerpt -->
        <div class="event-excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <!-- Botón -->
        <a href="<?php the_permalink(); ?>" class="btn btn-outline">
            <?php _e( 'Ver Detalles', 'eventstream' ); ?>
        </a>
        
    </div>
    
</article>

