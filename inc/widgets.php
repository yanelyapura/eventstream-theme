<?php
/**
 * Widgets Personalizados
 * 
 * Define widgets personalizados para el tema
 * En este caso: Widget de Próximos Eventos
 * 
 * @package EventStream
 * @version 1.0.0
 */

// Prevenir acceso directo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WIDGET: PRÓXIMOS EVENTOS
 * 
 * Muestra una lista de los próximos eventos
 * Se puede agregar en cualquier área de widgets (sidebar, footer, etc.)
 */
class EventStream_Upcoming_Events_Widget extends WP_Widget {
    
    /**
     * Constructor del widget
     */
    public function __construct() {
        parent::__construct(
            'eventstream_upcoming_events',                      // ID base del widget
            __( 'Próximos Eventos', 'eventstream' ),            // Nombre del widget
            array(
                'description' => __( 'Muestra una lista de los próximos eventos', 'eventstream' ),
                'classname'   => 'eventstream-upcoming-events-widget',
            )
        );
    }
    
    /**
     * Front-end display del widget
     * 
     * @param array $args     Argumentos del widget
     * @param array $instance Configuración guardada del widget
     */
    public function widget( $args, $instance ) {
        // Título del widget
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Próximos Eventos', 'eventstream' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        
        // Número de eventos a mostrar
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        
        echo $args['before_widget'];
        
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }
        
        // Query de eventos
        $event_query = new WP_Query( array(
            'post_type'      => 'event',
            'posts_per_page' => $number,
            'orderby'        => 'meta_value',
            'meta_key'       => '_event_date',
            'order'          => 'ASC',
            'meta_query'     => array(
                array(
                    'key'     => '_event_date',
                    'value'   => date( 'Y-m-d' ),
                    'compare' => '>=',
                    'type'    => 'DATE',
                ),
            ),
        ) );
        
        if ( $event_query->have_posts() ) : ?>
            <ul class="upcoming-events-list">
                <?php while ( $event_query->have_posts() ) : $event_query->the_post(); ?>
                    <li class="upcoming-event-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="event-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="event-info">
                            <h4 class="event-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h4>
                            
                            <?php
                            $event_date = get_post_meta( get_the_ID(), '_event_date', true );
                            $event_time = get_post_meta( get_the_ID(), '_event_time', true );
                            
                            if ( $event_date ) :
                                $formatted_date = date_i18n( 'j \d\e F, Y', strtotime( $event_date ) );
                                ?>
                                <div class="event-date">
                                    <i class="far fa-calendar"></i>
                                    <?php echo esc_html( $formatted_date ); ?>
                                    <?php if ( $event_time ) : ?>
                                        <span class="event-time">
                                            <i class="far fa-clock"></i>
                                            <?php echo esc_html( $event_time ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
            
            <?php
            wp_reset_postdata();
        else :
            echo '<p>' . __( 'No hay eventos programados.', 'eventstream' ) . '</p>';
        endif;
        
        echo $args['after_widget'];
    }
    
    /**
     * Back-end widget form (admin)
     * 
     * @param array $instance Configuración guardada del widget
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Próximos Eventos', 'eventstream' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php _e( 'Título:', 'eventstream' ); ?>
            </label>
            <input 
                class="widefat" 
                id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
                name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
                type="text" 
                value="<?php echo esc_attr( $title ); ?>"
            />
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
                <?php _e( 'Número de eventos a mostrar:', 'eventstream' ); ?>
            </label>
            <input 
                class="tiny-text" 
                id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" 
                name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" 
                type="number" 
                step="1" 
                min="1" 
                value="<?php echo esc_attr( $number ); ?>" 
                size="3"
            />
        </p>
        <?php
    }
    
    /**
     * Guardar configuración del widget
     * 
     * @param array $new_instance Nueva configuración
     * @param array $old_instance Configuración anterior
     * @return array Configuración actualizada
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? 
            sanitize_text_field( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? 
            absint( $new_instance['number'] ) : 5;
        
        return $instance;
    }
}

/**
 * REGISTRAR WIDGETS
 */
function eventstream_register_widgets() {
    register_widget( 'EventStream_Upcoming_Events_Widget' );
}
add_action( 'widgets_init', 'eventstream_register_widgets' );

/**
 * ESTILOS PARA EL WIDGET
 */
function eventstream_widget_styles() {
    ?>
    <style>
        .eventstream-upcoming-events-widget .upcoming-events-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .eventstream-upcoming-events-widget .upcoming-event-item {
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color, #e5e7eb);
        }
        
        .eventstream-upcoming-events-widget .upcoming-event-item:last-child {
            border-bottom: none;
        }
        
        .eventstream-upcoming-events-widget .event-thumbnail {
            margin-bottom: 10px;
        }
        
        .eventstream-upcoming-events-widget .event-thumbnail img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        
        .eventstream-upcoming-events-widget .event-title {
            font-size: 1rem;
            margin: 0 0 5px;
        }
        
        .eventstream-upcoming-events-widget .event-title a {
            color: var(--text-color, #1f2937);
            text-decoration: none;
        }
        
        .eventstream-upcoming-events-widget .event-title a:hover {
            color: var(--primary-color, #2563eb);
        }
        
        .eventstream-upcoming-events-widget .event-date {
            font-size: 0.875rem;
            color: var(--text-light, #6b7280);
        }
        
        .eventstream-upcoming-events-widget .event-date i {
            margin-right: 5px;
        }
        
        .eventstream-upcoming-events-widget .event-time {
            margin-left: 10px;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'eventstream_widget_styles' );

