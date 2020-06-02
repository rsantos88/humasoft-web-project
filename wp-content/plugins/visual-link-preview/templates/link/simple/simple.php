<div class="vlp-link-container vlp-template-default <?php echo $link->custom_class(); ?>">
	<?php echo $link->output_url(); ?>
	<?php if ( $link->image_id() ) : ?>
	<div class="vlp-link-image-container">
		<div class="vlp-link-image">
			<?php
			$size = array( 150, 999 );

			if ( VLP_Settings::get( 'template_use_custom_style' ) ) {
				$size = VLP_Settings::get( 'custom_style_image_size' );

				preg_match( '/^(\d+)x(\d+)$/i', $size, $match );
				if ( ! empty( $match ) ) {
					$size = array( intval( $match[1] ), intval( $match[2] ) );
				}
			}

			echo $link->image( $size );
			?>
		</div>
	</div>
	<?php endif; // Image ID. ?>
	<div class="vlp-link-text-container">
		<?php if ( $link->title() ) : ?>
		<div class="vlp-link-title">
			<?php echo wp_kses_post( $link->title() ); ?>
		</div>
		<?php endif; // Title. ?>
		<?php if ( $link->summary() ) : ?>
		<div class="vlp-link-summary">
			<?php echo wp_kses_post( $link->summary() ); ?>
		</div>
		<?php endif; // Summary. ?>
	</div>
</div>
