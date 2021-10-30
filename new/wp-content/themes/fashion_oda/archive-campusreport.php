<?php get_header(); ?>
<div class="box_white_under">
	<?php if(get_field("kv_campusreport_image", "option")): ?>	
		<?php
			$overlay = "";
			if(get_field("kv_campusreport_overlay", "option")) {
				$kv_overlay = hex2rgb(get_field("kv_campusreport_overlay", "option"));
				$kv_opacity = intval(get_field("kv_campusreport_opacity", "option")) / 100;
				$overlay = ' style="background:rgba('.$kv_overlay[0].', '.$kv_overlay[1].', '.$kv_overlay[2].', '.$kv_opacity.');"';
			}
		?>
	<section class="page-kv">
		<div class="overlay"<?php echo $overlay; ?>></div>
		<div class="bg" style="background-image: url(<?php the_field("kv_campusreport_image", "option"); ?>)"></div>
	<?php else: ?>
	<section class="page-kv page-kv-noimage">
	<?php endif; ?>
		<div class="wrap w960">
	<?php if(get_field("kv_campusreport_image", "option")): ?>
			<img src="<?php the_field("kv_campusreport_image", "option"); ?>" alt="" class="cut_img contain img">
	<?php endif; ?>
			<h1 class="ttl">キャンパスレポート</h1>
		</div>
	</section>
	<!-- /.page-kv -->
	<section class="sec_breadcrumb">
		<ul class="list">
			<li><a href="<?php echo esc_url(home_url('/')); ?>" class="fade">TOP</a></li>
			<li> キャンパスレポート</li>
		</ul>
	</section>
	<!-- /.sec_breadcrumb -->
	<section class="sec_report section">
	<?php if(have_posts()): ?>
		<div class="wrap w1080">
			<ul class="link_list grid2 grid2_mtx2 sp_grid1">
		<?php while(have_posts()): the_post(); ?>
				<li>
					<a href="<?php the_permalink(); ?>" class="fade">
						<div class="img"><?php the_post_thumbnail("talk_list"); ?></div>
					<?php
						$num = 33;
						$numc = $num*2;
						$gettit = strip_tags(get_the_title());
						if($numc <= strlen(mb_convert_encoding($gettit, "SJIS", "UTF-8"))) {
							$title = mb_strimwidth($gettit, 0, $numc, '','UTF-8');
							if($numc < strlen(mb_convert_encoding($gettit, "SJIS", "UTF-8"))) $title .= "…";
						}else{
							$title = $gettit;
						}
					?>
						<div class="txt_box">
							<p class="txt"><?php echo esc_html($title); ?></p>
						</div>
					</a>
				</li>
		<?php endwhile; ?>
			</ul>
		<?php
			if(function_exists("responsive_pagination")) {
				responsive_pagination();
			}
		?>
		</div>
	<?php endif; ?>
	</section>
	<!-- /.sec_about -->
</div>
<?php get_footer(); ?>
