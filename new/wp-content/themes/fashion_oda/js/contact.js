$(function(){
	$.fn.autoKana('#name01', '#kana01', {katakana:true});
	$.fn.autoKana('#name02', '#kana02', {katakana:true});

	$('.submit button[name="submitConfirm"]').prop('disabled', true);

	// テキストエリアの文字数
	$('textarea').keyup(function() {
		$(this).parent('div').next('.count').text($(this).val().length + '/1000文字');
	});

	validate();

	// フォーカスを外れたら
	$(document).on('blur', 'form .validate', function() {
		$(this).addClass('focus');
		if($(this).attr('name') === 'name01') {
			$('input[name="kana01"]').addClass('focus');
		}
		if($(this).attr('name') === 'name02') {
			$('input[name="kana02"]').addClass('focus');
		}
		validate();
	});

	// セレクトボックスとチェックボックスとラジオボタンの値が変わったら
	$('form select.validate, form input[type="checkbox"].validate, form input[type="radio"].validate').change(function() {
		$(this).addClass('focus');
		validate();
	});

	function validate() {
		var error_flg = false;
		$('.err_pos p.error').remove();
		var this_error_flg = Array();

		$('form .validate').each(function() {
			if($(this).is(':checkbox')) {
				if($('input[name="' + $(this).attr('name') + '"]:checked').val() != undefined) {
					$(this).addClass('focus');
				}

				if($(this).hasClass('focus')) {
					if($(this).hasClass('required')) {
						if($('input[name="' + $(this).attr('name') + '"]:checked').val() == undefined) {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">個人情報の取扱いをご確認ください。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
					}
				}
			}
			else if($(this).is(':radio')) {
				if($(this).hasClass('focus')) {
					if($(this).hasClass('required')) {
					}
				}
			}
			else {
				if($(this).val() !== '') {
					$(this).addClass('focus');
				}

				if($(this).hasClass('focus')) {
					if($(this).hasClass('katakana')) {
						if(!$(this).val().match(/^[ァ-ヶー]+$/)) {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">全角カタカナを入力してください。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
					}

					if($(this).hasClass('number')) {
						if(!$(this).val().match(/[0-9]+/)) {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">半角数字を入力してください。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
					}

					if($(this).hasClass('tel')) {
						if($(this).val().match(/-/)) {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">ハイフン（-）の入力は不要です。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
						else if(!$(this).val().match(/[0-9]+/)) {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">半角数字を入力してください。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
					}

					if($(this).hasClass('zip')) {
						if($(this).val().match(/-/)) {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">ハイフン（-）の入力は不要です。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
						else if(!$(this).val().match(/[0-9]+/)) {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">半角数字を入力してください。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
						else if(!$(this).val().match(/^[0-9]{7}$/)) {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">7桁で入力してください。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
					}

					if($(this).hasClass('email')) {
						if(!$(this).val().match(/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">有効なEメールアドレスを入力してください。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
					}

					if($(this).hasClass('required')) {
						if($.trim($(this).val()) === '') {
							$(this).parents('.err_pos').find('p.error').remove();
							$(this).parents('.err_pos').append('<p class="error">このフィールドは必須です。</p>');
							error_flg = true;
							this_error_flg[$(this).attr('name')] = true;
						}
					}

					if($(this).attr('name') === 'belongto') {
						if($(this).val().match(/^高校[1-4]{1}年生$/)) {
							$('input[name="school"]').addClass('focus validate required');
						}
						else {
							$('input[name="school"]').removeClass('validate');
							$('input[name="school"]').removeClass('required');
							$('input[name="school"]').removeClass('focus');
						}
					}
				}
			}

			$(this).parents('dd').prev('dt').children('.req_mark').remove();
			if($(this).attr('name') === 'name01' || $(this).attr('name') === 'name02') {
				if($(this).hasClass('focus') && !this_error_flg['name01'] && !this_error_flg['name02']) {
					$(this).parents('dd').prev('dt').append('<span class="req_mark"></span>');
				}
			}
			else if($(this).attr('name') === 'kana01' || $(this).attr('name') === 'kana02') {
				if($(this).hasClass('focus') && !this_error_flg['kana01'] && !this_error_flg['kana02']) {
					$(this).parents('dd').prev('dt').append('<span class="req_mark"></span>');
				}
			}
			else if($(this).attr('name') === 'zip' || $(this).attr('name') === 'addr') {
				if($(this).hasClass('focus') && !this_error_flg['zip'] && !this_error_flg['addr']) {
					$(this).parents('dd').prev('dt').append('<span class="req_mark"></span>');
				}
			}
			else {
				if($(this).hasClass('focus') && !this_error_flg[$(this).attr('name')]) {
					$(this).parents('dd').prev('dt').append('<span class="req_mark"></span>');
				}
			}
		});

		// 必須項目数
		var required_cnt = 0;
		$('form .required').each(function() {
			if($(this).is(':checkbox')) {
				if($('input[name="' + $(this).attr('name') + '"]:checked').val() == undefined) {
					required_cnt = required_cnt + 1;
				}
			}
			else if($(this).is(':radio')) {
			}
			else {
				if($(this).val() === '') {
					required_cnt = required_cnt + 1;
				}
			}
		});

		$('.fixedbnr .req .num').text(required_cnt);

		if(!error_flg && required_cnt == 0) {
			$('.submit button[name="submitConfirm"]').prop('disabled', false);
		}
		else {
			$('.submit button[name="submitConfirm"]').prop('disabled', true);
		}
	}
});
