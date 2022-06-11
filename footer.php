<?php

/**
 * Zona inferior (pie de página)
 *
 * @package locoymedio\wordpress\tema\plantillas
 * @link https://blog.expertowordpress.org/2015/12/anadir-schemaorg-tu-tema-de-wordpress.html
 */

// Texto de licencia
$textoLicencia = nl2br(get_option('lcm_opcion_pie_licencia'));

?>
<footer id="zpie" role="contentinfo" itemscope="itemscope" itemtype="https://schema.org/WPFooter">
	<div class="container zlicencias">
		<?php echo $textoLicencia ?>
		<p><?php _e('Funciona con WordPress') ?> <?php bloginfo('version') ?>. <?php _e('Tema "Loco y medio" (versión 0.7.5) creado por') ?> <a href="https://www.isolperu.com" target="_blank" title="Soluciones en Internet: Web. E-marketing. Hosting. Software">Danilo Alejandro Quispe Lucana</a>. &copy; <?php echo date('Y') ?></p>
		<?php wp_footer() ?>
	</div>
</footer>
<script>
jQuery(function($)
{
	// Campos estilo Bootstrap
	$('select').addClass('form-control');
});
// Paginado no móvil
jQuery('.paginado-nomovil .enlaces > div').hover(
    function()
    {
        jQuery(this).addClass('animated shake');
    },
    function()
    {
        jQuery(this).removeClass('animated shake');
    });
</script>
</body>
</html>