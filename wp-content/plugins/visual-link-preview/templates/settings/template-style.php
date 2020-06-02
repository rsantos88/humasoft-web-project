.vlp-link-container {
    background: <?php echo VLP_Settings::get( 'custom_style_background_color' ); ?>;

    border-radius: <?php echo VLP_Settings::get( 'custom_style_border_radius' ); ?>px;
    border-width: <?php echo VLP_Settings::get( 'custom_style_border_width' ); ?>px;
    border-style: <?php echo VLP_Settings::get( 'custom_style_border_style' ); ?>;
    border-color: <?php echo VLP_Settings::get( 'custom_style_border_color' ); ?>;

    padding: <?php echo VLP_Settings::get( 'custom_style_padding' ); ?>px;
}

.vlp-template-default .vlp-link-image img {
    border-radius: <?php echo VLP_Settings::get( 'custom_style_image_border_radius' ); ?>px;
}

.vlp-template-default .vlp-link-title {
    color: <?php echo VLP_Settings::get( 'custom_style_title_color' ); ?>;
    font-size: <?php echo VLP_Settings::get( 'custom_style_title_size' ); ?>px;
}

.vlp-template-default .vlp-link-summary {
    color: <?php echo VLP_Settings::get( 'custom_style_summary_color' ); ?>;
    font-size: <?php echo VLP_Settings::get( 'custom_style_summary_size' ); ?>px;
}

<?php if ( '' !== VLP_Settings::get( 'custom_style_max_width' ) ) : ?>
.vlp-link-container {
    max-width: <?php echo VLP_Settings::get( 'custom_style_max_width' ); ?>px;

    <?php if ( 'center' === VLP_Settings::get( 'custom_style_alignment' ) || 'right' === VLP_Settings::get( 'custom_style_alignment' ) ) : ?>
    margin-left: auto;
    <?php endif; ?>
    <?php if ( 'center' === VLP_Settings::get( 'custom_style_alignment' ) ) : ?>
    margin-right: auto;
    <?php endif; ?>
}
<?php endif; ?>

<?php if ( 'right' === VLP_Settings::get( 'custom_style_image_position' ) ) : ?>
.vlp-template-default { flex-direction: row-reverse; }
.vlp-template-default .vlp-link-image { padding-right: 0; padding-left: 10px; }
<?php endif; ?>
<?php if ( 'top' === VLP_Settings::get( 'custom_style_image_position' ) ) : ?>
.vlp-template-default { flex-direction: column; }
.vlp-template-default .vlp-link-image { padding-right: 0; padding-bottom: 10px; }
<?php endif; ?>
<?php if ( 'bottom' === VLP_Settings::get( 'custom_style_image_position' ) ) : ?>
.vlp-template-default { flex-direction: column-reverse; }
.vlp-template-default .vlp-link-image { padding-right: 0; padding-top: 10px; }
<?php endif; ?>