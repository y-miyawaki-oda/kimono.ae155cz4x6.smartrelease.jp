/**
 * 
 * @param {type} $
 * @returns {undefined}
 */

(function($){
    $(function(){
		$(".mus_selected_post :checkbox").click( function() {
			var value = $(this).attr('value');
			var target_meta = $("body").find(".mus_selected_metas").find("#accordion."+value );
			if( $(target_meta).hasClass('display_none') ) {
				$(target_meta).removeClass('display_none');
				$(target_meta).removeClass('disabled');
				$(target_meta).find('input[type=checkbox]').each( function( ind, val ){
					$(val).removeAttr('disabled');
					if( $(val).attr('checked') ) {
						$(val).parent().find('#'+ $(val).attr('id') +'_label').removeAttr('disabled');
					}
				});
			}
			else {
				$(target_meta).addClass('display_none');
				$(target_meta).addClass('disabled');
				$(target_meta).find('input').each( function( ind, val ){
					$(val).attr('disabled', 'disabled');
				});
			}
		})

		$("#accordion .type_title").on("click", function() {
			$(this).next().slideToggle();
		});
		$(".mus_selected_metas .check_box_list :checkbox").click( function() {
			if( $(this).is(":checked") ) {
				$(this).parent().children("#"+ $(this).attr("id") +"_label").attr('disabled', false);
			} else {
				$(this).parent().children("#"+ $(this).attr("id") +"_label").attr('disabled', true);
			}
		})
    });	
})(jQuery);
