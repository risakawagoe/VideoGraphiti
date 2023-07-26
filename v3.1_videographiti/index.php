<!-- header -->
<?php get_header(); ?>

    <!-- ======================== main (start) ======================== -->
    <main class="main__top-page">
        <section id="top-video"<?php if(get_background_video_url() == null): ?> class="no-video"<?php endif; ?>>
            <div class="text-box__tagline">
                <h1 class="tagline"></h1>
            </div>
			<?php if(get_background_video_url() != null): ?>
            	<video src="<?php echo get_background_video_url(); ?>" muted autoplay loop></video>
			<?php endif; ?>
        </section>

        <section id="mobile-top">
            <div class="text-box__tagline">
                <h1 class="tagline"></h1>
            </div>
        </section>

        <section class="works-box bg__pattern">
            <div class="wrap">
                <div class="category-tab__works">
                    <ul>
                        <?php $cats = my_get_work_category(); ?>
						<?php 
							if($cats != null):
								foreach($cats as $cat):
						?>
						    <li data-category="<?php echo $cat->slug; ?>" class="work-category<?php if($cats[0]==$cat): echo ' selected__category'; endif; ?>" onclick="toggleCategory(this, this.dataset.category)"><a><?php echo $cat->name; ?></a></li>
						<?php endforeach; ?>
						<?php else: ?>
						    <li><a>制作例</a></li>
						<?php endif; ?>
                    </ul>
                </div>

                <div class="works-grid">
                    <div class="works-grid">
                        <?php
                            $categories = my_get_work_category();
							if($categories != null):
								foreach ($categories as $category):
									$my_query = new WP_Query(
										array(
											'cat' => $category->term_id,
											'posts_per_page' => 2,
										));
									if ($my_query->have_posts()):
										while ($my_query->have_posts()) : 
											$my_query->the_post();
                        ?>


                        <div data-post-id="<?php the_ID(); ?>" class="work <?php echo $category->slug; ?> <?php if($category == $categories[0]) {echo 'active__category';} ?>">


                        <div class="work-thumb" onclick="modalDisplay(this.parentNode.dataset.postId)">

                        <?php if(has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                        <?php else: ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.png" alt="No Image Available">
                        <?php endif; ?>
     
                        </div><p class="work-title hover__theme-color" onclick="modalDisplay(this.parentNode.dataset.postId)"><a style="cursor: pointer;"><?php the_title(); ?></a></p></div>

                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                        <?php endforeach; ?>
						<?php else: ?>
						<p class="msg-center"><i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>只今コンテンツ準備中です。</p>
						<?php endif; ?>
                    </div>
                </div>
            </div>
			<?php if($categories != null): ?>
            	<p class="btn__center btn__black hover__theme-color"><a href="<?php echo home_url() . '/category/works'; ?>">もっと見る</a></p>
			<?php endif; ?>
        </section>

        <section id="feature" class="feature bg__white">
            <div class="wrap">
                <h2 class="section__header">VideoGraphitiの魅力</h2>
                <div class="sub-tagline">
                    <?php echo get_feature_tagline(); ?>
                </div>

                <div class="flex">

                    <div class="feature__points">
                        <div class="point first__point">
                            <h3>
                                <span class="icon-section"><span><i class="far fa-handshake"></i></span></span>
                                <?php echo get_feature_p1(); ?>
                                </h3>
                            <p><?php echo get_feature_p1_exp(); ?></p>
                        </div>
                        <div class="point second__point">
                            <h3>
                                <span class="icon-section"><span><i class="fas fa-certificate"></i></span></span>
                                <?php echo get_feature_p2(); ?>
                                </h3>
                            <p><?php echo get_feature_p2_exp(); ?></p>
                        </div>
                    </div>
                    <div class="feature__illustration">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/features-illustration.png" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section id="service" class="service bg__pattern">
            <div class="wrap">
                <h2 class="section__header">SERVICE</h2>
                <?php 
                    $service_page_id = get_page_by_path("service")->ID;
                    $args = array(
                        'posts_per_page' => -1,
                        'post_type' => 'page',
                        'orderby' => 'menu_order',
                        'order' => 'ASC',
                        'post_parent' => $service_page_id,
                    );

                    $common_pages = new WP_Query($args);

                    if($common_pages->have_posts()):
                ?>
                    <div class="services-grid">
                    <?php
                        while($common_pages->have_posts()):
                            $common_pages->the_post();
                    ?>


                    <div class="service-column">
                        <a href="<?php the_permalink(); ?>">
                            <div>
                                <?php if(has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                <?php else: ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.png" alt="No Image Available">
                                <?php endif; ?>
                            </div>
                            <p class="service-heading"><?php echo get_the_title(); ?></p>
                            <p class="service-exp"><?php echo get_the_excerpt(); ?></p>
                        </a>
                    </div>
 
                    <?php 
                            endwhile;
                            wp_reset_postdata();
                    ?>
                    </div>
                    <?php else: ?>
                        <div>
                            <p><i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>只今コンテンツ準備中です。</p>
                            <small>ご迷惑おかけ致しますが、公開まで今しばらくお待ち下さい。</small>
                        </div>
                    <?php endif; ?> 
                    
                </div>
            </div>
        </section>

        <section id="price" class="price bg__white">
            <div class="wrap">
                <h2 class="section__header">PRICE</h2>
                <?php 
                    if((get_price_img_pc() != null) && (get_price_img_smp() != null)):
                 ?>
                <picture class="price-img">
                    <source media="(min-width: 680px)" srcset="<?php echo get_price_img_pc(); ?>">
                    <img src="<?php echo get_price_img_smp(); ?>">
                </picture>
                <?php else: ?>
                    <p><i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>只今コンテンツ準備中です。</p>
                    <small>ご迷惑おかけ致しますが、公開まで今しばらくお待ち下さい。</small>
                <?php endif; ?>
                <?php if(get_price_pdf() != null): ?>
                <p class="price-pdf">※PDF版は<a href="<?php echo get_price_pdf() ?>" target="_blank" rel="noopener noreferrer">こちら</a>から。</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="contact bg__pattern" id="contact">
            <div class="wrap">
                <h2 class="section__header">ご相談からご依頼まで、<br>LINEでお気軽にお問合せ！</h2>
                <h3>
                    <span class="icon-section"><span><i>1</i></span></span>
                    LINEで友達登録
                </h3>
                <h3>
                    <span class="icon-section"><span><i>2</i></span></span>
                    チャットでご相談内容を送信
                </h3>
                <div class="lineat-info">
                    <div class="lineat__smp">
                        <p>スマホからクリックで追加</p>
                        <?php 
                            if(get_lineat_btn() != null):
                                echo get_lineat_btn();
                            else:
                                echo '<p><i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>只今準備中</p>';
                            endif;
                        ?>
               
                    </div>
                    <div class="lineat__qr">
                        <p>QRコードまたはID検索で追加</p>
                        <?php 
                            if(get_lineat_qrcode() != null):
                        ?>
                        <a href="<?php echo get_header_lineat_url(); ?>" target="_blank" rel="noopener noreferrer"><img src="<?php echo get_lineat_qrcode(); ?>" alt=""></a>
                        <?php
                            else:
                                echo '<p><i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>只今準備中</p>';
                            endif;
                        ?>
                        
                    </div>
                </div>
                <?php if(get_contact_email() != null): ?>
                <p class="contact-notice">※メールでのお問合わせをご希望の方は、<?php echo get_contact_email(); ?>までお願いいたします。</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="news">
            <div class="wrap">
                <h2>NEWS</h2>
                <?php 
                    $args = array(
                        'category_name' => 'news',
                        'posts_per_page' => 3,
                    );

                    $news_posts = new WP_Query($args);

                    if($news_posts->have_posts()):
                 ?>

                <div class="recent-posts">

                <?php 
                    while($news_posts->have_posts()):
                        $news_posts->the_post();
                ?>
                <div class="post-section"><?php  ?>
                    <a href="<?php the_permalink(); ?>"><span class="post-date"><?php echo get_the_date( 'Y-m-d' ); ?></span><span class="post-excerp"><?php echo get_the_title(); ?></span></a>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
                </div>
                <?php else: ?>
                    <small style="color: #fff;"><i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem; color: #fff;"></i>投稿がありません。</small>
                <?php endif; ?>

            </div>
        </section>

    </main>
    
    <!-- ======================== main (end) ======================== -->

    <div class="cp_modal">
        <input id="cp_trigger" type="checkbox">
        <div class="cp_overlay" role="dialog">
            <div class="cp_wrap">
                <label for="cp_trigger" onclick="closeModal()"><i class="fas fa-times"></i></label>
				<article>
					<h2 id="modal-title"></h2>
					<div id="modal-body" class="wp__page-content"></div>
					<p class="cp_post-date"></p>
				</article>
                <label for="cp_trigger" class="cp_btn" onclick="closeModal()">閉じる</label>
            </div>
        </div>
    </div>
    

<!-- footer -->
<?php get_footer(); ?>