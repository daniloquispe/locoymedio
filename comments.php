<?php

/**
 * Plantilla de WordPress: Comentarios.
 *
 * Muestra la lista de comentarios y el formulario para enviar un comentario o una respuesta.
 *
 * Los comentarios deben mostrarse como una lista HTML (elemento `<ul>`) para que WordPress pueda hacer el anidamiento de comentarios correctamente.
 *
 * @package locoymedio\wordpress\tema\plantillas
 * @author Danilo Quispe Lucana <dquispe@isolperu.com>
 * @link https://developer.wordpress.org/reference/functions/have_comments/
 * @link http://www.studiograsshopper.ch/code-snippets/customising-wp_list_comments/
 * @link https://franciscoamk.com/personalizar-formulario-de-comentarios-wordpress/
 *
 * @todo Diferenciar los comentarios de los pingbacks.
 */

/**
 * Muestra un comentario de la lista.
 *
 * No es necesario invocar directamente a esta función, WordPress la ejecutará desde la función `wp_list_comments()`.
 *
 * @param WP_Comment $wpComentario
 * @param array $wpArgs
 * @param int $nivel
 */
function comentario($wpComentario, $wpArgs, $nivel)
{
	$GLOBALS['comment'] = $wpComentario;
	$esPingback = $wpComentario->comment_type == 'pingback';
	// Clase CSS
	// (si el comentario es del mismo autor de la entrada, se destaca mediante una clase CSS)
	$claseCajaComentario = 'caja-comentario';
	if ($wpComentario->user_id == get_the_author_meta('ID'))
		$claseCajaComentario .= ' caja-comentario-autor';
	// Genera la caja del comentario
	echo '<li class="' . $claseCajaComentario . '" id="comentario-' . get_comment_id() . '">';
	echo '<footer>';
	if ($esPingback)
		echo '<div class="text-center">Pingback:</div>';
	else
		echo get_avatar($wpComentario, 64, '', get_comment_author(), ['class' => ['mx-auto', 'd-block']]);
	if ($esPingback)
		echo '<p><a href="' . get_comment_author_url() . '">' . get_comment_author() . '</a></p>';
	else
		echo '<p>' . get_comment_author() . '</p>';
	echo '</footer>';
	comment_text();
	echo '<div class="caja-comentario-meta">';
	echo '<ul class="list-inline">';
	if (!$esPingback)
		echo '<li class="list-inline-item"><span class="fa fa-fw fa-reply"></span> ' . get_comment_reply_link(array_merge($wpArgs, ['depth' => $nivel, 'max_depth' => $wpArgs['max_depth']])) . '</a></li>';
	echo '<li class="list-inline-item"><span class="fa fa-fw fa-calendar"></span><span class="sr-only">' . __('Fecha:') . '</span> <time datetime="' . get_comment_time('Y-m-j') . '">' . get_comment_time('j F, Y') . '</time></li>';
	if (is_user_logged_in())
		echo '<li class="list-inline-item"><span class="fa fa-fw fa-pencil"></span> <a href="' . get_edit_comment_link() . '">' . __('Editar') . '</a></li>';
	echo '</ul>';
	echo '</div>';
	echo '</li>';
}

?>
<!-- Lista de comentarios -->
<div class="zcomentarios">
<?php

// Lista de comentarios
if (have_comments()) :
	// Título de la lista de comentarios
	$numComentarios = get_comments_number();
	if ($numComentarios > 1) :
		$tituloListaComentarios = "$numComentarios comentarios en \"" . get_the_title() . "\"";
	else :
		$tituloListaComentarios = "1 comentario en \"" . get_the_title() . "\"";
	endif;
?>
  <h2><?php echo $tituloListaComentarios ?></h2>
  <ul class="list-unstyled">
<?php
	$args = array(
		'callback' => 'comentario',
		'avatar_size' => 64,
	);
	wp_list_comments($args);
?>
  </ul>
<?php
endif;

?>
</div>
<!-- Formulario de comentarios -->
<div class="entrada-lista">
<?php

// Formulario de comentarios
if (comments_open()) :
	$args = array(
		'title_reply' => __('Déjame un comentario', 'locoymedio'),
		'title_reply_to' => __('Responde a %s', 'locoymedio'),
		'fields' => array(
			'author' => '<div class="form-group"><label for="author">' . __('Nombre') . ' <span class="required">*</span></label><input type="text" class="form-control" id="author" name="author" aria-required="true" required="required" /></div>',
			'email'  => '<div class="form-group"><label for="email">' . __('Correo electrónico') . ' <span class="required">*</span></label><input type="email" class="form-control" id="email" name="email" aria-required="true" required="required" /></div>',
			'url'    => '<div class="form-group"><label for="url">' . __('Web') . '</label><input type="url" class="form-control" id="url" name="url" /></div>'
		),
		'comment_field' => '<div class="form-group"><label for="comment">' . __('Comentario') . ' <span class="required">*</span></label><textarea class="form-control" rows="8" id="comment" name="comment" aria-required="true" required="required"></textarea></div>',
		'class_submit' => 'btn btn-dark',
		'format' => 'html5');
	comment_form($args);
endif;

?>
</div>