<?php

/**
 * Funciones varias para WordPress.
 *
 * @package locoymedio\wordpress\tema
 */

/**
 * ¿El sitio se está ejecutando en servidor local?
 *
 * En un servidor de producción [de hosting], esta constante debe fijarse a FALSE.
 */
define('EN_LOCALHOST', true);

add_theme_support('nav-menus');
add_theme_support('post-thumbnails');
add_theme_support('post-formats', ['aside', 'image', 'video', 'quote', 'link', 'audio', 'gallery', 'status']);
add_post_type_support('post', 'excerpt');



// ===============================
// Configuración de tema WordPress
// ===============================

define('BS_COL_CENTRO', 'col-lg-9');
define('BS_COL_SIDEBAR', 'col-lg-3');

// ------
// Menúes
// ------

/**
 * Registra los menúes del tema
 *
 * Para usar uno de estos menúes en la plantilla, usar la función wp_nav_menu().
 *
 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
 */
function registrarMenues()
{
	$infoMenues = array(
		'menupri' => __('Menú principal'),
//		'menupie' => __('Menú inferior'),
		'menusocial' => __('Redes sociales')
	);
	register_nav_menus($infoMenues);
}

add_action('init', 'registrarMenues');

/**
 * Configura los elementos de un menú para que sean todos en línea
 *
 * En Bootstrap 3.x se podía tener un elemento `<ul>` de clase `list-inline` para que todos sus elementos estén en línea.
 * Ahora con Bootstrap 4, se requiere además que cada elemento de la lista tenga la clase `list-inline-item` para lograr este efecto.
 * El problema es que la función `wp_nav_menu()` de WordPress no permite asignar una clase a los elementos de una lista (solo permite a la lista y a su contenedor).
 * Esta función resuelve este problema permitiendo asignar una clase a cada elemento de la lista.
 *
 * @param array $items lista de elementos de la lista.
 * @return array La lista de items con la clase añadida.
 */
function configurarMenuEnLinea($items)
{
	foreach ($items as $item)
		$item->classes[] = 'list-inline-item';
	return $items;
}

// -----------------------
// Barra lateral [sidebar]
// -----------------------

/**
 * Registra una barra lateral.
 *
 * Para usar uno de estos menúes en la plantilla, usar las funciones dynamic_sidebar() en la plantilla de la barra,
 * y get_sidebar() en la plantilla de la página o del post.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 */
function registrarBarraLateral()
{
	$infoBarraLateral = array(
		'name' => __('Barra lateral'),
		'id' => 'sidebar',
		'class' => 'sidebar',
		'before_widget' => '<div class="sidebar-widget">',
		'after_widget' => '</div>',
//		'before_title' => '<h2 class="hbarra">',
//		'after_title' => '</h2>'
	);
	register_sidebar($infoBarraLateral);
}

add_action('init', 'registrarBarraLateral');



// =============================
// Librerías externas o internas
// =============================

// ------
// jQuery
// ------

/**
 * Carga la librería de jQuery integrada de WordPress.
 *
 * Esto evita la necesidad de cargar un archivo jQuery externo desde {@link header.php} (práctica no recomendada).
 *
 * **NOTA IMPORTANTE:** Incluir la librería integrada de WordPress hará que el símbolo dólar ($) no funcione.
 * Se tendrá que dejar de usar llamadas de tipo $(...) y usar jQuery(...) en su lugar.
 *
 * @link http://gracom.es/usar-jquery-en-wordpress/
 * @link https://www.nosolocodigo.com/5-trucos-para-usar-jquery-con-wordpress
 */
function cargarJQuery()
{
	if (!is_admin())
		wp_enqueue_script('jquery');
	if (false && !is_admin())
//		wp_enqueue_script('jquery');
	{
		wp_deregister_script('jquery');
//		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js', false, '2.0.3'/*, true*/);
		wp_register_script('jquery', 'https://code.jquery.com/jquery-1.12.4.min.js');
		wp_enqueue_script('jquery');
	}
}

// Añade a la cola de WordPress
add_action('init', 'cargarJQuery');

// ------------------
// Librerías externas
// ------------------

/**
 * Versión de Bootstrap activa
 *
 * @var string
 */
define('BS_VERSION', '4.3.1');

/**
 * Carga las librerías de externas en WordPress
 *
 * Librerías:
 *
 * - Bootstrap
 * - Google Fonts
 * - Font Awesome
 * - Animate.css
 * - Popper.js
 *
 * Tipografías probadas:
 *
 * - Amatic+SC
 * - Oxygen
 * - Source+Sans+Pro
 *
 * @link http://tecneofito.com/anade-bootstrap-a-tu-tema-de-wordpress/
 * @link https://voragine.net/wordpress/wp-enqueue-style-encolar-cargar-hoja-estilo-theme
 */
function cargarLibreriasEnCabecera()
{
	// Bootstrap
	$version = BS_VERSION;
	wp_enqueue_style('bootstrap-css', get_template_directory_uri() . "/lib/bootstrap-$version-dist/css/bootstrap.min.css");
	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . "/lib/bootstrap-$version-dist/js/bootstrap.min.js", ['jquery', 'popperjs']);
	// Google Fonts
//	wp_enqueue_style('gfonts', 'https://fonts.googleapis.com/css?family=Bitter:400,400i,700|PT+Sans+Narrow:400,700|Encode+Sans+Condensed:400,400i,700,700i|Montserrat:300,300i,700,700i');
	wp_enqueue_style('gfonts', 'https://fonts.googleapis.com/css?family=Roboto+Slab:400,400i,700|Catamaran:400,700&display=swap');
	// Font Awesome
	wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/7c6896f131.js');
	// Animate.css
	wp_enqueue_style('animatecss', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css');
//	wp_enqueue_style('animatecss', '/lib/animate.css');
	// bxSlider
//	wp_enqueue_style('bxslider-css', get_template_directory_uri() . "/lib/bxslider/jquery.bxslider.min.css");
//	wp_enqueue_script('bxslider-js', get_template_directory_uri() . "/lib/bxslider/jquery.bxslider.min.js", array('jquery'));
	// elevateZoom
//	wp_enqueue_script('zoom', get_template_directory_uri() . "/js/jquery.elevateZoom-3.0.8.min.js", array('jquery'));
	// Content Carousel
//	wp_enqueue_script('easing', get_template_directory_uri() . "/js/jquery.easing.1.3.js", array('jquery'));
//	wp_enqueue_script('contentcarousel', get_template_directory_uri() . "/js/jquery.contentcarousel.js", array('jquery', 'easing'));
	// Títulos con doble barra
//	wp_enqueue_script('hbarra', get_template_directory_uri() . "/js/hbarra.js", array('jquery'));
	// Estilos antiguos [legacy]
//	wp_enqueue_style('style-legacy', get_template_directory_uri() . "/style-legacy.css");
	// Popper.js
	wp_enqueue_script('popperjs', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js');
	// Hoja de estilos de WordPress (se cargará después de Bootstrap)
	wp_register_style('wp-css', get_stylesheet_uri(), ['bootstrap-css']);
	wp_enqueue_style('wp-css');
	// Funciones varias
	wp_enqueue_script('etc-js', get_template_directory_uri() . "/js/etc.js", ['jquery']);
}

// Añade a la cola de WordPress
add_action('wp_enqueue_scripts', 'cargarLibreriasEnCabecera');



// =====================================
// Personalización del tema de WordPress
// =====================================

/**
 * Configura el panel de personalización del tema de WordPress
 *
 * @param WP_Customize_Manager $wpCustomize
 * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/
 */
function configurarPersonalizacionTema($wpCustomize)
{
	// Panel Opciones
	$panel = $wpCustomize->add_panel('lcm_opciones', array('title' => __('Opciones de Loco y medio')));
	// Sección Mis datos
	$wpCustomize->add_section('lcm_opciones_datos', array('panel' => 'lcm_opciones', 'title' => __('Mis datos'), 'description' => __('Datos del autor de este blog')));
	// * E-mail (para Gravatar)
	$wpCustomize->add_setting('lcm_opcion_email', array('type' => 'option', 'default' => 'daniloquispe@gmail.com'));
	$wpCustomize->add_control('lcm_opcion_email', array('section' => 'lcm_opciones_datos', 'label' => 'E-mail (para Gravatar)'));
	// Sección Página de inicio
	$wpCustomize->add_section('lcm_opciones_inicio', array('panel' => 'lcm_opciones', 'title' => __('Página de inicio')/*, 'description' => __('Datos del autor de este blog')*/));
	// * Imagen de presentación
	$wpCustomize->add_setting('lcm_opcion_inicio_imagen', array('type' => 'option'/*, 'default' => ''*/));
	$wpCustomize->add_control(new WP_Customize_Media_Control($wpCustomize, 'lcm_opcion_inicio_imagen', array('section' => 'lcm_opciones_inicio', 'label' => 'Imagen de presentación', 'mime_type' => 'image')));
	// Sección Pie de página
	$wpCustomize->add_section('lcm_opciones_pie', array('panel' => 'lcm_opciones', 'title' => __('Pie de página'), 'description' => __('Opciones para el pie de página')));
	// * Licencia
	$wpCustomize->add_setting('lcm_opcion_pie_licencia', array('type' => 'option'));
	$wpCustomize->add_control('lcm_opcion_pie_licencia', array('type' => 'textarea', 'section' => 'lcm_opciones_pie', 'label' => __('Texto de licencia')));
	// * Copyright
//	$wpCustomize->add_setting('efm_opcion_texto_pie_telf', array('type' => 'option', 'default' => '(511) 371-0502 / (511) 371-0006'));
//	$wpCustomize->add_control('efm_opcion_texto_pie_telf', array('section' => 'efm_opciones_textos_pie', 'label' => 'Teléfonos'));
	// Sección Redes sociales
	$wpCustomize->add_section('lcm_opciones_rs', array('panel' => 'lcm_opciones', 'title' => __('Redes sociales'), 'description' => __('Los enlaces a las redes sociales aparecerán en la cabecera de página. Puedes usar el editor de menúes de WordPress para mostrar los enlaces que quieras.')));
	// * ¿Activar?
	$wpCustomize->add_setting('lcm_opcion_rs_act', array('type' => 'option'/*, 'default' => ''*/));
	$wpCustomize->add_control('lcm_opcion_rs_act', array('type' => 'checkbox', 'section' => 'lcm_opciones_rs', 'label' => 'Mostrar iconos en la cabecera de página'));
	// Sección: AdSense
	$wpCustomize->add_section('lcm_opciones_adsense', array('panel' => 'lcm_opciones', 'title' => __('Google AdSense'), 'description' => __('Aquí podrás ingresar el código de los bloques de AdSense para mostrar publicidad en el sitio web.')));
	// * ¿Activar?
	$wpCustomize->add_setting('lcm_opcion_adsense_act', array('type' => 'option'));
	$wpCustomize->add_control('lcm_opcion_adsense_act', array('type' => 'checkbox', 'section' => 'lcm_opciones_adsense', 'label' => __('Mostrar publicidad de Google AdSense'), 'description' => 'Necesitas estar registrado en el programa de AdSense'));
	// * Anuncios automáticos
	$wpCustomize->add_setting('lcm_opcion_adsense_auto', array('type' => 'option', 'default' => ''));
	$wpCustomize->add_control('lcm_opcion_adsense_auto', array('type' => 'textarea', 'section' => 'lcm_opciones_adsense', 'label' => __('Anuncios automáticos'), 'description' => __('Google elige la mejor ubicación para mostrar anuncios de AdSense.')));
	// * Zona superior
	$wpCustomize->add_setting('lcm_opcion_adsense_sup', array('type' => 'option', 'default' => ''));
	$wpCustomize->add_control('lcm_opcion_adsense_sup', array('type' => 'textarea', 'section' => 'lcm_opciones_adsense', 'label' => __('Zona superior'), 'description' => __('A todo lo ancho, debajo del menú principal y la imagen de presentación de la página de inicio.')));
	// * Zona de entrada
	$wpCustomize->add_setting('lcm_opcion_adsense_entrada', array('type' => 'option', 'default' => ''));
	$wpCustomize->add_control('lcm_opcion_adsense_entrada', array('type' => 'textarea', 'section' => 'lcm_opciones_adsense', 'label' => __('Página de entrada'), 'description' => __('Debajo del título de la entrada (en la página de entrada) y debajo de los metadatos.')));
	// * Barra lateral
	$wpCustomize->add_setting('lcm_opcion_adsense_lateral', array('type' => 'option', 'default' => ''));
	$wpCustomize->add_control('lcm_opcion_adsense_lateral', array('type' => 'textarea', 'section' => 'lcm_opciones_adsense', 'label' => __('Barra lateral'), 'description' => __('Debajo de los widgets.')));
	// Sección: Analytics
	$wpCustomize->add_section('lcm_opciones_analytics', array('panel' => 'lcm_opciones', 'title' => __('Google Analytics'), 'description' => __('Aquí podrás insertar el código de seguimiento de Google Analytics para recoger estadísticas de tu sitio web.')));
	// * ¿Activar?
	$wpCustomize->add_setting('lcm_opcion_analytics_act', array('type' => 'option'));
	$wpCustomize->add_control('lcm_opcion_analytics_act', array('type' => 'checkbox', 'section' => 'lcm_opciones_analytics', 'label' => __('Insertar código de Google Analytics'), 'description' => 'Necesitas estar registrado en Google Analytics'));
	// * Código de seguimiento
	$wpCustomize->add_setting('lcm_opcion_analytics_cod', array('type' => 'option', 'default' => ''));
	$wpCustomize->add_control('lcm_opcion_analytics_cod', array('type' => 'textarea', 'section' => 'lcm_opciones_analytics', 'label' => __('Código de seguimiento'), 'description' => __('Pega aquí el código proporcionado por Google Analytics. Se insertará automáticamente dentro del elemento <head> del sitio web.')));
}

add_action('customize_register', 'configurarPersonalizacionTema');



// ==========
// Plantillas
// ==========

/**
 * Paginado para la lista de entradas.
 *
 * Por alguna razón, WordPress considera que, por ejemplo, cuando hay entradas *anteriores*, el paginado lleva a la página "siguiente" (y viceversa).
 * Por eso, en esta función, se intercambian las llamadas:
 * Cuando hay entradas "siguientes", muestra el enlace a la página anterior, y cuando hat entradas "anteriores" muestra el de la página siguiente.
 *
 * El paginado solo se muestra cuando hay al menos 2 páginas de entradas.
 *
 * @see paginadoEntrada()
 */
function paginado()
{
	if ($GLOBALS['wp_query']->max_num_pages < 2)
		return;
	echo '<nav class="paginado" role="navigation">';
	echo '<h1 class="sr-only screen-reader-text">' . __('Navegación de entradas') . '</h1>';
	echo '<div class="enlaces">';
	// Anterior
	if (get_next_posts_link())
	{
		echo '<div class="anterior">';
//		next_posts_link(_x('<span class="sr-only">&larr;</span>', 'Anteriores'));
		next_posts_link(__('<span class="fa fa-arrow-left" aria-hidden="true"></span> <span class="sr-only">Anteriores</span>'));
		echo '</div>';
	}
	// Siguiente
	if (get_previous_posts_link())
	{
		echo '<div class="siguiente">';
//		next_posts_link(_x('<span class="sr-only">&rarr;</span>', 'Siguientes'));
		previous_posts_link(__('<span class="sr-only">Siguientes</span> <span class="fa fa-arrow-right" aria-hidden="true"></span>'));
		echo '</div>';
	}
	echo '</div>';
	echo '</nav>';
}

/**
 * Paginado para la lista de entradas
 *
 * Por alguna razón, WordPress considera que, por ejemplo, cuando hay entradas *anteriores*, el paginado lleva a la página "siguiente" (y viceversa).
 * Por eso, en esta función, se intercambian las llamadas:
 * Cuando hay entradas "siguientes", muestra el enlace a la página anterior, y cuando hat entradas "anteriores" muestra el de la página siguiente.
 *
 * El paginado solo se muestra cuando hay al menos 2 páginas de entradas.
 *
 * @param bool $esMovil Indica si el paginado que se mostrará es el diseño para móviles
 * @see paginado()
 * @link https://www.danielnabil.com/blog/funciones-wordpress-ruta-imagen-destacada/ Obtener la imagen destacada de una entrada
 */
function paginadoEntrada($esMovil = true)
{
	$anterior = is_attachment() ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
	$siguiente = get_adjacent_post(false, '', false);
	if (!$anterior && !$siguiente)
		return;
	if ($esMovil)
	{
    	echo '<nav class="paginado d-block d-sm-none" role="navigation">';
    	echo '<h1 class="sr-only screen-reader-text">' . __('Navegación de entrada') . '</h1>';
    	echo '<div class="enlaces">';
    	// Anterior
    	next_post_link('<div class="anterior">%link</div>', __('<span class="fa fa-arrow-left" aria=hidden="true"></span> <span class="sr-only">Anterior</span>'));
    	// Siguiente
    	previous_post_link('<div class="siguiente">%link</div>', __('<span class="sr-only">Siguiente</span> <span class="fa fa-arrow-right" aria=hidden="true"></span>'));
    	echo '</div>';
    	echo '</nav>';
	}
	else
	{
	    echo '<nav class="paginado-nomovil d-none d-sm-block" role="navigation">';
	    echo '<h1 class="sr-only screen-reader-text">' . __('Navegación de entrada') . '</h1>';
	    echo '<div class="enlaces row">';
	    // Anterior
	    $entradaAnterior = get_next_post();
    	$idImagenEntrada = get_post_thumbnail_id($entradaAnterior);
    	$imagenEntrada = wp_get_attachment_image_src($idImagenEntrada, 'thumbnail');
    	$imagenEntrada = $imagenEntrada[0];
    	next_post_link('<div class="anterior col-8 col-xl-6 text-left"><div>%link</div></div>', "<div class=\"row\"><div class=\"col-auto\"><img class=\"img-fluid\" src=\"$imagenEntrada\" alt=\"Anterior\" /></div>" . __('<div class="col pl-0 pr-3 py-2"><small>&larr; Anterior</small><br />%title</div></div>'));
    	// Siguiente
    	$entradaSiguiente = get_previous_post();
    	$idImagenEntrada = get_post_thumbnail_id($entradaSiguiente);
    	$imagenEntrada = wp_get_attachment_image_src($idImagenEntrada, 'thumbnail');
    	$imagenEntrada = $imagenEntrada[0];
    	previous_post_link('<div class="siguiente col-8 offset-4 col-xl-6 offset-xl-0 text-right"><div>%link</div></div>', __('<div class="row"><div class="col pl-3 pr-0 py-2"><small>Siguiente &rarr;</small><br />%title</div>') . "<div class=\"col-auto\"><img class=\"img-fluid\" src=\"$imagenEntrada\" alt=\"Siguiente\" /></div></div>");
	    echo '</div>';
	    echo '</nav>';
	}
}