<?php
	require_once("functions/script.php");
	require_once("functions/admin.php");

	// エラーを非表示
	error_reporting(0);

	// <head>内不要項目削除
	remove_action('wp_head', 'wp_generator');							// wp_generatorの削除
	remove_action('wp_head', 'feed_links_extra');						// rsd_linkの削除
	remove_action('wp_head', 'feed_links');								// rsd_linkの削除
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('wp_head', 'index_rel_link');							// rsd_linkの削除
	remove_action('wp_head', 'parent_post_rel_link');					// rsd_linkの削除
	remove_action('wp_head', 'start_post_rel_link');					// rsd_linkの削除
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');		// rsd_linkの削除
	remove_action('wp_head', 'wp_shortlink_wp_head');					// shortlink
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	remove_action('wp_print_styles', 'print_emoji_styles');

	//絵文字の DNS プリフェッチの削除
	add_filter( 'emoji_svg_url', '__return_false' );

	global $youbi_ja;
	global $youbi_en;
	$youbi_ja = array("日", "月", "火", "水", "木", "金", "土");
	$youbi_en = array("SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT");

	// post thumbnails
	add_theme_support('post-thumbnails');
	add_image_size('banner', 540, 180, true);
	add_image_size('talk_list', 520, 307, true);
	add_image_size('report_list', 520, 307, true);
	add_image_size('talk_detail', 450, 300, true);
	add_image_size('graduate_list', 320, 480, true);
	add_image_size('coordinatecontest_list', 246, 438, true);
	add_image_size('opencampus_list', 270, 270, true);

	add_theme_support('title-tag');


	function wp_document_title_separator($separator) {
		$separator = '|';
		return $separator;
	}
	add_filter('document_title_separator', 'wp_document_title_separator');

	// タイトルをカスタマイズ
	function customize_title($title) {
		global $post;

		if(is_front_page()) {
			return "きもの・和裁のプロを目指すなら｜織田きもの専門学校";
		}
		elseif(is_tax()) {
			return single_term_title("", false).' | '.get_bloginfo().' | '.get_post_type_object(get_post_type())->label;
		}
		elseif(is_post_type_archive("news")) {
			return "ニュース一覧 | ".get_bloginfo();
		}
/* AIOで設定
		elseif(is_post_type_archive()) {
			return get_bloginfo().' | '.get_post_type_object(get_post_type())->label;
		}
		elseif(is_single()) {
			return get_the_title().' | '.get_bloginfo().' | '.get_post_type_object(get_post_type())->label;
		}
*/
		elseif(is_page()) {
			if(get_toplevel_page_name() !== "contact" && get_toplevel_page_name() !== "coordinatecontest" && $post->post_parent) {
				if(is_page(array("design", "fashiontechnical", "stylist", "business", "fashiondesign_s", "fashiontechnical_s", "merchandising"))) {
					return get_the_title().' | '.get_bloginfo().' | 学科';
				}
				else {
					$parent = get_post($parent_id);
					return get_the_title().' | '.get_bloginfo().' | '.get_the_title($parent->post_parent);
				}
			}
			else {
				return get_the_title().' | '.get_bloginfo();
			}
		}
		return $title; 
	}
	add_filter('aioseop_title', 'customize_title');


	function customize_description($description) {
		if(is_post_type_archive("news") || is_tax("cat_news") || is_singular("news")) {
			$description = '織田きもの専門学校のニュースや各種ご案内等を一覧形式で掲載しています。';
		}
		elseif(is_post_type_archive("talk")) {
			$description = 'ファッションを学ぶ学生へインタビュー！ファッション学生東京都中野区の織田きもの専門学校でスタイリスト、デザイナー、パタンナー、アパレル、ファッションビジネスのプロを目指そう！';
		}
		elseif(is_singular("talk")) {
			$description = '「'.get_the_title().'」をテーマに、ファッションとは切り離せない自分のポリシーについて、ファッション学生にインタビュー。東京都中野区の織田きもの専門学校でスタイリスト、デザイナー、パタンナー、アパレル、ファッションビジネスのプロを目指そう！';
		}
		elseif(is_post_type_archive("column")) {
			$description = '着物(きもの)の専門学校への進学を考える上で参考になる話題について書き記していきます。';
		}
		elseif(is_singular("column")) {
			$description = '着物(きもの)はおよそ平安時代から今に形を残す日本の伝統衣装です。その美しさは世界からも注目されており、今でも日本を象徴する衣服です。';
		}
		elseif(is_post_type_archive("campusreport") || is_singular("campusreport")) {
			$description = '服飾、きものについて学べる専門学校。東京都中野区の織田きもの専門学校でスタイリスト、デザイナー、パタンナー、アパレル、きものビジネスのプロを目指そう！なりたい自分になって、夢をかなえよう。';
		}
		elseif(is_post_type_archive("coordinatecontest") || is_tax("contestdate") || is_singular("coordinatecontest")) {
			$description = '「高校生コーディネートコンテスト」...高校生なら誰でも応募可。お気に入りのコーデの写メで応募できるコーディネートコンテストです。LINEでの応募も可。応募コーデの中から毎週1点を選出し、講評と共に発表します。また毎月「月間ベスト」を決定し、賞状と副賞を贈呈しています。織田きもの専門学校が主催しています。';
		}
		return $description;
	}
	add_filter('aioseop_description', 'customize_description');

	function customize_keywords($keywords) {
		if(is_post_type_archive("news") || is_tax("cat_news") || is_singular("news")) {
			$keywords = '新着情報,ニュース,服飾,きもの,専門学校,織田';
		}
		elseif(is_post_type_archive("talk") || is_singular("talk")) {
			$keywords = 'きもの,きもの専攻, 企業コラボレーション';
		}
		elseif(is_post_type_archive("column")) {
			$keywords = 'きもの,和裁,着付け,着物,和装';
		}
		elseif(is_singular("column")) {
			$keywords = 'きもの,着物,和装,和服';
		}
		elseif(is_post_type_archive("campusreport") || is_singular("campusreport")) {
			$keywords = 'きもの,きもの専攻, 企業コラボレーション';
		}
		elseif(is_post_type_archive("coordinatecontest") || is_tax("contestdate")) {
			$keywords = '写メコン,コーディネート,スタイリング,きものスナップ,高校生コンテスト';
		}
		elseif(is_singular("coordinatecontest")) {
			$keywords = 'きもの,きもの専攻, 企業コラボレーション';
		}
		return $keywords;
	}
	add_filter('aioseop_keywords', 'customize_keywords');

	function customize_ogp($value, $sns, $field) {
//var_dump($field);
		if($field === 'sitename') {
			$value = "きもの・和裁のプロを目指すなら｜織田きもの専門学校";
		}
/*
		if(is_single() && ($field === 'thumbnail' || $field === 'thumbnail_1' || $field === 'twitter_thumbnail')) {
			$value = wp_get_attachment_image_url(str_replace("https://", "", $value), "full");
		}
*/

		return $value;
	}
	add_filter('aiosp_opengraph_meta', 'customize_ogp', 10, 3);


	// 抜粋をカスタム
	function get_the_custom_excerpt($content, $length=40) {
		$length = ($length ? $length : 40);									// デフォルトの長さを指定する
		$content = preg_replace('/<!--more-->.+/is',"",$content);			//moreタグ以降削除
		$content = strip_shortcodes($content);								// ショートコード削除
		$content = strip_tags($content);									// タグの除去
		$content = str_replace("&nbsp;", "", $content);						// 特殊文字の削除
		$content = str_replace(array("\r\n", "\r", "\n"), "", $content);	// 特殊文字の削除
		$content = mb_substr($content, 0, $length);							// 文字列を指定した長さで切り取る
		$content = rtrim($content, "<br>");
		$content = str_replace("<br> (さらに&hellip;)", "", $content);			// 「(さらに…)」の削除
		$content = str_replace("(さらに&hellip;)", "", $content);			// 「(さらに…)」の削除
		return $content."[…]";
	}


	// 投稿取得条件を変更
	function change_posts_per_page($query) {
		/* 管理画面,メインクエリに干渉しないために必須 */
		if(is_admin() || !$query->is_main_query()) {
			return;
		}

		// ニュースリリース一覧は1ページ8件でメニュー順
		if($query->is_post_type_archive("news") || $query->is_tax("cat_news")) {
			$query->set('posts_per_page', 8);
			$query->set('orderby', 'menu_order');
			$query->set('order', 'ASC');
			return;
		}
		// コラム一覧とキャンパスレポート一覧は1ページ6件でメニュー順
		elseif($query->is_post_type_archive(array("column", "campusreport"))) {
			$query->set('posts_per_page', 6);
			$query->set('orderby', 'menu_order');
			$query->set('order', 'ASC');
			return;
		}
		// 高校生コーディネートコンテスト一覧は1ページ8件
		elseif($query->is_post_type_archive("coordinatecontest") || $query->is_tax("contestdate")) {
			$query->set('posts_per_page', 8);
			return;
		}
		// ファッション学生にインタビュー一覧は1ページ6件
		elseif($query->is_post_type_archive("talk")) {
			$query->set('posts_per_page', 6);
			return;
		}
		elseif($query->is_post_type_archive("report")) {
			$query->set('posts_per_page', 6);
			return;
		}
		elseif($query->is_post_type_archive("movie")) {
			$query->set('posts_per_page', 2);
			return;
		}
	}
	add_action('pre_get_posts', 'change_posts_per_page');


	function replaceImagePath($arg) {
		$content = str_replace('"img/', '"' . get_bloginfo('template_directory') . '/img/', $arg);
		$content = str_replace(', img/', ', ' . get_bloginfo('template_directory') . '/img/', $content);
		$content = str_replace("('img/", "('". get_bloginfo('template_directory') . '/img/', $content);
//		$content = str_replace('<p><img', '<p class="img"><img', $content);
		return $content;
	}
	add_action('the_content', 'replaceImagePath');


	function replacePdfPath($arg) {
		$content = str_replace('"pdf/', '"' . get_bloginfo('template_directory') . '/pdf/', $arg);
		return $content;
	}
	add_action('the_content', 'replacePdfPath');


	function replaceHttpPath($arg) {
		$content = str_replace('[http]', esc_url(home_url('/')), $arg);
		return $content;
	}
	add_action('the_content', 'replaceHttpPath');


	function replaceHttpsPath($arg) {
		$content = str_replace('[https]', esc_url(home_url('/', 'https')), $arg);
		return $content;
	}
	add_action('the_content', 'replaceHttpsPath');


	/* ショートコード */
	// TOPページ
	function shortcode_hurl() {
		return home_url('/');
	}
	add_shortcode('hurl', 'shortcode_hurl');

	// トップページ緊急のお知らせ
	function shortcode_top_urgent() {
		if(!get_field("urgent_flg", "option")) return;

		global $post;
		$args = array(
			'posts_per_page' => 3,
			'post_type' => 'news',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'cat_news',
					'field' => 'slug',
					'terms' => array('urgent_info'),
					'operator' => 'IN'
				)
			),
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$posts = get_posts($args);
			$html .= <<< EOT
<section class="sec_urgent is_load_anime fadein">
	<div class="wrap">
		<div class="box_white_r">
			<h2 class="ttl"><span>緊急のお知らせ</span></h2>
			<ul class="list">
EOT;
		if($posts) {
			foreach($posts as $post) {
				setup_postdata($post);
				$url = esc_url(get_the_permalink());
				$date = get_the_time("Y.m.d");
				$title = esc_html(get_the_title());
				$html .= <<<EOT
				<li>
					<a href="{$url}" class="fade">
						<span class="time">{$date}</span>
						<span class="txt">{$title}</span>
					</a>
				</li>
EOT;
			}
		}
			$html .= <<<EOT
			</ul>
		</div>
	</div>
</section>
<!-- /.sec_urgent -->
EOT;
		wp_reset_postdata();
		return $html;
	}
	add_shortcode('top_urgent', 'shortcode_top_urgent');

	// トップページバナーエリア(上)
	function shortcode_top_banner_t() {
		if(!get_field("banner_area_top_flg", "option")) return;

		if(have_rows("banner_area_top", "option")) {
			$html .= <<< EOT
<section class="sec_slider is_load_anime fadein">
	<div class="slider">
EOT;
			while(have_rows("banner_area_top", "option")) {
				the_row();
				$image = wp_get_attachment_image(get_sub_field("image"), "banner");
				$url = esc_url(get_sub_field("url"));
				$target = ' target="_blank"';
				if(get_sub_field("target")) {
					$target = "";
				}
				$html .= <<<EOT
		<div class="img"><a href="{$url}"{$target} class="fade">{$image}</a></div>
EOT;
			}
			$html .= <<<EOT
	</div>
</section>
<!-- /.sec_slider -->
EOT;
		}
		return $html;
	}
	add_shortcode('top_banner_t', 'shortcode_top_banner_t');

	// トップページバナーエリア(下)
	function shortcode_top_banner_a() {
		if(!get_field("banner_area_top_first_flg", "option")) return;

		if(have_rows("banner_area_top_1", "option")) {
			$html .= <<< EOT
<section class="sec_slider is_load_anime fadein">
	<div class="slider">
EOT;
			while(have_rows("banner_area_top_1", "option")) {
				the_row();
				$image = wp_get_attachment_image(get_sub_field("image"), "banner");
				$url = esc_url(get_sub_field("url"));
				$target = ' target="_blank"';
				if(get_sub_field("target")) {
					$target = "";
				}
				$html .= <<<EOT
		<div class="img"><a href="{$url}"{$target} class="fade">{$image}</a></div>
EOT;
			}
			$html .= <<<EOT
	</div>
</section>
<!-- /.sec_slider -->
EOT;
		}
		return $html;
	}
	add_shortcode('top_banner_a', 'shortcode_top_banner_a');

	// トップページバナーエリア(下)
	function shortcode_top_banner_b() {
		if(!get_field("banner_area_bottom_flg", "option")) return;

		if(have_rows("banner_area_bottom", "option")) {
			$html .= <<< EOT
<section class="sec_slider is_load_anime fadein">
	<div class="slider">
EOT;
			while(have_rows("banner_area_bottom", "option")) {
				the_row();
				$image = wp_get_attachment_image(get_sub_field("image"), "banner");
				$url = esc_url(get_sub_field("url"));
				$target = ' target="_blank"';
				if(get_sub_field("target")) {
					$target = "";
				}
				$html .= <<<EOT
		<div class="img"><a href="{$url}"{$target} class="fade">{$image}</a></div>
EOT;
			}
			$html .= <<<EOT
	</div>
</section>
<!-- /.sec_slider -->
EOT;
		}
		return $html;
	}
	add_shortcode('top_banner_b', 'shortcode_top_banner_b');

	// トップページNEXTオープンキャンパス
	function shortcode_top_next_oc() {
		global $post;
		global $youbi_en;
		$args = array(
			'posts_per_page' => 2,
			'post_type' => 'opencampus',
			'meta_key' => 'date',
			'orderby' => 'meta_value menu_order',
			'order'=> 'ASC',
			'meta_query' => array(
				array(
					'key' => 'date',
					'value' => array(date_i18n('Y/m/d'), date_i18n('Y/m/t', mktime(0, 0, 0, date_i18n("n")+11, 1, date_i18n("Y")))),
					'compare' => 'BETWEEN',
					'type' => 'DATE'
				)
			)
		);
		$posts = get_posts($args);
		if($posts) {
			$html .= <<< EOT
<section class="sec_oc is_load_anime fadein">
	<div class="wrap">
		<div class="box_white_r">
			<h2 class="ttl_40 raleway">NEXT OPEN CAMPUS</h2>
			<ul class="list grid2 sp_grid2 stretch">
EOT;
			foreach($posts as $post) {
				setup_postdata($post);
				$date = date_i18n("m/d", strtotime(get_field("date", get_the_ID())));
				$time = esc_html(get_field("time", get_the_ID()));
				$youbi = $youbi_en[date_i18n("w", strtotime(get_field("date", get_the_ID())))];
				$title = esc_html(get_the_title());
				$image = get_the_post_thumbnail(get_the_ID(), "thumbnail", array("alt" => "", "class" => "cut_img cover"));
				$cat = get_the_terms(get_the_ID(), "cat_opencampus")[0]->slug;
				$tmp_dir = esc_url(get_template_directory_uri());
				$html .= <<<EOT
				<li>
					<a href="#oc" class="fade">
						<div class="inner">
							<div class="img">{$image}</div>
							<div class="box_txt">
								<div class="info">
									<p class="date nsj">{$date}</p>
									<p class="icon"><img src="{$tmp_dir}/img/index/{$cat}.png" alt=""></p>
								</div>
								<p class="time nsj">{$youbi}<br>{$time}</p>
								<h3 class="ttl nsj">{$title}</h3>
							</div>
						</div>
					</a>
				</li>
EOT;
			}
			$html .= <<<EOT
			</ul>
		</div>
	</div>
</section>
<!-- /.sec_oc -->
EOT;
		}
		wp_reset_postdata();
		return $html;
	}
	add_shortcode('top_next_oc', 'shortcode_top_next_oc');

	// トップページオープンキャンパス
	function shortcode_top_oc() {
		global $post;
		global $youbi_en;
		$tmp_dir = esc_url(get_template_directory_uri());
		$event_arr = array();

		// 該当月のオープンキャンパスを取得
		$args = array(
			'post_type' => 'opencampus',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'date',
					'value' => array(date_i18n('Y/m/d'), date_i18n('Y/m/t', mktime(0, 0, 0, date_i18n("n")+11, 1, date_i18n("Y")))),
					'compare' => 'BETWEEN',
					'type' => 'DATE'
				)
			)
		);
		$html = "";
		$posts = get_posts($args);
		global $oc_arr;
		foreach($posts as $key => $post) {
			setup_postdata($post);
			$date = get_field("date", get_the_ID());
			$cate = get_the_terms(get_the_ID(), "cat_opencampus")[0]->slug;
			$oc_arr[$date][$cate] = true;
		}
		wp_reset_postdata();

		$html .= <<<EOT
<section id="oc" class="sec_oc2 mt70 is_anime fadein">
	<div class="wrap w1200">
		<div class="box_white_r">
			<h2 class="ttl_sec"><span class="en raleway">OPEN CAMPUS</span>オープンキャンパス</h2>
			<p class="lead">織田きもの専門学校のオープンキャンパスでは<br class="sp">充実した授業体験を用意しています。</p>
			<div class="flex grid2">
				<div class="calendar">
					<div class="slider">
EOT;

		$target_month = date_i18n("Y/m/1");
		$target_e_month = date_i18n("Y/m/1", strtotime("+12 month", strtotime($target_month)));
		while($target_month !== $target_e_month) {
			$last_day = date_i18n("t", strtotime($target_month));
			$year = date_i18n("Y", strtotime($target_month));
			$month = date_i18n("n", strtotime($target_month));
			$month_en = jdmonthname(cal_to_jd(CAL_GREGORIAN, $month, 1, $year), 1);

			$calendar = array();
			$j = 0;

			// 月末日までループ
			for($i = 1; $i < $last_day + 1; $i++) {
				// 曜日を取得
				$week = date_i18n("w", mktime(0, 0, 0, $month, $i, $year));

				// 1日の場合
				if($i == 1) {
					// 前月末を取得
					$prev_last_day = date_i18n("t", mktime(0, 0, 0, $month, 0, $year));
					// 1日目の曜日までをループ
					for($s = 1; $s <= $week; $s++) {
						// 前半に前月の日付をセット
						$calendar[$j]['day'] = $prev_last_day - ($week - $s);
						$calendar[$j]['class'] = "prev";
						$j++;
					}
				}

				// 配列に日付をセット
				$calendar[$j]['day'] = $i;
				$j++;

				// 月末日の場合
				if($i == $last_day) {
					// 月末日から残りをループ
					for($e = 1; $e <= 6 - $week; $e++) {
						// 後半に翌月の日付をセット
						$calendar[$j]['day'] = $e;
						$calendar[$j]['class'] = "next";
						$j++;
					}
				}
			}

			$html .= <<<EOT
						<div class="block">
							<div class="head">
								<p class="month"><span class="jp"><span class="num">{$month}</span>月</span>-{$month_en}-</p>
							</div>
							<div class="main">
								<table>
									<tr>
										<th class="bc">Sun</th>
										<th class="bc">Mon</th>
										<th class="bc">Tue</th>
										<th class="bc">Wed</th>
										<th class="bc">Thu</th>
										<th class="bc">Fri</th>
										<th class="bc">Sat</th>
									</tr>
									<tr>
EOT;

			$table = "";
			$cnt = 0;
			foreach($calendar as $key => $val) {
				$class = array();
				$class[] = $val["class"];

				if($val["class"] === "prev") {
					$date_txt = date_i18n("Y/m/d", mktime(0, 0, 0, $month-1, $val["day"], $year));
				}
				elseif($val["class"] === "next") {
					$date_txt = date_i18n("Y/m/d", mktime(0, 0, 0, $month+1, $val["day"], $year));
				}
				else {
					$date_txt = date_i18n("Y/m/d", strtotime($year."/".$month."/".$val["day"]));
				}
				
				$table .= '<td>';
				if($val["class"] !== "prev" && $val["class"] !== "next") {
					$table .= '<p class="date">'.$val["day"].'</p>';
					
					if($oc_arr[$date_txt]["dressing"] || $oc_arr[$date_txt]["production"] || $oc_arr[$date_txt]["dressmaking"]) {
						$table .= '<ul class="icon">';
						if($oc_arr[$date_txt]["dressing"] == true) {
							$table .= '<li><img src="'.$tmp_dir.'/img/index/dressing.png" alt=""></li>';
						}
						if($oc_arr[$date_txt]["production"] == true) {
							$table .= '<li><img src="'.$tmp_dir.'/img/index/production.png" alt=""></li>';
						}
						if($oc_arr[$date_txt]["dressmaking"] == true) {
							$table .= '<li><img src="'.$tmp_dir.'/img/index/dressmaking.png" alt=""></li>';
						}
						$table .= '</ul>';
					}
				}
				$table .= "</td>";
				$cnt++;

				if($cnt == 7) {
					$table .= "
					</tr>
					<tr>";
					$cnt = 0;
				}
			}

			$table = rtrim($table, "<tr>");
			$table .= "</table></div></div>";

			$html .= $table;

			$target_month = date_i18n("Y/m/1", strtotime('+1 month', strtotime($target_month)));
		}

		wp_reset_postdata();

		$html .= <<<EOT
				</div>
				<div class="calendar_arw"></div>
				<div class="course grid2">
					<div class="item-icon">
						<p class="icon"><img src="{$tmp_dir}/img/index/dressing.png" alt=""></p>
						<p class="txt">着付け体験</p>
					</div>
					<div class="item-icon">
						<p class="icon"><img src="{$tmp_dir}/img/index/production.png" alt=""></p>
						<p class="txt">和小物製作体験</p>
					</div>
					<div class="item-icon" style="margin-top: auto;">
						<p class="icon"><img src="{$tmp_dir}/img/index/dressmaking.png" alt=""></p>
						<p class="txt">着付け&和小物製作体験</p>
					</div>
				</div>
			</div>
			<div class="oc">
				<h3 class="ttl_28 nsj">最新オープンキャンパス情報</h3>
					<ul class="list sp_grid2 stretch">
EOT;
		$args = array(
			'posts_per_page' => 2,
			'post_type' => 'opencampus',
			'meta_key' => 'date',
			'orderby' => 'meta_value menu_order',
			'order'=> 'ASC',
			'meta_query' => array(
				array(
					'key' => 'date',
					'value' => array(date_i18n('Y/m/d'), date_i18n('Y/m/t', mktime(0, 0, 0, date_i18n("n")+11, 1, date_i18n("Y")))),
					'compare' => 'BETWEEN',
					'type' => 'DATE'
				)
			)
		);
		$posts = get_posts($args);
		if($posts) {
			foreach($posts as $post) {
				setup_postdata($post);
				$date = date_i18n("m/d", strtotime(get_field("date", get_the_ID())));
				$time = esc_html(get_field("time", get_the_ID()));
				$youbi = $youbi_en[date_i18n("w", strtotime(get_field("date", get_the_ID())))];
				$title = esc_html(get_the_title());
				$image = get_the_post_thumbnail(get_the_ID(), "thumbnail", array("alt" => "", "class" => "cut_img cover"));
				$cat = get_the_terms(get_the_ID(), "cat_opencampus")[0]->slug;
				$tmp_dir = esc_url(get_template_directory_uri());
				$html .= <<<EOT
						<li>
							<a href="./oc/" class="fade">
								<div class="inner">
									<div class="img">{$image}</div>
									<div class="box_txt">
										<div class="info">
											<p class="date nsj">{$date}</p>
											<p class="icon"><img src="{$tmp_dir}/img/index/{$cat}.png" alt=""></p>
										</div>
										<p class="time nsj">{$youbi}<br>{$time}</p>
										<h3 class="ttl nsj">{$title}</h3>
									</div>
								</div>
							</a>
						</li>
EOT;
			}
		}

		$html .= <<<EOT
					</ul>
					<p class="btn tac"><a href="./oc/" class="btn_black fade raleway">read more</a></p>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.sec_oc2 -->
EOT;

		wp_reset_postdata();
		return $html;
	}
	add_shortcode('top_oc', 'shortcode_top_oc');

	// トップページキャンパスレポート
	function shortcode_top_campusreport() {
		if(!get_field("campusreport_flg", "option")) return;

		global $post;
		$campusreport_link = esc_url(get_post_type_archive_link("campusreport"));
		$args = array(
			'posts_per_page' => 4,
			'post_type' => 'campusreport',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$posts = get_posts($args);
		if($posts) {
			$html .= <<< EOT
<section class="sec_column mt70 is_anime fadein">
	<div class="wrap w1200">
		<div class="box_white_r">
			<h2 class="ttl_sec"><span class="en raleway">CAMPUS&nbsp;REPORT</span>キャンパス　レポート</h2>
			<ul class="list grid4 sp_grid2 stretch">
EOT;
			foreach($posts as $post) {
				setup_postdata($post);
				$url = esc_url(get_the_permalink());
				$date = get_the_time("Y.m.d");
				$image = get_the_post_thumbnail(get_the_ID(), "thumbnail", array("alt" => ""));
				$title = esc_html(get_the_title());
				$html .= <<<EOT
				<li>
					<a href="{$url}" class="fade">
						<div class="img">{$image}</div>
						<div class="box_txt">
							<h3 class="ttl">{$title}</h3>
							<p class="time">{$date}</p>
						</div>
					</a>
				</li>
EOT;
			}
			$html .= <<<EOT
			</ul>
			<p class="btn tac"><a href="{$campusreport_link}" class="btn_black fade raleway">read more</a></p>
		</div>
	</div>
</section>
<!-- /.sec_column -->
EOT;
		}
		wp_reset_postdata();
		return $html;
	}
	add_shortcode('top_campusreport', 'shortcode_top_campusreport');

	// トップページニュースリリース
	function shortcode_top_news() {
		global $post;
		$news_link = esc_url(get_post_type_archive_link("news"));
		$args = array(
			'posts_per_page' => 4,
			'post_type' => 'news',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$posts = get_posts($args);
		if($posts) {
			$html .= <<< EOT
<section class="sec_news mt70 is_anime fadein">
	<div class="wrap w1200">
		<div class="box_white_r">
			<h2 class="ttl_sec"><span class="en raleway">NEWS</span>ニュースリリース</h2>
			<ul class="list">
EOT;
			foreach($posts as $post) {
				setup_postdata($post);
				$url = esc_url(get_the_permalink());
				$date = get_the_time("Y.m.d");
				$image = get_the_post_thumbnail(get_the_ID(), "thumbnail", array("alt" => ""));
				$title = esc_html(get_the_title());
				$cat = "";
				foreach(get_the_terms(get_the_ID(), "cat_news") as $cat_news) {
					$cat .= '<li>#'.$cat_news->name.'</li>';
				}
				$html .= <<<EOT
				<li>
					<a href="{$url}" class="fade">
						<div class="info">
							<p class="date">{$date}</p>
							<ul class="tag">
								{$cat}
							</ul>
						</div>
						<p class="ttl">{$title}</p>
					</a>
				</li>
EOT;
			}
			$html .= <<<EOT
			</ul>
			<p class="btn tac"><a href="{$news_link}" class="btn_black fade raleway">read more</a></p>
		</div>
	</div>
</section>
<!-- /.sec_news -->
EOT;
		}
		wp_reset_postdata();
		return $html;
	}
	add_shortcode('top_news', 'shortcode_top_news');

	// KV画像
	function set_kv_image() {
		// トップページ
		if(is_front_page()) {
			$image_pc = esc_url(get_field("kv_image_pc"));
			$image_sp = esc_url(get_field("kv_image_sp"));
			$html = <<<EOT
<img src="{$image_pc}" alt="伝統と革新。新・日本美の創造。" class="pc">
<img src="{$image_sp}" alt="伝統と革新。新・日本美の創造。" class="sp">
EOT;
		}
		else {
			if(get_field("page_title")) {
				$title = wp_kses_post(get_field("page_title"));
			}
			else {
				$title = esc_html(get_the_title());
			}
			$caption = get_field("kv_caption");
			if(get_field("kv_image")) {
				$image = esc_url(get_field("kv_image"));
				$overlay = "";
				if(get_field("kv_overlay")) {
					$kv_overlay = hex2rgb(get_field("kv_overlay"));
					$kv_opacity = intval(get_field("kv_opacity")) / 100;
					$overlay = ' style="background:rgba('.$kv_overlay[0].', '.$kv_overlay[1].', '.$kv_overlay[2].', '.$kv_opacity.');"';
				}
				$html = <<<EOT
<section class="page-kv">
	<div class="overlay"{$overlay}></div>
	<div class="bg" style="background-image: url({$image})"></div>
EOT;
			}
			else {
				$html = <<<EOT
<section class="page-kv page-kv-noimage">
EOT;
							}
			$html .= <<<EOT
	<div class="wrap w960">
EOT;
			if(get_field("kv_image")) {
				$html .= <<<EOT
		<img src="{$image}" alt="" class="cut_img contain img">
EOT;
			}
			if($caption) {
				$html .= <<<EOT
		<p class="caption">{$caption}</p>
EOT;
			}
			$html .= <<<EOT
		<h1 class="ttl">{$title}</h1>
	</div>
</section>
<!-- /.sec_ttl -->
EOT;
		}

		return $html;
	}
	add_shortcode('kv_image', 'set_kv_image');

	// KV背景色
	function set_kv_color() {
		$title = esc_html(get_the_title());
		$kv_color = '';
		if(get_field("kv_color")) {
			$kv_color = ' style="background-color:'.get_field("kv_color").';"';
		}
		$html = <<<EOT
<section class="page-kv"{$kv_color}>
	<div class="wrap w960">
		<h1 class="ttl">{$title}</h1>
	</div>
</section>
<!-- /.page-kv -->
EOT;

		return $html;
	}
	add_shortcode('kv_color', 'set_kv_color');

	// 画像付きリンク
	function set_image_link($atts) {
		$no = $atts["no"];
		$html = "";
		$pos_arr = array("left" => "", "center" => " p-index-buttons-center", "right" => " p-index-buttons-right");

		if(is_numeric($no)) {
			$no = intval($no);
		}
		else {
			return $html;
		}
		
		$link_block = get_field("link_block")[$no-1];

		$ids = array();
		foreach($link_block["image_link"] as $image_link) {
			$ids[] = $image_link;
		}

		if($ids) {
			global $post;
			$args = array(
				'post_type' => 'any',
				'include' => implode(",", $ids),
				'orderby' => 'post__in'
			);
			$posts = get_posts($args);
			if($posts) {
				$pos = '';
				if(count($posts) == 1) {
					$pos = $pos_arr[$link_block["position"]];
				}
				$html .= <<<EOT
<div class="column-2 p-index-buttons{$pos}">
EOT;
				foreach($posts as $post) {
					setup_postdata($post);
					$url = esc_url(get_the_permalink());
					if(has_post_thumbnail()) {
						$image = esc_url(get_the_post_thumbnail_url());
					}
					else {
						$image = esc_url(get_template_directory_uri())."/img/news/noimg.jpg";
					}
					$transparent_image = esc_url(get_template_directory_uri())."/img/common/index-buttons.png";
					$title = esc_html(get_the_title());
					$html .= <<<EOT
	<div>
		<a href="{$url}" class="fade">
			<div class="p-img image-height">
				<img src="{$image}" alt="{$title}">
				<img src="{$transparent_image}" class="size">
			</div>
			<p class="p-txt">{$title}</p>
		</a>
	</div>
EOT;
				}
				$html .= <<<EOT
		</div>
EOT;
				wp_reset_postdata();
			}
		}
	
		return $html;
	}
	add_shortcode('image_link', 'set_image_link');


	// ページネーション
	function responsive_pagination($pages='', $range=1) {
		global $paged;
		if(empty($paged)) $paged = 1;

		//ページ情報の取得
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}

		if($pages <= 1) return;

		echo '<ul class="pagination-list mt80 sp-mt8">';

		if($paged != 1) {
			echo '<li class="pager_prev"><a href="'.get_pagenum_link($paged - 1).'" class="prev off fade"><span>prev</span></a></li>';
			echo '<li><a href="'.get_pagenum_link(1).'" class="fade">1</a></li>';

			if($paged-($range+1) > 1 && $pages > $range*2+1) {
				echo '<li><p>･･･</p></li>';
			}
		}
		else {
			echo '<li><a href="'.get_pagenum_link(1).'" class="this fade">1</a></li>';
//			echo '<div class="preview"></div>';
		}

		// 番号つきページ送りボタン
		if($pages > 1) {
			$display_arr = array();
			if($paged - $range - 1 < 0) {
				$under_cnt = abs($paged - $range - 1);
			}
			if($paged + $range - $pages > 0) {
				$over_cnt = $paged + $range - $pages;
			}
			for($i=2; $i<=$pages; $i++) {
				if($paged == 1 && $i <= $paged + $range * 2) {
					$display_arr[] = $i;
				}
				elseif($paged == $pages && $i >= $paged - $range * 2) {
					$display_arr[] = $i;
				}
				elseif($i >= $paged - $range - $over_cnt && $i <= $paged + $range + $under_cnt) {
					$display_arr[] = $i;
				}
			}

			foreach($display_arr as $val) {
				echo ($paged == $val) ? '<li><a href="'.get_pagenum_link($val).'" class="this fade">'.$val.'</a></li>':'<li><a href="'.get_pagenum_link($val).'" class="fade">'.$val.'</a></li>';
			}
		}

		if($paged != $pages) {
			if($pages > $range*2+1 && $paged < $pages-$range) {
				if($paged < $pages-$range-1) {
					echo '<li><p>･･･</p></li>';
				}
				echo '<li><a href="'.get_pagenum_link($pages).'" class="fade">'.$pages.'</a></li>';
			}

			echo '<li class="pager_next"><a href="'.get_pagenum_link($paged + 1).'" class="next on fade"><span>next</span></a></li>';
		}
		else {
//			echo '<div class="next"></div>';
		}

		echo '</ul>';
	}


	// HEX値をRGBに変換
	function hex2rgb ($hex) {
		if(substr($hex, 0, 1) == "#") $hex = substr($hex, 1);
		if(strlen($hex) == 3) $hex = substr($hex, 0, 1).substr($hex, 0, 1).substr($hex, 1, 1).substr($hex, 1, 1).substr($hex, 2, 1).substr($hex, 2, 1);
		return array_map("hexdec", [substr($hex, 0, 2), substr($hex, 2, 2), substr($hex, 4, 2)]);
	}

	// previous_post_link()とnext_post_link()を変更
	function add_prev_post_link_class($output) {
		$output = str_replace('rel="prev">', 'rel="prev"><span>', $output);
		$output = str_replace('</a>', '</span></a>', $output);
		return $output;
	}
	add_filter('previous_post_link', 'add_prev_post_link_class');
	function add_next_post_link_class($output) {
		$output = str_replace('rel="next">', 'rel="next"><span>', $output);
		$output = str_replace('</a>', '</span></a>', $output);
		return $output;
	}
	add_filter('next_post_link', 'add_next_post_link_class');


	// スマホ判別
	function is_mobile() {
		$useragents = array(
			'iPhone', // iPhone
			'iPod', // iPod touch
			'^(?=.*Android)(?=.*Mobile)', // 1.5+ Android
			'dream', // Pre 1.5 Android
			'CUPCAKE', // 1.5+ Android
			'blackberry9500', // Storm
			'blackberry9530', // Storm
			'blackberry9520', // Storm v2
			'blackberry9550', // Storm v2
			'blackberry9800', // Torch
			'webOS', // Palm Pre Experimental
			'incognito', // Other iPhone browser
			'webmate' // Other iPhone browser
		);
		$pattern = '/'.implode('|', $useragents).'/i';
		return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
	}


	// 一番上の親ページ名を取得
	function get_toplevel_page_name() {
		if(!is_page()) {
			return '';
		}

		global $post;
		$p = $post;
		while($p->post_parent != 0) {
			$p = get_post($p->post_parent);
		}
		return $p->post_name;
	}


	// オープンキャンパス申し込みフォームの日程を動的に設定
	function contact_form_my_select($children, $atts) {
		if($atts['name'] === 'date01' || $atts['name'] === 'date02' || $atts['name'] === 'date03') {
			$children = array("" => "選択してください");
			$args = array(
				'post_type' => 'opencampus',
				'posts_per_page' => -1,
				'meta_key' => 'date',
				'orderby' => 'meta_value menu_order',
				'order'=> 'ASC',
				'meta_query' => array(
					array(
						'key' => 'date',
						'value' => array(date_i18n('Y/m/d'), date_i18n('Y/m/t', mktime(0, 0, 0, date_i18n("n")+11, 1, date_i18n("Y")))),
						'compare' => 'BETWEEN',
						'type' => 'DATE'
					)
				)
			);
			$customPosts = get_posts($args);
			global $youbi_ja;
			foreach($customPosts as $post) {
				$children[$post->ID] = date_i18n("Y/m/d", strtotime(get_field("date", $post->ID)))."（".$youbi_ja[date_i18n("w", strtotime(get_field("date", $post->ID)))]."） ".get_field("time", $post->ID)."：".get_the_title($post->ID);
			}
		}
		return $children;
	}
	add_filter('mwform_choices_mw-wp-form-436' . $form_id, 'contact_form_my_select', 10, 2);


	// オープンキャンパス申し込みフォームで$_GET['oc']があったら、name属性がdate01の項目の初期値に設定
	function my_mwform_value($value, $name) {
		if($name === 'date01' && !empty($_GET['oc']) && !is_array($_GET['oc'])) {
			return $_GET['oc'];
		}
		return $value;
	}
	add_filter('mwform_value_mw-wp-form-436', 'my_mwform_value', 10, 2);