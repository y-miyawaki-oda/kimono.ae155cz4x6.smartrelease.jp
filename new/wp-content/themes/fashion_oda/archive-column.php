<?php get_header(); ?>
<div class="box_white_under">
	<?php if(get_field("kv_column_image", "option")): ?>	
		<?php
			$overlay = "";
			if(get_field("kv_column_overlay", "option")) {
				$kv_overlay = hex2rgb(get_field("kv_column_overlay", "option"));
				$kv_opacity = intval(get_field("kv_column_opacity", "option")) / 100;
				$overlay = ' style="background:rgba('.$kv_overlay[0].', '.$kv_overlay[1].', '.$kv_overlay[2].', '.$kv_opacity.');"';
			}
		?>
	<section class="page-kv">
		<div class="overlay"<?php echo $overlay; ?>></div>
		<div class="bg" style="background-image: url(<?php the_field("kv_column_image", "option"); ?>)"></div>
	<?php else: ?>
	<section class="page-kv page-kv-noimage">
	<?php endif; ?>
		<div class="wrap w960">
			<h1 class="ttl">きものコラム</h1>
		</div>
	</section>
	<!-- /.page-kv -->
	<section class="sec_breadcrumb">
		<ul class="list">
			<li><a href="<?php echo esc_url(home_url('/')); ?>" class="fade">TOP</a></li>
			<li>きものコラム</li>
		</ul>
	</section>
	<!-- /.sec_breadcrumb -->
	<section class="sec_contents">
	<?php if(have_posts()): ?>
			<div class="column-2 p-index-buttons">
		<?php while(have_posts()): the_post(); ?>
				<div>
					<a href="<?php the_permalink(); ?>" class="fade">
						<div class="p-img image-height">
							<?php the_post_thumbnail("talk_list"); ?>
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/column/img.png" alt="" class="size">
						</div>
						<p class="p-txt"><?php the_title(); ?></p>
					</a>
				</div>
		<?php endwhile; ?>
			</div>
		<?php
			if(function_exists("responsive_pagination")) {
				responsive_pagination();
			}
		?>
	<?php endif; ?>
	</section>
	<!-- /.sec_column -->
</div>
<?php get_footer(); ?>
