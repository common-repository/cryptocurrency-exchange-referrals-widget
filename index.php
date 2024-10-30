<?php
/**
 * Plugin Name: CryptoCurrency Exchange Referrals Widget
 * Description: With this plugin you can add a widget to your Wordpress to display your referrals links promotions
 * Version: 1.2
 * Author: Tom Martin
 */


require_once( plugin_dir_path( __FILE__ ) . 'class.cr-widget.php' );

add_action( 'admin_menu', 'cc_e_r_w' );

add_action( 'wp_enqueue_scripts', 'cc_e_r_load', 60 );
add_action( 'wp_footer', 'cc_e_r_footer', 70 );

function cc_e_r_w() {
	add_menu_page( 'Referrals Menu', 'Referrals Options', 'manage_options', 'cc_e_r_w_start' ,'cc_e_r_w_start' );
	add_submenu_page( 'cc_e_r_w_start', 'Create new referral link', 'Create new referral link', 'manage_options', 'cc_e_r_w_create', 'cc_e_r_w_create');
	add_submenu_page( 'cc_e_r_w_start', 'Edit & List Referrals Links', 'Edit & List Referrals Links', 'manage_options', 'cc_e_r_w_menu_edit', 'cc_e_r_w_menu_edit');
	
	$creatives = get_option( 'wp_cc_e_r_creatives' );

	if ( !empty( $_POST['cc_e_r_w_form']) && $_POST['cc_e_r_w_form'] == 1 ) {
		if (check_admin_referer( 'cc_e_r_w_form' )) {
			$attachmentID = $_POST['ccew_img_attachment_id'];
			if (!empty($attachmentID)) {
				$imageHtml = wp_get_attachment_image(intval($attachmentID), 'medium');
				if (!empty($_POST['ccew_link'])) {
					if (function_exists('sanitize_title')) {
						$title = sanitize_title($_POST['ccew_title']);
					} else {
						$title = filter_var( $_POST['ccew_title'], FILTER_SANITIZE_STRING);
					}

					if (function_exists('esc_url_raw')) {
						$link = esc_url_raw($_POST['ccew_link']);
					} else {
						$link = filter_var( $_POST['ccew_link'], FILTER_SANITIZE_URL);	
					}
					$response = wp_remote_get( esc_url_raw( $link ) );

					if (function_exists('sanitize_textarea_field')) {
						$des = sanitize_textarea_field($_POST['ccew_description']);
					} else {
						$des = filter_var( $_POST['ccew_description'], FILTER_SANITIZE_STRING);
					}
					if ( ! is_wp_error( $response ) ) {
						$creatives[] = array( 'ccew_link' => $link,
							'ccew_title' => $title,
							'ccew_img_attachment_id' => $attachmentID,
							'ccew_image' => $imageHtml,
							'ccew_description' => $des
						);
						update_option( 'wp_cc_e_r_creatives', $creatives  );
						header('Location: admin.php?page=cc_e_r_w_create&modal=done');
						exit;
					}
				}
			}
		}
		header('Location: admin.php?page=cc_e_r_w_create&modal=error'); 
		exit;
	}

	if ( !empty( $_POST['cc_e_r_w_form_edit']) && $_POST['cc_e_r_w_form_edit'] == 1 ) {
		if (check_admin_referer( 'cc_e_r_w_form_edit' )) {
			$creatives = get_option( 'wp_cc_e_r_creatives' );
			if (!empty($_POST['check_list'])) {
				foreach ($_POST['check_list'] as $key) {
					unset($creatives[$key]);
				}
				$creatives = array_values($creatives);
				update_option( 'wp_cc_e_r_creatives', $creatives  );
				header('Location: admin.php?page=cc_e_r_w_menu_edit&alert-updated=true');
				exit;
			}
		}
	}
}

function cc_e_r_w_start() {
	include_once plugin_dir_path( __FILE__ ) . '/inc/admin/index.php';
}
function cc_e_r_w_create() {
	add_action( 'admin_footer', 'media_selector_print_scripts' );
	wp_enqueue_media();
	include_once plugin_dir_path( __FILE__ ) . '/inc/admin/create.php';
}

function cc_e_r_w_menu_edit() {
	$creatives = get_option( 'wp_cc_e_r_creatives' );
	include_once plugin_dir_path( __FILE__ ) . '/inc/admin/edit.php';
}


function media_selector_print_scripts() {

	$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

	?><script type='text/javascript'>

		jQuery( document ).ready( function( $ ) {

			jQuery('#upload_image_button').on('click', function( event ){

				event.preventDefault();

				// If the media frame already exists, reopen it.
			if(typeof media_frame != "undefined") {
				media_frame.open();
				return;
			}

			// Create a new media frame
			media_frame = wp.media({
				title: 'Select or Upload A File',   // Should pass via localized script variable for i18n/l10n
				button: { text: 'Use This' },       // Should pass via localized script variable for i18n/l10n
				multiple: false                     // Set to true to allow multiple files to be selected
			});

			// When the file is selected in the media frame...
			var url_field = jQuery( this ).siblings( '.upload_image_button' );
			media_frame.on( 'select', function() {

				// Get the details about the file the user uploaded/selected
				var attachment = media_frame.state().get('selection').first().toJSON();

				jQuery( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
				jQuery( '#ccew_img_attachment_id' ).val( attachment.id );
			});

			// Finally, open the modal on click
			media_frame.open();
			});
		});
	</script><?php
}


function cc_e_r_footer() {
	$creatives = base64_encode(json_encode(get_option( 'wp_cc_e_r_creatives' )));
	?>
	<script type="text/javascript">
	(function( $ ) {
		CCEReferrals.init({
			creatives: '<?php echo $creatives; ?>'
		});
	})(jQuery);
	</script>
	<?php
}

function cc_e_r_load() {
	wp_enqueue_script('cc_e_r_lib',plugins_url( '/assets/js/library.js', __FILE__ ), array('jquery'), null, 1 );
	if (!is_user_logged_in() ) {
		wp_enqueue_script('cc_e_r_rand',plugins_url( '/assets/js/main.js', __FILE__ ), array('jquery'), null, 1 );
	}
}


