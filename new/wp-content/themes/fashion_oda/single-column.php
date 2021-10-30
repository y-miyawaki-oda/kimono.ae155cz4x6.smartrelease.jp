<?php get_header(); ?>
<?php if(have_posts()): ?>
	<?php while(have_posts()): the_post(); ?>
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
			<h1 class="ttl"><?php the_title(); ?></h1>
		</div>
	</section>
	<!-- /.page-kv -->
	<section class="sec_breadcrumb">
		<ul class="list">
			<li><a href="<?php echo esc_url(home_url('/')); ?>" class="fade">TOP</a></li>
			<li><a href="<?php echo esc_url(get_post_type_archive_link("column")); ?>" class="fade">きものコラム</a></li>
			<li><?php the_title(); ?></li>
		</ul>
	</section>
	<!-- /.sec_breadcrumb -->
	<section class="sec_contents post-column">
			<h2 class="headline-2-3"><?php the_field("sub_title"); ?></h2>
			<div class="post-column-contents post-contents cf">
				<?php the_content(); ?>
			</div>
			<p class="tag tar">
				<?php
					$cat_columns = array();
					foreach(get_the_terms(get_the_ID(), "cat_column") as $cat_column) {
						$cat_columns[] = $cat_column->name;
					}
				?>
				カテゴリ：<?php echo esc_html(implode(" , ", $cat_columns)); ?>
			</p>
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
				<div class="btn-white mt80 sp-mt8"><a href="<?php echo esc_url(get_post_type_archive_link("column")); ?>" class="btn_type2 fade">きものコラム一覧へ</a></div>
			</div>
		<?php if(get_field("sec_opencampus")): ?>
			<h3 class="headline-3-1 mt80 sp-mt8"><span>織田きものを<br class="sp">体験しよう！</span></h3>
			<div class="column-3 sp-column-2 column-h-center">
				<div>
					<a href="<?php echo esc_url(home_url('/')); ?>oc/" class="a-block">
						<div class="image-bg-line">
							<div class="image"><img src="/new/wp-content/uploads/2021/03/stevndv26059_250_250.jpg" alt=""></div>
						</div>
						<p class="text-size18 tac">和小物作りや</p>
					</a>
				</div>
				<div>
					<a href="<?php echo esc_url(home_url('/')); ?>oc/" class="a-block">
						<div class="image-bg-line">
							<div class="image"><img src="/new/wp-content/uploads/2021/03/stevndv21391_250_250.jpg" alt=""></div>
						</div>
						<p class="text-size18 tac">着付に挑戦します！</p>
					</a>
				</div>
			</div>
			<div class="column-1">
				<p class="btn-black"><a href="<?php echo esc_url(home_url('/')); ?>oc/" class="btn_type1 fade">オープンキャンパスページへ</a></p>
			</div>
	</section>
	<!-- /.sec_department_opencampus -->
		<?php endif; ?>
	</section>
</div>
	<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>