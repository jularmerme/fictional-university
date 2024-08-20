<?php 

  get_header();

  while( have_posts() ) {
  the_post(); 

  $pageBannerImage = get_field('page_banner_background_image');

  pageBanner();

?>



<div class="container container--narrow page-section">

  <div class="generic-content">
    <div class="row group">
      <div class="one-third">
        <?php the_post_thumbnail('professorPortrait'); ?>
      </div>
      <div class="two-thirds">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
      <hr class="section-break">
  <?php } 

  $relatedPrograms = get_field('related_programs');

  if ($relatedPrograms) {
    echo '<h2 class="headline headline--medium">Subject(s) Taught</h3>';
    echo '<ul class="link-list min-list">';
    foreach( $relatedPrograms as $program ) { ?>
      
      <li> <a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
  
    <?php }
    echo '</ul>';
  }

  ?>

</div>



<?php get_footer(); ?>
