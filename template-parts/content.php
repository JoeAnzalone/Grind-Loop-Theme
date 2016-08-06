<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Grind_Loop
 */

?>

<?php

// If the `linked:url` custom field exists,
// use it to override the post title's <a>
$linked_url = get_post_meta(get_the_id(), 'linked:url')[0];

// Use the `linked:og:image` custom field as the post thumbnail
$og_image = get_post_meta(get_the_id(), 'linked:og:image')[0];
$post_thumbnail = $og_image ? $og_image : get_the_post_thumbnail_url();

// Prepend the post title with one of these:
// The link's site name taken from the `linked:sitename` custom field
// The link's site name taken from `grind_loop_sitename($host)` in functions.php
// The link's hostname taken from the URL if a site name can not be obtained
// The category (Only if it's not a link and it belongs to a non-default category)
$site_name = get_post_meta(get_the_id(), 'linked:sitename')[0];
$host = get_post_meta(get_the_id(), 'linked:host')[0];
$host = grind_loop_sitename($host);
$site_name = $site_name ? $site_name : $host;

if (!$site_name) {
	$category_obj = get_the_category()[0];

	if ($category_obj->term_id !== 1) {
		$category = $category_obj->name;
	}
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">


		<div class="featured-image-wrapper" style="background-image: url(<?php echo $post_thumbnail; ?>)">
			<?php if ($site_name) { ?>
				<div class="linked-site-name">
					From <?php echo $site_name; ?>:
				</div>
			<?php } elseif ($category) { ?>
				<div class="main-category-name">
					<?php echo $category; ?>:
				</div>
			<?php } ?>
			<?php if ($linked_url) { ?>
				<a href="<?php echo esc_url($linked_url); ?>" target="_blank">
					<h2 class="entry-title">
							<?php the_title(); ?>
					</h2>
				</a>
			<?php } else { ?>
				<?php if (is_single()) { ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php } else { ?>
					<a href="<?php echo esc_url(get_permalink()); ?>" rel="bookmark">
						<h2 class="entry-title">
							<?php the_title(); ?>
						</h2>
					</a>
				<?php } ?>
			<?php } ?>
		</div>


		<?php if ( 'post' === get_post_type() ) { ?>
		<div class="entry-meta">
			<?php grind_loop_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php } ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'grind-loop' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'grind-loop' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php // grind_loop_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
