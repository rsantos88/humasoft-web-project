<?php

				//Striker Child Theme

				add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

				function my_theme_enqueue_styles() {
					$parenthandle = 'style'; // This is 'style' for the Striker theme.
					$theme = wp_get_theme();
					
					wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
						array(),  // if the parent theme code has a dependency, copy it to here
						$theme->parent()->get('Version')
					);
					
					wp_enqueue_style( 'child-style', get_stylesheet_uri(),
						array( $parenthandle ),
						$theme->get('Version') // this only works if you have Version in the style header
					);
					
				
				//Striker child theme javascript js file
					wp_enqueue_script('child-theme-js', get_stylesheet_directory_uri() . '/script.js', array( 'jquery' ), '1.0', true );
					
				}


				/* CUSTOM PHP CODE GOES HERE */
?>		