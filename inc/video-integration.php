<?php
/**
 * Funciones de Integración de Video
 * 
 * Funciones helper para embeddings de video de YouTube, Vimeo, etc.
 * 
 * @package EventStream
 * @version 1.0.0
 */

// Prevenir acceso directo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * SHORTCODE: [event_video]
 * 
 * Permite insertar videos en posts/páginas usando shortcode
 * Uso: [event_video url="https://youtube.com/watch?v=..."]
 * 
 * @param array $atts Atributos del shortcode
 * @return string HTML del video embebido
 */
function eventstream_video_shortcode( $atts ) {
    // Atributos por defecto
    $atts = shortcode_atts( array(
        'url'    => '',
        'width'  => '100%',
        'height' => 'auto',
        'live'   => 'no',
    ), $atts, 'event_video' );
    
    if ( empty( $atts['url'] ) ) {
        return '<p class="video-error">' . __( 'Por favor proporciona una URL de video.', 'eventstream' ) . '</p>';
    }
    
    $embed_url = eventstream_get_embed_url( $atts['url'] );
    $is_live = ( $atts['live'] === 'yes' || $atts['live'] === 'true' || $atts['live'] === '1' );
    
    ob_start();
    ?>
    <div class="video-container">
        <?php if ( $is_live ) : ?>
            <div class="live-badge">
                <?php _e( 'EN VIVO', 'eventstream' ); ?>
            </div>
        <?php endif; ?>
        
        <iframe
            src="<?php echo esc_url( $embed_url ); ?>"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            loading="lazy"
        ></iframe>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'event_video', 'eventstream_video_shortcode' );

/**
 * DETECTAR TIPO DE VIDEO (YouTube, Vimeo, etc.)
 * 
 * @param string $url URL del video
 * @return string Tipo de video (youtube, vimeo, other)
 */
function eventstream_detect_video_type( $url ) {
    if ( strpos( $url, 'youtube.com' ) !== false || strpos( $url, 'youtu.be' ) !== false ) {
        return 'youtube';
    }
    
    if ( strpos( $url, 'vimeo.com' ) !== false ) {
        return 'vimeo';
    }
    
    return 'other';
}

/**
 * OBTENER ID DE VIDEO DE YOUTUBE
 * 
 * @param string $url URL de YouTube
 * @return string|false ID del video o false si no se encuentra
 */
function eventstream_get_youtube_id( $url ) {
    // URL estándar: https://www.youtube.com/watch?v=VIDEO_ID
    preg_match( '/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches );
    if ( isset( $matches[1] ) ) {
        return $matches[1];
    }
    
    // URL corta: https://youtu.be/VIDEO_ID
    preg_match( '/youtu\\.be\\/([^\\?\\&]+)/', $url, $matches );
    if ( isset( $matches[1] ) ) {
        return $matches[1];
    }
    
    return false;
}

/**
 * OBTENER ID DE VIDEO DE VIMEO
 * 
 * @param string $url URL de Vimeo
 * @return string|false ID del video o false si no se encuentra
 */
function eventstream_get_vimeo_id( $url ) {
    preg_match( '/vimeo\\.com\\/(\\d+)/', $url, $matches );
    if ( isset( $matches[1] ) ) {
        return $matches[1];
    }
    
    return false;
}

/**
 * OBTENER THUMBNAIL DE VIDEO DE YOUTUBE
 * 
 * @param string $video_id ID del video de YouTube
 * @param string $quality Calidad del thumbnail (default, mqdefault, hqdefault, sddefault, maxresdefault)
 * @return string URL del thumbnail
 */
function eventstream_get_youtube_thumbnail( $video_id, $quality = 'hqdefault' ) {
    return "https://img.youtube.com/vi/{$video_id}/{$quality}.jpg";
}

/**
 * OBTENER THUMBNAIL DE VIDEO DE VIMEO
 * 
 * @param string $video_id ID del video de Vimeo
 * @return string|false URL del thumbnail o false si falla
 */
function eventstream_get_vimeo_thumbnail( $video_id ) {
    $api_url = "https://vimeo.com/api/v2/video/{$video_id}.json";
    
    $response = wp_remote_get( $api_url );
    
    if ( is_wp_error( $response ) ) {
        return false;
    }
    
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body );
    
    if ( ! empty( $data[0]->thumbnail_large ) ) {
        return $data[0]->thumbnail_large;
    }
    
    return false;
}

/**
 * FUNCIÓN HELPER: Renderizar video embed responsivo
 * 
 * @param string $url URL del video
 * @param array $args Argumentos adicionales
 * @return string HTML del video embebido
 */
function eventstream_render_video_embed( $url, $args = array() ) {
    $defaults = array(
        'show_live_badge' => false,
        'autoplay'        => false,
        'controls'        => true,
        'class'           => '',
    );
    
    $args = wp_parse_args( $args, $defaults );
    
    $embed_url = eventstream_get_embed_url( $url );
    
    // Agregar parámetros a la URL
    $params = array();
    if ( $args['autoplay'] ) {
        $params[] = 'autoplay=1';
    }
    if ( ! $args['controls'] ) {
        $params[] = 'controls=0';
    }
    
    if ( ! empty( $params ) ) {
        $embed_url .= ( strpos( $embed_url, '?' ) !== false ? '&' : '?' ) . implode( '&', $params );
    }
    
    $class = 'video-container ' . esc_attr( $args['class'] );
    
    ob_start();
    ?>
    <div class="<?php echo $class; ?>">
        <?php if ( $args['show_live_badge'] ) : ?>
            <div class="live-badge">
                <?php _e( 'EN VIVO', 'eventstream' ); ?>
            </div>
        <?php endif; ?>
        
        <iframe
            src="<?php echo esc_url( $embed_url ); ?>"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            loading="lazy"
        ></iframe>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * AGREGAR SOPORTE PARA oEmbed DE YOUTUBE Y VIMEO
 * WordPress ya tiene soporte, pero podemos extenderlo
 */
wp_oembed_add_provider( '#https?://(www\.)?youtube\.com/watch.*#i', 'https://www.youtube.com/oembed', true );
wp_oembed_add_provider( '#https?://(www\.)?youtube\.com/playlist.*#i', 'https://www.youtube.com/oembed', true );
wp_oembed_add_provider( '#https?://youtu\.be/.*#i', 'https://www.youtube.com/oembed', true );
wp_oembed_add_provider( '#https?://(www\.)?vimeo\.com/.*#i', 'https://vimeo.com/api/oembed.json', true );

/**
 * AJAX: Actualizar estado de transmisión en vivo
 * 
 * Permite verificar si una transmisión está en vivo mediante AJAX
 */
function eventstream_check_live_status() {
    // Verificar nonce
    check_ajax_referer( 'eventstream-nonce', 'nonce' );
    
    $video_url = isset( $_POST['video_url'] ) ? esc_url_raw( $_POST['video_url'] ) : '';
    
    if ( empty( $video_url ) ) {
        wp_send_json_error( array( 'message' => __( 'URL de video no proporcionada', 'eventstream' ) ) );
    }
    
    $video_type = eventstream_detect_video_type( $video_url );
    
    // En producción, aquí se haría una llamada a la API de YouTube/Vimeo
    // para verificar si el video está en vivo
    
    $is_live = true; // Placeholder
    
    wp_send_json_success( array(
        'is_live'    => $is_live,
        'video_type' => $video_type,
    ) );
}
add_action( 'wp_ajax_eventstream_check_live_status', 'eventstream_check_live_status' );
add_action( 'wp_ajax_nopriv_eventstream_check_live_status', 'eventstream_check_live_status' );

