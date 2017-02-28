<?php
/**
 * Security, checks if WordPress is running
 **/
if ( !function_exists( 'add_action' ) ) :
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
endif;



/**
*  Plugin
*/
final class Custom_Post_Type_Sponsor_Admin
{



	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt <me@horttcore.de>
	 **/
	public function __construct()
	{

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );

	} // END __construct



	/**
	 * Meta box
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt <me@horttcore.de>
	 **/
	public function add_meta_boxes()
	{

		add_meta_box( 'sponsor-meta', __( 'Information', 'custom-post-type-sponsors' ), array( $this, 'meta_box' ), 'sponsor' );

	} // END add_meta_boxes



	/**
	 * Sponsor meta box
	 *
	 * @access public
	 * @param obj $post Post object
	 * @return void
	 * @author Ralf Hortt <me@horttcore.de>
	 **/
	public function meta_box( $post )
	{

		$meta = get_post_meta( $post->ID, '_meta', TRUE );
		wp_nonce_field( 'save-sponsor-meta', 'sponsor-meta-nounce' );

		?>

		<table class="form-table">
			<tr>
				<th><label for="sponsor-url"><?php _e( 'URL', 'custom-post-type-sponsors' ); ?></label></th>
				<td><input type="text" class="regular-text" name="sponsor-url" id="sponsor-url" value="<?php if ( isset( $meta['url'] ) ) echo esc_url_raw( $meta['url'] ) ?>"></td>
			</tr>
		</table>

		<?php

	} // END meta_box



	/**
	 * Post updated messages
	 *
	 * @access public
	 * @param array $messages Update Messages
	 * @return array Update Messages
	 * @author Ralf Hortt <me@horttcore.de>
	 **/
	public function post_updated_messages( $messages )
	{

		$post             = get_post();
		$post_type        = 'sponsor';
		$post_type_object = get_post_type_object( $post_type );

		$messages[$post_type] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Sponsor updated.', 'custom-post-type-sponsors' ),
			2  => __( 'Custom field updated.' ),
			3  => __( 'Custom field deleted.' ),
			4  => __( 'Sponsor updated.', 'custom-post-type-sponsors' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Sponsor restored to revision from %s', 'custom-post-type-sponsors' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Sponsor published.', 'custom-post-type-sponsors' ),
			7  => __( 'Sponsor saved.', 'custom-post-type-sponsors' ),
			8  => __( 'Sponsor submitted.', 'custom-post-type-sponsors' ),
			9  => sprintf( __( 'Sponsor scheduled for: <strong>%1$s</strong>.', 'custom-post-type-sponsors' ), date_i18n( __( 'M j, Y @ G:i', 'custom-post-type-sponsors' ), strtotime( $post->post_date ) ) ),
			10 => __( 'Sponsor draft updated.', 'custom-post-type-sponsors' )
		);

		if ( !$post_type_object->publicly_queryable )
			return $messages;

		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View sponsor', 'custom-post-type-sponsors' ) );
		$messages[$post_type][1] .= $view_link;
		$messages[$post_type][6] .= $view_link;
		$messages[$post_type][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview sponsor', 'custom-post-type-sponsors' ) );
		$messages[$post_type][8]  .= $preview_link;
		$messages[$post_type][10] .= $preview_link;

		return $messages;

	} // END post_updated_messages



	/**
	 * Callback to save the sponsor meta data
	 *
	 * @access public
	 * @param int $post_id Post ID
	 * @return void
	 * @author Ralf Hortt <me@horttcore.de>
	 **/
	public function save_post( $post_id )
	{

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( !isset( $_POST['sponsor-meta-nounce'] ) || !wp_verify_nonce( $_POST['sponsor-meta-nounce'], 'save-sponsor-meta' ) )
			return;

		update_post_meta( $post_id, '_meta', array(
			'url' => esc_url_raw( $_POST['sponsor-url'] )
		) );

	} // END save_post



} // END final class Custom_Post_Type_Sponsor_Admin

new Custom_Post_Type_Sponsor_Admin();
