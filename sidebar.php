<?php

/**
 * Barra lateral [*sidebar*] para las entradas del blog.
 *
 * @package locoymedio\wordpress\tema
 * @author Danilo Quispe Lucana <dquispe@isolperu.com>
 * @uses ACT_ADSENSE Indica si están activados los avisos de Google AdSense.
 * @uses ADSENSE_AUTO Indica si están activados los avisos automáticos de Google AdSense.
 * @link https://blog.expertowordpress.org/2015/12/anadir-schemaorg-tu-tema-de-wordpress.html
 */

// Google AdSense
if (ACT_ADSENSE && ADSENSE_AUTO == '') :
	$bloqueAdSense = trim(get_option('lcm_opcion_adsense_sup'));
	if ($bloqueAdSense != '') :
		echo "<div class=\"sidebar-widget container\">$bloqueAdSense</div>";
	endif;
endif;

?>
<aside role="complementary" itemscope="itemscope" itemtype="https://schema.org/WPSideBar">
  <?php dynamic_sidebar('sidebar') ?>
  <div class="clearfix"></div>
  <!-- AdSense -->
  <?php if (false && ACT_ADSENSE && ADSENSE_AUTO == '') : ?>
    <?php $bloqueAdSense = trim(get_option('lcm_opcion_adsense_sup')) ?>
    <?php if ($bloqueAdSense != '') : echo $bloqueAdSense; endif; ?>
  <?php endif; ?>
</aside>