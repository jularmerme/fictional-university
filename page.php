<?php

  get_header();

  while( have_posts() )  {
  the_post(); 

  $args = array(
    'title' => 'Hello there this is the title',
    'subtitle' => 'Hi, this is the subtitle',
    'photo' => ''
  );
  
  pageBanner();
  
?>

    <div class="container container--narrow page-section">

      <?php
        $_parent_id = wp_get_post_parent_id(get_the_ID());
        if ( $_parent_id ) {
      ?>
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($_parent_id); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($_parent_id); ?></a> 
            <span class="metabox__main"><?php the_title(); ?></span>
        </p>
      </div>
      <?php } ?>

      <?php
        $testArray = get_pages(array(
          'child_of' => get_the_ID(),
        ));

        if ( $_parent_id or $testArray ) { ?>
        <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo get_permalink($_parent_id); ?>"><?php echo get_the_title($_parent_id); ?></a></h2>
            <ul class="min-list">
              <?php 
                if( $_parent_id ) {
                  $findChildrenOf = $_parent_id;
                } else {
                  $findChildrenOf = get_the_ID();
                }
                wp_list_pages(array(
                  'title_li' => NULL,
                  'child_of' => $findChildrenOf, 
                  'sort_column' => 'menu_order'
                )); ?>
            
            </ul>
          </div>
        <?php } ?>

      <div class="generic-content">
        <?php the_content(); ?>
      </div>
    </div>

<?php } ?>

<?php get_footer(); ?>