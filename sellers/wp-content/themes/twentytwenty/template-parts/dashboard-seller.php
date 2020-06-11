<?php
/**
 * The template used for displaying page content
 *
 * @package    WordPress
 * @subpackage Custom_Theme
 * @since      3.4.6
 * @version    3.4.6
 */

$users = get_users( [ 'role__in' => [ 'sellers' ] ] ); ?>
<?php if ( ! empty( $users ) ): ?>
	<div class="content container">
		<div class="content__users">

			<?php
			get_template_part( 'template-parts/seller', 'menu' );
			if ( $_REQUEST['caller'] == 'self' ) {

				if ( ! empty( $_REQUEST['title'] ) || ! empty( $_REQUEST['content'] ) ) {
					$post_id = wp_insert_post( [
						'post_type'    => 'car',
						'post_status'  => 'publish',
						'post_title'   => $_REQUEST['title'],
						'post_content' => $_REQUEST['content'],
					] );

					if ( isset( $_REQUEST['price'] ) && ! empty( $_REQUEST['price'] ) ) {
						update_post_meta( $post_id, 'price', $_REQUEST['price'] );
					}

					if ( isset( $_REQUEST['brand'] ) && ! empty( $_REQUEST['brand'] ) ) {
						update_post_meta( $post_id, 'brand', $_REQUEST['brand'] );
					}

					if ( $_FILES["image"] ) {
						require_once( ABSPATH . 'wp-admin/includes/image.php' );
						require_once( ABSPATH . 'wp-admin/includes/file.php' );
						require_once( ABSPATH . 'wp-admin/includes/media.php' );

						$upload        = wp_upload_bits( $_FILES["image"]["name"], null, file_get_contents( $_FILES["image"]["tmp_name"] ) );
						$filename      = $upload['file'];
						$wp_filetype   = wp_check_filetype( $filename, null );
						$mime_type     = $wp_filetype['type'];
						$attachment    = [
							'post_mime_type' => $wp_filetype['type'],
							'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
							'post_name'      => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
							'post_content'   => '',
							'post_parent'    => $post_id,
							'post_excerpt'   => $thumb_credit,
							'post_status'    => 'inherit'
						];
						$attachment_id = wp_insert_attachment( $attachment, $filename, $post_id );
						if ( $attachment_id != 0 ) {
							$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
							wp_update_attachment_metadata( $attachment_id, $attach_data );
							update_post_meta( $post_id, '_thumbnail_id', $attachment_id );
						}
					}
					if ( $post_id ) {
						$msg = 'Record Inserted';
					} else {
						$msg = '';
					}

					foreach ( $_REQUEST as $var => $val ) {
						$$val = '';
					}
				}
			}
			?>
			<div class="content__form">
				<?php if ( isset( $msg ) ): ?>
					<h2><?php echo $msg; ?></h2>
				<?php endif; ?>
				<form method="post" enctype="multipart/form-data">
					<input type="text" name="title" placeholder="Title" required>
					<br>
					<textarea name="content"></textarea>
					<br>
					<input type="number" name="price" placeholder="Price" required>
					<br>
					<input type="text" name="brand" placeholder="Brands" required>
					<br>
					<input type="file" name="image">
					<br>
					<input type="hidden" name="caller" value="self">
					<button type="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>
<?php endif;
