<?php get_header(); ?>
<?php
	$post_type = 'news';
	$taxonomy  = 'cat_news';

	$courses = get_terms(array(
		'taxonomy'   => $taxonomy,
		'hide_empty' => false
	));

	$current_label = is_tax($taxonomy)? get_queried_object(): null;
	$current_year  = is_year()? get_query_var('raw_year'): null;

	$index_url = get_post_type_archive_link($post_type);
?>
<div class="box_white_under">
	<?php if(get_field("kv_news_image", "option")): ?>
		<?php
			$overlay = "";
			if(get_field("kv_news_overlay", "option")) {
				$kv_overlay = hex2rgb(get_field("kv_news_overlay", "option"));
				$kv_opacity = intval(get_field("kv_news_opacity", "option")) / 100;
				$overlay = ' style="background:rgba('.$kv_overlay[0].', '.$kv_overlay[1].', '.$kv_overlay[2].', '.$kv_opacity.');"';
			}
		?>
	<section class="page-kv">
		<div class="overlay"<?php echo $overlay; ?>></div>
		<div class="bg" style="background-image: url(<?php the_field("kv_news_image", "option"); ?>)"></div>
	<?php else: ?>
	<section class="page-kv page-kv-noimage">
	<?php endif; ?>
		<div class="wrap w960">
	<?php if(get_field("kv_news_image", "option")): ?>
			<img src="<?php the_field("kv_news_image", "option"); ?>" alt="" class="cut_img contain img">
	<?php endif; ?>
			<h1 class="ttl">ニュースリリース</h1>
		</div>
	</section>
	<!-- /.page-kv -->
	<section class="sec_breadcrumb">
		<ul class="list">
			<li><a href="<?php echo esc_url(home_url('/')); ?>" class="fade">TOP</a></li>
		<?php if(is_tax()): ?>
			<li><a href="<?php echo esc_url(get_post_type_archive_link("news")); ?>" class="fade">ニュースリリース</a></li>
			<li><?php single_term_title(); ?></li>
		<?php else: ?>
			<li>ニュースリリース</li>
		<?php endif; ?>
		</ul>
	</section>
	<!-- /.sec_breadcrumb -->
	<section class="sec_contents">
		<div class="category-select">
			<div class="select_box">
				<p class="btn"><span class="txt">カテゴリーを選択</span></p>
				<ul class="children">
					<li data-value="<?php echo esc_html(oda_fashion_get_archive_link($current_year, null)); ?>">カテゴリーを選択</li>
					<?php $terms = get_terms($taxonomy, array('hide_empty'=>false)); ?>
					<?php foreach($terms as $term): ?>
						<li data-value="<?php echo esc_url(oda_fashion_get_archive_link($current_year, $term)); ?>"><?php echo esc_html($term->name); ?></li>
					<?php endforeach; ?>
				</ul>
				<input type="hidden" name="" value="<?php echo esc_html(oda_fashion_get_archive_link($current_year, $current_label)); ?>">
			</div>
			<div class="select_box">
				<p class="btn"><span class="txt">年度を選択</span></p>
				<ul class="children">
					<li data-value="<?php echo esc_html(oda_fashion_get_archive_link(null, $current_label)); ?>">年度を選択</li>
					<?php $yearly = oda_fashion_news_get_yearly_archives('DESC'); ?>
					<?php foreach($yearly as $year=>$url): ?>
						<li data-value="<?php echo esc_html(oda_fashion_get_archive_link($year, $current_label)); ?>"><?php echo esc_html($year); ?>年度</li>
					<?php endforeach; ?>
				</ul>
				<input type="hidden" value="<?php echo esc_html(oda_fashion_get_archive_link($current_year, $current_label)); ?>">
			</div>
		</div>
		<?php if(have_posts()): ?>
			<ul class="news-list column-4 sp-column-2 mt60">
			<?php while(have_posts()): the_post(); ?>
					<li><a href="<?php the_permalink(); ?>" class="fade">
						<div class="img">
						<?php if(has_post_thumbnail()): ?>
							<?php the_post_thumbnail("thumbnail"); ?>
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/news/img.png" alt="" class="size">
						<?php else: ?>
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/news/noimg.jpg" alt="">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/news/img.png" alt="" class="size">
						<?php endif; ?>
						</div>
						<div class="box_txt">
							<ul class="tag">
							<?php foreach(get_the_terms(get_the_ID(), "cat_news") as $the_term): ?>
								<li>#<?php echo esc_html($the_term->name); ?></li>
							<?php endforeach; ?>
							</ul>
							<h3 class="ttl"><?php the_title(); ?></h3>
							<p class="time"><?php the_time("Y.m.d"); ?></p>
						</div>
					</a></li>
			<?php endwhile; ?>
			</ul>
		<?php
			if(function_exists("responsive_pagination")) {
				responsive_pagination();
			}
		?>
		<?php endif; ?>
	</section>
	<!-- /.sec_news -->
</div>
<?php get_footer(); ?>
