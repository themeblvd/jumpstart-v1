<?php
/**
 * The template used for displaying content in template_sitemap.php
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php rewind_posts(); ?>
        <?php the_content(); ?>
        <?php edit_post_link( themeblvd_get_local( 'edit_page' ), '<p class="edit-link clearfix">', '</p>' ); ?>
        <h2><?php echo themeblvd_get_local( 'pages' ); ?></h2>
        <ul>
            <?php wp_list_pages('depth=0&sort_column=menu_order&title_li=' ); ?>
        </ul>
        <h2><?php echo themeblvd_get_local( 'categories' ); ?></h2>
        <ul>
            <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
        </ul>
        <h2><?php echo themeblvd_get_local( 'posts_per_category' ); ?></h2>
        <?php $cats = get_categories(); ?>
        <?php foreach ($cats as $cat) : ?>
            <?php query_posts('cat='.$cat->cat_ID); ?>
                <h3><?php echo $cat->cat_name; ?></h3>
                <ul>
                    <?php while (have_posts()) : the_post(); ?>
                    <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php echo themeblvd_get_local( 'comments' ); ?> (<?php echo $post->comment_count ?>)</li>
                    <?php endwhile; wp_reset_query(); ?>
                </ul>
        <?php endforeach; ?>
	</div><!-- .entry-content (end) -->
</article>