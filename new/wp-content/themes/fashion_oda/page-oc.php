<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-K4W5M2C');</script>
	<!-- End Google Tag Manager -->
</head>
<body class="preload">
<header>
	<div class="wrap">
		<h1 class="logo">
        <a href="<?php echo esc_url(home_url('/oc/')); ?>" class="fade">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/logo_pc.png" alt="織田調理師専門学校" class="switch">
        </a>
        </h1>
		<nav class="gnavi">
			<ul class="main">
				<li class="pc1260">
					<a href="#about" class="fade">
						<span class="icon">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/navi_icon01.png" alt="">
						</span>
						<span class="txt">オープン<br>キャンパスとは</span>
					</a>
				</li>
				<li class="pc1260">
					<a href="#schedule" class="fade">
						<span class="icon">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/navi_icon02.png" alt="">
						</span>
						<span class="txt">スケジュール</span>
					</a>
				</li>
				<li class="pc1260">
					<a href="#flow" class="fade">
						<span class="icon">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/navi_icon03.png" alt="">
						</span>
						<span class="txt">参加までの流れ</span>
					</a>
				</li>
				<li class="pc1260">
					<a href="#faq" class="fade">
						<span class="icon">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/navi_icon04.png" alt="">
						</span>
						<span class="txt">よくあるご質問</span>
					</a>
				</li>
				<li class="yoyaku">
					<a href="<?php echo esc_url(home_url('/')); ?>contact/experience_entry/" class="fade">
						<span class="icon">
							<img src="/new/wp-content/uploads/2021/04/navi_icon05-2.png" alt="">
						</span>
						<span class="txt">参加申込</span>
					</a>
				</li>
			</ul>
		</nav>
		<div class="menu_trigger"><div class="line"><span></span><span></span></div><p class="txt">メニュー</p></div>
	</div>
</header>

<nav class="hamnavi gnavi sp_navi">
	<ul class="main">
		<li>
			<a href="#about" class="fade">
				<span class="icon">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/navi_icon01_sp.png" alt="">
				</span>
				<span class="txt">オープンキャンパスとは</span>
			</a>
		</li>
		<li>
			<a href="#schedule" class="fade">
				<span class="icon">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/navi_icon02_sp.png" alt="">
				</span>
				<span class="txt">スケジュール</span>
			</a>
		</li>
		<li>
			<a href="#flow" class="fade">
				<span class="icon">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/navi_icon03_sp.png" alt="">
				</span>
				<span class="txt">参加までの流れ</span>
			</a>
		</li>
		<li>
			<a href="#faq" class="fade">
				<span class="icon">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/navi_icon04_sp.png" alt="">
				</span>
				<span class="txt">よくあるご質問</span>
			</a>
		</li>
	</ul>
</nav>

<div class="container">
<main>
<?php remove_filter('the_content', 'wpautop'); ?>
<?php if(have_posts()): ?>
	<?php while (have_posts()): the_post(); ?>
	<div class="bg_dot">
		<section class="sec_mv is_load_anime fadein">
			<div class="wrap">
				<h2 class="img"><img src="<?php the_field("kv_image"); ?>" alt="OPEN  CAMPUS"></h2>
		<?php
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
						'value' => date_i18n('Y/m/d'),
						'compare' => '>=',
						'type' => 'DATE'
					)
				)
			);
			$posts = get_posts($args);
		?>
		<?php if($posts): ?>
				<ul class="oc">
			<?php foreach($posts as $post): setup_postdata($post); ?>
					<li>
						<div class="inner">
							<p class="day"><span class="big"><?php echo esc_html(date_i18n("n/j", strtotime(get_field("date")))); ?></span><?php echo esc_html($youbi_en[date_i18n("w", strtotime(get_field("date")))]); ?></p>
							<h3 class="ttl"><?php the_title(); ?></h3>
							<p class="time"><?php echo the_field("time"); ?></p>
						</div>
					</li>
			<?php endforeach; ?>
				</ul>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
				<p class="btn"><a href="#schedule" class="btn_black arw_v fade">他の日程もチェック!!</a></p>
				<p class="note"><a href="#covid-19" class="fade">※感染症対策の詳細はこちらからご覧になれます。</a></p>
			</div>
		</section>
		<!--/.sec_mv-->
		<section id="about" class="sec_about is_anime fadein">
			<div class="wrap w1200">
				<div class="head">
					<div class="img">
						<div class="img_cross cross01"><img src="/new/wp-content/uploads/2021/03/stevndv26059_250_250.jpg" alt=""></div>
						<div class="img_cross cross02"><img src="/new/wp-content/uploads/2021/03/stevndv15159_250_250.jpg" alt=""></div>
					</div>
					<h2 class="ttl">
						<span class="mark">日本の伝統文化を体験できる！</span><br>
						織田きものの<br><span class="color">オープンキャンパス！</span>
					</h2>
				</div>
				<div class="detail">
					<h3 class="box_ttl">織田きものの<br class="sp br_tab"><span class="big">オープンキャンパスでは...</span></h3>
					<ul class="list">
						<li>
							<div class="img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/cook_icon.png" alt=""></div>
							<h4 class="txt">和文化を<br class="pc"><span class="big">体験できる</span></h4>
						</li>
						<li>
							<div class="img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/about_icon02.png" alt=""></div>
							<h4 class="txt">教員・在校生と<br class="pc"><span class="big">話せる</span></h4>
						</li>
						<li>
							<div class="img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/about_icon03.png" alt=""></div>
							<h4 class="txt"><span class="big">入学・就職</span>について<br class="pc">聞ける</h4>
						</li>
						<li>
							<div class="img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/about_icon04.png" alt=""></div>
							<h4 class="txt"><span class="big">個別相談</span>が<br class="pc">できる</h4>
						</li>
					</ul>
				</div>
				<div class="menu">
					<h3 class="box_ttl">和小物作りや<br><span class="big">着付けを体験</span><br class="sp br_tab">できるメニューを揃えました</h3>
					<div class="grid">
						<ul class="grid2">
							<li class="pink">
								<img class="icon" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/dressing.png" />
								<p class="txt">着付け体験</p>
							</li>
							<li class="cyan">
								<img class="icon" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/production.png" />
								<p class="txt">和小物製作体験</p>
							</li>
							<li class="orange">
								<img class="icon" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/access.png" />
								<p class="txt">着付け&<br class="sp">和小物製作体験</p>
							</li>
						</ul>
						<!-- <div class="box box_red">
							<div class="top">
								<p class="cat os"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/about_img03.png" alt="">DESIGN & TECHNICAL</p>
								<h4 class="ttl">調理<br class="sp">デザイン<br>&<br>調理<br class="sp br_tab">テクニカルコース</h4>
							</div>
							<p class="ttl_osusume"><span class="mark">こんな人におすすめ！</span></p>
							<div class="center">
								<ul class="check">
									<li>デザイナーになりたい！</li>
									<li>パタンナーって何するの？</li>
									<li>縫製をやりたい！</li>
								</ul>
							</div>
						</div>
						<div class="box box_blue">
							<div class="top">
								<p class="cat os"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/about_img04.png" alt="">STYLIST & BUSINESS</p>
								<h4 class="ttl">スタイリスト<br>&<br>調理<br class="sp br_tab">ビジネスコース</h4>
							</div>
							<p class="ttl_osusume"><span class="mark">こんな人におすすめ！</span></p>
							<div class="center">
								<ul class="check">
									<li>販売員になりたい！</li>
									<li>スタイリストに興味がある...</li>
								</ul>
							</div>
						</div> -->
					</div>
				</div>
			</div>
		</section>
		<!--/.sec_about-->
	</div>
	<div class="bg_green">
		<section id="schedule" class="sec_schedule is_anime fadein">
			<div class="wrap">
				<h2 class="ttl_sec"><span class="line en os">Schedule</span><span class="jp">オープンキャンパススケジュール</span></h2>
		<?php
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
			$posts = get_posts($args);
			foreach($posts as $key => $post) {
				setup_postdata($post);
				$date = get_field("date", get_the_ID());
				$cate = get_the_terms(get_the_ID(), "cat_opencampus")[0]->slug;
				$oc_arr[$date][$cate] = get_the_ID();
			}
			wp_reset_postdata();
		?>
				<div class="calendar">
					<div class="slider">
		<?php
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
		?>
						<div class="block">
							<div class="head">
								<p class="month"><span class="jp"><span class="num"><?php echo $month; ?></span>月</span>-<?php echo $month_en; ?>-</p>
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
			<?php
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

					if($cnt == 0) {
						$table .= '<td class="sun">';
					}
					else {
						$table .= '<td>';
					}
					if($val["class"] !== "prev" && $val["class"] !== "next") {
						$table .= '<p class="date">'.$val["day"].'</p>';
						if($oc_arr[$date_txt]["dressmaking"] || $oc_arr[$date_txt]["production"] || $oc_arr[$date_txt]["dressing"]) {
							$table .= '<ul class="icon">';
							if($oc_arr[$date_txt]["dressmaking"]) {
								$table .= '<li><a href="#oc'.$oc_arr[$date_txt]["dressmaking"].'"><img src="'.esc_url(get_template_directory_uri()).'/img/opencampus/access.png" alt=""></a></li>';
							}
							if($oc_arr[$date_txt]["production"]) {
								$table .= '<li><a href="#oc'.$oc_arr[$date_txt]["production"].'"><img src="'.esc_url(get_template_directory_uri()).'/img/opencampus/production.png" alt=""></a></li>';
							}
							if($oc_arr[$date_txt]["dressing"]) {
								$table .= '<li><a href="#oc'.$oc_arr[$date_txt]["dressing"].'"><img src="'.esc_url(get_template_directory_uri()).'/img/opencampus/dressing.png" alt=""></a></li>';
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

				echo $table;

				$target_month = date_i18n("Y/m/1", strtotime('+1 month', strtotime($target_month)));
			?>
								</table>
							</div>
						</div>
		<?php
			}
		?>
					</div>
					<div class="calendar_arw"></div>
					<div class="course grid2 cal">
						<div class="item">
							<p class="icon"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/dressing.png" alt=""></p>
							<p class="txt">着付け体験</p>
						</div>
						<div class="item">
							<p class="icon"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/production.png" alt=""></p>
							<p class="txt">和小物製作体験</p>
						</div>
						<div class="item">
							<p class="icon"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/access.png" alt=""></p>
							<p class="txt">着付け&和小物製作体験</p>
						</div>
					</div>
				</div>
				<div class="detail">
					<ul>
						<li>各コースとも<span class="st">定員制</span>です。</li>
						<li>オープンキャンパスは<span class="st">事前のお申し込みが必要</span>です。</li>
						<li>参加費は<span class="st">無料！</span>何度でもご参加いただけます。</li>
					</ul>
				</div>
		<?php
			// 該当月のオープンキャンパスを取得
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
			$posts = get_posts($args);
		?>
		<?php if($posts): ?>
				<ul class="oc">
			<?php foreach($posts as $key => $post): setup_postdata($post); ?>
				<?php
					$cat = get_the_terms(get_the_ID(), "cat_opencampus")[0]->slug;
					if($cat === "dressing") {
						$cat_class = 'pink';
						$cat_icon = 'dressing_1';
						$cat_txt = '着付け体験';
					}
					elseif($cat === "production") {
						$cat_class = 'cyan';
						$cat_icon = 'production_1';
						$cat_txt = '和小物製作体験';
					}
					elseif($cat === "dressmaking") {
						$cat_class = 'orange';
						$cat_icon = 'access_1';
						$cat_txt = '着付け&和小物製作体験';
					}
				?>
					<li id="oc<?php the_ID(); ?>" class="box_<?php echo $cat_class; ?>">
						<h3 class="head"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/opencampus/<?php echo $cat_icon; ?>.png" alt=""><?php echo $cat_txt; ?></h3>
						<div class="inner">
							<div class="cnt">
								<div class="img"><?php the_post_thumbnail("opencampus_list"); ?></div>
								<div class="box_txt">
									<div class="info">
										<p class="date"><?php the_field("date"); ?></p>
										<p class="time"><span class="bold"><?php echo esc_html($youbi_en[date_i18n("w", strtotime(get_field("date")))]); ?></span>　<br class="sp"><?php the_field("time"); ?></p>
									</div>
									<p class="ttl"><?php the_title(); ?></p>
									<p class="txt">
										<?php the_field("description"); ?>
									</p>
								</div>
							</div>
							<p class="btn">
							<?php if(intval(date_i18n("Ymd", strtotime(get_field("date")))) < intval(date_i18n("Ymd"))): ?>
								<span class="btn_black arw_h fade disabled">終了しました</span>
							<?php else: ?>
								<a href="<?php echo esc_url(home_url('/')); ?>contact/experience_entry/?oc=<?php the_ID(); ?>" class="btn_black arw_h fade">申し込む</a>
							<?php endif; ?>
							</p>
						</div>
					</li>
			<?php endforeach; ?>
				</ul>
				<div class="more more_schedule">
					<p class="txt_mark"><span class="mark">以降の日程&amp;メニューもチェック</span></p>
					<p class="btn"><span class="btn_white fade"><span class="icon change">もっとみる</span></span></p>
				</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
			</div>
		</section>
		<!--/.sec_schedule-->
		<?php the_content(); ?>
	</div>
	<?php endwhile; ?>
<?php endif; ?>
<?php get_footer("opencampus"); ?>