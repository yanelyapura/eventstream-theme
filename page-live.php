<?php
/**
 * Template Name: Página de Transmisión en Vivo
 * 
 * Template personalizado para mostrar video streaming en vivo
 * 
 * Para usar este template:
 * 1. Crear una página en WordPress
 * 2. En el editor, seleccionar "Página de Transmisión en Vivo" como template
 * 3. Configurar la URL del video en Apariencia → Personalizar → Opciones de Video Streaming
 * 
 * @package EventStream
 * @version 1.0.0
 */

get_header();
?>

<div class="site-content">
    <div class="container-wide">
        
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'live-streaming-page' ); ?>>
                
                <!-- Título de la página -->
                <header class="entry-header text-center">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    
                    <?php if ( get_the_content() ) : ?>
                        <div class="entry-intro">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </header>
                
                <!-- Video Player -->
                <div class="live-video-section">
                    <?php
                    // Obtener URL del video desde el Customizer
                    $live_video_url = get_theme_mod( 'eventstream_live_video_url' );
                    
                    if ( $live_video_url ) :
                        // Convertir URL normal a URL de embed
                        $embed_url = eventstream_get_embed_url( $live_video_url );
                        ?>
                        
                        <div class="video-container">
                            <?php if ( get_theme_mod( 'eventstream_show_live_badge', true ) ) : ?>
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
                        
                    <?php else : ?>
                        
                        <!-- Mensaje si no hay video configurado -->
                        <div class="no-video-message">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <p>
                                    <?php _e( 'No hay transmisión en vivo en este momento.', 'eventstream' ); ?>
                                </p>
                                <?php if ( current_user_can( 'customize' ) ) : ?>
                                    <p>
                                        <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=eventstream_video_section' ) ); ?>" class="btn btn-primary">
                                            <?php _e( 'Configurar Video en Vivo', 'eventstream' ); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                    <?php endif; ?>
                </div>
                
                <!-- Sección de información adicional -->
                <div class="live-info-section">
                    <div class="live-info-grid">
                        
                        <!-- Chat o interacción -->
                        <div class="live-info-box">
                            <h3>
                                <i class="fas fa-comments"></i>
                                <?php _e( 'Interactúa en Tiempo Real', 'eventstream' ); ?>
                            </h3>
                            <p><?php _e( 'Comparte tus comentarios y preguntas durante la transmisión en vivo.', 'eventstream' ); ?></p>
                        </div>
                        
                        <!-- Información de horarios -->
                        <div class="live-info-box">
                            <h3>
                                <i class="fas fa-clock"></i>
                                <?php _e( 'Horarios de Transmisión', 'eventstream' ); ?>
                            </h3>
                            <p><?php _e( 'Consulta los horarios de las próximas transmisiones en vivo.', 'eventstream' ); ?></p>
                        </div>
                        
                        <!-- Redes sociales -->
                        <div class="live-info-box">
                            <h3>
                                <i class="fas fa-share-alt"></i>
                                <?php _e( 'Comparte', 'eventstream' ); ?>
                            </h3>
                            <p><?php _e( 'Comparte esta transmisión con tus amigos y colegas.', 'eventstream' ); ?></p>
                        </div>
                        
                    </div>
                </div>
                
            </article>
            
        <?php endwhile; ?>
        
    </div>
</div>

<style>
/* Estilos específicos para la página de streaming */
.live-streaming-page {
    padding: 2rem 0;
}

.entry-intro {
    max-width: 800px;
    margin: 1rem auto 2rem;
    color: var(--text-light);
    font-size: 1.125rem;
}

.live-video-section {
    margin: 2rem 0;
}

.no-video-message {
    text-align: center;
    padding: 4rem 2rem;
}

.alert {
    max-width: 600px;
    margin: 0 auto;
    padding: 2rem;
    border-radius: var(--border-radius-lg);
    background-color: var(--bg-light);
    border: 1px solid var(--border-color);
}

.alert i {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.live-info-section {
    margin: 3rem 0;
}

.live-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.live-info-box {
    padding: 2rem;
    background: var(--bg-light);
    border-radius: var(--border-radius-lg);
    text-align: center;
    border: 1px solid var(--border-color);
}

.live-info-box i {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.live-info-box h3 {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.live-info-box h3 i {
    font-size: 1.5rem;
    margin-bottom: 0;
}
</style>

<?php
get_footer();

