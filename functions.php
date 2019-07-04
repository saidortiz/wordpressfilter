<?php
   add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

   function enqueue_parent_styles() {
      wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
   }




   function ajax_filter_posts_scripts() {
     // Enqueue script
     wp_register_script('afp_script', get_template_directory_uri() . '/js/ajax-filter-posts.js', false, null, false);
     wp_enqueue_script('afp_script');

     wp_localize_script( 'afp_script', 'afp_vars', array(
           'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
           'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
         )
     );
   }
   add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);

   // Script for getting posts
   function ajax_filter_get_posts( $taxonomy ) {

     // Verify nonce
     if( !isset( $_POST['afp_nonce'] ) || !wp_verify_nonce( $_POST['afp_nonce'], 'afp_nonce' ) )
       die('Permission denied');

     $taxonomy = $_POST['taxonomy'];

     // WP Query
     $args = array(
       'tag' => $taxonomy,
       'post_type' => 'work',
       'posts_per_page' => 20,
     );

     // If taxonomy is not set, remove key from array and get all posts
     if( !$taxonomy ) {
       unset( $args['tag'] );
     }

     $query = new WP_Query( $args );

     if ( $query->have_posts() ) :
       while ( $query->have_posts() ) : $query->the_post();
       $logo_img =  get_post_meta(get_the_ID(), 'ptb_work_logo_image', true);
       $long = get_post_meta(get_the_ID(), 'ptb_work_long_title', true);
   		$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
     //  $all = get_defined_vars($logo_img);
       $output  .='<section class="container-fluid" >';
       $output  .='<div class="posts-container" >';
       $output .='	<div class="tagged-posts">';
       $output .=' <div id="main-content" class="text-right" style="background: linear-gradient(to right,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.83) 74%,rgba(0,0,0,0.83) 100%), url(' . $backgroundImg[0] . ') no-repeat;  background-size: cover;">';
       $output .='	<div id="inside" class="news-list-content">';
       $output .='<div class="post-container" >';
       $output .= '<div> <img src ="' . $logo_img  . '">          </div> ';
       //$output  .= '<h2><a>'. $long .'</a></h2>';
       //$output .= ' <a> '.  $logo_img  . ' </a>        ';
       $output  .= '<h2><a href="'.get_permalink().'">'. get_the_title().'</a></h2>';
       $tags = get_the_tags($post->ID);

       foreach ( $tags as $tag) {

       $output .= '<a>   ' . $tag->name . ',</a> ';
       }
       $output .='	</section>';
       $result = 'success';

     endwhile; else:
       $output = '<h2>No posts found</h2>';
       $result = 'fail';
     endif;

     $response = json_encode($output);
     echo $response;


     die();
   }

   add_action('wp_ajax_filter_posts', 'ajax_filter_get_posts');
   add_action('wp_ajax_nopriv_filter_posts', 'ajax_filter_get_posts');




   ?>
