<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header();

$format = get_post_format();
$categories = get_the_terms($post->ID, 'category');

while (have_posts()): the_post();

  get_template_part('template-parts/header-content', 'page');
  ?>

		<div id="content-area" class="wrapper sidebar">
      <main id="main" class="site-main" role="main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <section class="wrapper-content">
            <?= do_shortcode("[slider id='" . $post->ID . "']");?>
          </section>
        </article>
      </main><!-- #main -->
		</div><!-- #primary -->
	<?php
endwhile; // End of the loop.

// get_sidebar();
get_footer();
