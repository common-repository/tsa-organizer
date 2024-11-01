=== TSA Organizer ===
Contributors: jarruego
Tags: tsa, seo, marketing
Requires at least: 4.7
Tested up to: 5.3
Stable tag: trunk

*Crea Custom Post Types de tipo Familia TSA y generea interlinking entre ellas*

== Descripción ==
Genera un Custom Post Type nuevo para crear páginas de Familias TSA. Las Familias están enlazadas entre si según su valor de búsquedas. La idea es hacer un interlinking según el peso que tiene cada familia en los resultados de Google.


**¿Cómo funciona TSA Organizer?**

Por ejemplo, si es una tienda de productos de Superhéroes, puedes crear un Familia TSA con productos tipo camisetas, otra con figuras, otra con tazas... A cada familia se le asignará un número de busquedas en Google aproximado (puedes utilizar herramietas tipo Ubersugest o Keyword Planner de Google). Según el número de búsquedas que tenga cada familia, tendrá más o menos enlaces intrernos del resto de familias.

También se puede escribir una descripción de cada Familia que aparecerá como extracto de la misma en los enlaces internos.

Las familias TSA se pueden clasificar dentro de grupos, funcionan igual que las categorías de Wordpress


== Shortcodes ==

Para mostrar un listado con todas las familias TSA:
[grid_TSA]

Para mostrar las familias TSA de un grupo o grupos determinados:
[grid_TSA grupos="electrodomésticos,herramientas"]



== Instalación ==

Después de descargar el plugin:

1. Sube la carpeta `tsa-organizer` al directorio `/wp-content/plugins/`
2. Activa el plugin desde el menú 'Plugins' de WordPress
3. Verás que aparece 'Familias TSA' en el menu de Administrador de Wordpress


== Preguntas Frecuentes ==

= ¿Pero esto funciona? =

Ahora mismo TSA Organizer es un plugin de un desarrollador amateur, muy sencillo y muy mejorable. Es para uso personal pero podéis instalarlo, mejorarlo y preguntarme lo que queráis.

== Changelog ==

**Version 0.3**
* Compatible con 5.3
* Se añade un campo meta para contar las visitas a los posts

**Version 0.2**
* Bootstrap

**Version 0.1**
* Compatible con 5.0