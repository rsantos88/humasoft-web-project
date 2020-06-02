<?php
/*
 * Template Name: Custom Home Page
 * Description: A home page with featured slider and widgets.
 *
 * @package Striker
 * @since Striker 1.0
 */

get_header(); ?>

	<div class="flex-container">
              <div class="flexslider">
                <ul class="slides">
                <?php $the_query = new WP_Query(array(
				  'category_name' => 'featured', 'posts_per_page' => 3
				  ));
				?>
    			  <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
                  <li>
                    <?php the_post_thumbnail(); ?>
                    <div class="caption_wrap">
                    <div class="flex-caption">
                    <div class="flex-caption-title">
                    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                    </div>
                    <p><?php echo striker_get_slider_excerpt(); ?>
                    <a href="<?php the_permalink() ?>">...</a></p>
                    </div>
                    </div>
                  </li>
                <?php
                    endwhile;
                ?>
                </ul>
              </div>
	</div>
        
        
        <div id="primary_home" class="content-area">
			<div id="content" class="fullwidth" role="main">
            
     <div class="featuretext">
			 <h3><?php echo esc_attr( get_theme_mod( 'featured_textbox' ) ); ?></h3>
              <div class="featuretext_button">
            <?php if ( get_theme_mod( 'featured_button_url' ) ) : ?>
			<a href="<?php echo esc_url( get_theme_mod( 'featured_button_url' ) ); ?>" ><?php echo __('Find Out More', 'striker'); ?></a>
			<?php endif; ?>
			</div>
	</div>
    
    <div class="section_thumbnails group">
	<?php echo '<h3>' . __('Recent Posts', 'striker') . '</h3>'; ?>
    
  <?php $the_query = new WP_Query(array(
  'showposts' => 4,
  'post__not_in' => get_option("sticky_posts"),
  ));
 ?>
    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
    <div class="col span_1_of_4">
    <article class="recent">
                
				<?php
			if ( has_post_thumbnail() ) {
    $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'recent' );
     echo '<img alt="post" class="imagerct" src="' . $image_src[0] . '">';
}
  			?>
                 <div class="recent_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
				
    </article>
    </div>	
		
	<?php endwhile; ?>

    </div>

	<div class="section group">
    
	<div class="col span_1_of_3">
    <?php if ( is_active_sidebar( 'left_column' ) && dynamic_sidebar('left_column') ) : else : ?>
         <div class="widget">
			<?php echo '<h4>' . __('Widget Ready', 'striker') . '</h4>'; ?>
            <?php echo '<p>' . __('This left column is widget ready! Add one in the admin panel.', 'striker') . '</p>'; ?>
            </div>     
	<?php endif; ?>  
		</div>
        
	<div class="col span_1_of_3">
	<?php if ( is_active_sidebar( 'center_column' ) && dynamic_sidebar('center_column') ) : else : ?>
         <div class="widget">
			<?php echo '<h4>' . __('Widget Ready', 'striker') . '</h4>'; ?>
            <?php echo '<p>' . __('This center column is widget ready! Add one in the admin panel.', 'striker') . '</p>'; ?>
            </div>     
	<?php endif; ?> 

	</div>
    
	<div class="col span_1_of_3">
	<?php if ( is_active_sidebar( 'right_column' ) && dynamic_sidebar('right_column') ) : else : ?>
         <div class="widget">
			<?php echo '<h4>' . __('Widget Ready', 'striker') . '</h4>'; ?>
            <?php echo '<p>' . __('This right column is widget ready! Add one in the admin panel.', 'striker') . '</p>'; ?>
            </div>     
	<?php endif; ?> 
	</div>
	</div>

                
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>