<?php
/**
 * The template for displaying search forms in gbteddybear
 *
 * @package gbteddybear
 * @since gbteddybear 1.0
 */
?>
	<form method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<input type="text" class="field" name="s" placeholder="SEARCH" value="<?php echo esc_attr( get_search_query() ); ?>" />
		<input type="submit" class="submit" value="&raquo;" />
	</form>
