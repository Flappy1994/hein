<?php
/*
 * Template Name: Termine
  *Template Post Type: post, page, product
  */
get_header(); ?>
<div class="container-fluid content-container col-12 wrap pt-1 pt-md-5 pl-md-0 pr-md-0 pb-4">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="col-10 offset-md-1 pr-0 pl-0">
	<div class="row">
		
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<?php the_content(); ?>
			</div>
			
				
				<div class="col-md-8  pr-0  d-md-block" id="pss" style="margin: 0px 30px 30px 30px auto; height:100%;" >
			<h2>Terminanfrage</h2>
			</div>
				
		
		</div>
		

	

		<?php endwhile; ?>
	</div>
		<?php endif; ?>	

	
</div>

<?php get_footer();?>
