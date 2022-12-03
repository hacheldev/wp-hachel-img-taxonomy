<?php

class HachelImgTaxonomy
{
	protected $taxonomy;

	public function __construct( $taxonomy )
	{
		$this->taxonomy = $taxonomy;

		add_action( 'create_' . $taxonomy, array( $this, 'save_taxonomy_images_meta' ) );
		add_action( 'edit_' . $taxonomy, array( $this, 'save_taxonomy_images_meta' ) );
		add_filter( 'manage_edit-' . $taxonomy . '_columns', array( $this, 'taxonomy_images_columns' ) );
		add_filter( 'manage_' . $taxonomy . '_custom_column', array( $this, 'taxonomy_images_custom_column' ), 10, 3 );
		add_action( $taxonomy . '_add_form_fields', array( $this, 'taxonomy_images_edit_meta' ) );
		add_action( $taxonomy . '_edit_form_fields', array( $this, 'taxonomy_images_edit_meta' ) );

	}

	public function save_taxonomy_images_meta( $term_id )
	{

		if ( !isset( $_POST['taxonomy_image'] ) )
		{
			return;
		}

		$image_url      = sanitize_text_field( $_POST['taxonomy_image'] );
		$existing_image = get_term_meta( $term_id, 'taxonomy_image', true );

		if ( $image_url !== $existing_image )
		{
			update_term_meta( $term_id, 'taxonomy_image', $image_url );
		}

	}

	public function taxonomy_images_columns( $columns )
	{
		$new_columns = array(
			'taxonomy_image' => __( 'Image', 'hachelimgtaxonomy' ),
		);

		// Merge the existing columns with the new column, excluding the "Name" column
		$columns = array_merge( array_slice( $columns, 0, 1 ), $new_columns, array_slice( $columns, 1 ) );

		return $columns;
	}

	public function taxonomy_images_custom_column( $content, $column_name, $term_id )
	{

		if ( $column_name !== 'taxonomy_image' )
		{
			return $content;
		}

		$image_url = get_term_meta( $term_id, 'taxonomy_image', true );

		if ( !empty( $image_url ) )
		{
			$content .= '<img src="' . esc_url( $image_url ) . '">';
		}

		return $content;
	}

	public function taxonomy_images_edit_meta( $term )
	{

		if ( isset( $term->term_id ) )
		{
			$term_id   = $term->term_id;
			$image_url = get_term_meta( $term_id, 'taxonomy_image', true );
		}

		if ( !isset( $image_url ) )
		{
			$image_url = '';
		}

		?>
<tr>
	<th scope="row"><label for="input_id">Image</label></th>
	<td>
		<div id="taxonomy_image_preview">
			<?php

		if ( !empty( $image_url ) )
		{
			?>
			<img src="<?php echo esc_url( $image_url ); ?>">
			<?php
};
		?>
		</div>
		<div>
			<button type="button" id="taxonomy_image_button"
				class="button button-secondary"><?php _e( 'Select Image', 'hachelimgtaxonomy' );?></button>
			<button type="button" id="taxonomy_image_clear"
				class="button button-secondary"><?php _e( 'Clear Image', 'hachelimgtaxonomy' );?></button>
			<p class="description">
				<?php _e( 'Select the image to display for this category.', 'hachelimgtaxonomy' );?></p>
		</div>
		<div>
			<input type="hidden" name="taxonomy_image" id="taxonomy_image"
				value="<?php echo esc_attr( $image_url ); ?>">
		</div>
	</td>
</tr>
<?php

	}

}