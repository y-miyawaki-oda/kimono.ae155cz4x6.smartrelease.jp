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

	replaceWidth = 767;

	var state = false;
	var scrollpos;
	$('.menu_trigger').click(function() {
		if(state == false) {
			scrollpos = $(window).scrollTop();
			$('body').addClass('fixed').css({'top': -scrollpos});
			$('header').addClass('menu_open');
			//$('.gnavi').fadeIn();
			state = true;
		} else {
			$('body').removeClass('fixed').css({'top': 0});
			window.scrollTo( 0 , scrollpos );
			$('header').removeClass('menu_open');
			//$('.gnavi').fadeOut();
			state = false;
		}
	});
	$('.gnavi a').click(function(){
		if(state == true) {
			$('.menu_trigger').trigger("click");
		}
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
		if(window.innerWidth > replaceWidth) {
			var position = target.offset().top;
		} else {
			var position = target.offset().top - hH;
		}
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


/*-------------------------------------------
 slider
 -------------------------------------------*/

$slider_4 = $(".slider_4");
$slider_4.each(function(){
	if($(this).hasClass('ranking')){
		var roop = false;
	} else {
		var roop = true;
	}
	var slick = $(this).slick({
		autoplay: false,
		speed: 600,
		dots: true,
		arrows: true,
		infinite: roop,
		//fade: true,
		draggable: false,
		slidesToShow: 4,
	    slidesToScroll: 1,
		pauseOnFocus: false,
		pauseOnHover: false,
		responsive: [{
			breakpoint: 990,
			settings: {
				slidesToShow: 3,
		        slidesToScroll: 1,
			}
			},{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
		        slidesToScroll: 1,
				centerPadding: '14%',
				centerMode: true,
			}
		}]
	});
});

var $slider = $('.slider_5');

var item = $slider.find('.item').length;
if (item <= 4) {
	var center = true;
} else {
	var center = false;
}

$slider.slick({
	autoplay: false,
	speed: 600,
	dots: false,
	arrows: true,
	infinite: true,
	//fade: true,
	draggable: false,
	slidesToShow: 5,
    slidesToScroll: 1,
	pauseOnFocus: false,
	pauseOnHover: false,
	centerMode: true,
	centerPadding: 0,
	variableWidth: center,
	//appendArrows: $('.slider_arw'),
	centerMode: true,
	responsive: [{
		breakpoint: 990,
		settings: {
			slidesToShow: 3,
	        slidesToScroll: 1,
		}
		},{
		breakpoint: 767,
		settings: {
			slidesToShow: 1,
	        slidesToScroll: 1,
			dots: true,
			arrows: true,
			centerPadding: '14%',
			variableWidth: false,
			centerMode: true,
		}
	}]
}).on("beforeChange", function(event, slick, currentSlide, nextSlide) {
	videoControl("pauseVideo");
});
$('.yt_video').click(function(){
	video = '<iframe src="'+ $(this).attr('youtube') +'" frameborder="0" class="yt_iframe" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>></iframe>';
	$(this).replaceWith(video);
});
function videoControl(action){
	$('.slider_5 .yt_iframe').each(function(){
		var $playerWindow = $(this)[0].contentWindow;
		$playerWindow.postMessage('{"event":"command","func":"'+action+'","args":""}', '*');
	});
}