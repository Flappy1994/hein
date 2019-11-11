<?php
/*
 * Template Name: Einzelseite
  *Template Post Type: post, page, product
  */
get_header(); ?>

<div class="container-fluid content-container col-12 wrap pt-1 pt-md-5 pl-md-0 pr-md-0 pb-4">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="col-10 col-xs-11 offset-1 offset-md-1 pr-0 pl-0">
		<h1 class="card-title col-md-12 pl-0"><?php the_title() ?></h1>
		
		
		<div class="col-md-12 pl-0 pr-0 d-none d-md-block">
			
			</div>

		
		<div class="col-md-11  pl-0 pr-0 mt-5">
			<?php the_content(); ?>
		</div>

		<?php endwhile; ?>
	</div>
		<?php endif; ?>	

	
</div>

<?php get_footer();?>
