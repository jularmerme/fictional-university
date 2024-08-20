<?php

  function pageBanner($args = NULL) { 
    // php logic will live here 

    if(!isset($args['title'])) {
      $args['title'] = get_the_title();
    }

    if(!isset($args['subtitle'])) {
      $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if(!isset($args['photo'])) {
      if(get_field('page_banner_background_image') AND !is_archive() AND !is_home()) {
        $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
      } else {
        $args['photo'] = get_template_directory_uri() . '/images/ocean.jpg';
        // or $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
      }
    }
?>

    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo  $args['photo']; ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
          <?php 
            //if(the_field('page_banner_subtitle')) {
              echo '<p>' . $args['subtitle'] . '</p>';
           // }
          ?>
        </div>
      </div>
    </div>

<?php }

  function university_files() {
    wp_enqueue_script( 'main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true );
    wp_enqueue_style( 'university_main_style', get_theme_file_uri('/build/style-index.css') );
    wp_enqueue_style( 'university_extra_style', get_theme_file_uri('/build/index.css') );
    wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  }

  add_action( 'wp_enqueue_scripts', 'university_files' );

  function university_features() {
    register_nav_menu( 'headerMenuLocation', 'Header Menu Location' );
    register_nav_menu( 'footerLocationOne', 'Footer Location 1' );
    register_nav_menu( 'footerLocationTwo', 'Footer Location 2' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    // Customize some image size for better use
    add_image_size( 'professorPic', 400, 260, true);
    add_image_size( 'professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
  }

  add_action( 'after_setup_theme', 'university_features' );

  function university_adjust_queries($query) {
    if( !is_admin() AND is_post_type_archive('program') AND $query->is_main_query() ) {
      $query->set('orderby', 'title');
      $query->set('order', 'ASC');
      $query->set('posts_per_page', '2');
    }

    if ( !is_admin() AND is_post_type_archive('event') AND $query->is_main_query() ) {
      $todayDate = date('Ymd');
      $query->set( 'meta-key', 'event_date' );
      $query->set( 'orderby', 'meta_value_num' );
      $query->set( 'order', 'ASC' );
      $query->set( 'meta_query', array(
        array(
          'key'         => 'event_date',
          'compare'  => '>=',
          'value'      => $todayDate,
          'type'       => 'numeric'
        )
      ) );
    }
  }

  add_action( 'pre_get_posts', 'university_adjust_queries' );

  // Function to visualize better the code
  function printr($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  }

  // Deactivate Gutenberg Editor
  add_filter('use_block_editor_for_post', '__return_false');