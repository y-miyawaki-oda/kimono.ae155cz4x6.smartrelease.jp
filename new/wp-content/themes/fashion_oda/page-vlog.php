<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
	<meta name="format-detection" content="telephone=no">
	<link rel="preconnect" href="https://fonts.gstatic.com">
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
<div class="bg_square">
	<header>
		<div class="wrap">
			<div class="head01">
				<p class="logo"><a href="<?php echo esc_url(home_url('/')); ?>" class="fade"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/vlog/logo.png" alt="織田きもの専門学校"></a></p>
				<h1 class="ttl"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/vlog/ttl.png" alt="oda fashion Vlog"></h1>
				<div class="menu_trigger"><span></span><span></span></div>
			</div>
			<nav class="gnavi">
				<ul class="main">
					<li><a href="#ranking"><span class="en roboto">RANKING</span></a></li>
					<li><a href="#life"><span class="en roboto">SCHOOL LIFE</span></a></li>
					<li><a href="#oc"><span class="en roboto">OPEN CAMPUS</span></a></li>
					<li><a href="#post"><span class="en roboto">NEW POST</span></a></li>
					<li class="bnr"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/vlog/logo_sp.png" alt="織田きもの専門学校"></a></li>
				</ul>
			</nav>
		</div>
	</header>

	<div class="container">
	<main>
		<section class="sec_mv is_load_anime fadein">
			<div class="wrap">
			<?php if(have_rows("recommend")): ?>
				<div class="slider_5 slider">
				<?php while(have_rows("recommend")): the_row(); ?>
					<div class="item">
						<div class="movie">
							<div class="yt">
								<div class="yt_video" youtube="https://www.youtube.com/embed/bjmBJ1Fl0cs?controls=1&loop=1&playlist=<?php the_sub_field("vid"); ?>&modestbranding=1&enablejsapi=1&playsinline=1">
									<img src="https://img.youtube.com/vi/<?php the_sub_field("vid"); ?>/maxresdefault.jpg" alt="" >
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				</div>
			<?php endif; ?>
			</div>
		</section>
		<!--/.sec_mv-->
		<section class="sec_navi">
			<div class="wrap">
				<h2 class="ttl">きもの学生の<span class="st">”<span class="green">REAL</span>”</span></h2>
				<ul class="link">
					<li><a href="#ranking" class="fade"><span class="en roboto">RANKING</span><span class="jp">(人気の動画)</span></a></li>
					<li><a href="#life" class="fade"><span class="en roboto">SCHOOL LIFE</span><span class="jp">(織田きものの日常)</span></a></li>
					<li><a href="#oc" class="fade"><span class="en roboto">OPEN CAMPUS</span><span class="jp">(オーキャンの雰囲気)</span></a></li>
					<li><a href="#post" class="fade"><span class="en roboto">NEW POST</span><span class="jp">(新着動画)</span></a></li>
				</ul>
			</div>
		</section>
		<!--/.sec_navi-->
		<section id="ranking" class="sec_ranking sec_slider is_anime fadein">
			<div class="wrap">
				<h2 class="ttl_sec"><span class="en roboto">RANKING</span>人気の動画</h2>
			<?php
				$youtube_api_key = 'AIzaSyA3QkPlXKam7SbhiqsSiWpNvdbWYYRtzHs';
				$youtube_channel_id = 'UCTSaPfxaqESuevv7dz8Phvg';
				$youtube_options = array(
						'key' => $youtube_api_key,
						'part' => 'snippet',
						'maxResults' => '10',
						'type' => 'video',
						'order' => 'viewCount',
						'channelId' => $youtube_channel_id,
				);
				$result = wp_remote_get("https://www.googleapis.com/youtube/v3/search?".http_build_query($youtube_options, '&'));
				$youtube_items = json_decode($result['body'], true);
			?>
			<?php if (!is_wp_error($result) && $result['response']['code'] == 200): ?>
				<div class="slider_4 ranking slider">
				<?php foreach($youtube_items["items"] as $item): ?>
					<div class="item">
						<div class="movie">
							<div class="yt">
								<div class="yt_video" youtube="https://www.youtube.com/embed/bjmBJ1Fl0cs?controls=1&loop=1&playlist=<?php echo esc_attr($item["id"]["videoId"]); ?>&modestbranding=1&enablejsapi=1&playsinline=1">
									<img src="https://img.youtube.com/vi/<?php echo esc_attr($item["id"]["videoId"]); ?>/maxresdefault.jpg" alt="" >
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
			</div>
		</section>
		<!--/.sec_ranking-->
		<section id="life" class="sec_life sec_slider is_anime fadein">
			<div class="wrap">
				<h2 class="ttl_sec"><span class="en roboto">SCHOOL LIFE</span>織田きものの日常</h2>
			<?php if(have_rows("school_life")): ?>
				<div class="slider_4 slider">
				<?php while(have_rows("school_life")): the_row(); ?>
					<div class="item">
						<div class="movie">
							<div class="yt">
								<div class="yt_video" youtube="https://www.youtube.com/embed/bjmBJ1Fl0cs?controls=1&loop=1&playlist=<?php the_sub_field("vid"); ?>&modestbranding=1&enablejsapi=1&playsinline=1">
									<img src="https://img.youtube.com/vi/<?php the_sub_field("vid"); ?>/maxresdefault.jpg" alt="" >
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				</div>
			<?php endif; ?>
			</div>
		</section>
		<!--/.sec_life-->
		<section id="oc" class="sec_oc sec_slider is_anime fadein">
			<div class="wrap">
				<h2 class="ttl_sec"><span class="en roboto">OPEN CAMPUS</span>オーキャンの雰囲気</h2>
			<?php if(have_rows("opencampus")): ?>
				<div class="slider_4 slider">
				<?php while(have_rows("opencampus")): the_row(); ?>
					<div class="item">
						<div class="movie">
							<div class="yt">
								<div class="yt_video" youtube="https://www.youtube.com/embed/bjmBJ1Fl0cs?controls=1&loop=1&playlist=<?php the_sub_field("vid"); ?>&modestbranding=1&enablejsapi=1&playsinline=1">
									<img src="https://img.youtube.com/vi/<?php the_sub_field("vid"); ?>/maxresdefault.jpg" alt="" >
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				</div>
			<?php endif; ?>
			</div>
		</section>
		<!--/.sec_oc-->
		<section id="post" class="sec_post sec_slider is_anime fadein">
			<div class="wrap">
				<h2 class="ttl_sec"><span class="en roboto">NEW POST</span>新着動画</h2>
			<?php
				$youtube_options = array(
						'key' => $youtube_api_key,
						'part' => 'snippet',
						'maxResults' => '10',
						'type' => 'video',
						'order' => 'date',
						'channelId' => $youtube_channel_id,
				);
				$result = wp_remote_get("https://www.googleapis.com/youtube/v3/search?".http_build_query($youtube_options, '&'));
				$youtube_items = json_decode($result['body'], true);
			?>
			<?php if (!is_wp_error($result) && $result['response']['code'] == 200): ?>
				<div class="slider_4 slider">
				<?php foreach($youtube_items["items"] as $item): ?>
					<div class="item">
						<div class="movie">
							<div class="yt">
								<div class="yt_video" youtube="https://www.youtube.com/embed/bjmBJ1Fl0cs?controls=1&loop=1&playlist=<?php echo esc_attr($item["id"]["videoId"]); ?>&modestbranding=1&enablejsapi=1&playsinline=1">
									<img src="https://img.youtube.com/vi/<?php echo esc_attr($item["id"]["videoId"]); ?>/maxresdefault.jpg" alt="" >
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
			</div>
		</section>
		<!--/.sec_post-->
		<section class="sec_bnr">
			<div class="wrap">
				<div class="btn">
					<a href="<?php echo esc_url(home_url('/')); ?>oc/" class="fade">
						<p class="txt"><span>和文化を体験できる</span></p>
						<p class="ttl">オープンキャンパス</p>
					</a>
				</div>
			</div>
		</section>
	</main>

	<footer>
		<div class="footer_navi">
			<div class="wrap">
				<ul class="link">
					<li><a href="<?php echo esc_url(home_url('/')); ?>faq/" class="fade">よくあるご質問</a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>reports/" class="fade">情報公開</a></li>
					<li><a href="https://oda.ac.jp/" target="_blank" class="fade">学校法人織田学園</a></li>
					<li><a href="<?php echo esc_url(home_url('/')); ?>sitemap/" class="fade">サイトマップ</a></li>
					<li><a href="https://oda.ac.jp/privacy/" target="_blank" class="fade">プライバシー・ポリシー</a></li>
				</ul>
				<p class="copyright">© Copyright 2020. Oda.ac. All rights reserved.</p>
			</div>
		</div>
	</footer>

</div>

<div class="fixedbnr">
	<p class="topbtn"><a href="#" class="fade"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/vlog/topbtn.png" alt="TOP"></a></p>
</div>

</div>
<?php wp_footer(); ?>
</body>
</html>
