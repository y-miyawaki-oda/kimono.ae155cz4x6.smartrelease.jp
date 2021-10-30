/*-------------------------------------------
 transition対策
 -------------------------------------------*/
$(window).on('load', function(){
	$('body').removeClass('preload');
	$('.is_load_anime').each(function(){
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
			$('.hamnavi a').click(function(){
				if(state == true) {
					$('.hamnavi').css('display','none');
					$('.container').removeClass('fixed').css({'top': 0});
					window.scrollTo( 0 , scrollpos );
					$('header,.hamnavi').removeClass('menu_open');
					$('.hamnavi').stop().animate({'right' : -naviWidth }, 300);
					state = false;
				}
			});
		}
	}

	widthCheck();

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
	 slider
	 -------------------------------------------*/
	$('.sec_schedule .slider').slick({
		autoplay: false,
		speed: 0,
		dots: false,
		arrows: true,
		infinite: false,
		//fade: true,
		draggable: false,
		slidesToShow: 2,
        slidesToScroll: 2,
		pauseOnFocus: false,
		pauseOnHover: false,
		appendArrows: $('.calendar_arw'),
		adaptiveHeight: true,
		responsive: [{
			breakpoint: 990,
			settings: {
				slidesToShow: 1,
		        slidesToScroll: 1,
			}
			},{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
		        slidesToScroll: 1,
			}
		}]
	});
	$('.sec_flow .slider').slick({
		centerMode: true,
		centerPadding: '160px',
		autoplay: false,
		speed: 1200,
		dots: true,
		arrows: true,
		infinite: false,
		variableWidth: true,
		//infinite: false,
		//fade: true,
		draggable: true,
		pauseOnFocus: false,
		pauseOnHover: false,
		appendArrows: $('.flow_arw'),
		responsive: [{
			breakpoint: 960,
			settings: {
				centerPadding: '7%',
				variableWidth: false,
				//arrows: false,
			}
			},{
			breakpoint: 767,
			settings: {
				centerPadding: '7%',
				variableWidth: false,
				//arrows: false,
			}
		}]
	});


	/*-------------------------------------------
	scroll
	-------------------------------------------*/
	$('a[href^="#"]').not('.noscroll').click(function() {
		try {
			if($($(this).attr('href')).hasClass('is-hidden')){
				$('.more_schedule').trigger("click");
			}
		}
		catch (e) {
			console.log(e);
		}
		var hH = $('header').outerHeight();
		var speed = 300;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top - hH;
		$('body,html').animate({scrollTop:position}, speed, 'swing');
		return false;
	});


	/*-------------------------------------------
	 fixbnr
	 -------------------------------------------*/
	var fixbnr=$('.fixedbnr');
	fixbnr.hide();
	$(window).scroll(function(){
		if($(this).scrollTop() > 300){
			fixbnr.fadeIn();
		}else{
			fixbnr.fadeOut();
		}
	});

	/*-------------------------------------------
	アニメーション
	-------------------------------------------*/
	$(window).on('load scroll', function(){
		$('.is_anime').each(function(){
			var trigger = $(this),
				top = trigger.offset().top,
				position = top - $(window).height() / 1.5,
				position_bottom = top + trigger.height();
			if($(window).scrollTop() > position && $(window).scrollTop() < position_bottom){
				trigger.addClass('anime_active');
			//}else{
			//	trigger.removeClass('anime_active');
			}
		});
	})

	/*-------------------------------------------
	matchHeight
	-------------------------------------------*/
	$('.sec_mv .oc .inner').matchHeight();
	$('.sec_mv .oc .ttl').matchHeight();
	$('.sec_about .menu .top .ttl').matchHeight();
	$('.sec_schedule .oc li .head').matchHeight();
	$('.sec_schedule .oc li .cnt').matchHeight();
	$('.sec_other .list .txt').matchHeight();
	$('.sec_flow .box .txt').matchHeight();


	/*-------------------------------------------
	more
	-------------------------------------------*/
	var show = 4; //最初に表示する件数
	var contents = '.sec_schedule .oc li'; // 対象のlist
	$(contents + ':nth-child(n + ' + (show + 1) + ')').addClass('is-hidden');
	if ($(contents + '.is-hidden').length == 0) {
		$('.more_schedule').hide();
	}
	$('.more_schedule').on('click', function () {
		if( $('.more_schedule').hasClass('open') ) {
			$(contents + ':nth-child(n + ' + (show + 1) + ')').addClass('is-hidden');
			if ($(contents + '.is-hidden').length == 0) {
				$('.more_schedule').hide();
			}
			$(this).removeClass('open');
			$(this).find('.change').text('もっと見る');
		} else {
			$(contents + '.is-hidden').removeClass('is-hidden');
			$(this).addClass('open');
			$(this).find('.change').text('日程を閉じる');
		}
	});

	$('.more_faq').on('click', function() {
		if( $(this).hasClass('open') ) {
			$(this).find('.change').text('質問を閉じる');
			$(this).removeClass('open');
			$(this).siblings('.is-hidden').addClass('show');
		} else {
			$(this).find('.change').text('質問をもっと見る');
			$(this).addClass('open');
			$(this).siblings('.is-hidden').removeClass('show');
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