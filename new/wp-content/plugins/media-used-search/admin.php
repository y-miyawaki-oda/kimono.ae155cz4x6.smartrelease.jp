<?php
	$mus = Media_Used_Search::get_instance();

	$selected_post_types = $mus->get_post_types_info();
	$selected_post_metas = $mus->get_post_metas_info();
?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>Media Used Search</h2>
	<div class="mus_wrap">
		<form action="<?php echo admin_url('admin.php?page=mus_admin'); ?>" method="post">
			<?php wp_nonce_field('mus_save', '_mussavenonce'); ?>

			<table class="mus_option_fields">
				<tbody>
					<tr class="mus_hr">
						<td colspan="2">
							<hr>
						</td>
					</tr>
					<tr class="mus_selected_post">
						<th>
							<label for="select_posts"><?php _e('Search post type selection', 'media-used-search');?></label>
						</th>
						<td>
							<?php 
								$type_checked_list = array();
								foreach( $selected_post_types as $key=>$post_type ) :
									$checked = !empty($post_type['checked']) && $post_type['checked'] ? 'checked="checked"' : '';
									if( $checked ) { $type_checked_list[] = $post_type['type']; }
							?>
								<input type="checkbox" name="select_posts[]" id="ptype_<?php echo $key; ?>" value="<?php echo $post_type['type']; ?>" <?php echo $checked; ?>><label for="ptype_<?php echo $key; ?>"><?php echo $post_type['type']; ?></label><br />
							<?php endforeach; ?>
						</td>
					</tr>
					<tr class="mus_hr">
						<td colspan="2">
							<hr>
						</td>
					</tr>
					<tr class="mus_selected_metas">
						<th>
							<label><?php _e('Search custom field selection', 'media-used-search');?></label>
						</th>
						<td>
							<?php 
								$change_check_type = '';
								foreach( $selected_post_metas as $key=>$post_meta ) :
									$display_class = !in_array( $post_meta['type'], $type_checked_list ) ? 'display_none disabled' : '' ;
									$is_check = !empty($post_meta['checked']) && $post_meta['checked'];
									$checked = $is_check ? 'checked="checked"' : '';
									$disabled = $is_check ? '' : 'disabled="true"';
							?>
								<?php if( $change_check_type && $change_check_type !== $post_meta['type'] ) : ?></span></span><?php endif; ?>
								<?php if( $change_check_type !== $post_meta['type'] ) : 
									$change_check_type = $post_meta['type']; 
								?>
									<span id="accordion" class="ac_box <?php echo $post_meta['type']; ?> <?php echo $display_class; ?>">
										<span class="type_title button"><?php echo $post_meta['type']; ?></span>
											<span class="check_box_list">
								<?php endif; ?>
												<input type="checkbox" name="select_metas[]" id="pmeta_<?php echo $key; ?>" value="<?php echo $post_meta['type']; ?>:<?php echo $post_meta['meta']; ?>" <?php echo $checked; ?>><label for="pmeta_<?php echo $key; ?>"><?php echo $post_meta['meta']; ?></label>&nbsp;：&nbsp;<input type="text" id="pmeta_<?php echo $key; ?>_label" class="select_meta_label" <?php echo $disabled;?> name="select_meta_label[]" value="<?php echo $post_meta['label']; ?>" placeholder="<?php _e('Label text', 'media-used-search');?>">
												<br />
							<?php endforeach; ?>
							<?php if( $change_check_type ) : ?></span></span><?php endif; ?>
						</td>
					</tr>
					<tr class="mus_hr">
						<td colspan="2">
							<p class="description">
								<?php _e('Custom field list associated with post type that you specified in the search post type selection is displayed.', 'media-used-search');?><br />
								<?php _e('Custom fields that you check here will be searched in the media list.', 'media-used-search');?><br />
								<?php _e('On the right side and put a check will be able to enter the label text. Label text is displayed as use custom field next to the post title in the media list.', 'media-used-search');?><br />
								<?php _e('Custom field name is displayed when it is not input to the label text.', 'media-used-search');?>
							</p>
							<hr>
						</td>
					</tr>
					<tr class="mus_omit_border">
						<th>
							<label for="title_omit_border"><?php _e('Post title omitted characters', 'media-used-search');?></label>
						</th>
						<td>
							<input class="regular-text" type="text" name="title_omit_border" id="title_omit_border" value=<?php echo (int)$mus->omit_border; ?> /><br />
						</td>
					</tr>
					<tr class="mus_hr">
						<td colspan="2">
							<p class="description">
								<?php _e('When displaying posts title media list and omitted in the "..." If the title characters exceeds the value specified here.', 'media-used-search');?><br />
								<?php _e('No omitted in the value of 0.', 'media-used-search');?>
							</p>
							<hr>
						</td>
					</tr>
				</tbody>
			</table>
			<p><input type="submit" name="submit" value="<?php _e("Save"); ?>" class="button-primary" /></p>
		</form>
	</div>
</div>
