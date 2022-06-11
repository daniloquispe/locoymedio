/**
 * Funciones varias.
 * 
 * @author Danilo Quispe Lucana
 */

jQuery(function()
{
	// Paginado de entrada antes que widgets de Jetpack
	jQuery('.entrada').each(function()
	{
		jQuery(this).find('.paginado-entrada').insertBefore(jQuery(this).find('.sharedaddy').first());
	});
});