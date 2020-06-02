<?php

$settings_structure = array(
    array(
        'id' => 'documentation',
        'name' => __( 'Documentation', 'visual-link-preview' ),
        'description' => __( 'Use Visual Link Preview to create beautiful call to action links to your own posts or external websites.', 'visual-link-preview' ),
        'documentation' => 'https://help.bootstrapped.ventures/collection/164-visual-link-preview',
        'icon' => 'support',
    ),
    array(
        'id' => 'template',
        'name' => __( 'Template', 'visual-link-preview' ),
        'icon' => 'doc',
        'settings' => array(
            array(
                'id' => 'template_default',
                'name' => __( 'Default Template', 'visual-link-preview' ),
                'description' => __( 'Default template to use for your visual links.', 'visual-link-preview' ),
                'type' => 'dropdown',
                'optionsCallback' => function() {
                    $options = array();

                    $templates = VLP_Template_Manager::get_templates();
                    foreach ( $templates as $slug => $template ) {
                        $options[ $slug ] = $template['name'];
                    }

                    return $options;
                },
                'default' => 'simple',
            ),
            array(
                'id' => 'template_use_custom_style',
                'name' => __( 'Use Custom Styling', 'visual-link-preview' ),
                'documentation' => 'https://help.bootstrapped.ventures/article/173-changing-the-template-style',
                'type' => 'toggle',
                'default' => false,
            ),
        ),
        'subGroups' => array(
            array(
                'name' => __( 'Container', 'visual-link-preview' ),
                'dependency' => array(
                    'id' => 'template_use_custom_style',
                    'value' => true,
                ),
                'settings' => array(
                    array(
                        'id' => 'custom_style_max_width',
                        'name' => __( 'Max width', 'visual-link-preview' ),
                        'description' => __( 'Leave blank to net set a max width.', 'visual-link-preview' ),
                        'type' => 'number',
                        'suffix' => 'px',
                        'default' => '',
                    ),
                    array(
                        'id' => 'custom_style_alignment',
                        'name' => __( 'Alignment', 'visual-link-preview' ),
                        'type' => 'dropdown',
                        'options' => array(
                            'left' => __( 'Left', 'visual-link-preview' ),
                            'center' => __( 'Center', 'visual-link-preview' ),
                            'right' => __( 'Right', 'visual-link-preview' ),
                        ),
                        'default' => 'center',
                        'dependency' => array(
                            'id' => 'custom_style_max_width',
                            'value' => '',
                            'type' => 'inverse',
                        ),
                    ),
                    array(
                        'id' => 'custom_style_background_color',
                        'name' => __( 'Background Color', 'visual-link-preview' ),
                        'type' => 'color',
                        'default' => '#ffffff',
                    ),
                    array(
                        'id' => 'custom_style_padding',
                        'name' => __( 'Padding', 'visual-link-preview' ),
                        'type' => 'number',
                        'suffix' => 'px',
                        'default' => '10',
                    ),
                ),
            ),
            array(
                'name' => __( 'Border', 'visual-link-preview' ),
                'dependency' => array(
                    'id' => 'template_use_custom_style',
                    'value' => true,
                ),
                'settings' => array(
                    array(
                        'id' => 'custom_style_border_radius',
                        'name' => __( 'Border Radius', 'visual-link-preview' ),
                        'type' => 'number',
                        'suffix' => 'px',
                        'default' => '0',
                    ),
                    array(
                        'id' => 'custom_style_border_width',
                        'name' => __( 'Border Width', 'visual-link-preview' ),
                        'description' => __( 'Set to 0 to not use a border.', 'visual-link-preview' ),
                        'type' => 'number',
                        'suffix' => 'px',
                        'default' => '1',
                    ),
                    array(
                        'id' => 'custom_style_border_style',
                        'name' => __( 'Border Style', 'visual-link-preview' ),
                        'type' => 'dropdown',
                        'options' => array(
                            'solid' => __( 'Solid', 'visual-link-preview' ),
                            'dashed' => __( 'Dashed', 'visual-link-preview' ),
                            'dotted' => __( 'Dotted', 'visual-link-preview' ),
                            'double' => __( 'Double', 'visual-link-preview' ),
                            'groove' => __( 'Groove', 'visual-link-preview' ),
                            'ridge' => __( 'Ridge', 'visual-link-preview' ),
                            'inset' => __( 'Inset', 'visual-link-preview' ),
                            'outset' => __( 'Outset', 'visual-link-preview' ),
                        ),
                        'default' => 'solid',
                        'dependency' => array(
                            'id' => 'custom_style_border_width',
                            'value' => '0',
                            'type' => 'inverse',
                        ),
                    ),
                    array(
                        'id' => 'custom_style_border_color',
                        'name' => __( 'Border Color', 'visual-link-preview' ),
                        'type' => 'color',
                        'default' => '#000000',
                        'dependency' => array(
                            'id' => 'custom_style_border_width',
                            'value' => '0',
                            'type' => 'inverse',
                        ),
                    ),
                ),
            ),
            array(
                'name' => __( 'Image', 'visual-link-preview' ),
                'dependency' => array(
                    'id' => 'template_use_custom_style',
                    'value' => true,
                ),
                'settings' => array(
                    array(
                        'id' => 'custom_style_image_position',
                        'name' => __( 'Image Position', 'visual-link-preview' ),
                        'type' => 'dropdown',
                        'options' => array(
                            'left' => __( 'Left', 'visual-link-preview' ),
                            'right' => __( 'Right', 'visual-link-preview' ),
                            'top' => __( 'Top', 'visual-link-preview' ),
                            'bottom' => __( 'Bottom', 'visual-link-preview' ),
                        ),
                        'default' => 'left',
                    ),
                    array(
                        'id' => 'custom_style_image_size',
                        'name' => __( 'Image Size', 'visual-link-preview' ),
                        'description' => __( 'Enter a thumbnail name or specific size.', 'visual-link-preview' ),
                        'documentation' => 'https://help.bootstrapped.ventures/article/173-changing-the-template-style',
                        'type' => 'text',
                        'default' => '150x150',
                    ),
                    array(
                        'id' => 'custom_style_image_border_radius',
                        'name' => __( 'Image Border Radius', 'visual-link-preview' ),
                        'type' => 'number',
                        'suffix' => 'px',
                        'default' => '0',
                    ),
                ),
            ),
            array(
                'name' => __( 'Text', 'visual-link-preview' ),
                'dependency' => array(
                    'id' => 'template_use_custom_style',
                    'value' => true,
                ),
                'settings' => array(
                    array(
                        'id' => 'custom_style_title_size',
                        'name' => __( 'Title Font Size', 'visual-link-preview' ),
                        'type' => 'number',
                        'suffix' => 'px',
                        'default' => '18',
                    ),
                    array(
                        'id' => 'custom_style_title_color',
                        'name' => __( 'Title Color', 'visual-link-preview' ),
                        'type' => 'color',
                        'default' => '#000000',
                    ),
                    array(
                        'id' => 'custom_style_summary_size',
                        'name' => __( 'Summary Font Size', 'visual-link-preview' ),
                        'type' => 'number',
                        'suffix' => 'px',
                        'default' => '14',
                    ),
                    array(
                        'id' => 'custom_style_summary_color',
                        'name' => __( 'Summary Color', 'visual-link-preview' ),
                        'type' => 'color',
                        'default' => '#000000',
                    ),
                ),
            ),
        ),
    ),
);