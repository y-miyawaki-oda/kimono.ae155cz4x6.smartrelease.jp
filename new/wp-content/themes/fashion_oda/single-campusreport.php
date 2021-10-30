<?php get_header(); ?>
<?php if(have_posts()): ?>
	<?php while(have_posts()): the_post(); ?>
<div class="box_white_under">
	<section class="page-kv">	
		<div class="overlay"></div>
		<div class="bg" style="background-image: url(<?php the_post_thumbnail_url("full"); ?>)"></div>
		<div class="wrap w960">
			<?php the_post_thumbnail("full", array("class" => "cut_img cover img")); ?>
			<h1 class="ttl">キャンパスレポート</h1>
		</div>
	</section>
	<!-- /.page-kv -->
	<section class="breadcrumb">
		<div class="wrap w1080">
			<ul class="list">
				<li><a href="<?php echo esc_url(home_url('/')); ?>" class="fade">TOP</a></li>
				<li><a href="<?php echo esc_url(get_post_type_archive_link("campusreport")); ?>" class="fade">キャンパスレポート</a></li>
				<li> <?php the_title(); ?></li>
			</ul>
		</div>
	</section>
	<!-- /.breadcrumb -->
	<section class="sec_report_detail section">
		<div class="wrap w960">
			<h1 class="ttl"><?php the_title(); ?></h1>
			<div class="cnt">
				<?php the_content(); ?>
			</div>
			<ul class="pager small section">
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
			<div class="btn tac"><a href="<?php echo esc_url(get_post_type_archive_link("campusreport")); ?>" class="btn_type2 fade">キャンパスレポート一覧へ</a></div>
		</div>
	</section>
	<!-- /.sec_about -->
</div>
	<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
