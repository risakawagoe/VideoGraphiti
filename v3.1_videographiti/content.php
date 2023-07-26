<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> type-<?php if(is_page()) {echo 'page';}elseif(is_single()) {echo 'post';} ?> status-<?php echo get_post_status(); ?><?php if(has_post_thumbnail()) {echo ' has-post-thumbnail';} ?>">

  <!-- post content -->
    <?php the_content(); ?>

</article>