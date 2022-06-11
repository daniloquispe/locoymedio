<?php

/**
 * Cabecera web
 *
 * @package isolperu\locoymedio-wordpress
 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/ documentación de `wp_nav_menu()`
 * @link https://blog.expertowordpress.org/2015/12/anadir-schemaorg-tu-tema-de-wordpress.html
 */

/**
 * ¿Está activado Google AdSense?
 *
 * @var bool
 */
define('ACT_ADSENSE', get_option('lcm_opcion_adsense_act'));
/**
 * Código de anuncios automáticos de Google AdSense
 *
 * @var string
 */
define('ADSENSE_AUTO', get_option('lcm_opcion_adsense_auto'));

// Menú de redes sociales (argumentos)
$argsMenuRedes = [
	'theme_location' => 'menusocial',
	'menu_id' => 'menusocial-sup',
	'menu_class' => 'list-inline',
	'container_id' => 'zmenusocial-sup',
	'container_class' => 'col-md-6',
	'depth' => 1,
	'link_before'    => '<span class="sr-only">',
	'link_after'     => '</span>'
];

// Menú principal (argumentos)
$argsMenuPrincipal = [
	'theme_location' => 'menupri',
	'menu_id' => 'menupri',
	'menu_class' => 'navbar-nav mr-auto',
	'container' => '',
//	'container_id' => 'zmenupri-new',
//	'container_class' => 'mr-auto',
];

?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
<meta charset="<?php bloginfo('charset') ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/favicon.ico" />
<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
<?php wp_head() ?>
<title><?php wp_title() ?></title>
<?php if (ACT_ADSENSE) : ?>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<?php if (ADSENSE_AUTO != '') echo ADSENSE_AUTO ?>
<?php endif ?>
<?php if (get_option('lcm_opcion_analytics_act')) echo trim(get_option('lcm_opcion_analytics_cod')) ?>
</head>
<body <?php body_class() ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
<header class="zcab pt-3" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
	<div class="container-fluid">
		<div class="row">
			<div id="zlogo" class="col-md-6">
				<div class="d-none d-lg-block">
					<h1 itemprop="headline"><a href="<?php echo home_url() ?>"><?php bloginfo('name') ?></a></h1>
					<p itemprop="description"><?php bloginfo('description') ?></p>
				</div>
				<div class="d-lg-none">
					<div class="media">
						<div class="media-object mr-2">
							<button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#zmenupri" aria-controls="zmenupri" aria-expanded="false" aria-label="<?php _e('Menú principal') ?>"><span class="fa fa-bars"></span></button>
						</div>
						<div class="media-body">
							<h1><a href="<?php echo home_url() ?>"><?php bloginfo('name') ?></a></h1>
							<p><?php bloginfo('description') ?></p>
						</div>
					</div>
				</div>
			</div>
			<?php wp_nav_menu($argsMenuRedes) ?>
		</div>
	</div>
</header>
<nav class="navbar navbar-expand-lg py-0" id="zmenupribusc" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
	<div class="collapse navbar-collapse" id="zmenupri">
		<?php wp_nav_menu($argsMenuPrincipal) ?>
		<form class="form-inline py-4 py-lg-0">
			<div class="input-group">
				<input type="search" id="s" name="s" class="form-control" value="<?php the_search_query() ?>" placeholder="<?php _e('Buscar') ?>" aria-label="<?php _e('Buscar') ?>" />
				<span class="input-group-btn">
					<button type="submit" class="btn btn-dark"><span class="fa fa-search" aria-hidden="true"></span> <span class="sr-only"><?php _e('Buscar') ?></span></button>
				</span>
			</div>
		</form>
	</div>
</nav>