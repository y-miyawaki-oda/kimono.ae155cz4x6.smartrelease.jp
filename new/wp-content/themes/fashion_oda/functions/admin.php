<?php
	// 不要なメニューを非表示
	flush_rewrite_rules();
	function remove_menus () {
		global $menu;
		unset($menu[5]);	// 投稿
		unset($menu[25]);	// コメント
	}
	add_action('admin_menu', 'remove_menus', 999);


	// 固定ページとMW WP Formでビジュアルモードを使用しない
	function stop_rich_editor($editor) {
		global $typenow;
		global $post;
		if(in_array($typenow, array('page', 'mw-wp-form'))) {
			$editor = false;
		}
		return $editor;
	}
	add_filter('user_can_richedit', 'stop_rich_editor');

/*
	// 投稿ページでテキストモードを使用しない
	add_filter('wp_editor_settings', function($settings) {
		global $typenow;
		if(in_array($typenow, array('news', 'case')) && user_can_richedit()) {
			$settings['quicktags'] = false;
		}

		return $settings;
	});
*/

	// エディター独自スタイル追加
	//TinyMCE追加用のスタイルを初期化
	if(!function_exists('initialize_tinymce_styles')) {
		function initialize_tinymce_styles($init_array) {
			//追加するスタイルの配列を作成
			$style_formats = array(
				array(
					'title' => '注釈',
					'inline' => 'span',
					'classes' => 'cmn_note'
				)
			);
			//JSONに変換
			$init_array['style_formats'] = json_encode($style_formats);
			return $init_array;
		}
	}
	add_filter('tiny_mce_before_init', 'initialize_tinymce_styles', 10000);


	// オプションページを追加
	if(function_exists('acf_add_options_page')) {
		acf_add_options_page(array(
			'page_title' => 'トップページ設定', // 設定ページで表示される名前
			'menu_title' => 'トップページ設定', // ナビに表示される名前
			'menu_slug' => 'top_setting',
			'capability' => 'edit_posts',
			'redirect' => false
		));

		acf_add_options_page(array(
			'page_title' => 'KV設定', // 設定ページで表示される名前
			'menu_title' => 'KV設定', // ナビに表示される名前
			'menu_slug' => 'kv_setting',
			'capability' => 'edit_posts',
			'redirect' => false
		));
	}


	// カスタム投稿とタクソノミーを追加
	add_action('init', function(){
		// ニュースリリース
		register_post_type('news',
			array(
				'labels' => array(
					'name' => __('ニュースリリース'),
					'singular_name' => __('ニュースリリース')
				),
				'rewrite' => array(
					'slug' => 'news',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => true,
				'menu_position' => 21,
				'public' => true,
				"supports" => [ "title", "editor", "thumbnail" ],
			)
		);

		// ニュースリリースカテゴリー
		register_taxonomy(
			'cat_news',
			'news',
			array(
				'update_count_callback' => '_update_post_term_count',
				'label' => 'ニュースリリースカテゴリー',
				'labels' => array(
					'singular_name' => 'ニュースリリースカテゴリー',
					'menu_name' => 'カテゴリー',
				),
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => false,
				'hierarchical' => true,
				'rewrite' => array(
					'slug' => 'news',
					'with_front' => false
				),
			)
		);

		add_rewrite_rule('(news)/([12]\d{3})/?$', 'index.php?post_type=$matches[1]&year=$matches[2]', 'top');
		add_rewrite_rule('(news)/([12]\d{3})/page/(\d+)/?$', 'index.php?post_type=$matches[1]&year=$matches[2]&paged=$matches[3]', 'top');
		add_rewrite_rule('(news)/([12]\d{3})/(.+?)/page/(\d+)/?$', 'index.php?post_type=$matches[1]&year=$matches[2]&cat_news=$matches[3]&paged=$matches[4]', 'top');
		add_rewrite_rule('(news)/(.+?)/page/(\d+)/?$', 'index.php?post_type=$matches[1]&cat_news=$matches[2]&paged=$matches[3]', 'top');
		add_rewrite_rule('(news)/([12]\d{3})/(.+?)/?$', 'index.php?post_type=$matches[1]&year=$matches[2]&cat_news=$matches[3]', 'top');


		// オープンキャンパス
		register_post_type('opencampus',
			array(
				'labels' => array(
					'name' => __('オープンキャンパス'),
					'singular_name' => __('オープンキャンパス')
				),
				'rewrite' => array(
					'slug' => 'opencampus',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => false,
				'menu_position' => 22,
				'public' => true,
				"supports" => [ "title", "thumbnail" ],
			)
		);

		// オープンキャンパスカテゴリー
		register_taxonomy(
			'cat_opencampus',
			'opencampus',
			array(
				'update_count_callback' => '_update_post_term_count',
				'label' => 'オープンキャンパス',
				'labels' => array(
					'singular_name' => 'オープンキャンパス',
					'menu_name' => 'カテゴリー'
				),
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => false,
				'hierarchical' => true,
				'rewrite' => array(
					'slug' => 'cat_opencampus',
					'with_front' => false
				),
			)
		);


		// 卒業生VOICE
		register_post_type('graduate',
			array(
				'labels' => array(
					'name' => __('卒業生VOICE'),
					'singular_name' => __('卒業生VOICE')
				),
				'rewrite' => array(
					'slug' => 'career/graduate',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => false,
				'menu_position' => 23,
				'public' => true,
				"supports" => [ "title", "thumbnail" ],
			)
		);

		// 職業
		register_taxonomy(
			'job',
			'graduate',
			array(
				'update_count_callback' => '_update_post_term_count',
				'label' => '職業',
				'labels' => array(
					'singular_name' => '職業',
					'menu_name' => '職業'
				),
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => false,
				'hierarchical' => true,
				'rewrite' => array(
					'slug' => 'job',
					'with_front' => false
				),
			)
		);


		// ファッション学生にインタビュー！
		/* register_post_type('talk',
			array(
				'labels' => array(
					'name' => __('実習ダイアリー'),
					'singular_name' => __('実習ダイアリー'),
					'menu_name' => '実習ダイアリー'
				),
				'rewrite' => array(
					'slug' => 'life/active',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => true,
				'menu_position' => 24,
				'public' => true,
				"supports" => [ "title", "editor", "thumbnail" ],
			)
		); */
		// register_post_type('active',
		// 	array(
		// 		'labels' => array(
		// 			'name' => __('学生の活動'),
		// 			'singular_name' => __('学生の活動'),
		// 			'menu_name' => '学生の活動'
		// 		),
		// 		'rewrite' => array(
		// 			'slug' => 'life/active',
		// 			'with_front' => false
		// 		),
		// 		'hierarchical' => false,
		// 		'has_archive' => true,
		// 		'menu_position' => 24,
		// 		'public' => true,
		// 		"supports" => [ "title", "editor", "thumbnail", "slug" ],
		// 	)
		// );


		// OFDC作品紹介
		 /* register_post_type('ofdc',
		 	array(
		 		'labels' => array(
		 			'name' => __('OFDC作品紹介'),
		 			'singular_name' => __('OFDC作品紹介')
		 		),
		 		'rewrite' => array(
		 			'slug' => 'life/works/ofdc',
		 			'with_front' => false
		 		),
		 		'hierarchical' => false,
		 		'has_archive' => false,
		 		'menu_position' => 25,
		 		'public' => true,
		 		"supports" => [ "title" ],
		 	)
		 ); */

		// 外部コンペティション入賞作品
/*
		register_post_type('competition',
			array(
				'labels' => array(
					'name' => __('外部コンペティション入賞作品'),
					'singular_name' => __('外部コンペティション入賞作品')
				),
				'rewrite' => array(
					'slug' => 'life/works/competition',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => false,
				'menu_position' => 26,
				'public' => true,
				"supports" => [ "title" ],
			)
		);
*/
/*
		// 受賞年度
		register_taxonomy(
			'award_year',
			array('ofdc', 'competition'),
			array(
				'update_count_callback' => '_update_post_term_count',
				'label' => '受賞年度',
				'labels' => array(
					'singular_name' => '受賞年度',
					'menu_name' => '受賞年度'
				),
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => false,
				'hierarchical' => true,
				'rewrite' => array(
					'slug' => 'award_year',
					'with_front' => false
				),
			)
		);
*/


		// きものコラム
		register_post_type('column',
			array(
				'labels' => array(
					'name' => __('きものコラム'),
					'singular_name' => __('きものコラム'),
					'menu_name' => 'きものコラム'
				),
				'rewrite' => array(
					'slug' => 'column',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => true,
				'menu_position' => 27,
				'public' => true,
				"supports" => [ "title", "editor", "thumbnail" ],
			)
		);

		//きものコラムカテゴリー
		register_taxonomy(
			'cat_column',
			'column',
			array(
				'update_count_callback' => '_update_post_term_count',
				'label' => 'きものコラムカテゴリー',
				'labels' => array(
					'singular_name' => 'きものコラムカテゴリー',
					'menu_name' => 'カテゴリー',
				),
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => false,
				'hierarchical' => true,
				'rewrite' => array(
					'slug' => 'column',
					'with_front' => false
				),
			)
		);


		// 高校生コーディネートコンテスト
/*
		register_post_type('coordinatecontest',
			array(
				'labels' => array(
					'name' => __('高校生コーディネートコンテスト'),
					'singular_name' => __('高校生コーディネートコンテスト'),
					'menu_name' => '高校生コーディネートコンテスト'
				),
				'rewrite' => array(
					'slug' => 'coordinatecontest',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => true,
				'menu_position' => 28,
				'public' => true,
				"supports" => [ "title", "editor", "thumbnail" ],
			)
		);

		// 年月
		register_taxonomy(
			'contestdate',
			'coordinatecontest',
			array(
				'update_count_callback' => '_update_post_term_count',
				'label' => '年月',
				'labels' => array(
					'singular_name' => '年月',
					'menu_name' => '年月',
				),
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => false,
				'hierarchical' => true,
				'rewrite' => array(
					'slug' => 'coordinatecontest/works',
					'with_front' => false
				),
			)
		);

*/
		// キャンパスレポート
		register_post_type('campusreport',
			array(
				'labels' => array(
					'name' => __('キャンパスレポート'),
					'singular_name' => __('キャンパスレポート'),
					'menu_name' => 'キャンパスレポート'
				),
				'rewrite' => array(
					'slug' => 'life/campusreport',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => true,
				'menu_position' => 29,
				'public' => true,
				"supports" => [ "title", "editor", "thumbnail" ],
				'taxonomies' => ["category", "post_tag"]
			)
		);


		// 在校生VOICE
		register_post_type('voice',
			array(
				'labels' => array(
					'name' => __('在校生VOICE'),
					'singular_name' => __('在校生VOICE')
				),
				'rewrite' => array(
					'slug' => 'life/voice',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => false,
				'menu_position' => 30,
				'public' => true,
				"supports" => [ "title", "thumbnail" ],
			)
		);

		/*register_post_type('report',
			array(
				'labels' => array(
					'name' => __('卒業生のお店を取材'),
					'singular_name' => __('卒業生のお店を取材'),
					'menu_name' => '卒業生のお店を取材'
				),
				'rewrite' => array(
					'slug' => 'report',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => true,
				'menu_position' => 31,
				'public' => true,
				"supports" => [ "title", "editor", "thumbnail" ],
			)
		);

		register_post_type('movie',
			array(
				'labels' => array(
					'name' => __('料理動画'),
					'singular_name' => __('料理動画'),
					'menu_name' => '料理動画'
				),
				'rewrite' => array(
					'slug' => 'mov_list',
					'with_front' => false
				),
				'hierarchical' => false,
				'has_archive' => true,
				'menu_position' => 32,
				'public' => true,
				"supports" => [ "title", "editor", "thumbnail" ],
			)
		); */

		// 学科
		register_taxonomy(
			'course',
			'voice',
			array(
				'update_count_callback' => '_update_post_term_count',
				'label' => '学科',
				'labels' => array(
					'singular_name' => '学科',
					'menu_name' => '学科'
				),
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => false,
				'hierarchical' => true,
				'rewrite' => array(
					'slug' => 'course',
					'with_front' => false
				),
			)
		);

	});


	// 年度が切り替わるデフォルトの月
	define('ODA_FASHION_NEW_YEAR_FIRST_MONTH_DEFAULT', 4);

	/**
	 * 年別アーカイブを年度別アーカイブにする
	 */
	add_action('pre_get_posts', function($query) {

		/** @var WP_Query $query */
		if (is_admin() || !$query->is_main_query() || is_preview()) {
			return;
		}

		$post_type = $query->get('post_type');

		if( $post_type==='news' && $query->is_year() ) {

			$year = $query->get('year');

			$query->set('year', null);

			$new_year_first_month = ODA_FASHION_NEW_YEAR_FIRST_MONTH_DEFAULT;

			$first_date = new DateTime();
			$first_date->setDate($year, $new_year_first_month, 1);

			$last_date = new DateTime();
			$last_date->setDate($year+1, $new_year_first_month, 0);

			$query->set('date_query', array(
				array(
					'after'     => array(
						'year'  => $first_date->format('Y'),
						'month' => $first_date->format('n'),
						'day'   => $first_date->format('j'),
					),
					'before'    => array(
						'year'  => $last_date->format('Y'),
						'month' => $last_date->format('n'),
						'day'   => $last_date->format('j'),
					),
					'inclusive' => true,
				),
			));

			$query->set('raw_year', $year);

			return;

		}

	});


	/**
	 * 年度別アーカイブリンク
	 *
	 * @param $year int|string 年度
	 * @param int|string|WP_Term $term
	 * @param string $taxonomy
	 * @return string URL
	 */
	function oda_fashion_get_archive_link($year=null, $term=null){

		if( !$year && !$term ) return esc_html(home_url('/')).'news/';

		if(is_numeric($term)) $term = get_term($term, 'news');
		if($term instanceof WP_Term) $term = $term->slug;

		return esc_html(home_url('/')).'news/'.($year? strval($year).'/': '').($term? strval($term).'/': '');

	}


	/**
	 * 年度別アーカイブリスト
	 *
	 * @param string $order
	 * @return array
	 */
	function oda_fashion_news_get_yearly_archives($order='ASC'){

		//年度が切り替わる月
		$new_year_first_month = ODA_FASHION_NEW_YEAR_FIRST_MONTH_DEFAULT;

		//通常の年別アーカイブとは区切りが異なるので一旦月別で取得
		$monthly = array_filter(array_map('trim', explode("\n", wp_get_archives(array(
			'type'      => 'monthly',
			'post_type' => 'news',
			'format'    => 'custom',
			'echo'      => false
		)))));

		$yearly = array();

		foreach($monthly as $month){

			if(!preg_match('/(\d+)年(\d+)月/u', $month, $matches)) continue;

			$year  = intval($matches[1]);
			$month = intval($matches[2]);

			//年度切り替え前なら 1 引いて前年度にする
			if($month<$new_year_first_month){
				$year = $year - 1;
			}

			if(!isset($yearly[$year])){
				$yearly[$year] = oda_fashion_get_archive_link($year);
			}

		}

		if($order==='DESC'){
			krsort($yearly);
		}else{
			ksort($yearly);
		}

		return $yearly;

	}
