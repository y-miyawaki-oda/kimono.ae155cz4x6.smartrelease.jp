		</main>

		<footer<?php if(is_page(array("confirm", "thanks"))) echo ' class="pb00"'; ?>>
			<div class="footer_main">
				<div class="wrap">
					<div class="flex">
						<div class="school">
							<p class="logo"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/footer_logo.png" alt="織田きもの専門学校"></p>
							<p class="adr">〒164-0001 東京都中野区中野5-32-8</p>
							<p class="btn tac"><a href="<?php echo esc_url(home_url('/')); ?>about/access/" class="fade"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/map_icon.png" alt="">アクセスマップ</a></p>
						</div>
						<div class="contact">
							<p class="txt">
								オープンキャンパス参加の<br class="sp_navi">お申し込みはもちろん、<br>気になることがあれば、何でもご相談ください<br>
								<span class="big">入学相談課</span><br>
								<span class="time">受付時間：平日9:00～17:00</span>
							</p>
							<p class="tel "><a href="tel:0332282111"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/tel_icon_pc.png" alt="" class="switch">03-3228-2111</a></p>
						</div>
					</div>
					<ul class="link">
						<li><a href="<?php echo esc_url(home_url('/')); ?>lineguidance/" class="fade">LINEで<br class="sp_navi">お問い合わせ</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>contact/tour_entry/" class="fade">フォームで<br class="sp_navi">お問い合わせ</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>oc/" class="fade">オープン<br class="sp_navi">キャンパス</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>contact/pamphlet/" class="fade">資料請求</a></li>
					</ul>
				</div>
			</div>
			<div class="footer_sns">
				<div class="wrap">
					<p class="ttl nunito">SNS</p>
					<ul class="list">
						<li><a href="https://www.instagram.com/odakimonocollege/" class="fade" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/sns_insta.png" alt="instagram"></a></li>
						<li><a href="https://lin.ee/lUyLfrX" class="fade" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/sns_line.png" alt="line"></a></li>
						<li><a href="https://www.youtube.com/channel/UCvO5igCFG2fQ6_cqC-MT02Q" class="fade" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/sns_youtube.png" alt="youtube"></a></li>
					</ul>
				</div>
			</div>
			<div class="footer_navi">
				<div class="wrap">
					<ul class="link">
						<li><a href="<?php echo esc_url(home_url('/')); ?>faq/" class="fade">よくある<br class="br_tab">ご質問</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>reports/" class="fade">情報公開</a></li>
						<li><a href="https://oda.ac.jp/" target="_blank" class="fade">学校法人<br class="br_tab">織田学園</a></li>
						<li><a href="<?php echo esc_url(home_url('/')); ?>sitemap/" class="fade">サイトマップ</a></li>
						<li><a href="https://oda.ac.jp/recruit/" target="_blank" class="fade">教職員募集</a></li>
						<li><a href="https://oda.ac.jp/privacy/" target="_blank" class="fade">プライバシー・<br class="br_tab">ポリシー</a></li>
					</ul>
					<p class="copyright nunito">&copy; Copyright 2021. Oda.ac. All rights reserved.</p>
				</div>
			</div>
		</footer>

		<?php if(is_page(array("tour_entry", "pamphlet", "experience_entry"))): ?>
		<div class="fixedbnr fixed_countbnr">
		<?php else : ?>
		<div class="fixedbnr fixed_linkbnr">
		<?php endif; ?>
			<p class="topbtn"><a href="#" class="fade">
            <img class="pc" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/topbtn.png" alt="TOP">
            <img class="sp" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/topbtn_sp.png" alt="TOP">
            </a></p>
		<?php if(is_page(array("tour_entry", "pamphlet", "experience_entry"))): ?>
			<ul class="req">
				<li><span class="v">残り必須項目</span><span class="num"></span></li>
			</ul>
		<?php elseif(get_toplevel_page_name() !== "contact"): ?>
			<ul class="list">
				<li class="oc"><a href="<?php echo esc_url(home_url('/')); ?>oc/" class="fade">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/fixed_img01_pc.png" alt="オープンキャンパス" class="pc_navi">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/fixed_img01_sp.png" alt="オープンキャンパス" class="sp_navi">
				</a></li>
				<li class="doc"><a href="<?php echo esc_url(home_url('/')); ?>contact/pamphlet/" class="fade">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/fixed_img02_pc.png" alt="資料請求" class="pc_navi">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/fixed_img02_sp.png" alt="資料請求" class="sp_navi">
				</a></li>
			</ul>
		<?php endif; ?>
		</div>
	</div>
	<?php wp_footer(); ?>
	<script>
		$(".table-spscroll").each(function(){
			var ps = new PerfectScrollbar(this);
		});
		$('.acd-headline').on('click', function() {
			$(this).next('.acd-contents').slideToggle();
			$(this).toggleClass('open');
		});
	</script>
	<?php if(is_page("academics")): ?>
	<script>
		$(function(){
			$('.sec_list .ttl_line').matchHeight();
			$('.sec_list .list .txt').matchHeight();
		});
	</script>
	<?php endif; ?>
	<?php if(is_page("ofdc")): ?>
	<script>
		$(function(){
			/*-------------------------------------------
			acd
			-------------------------------------------*/
			$('.sec_ofdc .lead_more .btn').on('click', function() {
				$(this).parent('.lead_more').next('.lead_more_list').slideToggle();
				$(this).toggleClass('open');
			});
		});
	</script>
	<?php endif; ?>
	<?php if(is_page("competition")): ?>
	<script>
		$(function(){
			/*-------------------------------------------
			acd
			-------------------------------------------*/
			$('.sec_competition .lead_more .btn').on('click', function() {
				$(this).parent('.lead_more').next('.lead_more_list').slideToggle();
				$(this).toggleClass('open');
			});
		});
	</script>
	<?php endif; ?>
	<?php if(is_page("voice")): ?>
	<script>
		$(".btn_modal").colorbox({
			inline:true,
			width:"90%",
			maxWidth:"1080px",
			//maxHeight:"90%",
			opacity: 0.5,
			//fixed: true,
			//onOpen: function() {
			//	var ycoord = $(window).scrollTop();
			//	$('#colorbox').data('ycoord',ycoord);
			//	ycoord = ycoord * -1;
			//	$('body').css('position','fixed').css('left','0px').css('right','0px').css('top',ycoord + 'px');
			//},
			//onClosed: function() {
			//	$('body').css('position','').css('left','auto').css('right','auto').css('top','auto');
			//	$(window).scrollTop($('#colorbox').data('ycoord'));
			//}
		});
	</script>
	<?php endif; ?>
	<?php if(is_page(array("kimono", "kimono_s", "collab",  "business", "fashiondesign_s", "fasiontechnical_s", "merchandising", "guidance", "tuition", "foreignstudentguideline", "tuitionsupport"))): ?>
	<script>
		$(".spscroll").each(function(){
			var ps = new PerfectScrollbar(this);
		});
	</script>
	<?php endif; ?>
	<?php if(is_page("guideline")): ?>
	<script>
		$(function(){
			/*-------------------------------------------
			acd
			-------------------------------------------*/
			$('.sec_guideline .clm_ttl').on('click', function() {
				$(this).siblings('.type_detail').slideToggle();
				$(this).toggleClass('open');
			});
		});
	</script>
	<?php endif; ?>
	<?php if(is_page("faq")): ?>
	<script>
		$(function(){
			/*-------------------------------------------
			acd
			-------------------------------------------*/
			$('.sec_faq .clm_ttl').on('click', function() {
				$(this).siblings('.answer_box').slideToggle();
				$(this).toggleClass('open');
			});
		});
	</script>
	<?php endif; ?>
	<?php if(is_page(array("lookbookpv", "ofdc2020", "nakanosan2019contest")) || is_post_type_archive("column")): ?>
	<script>
		$(function(){
			$('.link_list .txt').matchHeight();
		});
	</script>
	<?php endif; ?>
	<?php if(is_post_type_archive("talk")): ?>
	<script>
		$(function(){
			$('.link_list .txt').matchHeight();
		});
	</script>
	<?php endif; ?>
</body>
</html>