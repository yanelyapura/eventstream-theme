/**
 * JavaScript Principal del Tema EventStream
 * 
 * Maneja la interactividad general del sitio
 * 
 * @package EventStream
 * @version 1.0.0
 */

(function($) {
    'use strict';
    
    /**
     * INICIALIZACIÓN AL CARGAR EL DOM
     */
    $(document).ready(function() {
        
        // Inicializar menú móvil
        initMobileMenu();
        
        // Inicializar smooth scroll
        initSmoothScroll();
        
        // Inicializar lazy loading de imágenes
        initLazyLoading();
        
        // Log de inicialización (solo en desarrollo)
        console.log('EventStream Theme Initialized');
    });
    
    /**
     * MENÚ MÓVIL
     * 
     * Maneja el toggle del menú en dispositivos móviles
     */
    function initMobileMenu() {
        const $menuToggle = $('.mobile-menu-toggle');
        const $navigation = $('.main-navigation');
        
        // Click en el botón del menú
        $menuToggle.on('click', function() {
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            
            // Toggle del menú
            $navigation.toggleClass('active');
            
            // Actualizar atributo ARIA para accesibilidad
            $(this).attr('aria-expanded', !isExpanded);
            
            // Toggle del ícono
            const $icon = $(this).find('i');
            if ($icon.hasClass('fa-bars')) {
                $icon.removeClass('fa-bars').addClass('fa-times');
            } else {
                $icon.removeClass('fa-times').addClass('fa-bars');
            }
        });
        
        // Cerrar menú al hacer clic fuera de él
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-header').length && $navigation.hasClass('active')) {
                $navigation.removeClass('active');
                $menuToggle.attr('aria-expanded', 'false');
                $menuToggle.find('i').removeClass('fa-times').addClass('fa-bars');
            }
        });
        
        // Cerrar menú al cambiar tamaño de ventana
        $(window).on('resize', debounce(function() {
            if ($(window).width() > 768 && $navigation.hasClass('active')) {
                $navigation.removeClass('active');
                $menuToggle.attr('aria-expanded', 'false');
                $menuToggle.find('i').removeClass('fa-times').addClass('fa-bars');
            }
        }, 250));
    }
    
    /**
     * SMOOTH SCROLL
     * 
     * Scroll suave para enlaces ancla (#)
     */
    function initSmoothScroll() {
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').on('click', function(e) {
            const target = $(this.hash);
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 100 // Offset para el header fijo
                }, 800, 'swing');
            }
        });
    }
    
    /**
     * LAZY LOADING DE IMÁGENES
     * 
     * Carga imágenes solo cuando están visibles en el viewport
     * Nota: Los navegadores modernos tienen lazy loading nativo con loading="lazy"
     * Esta es una implementación de fallback
     */
    function initLazyLoading() {
        // Verificar si el navegador soporta Intersection Observer
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.getAttribute('data-src');
                        
                        if (src) {
                            img.src = src;
                            img.removeAttribute('data-src');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });
            
            // Observar todas las imágenes con data-src
            const lazyImages = document.querySelectorAll('img[data-src]');
            lazyImages.forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }
    
    /**
     * FUNCIÓN HELPER: DEBOUNCE
     * 
     * Limita la frecuencia de ejecución de una función
     * Útil para eventos que se disparan muchas veces (resize, scroll, etc.)
     * 
     * @param {Function} func - Función a ejecutar
     * @param {number} wait - Tiempo de espera en milisegundos
     * @return {Function}
     */
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }
    
    /**
     * ANIMACIONES AL HACER SCROLL
     * 
     * Agrega clase 'visible' a elementos cuando entran en el viewport
     */
    function initScrollAnimations() {
        const $animatedElements = $('.animate-on-scroll');
        
        if ($animatedElements.length === 0) return;
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    $(entry.target).addClass('visible');
                }
            });
        }, {
            threshold: 0.1
        });
        
        $animatedElements.each(function() {
            observer.observe(this);
        });
    }
    
    /**
     * CONTADOR REGRESIVO
     * 
     * Muestra cuenta regresiva para eventos próximos
     */
    window.EventStreamCountdown = function(targetDate, elementId) {
        const target = new Date(targetDate).getTime();
        const element = document.getElementById(elementId);
        
        if (!element) return;
        
        const interval = setInterval(function() {
            const now = new Date().getTime();
            const distance = target - now;
            
            if (distance < 0) {
                clearInterval(interval);
                element.innerHTML = '<span class="countdown-expired">¡El evento ha comenzado!</span>';
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            element.innerHTML = `
                <div class="countdown-item">
                    <span class="countdown-number">${days}</span>
                    <span class="countdown-label">Días</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number">${hours}</span>
                    <span class="countdown-label">Horas</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number">${minutes}</span>
                    <span class="countdown-label">Minutos</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number">${seconds}</span>
                    <span class="countdown-label">Segundos</span>
                </div>
            `;
        }, 1000);
    };
    
    /**
     * AJAX: CARGAR MÁS EVENTOS
     * 
     * Implementa "Load More" para eventos sin recargar la página
     */
    window.EventStreamLoadMore = function() {
        const $loadMoreBtn = $('.load-more-events');
        
        $loadMoreBtn.on('click', function(e) {
            e.preventDefault();
            
            const $btn = $(this);
            const page = parseInt($btn.data('page')) || 1;
            const maxPages = parseInt($btn.data('max-pages')) || 1;
            
            if (page >= maxPages) {
                $btn.hide();
                return;
            }
            
            $btn.addClass('loading').text('Cargando...');
            
            $.ajax({
                url: eventstreamData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'load_more_events',
                    page: page + 1,
                    nonce: eventstreamData.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $('.events-grid').append(response.data.html);
                        $btn.data('page', page + 1);
                        
                        if (page + 1 >= maxPages) {
                            $btn.hide();
                        }
                    } else {
                        console.error('Error loading events:', response.data.message);
                    }
                },
                error: function() {
                    console.error('AJAX error');
                },
                complete: function() {
                    $btn.removeClass('loading').text('Cargar Más Eventos');
                }
            });
        });
    };
    
})(jQuery);

