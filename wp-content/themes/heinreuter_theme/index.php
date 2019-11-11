<?php
/**
* Template Name: Landing-Page
*
*/
?>

<?php get_header(); ?>

<img class="img-fluid" src="http://heinreuter.de/wp-content/uploads/2019/09/hein_landingpage.jpg"/>

	<div class="container-fluid content-container p-0">
<div class="row justify-content-center">
	<div class="col-12 pl-0 pr-0">
	
		
<div class="content-margin">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		
			<?php the_content(); ?>
		

		<?php endwhile; ?>

		<?php endif; ?>	
		<!-- Div Bugfix -->
		</div>
	</div>
</div>
</div>
<?php get_footer(); ?>
