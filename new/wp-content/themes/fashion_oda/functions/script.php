<?php
	// CSS・スクリプトの読み込み
	function add_files() {
		global $post;

		if(is_page("oc")) {
			wp_enqueue_style('c-font01', 'https://fonts.googleapis.com/css2?family=Oswald:wght@400;600&display=swap', array(), '1.0', 'all');
			wp_enqueue_style('c-font02', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&display=swap', array('c-font01'), '1.0', 'all');
			wp_enqueue_style('c-slick', get_template_directory_uri().'/css/slick.css', array('c-font02'), '1.0', 'all');
			wp_enqueue_style('c-page', get_template_directory_uri().'/css/opencampus.css', array('c-slick'), '1.0', 'all');
		}
		elseif(is_page("vlog")) {
			wp_enqueue_style('c-font01', 'https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap', array(), '1.0', 'all');
			wp_enqueue_style('c-font02', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&display=swap', array('c-font01'), '1.0', 'all');
			wp_enqueue_style('c-slick', get_template_directory_uri().'/css/slick.css', array('c-font02'), '1.0', 'all');
			wp_enqueue_style('c-page', get_template_directory_uri().'/css/vlog.css', array('c-slick'), '1.0', 'all');
		}
		else {
			wp_enqueue_style('c-font01', 'https://fonts.googleapis.com/css2?family=Barlow+Condensed&display=swap', array(), '1.0', 'all');
			wp_enqueue_style('c-font02', 'https://fonts.googleapis.com/css2?family=Oswald:wght@400;600&display=swap', array('c-font01'), '1.0', 'all');
			wp_enqueue_style('c-font03', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&display=swap', array('c-font02'), '1.0', 'all');
			wp_enqueue_style('c-font04', 'https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap', array('c-font03'), '1.0', 'all');
			wp_enqueue_style('c-slick', get_template_directory_uri().'/css/slick.css', array('c-font04'), '1.0', 'all');
			if(is_page("voice")) {
				wp_enqueue_style('c-colorbox', get_template_directory_uri().'/css/colorbox.css', array('c-slick'), '1.0', 'all');
				wp_enqueue_style('c-common', get_template_directory_uri().'/css/common.css', array('c-colorbox'), '1.0', 'all');
			}
			elseif(is_page(array("kimono", "kimono_s", "collab", "business", "fashiondesign_s", "fasiontechnical_s", "merchandising", "guidance", "tuition", "foreignstudentguideline", "tuitionsupport"))) {
				wp_enqueue_style('c-perfect-scrollbar', get_template_directory_uri().'/css/perfect-scrollbar.css', array('c-slick'), '1.0', 'all');
				wp_enqueue_style('c-common', get_template_directory_uri().'/css/common.css', array('c-perfect-scrollbar'), '1.0', 'all');
			}
			else {
				wp_enqueue_style('c-common', get_template_directory_uri().'/css/common.css', array('c-slick'), '1.0', 'all');
			}
			wp_enqueue_style('c-parts', 'https://ae15982l62.smartrelease.jp/new/wp-content/themes/fashion_oda/css/parts.css', array('c-common'), '1.0', 'all');
			wp_enqueue_style('c-kimono', get_template_directory_uri().'/css/kimono.css', array('c-parts'), '1.0', 'all');

			if(is_page()) {
				if(have_rows("css")) {
					$cnt = 0;
					$before_css = "kimono";
					while(have_rows("css")) {
						the_row();
						wp_enqueue_style('c-page'.$cnt, get_template_directory_uri().'/css/'.esc_attr(get_sub_field("file")), array('c-'.$before_css), '1.0', 'all');
						$before_css = "page".$cnt;
						$cnt++;
					}
				}
				else {
					if(is_page("howto")) {
						wp_enqueue_style('c-page', get_template_directory_uri().'/css/howto.css', array('c-common'), '1.0', 'all');
					}
					else {
						wp_enqueue_style('c-page', get_template_directory_uri().'/css/'.get_toplevel_page_name().'.css', array('c-common'), '1.0', 'all');
					}
				}
			}
			elseif(is_post_type_archive(array("talk", "campusreport")) || is_singular(array("talk", "campusreport"))) {
				wp_enqueue_style('c-page', get_template_directory_uri().'/css/life.css', array('c-common'), '1.0', 'all');
			}
			elseif(is_post_type_archive() || is_single()) {
				$post_type = get_query_var('post_type');
				wp_enqueue_style('c-page', get_template_directory_uri().'/css/'.$post_type.'.css', array('c-common'), '1.0', 'all');
			}
			elseif(is_tax("cat_news")) {
				wp_enqueue_style('c-page', get_template_directory_uri().'/css/news.css', array('c-common'), '1.0', 'all');
			}
			elseif(is_tax("contestdate")) {
				wp_enqueue_style('c-page', get_template_directory_uri().'/css/coordinatecontest.css', array('c-common'), '1.0', 'all');
			}
		}

		// WordPress本体のjquery.jsを読み込まない
		if(!is_admin()) {
//			wp_deregister_script('jquery');
		}

		wp_enqueue_script('s-jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), '1.0', true);
		// wp_enqueue_script('s-jquery', '/wp-content/themes/fashion_oda/js/jquery.min.js', array(), '', true);
		if(is_page("oc")) {
			wp_enqueue_script('s-matchHeight', get_template_directory_uri().'/js/jquery.matchHeight-min.js', array('s-jquery'), '1.0', true);
			wp_enqueue_script('s-slick', get_template_directory_uri().'/js/slick.min.js', array('s-matchHeight'), '1.0', true);
			wp_enqueue_script('s-opencampus', get_template_directory_uri().'/js/opencampus.js', array('s-slick'), '1.0', true);
		}
		elseif(is_page("vlog")) {
			wp_enqueue_script('s-iframe_api', 'https://www.youtube.com/iframe_api', array('s-jquery'), '1.0', true);
			wp_enqueue_script('s-matchHeight', get_template_directory_uri().'/js/jquery.matchHeight-min.js', array('s-iframe_api'), '1.0', true);
			wp_enqueue_script('s-slick', get_template_directory_uri().'/js/slick.min.js', array('s-matchHeight'), '1.0', true);
			wp_enqueue_script('s-vlog', get_template_directory_uri().'/js/vlog.js', array('s-slick'), '1.0', true);
		}
		else {
			wp_enqueue_script('s-ofi', get_template_directory_uri().'/js/ofi.min.js', array('s-jquery'), '1.0', true);
			wp_enqueue_script('s-slick', get_template_directory_uri().'/js/slick.min.js', array('s-ofi'), '1.0', true);
			wp_enqueue_script('s-main', get_template_directory_uri().'/js/main.js', array('s-slick'), '1.0', true);

			if(is_page("voice")) {
				wp_enqueue_script('s-colorbox', get_template_directory_uri().'/js/jquery.colorbox-min.js', array('s-main'), '1.0', true);
			}
			elseif(is_page(array("kimono", "kimono_s", "collab", "business", "fashiondesign_s", "fasiontechnical_s", "merchandising", "guidance", "tuition", "foreignstudentguideline", "tuitionsupport"))) {
				wp_enqueue_script('s-perfect-scrollbar', get_template_directory_uri().'/js/perfect-scrollbar.min.js', array('s-main'), '1.0', true);
			}
			elseif(is_page(array("lookbookpv", "ofdc2020", "nakanosan2019contest")) || is_post_type_archive("column")) {
				wp_enqueue_script('s-matchHeight', get_template_directory_uri().'/js/jquery.matchHeight-min.js', array('s-main'), '1.0', true);
			}
			elseif(is_page(array("tour_entry", "pamphlet", "experience_entry"))) {
				wp_enqueue_script('s-autoKana', get_template_directory_uri().'/js/jquery.autoKana.js', array('s-main'), '1.0', true);
				wp_enqueue_script('s-contact', get_template_directory_uri().'/js/contact.js', array('s-autoKana'), '1.0', true);
				wp_enqueue_script('s-ajaxzip3', 'https://ajaxzip3.github.io/ajaxzip3.js', array('s-contact'), '1.0', true);
			}
		}
	}
	add_action('wp_enqueue_scripts', 'add_files');