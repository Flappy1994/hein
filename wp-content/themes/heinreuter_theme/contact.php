<?php
/*
 * Template Name: Kontakt
  *Template Post Type: page
  */
get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="container-fluid content-container col-12" style="height: 100%">
<div class="row justify-content-center">
	<div class="col-10 mt-5">
		<h1><?php the_title() ?></h1>
			<?php the_content(); ?>
		<?php endwhile; ?>
		<?php endif; ?>		
		<iframe class="border google-maps" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1276.1065049029842!2d8.61113034004543!3d50.23192536135316!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47bd0783498ccc45%3A0xb37964bdcfcf4e34!2sDr.+med.+Hein+Reuter+-+Arzt+f%C3%BCr+Allgemeinmedizin!5e0!3m2!1sde!2sde!4v1548172918057"width="100%" height="650" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
</div>
</div>
<?php get_footer();?>