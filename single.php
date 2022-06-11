<?php

/**
 * Plantilla de WordPress: Entrada de blog predeterminada
 *
 * @package locoymedio\wordpress\tema\plantillas
 * @uses ACT_ADSENSE Indica si están activados los avisos de Google AdSense.
 * @uses ADSENSE_AUTO Indica si están activados los avisos automáticos de Google AdSense.
 * @link https://developer.wordpress.org/reference/functions/edit_post_link/
 * @link http://www.inboundcycle.com/blog-de-inbound-marketing/como-crear-una-plantilla-de-wordpress-desde-cero-parte-2
 * @link https://blog.expertowordpress.org/2015/12/anadir-schemaorg-tu-tema-de-wordpress.html
 */

// Etiqueta de comentarios
$numComentarios = get_comments_number();
if (!$numComentarios)
	$etiquetaComentarios = __('No hay comentarios');
elseif ($numComentarios > 1)
	$etiquetaComentarios = $numComentarios . __(' comentarios');
else
	$etiquetaComentarios = __('1 comentario');

// Muestra cabecera de la página
get_header();

// Google AdSense
if (ACT_ADSENSE && ADSENSE_AUTO == '')
{
	$bloqueAdSense = trim(get_option('lcm_opcion_adsense_sup'));
	if ($bloqueAdSense != '')
		echo "<div class=\"zpub container\">$bloqueAdSense</div>";
}

?>
<main role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
  <div class="container">
    <div class="row">
      <div class="<?php echo BS_COL_CENTRO ?>">
<?php

// Loop
if (have_posts()) :
	while (have_posts()) :
		the_post();
		// Color de formato de post
		$wpTipoEntrada = get_post_format();
		// Opciones para paginado de entrada
		$opcionesPaginadoEntrada = [
			'before' => '<nav class="paginado-entrada"><p>Páginas ',
			'after' => '</p></nav>',
			'link_before' => '<span>',
			'link_after' => '</span>'];
?>
        <div class="zentrada-lista">
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
                <li class="list-inline-item"><span class="fa fa-fw fa-calendar" aria-hidden="true"></span><span class="sr-only"><?php _e('Fecha:') ?></span> <time datetime="<?php the_time('Y-m-j') ?>" itemprop="datePublished"><?php the_time('j F, Y') ?></time></li>
                <li class="list-inline-item"><span class="fa fa-fw fa-user" aria-hidden="true"></span><span class="sr-only"><?php _e('Autor:') ?></span> <span itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><?php the_author() ?></span></li>
                <li class="list-inline-item"><span class="fa fa-fw fa-newspaper-o" aria-hidden="true"></span> <?php the_category(', ') ?></li>
                <li class="list-inline-item"><span class="fa fa-fw fa-comments-o" aria-hidden="true"></span><span class="sr-only"><?php _e('Comentarios:') ?></span> <?php echo $etiquetaComentarios ?></li>
                <?php if (is_user_logged_in()) : ?>
                  <li class="list-inline-item"><?php edit_post_link(null, '<span class="fa fa-fw fa-pencil" aria-hidden="true"></span>') ?></li>
                <?php endif ?>
              </ul>
				</div>
            </header>
<?php
		// Google AdSense
		if (ACT_ADSENSE && ADSENSE_AUTO == '') :
			$bloqueAdSense = trim(get_option('lcm_opcion_adsense_entrada'));
			if ($bloqueAdSense != '') :
				echo $bloqueAdSense;
			endif;
			echo '<br />';
		endif;
?>
            <div class="contenido">
              <div itemprop="text"><?php the_content() ?></div>
              <?php wp_link_pages($opcionesPaginadoEntrada) ?>
            </div>
            <footer>
              <?php the_tags('<div class="zentrada-etiquetas"><span class="sr-only">Etiquetas:</span> ', '', '</div>') ?>
            </footer>
          </article>
        </div>
<?php
	endwhile;
endif;

// Paginado
paginadoEntrada(true);
paginadoEntrada(false);

// Comentarios
comments_template();

?>
      </div>
      <div class="<?php echo BS_COL_SIDEBAR ?>"><?php get_sidebar() ?></div>
    </div>
  </div>
</main>
<?php

// Pie de página
get_footer();