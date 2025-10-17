<?php
/**
 * Template Part: Video Player
 * 
 * Muestra un video player responsivo
 * Uso: get_template_part( 'templates/parts/video', 'player' );
 * 
 * Variables esperadas:
 * - $video_url: URL del video
 * - $show_live_badge: (opcional) Mostrar badge "EN VIVO"
 * 
 * @package EventStream
 * @version 1.0.0
 */

// Variables por defecto
if ( ! isset( $video_url ) ) {
    $video_url = '';
}

if ( ! isset( $show_live_badge ) ) {
    $show_live_badge = false;
}

// Si no hay URL, no mostrar nada
if ( empty( $video_url ) ) {
    return;
}

// Convertir URL a URL de embed
$embed_url = eventstream_get_embed_url( $video_url );
?>

<div class="video-player-wrapper">
    <div class="video-container">
        
        <?php if ( $show_live_badge ) : ?>
            <div class="live-badge">
                <?php _e( 'EN VIVO', 'eventstream' ); ?>
            </div>
        <?php endif; ?>
        
        <iframe
            src="<?php echo esc_url( $embed_url ); ?>"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
            loading="lazy"
            title="<?php echo esc_attr( get_the_title() ); ?>"
        ></iframe>
        
    </div>
    
    <div class="video-info">
        <p class="video-description">
            <i class="fas fa-info-circle"></i>
            <?php _e( 'Para una mejor experiencia, visualiza en pantalla completa.', 'eventstream' ); ?>
        </p>
    </div>
</div>

<style>
.video-player-wrapper {
    margin: 2rem 0;
}

.video-info {
    margin-top: 1rem;
    text-align: center;
}

.video-description {
    color: var(--text-light);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
</style>

