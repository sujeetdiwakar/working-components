<div class="content__user-menu">
	<?php
	if ( has_nav_menu( 'dashboard' ) ) {
		wp_nav_menu(
			[
				'container'      => '',
				'theme_location' => 'dashboard',
			]
		);
	}
	?>
</div>
