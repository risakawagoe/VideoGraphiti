<!-- header -->
<?php get_header(); ?>

    <!-- ======================== main (start) ======================== -->
    <main class="main__single-page-post">

        <section class="page-post-title bg__pattern">
            <div class="wrap">
                <h1 class="page-post-header"><?php the_title(); ?></h1>
            </div>
        </section>
        

        <section class="page-post-content bg__white">
            <div class="wrap">
                <!-- ページコンテンツ -->
                <div class="wp__page-content">
                    <!-- ここに投稿が入る -->
                    <?php get_template_part( 'content' ); ?>

                </div>

                <!-- 戻るボタン -->
                <div class="return-btn">
                    <a href="javascript:history.back()">戻る</a>
                </div>
            </div>
        </section>



    </main>
    
    <!-- ======================== main (end) ======================== -->
    
    <!-- footer -->
    <?php get_footer(); ?>