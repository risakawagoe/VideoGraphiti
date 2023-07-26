<footer class="unselectable">
        <div class="footer">
            <small>&copy; 2022 <?php echo get_bloginfo('name'); ?></small>
            <p class="btn__center btn__white" id="page-top"><a href="">トップへ戻る</a></p>
            <div class="contact-list">
                <?php if(get_contact_email() != null): ?>
                    <p><?php echo get_contact_email(); ?></p>
                <?php endif; ?>
                <div class="contact-sns">
                    <?php if(get_youtube_url() != null): ?>
                        <a href="<?php echo get_youtube_url(); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                    <?php if(get_instagram_url() != null): ?>
                        <a href="<?php echo get_instagram_url(); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if(get_twitter_url() != null): ?>
                        <a href="<?php echo get_twitter_url(); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>

    
    <?php wp_footer(); ?>
</body>
</html>