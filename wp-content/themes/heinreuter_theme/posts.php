<?php get_header(); ?>
 <style>
	 iframe
	 {
		 height: 315px !important;
	 }
	 body
	 {
		 max-width: 100%;
	 }
</style>

   <div class="container-fluid content-container  wrap pt-1 pt-5 pl-0 pr-0 ">
<div class="row ">
<div class="col-11 ml-3 ml-md-5 offset-md-0 pl-md-0 col-md-11  pl-lg-0 mb-5" >
	<h1 class="ft-yellow">News</h1>
	
	</div>
	</div>
	<div class="row ml-xl-3 mr-xl-3 ml-lg-2 mr-lg-2">
<?php

global $post;
$args = array( 'posts_per_page' => 12);

$myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post ); ?>

		
			<div class="col-xl-4">
				<div class="alert mb-0 bg-gold col-md-4 col-xl-12 border border-white horizontal-vertical-align pl-md-5" role="alert">
			<h4 class="ft-yellow" style="line-height:4em;"><a href="<?php the_permalink(); ?>" style="color:black"><?php the_title(); ?></a></h6>
			</div>
			<div class="alert alert-secondary border border-white col-md-7 col-xl-12 mr-md-5 pl-5" style="min-height:440px" role="alert">
 					<p class="mb-0 pl-4 ml-2 pl-md-0 ml-md-0" style="font-size:1.5em; line-height: 3em;"><?php the_time('j. F Y') ?></p>
				
				<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
				
				<p class="card-text "><?php the_excerpt(); ?></p>
			</div>
			
		
		
			</div>
			
	
<?php endforeach; 
		
wp_reset_postdata();?>

       </div><!-- main -->

 
<?php get_footer(); ?>