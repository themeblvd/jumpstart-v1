<?php
/**
 * The default template for displaying content in mini post list.
 */
$class  = themeblvd_get_att('thumbs') ? 'has-thumbnail' : ''; // Whether thumb displays, not if it has one
$class .= themeblvd_get_att('show_meta') ? ' has-meta' : '';
$meta = apply_filters('themeblvd_mini_list_meta_args', array('include' => array('time', 'comments'), 'comments' => 'mini', 'time' => 'ago'));
?>
<article <?php post_class($class); ?>>

	<?php if ( themeblvd_get_att('thumbs') ) : ?>
		<div class="thumb-wrapper">
			<?php themeblvd_the_post_thumbnail('tb_thumb', array('placeholder' => true)); ?>
		</div><!-- .thumb-wrapper (end) -->
	<?php endif; ?>

	<h3 class="entry-title"><?php themeblvd_the_title(); ?></h3>

	<?php if ( themeblvd_get_att('show_meta') ) : ?>
		<div class="meta-wrapper">
			<?php echo themeblvd_get_meta($meta); ?>
		</div><!-- .meta-wrapper (end) -->
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->