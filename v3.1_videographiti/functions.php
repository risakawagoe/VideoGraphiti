<?php 
    // WordPress標準機能

    function my_setup() {
        // アイキャッチ画像
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'automatic-feed-links' ); 
        add_theme_support( 'title-tag' ); 
        add_theme_support( 'html5', array( 
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );
    }
    add_action( 'after_setup_theme', 'my_setup' );


    
    function add_stylesheet() {
        // CSSの読み込み
        wp_register_style('reset', get_template_directory_uri().'/css/reset.css', array(), '', false);
        wp_enqueue_style('main', get_stylesheet_uri(), array('reset'), '', false);

        // JavaScriptの読み込み
        wp_enqueue_script('myscript', get_template_directory_uri().'/js/script.js', array(), '', true);
    }
    add_action('wp_enqueue_scripts', 'add_stylesheet');

    // カスタムメニュー有効化
    register_nav_menu( 'main-menu', 'Main Menu' );


    // ajax
    function add_my_ajaxurl() {
        ?>
            <script>
                var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
            </script>
        <?php
    }
    add_action( 'wp_head', 'add_my_ajaxurl', 1 );


    // ajax - get post information
    function postInfo() {
        $id = $_POST['id'];
		$post = null;
        
        // get post info
        if( get_post_status($id) ) {
            $post = get_post($id);
        }

        $json[] = array(
			"post" => $post,
        );

        header( "Content-Type: application/json; X-Content-Type-Options: nosniff; charset=utf-8" );
        echo json_encode( $json );
        die();
    }
    add_action( 'wp_ajax_postInfo', 'postInfo' );
    add_action( 'wp_ajax_nopriv_postInfo', 'postInfo' );



    // sns
    function add_twitter_to_profile_fields( $contactmethods ) {
        $contactmethods['twitter'] = 'Twitter';
        $contactmethods['instagram'] = 'Instagram';
        return $contactmethods;
    }
    add_filter('user_contactmethods','add_twitter_to_profile_fields');
  

    /* the_archive_title 余計な文字を削除 */
    add_filter( 'get_the_archive_title', function ($title) {
        if (is_category()) {
            $title = single_cat_title('',false);
        } elseif (is_tag()) {
            $title = single_tag_title('',false);
        } elseif (is_tax()) {
            $title = single_term_title('',false);
        } elseif (is_post_type_archive() ){
            $title = post_type_archive_title('',false);
        } elseif (is_date()) {
            $title = get_the_time('Y年n月');
        } elseif (is_search()) {
            $title = '検索結果：'.esc_html( get_search_query(false) );
        } elseif (is_404()) {
            $title = '「404」ページが見つかりません';
        } else {

        }
        return $title;
    });

    function my_get_work_category() {
		if(get_category_by_slug('works')) {
            $works = get_category_by_slug('works');
            return get_categories(array(
                'child_of' => $works->term_id,
                'title_li' => '',
            ));
        }

        return null;
    }


    function my_theme_customize($wp_customize) {
        $wp_customize->add_panel(
            'toppage_panel',
            array(
                'title'    => 'トップページカスタマイザー',
                'priority' => 1,
            )
        );
        // header
        $wp_customize->add_section(
            'header_section',
            array(
                'title'           => 'ヘッダー',
                'panel'           => 'toppage_panel',
                'priority'        => 1,
            )
        );


        // feature
        $wp_customize->add_section(
            'feature_section',
            array(
                'title'           => '特長',
                'panel'           => 'toppage_panel',
                'priority'        => 2,
            )
        );

        // feature - main tagline
        $wp_customize->add_setting( 'feature_tagline' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'feature_tagline_control',
                array(
                    'label'    => 'キャッチコピー',
                    'section'  => 'feature_section',
                    'settings' => 'feature_tagline',
                    'type'     => 'text',
                )
            )
        );
        // feature - point1 heading
        $wp_customize->add_setting( 'feature_p1_heading' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'feature_p1_heading_control',
                array(
                    'label'    => '特長１：見出し',
                    'section'  => 'feature_section',
                    'settings' => 'feature_p1_heading',
                    'type'     => 'text',
                )
            )
        );
        // feature - point1 explanation
        $wp_customize->add_setting( 'feature_p1_exp' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'feature_p1_exp_control',
                array(
                    'label'    => '特長１：説明',
                    'section'  => 'feature_section',
                    'settings' => 'feature_p1_exp',
                    'type'     => 'textarea',
                )
            )
        );
        // feature - point2 heading
        $wp_customize->add_setting( 'feature_h2_heading' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'feature_h2_heading_control',
                array(
                    'label'    => '特長２：見出し',
                    'section'  => 'feature_section',
                    'settings' => 'feature_h2_heading',
                    'type'     => 'text',
                )
            )
        );
        // feature - point2 explanation
        $wp_customize->add_setting( 'feature_h2_exp' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'feature_h2_exp_control',
                array(
                    'label'    => '特長２：説明',
                    'section'  => 'feature_section',
                    'settings' => 'feature_h2_exp',
                    'type'     => 'textarea',
                )
            )
        );


        // header - logo image
        $wp_customize->add_setting( 'logo_image' );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'logo_image_control',
                array(
                    'label'    => 'ロゴ画像',
                    'section'  => 'header_section',
                    'settings' => 'logo_image',
                    'priority' => 1,
                )
            )
        );
        // header - line@ url
        $wp_customize->add_setting( 'lineat_url' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'lineat_url_control',
                array(
                    'label'    => 'LINE@リンク（URL）',
                    'section'  => 'header_section',
                    'settings' => 'lineat_url',
                    'type'     => 'url',
                    'priority' => 2,
                )
            )
        );
        // header - background video
        $wp_customize->add_setting( 'background_video' );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'background_video_control',
                array(
                    'label'    => 'バックグランド映像',
                    'section'  => 'header_section',
                    'settings' => 'background_video',
                    'mime_type' => 'video',
                    'priority' => 3,
                )
            )
        );
        
        // price
        $wp_customize->add_section(
            'price_section',
            array(
                'title'           => '料金表',
                'panel'           => 'toppage_panel',
                'priority'        => 3,
            )
        );
        
        // price - pricing info image (pc)
        $wp_customize->add_setting( 'price_image_pc' );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'price_image_pc_control',
                array(
                    'label'    => '料金表（PC表示用）',
                    'section'  => 'price_section',
                    'settings' => 'price_image_pc',
                    'priority' => 1,
                )
            )
        );
        // price - pricing info image (smartphone)
        $wp_customize->add_setting( 'price_image_smp' );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'price_image_smp_control',
                array(
                    'label'    => '料金表（スマホ表示用）',
                    'section'  => 'price_section',
                    'settings' => 'price_image_smp',
                    'priority' => 2,
                )
            )
        );
        // pricing PDF 
        $wp_customize->add_setting( 'price_pdf' );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'price_pdf_control',
                array(
                    'label'    => '料金表(PDF)',
                    'section'  => 'price_section',
                    'settings' => 'price_pdf',
                    'mime_type' => 'application/pdf',
                    'priority' => 3,
                )
            )
        );



        // contact
        $wp_customize->add_section(
            'contact_section',
            array(
                'title'           => 'お問い合わせ情報',
                'panel'           => 'toppage_panel',
                'priority'        => 4,
            )
        );
        // contact - friend add button
        $wp_customize->add_setting( 'line_addfirend_btn' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'line_addfirend_btn_control',
                array(
                    'label'    => '友達追加ボタン埋め込み',
                    'section'  => 'contact_section',
                    'settings' => 'line_addfirend_btn',
                    'type'     => 'textarea',
                    'priority' => 1,
                )
            )
        );
        // contact - QR code
        $wp_customize->add_setting( 'line_qrcode_image' );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'line_qrcode_image_control',
                array(
                    'label'    => 'QRコード・ID情報（画像）',
                    'section'  => 'contact_section',
                    'settings' => 'line_qrcode_image',
                    'priority' => 2,
                )
            )
        );
        // contact - email (before @)
        $wp_customize->add_setting( 'contact_email_front' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'contact_email_front_control',
                array(
                    'label'    => '問い合わせ用メール※＠より前',
                    'section'  => 'contact_section',
                    'settings' => 'contact_email_front',
                    'type'     => 'text',
                    'priority' => 3,
                )
            )
        );
        // contact - email (after @)
        $wp_customize->add_setting( 'contact_email_back' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'contact_email_back_control',
                array(
                    'label'    => '問い合わせ用メール※＠より後ろ',
                    'section'  => 'contact_section',
                    'settings' => 'contact_email_back',
                    'type'     => 'text',
                    'priority' => 4,
                )
            )
        );

        // footer
        $wp_customize->add_section(
            'footer_section',
            array(
                'title'           => 'フッター',
                'panel'           => 'toppage_panel',
                'priority'        => 5,
            )
        );
        // footer - sns (youtube)
        $wp_customize->add_setting( 'youtube_url' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'youtube_url_control',
                array(
                    'label'    => 'YouTube (URL)',
                    'section'  => 'footer_section',
                    'settings' => 'youtube_url',
                    'type'     => 'url',
                    'priority' => 1,
                )
            )
        );
        // footer - sns (instagram)
        $wp_customize->add_setting( 'instagram_url' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'instagram_url_control',
                array(
                    'label'    => 'Instagram (URL)',
                    'section'  => 'footer_section',
                    'settings' => 'instagram_url',
                    'type'     => 'url',
                    'priority' => 2,
                )
            )
        );
        // footer - sns (twitter)
        $wp_customize->add_setting( 'twitter_url' );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'twitter_url_control',
                array(
                    'label'    => 'Twitter (URL)',
                    'section'  => 'footer_section',
                    'settings' => 'twitter_url',
                    'type'     => 'url',
                    'priority' => 3,
                )
            )
        );
    }
    add_action('customize_register', 'my_theme_customize');

    // カスタマイザー反映
    //header - logo image
    function get_the_logo_img_url() {
        if(get_theme_mod( 'logo_image' )) {
            return esc_url( get_theme_mod( 'logo_image' ) );
        }else {
            return get_template_directory_uri() . "/images/logo-white.png";
        }
    }
    // header - LINE@ url
    function get_header_lineat_url() {
        if(get_theme_mod('lineat_url')) {
            return esc_url(get_theme_mod('lineat_url'));
        }else {
            return '';
        }
    }
    // top page background video
    function get_background_video_url() {
        if(get_theme_mod( 'background_video' )) {
            return esc_url(get_theme_mod( 'background_video' ));
        }else {
            return null;
        }
    }
    // footer - contact email
    function get_contact_email() {
        if(get_theme_mod('contact_email_front') && get_theme_mod('contact_email_back')) {
            $ret = '<span>' . get_theme_mod('contact_email_front') . '[at]' . get_theme_mod('contact_email_back') . '</span>';
            return $ret;
        }else {
            return null;
        }
    }
    // footer - sns
    function get_youtube_url() {
        if(get_theme_mod('youtube_url')) {
            return esc_url(get_theme_mod('youtube_url'));
        }else {
            return null;
        }
    }
    function get_instagram_url() {
        if(get_theme_mod('instagram_url')) {
            return esc_url(get_theme_mod('instagram_url'));
        }else {
            return null;
        }
    }
    function get_twitter_url() {
        if(get_theme_mod('twitter_url')) {
            return esc_url(get_theme_mod('twitter_url'));
        }else {
            return null;
        }
    }
    
    // line@ - add friend button
    function get_lineat_btn() {
        if(get_theme_mod('line_addfirend_btn')) {
            return get_theme_mod('line_addfirend_btn');
        }else {
            return null;
        }
    }
     
    // line@ - add friend qr code
    function get_lineat_qrcode() {
        if(get_theme_mod('line_qrcode_image')) {
            return esc_url(get_theme_mod('line_qrcode_image'));
        }else {
            return null;
        }
    }
    
    // price - pc image
    function get_price_img_pc() {
        if(get_theme_mod('price_image_pc')) {
            return get_theme_mod('price_image_pc');
        }else {
            return null;
        }
    }
    // price - smartphone image
    function get_price_img_smp() {
        if(get_theme_mod('price_image_smp')) {
            return get_theme_mod('price_image_smp');
        }else {
            return null;
        }
    }
    // price - pdf
    function get_price_pdf() {
        if(get_theme_mod('price_pdf')) {
            return wp_get_attachment_url( get_theme_mod('price_pdf') );
        }else {
            return null;
        }
    }
    
    // feature
    function get_feature_tagline() {
        if(get_theme_mod('feature_tagline')) {
            return get_theme_mod('feature_tagline');
        }else {
            return 'お客様の手間を最小限に、ハイクオリティかつリーズナブルな価格で映像を提供';
        }
    }
    function get_feature_p1() {
        if(get_theme_mod('feature_p1_heading')) {
            return get_theme_mod('feature_p1_heading');
        }else {
            return '「ワンストップ完結型」でお客様の手間を最小限に。';
        }
    }
    function get_feature_p1_exp() {
        if(get_theme_mod('feature_p1_exp')) {
            return get_theme_mod('feature_p1_exp');
        }else {
            return 'ワンストップとは、最初から最後まで全てを一か所で完結させることができるサービス形態のことをさします。VideoGraphitiでは、制作依頼から納品まで全てを請け負うことで、お客様の手間を最小限にすることができます。';
        }
    }
    function get_feature_p2() {
        if(get_theme_mod('feature_h2_heading')) {
            return get_theme_mod('feature_h2_heading');
        }else {
            return '中小事業者や個人の予算でハイクオリティな映像を。';
        }
    }
    function get_feature_p2_exp() {
        if(get_theme_mod('feature_h2_exp')) {
            return get_theme_mod('feature_h2_exp');
        }else {
            return '広告宣伝や映像制作会社に依頼するほどの予算は持ち合わせていない、それでも品質に妥協をしたくないという方のニーズに応えます。中小事業者や個人の予算に合った料金で、ハイクオリティな映像を提供することができます。';
        }
    }

?>
