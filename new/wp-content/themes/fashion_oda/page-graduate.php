<?php get_header(); ?>
<?php if(get_toplevel_page_name() === "career"): ?>
<div class="box_white_under">
	<?php echo do_shortcode('[kv_image]'); ?>
	<section class="sec_breadcrumb">
		<ul class="list">
			<li><a href="<?php echo esc_url(home_url('/')); ?>" class="fade">TOP</a></li>
			<li><a href="<?php echo esc_url(home_url('/')); ?>career/" class="fade">就職・資格</a></li>
			<li> 卒業生VOICE</li>
		</ul>
	</section>
	<!-- /.sec_breadcrumb -->
	<section class="sec_contents">
		<h2 class="headline-2-1">様々なフィールドで活躍する卒業生たち</h2>
		<ul class="anchor-link-voice">
		<?php foreach(get_terms("job", "hide_empty=1&orderby=menu_order&order=ASC") as $job): ?>
			<?php
				if(get_field("name", $job)) {
					$job_name = get_field("name", $job);
				}
				else {
					$job_name = $job->name;
				}
			?>
			<li><a href="#<?php echo esc_attr($job->slug); ?>" class="fade"><?php echo wp_kses_post($job_name); ?></a></li>
		<?php endforeach; ?>
		</ul>

<?php foreach(get_terms("job", "hide_empty=1&orderby=menu_order&order=ASC") as $job): ?>
	<div id="<?php echo esc_attr($job->slug); ?>" class="mt80 sp-mt8 block-text-area">
		<h3 class="headline-3-1"><span class="line"><?php echo esc_html($job->name); ?></span></h3>
	<?php
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'graduate',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'job',
					'field' => 'slug',
					'terms' => array($job->slug),
					'operator' => 'IN'
				)
			),
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$posts = get_posts($args);
	?>
	<?php if($posts): ?>
		<?php foreach($posts as $post): setup_postdata($post); ?>
			<h4 class="headline-4-1 tac"><?php the_field("title"); ?></h4>
			<div class="column-1-vertical">
				<div class="image"><?php the_post_thumbnail("graduate_list", array("alt" => get_the_title())); ?></div>
			</div>
			<p class="text-size24 bold tac"><?php the_title(); ?>/<?php the_field("job"); ?><br><?php the_field("company"); ?></p>
			<p class="text-size18 bold tac"><?php if(get_field("school")): ?><?php the_field("school"); ?><br><?php endif; ?><?php the_field("graduate"); ?>卒業</p>
			<div>
				<?php the_field("interview"); ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
	</div>
	<!-- /.sec_voice -->
<?php endforeach; ?>
<?php else: ?>
	<?php remove_filter('the_content', 'wpautop'); ?>
	<?php if(have_posts()): while (have_posts()): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>
<?php endif; ?>
	</section>
<?php get_footer(); ?>
