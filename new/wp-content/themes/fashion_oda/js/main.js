/*-------------------------------------------
 transition対策
 -------------------------------------------*/
$(window).on('load', function(){
	$('body').removeClass('preload');
	$('.is_load_anime,.box_white_under').each(function(){
		var trigger = $(this);
		trigger.addClass('anime_active');
	});
});


$(function(){

	var replaceWidth = 767,
		menuWidth = 1259;

	function widthCheck() {
		var winWidth = window.innerWidth;
		var state = false;
		var scrollpos;
		if(winWidth <= menuWidth) {
			/*-------------------------------------------
			 sp menu
			 -------------------------------------------*/
			widthFlag = 'menu-sp';
			var naviWidth = $('.hamnavi').outerWidth();
			$('.hamnavi').css('right',-naviWidth);
			$('.menu_trigger').click(function() {
				if(state == false) {
					scrollpos = $(window).scrollTop();
					$('.container').addClass('fixed').css({'top': -scrollpos});
					$('header,.hamnavi').addClass('menu_open');
					$('.hamnavi').stop().animate({'right' : 0 }, 300);
					$('.hamnavi').css('display','block');
					window.scrollTo( 0 , 0 );
					state = true;
				} else {
					setTimeout(function() {
						$('.container').removeClass('fixed').css({'top': 0});
						window.scrollTo( 0 , scrollpos );
					}, 300);
					$('header,.hamnavi').removeClass('menu_open');
					$('.hamnavi').stop().animate({'right' : -naviWidth }, 300 ,function(){
						$('.hamnavi').css('display','none');
					});
					state = false;
				}
			});
/*			$('.hamnavi a').click(function(){
				if(state == true) {
					$('.menu_trigger').trigger("click");
				}
			});*/
		}
	}

	widthCheck();


	$('.hamnavi .acdbtn').on('click', function() {
		$(this).siblings('.acdmenu').slideToggle();
		$(this).toggleClass('open');
	});
	$('.hoverbtn').hover(function(){
			$(this).children('.hovermenu').stop().fadeIn('');
		},
		function(){
			$(this).children('.hovermenu').stop().fadeOut('');
	});

    var lastWW = window.innerWidth;
    $(window).on('resize', function() {
        var currentWW = window.innerWidth;
        //1259pxを跨ぐ移動
        if (lastWW <= menuWidth && menuWidth < currentWW) {
           window.location = window.location;
        } else if (currentWW <= menuWidth && menuWidth < lastWW) {
           window.location = window.location;
        }
        lastWW = currentWW;
    });

	/*-------------------------------------------
	 responsive image
	 -------------------------------------------*/
	var $setElem = $('.switch'),
	pcName = '_pc',
	spName = '_sp';

	$setElem.each(function(){
	    var $this = $(this);
	    function imgSize(){
	        if(window.innerWidth > replaceWidth) {
	            $this.attr('src',$this.attr('src').replace(spName,pcName)).css({visibility:'visible'});
	        } else {
	            $this.attr('src',$this.attr('src').replace(pcName,spName)).css({visibility:'visible'});
	        }
	    }
	    $(window).resize(function(){imgSize();});
	    imgSize();
    });

	/*-------------------------------------------
	scroll
	-------------------------------------------*/
	$('a[href^="#"]').not('.noscroll').click(function() {
		var hH = $('header').outerHeight();
		var speed = 300;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top - hH;
		$('body,html').animate({scrollTop:position}, speed, 'swing');
		return false;
	});

	/*-------------------------------------------
	 ofject
	 -------------------------------------------*/
	if($('.cut_img').length){
		objectFitImages('img.cut_img');
	}
	if($('.cut_thumb').length){
		objectFitImages('.cut_thumb img:first-child');
	}
	if($('.image-height').length){
		objectFitImages('.image-height img:first-child');
	}

	/*-------------------------------------------
	 slider
	 -------------------------------------------*/
	if($('.sec_slider').length){
		$('.sec_slider .slider').slick({
			centerMode: true,
			centerPadding: '500px',
			dots: true,
			autoplay: true,
			autoplaySpeed: 2500,
			speed: 1000,
			infinite: true,
			variableWidth: true,
			arrows: false,
			responsive: [{
				breakpoint: 820,
				settings: {
					centerPadding: '15%',
					variableWidth: false,
				}
				},{
				breakpoint: 767,
				settings: {
					centerPadding: '8%',
					variableWidth: false,
				}
			}]
		});
	}
	if($('.sec_oc2').length){
		$('.sec_oc2 .slider').slick({
			autoplay: false,
			speed: 0,
			dots: false,
			arrows: true,
			infinite: false,
			fade: true,
			draggable: false,
			pauseOnFocus: false,
			pauseOnHover: false,
			appendArrows: $('.calendar_arw'),
			adaptiveHeight: true,
		});
	}

	/*-------------------------------------------
	 fixbnr
	 -------------------------------------------*/
	var countbnr=$('.fixed_countbnr');
	countbnr.hide();
	$(window).scroll(function(){
		if($(this).scrollTop() > 200){
			countbnr.fadeIn(800);
		}else{
			countbnr.fadeOut(800);
		}
	});

	var linkbnr=$('.fixed_linkbnr');
	linkbnr.hide();
	if($('.sec_course').length && $('.fixed_linkbnr').length){
		var linkbnr_top = $('.sec_course').offset().top- $(window).height();
		$(window).scroll(function(){
			if($(window).scrollTop() > linkbnr_top){
				linkbnr.fadeIn(800);
			}else{
				linkbnr.fadeOut(800);
			}
		});
	} else if(! $('.sec_course').length && $('.fixed_linkbnr').length){
		$(window).scroll(function(){
			if($(this).scrollTop() > 200){
				linkbnr.fadeIn(800);
			}else{
				linkbnr.fadeOut(800);
			}
		});
	}

	/*-------------------------------------------
	アニメーション
	-------------------------------------------*/
	$(window).scroll(function(){
		$('.is_anime').each(function(){
			var trigger = $(this),
				top = trigger.offset().top,
				position = top - $(window).height(),
				position_bottom = top + trigger.height();
			if($(window).scrollTop() > position && $(window).scrollTop() < position_bottom){
				trigger.addClass('anime_active');
			//}else{
			//	trigger.removeClass('anime_active');
			}
		});
	})


	/*-------------------------------------------
	セレクト
	-------------------------------------------*/
	$('.select_box .btn').on('click', function() {
		$(this).siblings('.children').slideToggle('fast');
		$(this).toggleClass('open');
	});
	$('.select_box li').click(function(){
		var newText = $(this).html();
		var val = $(this).data('value');
		location.href = val;
//		$(this).parents('.select_box').find('.select_input').val(val);
//		$(this).parents('.select_box').find('.txt').text(newText);
//		$(this).parents('.select_box').find('.btn').trigger("click");
	});

	$('.select_box li').each(function(){
		if($(this).data('value') === $(this).parent('ul.children').next('input').val()) {
			$(this).parents('.select_box').find('.txt').text($(this).text());
		}
	});
});

/*
* css swicher
*/
function css_browser_selector(u){
	var ua=u.toLowerCase(),
	is=function(t){return ua.indexOf(t)>-1},
	e='edge',g='gecko',w='webkit',s='safari',o='opera',m='mobile',
	h=document.documentElement,
	b=[
		( !(/opera|webtv/i.test(ua)) && /msie\s(\d)/.test(ua))? ('ie ie'+RegExp.$1) :
			!(/opera|webtv/i.test(ua)) && is('trident') && /rv:(\d+)/.test(ua)? ('ie ie'+RegExp.$1) :
			is('edge/')? e:
			is('firefox/2')?g+' ff2':
			is('firefox/3.5')? g+' ff3 ff3_5' :
			is('firefox/3.6')?g+' ff3 ff3_6':is('firefox/3')? g+' ff3' :
			is('gecko/')?g:
			is('opera')? o+(/version\/(\d+)/.test(ua)? ' '+o+RegExp.$1 :
			(/opera(\s|\/)(\d+)/.test(ua)?' '+o+RegExp.$2:'')) :
			is('konqueror')? 'konqueror' :
			is('blackberry')?m+' blackberry' :
			is('android')?m+' android' :
			is('chrome')?w+' chrome' :
			is('iron')?w+' iron' :
			is('applewebkit/')? w+' '+s+(/version\/(\d+)/.test(ua)? ' '+s+RegExp.$1 : '') :
			is('mozilla/')? g:
			'',
			is('j2me')?m+' j2me':
			is('iphone')?m+' iphone':
			is('ipod')?m+' ipod':
			is('ipad')?m+' ipad':
			is('mac')?'mac':
			is('darwin')?'mac':
			is('webtv')?'webtv':
			is('win')? 'win'+(is('windows nt 6.0')?' vista':''):
			is('freebsd')?'freebsd':
			(is('x11')||is('linux'))?'linux':
			'',
			'js'];
	c = b.join(' ');
	h.className += ' '+c;
	return c;
};
css_browser_selector(navigator.userAgent);