<?php
   /** Template Name: demo

   */
   ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
<?php get_header(); ?>

<?php
   /**
    * Template name: AJAX Post Filter by Taxonomy
    *
    */


   //query
   $args = array(
   	'post_type' => 'work',
   	'posts_per_page' => 20,

   );

   $query = new WP_Query( $args );

   $tax = 'post_tag';
   $terms = get_terms( $tax );
   $count = count( $terms );

   if ( $count > 0 ): ?>

<div class="container" >
	<!-- post menu  -->
   <div class="post-tags text-center">
      <h2>OUR WORK </h2>
      <div>
         <ul class="sub-menus">
            <li><a  href="http://site.com" class="tax-filter text-select ">ALL</a></li>
            <?php
               foreach ( $terms as $term ) {
               	$term_link = get_term_link( $term, $tax );

               	echo '<li><a href="' . $term_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a></li> ';
               } ?>
            <hr class="border-new" >
         </ul>
      </div>
   </div>
	 <!-- post menu end  -->
</div >

<?php endif; ?>
<section class="container-fluid container-custom" >
   <div class="posts-container" >
      <?php
         if ( $query->have_posts() ): ?>
      <div class="tagged-posts">
         <?php while ( $query->have_posts() ) : $query->the_post(); ?>
          <!--get logo from custom types -->
         <?php  $logo_img =  get_post_meta($post->ID, 'ptb_work_logo_image', true); ?>
          <!-- get feature image -->
         <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
         <div id="main-content" class="text-right" style="background: linear-gradient(to right,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.83) 74%,rgba(0,0,0,0.83) 100%), url('<?php echo $backgroundImg[0]; ?>') no-repeat;  background-size: cover; ">
            <div id="inside" class="news-list-content">
               <div class="post-container">
                  <div class="img-style" >
                     <img src = "<?php echo $logo_img ?>" >
                  </div>
                  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                  <p>   <?php    echo get_post_field(''); ?>  </p>
                  <?php
                     $tags = get_the_tags($post->ID);
                     foreach ( $tags as $tag) {

                     echo '<a>   ' . $tag->name . ',</a> ';
                     } ?>
               </div>
            </div>
         </div>
         <?php endwhile; ?>
      </div>
      <?php else: ?>
      <div class="tagged-posts">
         <h2>No posts found</h2>
      </div>
   </div>
   <?php endif; ?>
</section>
<?php get_footer(); ?>
