/**
 * Video Player y Streaming
 * 
 * Maneja la funcionalidad de video streaming
 * Integración con YouTube, Vimeo y Video.js
 * 
 * @package EventStream
 * @version 1.0.0
 */

(function($) {
    'use strict';
    
    /**
     * INICIALIZACIÓN
     */
    $(document).ready(function() {
        
        // Inicializar Video.js si está disponible
        if (typeof videojs !== 'undefined') {
            initVideoJS();
        }
        
        // Monitorear estado de transmisión en vivo
        initLiveMonitoring();
        
        // Hacer videos responsivos
        makeVideosResponsive();
    });
    
    /**
     * INICIALIZAR VIDEO.JS
     * 
     * Configura Video.js para players HTML5
     */
    function initVideoJS() {
        const videoElements = document.querySelectorAll('.video-js');
        
        videoElements.forEach(function(element) {
            const player = videojs(element, {
                controls: true,
                autoplay: false,
                preload: 'auto',
                fluid: true, // Hace el player responsivo
                responsive: true,
                playbackRates: [0.5, 1, 1.5, 2], // Velocidades de reproducción
                controlBar: {
                    volumePanel: {
                        inline: false
                    }
                }
            });
            
            // Event listeners
            player.on('ready', function() {
                console.log('Video player ready');
            });
            
            player.on('play', function() {
                console.log('Video playing');
            });
            
            player.on('pause', function() {
                console.log('Video paused');
            });
            
            player.on('ended', function() {
                console.log('Video ended');
            });
            
            player.on('error', function(error) {
                console.error('Video error:', error);
            });
        });
    }
    
    /**
     * HACER VIDEOS RESPONSIVOS
     * 
     * Asegura que todos los embeds de video sean responsivos
     */
    function makeVideosResponsive() {
        // Encontrar todos los iframes de video que no están en un contenedor responsivo
        $('iframe[src*="youtube.com"], iframe[src*="vimeo.com"]').each(function() {
            const $iframe = $(this);
            
            // Si ya está en un contenedor video-container, saltar
            if ($iframe.parent().hasClass('video-container')) {
                return;
            }
            
            // Envolver en contenedor responsivo
            $iframe.wrap('<div class="video-container"></div>');
        });
    }
    
    /**
     * MONITOREAR ESTADO DE TRANSMISIÓN EN VIVO
     * 
     * Verifica periódicamente si una transmisión está en vivo
     */
    function initLiveMonitoring() {
        const $liveContainer = $('.live-video-section');
        
        if ($liveContainer.length === 0) return;
        
        const videoUrl = $liveContainer.data('video-url');
        
        if (!videoUrl) return;
        
        // Verificar estado cada 30 segundos
        setInterval(function() {
            checkLiveStatus(videoUrl);
        }, 30000);
    }
    
    /**
     * VERIFICAR ESTADO DE TRANSMISIÓN
     * 
     * @param {string} videoUrl - URL del video
     */
    function checkLiveStatus(videoUrl) {
        if (typeof eventstreamData === 'undefined') {
            console.error('EventStream data not loaded');
            return;
        }
        
        $.ajax({
            url: eventstreamData.ajaxUrl,
            type: 'POST',
            data: {
                action: 'eventstream_check_live_status',
                video_url: videoUrl,
                nonce: eventstreamData.nonce
            },
            success: function(response) {
                if (response.success) {
                    updateLiveStatus(response.data.is_live);
                }
            },
            error: function() {
                console.error('Error checking live status');
            }
        });
    }
    
    /**
     * ACTUALIZAR UI DEL ESTADO EN VIVO
     * 
     * @param {boolean} isLive - Si está en vivo o no
     */
    function updateLiveStatus(isLive) {
        const $liveBadge = $('.live-badge');
        
        if (isLive) {
            $liveBadge.show().addClass('pulsing');
        } else {
            $liveBadge.hide().removeClass('pulsing');
        }
    }
    
    /**
     * OBTENER ID DE VIDEO DE YOUTUBE
     * 
     * @param {string} url - URL de YouTube
     * @return {string|null} - ID del video o null
     */
    function getYouTubeId(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);
        
        return (match && match[2].length === 11) ? match[2] : null;
    }
    
    /**
     * OBTENER ID DE VIDEO DE VIMEO
     * 
     * @param {string} url - URL de Vimeo
     * @return {string|null} - ID del video o null
     */
    function getVimeoId(url) {
        const regExp = /vimeo\.com\/(\d+)/;
        const match = url.match(regExp);
        
        return match ? match[1] : null;
    }
    
    /**
     * CREAR PLAYER DE YOUTUBE
     * 
     * Usa la API de YouTube IFrame para mayor control
     * Requiere: <script src="https://www.youtube.com/iframe_api"></script>
     * 
     * @param {string} elementId - ID del elemento contenedor
     * @param {string} videoId - ID del video de YouTube
     * @param {object} options - Opciones del player
     */
    window.createYouTubePlayer = function(elementId, videoId, options) {
        options = options || {};
        
        const defaultOptions = {
            height: '390',
            width: '640',
            videoId: videoId,
            playerVars: {
                autoplay: options.autoplay ? 1 : 0,
                controls: options.controls !== false ? 1 : 0,
                modestbranding: 1,
                rel: 0,
                showinfo: 0
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange,
                'onError': onPlayerError
            }
        };
        
        function onPlayerReady(event) {
            console.log('YouTube player ready');
            if (options.onReady) {
                options.onReady(event);
            }
        }
        
        function onPlayerStateChange(event) {
            console.log('YouTube player state:', event.data);
            if (options.onStateChange) {
                options.onStateChange(event);
            }
        }
        
        function onPlayerError(event) {
            console.error('YouTube player error:', event.data);
            if (options.onError) {
                options.onError(event);
            }
        }
        
        // Crear player (requiere YouTube IFrame API)
        if (typeof YT !== 'undefined' && YT.Player) {
            return new YT.Player(elementId, defaultOptions);
        } else {
            console.error('YouTube IFrame API not loaded');
            return null;
        }
    };
    
    /**
     * Picture-IN-PICTURE
     * 
     * Habilita modo Picture-in-Picture para videos
     */
    window.enablePictureInPicture = function(videoElement) {
        if (document.pictureInPictureEnabled) {
            videoElement.requestPictureInPicture()
                .then(function() {
                    console.log('Picture-in-Picture enabled');
                })
                .catch(function(error) {
                    console.error('PiP error:', error);
                });
        } else {
            console.log('Picture-in-Picture not supported');
        }
    };
    
    /**
     * CONTROL DE FULLSCREEN
     * 
     * @param {HTMLElement} element - Elemento a hacer fullscreen
     */
    window.toggleFullscreen = function(element) {
        if (!document.fullscreenElement) {
            element.requestFullscreen().catch(function(err) {
                console.error('Error entering fullscreen:', err);
            });
        } else {
            document.exitFullscreen();
        }
    };
    
})(jQuery);

