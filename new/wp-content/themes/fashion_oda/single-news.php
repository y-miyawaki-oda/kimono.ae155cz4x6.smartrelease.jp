<?php get_header(); ?>
<?php if(have_posts()): ?>
	<?php while(have_posts()): the_post(); ?>
<div class="box_white_under">
	<section class="page-kv page-kv-noimage">	
		<div class="wrap w960">
			<h1 class="ttl">ニュースリリース</h1>
		</div>
	</section>
	<!-- /.page-kv -->
	<section class="sec_breadcrumb">
		<ul class="list">
			<li><a href="<?php echo esc_url(home_url('/')); ?>" class="fade">TOP</a></li>
			<li><a href="<?php echo esc_url(get_post_type_archive_link("news")); ?>" class="fade">ニュースリリース</a></li>
			<li><?php the_title(); ?></li>
		</ul>
	</section>
	<!-- /.sec_breadcrumb -->
	<section class="sec_contents post-news">
		<div class="post-news-headline">
			<div class="post-info-date">
				<p class="date"><?php the_time("Y.m.d"); ?></p>
				<p class="tag"><?php
					$cat_newses = array();
					foreach(get_the_terms(get_the_ID(), "cat_news") as $cat_news) {
						$cat_newses[] = $cat_news->name;
					}
					echo esc_html(implode(" , ", $cat_newses));
				?></p>
			</div>
			<h1 class="headline-1-1"><span><?php the_title(); ?></span></h1>
		</div>
		<div class="post-news-contents post-contents cf">
			<?php the_content(); ?>
		</div>
		<!-- ul class="pager small section pc">
			<li>
			<?php $prev_post = get_previous_post(); ?>
			<?php if(!empty($prev_post)): ?>
				<a href="<?php // echo get_permalink($prev_post->ID); ?>" class="prev off fade"><span>prev</span></a>
			<?php endif; ?>
			</li>
			<li>
				<a href="<?php // echo esc_url(get_post_type_archive_link("news")); ?>" class="fade next-page">一覧へ</a>
			</li>
			<li>
			<?php $next_post = get_next_post(); ?>
			<?php if(!empty($next_post)): ?>
				<a href="<?php // echo get_permalink($next_post->ID); ?>" class="next on fade"><span>next</span></a>
			<?php endif; ?>
			</li>
		</ul -->
		<div class="column-1 mt80 sp-mt8">
			<ul class="pagination-single">
				<li>
				<?php $prev_post = get_previous_post(); ?>
				<?php if(!empty($prev_post)): ?>
					<a href="<?php echo get_permalink($prev_post->ID); ?>" class="prev off fade"><span>prev</span></a><span class="txt">prev</span>
				<?php endif; ?>
				</li>
				<li>
				<?php $next_post = get_next_post(); ?>
				<?php if(!empty($next_post)): ?>
					<span class="txt">next</span><a href="<?php echo get_permalink($next_post->ID); ?>" class="next on fade"><span>next</span></a>
				<?php endif; ?>
				</li>
			</ul>
			<div class="btn-white mt80 sp-mt8"><a href="<?php echo esc_url(get_post_type_archive_link("news")); ?>" class="btn_type2 fade">ニュースリリース一覧へ</a></div>
		</div>
	</section>
	<!-- /.sec_detail -->
</div>
	<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>