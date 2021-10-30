<?php
if ( 'true' === $vertically ) {
	$vertically_class = 'vertical-item';
} else {
	$vertically_class = 'horizontal-item';
}
?>
<?php foreach ( $fields as $field_value => $field ) : ?>
	<label <?php echo MWF_Functions::generate_input_attribute( 'for', $field['id'] ); ?> class="fade">
		<input type="checkbox"
			name="<?php echo esc_attr( $field['name'] ); ?>"
			value="<?php echo esc_attr( $field_value ); ?>"
			<?php checked( in_array( $field_value, $value ), true, true ); ?>
			<?php echo MWF_Functions::generate_input_attribute( 'id', $field['id'] ); ?>
			<?php echo MWF_Functions::generate_input_attribute( 'class', $field['class'] ); ?>
		/>
		<span class="mwform-checkbox-field-text"><?php echo wp_kses_post( str_replace('(brsp)', '<br class="sp">', $field['label']) ); ?></span>
	</label>
<?php endforeach; ?>
