<?php

/* Template name: Blogroll */

/**
 * Plantilla de WordPress: Blogroll.
 *
 * @package locoymedio\wordpress\tema\plantillas
 * @link https://developer.wordpress.org/reference/functions/edit_post_link/
 */

// Carga información de la página
the_post();

// Etiqueta de comentarios
$numComentarios = get_comments_number();
if (!$numComentarios) :
	$etiquetaComentarios = __('No hay comentarios');
elseif ($numComentarios > 1) :
	$etiquetaComentarios = $numComentarios . __(' comentarios');
else :
	$etiquetaComentarios = __('1 comentario');
endif;

// Muestra cabecera de la página
get_header();

// Google AdSense
if (ACT_ADSENSE) :
	$bloqueAdSense = trim(get_option('lcm_opcion_adsense_sup'));
	if ($bloqueAdSense != '') :
		echo "<div class=\"zpub container\">$bloqueAdSense</div>";
	endif;
endif;

?>
<main>
  <div class="container">
    <div class="row">
      <div class="<?php echo BS_COL_CENTRO ?>">
        <div class="zentrada-lista">
          <a href="<?php the_permalink()?>"><?php the_post_thumbnail('post_thumbnail', array('class' => 'img-fluid')) ?></a>
          <article class="px-5 pt-4 pb-5 caja-pagina">
            <header>
              <h1 class="text-center mt-4 mb-3"><a href="<?php the_permalink()?>"><?php the_title() ?></a></h1>
              <ul class="list-inline text-center">
                <li class="list-inline-item"><span class="fa fa-fw fa-comments-o"></span><span class="sr-only"><?php _e('Comentarios:') ?></span> <?php echo $etiquetaComentarios ?></li>
<?php

if (is_user_logged_in()) :
?>
                <li class="list-inline-item"><?php edit_post_link(null, '<span class="fa fa-fw fa-pencil" aria-hidden="true"></span>') ?></li>
<?php
endif;

?>
              </ul>
            </header>
<?php

// Google AdSense
if (ACT_ADSENSE) :
	$bloqueAdSense = trim(get_option('lcm_opcion_adsense_entrada'));
	if ($bloqueAdSense != '') :
		echo $bloqueAdSense;
	endif;
	echo '<br />';
endif;
?>
            <?php the_content() ?>
            <hr />
            <?php $marcadores = get_bookmarks() ?>
            <?php $numMarcadores = count($marcadores) ?>
            <?php if ($numMarcadores > 0) : ?>
              <dl class="row">
              <?php for ($i = 0; $i < $numMarcadores; $i++) : ?>
                <?php $marcador = $marcadores[$i] ?>
                <dt class="col-sm-3"><a href="<?php echo $marcador->link_url ?>" target="<?php echo $marcador->link_target ?>"><?php echo $marcador->link_name ?></a></dt>
                <dd class="col-sm-9"><?php echo $marcador->link_description ?></dd>
              <?php endfor ?>
              </dl>
            <?php endif ?>
          </article>
        </div>
        <?php comments_template() ?>
      </div>
      <div class="<?php echo BS_COL_SIDEBAR ?>"><?php get_sidebar() ?></div>
    </div>
  </div>
</main>
<?php

// Pie de página
get_footer();

?>