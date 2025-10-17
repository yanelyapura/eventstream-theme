<?php
/**
 * Custom Post Types
 * 
 * Define tipos de contenido personalizados
 * En este caso: "Eventos" con campos personalizados
 * 
 * @package EventStream
 * @version 1.0.0
 */

// Prevenir acceso directo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * REGISTRAR CUSTOM POST TYPE: EVENTOS
 * 
 * Los Custom Post Types permiten crear tipos de contenido más allá de posts y páginas
 * Son perfectos para eventos, portafolios, productos, testimonios, etc.
 */
function eventstream_register_event_post_type() {
    
    // Labels (etiquetas) para el admin de WordPress
    $labels = array(
        'name'                  => _x( 'Eventos', 'Post type general name', 'eventstream' ),
        'singular_name'         => _x( 'Evento', 'Post type singular name', 'eventstream' ),
        'menu_name'             => _x( 'Eventos', 'Admin Menu text', 'eventstream' ),
        'name_admin_bar'        => _x( 'Evento', 'Add New on Toolbar', 'eventstream' ),
        'add_new'               => __( 'Agregar Nuevo', 'eventstream' ),
        'add_new_item'          => __( 'Agregar Nuevo Evento', 'eventstream' ),
        'new_item'              => __( 'Nuevo Evento', 'eventstream' ),
        'edit_item'             => __( 'Editar Evento', 'eventstream' ),
        'view_item'             => __( 'Ver Evento', 'eventstream' ),
        'all_items'             => __( 'Todos los Eventos', 'eventstream' ),
        'search_items'          => __( 'Buscar Eventos', 'eventstream' ),
        'parent_item_colon'     => __( 'Eventos Padre:', 'eventstream' ),
        'not_found'             => __( 'No se encontraron eventos.', 'eventstream' ),
        'not_found_in_trash'    => __( 'No hay eventos en la papelera.', 'eventstream' ),
        'featured_image'        => _x( 'Imagen del Evento', 'Overrides the "Featured Image" phrase', 'eventstream' ),
        'set_featured_image'    => _x( 'Establecer imagen del evento', 'Overrides the "Set featured image" phrase', 'eventstream' ),
        'remove_featured_image' => _x( 'Remover imagen del evento', 'Overrides the "Remove featured image" phrase', 'eventstream' ),
        'use_featured_image'    => _x( 'Usar como imagen del evento', 'Overrides the "Use as featured image" phrase', 'eventstream' ),
        'archives'              => _x( 'Archivo de Eventos', 'The post type archive label', 'eventstream' ),
        'insert_into_item'      => _x( 'Insertar en evento', 'Overrides the "Insert into post" phrase', 'eventstream' ),
        'uploaded_to_this_item' => _x( 'Subido a este evento', 'Overrides the "Uploaded to this post" phrase', 'eventstream' ),
        'filter_items_list'     => _x( 'Filtrar lista de eventos', 'Screen reader text', 'eventstream' ),
        'items_list_navigation' => _x( 'Navegación de lista de eventos', 'Screen reader text', 'eventstream' ),
        'items_list'            => _x( 'Lista de eventos', 'Screen reader text', 'eventstream' ),
    );
    
    // Argumentos para el Custom Post Type
    $args = array(
        'labels'             => $labels,
        'public'             => true,                // Visible públicamente
        'publicly_queryable' => true,                // Se puede consultar desde el frontend
        'show_ui'            => true,                // Mostrar UI en admin
        'show_in_menu'       => true,                // Mostrar en el menú de admin
        'show_in_rest'       => true,                // Habilitar Gutenberg editor
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'eventos' ), // URL: sitio.com/eventos/nombre-evento
        'capability_type'    => 'post',              // Permisos similares a posts
        'has_archive'        => true,                // Tiene página de archivo
        'hierarchical'       => false,               // No jerárquico (como posts, no como páginas)
        'menu_position'      => 5,                   // Posición en el menú de admin
        'menu_icon'          => 'dashicons-calendar-alt', // Ícono del menú
        'supports'           => array(               // Características soportadas
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'custom-fields',
            'revisions',
        ),
    );
    
    // Registrar el Custom Post Type
    register_post_type( 'event', $args );
}
add_action( 'init', 'eventstream_register_event_post_type' );

/**
 * REGISTRAR TAXONOMÍA PERSONALIZADA: CATEGORÍAS DE EVENTOS
 * 
 * Las taxonomías permiten categorizar el contenido
 * Similar a categorías y tags, pero específicas para eventos
 */
function eventstream_register_event_taxonomy() {
    
    $labels = array(
        'name'              => _x( 'Categorías de Eventos', 'taxonomy general name', 'eventstream' ),
        'singular_name'     => _x( 'Categoría de Evento', 'taxonomy singular name', 'eventstream' ),
        'search_items'      => __( 'Buscar Categorías', 'eventstream' ),
        'all_items'         => __( 'Todas las Categorías', 'eventstream' ),
        'parent_item'       => __( 'Categoría Padre', 'eventstream' ),
        'parent_item_colon' => __( 'Categoría Padre:', 'eventstream' ),
        'edit_item'         => __( 'Editar Categoría', 'eventstream' ),
        'update_item'       => __( 'Actualizar Categoría', 'eventstream' ),
        'add_new_item'      => __( 'Agregar Nueva Categoría', 'eventstream' ),
        'new_item_name'     => __( 'Nombre de Nueva Categoría', 'eventstream' ),
        'menu_name'         => __( 'Categorías', 'eventstream' ),
    );
    
    $args = array(
        'hierarchical'      => true,  // Jerárquica (como categorías)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,  // Mostrar columna en lista de eventos
        'show_in_rest'      => true,  // Habilitar en Gutenberg
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'categoria-evento' ),
    );
    
    // Registrar taxonomía para el post type 'event'
    register_taxonomy( 'event_category', array( 'event' ), $args );
}
add_action( 'init', 'eventstream_register_event_taxonomy' );

/**
 * META BOXES PERSONALIZADOS PARA EVENTOS
 * 
 * Agrega campos personalizados al editor de eventos
 * Ejemplo: Fecha del evento, Hora, Ubicación, Link de video, etc.
 */
function eventstream_add_event_meta_boxes() {
    add_meta_box(
        'event_details',                             // ID del meta box
        __( 'Detalles del Evento', 'eventstream' ),  // Título
        'eventstream_event_details_callback',        // Función callback
        'event',                                     // Post type
        'normal',                                    // Contexto (normal, side, advanced)
        'high'                                       // Prioridad
    );
}
add_action( 'add_meta_boxes', 'eventstream_add_event_meta_boxes' );

/**
 * CALLBACK: Mostrar campos del meta box
 */
function eventstream_event_details_callback( $post ) {
    // Nonce para seguridad
    wp_nonce_field( 'eventstream_save_event_details', 'eventstream_event_details_nonce' );
    
    // Obtener valores existentes
    $event_date = get_post_meta( $post->ID, '_event_date', true );
    $event_time = get_post_meta( $post->ID, '_event_time', true );
    $event_location = get_post_meta( $post->ID, '_event_location', true );
    $event_video_url = get_post_meta( $post->ID, '_event_video_url', true );
    $event_speaker = get_post_meta( $post->ID, '_event_speaker', true );
    
    ?>
    <div class="event-meta-box">
        <style>
            .event-meta-box { padding: 10px 0; }
            .event-field { margin-bottom: 20px; }
            .event-field label { display: block; margin-bottom: 5px; font-weight: bold; }
            .event-field input[type="text"],
            .event-field input[type="date"],
            .event-field input[type="time"],
            .event-field input[type="url"] { width: 100%; max-width: 400px; }
        </style>
        
        <div class="event-field">
            <label for="event_date"><?php _e( 'Fecha del Evento:', 'eventstream' ); ?></label>
            <input type="date" id="event_date" name="event_date" value="<?php echo esc_attr( $event_date ); ?>" />
        </div>
        
        <div class="event-field">
            <label for="event_time"><?php _e( 'Hora del Evento:', 'eventstream' ); ?></label>
            <input type="time" id="event_time" name="event_time" value="<?php echo esc_attr( $event_time ); ?>" />
        </div>
        
        <div class="event-field">
            <label for="event_location"><?php _e( 'Ubicación:', 'eventstream' ); ?></label>
            <input type="text" id="event_location" name="event_location" value="<?php echo esc_attr( $event_location ); ?>" placeholder="<?php esc_attr_e( 'Ej: Buenos Aires, Argentina', 'eventstream' ); ?>" />
        </div>
        
        <div class="event-field">
            <label for="event_speaker"><?php _e( 'Ponente/Orador:', 'eventstream' ); ?></label>
            <input type="text" id="event_speaker" name="event_speaker" value="<?php echo esc_attr( $event_speaker ); ?>" placeholder="<?php esc_attr_e( 'Nombre del ponente', 'eventstream' ); ?>" />
        </div>
        
        <div class="event-field">
            <label for="event_video_url"><?php _e( 'URL del Video (YouTube/Vimeo):', 'eventstream' ); ?></label>
            <input type="url" id="event_video_url" name="event_video_url" value="<?php echo esc_url( $event_video_url ); ?>" placeholder="https://youtube.com/watch?v=..." />
            <p class="description"><?php _e( 'Ingresa la URL de YouTube o Vimeo para incrustar el video del evento.', 'eventstream' ); ?></p>
        </div>
    </div>
    <?php
}

/**
 * GUARDAR META DATA DEL EVENTO
 * 
 * Se ejecuta cuando se guarda un evento
 */
function eventstream_save_event_details( $post_id ) {
    // Verificar nonce
    if ( ! isset( $_POST['eventstream_event_details_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['eventstream_event_details_nonce'], 'eventstream_save_event_details' ) ) {
        return;
    }
    
    // Verificar que no es autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Verificar permisos
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Sanitizar y guardar datos
    $fields = array(
        'event_date'      => 'sanitize_text_field',
        'event_time'      => 'sanitize_text_field',
        'event_location'  => 'sanitize_text_field',
        'event_video_url' => 'esc_url_raw',
        'event_speaker'   => 'sanitize_text_field',
    );
    
    foreach ( $fields as $field => $sanitize_function ) {
        if ( isset( $_POST[ $field ] ) ) {
            $value = call_user_func( $sanitize_function, $_POST[ $field ] );
            update_post_meta( $post_id, '_' . $field, $value );
        }
    }
}
add_action( 'save_post_event', 'eventstream_save_event_details' );

/**
 * FLUSH REWRITE RULES AL ACTIVAR EL TEMA
 * 
 * Importante para que las URLs personalizadas funcionen correctamente
 */
function eventstream_rewrite_flush() {
    eventstream_register_event_post_type();
    eventstream_register_event_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'eventstream_rewrite_flush' );

