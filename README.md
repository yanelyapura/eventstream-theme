# EventStream WordPress Theme

![WordPress](https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

## 📖 Descripción

EventStream es un tema personalizado de WordPress diseñado específicamente para sitios web de **eventos, conferencias y seminarios** con capacidades de **streaming de video en vivo**. Desarrollado con las mejores prácticas de WordPress, incluye integración completa con YouTube Live y Vimeo para transmisiones en tiempo real.

**🔗 Demo en vivo:** [https://good-rhythm.localsite.io/](https://good-rhythm.localsite.io/)

---

## ✨ Características Principales

### 🎥 Video Streaming
- ✅ Integración con **YouTube Live** y **Vimeo**
- ✅ **Video.js** v8.6.1 como player HTML5
- ✅ Embeddings responsivos con aspect ratio 16:9
- ✅ Badge "EN VIVO" animado para transmisiones activas
- ✅ Shortcodes personalizados para inserción rápida de videos

### 📅 Gestión de Eventos
- ✅ **Custom Post Type** para eventos
- ✅ Meta boxes personalizados con campos para:
  - Fecha y hora del evento
  - Ubicación
  - Ponente/Orador
  - URL de video (YouTube/Vimeo)
- ✅ Taxonomías personalizadas (Categorías de Eventos)
- ✅ Templates específicos para archivo y eventos individuales

### 🎨 Diseño y UX
- ✅ **Diseño responsivo** mobile-first
- ✅ CSS moderno con variables personalizables
- ✅ Animaciones y transiciones suaves
- ✅ WordPress Customizer integrado
- ✅ Widget "Próximos Eventos"

### 🛠️ Desarrollo Profesional
- ✅ Código limpio y bien documentado
- ✅ Seguimiento de estándares de WordPress
- ✅ Hooks (actions y filters) implementados
- ✅ Sanitización y seguridad de datos
- ✅ Preparado para traducción (i18n)
- ✅ Accesibilidad con ARIA labels

---

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 7.4+**: Lógica del servidor
- **WordPress API**: Custom Post Types, Taxonomías, Meta Boxes
- **MySQL**: Base de datos

### Frontend
- **HTML5**: Estructura semántica
- **CSS3**: Diseño moderno (Grid, Flexbox, Variables CSS)
- **JavaScript**: Vanilla JS + jQuery
- **Video.js 8.6.1**: Player de video HTML5
- **Font Awesome 6.4**: Iconografía

### Integración
- **YouTube IFrame API**: Para embeddings de YouTube
- **Vimeo Player API**: Para embeddings de Vimeo
- **WordPress oEmbed**: Conversión automática de URLs

---

## 📦 Instalación

### Requisitos Previos
- WordPress 5.8 o superior
- PHP 7.4 o superior
- MySQL 5.7 o superior

### Pasos de Instalación

1. **Descargar el tema**
   ```bash
   git clone https://github.com/yanelyapura/eventstream-theme.git
   ```

2. **Copiar a WordPress**
   - Copia la carpeta del tema a `wp-content/themes/`
   - O sube el archivo ZIP desde WordPress Admin → Apariencia → Temas → Añadir nuevo

3. **Activar el tema**
   - Ve a **Apariencia → Temas**
   - Encuentra "EventStream Theme"
   - Haz clic en "Activar"

4. **Configurar enlaces permanentes**
   - Ve a **Ajustes → Enlaces Permanentes**
   - Selecciona "Nombre de la entrada"
   - Guarda los cambios

5. **¡Listo!** Tu tema está instalado y funcionando

---

## 🎯 Uso

### Crear un Evento

1. En el panel de WordPress, ve a **Eventos → Añadir Nuevo**
2. Completa los campos:
   - **Título**: Nombre del evento
   - **Contenido**: Descripción detallada
   - **Imagen destacada**: Imagen principal del evento
   - **Detalles del Evento** (meta box):
     - Fecha del evento
     - Hora
     - Ubicación
     - Ponente
     - URL de video (YouTube o Vimeo)
3. Asigna una **Categoría de Evento**
4. Haz clic en **Publicar**

### Página de Transmisión en Vivo

1. Crea una nueva página: **Páginas → Añadir Nueva**
2. En **Atributos de Página → Plantilla**, selecciona **"Página de Transmisión en Vivo"**
3. Configura la URL del video en **Apariencia → Personalizar → Opciones de Video Streaming**
4. Publica la página

### Shortcode de Video

Para insertar un video en cualquier página o post:

```php
[event_video url="https://www.youtube.com/watch?v=VIDEO_ID" live="yes"]
```

Parámetros:
- `url`: URL del video (YouTube o Vimeo)
- `live`: "yes" para mostrar el badge "EN VIVO" (opcional)

---

## 📂 Estructura del Proyecto

```
eventstream-theme/
├── style.css                 # Metadata y estilos principales
├── index.php                 # Template principal
├── functions.php             # Configuración del tema
├── header.php                # Header del sitio
├── footer.php                # Footer del sitio
├── single.php                # Posts individuales
├── page.php                  # Páginas estáticas
├── page-live.php             # Template para streaming
├── archive-event.php         # Archivo de eventos
├── single-event.php          # Evento individual
├── screenshot.png            # Captura del tema
│
├── inc/                      # Funcionalidades adicionales
│   ├── custom-post-types.php # Custom Post Types
│   ├── widgets.php           # Widgets personalizados
│   └── video-integration.php # Integración de video
│
├── assets/                   # Recursos estáticos
│   ├── css/
│   │   └── main.css         # Estilos adicionales
│   ├── js/
│   │   ├── main.js          # JavaScript principal
│   │   └── video-player.js  # Manejo de video
│   └── images/
│       └── placeholder.jpg   # Imagen placeholder
│
└── templates/                # Templates reutilizables
    └── parts/
        ├── content-event.php # Template part de evento
        └── video-player.php  # Template part de video
```

---

## 🎓 Conceptos de WordPress Demostrados

Este proyecto demuestra conocimiento profundo en:

### 1. Estructura de Temas WordPress
- Archivos obligatorios (`style.css`, `index.php`)
- Template hierarchy
- Template parts reutilizables
- Custom page templates

### 2. PHP y WordPress Backend
- `functions.php` con configuración completa
- Custom Post Types y Taxonomías
- Meta Boxes personalizados con sanitización
- Hooks: Actions y Filters
- WordPress Customizer API
- Widgets personalizados (OOP)

### 3. Integración de APIs
- YouTube IFrame API
- Vimeo Player API
- WordPress oEmbed
- Video.js para streaming

### 4. Frontend Moderno
- HTML5 semántico
- CSS3 con variables y responsive design
- JavaScript vanilla y jQuery
- Diseño mobile-first

### 5. Buenas Prácticas
- Código documentado
- Sanitización de datos (`sanitize_text_field`, `esc_url_raw`)
- Escapado de output (`esc_html`, `esc_attr`, `esc_url`)
- Seguridad con nonces
- Traducción preparada (i18n)
- Accesibilidad (ARIA labels)

---

## 🎨 Personalización

### Colores del Tema

Ve a **Apariencia → Personalizar → Colores del Tema** para cambiar:
- Color primario
- Color secundario
- Color de acento

O edita las variables CSS en `style.css`:

```css
:root {
    --primary-color: #2563eb;
    --secondary-color: #1e40af;
    --accent-color: #f59e0b;
}
```

### Video Streaming

Configura el video en vivo desde **Apariencia → Personalizar → Opciones de Video Streaming**:
- URL del video en vivo
- Mostrar/ocultar badge "EN VIVO"

---

## 📸 Capturas de Pantalla

### Página Principal
![Home](https://via.placeholder.com/800x400?text=Home+Page)

### Transmisión en Vivo
![Live Streaming](https://via.placeholder.com/800x400?text=Live+Streaming+Page)

### Archivo de Eventos
![Events Archive](https://via.placeholder.com/800x400?text=Events+Archive)

### Evento Individual
![Single Event](https://via.placeholder.com/800x400?text=Single+Event)

---

## 🔍 Casos de Uso

- ✅ Sitios web de conferencias y congresos
- ✅ Plataformas de seminarios en línea
- ✅ Transmisiones en vivo de eventos corporativos
- ✅ Sitios de eventos híbridos (presencial + virtual)
- ✅ Plataformas educativas con webinars
- ✅ Eventos deportivos con streaming

---

## 🐛 Solución de Problemas

### El tema no aparece en WordPress
- Verifica que la carpeta esté en `wp-content/themes/`
- Asegúrate de que `style.css` tenga el header correcto

### Los eventos no se muestran
- Ve a **Ajustes → Enlaces Permanentes**
- Haz clic en "Guardar cambios" para regenerar las reglas

### Los estilos no se aplican
- Limpia el caché del navegador (Ctrl + Shift + R)
- Verifica si hay errores en la consola del navegador (F12)

### El video no se reproduce
- Verifica que la URL sea de YouTube o Vimeo
- Asegúrate de que el video sea público
- Comprueba la configuración de privacidad del video

---

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Si deseas contribuir:

1. Haz fork del proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📚 Recursos y Documentación

- [WordPress Theme Handbook](https://developer.wordpress.org/themes/)
- [WordPress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- [Custom Post Types](https://developer.wordpress.org/plugins/post-types/)
- [Video.js Documentation](https://videojs.com/)
- [YouTube IFrame API](https://developers.google.com/youtube/iframe_api_reference)
- [Vimeo Player SDK](https://developer.vimeo.com/player/sdk)

---

## 👤 Autor

**Yanel Yapura**
- Portfolio: [github.com/yanelyapura](https://github.com/yanelyapura)
- LinkedIn: [Tu LinkedIn](#)
- Email: [tu-email@example.com](#)

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

---

## 🙏 Agradecimientos

- Inspirado en la necesidad de crear sitios web modernos para eventos con streaming
- Desarrollado con ❤️ y las mejores prácticas de WordPress
- Video.js por su excelente player HTML5
- La comunidad de WordPress por su documentación

---

**⭐ Si te gusta este proyecto, dale una estrella en GitHub!**

---

*Desarrollado como proyecto de portfolio para demostrar conocimientos en WordPress, PHP, JavaScript y integración de video streaming.*

