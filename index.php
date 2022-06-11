<?php

/**
 * Lista de entradas del blog
 *
 * @package locoymedio\wordpress\tema\plantillas
 * @uses ACT_ADSENSE
 * @link https://developer.wordpress.org/reference/functions/edit_post_link/
 * @link https://blog.expertowordpress.org/2015/12/anadir-schemaorg-tu-tema-de-wordpress.html
 */

// Opciones para paginado de entrada
$opcionesPaginadoEntrada = [
	'before' => '<nav class="paginado-entrada">Páginas ',
	'after' => '</nav>',
	'link_before' => '<span>',
	'link_after' => '</span>'];

// Cabecera
get_header();

// Imagen de presentación
if (is_home())
{
	$idImagenPresentacion = get_option('lcm_opcion_inicio_imagen');
	if ($idImagenPresentacion != '')
	{
		$imagen = wp_get_attachment_image($idImagenPresentacion, 'size-full', false, ['class' => 'img-fluid', 'alt' => get_bloginfo('name')]);
		echo $imagen;
	}
}

// Google AdSense
if (ACT_ADSENSE && ADSENSE_AUTO == '')
{
	$bloqueAdSense = trim(get_option('lcm_opcion_adsense_sup'));
	if ($bloqueAdSense != '')
		echo "<div class=\"zpub container\">$bloqueAdSense</div>";
}

// Cajetin de título
$tieneCajetin = false;
if (is_category() || is_tag() || is_search())
{
	$tieneCajetin = true;
	if (is_category())
	{
		$tituloCajetin = sprintf('Entradas en la categoría "<strong>' . single_cat_title('', false) . '</strong>"');
		$descripcionCajetin = category_description();
	}
	elseif (is_tag())
	{
		$tituloCajetin = sprintf('Entradas con la etiqueta "<strong>' . single_tag_title('', false) . '</strong>"');
		$descripcionCajetin = category_description();
	}
	elseif (is_search())
	{
		$tituloCajetin = sprintf('Buscando "<strong>' . esc_html(get_search_query(false)) . '</strong>"');
		$descripcionCajetin = '';
	}
}

?>
<main role="main">
  <div class="container">
    <div class="row">
      <div class="<?php echo BS_COL_CENTRO ?>">
        <?php if ($tieneCajetin) : ?>
          <div class="cajetin-titulo">
            <p class="lead"><?php echo $tituloCajetin ?></p>
            <?php if ($descripcionCajetin) : ?>
              <?php echo $descripcionCajetin ?>
            <?php endif ?>
          </div>
        <?php endif ?>
<?php

// Lista de entradas
if (have_posts()) :
	while (have_posts()) :
		the_post();
		// Color de formato de post
		$wpTipoEntrada = get_post_format();
		// Etiqueta de comentarios
		$numComentarios = get_comments_number();
		if (!$numComentarios)
			$etiquetaComentarios = __('No hay comentarios');
		elseif ($numComentarios > 1)
			$etiquetaComentarios = $numComentarios . __(' comentarios');
		else
			$etiquetaComentarios = __('1 comentario');
?>
        <div class="zentrada-lista" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
          <a href="<?php the_permalink()?>"><?php the_post_thumbnail('post_thumbnail', ['class' => 'img-fluid', 'itemprop' => 'image']) ?></a>
          <article class="px-4 px-sm-5 pt-4 pb-4 pb-sm-5 entrada formato-entrada-wp-<?php echo $wpTipoEntrada ?>">
            <header class="mb-5">
              <h1 class="text-center mt-4 mb-3" itemprop="headline"><a href="<?php the_permalink()?>"><?php the_title() ?></a></h1>
				<div class="d-sm-none">
					<ul class="list-unstyled">
						<li><span class="fa fa-fw fa-calendar" aria-hidden="true"></span><span class="sr-only"><?php _e('Fecha:') ?></span> <time datetime="<?php the_time('Y-m-d'); ?>" itemprop="datePublished"><?php the_time('j F, Y'); ?></time></li>
						<li><span class="fa fa-fw fa-user" aria-hidden="true"></span><span class="sr-only"><?php _e('Autor:') ?></span> <span itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><?php the_author() ?></span></li>
						<li><span class="fa fa-fw fa-newspaper-o" aria-hidden="true"></span> <?php the_category(', ') ?></li>
						<li><span class="fa fa-fw fa-comments-o" aria-hidden="true"></span><span class="sr-only"><?php _e('Comentarios:') ?></span> <?php echo $etiquetaComentarios ?></li>
						<?php if (is_user_logged_in()) : ?>
							<li><?php edit_post_link(null, '<span class="fa fa-fw fa-pencil" aria-hidden="true"></span>') ?></li>
						<?php endif ?>
					</ul>
				</div>
				<div class="d-none d-sm-block">
					<ul class="list-inline text-center">
						<li class="list-inline-item"><span class="fa fa-fw fa-calendar" aria-hidden="true"></span><span class="sr-only"><?php _e('Fecha:') ?></span> <time datetime="<?php the_time('Y-m-d'); ?>" itemprop="datePublished"><?php the_time('j F, Y'); ?></time></li>
						<li class="list-inline-item"><span class="fa fa-fw fa-user" aria-hidden="true"></span><span class="sr-only"><?php _e('Autor:') ?></span> <span itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><?php the_author() ?></span></li>
						<li class="list-inline-item"><span class="fa fa-fw fa-newspaper-o" aria-hidden="true"></span> <?php the_category(', ') ?></li>
						<li class="list-inline-item"><span class="fa fa-fw fa-comments-o" aria-hidden="true"></span><span class="sr-only"><?php _e('Comentarios:') ?></span> <?php echo $etiquetaComentarios ?></li>
						<?php if (is_user_logged_in()) : ?>
							<li class="list-inline-item"><?php edit_post_link(null, '<span class="fa fa-fw fa-pencil" aria-hidden="true"></span>') ?></li>
						<?php endif ?>
					</ul>
				</div>
            </header>
            <div itemprop="text"><?php the_content(__('Sigue leyendo &rarr;')) ?></div>
            <?php wp_link_pages($opcionesPaginadoEntrada) ?>
          </article>
        </div>
<?php
	endwhile
?>
        <!-- Paginado -->
        <!-- nav class="paginado" role="navigation">
          <h1 class="sr-only"><?php __('ir a las entradas') ?></h1>
        </nav-->
<?php
	// Paginado
	paginado();
else :
	echo '<p>Lo sentimos, no hay ninguna entrada.</p>';
endif

?>
      </div>
      <div class="<?php echo BS_COL_SIDEBAR ?>"><?php get_sidebar() ?></div>
    </div>
  </div>
</main>
<?php

// Pie de página
get_footer();