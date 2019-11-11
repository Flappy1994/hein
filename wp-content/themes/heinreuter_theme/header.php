
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	  <title><?php echo bloginfo();?></title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	 <?php wp_head();?>
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="<?php echo get_bloginfo('template_directory');?>/blog.css" rel="stylesheet">
	      <link href="<?php echo get_bloginfo('template_directory');?>/style.css" rel="stylesheet">
	 <script type="text/javascript">

var pssConfig = {
    "host" : "https://my.lemniscus.de",
    "token" : "625dd36a-8a22-4b2d-a61d-7f19a16cc827",
    "showFooter" : "true",
    "breadcrumsBackgroundColor" : "#007bff"
}
document.write("<script type='text/javascript' src='https://my.lemniscus.de/pss/pss.nocache.js?v=" + Date.now() + "'><\/script>");
</script>
  </head>
	<style>
		@media and (max-width: 375px)
		{
			div#logoText
			{
				min-width: 100% !important;
			}
		}
	</style>
 <!--FOR BODY => data-spy="scroll" data-target=".navbar" data-offset="50"-->
  <body>
	<div class="container-fluid h-100 header-container">
	  <div class="row h-100  pb-4 justify-content-center align-items-center justify-content-lg-start align-items-lg-start">
		     
		  <div class="col-10 offset-0 offset-lg-1 offset-md-1 offset-lg-0 col-sm-8 col-md-6 col-lg-12 col-xl-2 justify-content-center p-0" id="logo">
			
			  <div class="col-6 col-lg-2 col-xl-4 hr-logo p-0 h-100  text-lg-left ml-lg-3 mr-2 mr-md-0">
			<img src="<?php echo get_template_directory_uri(); ?>/images/hr-weiss.png" width="140px" height="76px" alt="" />
				
			  </div>
			  <div class="col-6 col-xl-6 offset-6 pl-0" id="logoText">
				  <p class="font-white mb-2">HOMÖOPATHIE</p>
					<p class="font-white mb-2">AKUPUNKTUR</p>
						<p class="font-white mb-0">BAD HOMBURG</p>
			  </div>
		
			
		  </div>
		    <?php quadmenu(array("theme_location" => "header", "theme" => "default_theme")); ?>
		  
		 
		 
<!-- 

-->
	
		  <div class="text-start ml-3 ml-xl-3 pr-0 col-md-12 col-lg-12 col-xl-1 justify-content-lg-start text-lg-left ml-xl-3 ml-lg-5 pl-lg-0 mt-xl-5 pt-xl-1 pl-xl-4" id="opening">
						<?php get_sidebar('opening');?>
		  </div>		
				
					<div class="col-11 offset-1 col-md-5 content-center ml-3 ml-xl-3 pl-md-0 pb-1 pl-lg-0 col-xl-2 col-lg-5 offset-lg-0 ml-lg-5 mt-xl-5 pt-xl-0 ml-xl-7" id="suche" >
						<p class="mb-0" style="color:white;" id="textSuche">SUCHE</p>
						<?php echo do_shortcode('[ivory-search id="4423" title="Default Search Form"]'); ?>
					</div>
		</div>
	  </div>
	  

