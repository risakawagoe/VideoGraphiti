<!-- header -->
<?php get_header(); ?>

    <!-- ======================== main (start) ======================== -->
    <main class="main__archive">

        <section class="archive-title bg__pattern">
            <div class="wrap">
                <h1 class="archive-header"><?php single_cat_title(); ?></h1>
            </div>
        </section>
        

        <section class="archive-page bg__white">
            <div class="wrap">
                <!-- ページコンテンツ -->
                <?php if (have_posts()): ?>
                    <div class="works-grid">

                <?php
                    while (have_posts()) :
                        the_post();
                ?>
                <div data-post-id="<?php the_ID(); ?>" class="work<?php 
						$categories = get_the_category();
						foreach($categories as $cat) {
							echo ' ';
							echo $cat->category_nicename;
						} ?>">
                    <a href="<?php the_permalink(); ?>"><div class="work-thumb">
                    <?php if(has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.png" alt="No Image Available">
                    <?php endif; ?>
                    </div></a>
                    <p class="work-title hover__theme-color"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                </div>
                <?php endwhile; ?>
                </div>
                <?php else: ?>
                    <p><i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>只今コンテンツ準備中です。</p>
                    <small>ご迷惑おかけ致しますが、公開まで今しばらくお待ち下さい。</small>
                <?php endif; ?>
                
                </div>

            </div>
        </section>



    </main>
    
    <!-- ======================== main (end) ======================== -->
    
<!-- footer -->
<?php get_footer(); ?>